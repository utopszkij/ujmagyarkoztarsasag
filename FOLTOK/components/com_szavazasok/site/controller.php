<?php
/**
* @version		$Id:controller.php  1 2014-04-04Z FT $
* @package		Szavazasok
* @subpackage 	Controllers
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/

// no direct access

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
require_once(JPATH_ROOT . '/components/com_jcomments/jcomments.php');
require_once JPATH_BASE.DS.'components'.DS.'com_temakorok'.DS.'models'.DS.'temakorok.php';

// titkositó kulcs JConfig.secret első 8 karaktere
$config     = new JConfig();
$secret     = $config->secret;
$hexSecret='';
for ($i=0; $i < strlen($secret); $i++){
  $hexSecret .= dechex(ord($secret[$i]));
}
define("ENCRYPTION_KEY", $hexSecret);

function string2Hex($string){
    $hex='';
    for ($i=0; $i < strlen($string); $i++){
        $hex .= dechex(ord($string[$i]));
    }
    return $hex;
}
function hex2String($hex){
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2){
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;
}
 

/**
 * titkositás RIJNADEL 128 eljárással
 * @param string $pure_string titkositandó string
 * @param string $encryption_key titkoskulcs
 * @return string titkositott string hexa
 */ 
function encrypt($pure_string, $encryption_key) {
  /*
  $key = pack('H*', $encryption_key);
  $key_size =  strlen($key);
  $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
  $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
  $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,
                               $pure_string, MCRYPT_MODE_CBC, $iv);
  $ciphertext = $iv . $ciphertext;
  return trim(string2Hex($ciphertext));
  */
  return string2Hex($pure_string);
}

/**
 * titkositott adat (hexa) visszafejtés RIJNADEL 128 eljárással
 * @param string $encrypted_string titkositott string
 * @param string $encryption_key titkoskulcs
 * @return string visszafejtett string
 */ 
function decrypt($encrypted_string, $encryption_key) {
  /*
  $key = pack('H*', $encryption_key);
  $ciphertext_dec = hex2String($encrypted_string);
  $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
  $iv_dec = substr($ciphertext_dec, 0, $iv_size);
  $ciphertext_dec = substr($ciphertext_dec, $iv_size);
  $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,
                                    $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
  return  trim($plaintext_dec);
  */
  return hex2String($encrypted_string);
}

/**
 * Variant Controller
 *
 * @package    
 * @subpackage Controllers
 */
