<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.protostar
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * 
 * URL param: fb=y  facebook auto login hs-user modul segitségével
 * URL param google=y  google auto login hs-user modul segitségével   
 */

defined('_JEXEC') or die;

// Getting params from template
$params = JFactory::getApplication()->getTemplate(true)->params;


/*  2014.11.18 sajnos nem mükszik :(
include 'Facebook\FacebookSession.php';
FacebookSession::setDefaultApplication('800487800008440','d54913bbce42d9b34c965359f756ada5');
// Use one of the helper classes to get a FacebookSession object.
//   FacebookRedirectLoginHelper
//   FacebookCanvasLoginHelper
//   FacebookJavaScriptLoginHelper
// or create a FacebookSession with a valid access token:
$session = new FacebookSession('access-token-here');
$fbUser = '???';
$fbStatus = '';
// Get the GraphUser object for the current user:
try {
  $me = (new FacebookRequest(
    $session, 'GET', '/me'
  ))->execute()->getGraphObject(GraphUser::className());
  $fbUser = $me->getName();
  $fbStatus = 'OK';
} catch (FacebookRequestException $e) {
  // The Graph API returned an error
  $fbStatus = 'fb error 1';
} catch (\Exception $e) {
  // Some other error occurred
  $fbStatus = 'other error 1';
}
*/

$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$this->language = $doc->language;
$this->direction = $doc->direction;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->getCfg('sitename');

if($task == "edit" || $layout == "form" )
{
	$fullWidth = 1;
}
else
{
	$fullWidth = 0;
}

// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');
$doc->addScript('templates/' .$this->template. '/js/template.js');

// Add Stylesheets
$doc->addStyleSheet('templates/'.$this->template.'/css/template.css');

// Load optional RTL Bootstrap CSS
JHtml::_('bootstrap.loadCss', false, $this->direction);

// Add current user information
$user = JFactory::getUser();

// Adjusting content width
if ($this->countModules('position-7') && $this->countModules('position-8'))
{
	$span = "span6";
}
elseif ($this->countModules('position-7') && !$this->countModules('position-8'))
{
	$span = "span9";
}
elseif (!$this->countModules('position-7') && $this->countModules('position-8'))
{
	$span = "span9";
}
else
{
	$span = "span12";
}

// Logo file or site title param
if ($this->params->get('logoFile'))
{
	$logo = '<img src="'. JUri::root() . $this->params->get('logoFile') .'" alt="'. $sitename .'" />';
}
elseif ($this->params->get('sitetitle'))
{
	$logo = '<span class="site-title" title="'. $sitename .'">'. htmlspecialchars($this->params->get('sitetitle')) .'</span>';
}
else
{
	$logo = '<span class="site-title" title="'. $sitename .'">'. $sitename .'</span>';
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<jdoc:include type="head" />
	<?php
	// Use of Google Font
	if ($this->params->get('googleFont'))
	{
	?>
		<link href='//fonts.googleapis.com/css?family=<?php echo $this->params->get('googleFontName');?>' rel='stylesheet' type='text/css' />
		<style type="text/css">
			h1,h2,h3,h4,h5,h6,.site-title{
				font-family: '<?php echo str_replace('+', ' ', $this->params->get('googleFontName'));?>', sans-serif;
			}
		</style>
	<?php
	}
	?>
	<?php
	// Template color
	if ($this->params->get('templateColor'))
	{
	?>
	<style type="text/css">
		body.site
		{
			border-top: 3px solid <?php echo $this->params->get('templateColor');?>;
			background-color: <?php echo $this->params->get('templateBackgroundColor');?>
		}
		a
		{
			color: <?php echo $this->params->get('templateColor');?>;
		}
		.navbar-inner, .nav-list > .active > a, .nav-list > .active > a:hover, .dropdown-menu li > a:hover, .dropdown-menu .active > a, .dropdown-menu .active > a:hover, .nav-pills > .active > a, .nav-pills > .active > a:hover,
		.btn-primary
		{
			background: <?php echo $this->params->get('templateColor');?>;
		}
		.navbar-inner
		{
			-moz-box-shadow: 0 1px 3px rgba(0, 0, 0, .25), inset 0 -1px 0 rgba(0, 0, 0, .1), inset 0 30px 10px rgba(0, 0, 0, .2);
			-webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, .25), inset 0 -1px 0 rgba(0, 0, 0, .1), inset 0 30px 10px rgba(0, 0, 0, .2);
			box-shadow: 0 1px 3px rgba(0, 0, 0, .25), inset 0 -1px 0 rgba(0, 0, 0, .1), inset 0 30px 10px rgba(0, 0, 0, .2);
		}
	</style>
	<?php
	}
	?>
	<!--[if lt IE 9]>
		<script src="<?php echo $this->baseurl ?>/media/jui/js/html5.js"></script>
	<![endif]-->
  
  <script type="text/javascript">
  // ENTER ne jelentsen SUBMIT -et.
  function stopRKey(evt) {
    var evt = (evt) ? evt : ((event) ? event : null);
    var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
    if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
  } 
  document.onkeypress = stopRKey; 
  </script>

  <script src="https://apis.google.com/js/platform.js" async defer>
  {lang: 'hu'}
  </script>
  
  </head>

