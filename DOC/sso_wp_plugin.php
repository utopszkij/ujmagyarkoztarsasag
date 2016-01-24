<?php
	/*
		Plugin Name: Edemo SSO authentication
		Plugin URI: 
		Description: Allows you connect to the Edemo SSO server, and autenticate the users, who acting on your site
		Version: 0.01
		Author: Claymanus
		Author URI:
		
		
		
		a plugins/slogin_auth alatt kell egy új alkönyvtárat csinálni
		a megfelelõ tartalommal
		
		az #__extensoins táblába kell egy új rekordot felvenni
		
		a modules/mod_slogin/tmpl/compact/...css -be .ssoslogin felvétele
		
		Úgy tünik ezzel a dolog meg van oldva.
		
		
		
	*/

### Version
define( 'EDEMO_SSO_VERSION', 0.01 );

class eDemoSSO {
 
	const    SSO_DOMAIN = 'sso.edemokraciagep.org';
	const SSO_TOKEN_URI = 'sso.edemokraciagep.org/v1/oauth2/token';
	const  SSO_AUTH_URI = 'sso.edemokraciagep.org/v1/oauth2/auth';
	const  SSO_USER_URI = 'sso.edemokraciagep.org/v1/users/me';
	const     QUERY_VAR = 'sso_callback';
	const     USER_ROLE = 'eDemo_SSO_role';
	const  CALLBACK_URI = 'sso_callback';
	const      USERMETA = 'eDemoSSO_ID';
	const  WP_REDIR_VAR = 'wp_redirect';

	public $callbackURL;
	public $error_message;
	public $auth_message;
	private $appkey;
	private $secret;
	private $sslverify;
	
	function __construct() {

		add_option('eDemoSSO_appkey', '', '', 'yes');
		add_option('eDemoSSO_secret', '', '', 'yes');
		add_option('eDemoSSO_appname', '', '', 'yes');
		add_option('eDemoSSO_sslverify', '', '', 'yes');
    
		$this->callbackURL = get_site_url( "", "", "https" )."/".self::CALLBACK_URI;
		$this->appkey = get_option('eDemoSSO_appkey');
		$this->secret = get_option('eDemoSSO_secret');
		$this->sslverify = get_option('eDemoSSO_sslverify');
        
		
		### Adding sso callback function to rewrite rules
		add_action( 'generate_rewrite_rules', array( $this, 'add_rewrite_rules' ) );

		add_filter( 'query_vars', array( $this, 'query_vars' ) );
		add_filter( 'the_content', array( $this, 'the_content_filter' ) );

		### Plugin activation hooks
		register_activation_hook( __FILE__, array( $this, 'plugin_activation' ) );
		register_deactivation_hook( __FILE__, array( $this, 'plugin_deactivation' ) );
		
		
		add_action( 'parse_request', array( $this, 'parse_request' ) );
		add_shortcode('SSOsignit', array( $this, 'sign_it' ) );	
		
		### Adding admin page
		add_action('admin_menu', array( $this, 'addAdminPage' ) );

		### Create Text Domain For Translations
		add_action( 'plugins_loaded', array( $this, 'textdomain' ) );
	}

	function textdomain() {
		load_plugin_textdomain( 'eDemoSSO' );
	}
	
	//
	// Options/admin panel
	//

	// Add page to options menu.
	function addAdminPage() 
	{
	  // Add a new submenu under Options:
		add_options_page('eDemo SSO Options', 'eDemo SSO', 'manage_options', 'edemosso', array( $this, 'displayAdminPage'));
	}