class SzavazasokController extends JControllerLegacy {
  protected $NAME='szavazasok';
  protected $_viewname = 'item';
  protected $_mainmodel = 'item';
  protected $_itemname = 'Item';    
  protected $_context = "com_szavazasok";
  protected $temakorokHelper = null;
  protected $temakor_id = 0;
  protected $temakor = null;
  protected $temakor_admin = false;
  protected $helper = null;
  protected $model = null;
  protected $view = null;
	/**
	 * Constructor
	 */
	public function __construct($config = array ()) {
		parent :: __construct($config);
        if(isset($config['viewname'])) $this->_viewname = $config['viewname'];
		if(isset($config['mainmodel'])) $this->_mainmodel = $config['mainmodel'];
		if(isset($config['itemname'])) $this->_itemname = $config['itemname']; 
        $this->temakor_id = JRequest::getVar('temakor','0');
        $db = JFactory::getDBO();
        $temakorModel = new TemakorokModelTemakorok;
        $this->temakor = $temakorModel->getItem($this->temakor_id);
        
        // browser paraméterek ellenörzése, ha kell javitása
        if (JRequest::getVar('limit')=='') JRequest::setVar('limit',20);
        if (JRequest::getVar('limitstart')=='') JRequest::setVar('limitstart',0);
        if (JRequest::getVar('order')=='') JRequest::setVar('order',6);
        
        // általánosan használt helper
        if (file_exists(JPATH_ROOT.DS.'components'.DS.'com_temakorok'.DS.'helpers'.DS.'temakorok.php')) {
          include JPATH_ROOT.DS.'components'.DS.'com_temakorok'.DS.'helpers'.DS.'temakorok.php';
          $this->temakorokHelper = new TemakorokHelper();
        }
    
        // saját helper
        //if (file_exists(JPATH_COMPONENT.DS.'helpers'.DS.'temakorok.php')) {
        //  include JPATH_COMPONENT.DS.'helpers'.DS.'temakorok.php';
        //  $this->helper = new TemakorokHelper();
        //}
        
        $user = JFactory::getUser();
        $db->setQuery('select * from #__tagok 
        where temakor_id="'.$this->temakor_id.'" and user_id="'.JFactory::getUser()->id.'"');
        $res = $db->loadObject();
        if ($res) {
          $this->temakor_admin = ($res->admin == 1);
        }	
		
		$document =& JFactory::getDocument();
		$viewType	= $document->getType();
		$this->view = $this->getView($this->_viewname,$viewType);
		$this->model = $this->getModel($this->_mainmodel);
		$this->view->setModel($this->model,true);		
		JRequest :: setVar('view', $this->_viewname);
    
        // automatikus szavazás állapot változtatás
        $this->temakorokHelper->setSzavazasAllapot();
		
	}
  /**
   * kik a szavazás felvivők?
   * @return integer 1- regisztráltak, 2-téma tagok, 3-adminok
   */         
  private function szavazas_felvivo() {
    return $this->temakor->szavazasinditok;
  }
  /**
   * a megadott étmakörnek ez a user az inditója?
   */      
  private function temakorIndito($temakor_id,$user) {
    return (($user->id == $this->temakor->felvivo) & ($user->id > 0));
  }
  /**
   * default display function
   */      
	public function display() {
		$this->view->display();
	}
	/**
	 * browse task
	 * @return void
	 * @request integer limit
	 * @request integer limitstart
	 * @request integer order
	 * @request integer filterStr
	 * @session object 'temakoroklist_status'   
	 */                     
  public function browse() {
	jimport('hs.user.user');
    JHTML::_('behavior.modal'); 
    $total = 0;
    $pagination = null;
    $user = JFactory::getUser();
    $db = JFactory::getDBO();

    // hozzáférés ellenörzés
    if ($this->temakorokHelper->isAdmin($user) == false) {
      if ((($this->temakor->lathatosag == 1) & ($user->id == 0)) |
          (($this->temakor->lathatosag == 2) & ($this->temakorokHelper->userTag($this->temakor->id,$user) == false))
         ) {  
        // Redirect to login
        $this->temakorokHelper->getLogin(JText::_('TEMAKOR_NEKED_NEM_ELERHETO'));
      }
    }

    // alapértelmezett browser status beolvasása sessionból
    $session = JFactory::getSession();
    $brStatusStr = $session->get($this->NAME.'list_status');
    if ($brStatusStr == '') {
      $brStatusStr = '{"limit":20,"limitstart":0,"order":1,"filterStr":"|1"}';
    }
    $brStatus = JSON_decode($brStatusStr);
    
    $limitStart = JRequest::getVar('limitstart',$brStatus->limitstart);
    $limit = JRequest::getVar('limit',$brStatus->limit);
    $order = JRequest::getVar('order',$brStatus->order);
    $filterStr = urldecode(JRequest::getVar('filterStr',$brStatus->filterStr));
    
	//if ($this->temakor_id=='') $this->temakor_id = $brStatus->temakor_id;
    
    // browser status save to session and JRequest
    $brStatus->limit = $limit;
    $brStatus->limitStart = $limitStart;
    $brStatus->order = $order;
    $brStatus->filterStr = $filterStr;
    $brStatus->temakor_id = $this->temakor_id;
    $session->set($this->NAME.'list_status', JSON_encode($brStatus));
    JRequest::setVar('limit',$limit);
    JRequest::setVar('limitstart',$limitStart);
    JRequest::setVar('order',$order);
    JRequest::setVar('filterStr',$filterStr);
    JRequest::setVar('temakor',$this->temakor_id);
    // adattábla tartalom elérése és átadása a view -nek
    $items = $this->model->getItems();
    if ($this->model->getDBO()->getErrorNum() > 0) $this->model->getDBO()->stderr();
	if (JRequest::getVar('temakor') > 0)
	   $alTemak = $this->model->getAltemak();
    else
	   $alTemak = array();	
    
    if ($this->model->getError() != '')
      $this->view->Msg = $this->model->getError();
    $this->view->set('Items',$items);
    $this->view->set('AlTemak',$alTemak);
    $this->view->set('Temakor',$this->temakor);
    $this->view->set('Szulok',$this->temakorokHelper->getSzulok());
    if (JRequest::getVar('temakor') > 0)
	   $this->view->set('Title',JText::_('SZAVAZASOK'));
    else
	   $this->view->set('Title',JText::_('AKTIV_SZAVAZASOK'));
	if ($this->temakor->lathatosag == 2)
      $this->view->set('TemakorGroupId',$this->temakorokHelper->getTemakorGroupId($this->temakor->id));
    
    // browser müködéshez linkek definiálása
    $reorderLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&filterStr='.urlencode($filterStr).
       '&temakor='.$this->temakor_id;
    $doFilterLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&order='.JRequest::getVar('order','1').
       '&temakor='.$this->temakor_id;
    
	/* rövid URL használata 
	$itemLink =
       JURI::base().'index.php?option=com_alternativak&view=alternativaklist'.
       '&task=browse'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&order='.JRequest::getVar('order','1').
       '&temakor='.$this->temakor_id.
       '&filterStr='.urlencode($filterStr);
	*/   
	$itemLink =
       JURI::base().'SU/alternativak/alternativaklist/browse/'.
       $this->temakor_id.'/szavazas/'.
	   JRequest::getVar('limit','20').'/0/'.
       JRequest::getVar('order','1').'/'.
       urlencode($filterStr);
	   
	   
	   
    $backLink =
       JURI::base().'index.php?option=com_temakorok&view=temakoroklist'.
       '&task=browse';
    $temakorLink =
       JURI::base().'index.php?option=com_temakorok&view=temakorok'.
       '&task=show&remakor='.$this->temakor_id;
       
    $this->view->set('reorderLink',$reorderLink);
    $this->view->set('doFilterLink',$doFilterLink);
    $this->view->set('itemLink',$itemLink);
    $this->view->set('backLink',$backLink);
    $this->view->set('temakorLink',$temakorLink);
   
    // van ált. képviselője?
    $altKepviseloje = 0;
    $db->setQuery('select k.kepviselo_id, u.name 
    from #__kepviselok k, #__users u
    where k.kepviselo_id = u.id and
            k.user_id = "'.$user->id.'" and k.temakor_id=0 and k.szavazas_id = 0 and
            k.lejarat >= "'.date('Y-m-d').'"');
    $res = $db->loadObject();
    if ($db->getErrorNum() > 0) 
       $db->stderr();
    if ($res) {
      $altKepviseloje = $res->kepviselo_id;
    }
    
    // van témakör képviselője?
    $kepviseloje = 0;
    $db->setQuery('select k.kepviselo_id, u.name 
    from #__kepviselok k, #__users u
    where k.kepviselo_id = u.id and
            k.user_id = "'.$user->id.'" and k.temakor_id='.$this->temakor_id.' and k.szavazas_id = 0 and
            k.lejarat >= "'.date('Y-m-d').'"');
    $res = $db->loadObject();
    if ($db->getErrorNum() > 0) 
       $db->stderr();
    if ($res) {
      $kepviseloje = $res->kepviselo_id;
    }
    
    // Ő maga képviselő jelölt?
    $kepviseloJelolt = false;
    $db->setQuery('select user_id 
    from #__kepviselojeloltek
    where  user_id = "'.$user->id.'" and (temakor_id="'.$this->temakor_id.'" or temakor_id="0")');
    $res = $db->loadObject();
    if ($db->getErrorNum() > 0) 
       $db->stderr();
    if ($res) {
      $kepviseloJelolt = true;
    }
    
    // kik a szavazaás felvivők?
    $szavazas_felvivo = $this->szavazas_felvivo();

    // akciók definiálása
    $akciok = array();
    if ($this->temakorokHelper->isAdmin($user) | 
        ($this->temakor_admin) |
        (($szavazas_felvivo == 1) & ($user->id > 0)) |
        (($szavazas_felvivo == 2) & ($this->temakorokHelper->userTag($this->temakor_id,$user)))
       ) {
      if ($this->temakor->allapot == 0) { 
        $akciok['ujSzavazas'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=add'.
         '&temakor='.$this->temakor_id.
         '&limit='.JRequest::getVar('limit',20).
         '&limitstart='.JRequest::getVar('limitstart',0).
         '&order='.JRequest::getVar('order',1).
         '&filterStr='.JRequest::getVar('filterStr','');
        $akciok['ujAltema'] = JURI::base().'index.php?option=com_temakorok&view=temakorok&task=add&szulo='.$this->temakor->id;
      }   
    }  

    if (($this->temakorokHelper->isAdmin($user)) |
        ($this->temakor_admin) |
        ($this->temakorIndito($this->temakor_id,$user))) {  
      $akciok['temakoredit'] = JURI::base().'index.php?option=com_temakorok&view=temakorok&task=edit'.
      '&temakor='.$this->temakor_id;
    }

    if (($this->temakorokHelper->isAdmin($user)) |
        ($this->temakor_admin) |
        ($this->temakorIndito($this->temakor_id,$user))) {  
      $akciok['temakortorles'] = JURI::base().'index.php?option=com_temakorok&view=temakorok&task=deleteform'.
      '&temakor='.$this->temakor_id;
    }

    $akciok['tagok'] = JURI::base().'index.php?option=com_tagok&temakor='.$this->temakor_id;
    $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                      '&id='.JText::_(strtoupper($this->NAME).'LIST_SUGO').'&Itemid=435&tmpl=component';

    if ($this->temakorokHelper->userTag($this->temakor_id,$user) == false) {
      $akciok['tagJelentkezes'] = JURI::base().'index.php?option=com_tagok&view=tagok&task=jelentkezes'.
                      '&temakor='.$this->temakor_id.'&user='.$user->id;
    }

    $this->view->set('Akciok',$akciok);
   
    // globális képviselő/képviselő jelölt gombok definiálása
    $altKepviselo = array();
    $altKepviselo['kepviselojeLink'] = '';
    $kepviselo = array();
    $kepviselo['kepviselojeLink'] = '';
    $kepviselo['kepviseloJeloltLink'] = '';
    $kepviselo['kepviselotValasztLink'] = '';
    $kepviselo['ujJeloltLink'] = '';
    
    if ($user->id > 0) {
      if ($altKepviseloje > 0) {
        $kepviseloUser = JFactory::getUser($altKepviseloje);
        if ($kepviseloUser) {
          $altKepviselo['kepviselojeLink'] = JURI::base().'index.php?option=com_kepviselok&task=show&temakor=0&id='.$altKepviseloje;
	      $altKepviselo['image'] = getAvatar($altKepviseloje);
          $altKepviselo['nev'] = $kepviseloUser->name;
        }  
      }
      if ($kepviseloje > 0) {
        $kepviseloUser = JFactory::getUser($kepviseloje);
        if ($kepviseloUser) {
          $kepviselo['kepviselojeLink'] = JURI::base().'index.php?option=com_kepviselok&task=show&temakor='.$this->temakor_id.'&id='.$kepviseloje;
	      $kepviselo['image'] = getAvatar($kepviseloje);
          $kepviselo['nev'] = $kepviseloUser->name;
        }  
      } else if ($kepviseloJelolt) {
        $kepviselo['kepviseloJeloltLink'] = JURI::base().'index.php?option=com_kepviselojeloltek&&view=kepviselojeloltek&task=add&user_id='.$user->id.'&temakor='.$this->temakor_id;
      } else {
        $kepviselo['kepviselotValasztLink'] = JURI::base().'index.php?option=com_kepviselok&view=kepviseloklist&task=add&temakor='.$this->temakor_id.'&szavazas=0';
        $kepviselo['ujJeloltLink'] =  JURI::base().'index.php?option=com_kepviselojeloltek&task=add&temakor='.$this->temakor_id.'&szavazas=0&id='.$user->id;
      }
    }
    $this->view->set('Kepviselo',$kepviselo);
    $this->view->set('AltKepviselo',$altKepviselo);
    
    //lapozósor definiálása
    jimport( 'joomla.html.pagination' );    
    $total = $this->model->getTotal($filterStr);
    $pagination = new JPagination($total, $limitStart, $limit);
    $pagination->setAdditionalUrlParam('order',$order);
    $pagination->setAdditionalUrlParam('filterStr',urlencode($filterStr));
	$this->view->set('LapozoSor', $pagination->getListFooter());
    
    // kacsolodó cikk id-jének elérése és átadása a viewer-nek
    $db->setQuery('SELECT id from #__content WHERE alias="t'.$this->temakor_id.'"');
    $res = $db->loadObject();
    if ($res) {
      $this->view->set('CommentId',$res->id);
    } else {
      $this->view->set('CommentId',0);
    }

    $this->view->display();
  } // browse task
  /**
   * szürés start
   * @JRequests: limit, limitstart, filterStr, order
   * @return void      
   */      
  public function dofilter() {
     $s = JRequest::getVar('filterKeresendo','').'|'.JRequest::getVar('filterAktiv','0');
     JRequest::setVar('filterStr',$s);
     JRequest::setVar('limitstart','0');
     $this->browse();
  }
  /**
   * felvivő képernyő kirajzoéása
   * @JRequests: limit, limitstart, filterStr, order
   * @session: clipboard_szavazas_id = szavazas_id   
   * @return void
   * A task=paste aktiválás is ezt hivja be   
   */
  public function paste() {
    $this->add();
  }
  /**
   * felvivő képernyő kirajzoéása
   * @JRequests: limit, limitstart, filterStr, order
   * @return void
   * A task=paste aktiválás is ezt hivja be , 
   * ilyenkor JRequest::getVar('task')=='paste'   
   */
  public function add() {
    jimport('hs.user.user');
    JHTML::_('behavior.modal'); 
    $user = JFactory::getUser();
    $db = JFactory::getDBO();
    $session = JFactory::getSession();
    // kik a témakor felvivők?
    $szavazas_felvivo = $this->szavazas_felvivo();

    if ($this->temakorokHelper->isAdmin($user) | 
        ($this->temakor_admin) |
        (($szavazas_felvivo == 1) & ($user->id > 0)) |
        (($szavazas_felvivo == 2) & ($this->temakorokHelper->userTag($this->temakor_id,$user)))
       ) {
      if (JRequest::getVar('task','') == 'paste')
        $item = $this->model->getFromClipboard();
      else
        $item = $this->model->getItem(0);
      
      if ($this->model->getError() != '')
        $this->view->Msg = $this->model->getError();
      $item->szavazok = $this->temakor->szavazok;
      $this->view->set('Item',$item);
      $this->view->set('Temakor',$this->temakor);
      $this->view->set('Title', JText::_('UJSZAVAZAS'));
      
      // akciok definiálása
      $akciok = array();
      if ($session->get('clipboard_szavazas_id') != '')
        $akciok['paste'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=paste'.
          '&temakor='.JRequest::getVar('temakor');
      $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=save';
      $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
                          '&temakor='.$this->temakor_id;
      $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                        '&id='.JText::_('UJSZAVAZAS_SUGO').'&Itemid=435&tmpl=component'; 
      $this->view->set('Akciok',$akciok);
      
      // form megjelenités
      $this->view->setLayout('form');
      $this->view->display();
    } else {
      echo '<div class="errorMsg">Access denied $szavazas_felvivo='.$szavazas_felvivo.
              ' tag='.$this->temakorokHelper->userTag($this->temakor_id,$user).'</div>';
    }
  } // add task
  /**
   * módosító képernyő kirajzoéása
   * @JRequests: limit, limitstart, filterStr, order, temakor
   * @return void
   */
  public function edit() {
    jimport('hs.user.user');
    JHTML::_('behavior.modal'); 
    $user = JFactory::getUser();
    $db = JFactory::getDBO();
    $db->setQuery('select letrehozo from #__szavazasok where id="'.JRequest::getVar('szavazas').'"');
    $res = $db->loadObject();
    if ($res == false) {
       echo '<div class="errorMsg">'.JText::_('WRONG_SZAVAZAS_ID').':'.JRequest::getVar('szavazas').'</div>';
       return;
    }
    
    // hozzáférés ellenörzés
    if ($this->temakorokHelper->isAdmin($user) == false) {
      if ((($this->temakor->lathatosag == 1) & ($user->id == 0)) |
          (($this->temakor->lathatosag == 2) & ($this->temakorokHelper->userTag($this->temakor->id,$user) == false))
         ) {  
        $this->setMessage(JText::_('TEMAKOR_NEKED_NEM_ELERHETO'));
        $this->setRedirect(JURI::base().'index.php?option=com_temakorok&view=temakoroklist'.
               '&task=browse');
        $this->redirect();
      }
    }
    
    if ($this->temakorokHelper->isAdmin($user) | 
        ($this->temakor_admin) |
        ($res->felvivo == $user->id)
       ) {
      $item = $this->model->getItem(JRequest::getVar('szavazas'));
      
      //DBG foreach ($item as $fn => $fv) echo '<p>controller->item '.$fn.'='.$fv.'</p>';
      
      if ($this->model->getError() != '')
        $this->view->Msg = $this->model->getError();
      $this->view->set('Item',$item);
      $this->view->set('Temakor',$this->temakor);
      $this->view->set('Title', JText::_('SZAVAZASMODOSITAS'));
	  $temakorTree = $this->temakorokHelper->getTemakorTree(0,'options',0,$item->temakor_id);
	  $this->view->set('temakorTree',$temakorTree);
      
      // akciok definiálása
      $akciok = array();
      $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=save';
      $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
            '&temakor='.$this->temakor_id;
      $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                        '&id='.JText::_('SZAVAZASMODOSITAS_SUGO').'&Itemid=435&tmpl=component'; 
      $akciok['emails'] = JURI::base().'index.php?option=com_szavazasok&view=emails&task=emailform'.
         '&szavazas='.$item->id;
      $this->view->set('Akciok',$akciok);
      
      // form megjelenités
      $this->view->setLayout('form');
      $this->view->display();
    } else {
      echo '<div class="errorMsg">Access denied</div>';
    }
  } // edit task
  /**
   * szavazás adatlap kirajzoéása
   * @JRequests: limit, limitstart, filterStr, order, temakor
   * @return void
   */
  public function __show() {
    jimport('hs.user.user');
    JHTML::_('behavior.modal'); 
    $user = JFactory::getUser();
    $db = JFactory::getDBO();
    $db->setQuery('select letrehozo from #__szavazasok where id="'.JRequest::getVar('szavazas').'"');
    $res = $db->loadObject();
    if ($res == fase) {
       echo '<div class="errorMsg">'.JText::_('WRONG_SZAVAZAS_ID').':'.JRequest::getVar('szavazas').'</div>';
       return;
    }
    
    // hozzáférés ellenörzés
    if ($this->temakorokHelper->isAdmin($user) == false) {
      if ((($this->temakor->lathatosag == 1) & ($user->id == 0)) |
          (($this->temakor->lathatosag == 2) & ($this->temakorokHelper->userTag($this->temakor->id,$user) == false))
         ) {  
        // Redirect to login
        $this->temakorokHelper->getLogin(JText::_('TEMAKOR_NEKED_NEM_ELERHETO'));
        
      }
    }
    
    if ($this->temakorokHelper->isAdmin($user) | 
        ($this->temakor_admin) |
        ($res->felvivo == $user->id)
       ) {
      $item = $this->model->getItem(JRequest::getVar('szavazas'));
      if ($this->model->getError() != '')
        $this->view->Msg = $this->model->getError();
      $this->view->set('Item',$item);
      $this->view->set('Temakor',$this->temakor);
      $this->view->set('Title', JText::_('SZAVAZASMODOSITAS'));
      
      // akciok definiálása
      $akciok = array();
      $akciok['szavazok'] = JURI::base().'index.php?option=com_szavazasok&view=szavazasok&task=szavazok'.
              '&temakor='.$this->temakor.
              '&szavazas='.$JRequest::getVar('szavazas');
      $akciok['eredmeny'] = JURI::base().'index.php?option=com_szavazasok&view=szavazasok&task=eredmeny'.
              '&temakor='.$this->temakor.
              '&szavazas='.$JRequest::getVar('szavazas');
      $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list';
      $akciok['cancel2'] = JURI::base().'index.php?option=com_temakorok&view=temakoroklist';
      $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                        '&id='.JText::_('SZAVAZASADATLAP_SUGO').'&Itemid=435&tmpl=component'; 
      $this->view->set('Akciok',$akciok);
      
      // form megjelenités
      $this->view->setLayout('form');
      $this->view->display();
    } else {
      echo '<div class="errorMsg">Access denied</div>';
    }
  } // showt task
  /**
   * delete képernyő kirajzoéása
   * @JRequests: limit, limitstart, filterStr, order, temakor
   * @return voin
   */
  public function deleteform() {
    jimport('hs.user.user');
    JHTML::_('behavior.modal'); 
    $user = JFactory::getUser();
    $db = JFactory::getDBO();
    $db->setQuery('select letrehozo from #__szavazasok where id="'.JRequest::getVar('szavazas').'"');
    $res = $db->loadObject();
    if ($res == fase) {
       echo '<div class="errorMsg">'.JText::_('WRON_SZAVAZAS_ID').':'.JRequest::getVar('szavazas').'</div>';
       return;
    }
    
    // hozzáférés ellenörzés
    if ($this->temakorokHelper->isAdmin($user) == false) {
      if ((($this->temakor->lathatosag == 1) & ($user->id == 0)) |
          (($this->temakor->lathatosag == 2) & ($this->temakorokHelper->userTag($this->temakor->id,$user) == false))
         ) {  
        $this->setMessage(JText::_('TEMAKOR_NEKED_NEM_ELERHETO'));
        $this->setRedirect(JURI::base().'index.php?option=com_temakorok&view=temakoroklist'.
               '&task=browse');
        $this->redirect();
      }
    }
    
    if ($this->temakorokHelper->isAdmin($user) | ($this->temakor_admin)) {
      $item = $this->model->getItem(JRequest::getVar('szavazas'));
      if ($this->model->getError() != '')
         $this->view->Msg = $this->model->getError();
      $this->view->set('Item',$item);
      $this->view->set('Temakor',$this->temakor);
      $this->view->set('Title', JText::_('SZAVAZASTORLES'));
      
      // akciok definiálása
      $akciok = array();
      $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=delete'.
         '&temakor='.$this->temakor->id.
         '&szavazas='.$item->id;
      ;
      $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
         '&temakor='.$this->temakor->id;
      $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                        '&id='.JText::_('SZAVAZASTORLES_SUGO').'&Itemid=435&tmpl=component'; 
      $this->view->set('Akciok',$akciok);
      
      // form megjelenités
      $this->view->setLayout('delete');
      $this->view->display();
    } else {
      echo '<div class="errorMsg">Access denied</div>';
    }
  } // deleteform task
  
  /**
   * save a POST -ban lévő adatokból
   * @JRequest dataform   
   * @return void   
   */      
  public function save()	{
    // Check for request forgeries
    JRequest :: checkToken() or jexit('Invalid Token');
    $user = JFactory::getUser();
    $db = JFactory::getDBO();

    // kik a témakor felvivők?
    $szavazas_felvivo = $this->szavazas_felvivo();

    // hozzáférés ellenörzés
    if ($this->temakorokHelper->isAdmin($user) == false) {
      if ((($this->temakor->lathatosag == 1) & ($user->id == 0)) |
          (($this->temakor->lathatosag == 2) & ($this->temakorokHelper->userTag($this->temakor->id,$user) == false))
         ) {  
        $this->setMessage(JText::_('TEMAKOR_NEKED_NEM_ELERHETO'));
        $this->setRedirect(JURI::base().'index.php?option=com_temakorok&view=temakoroklist'.
               '&task=browse');
        $this->redirect();
      }
    }


    if ($this->temakorokHelper->isAdmin($user) | 
        ($this->temakor_admin) |
        (($szavazas_felvivo == 1) & ($user->id > 0) & JRequest::getVar('id') == 0) |
        (($szavazas_felvivo == 2) & ($this->temakorokHelper->userTag($this->temakor_id,$user))) |
        (($user->id == JRequest::getVar('felvivo') & (JRequest::getVar('id') > 0)))
        ) {
      $item = $this->model->bind($_POST);
      if (($item->temakor_id == 0) | 
          ($item->temakor_id == '') | 
          ($item->temakor_id == null)) {
      
          echo '<p>$item->temakor_id is emtpy 
                   <br />Jrequest(temakor)='.JRequest::getVar('temakor').'
                   <br />$this->temakor->id='.$this->temakor->id.'</p>';
                   
          exit();         
      }
  	  if ($this->model->store($item)) {
        $link =
        JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
        '&limit='.JRequest::getVar('limit','20').
        '&limitstart='.JRequest::getVar('limitstart',0).
        '&filterStr='.urlencode(JRequest::getVar('filterStr')).
        '&temakor='.urlencode($item->temakor_id).
        '&order='.JRequest::getVar('order');
        $this->setMessage(JText::_('SZAVAZASTAROLVA'));
        $this->setRedirect($link);
        $this->redirect();
      } else {
		JRequest::setVar('temakor',$item->temakor_id);  
    	$this->view->setModel($this->model,true);
        $this->view->Msg = 'ERROR IS store '.$this->model->getError();
        $this->view->set('Item',$item);
        if ($item->id == 0) {
           $this->view->set('Title', JText::_('UJSZAVAZAS'));
        } else {
           $this->view->set('Title', JText::_('SZAVAZASMODOSITAS'));
        }   
        // akciok definiálása
        $akciok = array();
        $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=save';
        $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
           '&temakor='.$this->temakor_id;
        if ($item->id == 0)
          $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                            '&id='.JText::_('UJSZAVAZAS_SUGO').'&Itemid=435&tmpl=component'; 
        else
          $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                            '&id='.JText::_('SZAVAZASMODOSITAS_SUGO').'&Itemid=435&tmpl=component'; 
        $this->view->set('Akciok',$akciok);
      
        // form megjelenités
        $this->view->setLayout('form');
        $this->view->display();
      }
    } else {
      echo '<div class="errorMsg">Access denied</div>';
    }
  } // save task 
  
  /**
   * delete task
   * @JRequest limit,limitstart,order, filterStr, temakor
   * @return void      
   */      
  public function delete()	{
    // Check for request forgeries
    $session = JFactory::getSession();
    $secret = $session->get('secret');
    if (JRequest::getVar($secret)!='1') {
         echo '<div class="errorMsg">Wrong secret key</div>';
         return;
    }
    $user = JFactory::getUser();
    $db = JFactory::getDBO();
    
    // hozzáférés ellenörzés
    if ($this->temakorokHelper->isAdmin($user) == false) {
      if ((($this->temakor->lathatosag == 1) & ($user->id == 0)) |
          (($this->temakor->lathatosag == 2) & ($this->temakorokHelper->userTag($this->temakor->id,$user) == false))
         ) {  
        $this->setMessage(JText::_('TEMAKOR_NEKED_NEM_ELERHETO'));
        $this->setRedirect(JURI::base().'index.php?option=com_temakorok&view=temakoroklist'.
               '&task=browse');
        $this->redirect();
      }
    }
    
    if ($this->temakorokHelper->isAdmin($user) | ($this->temakor_admin)) {
      $item = $this->model->getItem(JRequest::getVar('szavazas'));
      if ($item == fase) {
         echo '<div class="errorMsg">'.JText::_('WRON_SZAVAZAS_ID').':'.JRequest::getVar('szavazas').'</div>';
         return;
      }
      if ($this->model->delete($item)) {
        $link =
        JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
        '&limitstart=0&temakor='.$this->temakor_id;
        $this->setMessage(JText::_('SZAVAZASTOROLVE'));
        $this->setRedirect($link);
        $this->redirect();
      } else {
        $link =
        JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
        '&limitstart=0&temakor='.$this->temakor_id;
        $this->setMessage($this->model->getError());
        $this->setRedirect($link);
        $this->redirect();
      }
    } else {
      echo '<div class="errorMsg">Access denied</div>';
    }
  } // delete task
  /**
   * szavazás leadása
   */     
  public function szavazoform() {
    jimport('hs.user.user');
    JHTML::_('behavior.modal'); 
    $user = JFactory::getUser();
    if ($user->id == 0) {
       // Redirect to login
       $this->temakorokHelper->getLogin(JText::_('TEMAKOR_NEKED_NEM_ELERHETO'));
       
    }
    $db = JFactory::getDBO();
    $db->setQuery('select letrehozo from #__szavazasok where id="'.JRequest::getVar('szavazas').'"');
    $res = $db->loadObject();
    if ($res == false) {
       echo '<div class="errorMsg">'.JText::_('WRONG_SZAVAZAS_ID').':'.JRequest::getVar('szavazas').'</div>';
       return;
    }
    // szavazott már?
    $db->setQuery('select * 
    from #__szavazok 
    where szavazas_id='.JRequest::getVar('szavazas').' and user_id='.$user->id);
    $res = $db->loadObejctList();    
    if (count($res) > 0) {
       echo '<div class="errorMsg">'.JText::_('MARSZAVAZTAL').'</div>';
       return;
    }
    $item = $this->model->getItem(JRequest::getVar('szavazas'));
    if (($item->szavazas == 1) &
        (($item->szavazok == 1) |
         (($item->szavazok == 2) & ($this->temakorokHelper->userTag($item->temakor_id,$user,false))) |
         (($item->szavazok == 3) & ($this->temakorokHelper->userTag($item->temakor_id,$user,true))) 
        ) 
       ) {
      if ($this->model->getError() != '')
        $this->view->Msg = $this->model->getError();
      $this->view->set('Item',$item);
      $this->view->set('Temakor',$this->temakor);
      $this->view->set('Title', JText::_('SZAVAZOK'));
      
      // akciok definiálása
      $akciok = array();
      $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=szavazassave';
      $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
         '&temakor='.$this->temakor->id.'&szavazas='.$item->id;
      $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                        '&id='.JText::_('SZAVAZOK_SUGO').'&Itemid=435&tmpl=component'; 
      $this->view->set('Akciok',$akciok);
      
      // form megjelenités
      
      $this->view->setLayout('szavazok');
      $this->view->display();
    } else {
      echo '<div class="errorMsg">Access denied</div>';
    }
  }
  /**
   * eredmény megtekintése
   */      
  public function eredmeny() {
    JHTML::_('behavior.modal'); 
    $db = JFactory::getDBO();
  
    // TEST szavazotok tárolása
    //  textfield:  pos pos pos
    //              pos pos pos
    if (JRequest::getVar('test') != '') {
      $temakor_id = JRequest::getVar('temakor','0');
      $szavazas_id = JRequest::getVar('szavazas','0');
      $tests = explode("\n",JRequest::getVar('test'));
      $db->setQuery('DELETE FROM #__poll_value_cache'); 
      $db->query();
      $db->setQuery('DELETE FROM #__szavazatok where szavazas_id='.$szavazas_id);
      $db->query(); 
      $db->query();
      foreach ($tests as $test) {
        echo '<p>'.$test.'</p>';
        // szavazo_id képzése
        $db->setQuery('select max(szavazo_id) szavazo_id from #__szavazatok');
        $res = $db->loadObject();
        if ($res)
          $szavazo_id = $res->szavazo_id + 1;
        else
          $szavazo_id = 0;  
        $db->setQuery('select * from #__alternativak where szavazas_id='.$szavazas_id.' order by megnevezes');
        $alternativak = $db->loadObjectList();
        for ($i=0; $i<count($alternativak); $i++) {
          $j = 0 + substr($test,$i,1) - 1;
          $alternativa_id = $alternativak[$j]->id;
          $db->setQuery('insert into #__szavazatok 
            	(`temakor_id`,`szavazas_id`,`szavazo_id`,`user_id`,`alternativa_id`,`pozicio`	)
            	values
            	("'.$temakor_id.'", 
            	 "'.$szavazas_id.'", 
            	 "'.$szavazo_id.'", 
            	 "0", 
            	 "'.$alternativa_id.'", 
            	 "'.($i+1).'");
           ');
           $db->query();
        }
      }
    }
  
    $temakor_id = JRequest::getVar('temakor','0');
    $szavazas_id = JRequest::getVar('szavazas','0');
    $this->view->set('Temakor_id',$temakor_id);
    $this->view->set('Szavazas_id',$szavazas_id);
    $this->view->set('temakorokHelper',$this->temakorokHelper);
    $this->view->setLayout('values');
    $this->view->display();
  
  }
  /**
   * szavazás eredmény tárolása
   * Session: szavazas_secret              
   * JRequest: temakor, szavazas, nick, 'szavazas_secret', pos##,....
   *      ahol ## az alternativák id -je
   */
   public function szavazassave() {
     $db = JFactory::getDBO();
     $temakor_id = JRequest::getVar('temakor','0');
     $szavazas_id = JRequest::getVar('szavazas','0');
     $nick = JRequest::getvar('nick');
     $user = JFactory::getUser();
     $session = JFactory::getSession();
     if ($user->id == 0) {
       echo '<div class="errorMsg">Not loged in.</div>
       ';
       return;
     }
     if ($user->username != $nick) {
       echo '<div class="errorMsg">Wrong user</div>';
       return;
     }
     $szavazas_secret = $session->get('szavazas_secret','@@@');
     if (JRequest::getVar($szavazas_secret,'0') != 1) {
       echo '<h2 class="error">Wrong secret key</h2>';
       return;
     }
     // begin transaction, lock tables
     $db->setQuery('start transaction');
     if (!$db->query()) {
       echo '<h2 class="error">Error in save vote (0). Pleas try again</h2>';
       return;
     };
     $db->setQuery('lock tables #__szavazatok write,
                                #__szavazok write,
                                #__szavazasok read,
                                #__kepviselok read,
                                #__alternativak read');
     if (!$db->query()) {
       $db->setQuery('rollback');
       $db->query();
       echo '<h2 class="errorMsg">Error in save vote (1). Pleas try again</h2>';
       return;
     };
     
     // szavazas rekord beolvasása
     $db->setQuery('select * from #__szavazasok where id='.$szavazas_id);
     $szavazas = $db->loadObject();
     if ($szavazas->szavazas != 1) {
         $db->setQuery('unlock tables');
         $db->query();
         $db->setQuery('rollback');
         $db->query();
         echo '<h2 class="errorMsg">Wrong status '.$szavazas->megnevezes.'</h2>';
         return;
     }
	 
	 // 2015.07.26. idönként az éles rendszerben előfordul, hogy a JRequest temakor_id üres
	 $temakor_id = $szavazas->temakor_id;
	 
     // user témakör képviselő vagy általános képviselő?
     $db->setQuery('select * from #__kepviselok 
     where kepviselo_id='.$user->id.' and
           (temakor_id='.$db->quote($temakor_id).' or temakor_id = 0)
     ');
     $res = $db->loadObjectList();
     $kepviselo = (count($res) > 0);
     // szavazott már?
     $db->setQuery('select * from #__szavazok where szavazas_id='.$szavazas_id.' and user_id='.$user->id);
     $res = $db->loadObjectList();
     if (count($res)>0) {
         $db->setQuery('unlock tables');
         $db->query();
         $db->setQuery('rollback');
         $db->query();
         echo '<h2 class="errorMsg">Alredy voted</h2>';
         return;
     }
     if (JRequest::getVar($szavazas_secret,'0') == 1) {
        $db->setQuery('select * from #__alternativak where szavazas_id='.$szavazas_id);
        $alternativak = $db->loadObjectList();
        if (($szavazas->titkos == 0) |
            (($szavazas->titkos == 1) and ($kepviselo)))
            $user_id = $user->id;
        else
            $user_id = 0;     
  
        // szavazo_id képzése. 
        $db->setQuery('select max(szavazo_id) szavazo_id from #__szavazatok');
        $res = $db->loadObject();
        if ($res) {
          $szavazo_id = $res->szavazo_id + 1;
        }  
        if ($szavazo_id == 0) {
            $db->setQuery('unlock tables');
            $db->query();
            $db->setQuery('rollback');
            $db->query();
            echo '<h2 class="errorMsg">Error in save vote (5). Pleas try again</h2>';
            return;
        }
        // írás a szavazatok táblába
        foreach ($alternativak as $alternativa) {
          $pozicio = JRequest::getVar('pos'.$alternativa->id,0);
          $db->setQuery('insert into #__szavazatok 
            	(`temakor_id`,`szavazas_id`,`szavazo_id`,`user_id`,`alternativa_id`,`pozicio`	)
            	values
            	("'.$temakor_id.'", 
            	 "'.$szavazas_id.'", 
            	 "'.$szavazo_id.'", 
            	 "'.$user_id.'", 
            	 "'.$alternativa->id.'", 
            	 "'.$pozicio.'");
           ');
           if (!$db->query()) {
                 $db->setQuery('unlock tables');
                 $db->query();
                 $db->setQuery('rollback');
                 $db->query();
                 echo '<h2 class="errorMsg">Error in save vote (6). Pleas try again</h2>';
                 return;
           }
        }
        
        // szavazok táblába írás, a titkositás érdekében itt nem felvitel 
        // sorrendben vannak a rekordok
        $db->setQuery('select id from #__szavazok where szavazas_id =0 order by id');
        $res = $db->loadObjectList();
        if (count($res) > 0) {
          $i = rand(0, count($res) - 1);
          $id = $res[$i]->id;
        } else {
          $imax = rand(2,20);
          for ($i=0; $i<$imax; $i++) {
            $db->setQuery('insert into #__szavazok values (0,0,0,0,0,0)');
            if (!$db->query()) {
                 $db->setQuery('unlock tables');
                 $db->query();
                 $db->setQuery('rollback');
                 $db->query();
                 echo '<h2 class="errorMsg">Error in save vote (7). Pleas try again</h2>';
                 return;
            }
          } 
          $db->setQuery('select id from #__szavazok where szavazas_id =0 order by id');
          $res = $db->loadObjectList();
          if (count($res) > 0) {
            $i = rand(0, count($res) - 1);
            $id = $res[$i]->id;
          } else {
            $id = 0;
          }    
        }
        if ($id==0) {
           $db->setQuery('unlock tables');
           $db->query();
           $db->setQuery('rollback');
           $db->query();
           echo '<h2 class="errorMsg">Error in save vote (8). Pleas try again</h2>';
           return;
        }  
        $db->setQuery('update #__szavazok
        set temakor_id="'.$temakor_id.'",
        szavazas_id="'.$szavazas_id.'",
        user_id="'.$user->id.'",
        idopont="'.date('Y-m-d H:i:s').'"
        where id="'.$id.'"
        ');
        if (!$db->query()) {
                 $db->setQuery('unlock tables');
                 $db->query();
                 $db->setQuery('rollback');
                 $db->query();
                 echo '<h2 class="errorMsg">Error in save vote (9). Pleas try again</h2>';
                 return;
        }
        // unlock, commit
        $db->setQuery('unlock tables');
        $db->query();
        $db->setQuery('commit');
        $db->query();
        $this->setMessage(JText::_('SZAVAZATTAROLVA'));
  
        $this->setRedirect(JURI::base().'index.php?option=com_alternativak&view=alternativaklist'.
          '&temakor='.$temakor_id.
          '&szavazas='.$szavazas_id);
        $this->redirect();
     } else {
       echo '<div class="errorMsg">Access denied wrong secret_key.</div>
       ';
       return;
     }
   }
   /**
    * saját leadott szavazatom lekérdezése
    * @Jrequest integer temakor  
    * @Jrequest integer szavazas
    * @return void
    */
    public function szinfo() {
     $db = JFactory::getDBO();
     $temakor_id = JRequest::getVar('temakor','0');
     $szavazas_id = JRequest::getVar('szavazas','0');
     $nick = JRequest::getvar('nick');
     $user = JFactory::getUser();
     if (($user->id == 0) | ($szavazas_id == 0)) {
        echo '<div class="errorMsg">Access denied.</div>';
        return;
     }
     $this->view->set('Temakor_id',$temakor_id);
     $this->view->set('Szavazas_id',$szavazas_id);
     $this->view->set('SzavazasModja','Te sem közvetlenül, sem közvetetten (képviselő által) nem szavaztál ebben a kérdésben.');
     $this->view->set('Kepviselok','');
     $this->view->set('LeadottSzavazat','');
     $db->setQuery('select * from #__szavazasok where id='.$szavazas_id);
     $szavazas = $db->loadObject();
     if ($szavazas) {
       $db->setQuery('select * 
       from #__szavazok 
       where szavazas_id='.$szavazas_id.' and user_id='.$user->id);
       $szavazok = $db->loadObject();
       if ($szavazok) {
          if ($szavazok->kepviselo_id == 0) {
             $this->view->set('SzavazasModja','Te közvetlenül szavaztál ebben a kérdésben.');
          } else {
             $this->view->set('SzavazasModja','Te képviselő által, közvetve szavaztál ebben a kérdésben:');
             $this->view->set('Kepviselok',
               $this->model->getKepviselok($szavazas_id, $szavazok->kepviselo_id)
             );
          }
          $db->setQuery('select sz.pozicio, sz.alternativa_id, a.megnevezes 
          from #__szavazatok sz
          inner join #__alternativak a on a.id = sz.alternativa_id
          where sz.szavazas_id='.$szavazas_id.' and sz.user_id='.$user->id.'
          order by 1');
          $szavazatok = $db->loadObjectList();
          $this->view->set('LeadottSzavazat','A leadott konkrét szavazatról nincs információ tárolva.');
          $s = '';
          foreach ($szavazatok as $szavazat) {
            $s .= $szavazat->pozicio.'. '.$szavazat->megnevezes.'<br />';
          }
          $this->view->set('LeadottSzavazat',$s);
       }
     }
     $this->view->setLayout('szinfo');
     $this->view->display();
    }                        
   /**
    * leadott nyilt szavazatok lekérdezése
    * @Jrequest integer temakor  
    * @Jrequest integer szavazas
    * @return void
    */
    public function szavazatok() {
     $db = JFactory::getDBO();
     $temakor_id = JRequest::getVar('temakor','0');
     $szavazas_id = JRequest::getVar('szavazas','0');
     $nick = JRequest::getvar('nick');
     $user = JFactory::getUser();
     if (($user->id == 0) | ($szavazas_id == 0)) {
        echo '<div class="errorMsg">Access denied.</div>';
        return;
     }
     $this->view->set('Temakor_id',$temakor_id);
     $this->view->set('Szavazas_id',$szavazas_id);
     $db->setQuery('select * from #__szavazasok where id='.$szavazas_id);
     $szavazas = $db->loadObject();
     if ($szavazas) {
       /*
       $db->setQuery('select u.name, sz.szavazo_id, sz.pozicio, a.megnevezes alternativa 
       from #__szavazatok sz
       left outer join #__szavazok szo on szo.user_id = sz.user_id and szo.szavazas_id = sz.szavazas_id 
       left outer join #__users u on sz.user_id = u.id 
       left outer join #__alternativak a on sz.alternativa_id = a.id
       where  sz.szavazas_id='.$szavazas_id.' and sz.user_id > 0 and szo.kepviselo_id = 0
       union all
       select * from (
       select concat("(",count(sz.szavazo_id),")&gt;",u.name), szo.kepviselo_id, sz.pozicio, a.megnevezes alternativa
       from #__szavazatok sz
       left outer join #__szavazok szo on szo.user_id = sz.user_id and szo.szavazas_id = sz.szavazas_id 
       left outer join #__users u on szo.kepviselo_id = u.id 
       left outer join #__alternativak a on sz.alternativa_id = a.id
       where  sz.szavazas_id='.$szavazas_id.' and sz.user_id > 0 and szo.kepviselo_id > 0      
       group by u.name, szo.kepviselo_id, sz.pozicio, a.megnevezes
       ) w
       order by 1,2,3');
       */
       $db->setQuery('select  name, kepviselo_id, pozicio, alternativa, count(user_id) darab
       from (
       select u.username as name, sz.user_id kepviselo_id, sz.user_id user_id, sz.pozicio, a.megnevezes alternativa 
       from #__szavazatok sz
       left outer join #__szavazok szo on szo.user_id = sz.user_id and szo.szavazas_id = sz.szavazas_id 
       left outer join #__users u on sz.user_id = u.id 
       left outer join #__alternativak a on sz.alternativa_id = a.id
       where  sz.szavazas_id='.$szavazas_id.' and sz.user_id > 0 and szo.kepviselo_id = 0
       union all
       select u.username, szo.kepviselo_id kepviselo_id, sz.user_id user_id, sz.pozicio, a.megnevezes alternativa 
       from #__szavazatok sz
       left outer join #__szavazok szo on szo.user_id = sz.user_id and szo.szavazas_id = sz.szavazas_id 
       left outer join #__users u on szo.kepviselo_id = u.id 
       left outer join #__alternativak a on sz.alternativa_id = a.id
       where  sz.szavazas_id='.$szavazas_id.' and sz.user_id > 0 and szo.kepviselo_id > 0
       union all
       select concat("eMail-",sz.szavazo_id), sz.szavazo_id, sz.szavazo_id, sz.pozicio, a.megnevezes alternativa 
       from #__szavazatok sz
       left outer join #__alternativak a on sz.alternativa_id = a.id
       where  sz.szavazas_id='.$szavazas_id.' and sz.user_id = 0 
       ) w
       group by name, kepviselo_id, pozicio, alternativa
       order by 1,2,3
       ');
       $szavazatok = $db->loadObjectList();
       $this->view->set('Szavazatok',$szavazatok);
     }
     $this->view->setLayout('szinfo2');
     $this->view->display();
    }
 	/**
	 * szavazhatok task
	 * @return void
	 * @request integer limit
	 * @request integer limitstart
	 * @request integer order
	 * @request integer filterStr
	 * @session object 'temakoroklist_status'   
	 */                     
  public function szavazhatok() {
    jimport('hs.user.user');
    JHTML::_('behavior.modal'); 
    $total = 0;
    $pagination = null;
    $user = JFactory::getUser();
    $db = JFactory::getDBO();

    // hozzáférés ellenörzés
    if ($user->id == 0) {
        $this->temakorokHelper->getLogin(JText::_('JELENTKEZZBE'));
    }

    // alapértelmezett browser status beolvasása sessionból
    $session = JFactory::getSession();
    $brStatusStr = '{"limit":20,"limitstart":0,"order":1,"filterStr":"|1"}';
    $brStatus = JSON_decode($brStatus);
    
    $limitStart = JRequest::getVar('limitstart',$brStatus->limitstart);
    $limit = JRequest::getVar('limit',$brStatus->limit);
    $order = JRequest::getVar('order',$brStatus->order);
    $filterStr = urldecode(JRequest::getVar('filterStr',$brStatus->filterStr));
    if ($this->temakor_id=='') $this->temakor_id = $brStatus->temakor_id;
    JRequest::setVar('limit',$limit);
    JRequest::setVar('limitstart',$limitStart);
    JRequest::setVar('order',$order);
    JRequest::setVar('filterStr',$filterStr);
    JRequest::setVar('temakor',$this->temakor_id);

    // adattábla tartalom elérése és átadása a view -nek
    $items = $this->model->getItems();
    if ($this->model->getDBO()->getErrorNum() > 0) $this->model->getDBO()->stderr();
    if ($this->model->getError() != '')
      $this->view->Msg = $this->model->getError();
    $this->view->set('Items',$items);
    $this->view->set('Title',JText::_('SZAVAZHATOK'));
    
    // browser müködéshez linkek definiálása
    $reorderLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view=szavazhatok&task=szavazhatok'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&filterStr='.urlencode($filterStr).
       '&temakor='.$this->temakor_id;
    $doFilterLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view=szavazhatok&task=szavazhatok'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&order='.JRequest::getVar('order','1').
       '&temakor='.$this->temakor_id;
    //$itemLink =
    //   JURI::base().'index.php?option=com_alternativak&view=alternativaklist'.
    //   '&task=browse'.
    //   '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
    //   '&filterStr='.urlencode($filterStr).
    //   '&order='.JRequest::getVar('order','1');
	$itemLink =
       JURI::base().'SU/alternativak/alternativaklist/browse/'.
       $this->temakor_id.'/szavazas/'.
	   JRequest::getVar('limit','20').'/0/'.
       JRequest::getVar('order','1').'/'.
       urlencode($filterStr);
	   

	   $backLink =
       JURI::base().'index.php?option=com_temakorok&view=temakoroklist'.
       '&task=browse';
       
    $this->view->set('reorderLink',$reorderLink);
    $this->view->set('doFilterLink',$doFilterLink);
    $this->view->set('itemLink',$itemLink);
    $this->view->set('backLink',$backLink);
    $this->view->set('temakorLink',$temakorLink);
    
    // kik a szavazaás felvivők?
    $szavazas_felvivo = $this->szavazas_felvivo();

    // akciók definiálása
    $akciok = array();
    $this->view->set('Akciok',$akciok);
    
    //lapozósor definiálása
    jimport( 'joomla.html.pagination' );    
    $total = $this->model->getTotal($filterStr);
    $pagination = new JPagination($total, $limitStart, $limit);
    $pagination->setAdditionalUrlParam('order',$order);
    $pagination->setAdditionalUrlParam('filterStr',urlencode($filterStr));
    $this->view->set('LapozoSor', $pagination->getListFooter());
    
    $this->view->display();
  } // szavazhatok task
 
     /**
	 * szavazasok ahol a vita folyik task
	 * @return void
	 * @request integer limit
	 * @request integer limitstart
	 * @request integer order
	 * @request integer filterStr
	 * @session object 'temakoroklist_status'   
	 */                     
  public function vita() {
    jimport('hs.user.user');
    JHTML::_('behavior.modal'); 
    $total = 0;
    $pagination = null;
    $user = JFactory::getUser();
    $db = JFactory::getDBO();

    // hozzáférés ellenörzés
    if ($user->id == 0) {
        $this->temakorokHelper->getLogin(JText::_('JELENTKEZZBE'));
    }

    // alapértelmezett browser status beolvasása sessionból
    $session = JFactory::getSession();
    $brStatusStr = '{"limit":20,"limitstart":0,"order":1,"filterStr":"|1"}';
    $brStatus = JSON_decode($brStatus);
    
    $limitStart = JRequest::getVar('limitstart',$brStatus->limitstart);
    $limit = JRequest::getVar('limit',$brStatus->limit);
    $order = JRequest::getVar('order',$brStatus->order);
    $filterStr = urldecode(JRequest::getVar('filterStr',$brStatus->filterStr));
    if ($this->temakor_id=='') $this->temakor_id = $brStatus->temakor_id;
    JRequest::setVar('limit',$limit);
    JRequest::setVar('limitstart',$limitStart);
    JRequest::setVar('order',$order);
    JRequest::setVar('filterStr',$filterStr);
    JRequest::setVar('temakor',$this->temakor_id);

    // adattábla tartalom elérése és átadása a view -nek
    $items = $this->model->getItems();
    if ($this->model->getDBO()->getErrorNum() > 0) $this->model->getDBO()->stderr();
    if ($this->model->getError() != '')
      $this->view->Msg = $this->model->getError();
    $this->view->set('Items',$items);
    $this->view->set('Title',JText::_('SZAVAZASOK_VITA'));
    
    // browser müködéshez linkek definiálása
    $reorderLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view=vita&task=vita'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&filterStr='.urlencode($filterStr).
       '&temakor='.$this->temakor_id;
    $doFilterLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view=vita&task=vita'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&order='.JRequest::getVar('order','1').
       '&temakor='.$this->temakor_id;
    //$itemLink =
    //   JURI::base().'index.php?option=com_alternativak&view=alternativaklist'.
    //   '&task=browse'.
    //   '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
    //   '&filterStr='.urlencode($filterStr).
    //   '&order='.JRequest::getVar('order','1');
	$itemLink =
       JURI::base().'SU/alternativak/alternativaklist/browse/'.
       $this->temakor_id.'/szavazas/'.
	   JRequest::getVar('limit','20').'/0/'.
       JRequest::getVar('order','1').'/'.
       urlencode($filterStr);
	   
    $backLink =
       JURI::base().'index.php?option=com_temakorok&view=temakoroklist'.
       '&task=browse';
       
    $this->view->set('reorderLink',$reorderLink);
    $this->view->set('doFilterLink',$doFilterLink);
    $this->view->set('itemLink',$itemLink);
    $this->view->set('backLink',$backLink);
    $this->view->set('temakorLink',$temakorLink);
    
    // kik a szavazaás felvivők?
    $szavazas_felvivo = $this->szavazas_felvivo();

    // akciók definiálása
    $akciok = array();
    $this->view->set('Akciok',$akciok);
    
    //lapozósor definiálása
    jimport( 'joomla.html.pagination' );    
    $total = $this->model->getTotal($filterStr);
    $pagination = new JPagination($total, $limitStart, $limit);
    $pagination->setAdditionalUrlParam('order',$order);
    $pagination->setAdditionalUrlParam('filterStr',urlencode($filterStr));
    $this->view->set('LapozoSor', $pagination->getListFooter());
    
    $this->view->display();
  } // vita

     /**
	 * szavazasok amik vita1 állapotban vannak
	 * @return void
	 * @request integer limit
	 * @request integer limitstart
	 * @request integer order
	 * @request integer filterStr
	 * @session object 'temakoroklist_status'   
	 */                     
  public function vita_alt() {
    jimport('hs.user.user');
    JHTML::_('behavior.modal'); 
    $total = 0;
    $pagination = null;
    $user = JFactory::getUser();
    $db = JFactory::getDBO();

    // alapértelmezett browser status beolvasása sessionból
    $session = JFactory::getSession();
    $brStatusStr = '{"limit":20,"limitstart":0,"order":1,"filterStr":"|1"}';
    $brStatus = JSON_decode($brStatus);
    
    $limitStart = JRequest::getVar('limitstart',$brStatus->limitstart);
    $limit = JRequest::getVar('limit',$brStatus->limit);
    $order = JRequest::getVar('order',$brStatus->order);
    $filterStr = urldecode(JRequest::getVar('filterStr',$brStatus->filterStr));
    if ($this->temakor_id=='') $this->temakor_id = $brStatus->temakor_id;
    JRequest::setVar('limit',$limit);
    JRequest::setVar('limitstart',$limitStart);
    JRequest::setVar('order',$order);
    JRequest::setVar('filterStr',$filterStr);
    JRequest::setVar('temakor',$this->temakor_id);

    // adattábla tartalom elérése és átadása a view -nek
    $items = $this->model->getItems();
    if ($this->model->getDBO()->getErrorNum() > 0) $this->model->getDBO()->stderr();
    if ($this->model->getError() != '')
      $this->view->Msg = $this->model->getError();
  
    $this->view->set('Items',$items);
    $this->view->set('Title',JText::_('SZAVAZASOK_VITA1'));
    
    // browser müködéshez linkek definiálása
    $reorderLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view=vita_alt&task=vita_alt'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&filterStr='.urlencode($filterStr).
       '&temakor='.$this->temakor_id;
    $doFilterLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view=vita_alt&task=vita_alt'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&order='.JRequest::getVar('order','1').
       '&temakor='.$this->temakor_id;
    //$itemLink =
    //   JURI::base().'index.php?option=com_alternativak&view=alternativaklist'.
    //   '&task=browse'.
    //   '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
    //   '&filterStr='.urlencode($filterStr).
    //   '&order='.JRequest::getVar('order','1');
	$itemLink =
       JURI::base().'SU/alternativak/alternativaklist/browse/'.
       $this->temakor_id.'/szavazas/'.
	   JRequest::getVar('limit','20').'/0/'.
       JRequest::getVar('order','1').'/'.
       urlencode($filterStr);
	   
    $backLink =
       JURI::base().'index.php?option=com_temakorok&view=temakoroklist'.
       '&task=browse';
       
    $this->view->set('reorderLink',$reorderLink);
    $this->view->set('doFilterLink',$doFilterLink);
    $this->view->set('itemLink',$itemLink);
    $this->view->set('backLink',$backLink);
    $this->view->set('temakorLink',$temakorLink);
    
    // kik a szavazaás felvivők?
    $szavazas_felvivo = $this->szavazas_felvivo();

    // akciók definiálása
    $akciok = array();
    $this->view->set('Akciok',$akciok);
    
    //lapozósor definiálása
    jimport( 'joomla.html.pagination' );    
    $total = $this->model->getTotal($filterStr);
    $pagination = new JPagination($total, $limitStart, $limit);
    $pagination->setAdditionalUrlParam('order',$order);
    $pagination->setAdditionalUrlParam('filterStr',urlencode($filterStr));
    $this->view->set('LapozoSor', $pagination->getListFooter());
    
    $this->view->display();
  } // vita1

     /**
	 * szavazasok amik vita2 állapotban vannak
	 * @return void
	 * @request integer limit
	 * @request integer limitstart
	 * @request integer order
	 * @request integer filterStr
	 * @session object 'temakoroklist_status'   
	 */                     
  public function vita_too() {
    jimport('hs.user.user');
    JHTML::_('behavior.modal'); 
    $total = 0;
    $pagination = null;
    $user = JFactory::getUser();
    $db = JFactory::getDBO();

    // alapértelmezett browser status beolvasása sessionból
    $session = JFactory::getSession();
    $brStatusStr = '{"limit":20,"limitstart":0,"order":1,"filterStr":"|1"}';
    $brStatus = JSON_decode($brStatus);
    
    $limitStart = JRequest::getVar('limitstart',$brStatus->limitstart);
    $limit = JRequest::getVar('limit',$brStatus->limit);
    $order = JRequest::getVar('order',$brStatus->order);
    $filterStr = urldecode(JRequest::getVar('filterStr',$brStatus->filterStr));
    if ($this->temakor_id=='') $this->temakor_id = $brStatus->temakor_id;
    JRequest::setVar('limit',$limit);
    JRequest::setVar('limitstart',$limitStart);
    JRequest::setVar('order',$order);
    JRequest::setVar('filterStr',$filterStr);
    JRequest::setVar('temakor',$this->temakor_id);

    // adattábla tartalom elérése és átadása a view -nek
    $items = $this->model->getItems();
    if ($this->model->getDBO()->getErrorNum() > 0) $this->model->getDBO()->stderr();
    if ($this->model->getError() != '')
      $this->view->Msg = $this->model->getError();
  
    $this->view->set('Items',$items);
    $this->view->set('Title',JText::_('SZAVAZASOK_VITA2'));
    
    // browser müködéshez linkek definiálása
    $reorderLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view=vita_too&task=vita_too'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&filterStr='.urlencode($filterStr).
       '&temakor='.$this->temakor_id;
    $doFilterLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view=vita_too&task=vita_too'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&order='.JRequest::getVar('order','1').
       '&temakor='.$this->temakor_id;
    //$itemLink =
    //   JURI::base().'index.php?option=com_alternativak&view=alternativaklist'.
    //   '&task=browse'.
    //   '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
    //   '&filterStr='.urlencode($filterStr).
    //   '&order='.JRequest::getVar('order','1');
	$itemLink =
       JURI::base().'SU/alternativak/alternativaklist/browse/'.
       $this->temakor_id.'/szavazas/'.
	   JRequest::getVar('limit','20').'/0/'.
       JRequest::getVar('order','1').'/'.
       urlencode($filterStr);
	   
    $backLink =
       JURI::base().'index.php?option=com_temakorok&view=temakoroklist'.
       '&task=browse';
       
    $this->view->set('reorderLink',$reorderLink);
    $this->view->set('doFilterLink',$doFilterLink);
    $this->view->set('itemLink',$itemLink);
    $this->view->set('backLink',$backLink);
    $this->view->set('temakorLink',$temakorLink);
    
    // kik a szavazaás felvivők?
    $szavazas_felvivo = $this->szavazas_felvivo();

    // akciók definiálása
    $akciok = array();
    $this->view->set('Akciok',$akciok);
    
    //lapozósor definiálása
    jimport( 'joomla.html.pagination' );    
    $total = $this->model->getTotal($filterStr);
    $pagination = new JPagination($total, $limitStart, $limit);
    $pagination->setAdditionalUrlParam('order',$order);
    $pagination->setAdditionalUrlParam('filterStr',urlencode($filterStr));
    $this->view->set('LapozoSor', $pagination->getListFooter());
    
    $this->view->display();
  } // vita_too

     /**
	 * szavazasok amik szavazas állapotban vannak
	 * @return void
	 * @request integer limit
	 * @request integer limitstart
	 * @request integer order
	 * @request integer filterStr
	 * @session object 'temakoroklist_status'   
	 */                     
  public function szavazas_folyik() {
    jimport('hs.user.user');
    JHTML::_('behavior.modal'); 
    $total = 0;
    $pagination = null;
    $user = JFactory::getUser();
    $db = JFactory::getDBO();

    // alapértelmezett browser status beolvasása sessionból
    $session = JFactory::getSession();
    $brStatusStr = '{"limit":20,"limitstart":0,"order":1,"filterStr":"|1"}';
    $brStatus = JSON_decode($brStatus);
    
    $limitStart = JRequest::getVar('limitstart',$brStatus->limitstart);
    $limit = JRequest::getVar('limit',$brStatus->limit);
    $order = JRequest::getVar('order',$brStatus->order);
    $filterStr = urldecode(JRequest::getVar('filterStr',$brStatus->filterStr));
    if ($this->temakor_id=='') $this->temakor_id = $brStatus->temakor_id;
    JRequest::setVar('limit',$limit);
    JRequest::setVar('limitstart',$limitStart);
    JRequest::setVar('order',$order);
    JRequest::setVar('filterStr',$filterStr);
    JRequest::setVar('temakor',$this->temakor_id);

    // adattábla tartalom elérése és átadása a view -nek
    $items = $this->model->getItems();
    if ($this->model->getDBO()->getErrorNum() > 0) $this->model->getDBO()->stderr();
    if ($this->model->getError() != '')
      $this->view->Msg = $this->model->getError();
  
    $this->view->set('Items',$items);
    $this->view->set('Title',JText::_('SZAVAZASOK_SZAVAZAS'));
    
    // browser müködéshez linkek definiálása
    $reorderLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view=szavazas_folyik&task=szavazas_folyik'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&filterStr='.urlencode($filterStr).
       '&temakor='.$this->temakor_id;
    $doFilterLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view=szavazas_folyik&task=szavazas_folyik'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&order='.JRequest::getVar('order','1').
       '&temakor='.$this->temakor_id;
    //$itemLink =
    //   JURI::base().'index.php?option=com_alternativak&view=alternativaklist'.
    //   '&task=browse'.
    //   '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
    //   '&filterStr='.urlencode($filterStr).
    //   '&order='.JRequest::getVar('order','1');
	$itemLink =
       JURI::base().'SU/alternativak/alternativaklist/browse/'.
       $this->temakor_id.'/szavazas/'.
	   JRequest::getVar('limit','20').'/0/'.
       JRequest::getVar('order','1').'/'.
       urlencode($filterStr);
	   
    $backLink =
       JURI::base().'index.php?option=com_temakorok&view=temakoroklist'.
       '&task=browse';
       
    $this->view->set('reorderLink',$reorderLink);
    $this->view->set('doFilterLink',$doFilterLink);
    $this->view->set('itemLink',$itemLink);
    $this->view->set('backLink',$backLink);
    $this->view->set('temakorLink',$temakorLink);
    
    // kik a szavazaás felvivők?
    $szavazas_felvivo = $this->szavazas_felvivo();

    // akciók definiálása
    $akciok = array();
    $this->view->set('Akciok',$akciok);
    
    //lapozósor definiálása
    jimport( 'joomla.html.pagination' );    
    $total = $this->model->getTotal($filterStr);
    $pagination = new JPagination($total, $limitStart, $limit);
    $pagination->setAdditionalUrlParam('order',$order);
    $pagination->setAdditionalUrlParam('filterStr',urlencode($filterStr));
    $this->view->set('LapozoSor', $pagination->getListFooter());
    
    $this->view->display();
  } // szavazas_folyik

     /**
	 * szavazasok amik lezárt állapotban vannak
	 * @return void
	 * @request integer limit
	 * @request integer limitstart
	 * @request integer order
	 * @request integer filterStr
	 * @session object 'temakoroklist_status'   
	 */                     
  public function lezart() {
    jimport('hs.user.user');
    JHTML::_('behavior.modal'); 
    $total = 0;
    $pagination = null;
    $user = JFactory::getUser();
    $db = JFactory::getDBO();

    // alapértelmezett browser status beolvasása sessionból
    $session = JFactory::getSession();
    $brStatusStr = '{"limit":20,"limitstart":0,"order":1,"filterStr":"|1"}';
    $brStatus = JSON_decode($brStatus);
    
    $limitStart = JRequest::getVar('limitstart',$brStatus->limitstart);
    $limit = JRequest::getVar('limit',$brStatus->limit);
    $order = JRequest::getVar('order',$brStatus->order);
    $filterStr = urldecode(JRequest::getVar('filterStr',$brStatus->filterStr));
    if ($this->temakor_id=='') $this->temakor_id = $brStatus->temakor_id;
    JRequest::setVar('limit',$limit);
    JRequest::setVar('limitstart',$limitStart);
    JRequest::setVar('order',$order);
    JRequest::setVar('filterStr',$filterStr);
    JRequest::setVar('temakor',$this->temakor_id);

    // adattábla tartalom elérése és átadása a view -nek
    $items = $this->model->getItems();
    //DBG echo 'lezart count='.count($items).'<br>';
    if ($this->model->getDBO()->getErrorNum() > 0) $this->model->getDBO()->stderr();
    if ($this->model->getError() != '')
      $this->view->Msg = $this->model->getError();
  
    $this->view->set('Items',$items);
    $this->view->set('Title',JText::_('SZAVAZASOK_LEZART'));
    
    // browser müködéshez linkek definiálása
    $reorderLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view=lezart&task=lezart'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&filterStr='.urlencode($filterStr).
       '&temakor='.$this->temakor_id;
    $doFilterLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view=lezart&task=lezart'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&order='.JRequest::getVar('order','1').
       '&temakor='.$this->temakor_id;
    //$itemLink =
    //   JURI::base().'index.php?option=com_alternativak&view=alternativaklist'.
    //   '&task=browse'.
    //   '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
    //   '&filterStr='.urlencode($filterStr).
    //   '&order='.JRequest::getVar('order','1');
	$itemLink =
       JURI::base().'SU/alternativak/alternativaklist/browse/'.
       $this->temakor_id.'/szavazas/'.
	   JRequest::getVar('limit','20').'/0/'.
       JRequest::getVar('order','1').'/'.
       urlencode($filterStr);
	   
    $backLink =
       JURI::base().'index.php?option=com_temakorok&view=temakoroklist'.
       '&task=browse';
       
    $this->view->set('reorderLink',$reorderLink);
    $this->view->set('doFilterLink',$doFilterLink);
    $this->view->set('itemLink',$itemLink);
    $this->view->set('backLink',$backLink);
    $this->view->set('temakorLink',$temakorLink);
    
    // kik a szavazaás felvivők?
    $szavazas_felvivo = $this->szavazas_felvivo();

    // akciók definiálása
    $akciok = array();
    $this->view->set('Akciok',$akciok);
    
    //lapozósor definiálása
    jimport( 'joomla.html.pagination' );    
    $total = $this->model->getTotal($filterStr);
    $pagination = new JPagination($total, $limitStart, $limit);
    $pagination->setAdditionalUrlParam('order',$order);
    $pagination->setAdditionalUrlParam('filterStr',urlencode($filterStr));
    $this->view->set('LapozoSor', $pagination->getListFooter());
    //DBG echo 'total='.$total.'<br>';
    $this->view->display();
  } // lezart

     /**
	 * szavazasok amik publikalandóak
	 * @return void
	 * @request integer limit
	 * @request integer limitstart
	 * @request integer order
	 * @request integer filterStr
	 * @session object 'temakoroklist_status'   
	 */                     
  public function publikalandok() {
    jimport('hs.user.user');
    JHTML::_('behavior.modal'); 
    $total = 0;
    $pagination = null;
    $user = JFactory::getUser();
    $db = JFactory::getDBO();

    // alapértelmezett browser status beolvasása sessionból
    $session = JFactory::getSession();
    $brStatusStr = '{"limit":20,"limitstart":0,"order":1,"filterStr":"|1"}';
    $brStatus = JSON_decode($brStatus);
    
    $limitStart = JRequest::getVar('limitstart',$brStatus->limitstart);
    $limit = JRequest::getVar('limit',$brStatus->limit);
    $order = JRequest::getVar('order',$brStatus->order);
    $filterStr = urldecode(JRequest::getVar('filterStr',$brStatus->filterStr));
    if ($this->temakor_id=='') $this->temakor_id = $brStatus->temakor_id;
    JRequest::setVar('limit',$limit);
    JRequest::setVar('limitstart',$limitStart);
    JRequest::setVar('order',$order);
    JRequest::setVar('filterStr',$filterStr);
    JRequest::setVar('temakor',$this->temakor_id);

    // adattábla tartalom elérése és átadása a view -nek
    $items = $this->model->getItems();
    //DBG echo 'lezart count='.count($items).'<br>';
    if ($this->model->getDBO()->getErrorNum() > 0) $this->model->getDBO()->stderr();
    if ($this->model->getError() != '')
      $this->view->Msg = $this->model->getError();
  
    $this->view->set('Items',$items);
    $this->view->set('Title',JText::_('SZAVAZASOK_PUBLIKALANDOK'));
    
    // browser müködéshez linkek definiálása
    $reorderLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view=publikalandok&task=publikalandok'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&filterStr='.urlencode($filterStr).
       '&temakor='.$this->temakor_id;
    $doFilterLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view=publikalandok&task=publikalandok'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&order='.JRequest::getVar('order','1').
       '&temakor='.$this->temakor_id;
    //$itemLink =
    //   JURI::base().'index.php?option=com_alternativak&view=alternativaklist'.
    //   '&task=browse'.
    //   '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
    //   '&filterStr='.urlencode($filterStr).
    //   '&order='.JRequest::getVar('order','1');
	$itemLink =
       JURI::base().'SU/alternativak/alternativaklist/browse/'.
       $this->temakor_id.'/szavazas/'.
	   JRequest::getVar('limit','20').'/0/'.
       JRequest::getVar('order','1').'/'.
       urlencode($filterStr);
	   
    $backLink =
       JURI::base().'index.php?option=com_temakorok&view=temakoroklist'.
       '&task=browse';
       
    $this->view->set('reorderLink',$reorderLink);
    $this->view->set('doFilterLink',$doFilterLink);
    $this->view->set('itemLink',$itemLink);
    $this->view->set('backLink',$backLink);
    $this->view->set('temakorLink',$temakorLink);

	// kik a szavazaás felvivők?
    $szavazas_felvivo = $this->szavazas_felvivo();

    // akciók definiálása
    $akciok = array();
    $this->view->set('Akciok',$akciok);
    
    //lapozósor definiálása
    jimport( 'joomla.html.pagination' );    
    $total = $this->model->getTotal($filterStr);
    $pagination = new JPagination($total, $limitStart, $limit);
    $pagination->setAdditionalUrlParam('order',$order);
    $pagination->setAdditionalUrlParam('filterStr',urlencode($filterStr));
    $this->view->set('LapozoSor', $pagination->getListFooter());
    //DBG echo 'total='.$total.'<br>';
    $this->view->display();
  } // publikalando

     /**
	 * elutasitott szavazási javaslatok
	 * @return void
	 * @request integer limit
	 * @request integer limitstart
	 * @request integer order
	 * @request integer filterStr
	 * @session object 'temakoroklist_status'   
	 */                     
  public function elutasitottak() {
    jimport('hs.user.user');
    JHTML::_('behavior.modal'); 
    $total = 0;
    $pagination = null;
    $user = JFactory::getUser();
    $db = JFactory::getDBO();

    // alapértelmezett browser status beolvasása sessionból
    $session = JFactory::getSession();
    $brStatusStr = '{"limit":20,"limitstart":0,"order":1,"filterStr":"|1"}';
    $brStatus = JSON_decode($brStatus);
    
    $limitStart = JRequest::getVar('limitstart',$brStatus->limitstart);
    $limit = JRequest::getVar('limit',$brStatus->limit);
    $order = JRequest::getVar('order',$brStatus->order);
    $filterStr = urldecode(JRequest::getVar('filterStr',$brStatus->filterStr));
    if ($this->temakor_id=='') $this->temakor_id = $brStatus->temakor_id;
    JRequest::setVar('limit',$limit);
    JRequest::setVar('limitstart',$limitStart);
    JRequest::setVar('order',$order);
    JRequest::setVar('filterStr',$filterStr);
    JRequest::setVar('temakor',$this->temakor_id);

    // adattábla tartalom elérése és átadása a view -nek
    $items = $this->model->getItems();
    //DBG echo 'lezart count='.count($items).'<br>';
    if ($this->model->getDBO()->getErrorNum() > 0) $this->model->getDBO()->stderr();
    if ($this->model->getError() != '')
      $this->view->Msg = $this->model->getError();
  
    $this->view->set('Items',$items);
    $this->view->set('Title',JText::_('SZAVAZASOK_ELUTASITVA'));
    
    // browser müködéshez linkek definiálása
    $reorderLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view=elutasitottak&task=elutasitottak'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&filterStr='.urlencode($filterStr).
       '&temakor='.$this->temakor_id;
    $doFilterLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view=elutasitottak&task=elutasitottak'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&order='.JRequest::getVar('order','1').
       '&temakor='.$this->temakor_id;
    //$itemLink =
    //   JURI::base().'index.php?option=com_alternativak&view=alternativaklist'.
    //   '&task=browse'.
    //   '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
    //   '&filterStr='.urlencode($filterStr).
    //   '&order='.JRequest::getVar('order','1');
	$itemLink =
       JURI::base().'SU/alternativak/alternativaklist/browse/'.
       $this->temakor_id.'/szavazas/'.
	   JRequest::getVar('limit','20').'/0/'.
       JRequest::getVar('order','1').'/'.
       urlencode($filterStr);
	   
    $backLink =
       JURI::base().'index.php?option=com_temakorok&view=temakoroklist'.
       '&task=browse';
       
    $this->view->set('reorderLink',$reorderLink);
    $this->view->set('doFilterLink',$doFilterLink);
    $this->view->set('itemLink',$itemLink);
    $this->view->set('backLink',$backLink);
    $this->view->set('temakorLink',$temakorLink);
    
    // kik a szavazaás felvivők?
    $szavazas_felvivo = $this->szavazas_felvivo();

    // akciók definiálása
    $akciok = array();
    $this->view->set('Akciok',$akciok);
    
    //lapozósor definiálása
    jimport( 'joomla.html.pagination' );    
    $total = $this->model->getTotal($filterStr);
    $pagination = new JPagination($total, $limitStart, $limit);
    $pagination->setAdditionalUrlParam('order',$order);
    $pagination->setAdditionalUrlParam('filterStr',urlencode($filterStr));
    $this->view->set('LapozoSor', $pagination->getListFooter());
    //DBG echo 'total='.$total.'<br>';
    $this->view->display();
  } // elutasitottak

  
  
  /**
	 * szavaztam
	 * @return void
	 * @request integer limit
	 * @request integer limitstart
	 * @request integer order
	 * @request integer filterStr
	 * @session object 'temakoroklist_status'   
	 */                     
  public function szavaztam() {
    jimport('hs.user.user');
    JHTML::_('behavior.modal'); 
    $total = 0;
    $pagination = null;
    $user = JFactory::getUser();
    $db = JFactory::getDBO();

    // hozzáférés ellenörzés
    if ($user->id == 0) {
        $this->temakorokHelper->getLogin(JText::_('JELENTKEZZBE'));
    }

    // alapértelmezett browser status beolvasása sessionból
    $session = JFactory::getSession();
    $brStatusStr = '{"limit":20,"limitstart":0,"order":1,"filterStr":"|1"}';
    $brStatus = JSON_decode($brStatus);
    
    $limitStart = JRequest::getVar('limitstart',$brStatus->limitstart);
    $limit = JRequest::getVar('limit',$brStatus->limit);
    $order = JRequest::getVar('order',$brStatus->order);
    $filterStr = urldecode(JRequest::getVar('filterStr',$brStatus->filterStr));
    if ($this->temakor_id=='') $this->temakor_id = $brStatus->temakor_id;
    JRequest::setVar('limit',$limit);
    JRequest::setVar('limitstart',$limitStart);
    JRequest::setVar('order',$order);
    JRequest::setVar('filterStr',$filterStr);
    JRequest::setVar('temakor',$this->temakor_id);

    // adattábla tartalom elérése és átadása a view -nek
    $items = $this->model->getItems();
    if ($this->model->getDBO()->getErrorNum() > 0) $this->model->getDBO()->stderr();
    if ($this->model->getError() != '')
      $this->view->Msg = $this->model->getError();
    $this->view->set('Items',$items);
    $this->view->set('Title',JText::_('SZAVAZASOK_SZAVAZTAM'));
    
    // browser müködéshez linkek definiálása
    $reorderLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view=szavazhatok&task=szavazhatok'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&filterStr='.urlencode($filterStr).
       '&temakor='.$this->temakor_id;
    $doFilterLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view=szavazhatok&task=szavazhatok'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&order='.JRequest::getVar('order','1').
       '&temakor='.$this->temakor_id;
    //$itemLink =
    //   JURI::base().'index.php?option=com_alternativak&view=alternativaklist&task=szavazhatok'.
    //   '&task=browse'.
    //   '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
    //   '&filterStr='.urlencode($filterStr).
    //   '&order='.JRequest::getVar('order','1');
	$itemLink =
       JURI::base().'SU/alternativak/alternativaklist/browse/'.
       $this->temakor_id.'/szavazas/'.
	   JRequest::getVar('limit','20').'/0/'.
       JRequest::getVar('order','1').'/'.
       urlencode($filterStr);
	   
    $backLink =
       JURI::base().'index.php?option=com_temakorok&view=temakoroklist'.
       '&task=browse';
       
    $this->view->set('reorderLink',$reorderLink);
    $this->view->set('doFilterLink',$doFilterLink);
    $this->view->set('itemLink',$itemLink);
    $this->view->set('backLink',$backLink);
    $this->view->set('temakorLink',$temakorLink);
    
    // kik a szavazaás felvivők?
    $szavazas_felvivo = $this->szavazas_felvivo();

    // akciók definiálása
    $akciok = array();
    $this->view->set('Akciok',$akciok);
    
    //lapozósor definiálása
    jimport( 'joomla.html.pagination' );    
    $total = $this->model->getTotal($filterStr);
    $pagination = new JPagination($total, $limitStart, $limit);
    $pagination->setAdditionalUrlParam('order',$order);
    $pagination->setAdditionalUrlParam('filterStr',urlencode($filterStr));
    $this->view->set('LapozoSor', $pagination->getListFooter());
    
    $this->view->display();
  } // szavaztam
  /**
   * levél küldés a szavazásra jogosult usereknek - form  view:emails
   * @JRequest integer szavazas
   * @JRequest integer temakor
   * @NEXTtasks sendemails, com_alternativak.browse    
   */
  public function emailform() {
    $user = JFactory::getUser();
    $db = JFactory::getDBO();
    $db->setQuery('select * from #__szavazasok where id="'.JRequest::getvar('szavazas',0).'"');
    $szavazas = $db->loadObject();
    $temakorModel = new TemakorokModelTemakorok;
    $temakor = $temakorModel->getItem($szavazas->temakor_id);
    $akciok = array();
    $akciok['cancel'] = JURI::base().'index.php?option=com_alternativak&view=alternativaklist&task=browse'.
                     '&temakor='.$szavazas->temakor_id.
                     '&szavazas='.$szavazas->id;
    $akciok['send'] = JURI::base().'index.php?option=com_szavazasok&view=emails&task=sendemails'.
                     '&temakor='.$szavazas->temakor_id.
                     '&szavazas='.$szavazas->id;
    $this->model->deleteOldEmailLog();                 
    $this->view->set('Szavazas',$szavazas);
    $this->view->set('Temakor',$temakor);
    $this->view->set('Akciok',$akciok);
    $this->view->setLayout('form');
    $this->view->display();
  }
  /**
   * levél küldés a szavazásra jogosult usereknek - végrehajtás  view:emails
   * @JRequest integer szavazas
   * @JRequest integer temakor
   * @JRequest integer megnemszavazott   
   * @NEXTtasks com_alternativak.browse    
   */
   public function sendemails() {
      $user = JFactory::getUser();
      $db = JFactory::getDBO();
      $db->setQuery('select * from #__szavazasok where id="'.JRequest::getVar('szavazas',0).'"');
      $szavazas = $db->loadObject();
      $temakorModel = new TemakorokModelTemakorok;
      $temakor = $temakorModel->getItem($szavazas->temakor_id);
      $subject = JRequest::getVar('subject','');
      $mailbody = JRequest::getVar('mailbody','','POST','STRING',JREQUEST_ALLOWHTML);
      echo $mailbosy.'<br />';
      $mailbody = str_replace('href="index.php','href="'.JURI::base().'index.php',$mailbody);
      $this->model->deleteOldEmailLog();                 
      $this->model->sendSzavazasToEmailQue($szavazas, $subject, $mailbody);
      $akciok['back'] = JURI::base().'index.php?option=com_alternativak&view=alternativaklist&task=browse'.
                     '&temakor='.$szavazas->temakor_id.
                     '&szavazas='.$szavazas->id;
      $this->view->set('Szavazas',$szavazas);
      $this->view->set('Temakor',$temakor);
      $this->view->set('Akciok',$akciok);
      $this->view->setLayout('sended');
      $this->view->display();
   }
   /** emailes szavazashoz meghivó levél küldő form
     * JRequest  integer temakor
     * JRequest integer szavazas
     * JRequest string szoveg  opcionális     
     * JRequest string cimek  opcionális     
     * JRequest data kodolt sender email (opcionalis)
     * ha data -ban nem jön küldő email akkor az aktuális user email -t használja
     * feladónak, ha nincs bejelentkezve akkor hibaüzenet                    
     * return void
     */          
   public function meghivo() {
     $temakor = JRequest::getVar('temakor',0);
     $szavazas = JRequest::getVar('szavazas',0);
     $szoveg = JRequest::getVar('szoveg','');
     $cimek = JRequest::getVar('cimek','');
     $data = JRequest::getVar('data','');
     $user = JFactory::getUser();
     $db = JFactory::getDBO();
     $cancelLink = JURI::base().'index.php?option=com_alternativak&alternativaklist&temakor='.$temakor.'&szavazas='.$szavazas;
     $session = JFactory::getSession();
     if ($data != '')
       $felado = decrypt($data,ENCRYPTION_KEY);
     else
       $felado = $user->email;
     if (($felado == '') | ($temakor == 0) | ($szavazas == 0)) {
       echo '<p class="errorMsg">Acces denied temakor:'.$temakor.' szavazas:'.$szavazas.' felado:'.$felado.'</p>';
     } else {
       $db->setQuery('select * from #__szavazasok where id="'.$szavazas.'"');
       $szavazas = $db->loadObject();
       if ($szavazas) {
         $session->set('emailszavazas',$szavazas->id.','.$felado);
         $this->view->set('Temakor',$temakor);
         $this->view->set('Szavazas',$szavazas);
         $this->view->set('Felado',$felado);
         $this->view->set('Cimek',$cimek);
         $this->view->set('Szoveg',$szoveg);
         $this->view->set('CancelLink',$cancelLink);
         $this->view->setLayout('emailmeghivo');
         $this->view->display();
       } else {
         echo '<p class="errorMsg">Acces denied szavzas not found </p>';
       }  
     }
     return;       
   }
   /** emailes szavazas meghivó küldés
    * JRequest integer temakor
    * JRequest integer szavazas
    * JRequest string felado           
    * JRequest string cimek           
    * JRequest string szoveg           
    * session string emailszavazas $szavazasId,felado           
    * return void
    */       
   public function meghivotkuld() {
     $temakor = JRequest::getVar('temakor',0);
     $szavazas = JRequest::getVar('szavazas',0);
     $felado = JRequest::getVar('felado','');
     $cimek = urldecode(JRequest::getVar('cimek',''));
     $cimek = str_replace(',','',$cimek);
     $cimek = explode("\n",trim($cimek."\n"));
     $szoveg = urldecode(JRequest::getVar('szoveg',''));
     $szoveg = strip_tags($szoveg);
     $szoveg = str_replace("\n",'<br />',$szoveg);
     $db = JFactory::getDBO();
     $db->setQuery('select * from #__szavazasok where id="'.$szavazas.'"');
     $szavazas = $db->loadObject();
     $session = JFactory::getSession();
     $mail = JFactory::getMailer();
     $eredmenyLink = JURI::base().'index.php?option=com_alternativak&view=alternativaklist&temakor='.$temakor.'&szavazas='.$szavazas->id;
     $meghivoLink = JURI::base().'index.php?option=com_szavazasok&view=szavazasok'.
       '&task=meghivo&temakor='.$temakor.'&szavazas='.$szavazas->id.
       '&data='.encrypt($felado,ENCRYPTION_KEY);

     // adott meg cimeket?
     if (count($cimek) == 0) {
        echo '<pclass="errormsg">'.JText::_('EMIALES_SZAVAZAS_CIMEK_URES').'</p>';
        JRequest::setVar('data',encrypt($felado,ENCRYPTION_KEY));
        $this->meghivo();
     }
     // max.20 címet adott meg?
     if (count($cimek) > 20) {
        echo '<pclass="errormsg">'.JText::_('EMIALES_SZAVAZAS_SOK_CIM').'</p>';
        JRequest::setVar('data',encrypt($felado,ENCRYPTION_KEY));
        $this->meghivo();
     }
     // ellenörzi a sessiont hogy megfelelő-e?
     if ($session->get('emailszavazas','') != $szavazas->id.','.$felado) {
        echo '<pclass="errormsg">Acces denied wrong session session:'.$session->get('emailszavazas','').' szavazasID:'.$szavazas->id.' felado:'.$felado.'</p>';
        return;
     }

     // cimek kisbetüsitése
     for ($i=0; $i<count($cimek); $i++) {
       $cimek[$i] = trim(strtolower($cimek[$i]));
     }
     // végig nézi a cimeket, hogy nem kaptak-e már meghívó levelet?
     // és nem dupla-e?
     $markapott = 0;
     $elkuldve = 0;
     $dupla = 0;
     $hiba = '';
     for ($i=0; $i<count($cimek); $i++) {
       $j = array_keys($cimek, $cimek[$i]);
       /* dbg
       echo 'array_keys '.$cimek[$i].':';
       foreach($j as $j1) echo $j1.'/';
       echo '<br />';
       */
       if ((count($j) > 1) & ($cimek[$i]!= '')) {
         // dupla
         $cimek[$i] = '';
         $dupla++;
       } else {
         $db->setQuery('select id 
         from #__emailszavazas
         where szavazas="'.$szavazas->id.'" and email="'.trim($cimek[$i]).'"');
         $res = $db->loadObject();
         if ($res) {
           $cimek[$i] = '';
           $markapott++;  
         }
       } // dupla?  
     } // for
     // alternativak beolvasása
     $db->setQuery('SELECT *
     FROM #__alternativak
     WHERE szavazas_id = "'.$szavazas->id.'"');
     $alternativak = $db->loadObjectList();
     //DBG echo $mailBody;
     // elküldi a leveleket és rekordokat ír a #__emailszavazok táblába
     for ($i=0; $i<count($cimek); $i++) {
       if (trim($cimek[$i]) != '') {
          // levél kialakitása
          include JPATH_COMPONENT.'/views/szavazasok/tmpl/emailszavazaslevel.php';
          // levél küldés
          $mail->clearAllRecipients();
          $mail->addRecipient(trim($cimek[$i]));
          $mail->isHTML(true);
          $mail->setBody($mailBody);
          $mail->setSubject($szavazas->megnevezes.' '.JText::_('EMAIL_SZAVAZAS_SUBJECT'));
          // $mail->setSender(array( [0] => $felado [1] => ''));
          if ($mail->send()) {
            // rekord irás a #__emailszavazas táblába
            $db->setQuery('
            INSERT INTO #__emailszavazas	( 
          	`szavazas`, 
          	`email`, 
          	`szavazott`, 
          	`kuldes`, 
          	`szavazasido`, 
          	`meghivo`
          	)
          	VALUES
          	( 
          	"'.$szavazas->id.'", 
          	"'.trim($cimek[$i]).'", 
          	0, 
          	"'.date('Y-m-d H:i:s').'", 
          	"", 
          	"'.$felado.'"
          	);
            ');
            $db->query();
            if ($db->getErrorNum() > 0) $db->sdError();
            $elkuldve++; 
          } else {
            $hiba .= $cimek[$i].' ';
          }
       }
     }

     // képernyő kiirása
     echo '<p><br /><br /><strong>'.JText::_('EMAIL_SZAVAZAS_ELKULDVE').$elkuldve.'</strong></p>';
     if ($markapott > 0)
       echo '<p>'.JText::_('EMAIL_SZAVAZAS_MARKAPOTT').' '.$markapott.'</p>';
     if ($dupla > 0)
       echo '<p>'.JText::_('EMAIL_SZAVAZAS_DUPLA').' '.$dupla.'</p>';
     if ($hiba != 0)
       echo '<p>'.JText::_('EMAIL_SZAVAZAS_HIBA').' '.$hiba.'</p>';
     echo '<p><a href="'.$eredmenyLink.'">'.JText::_('EMAIL_SZAVAZAS_EREDMEnYLINK').'</a></p>';
     echo '<p>'.JText::_('EMAIL_SZAVAZAS_HIVDMEG').'</p>';
     JRequest::setVar('temakor',$temakor);
     JRequest::setVar('szavazas',$szavazas->id);
     JRequest::setVar('data',encrypt($felado,ENCRYPTION_KEY));
     $this->meghivo();
   }
   /** emailes szavazás, szavazat
    * JRequest string data kodolt adat temakorId,szavazasId,alternativaId,szavazoEmail
    * return void       
    */       
   public function emailszavazat() {
     $session = JFactory::getSession();
     $data = JRequest::getVar('data','');
     $data = decrypt($data,ENCRYPTION_KEY);
     $w = explode(",",$data);
     $temakor = $w[0];
     $szavazas = $w[1];
     $alternativa = $w[2];
     $email = $w[3];
     $felado = $w[3];
     $errorMsg = '';
//DBG        
//     echo '<p class="errorMsg">DEBUG '.$data.' / '.$w[0].' / '.$w[1].' / '.$w[2].' / '.$w[3].'</p>';


     $db = JFactory::getDBO();
     // beolvassuk a szavazas rekordot
     $db->setQuery('select * from #__szavazasok where id="'.$szavazas.'"');
     $szavazas = $db->loadObject();
     if ($szavazas == false) {
         echo '<p class="errorMsg">'.JText::_('EMAIL_SZAVAZAS_NEMJOSZAVAZAS').' (1) </p>';
         return;
     }
     // nézzük az email szerepel-e a #__emailszavazas táblában?
     //    ha nem akkor access denied
     $db->setQuery('SELECT *
     FROM #__emailszavazas
     WHERE email="'.$email.'" AND szavazas="'.$szavazas->id.'"');
     $rekord = $db->loadObject();
     if ($rekord == false) {
         echo '<p class="errorMsg">Access denied not saved email vote record</p>';
         return;
     }
     // ha a tábla szerint már szavazott akkor üzenet és meghivó form
     if ($rekord->szavazott == 1) {
       echo '<h1>'.JText::_('EMAIL_SZAVAZAS_MARSZAVAZTAL').' '.$email.'</h1>';
     } else {
       // ha nem emailes szavazas, vagy nem szavazas állapotú akkor hibaüzenet
       if (($szavazas->szavazas != 1) | ($szavazas>szavazok != 2)) {
         echo '<p class="errorMsg">'.JText::_('EMAIL_SZAVAZAS_NEMJOSZAVAZAS').' (2)</p>';
         return;
       }
       // ellenörizzük a témakört
       if ($szavazas->temakor_id != $temakor) {
         echo '<p class="errorMsg">'.JText::_('EMAIL_SZAVAZAS_NEMJOSZAVAZAS').' (3)</p>';
         return;
       }
       // beolvassuk a szavazás alternativáit
       $db->setQuery('SELECT *
       FROM #__alternativak
       WHERE szavazas_id = "'.$szavazas->id.'"');
       $alternativak = $db->loadObjectList();
       // ellenörizzük az alternativa számot
       $jo = false;
       foreach ($alternativak as $alt) {
          if ($alt->id == $alternativa) $jo = true;
       }
       if ($jo == false) {
         echo '<p class="errorMsg">'.JText::_('EMAIL_SZAVAZAS_NEMJOALTERNATIVA').'</p>';
         return;
       }
       // start transaction - tároljuk a szavazatot
       $db->setQuery('start transaction');
       $db->query();
       
       $db->setQuery('unlock tables');
       $db->query();
       $db->setQuery('lock tables #__szavazatok write,
                                #__szavazok write,
                                #__szavazasok read,
                                #__emailszavazas write,
                                #__alternativak read');
       if ($db->query()) {
         // szavazás id képzése
         $db->setQuery('select max(szavazo_id) szavazo_id from #__szavazatok');
         $res = $db->loadObject();
         if ($res == false) {
              $errorMsg = $db->getErrorMsg().'<br />';
              $db->setQuery('rollback');
              $db->setQuery();
              $db->setQuery('unlock tables');
              $db->query();
              
         } else {
           $szavazo_id = $res->szavazo_id + 1;
         };
         // szavazat tárolása
         foreach ($alternativak as $alt) {
           if ($alternativa == $alt->id) {
             $pozicio = 1;
           } else {
             $pozicio = 2;
           }
           $db->setQuery('insert into #__szavazatok 
            	(`temakor_id`,`szavazas_id`,`szavazo_id`,`user_id`,`alternativa_id`,`pozicio`	)
            	values
            	("'.$temakor.'", 
            	 "'.$szavazas->id.'", 
            	 "'.$szavazo_id.'", 
            	 "0", 
            	 "'.$alt->id.'", 
            	 "'.$pozicio.'");
           ');
           if (!$db->query()) {
              $errorMsg .= $db->getErrorMsg().'<br />';
              $db->setQuery('rollback');
              $db->setQuery();
              $db->setQuery('unlock tables');
              $db->query();
           };
         } // foreach alternativak
         // update a #__emailszavazok táblában
         $db->setQuery('UPDATE #__emailszavazas
         SET szavazott=1,
         szavazasido="'.date('Y-m-d H:i:s').'"
         WHERE email="'.$email.'" AND szavazas="'.$szavazas->id.'"');
         if (!$db->query()) {
                $errorMsg .= $db->getErrorMsg().'<br />';
                $db->setQuery('rollback');
                $db->setQuery();
                $db->setQuery('unlock tables');
                $db->query();
         };
       } else {
         $errorMsg .= 'lock error '.$db->getErrorMsg().'<br />';  
       } // sikerers lock
       $db->setQuery('unlock tables');
       $db->query();
       // commit transaction
       $db->setQuery('commit');
       $db->query();
       if ($errorMsg == '') {
         echo '<h1>'.JText::_('EMAIL_SZAVAZAS_KOSZONET').'</h1>';
       } else {
         echo '<p class="errorMsg">ERROR '.$errorMsg.'</p>';       }  
     }  
     $session->set('emailszavazas','');
     $link = JURI::base().'index.php?option=com_alternativak&view=alternativaklist&temakor='.$temakor.'&szavazas='.$szavazas->id;
     // képernyő kiirása
     echo '<p><a href="'.$link.'">'.JText::_('EMAIL_SZAVAZAS_EREDMENYLINK').'</a></p>';
     echo '<p>'.JText::_('EMAIL_SZAVAZAS_HIVDMEG').'</p>';
     JRequest::setVar('temakor',$temakor);
     JRequest::setVar('szavazas',$szavazas->id);
     $data = JRequest::setVar('data',encrypt($felado,ENCRYPTION_KEY));
     JRequest::setVar('data',$data);
     $this->meghivo();
   }
   /**
     * leiratkozás hirlevélről task
     * JRequest integer 'is'  #__levelkuldesek.id
    */
    public function unsub() {
        $user = false;
        $naplo = false;
        $db = JFactory::getDBO();
        
        // levelkuldesek naplo elérése
        $db->setQuery('select * from #__levelkuldesek where id="'.JRequest::getVar('id',0).'"');        
        $naplo = $db->loadObject();
        if ($naplo) {
            // user rekord elérése     
            $db->setQuery('select * from  #__users where email="'.$naplo->cimzett_email.'"');
            $user = $db->loadObject();
        }        
        if ($user) {
          // van már rekord a user_profiles táblában?
          $db->setQuery('select * from #__user_profiles where user_id="'.$user->id.'" and profile_key="profile.noNewsLetter"');
          $res = $db->loadObject();
          if ($res) {
              // van, update
              $db->setQuery('update #__user_profiles
              set profile_value="1" 
              where user_id="'.$user->id.'" and profile_key="profile.noNewsLetter"');
          } else {
              // nincs, insert 
              $db->setQuery('insert into #__user_profiles 
              (user_id, profile_key, profile_value)
              value 
              ("'.$user->id.'","profile.noNewLetter","1")');
          }
          // végrehajtás
          if (!$db->query()) {
            echo '<p>Error in unsub process '.$db->getErrorMsg().'</p>';  
          } else {
            echo '<p>Kedves '.$user->name.' '.$user->email.' !</p>'; 
            echo '<p>Sajnáljuk, hogy leiratkoztál a hírlevélről, reméljük ennek ellenére aktív látogatója maradsz oldalunknak.</p>';
            echo '<br /><br /><br /><br /><br /><br /><br />';
          }  
        } else {
             echo '<p>Error in process (unsub user not found)</p>';
        }
    }    
}// class
  
?>