<body class="site <?php echo $option
	. ' view-' . $view
	. ($layout ? ' layout-' . $layout : ' no-layout')
	. ($task ? ' task-' . $task : ' no-task')
	. ($itemid ? ' itemid-' . $itemid : '')
	. ($params->get('fluidContainer') ? ' fluid' : '');

?>">

	<!-- Body -->
	<div class="body">
		<div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : '');?>">
			<!-- Header -->
			<header class="header" role="banner">
				<div class="header-inner clearfix">
					<div id="sitetitle">  
            <a class="brand pull-left" href="<?php echo $this->baseurl; ?>">
						<?php echo $logo;?> <?php if ($this->params->get('sitedescription')) { echo '<div class="site-description">'. htmlspecialchars($this->params->get('sitedescription')) .'</div>'; } ?>
					  </a>
            <div style="clear:both"><small>Nem az a szabadság, hogy négyévente<br />megválasztjuk azt, hogy ki uralkodjon rajtunk.</small></div>
          </div>  
          <div id="slideshow">
						<jdoc:include type="modules" name="position-2" style="none" />
          </div>
					<div class="header-search pull-right">
						<jdoc:include type="modules" name="position-0" style="none" />
					</div>
				</div>
			</header>
			<?php if ($this->countModules('position-1')) : ?>
			<nav class="navigation" role="navigation">
				<jdoc:include type="modules" name="position-1" style="none" />
			</nav>
			<?php endif; ?>
			<jdoc:include type="modules" name="banner" style="xhtml" />
			<div class="row-fluid">
				<?php if ($this->countModules('position-8')) : ?>
				<!-- Begin Sidebar -->
				<div id="sidebar" class="span3">
					<div class="sidebar-nav">
						<jdoc:include type="modules" name="position-8" style="xhtml" />
					</div>
				</div>
				<!-- End Sidebar -->
				<?php endif; ?>
				<main id="content" role="main" class="<?php echo $span;?>">
					<!-- Begin Content -->
					<jdoc:include type="modules" name="position-3" style="xhtml" />
					<jdoc:include type="message" />
					<jdoc:include type="component" />
					<jdoc:include type="modules" name="position-5" style="xhtml" />
					<!-- End Content -->

          <!-- megosztás gombok -->
          <?php
          $myURL = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
          ?>
          <table class="megosztasBar">
            <tbody>
            <tr>
              <td valign="top">
                <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
              </td>
              <td valign="top"><div class="g-plusone" data-annotation="inline" data-width="100"></div></td>
              <td><iframe src="//www.facebook.com/plugins/like.php?href=<?php echo urlencode($myURL); ?>&amp;width=200&amp;layout=standard&amp;action=recommend&amp;show_faces=true&amp;share=true&amp;height=80&amp;appId=366904500111535" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:230px;" allowTransparency="true"></iframe></td>
            </tr>
            </tbody>
          </table>
				</main>


				<?php if ($this->countModules('position-7')) : ?>
				<div id="aside" class="span3">
					<!-- Begin Right Sidebar -->
					<jdoc:include type="modules" name="position-7" style="well" />
					<!-- End Right Sidebar -->
				</div>
				<?php endif; ?>
			</div>
			<jdoc:include type="modules" name="position-4" style="xhtml" />
		</div>
	</div>


	<!-- Footer -->
	<footer class="footer" role="contentinfo">
		<div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : '');?>">
			<hr />
			<jdoc:include type="modules" name="footer" style="none" />
			<p class="pull-right"><a href="#top" id="back-top">Oldal tetejére</a></p>
			<p>&copy; <?php echo $sitename; ?> <?php echo date('Y');?></p>
		</div>
	</footer>
	<jdoc:include type="modules" name="debug" style="none" />
  
  <?php
    /*
    
    Úgy tünik ezzel a módszerrel megoldható a téli-nyári időszámytás + időzona probléme.
    $date = new DateTime('2014-01-01');
    $tz = $date->getTimezone();
    echo '<p>2014-01-01 '.$tz->getOffset($date).' '.$date->getOffset.'</p>';

    $date = new DateTime('2014-08-01');
    $tz = $date->getTimezone();
    echo '<p>2014-01-01 '.$tz->getOffset($date).' '.$date->getOffset.'</p>';

    $date = new DateTime();
    $tz = $date->getTimezone();
    echo '<p>'.$date->format('Y-m-d').' '.$tz->getOffset($date).' '.$date->getOffset.'</p>';
    */

  ?>
  
  <?php
  // facebook auto login ha fb=Y URL paraméter érkezik
  $fb = JRequest::getVar('fb');
  if ($fb == 'y') {
    ?>
    <script type="text/javascript">
      function fbAutoLogin() {
        var loginForm = document.getElementById('login-form');
        var aTags = loginForm.getElementsByTagName('A');
        var i = 0;
        for (i=1; i<aTags.length; i++) {
          if (aTags[i].href.indexOf('facebook') > 0) {
            aTags[i].click();
          }
        }
      }
      setTimeout(fbAutoLogin,2000);
    </script>
    <?php
  }
  // google auto login ha google=Y URL paraméter érkezik
  $google = JRequest::getVar('google');
  if ($google == 'y') {
    ?>
    <script type="text/javascript">
      function googleAutoLogin() {
        var loginForm = document.getElementById('login-form');
        var aTags = loginForm.getElementsByTagName('A');
        var i = 0;
        for (i=1; i<aTags.length; i++) {
          if (aTags[i].href.indexOf('google') > 0) {
            aTags[i].click();
          }
        }
      }
      setTimeout(googleAutoLogin,2000);
    </script>
    <?php
  }


  /**
   * image beolvasása facebook url -ből
   * ez igy nem jó :(   
   */      
  function getimg($link) {
      $ch = curl_init($link);
      curl_setopt($ch, CURLOPT_HEADER, true); // header will be at output
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'HEAD'); // HTTP request is 'HEAD'
      $result1 = curl_exec($ch);
      curl_close($ch);
      echo 'result1=<pre>'.$result1.'</pre>';
      $w = split($result1,'Location: ');
      $result = file_get_contents($w[1]);
      return $result;
  }

  /**
   * amikor facebook vagy g+ bejelentkezéssel generálódik user, akkor nincs
   * neki hs_user profilképe. 
   * ez a kód egy darab hiányzó userképet pótol a facebook -ból vagy g+ -ból
   * 
   * mindegyik  img tárolási módszer nulla méretü image-t csinál.
      
  $db = JFactory::getDBO();      
  echo '<br />hs_user kép pótlás start<br />';
  $db->setQuery('select a.user_id, a.photo_url
  from #__users_authentications a
  left outer join #__users_extended e on e.user_id = a.user_id
  where e.id is null
  limit 1');
  $res = $db->loadObjectList();
  if (count($res)>0) {
    $res1 = $res[0];
    echo 'hs_user kép pótlás 1 '.$res1->photo_url.'<br />';
    $url = $res1->photo_url;
    $imgName = 'user'.$res1->user_id.'.jpg';
    $imgFile = 'images/hsu/00/00/00/'.$imgName;
    
    // nem jó 0 méretü image-t csinál
    //file_put_contents($imgFile, file_get_contents($url));
    
    // nem jó 0 méretü image-t csinál
    //$ch = curl_init($url);
    //$fp = fopen($imgFile, 'wb');
    //curl_setopt($ch, CURLOPT_FILE, $fp);
    //curl_setopt($ch, CURLOPT_HEADER, 0);
    //curl_exec($ch);
    //curl_close($ch);
    //fclose($fp);
    
    // nem jó 0 méretü image-t csinál
    //$content = file_get_contents($url);
    //$fp = fopen($imgFile, "w");
    //fwrite($fp, $content);
    //fclose($fp);    

    // ez meg nem csinál semmit
    //copy($url, $imgFile);
    
    // ez is nulla méretet ad
    $image = getimg($url); 
    file_put_contents($imgFile,$image); 
    
    echo 'hs_user kép pótlás 2 '.$imgFile.'<br />';
    $db->setquery('insert into #__users_extended (user_id,image_folder,image_name,image_raw_name)
    values ('.$res1->user_id.',"00/00/00","'.$imgName.'","'.$imgName.'")');
    echo 'hs_user kép pótlás 3 <br />';
    $db->query();
  }
  */
  ?>
  
</body>
</html>