	// Display the admin page.
	function displayAdminPage() {
		
		if (isset($_POST['edemosso_update'])) {
//			check_admin_referer();    // EZT MAJD MEG KELLENE NÉZNI !!!!!

			// Update options 
			$this->sslverify = isset($_POST['EdemoSSO_sslverify']);
			$this->appkey    = $_POST['EdemoSSO_appkey'];
			$this->secret    = $_POST['EdemoSSO_secret'];
			$this->appname   = $_POST['EdemoSSO_appname'];
			update_option( 'eDemoSSO_appkey'   , $this->appkey   );
			update_option( 'eDemoSSO_secret'   , $this->secret   );
			update_option( 'eDemoSSO_appname'  , $this->appname  );
			update_option( 'eDemoSSO_sslverify', $this->sslverify);

			// echo message updated
			echo "<div class='updated fade'><p>Options updated.</p></div>";
		}		
		?>
		<div class="wrap">

			<h2><?= __( 'eDemo SSO Authentication Options' ) ?></h2>
			<form method="post">
				<fieldset class='options'>
					<table class="editform" cellspacing="2" cellpadding="5" width="100%">
						<tr>
							<th width="30%" valign="top" style="padding-top: 10px;">
								<label for="EdemoSSO_appname"><?= __( 'Application name:' ) ?></label>
							</th>
							<td>
								<input type='text' size='16' maxlength='30' name='EdemoSSO_appname' id='EdemoSSO_appname' value='<?= get_option('eDemoSSO_appname'); ?>' />
								<?= __( 'Used for registering the application' ) ?>
							</td>
						</tr>
						<tr>
							<th width="30%" valign="top" style="padding-top: 10px;">
								<label for="EdemoSSO_appkey"><?= __( 'Application key:' ) ?></label>
							</th>
							<td>
								<input type='text' size='40' maxlength='40' name='EdemoSSO_appkey' id='EdemoSSO_appkey' value='<?= $this->appkey; ?>' />
								<?= __( 'Application key.' ) ?>
							</td>
						</tr>
						<tr>
							<th width="30%" valign="top" style="padding-top: 10px;">
								<label for="EdemoSSO_secret"><?= __( 'Application secret:' ) ?></label>
							</th>
							<td>
								<input type='text' size='40' maxlength='40' name='EdemoSSO_secret' id='EdemoSSO_secret' value='<?= $this->secret; ?>' />
								<?= __( 'Application secret.' ) ?>
							</td>
						</tr>
						<tr>
							<th width="30%" valign="top" style="padding-top: 10px;">
								<label for="EdemoSSO_sslverify"><?= __( 'Allow verify ssl certificates:' ) ?></label>
							</th>
							<td>
								<input type='checkbox' name='EdemoSSO_sslverify' id='EdemoSSO_sslverify' <?= (($this->sslverify)?'checked':''); ?> />
								<?= __( "If this set, the ssl certificates will be verified during the communication with sso server. Uncheck is recommended if your site has no cert, or the issuer isn't validated." ) ?>
							</td>
						</tr>
						<tr>
							<th>
								<label for="eDemoSSO_callbackURI"><?= __( 'eDemo_SSO callback URL:' ) ?></label>
							</th>
							<td>
								<?= $this->callbackURL ?>
							</td>
						</tr>
						<tr>
							<td colspan="2">
							<p class="submit"><input type='submit' name='edemosso_update' value='<?= __( 'Update Options' ) ?>' /></p>
							</td>
						</tr>
					</table>
				</fieldset>
			</form>
		</div>
		<?php
	}
	
	//
	// Actual functionality
	//
	
  // shortcode for 'sign it' function
 	// [SSOsignit text="Sign it if you agree with" thanks="Thank you" signed="Has been signed"]
	
  function sign_it( $atts )	{
    $a = shortcode_atts( array(
        'text'   => 'Sign it if you agree with',
        'thanks' => 'Thanks for your sign',
        'signed' => 'You signed yet, thanks',
          ), $atts );

	if ( !is_user_logged_in() ) {
		return '<a href="https://'.self::SSO_AUTH_URI.'?response_type=code&client_id='.$this->appkey.'&redirect_uri='.urlencode($this->callbackURL.'?wp_redirect='.$_SERVER['REQUEST_URI'].'&signed=true').'"><div class="btn">'.$a['text'].'</div></a>';
    }
    elseif ( isset( $_GET['signed'] ) ) {
      if ($this->is_signed()) return '<div class="button SSO_signed">'.$a['signed'].'</div>';
      else {
        $this->do_sign_it();
        return '<div class="button SSO_signed">'.$a['thanks'].'</div>';
      }
    } 
    return '<a href="'.$_SERVER['REQUEST_URI'].'?signed=true"><div class="btn">'.$a['text'].'</div></a>';
	}

  // saving the signing event in database
  function do_sign_it(){}
  
  // checking if is it signed yet
  function is_signed(){ 
    return true ;
  }
  
	//
	// Hooks
	//


	function add_rewrite_rules() {
		global $wp_rewrite;
		$rules = array( self::CALLBACK_URI.'(.+?)$' => 'index.php$matches[1]&'.self::CALLBACK_URI.'=true',
                    self::CALLBACK_URI.'$'      => 'index.php?'.self::CALLBACK_URI.'=true&'  );
		$wp_rewrite->rules = $rules + (array)$wp_rewrite->rules;
	}

	function plugin_activation() {

		// Adding new user role "eDemo_SSO_role" only with "read" capability 
	  
		add_role( self::USER_ROLE, 'eDemo_SSO user', array( 'read' => true, 'level_0' => true ) );

		// Adding new rewrite rules     
    
		global $wp_rewrite;
		$wp_rewrite->flush_rules(); // force call to generate_rewrite_rules()
	}
	
	function plugin_deactivation() {
	
		// Removing SSO rewrite rules  
		remove_action( 'generate_rewrite_rules', array( $this, 'rewrite_rules' ) );
		global $wp_rewrite;
		$wp_rewrite->flush_rules(); // force call to generate_rewrite_rules()
	}

  /**
  * Úgy tünik ezt a rutin a wordpress behivja minden task aktivizálódáskor 
  */  
  function parse_request( &$wp )
  {
    if ( array_key_exists( self::QUERY_VAR, $wp->query_vars ) ) {
         if (isset($_GET[self::WP_REDIR_VAR])) {
          $_SERVER['REQUEST_URI']="/". $_GET[self::WP_REDIR_VAR]."?SSO_code=".$_GET['code'].(isset($_GET['signed'])?'&signed=true':'') ;

          error_log($_GET[self::WP_REDIR_VAR]);
          
          $wp->parse_request();
        }
    }
    if ( array_key_exists( 'SSO_code', $_GET) ) {
        $this->auth_message=$this->callback_process();
     }
    return;
  }	
  
  //
  // displaying auth error message in the top of content
  //
  
  // we will found out what is the best way to display this (pop-up or anithing else) 
  
  function the_content_filter( $content ) {
    echo "<div class='updated '><p>".$this->auth_message."</p></div>";
    return $content;
  }

  //
  // our query var filter adds the SSO query var to the query. Used for identifying the call of the callback url.
  //

	function query_vars( $public_query_vars ) { 
		array_push( $public_query_vars, self::QUERY_VAR );
		return $public_query_vars;
	}
  
  //
  // Commumication with oauth server
  //

  // The main callback function controlls the whole authentication process
   
  function callback_process() {

    if (isset($_GET['SSO_code'])) {
      if ( $token = $this->requestToken( $_GET['SSO_code'] ) ) {
        if ( $user_data = $this->requestUserData( $token['access_token'] ) ) {
          if ( $ssoUser=get_users(array('meta_key' => self::USERMETA, 'meta_value' => $user_data['userid'])) ) {
           $user=$ssoUser[0]->data;
          }
          else {
            $user=$this->registerUser($user_data) ;
          }
          if ($user) {
            $this->signinUser($user);
            $this->error_message= __('You are signed in');
          }
        }
      }
    }
    else $this->error_message = __('Invalid page request - missing code');
    return $this->error_message;
  }
  
  // token requesting phase
  
  function requestToken( $code ) {
  
    $response = wp_remote_post( 'https://'.self::SSO_TOKEN_URI, array(
                 'method' => 'POST',
                'timeout' => 30,
            'redirection' => 10,
	          'httpversion' => '1.0',
	             'blocking' => true,
	              'headers' => array(),
	                 'body' => array( 'code' => $code,
				                      'grant_type' => 'authorization_code',
				                       'client_id' => $this->appkey,
			                     'client_secret' => $this->secret,
			                      'redirect_uri' => $this->callbackURL ),
	              'cookies' => array(),
	            'sslverify' => $this->sslverify ) );

    if ( is_wp_error( $response )  ) {
      $this->error_message = $response->get_error_message();
      return false;
    }
    else {
      $body = json_decode( $response['body'], true );
      if (!empty($body)){
        if ( isset( $body['error'] ) ) {
          $this->error_message = __("The SSO-server's response: "). $body['error'];
          return false;
        }
        else return $body;
      }
        $this->error_message = __("Unexpected response cames from SSO Server");
        return false;
    }
  }
  
  // user data requesting phase, called if we have a valid token
  
  function requestUserData( $access_token ) {
  
    $response = wp_remote_get( 'https://'.self::SSO_USER_URI, array(
                    'timeout' => 30,
                'redirection' => 10,
                'httpversion' => '1.0',
                   'blocking' => true,
                    'headers' => array( 'Authorization' => 'Bearer '.$access_token ),
                    'cookies' => array(),
                  'sslverify' => $this->sslverify ) );
    if ( is_wp_error( $response ) ) {
      $this->error_message = $response->get_error_message();
      return false;
    }
    elseif ( isset( $response['body'] ) ) {
        $body = json_decode( $response['body'], true );
        if (!empty($body)) return $body;
    }
	$this->error_message=__("Invalid response has been came from SSO server");
    return false;
  }
  
  //
  //  Wordpress User function
  //
  
  //  Registering the new user
  
  function registerUser($user_data){
    // updating if user already exist with this email 
    // this function will be removed due security reason !!!
     if ( $ssoUser=get_users(array('search' => $user_data['email'])) ){
        $user=$ssoUser[0]->data;
        update_user_meta( $user->ID, self::USERMETA, $user_data['userid'] );
     }
     // registering new user
     else {
        $display_name=explode('@',$user_data['email']);
        $user_id = wp_insert_user( array( 'user_login' => $user_data['userid'],
                                          'user_email' => $user_data['email'],
                                          'display_name' => $display_name[0],
                                          'role' => self::USER_ROLE ));
      //On success
        if( !is_wp_error($user_id) ) update_user_meta( $user_id, self::USERMETA, $user_data['userid'] );
        else $this->error_message=$user_id->get_error_message();     
     }
  }
  
  //  Logging in the user
  
  function signinUser($user) {
    wp_set_current_user( $user->ID, $user->user_login );
    wp_set_auth_cookie( $user->ID );
    do_action( 'wp_login', $user->user_login );
  }
   
} // end of class declaration
	
if (!isset($eDemoSSO)) { $eDemoSSO = new eDemoSSO(); } 

?>