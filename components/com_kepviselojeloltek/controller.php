<?php
/**
* @version		$Id:controller.php  1 2014-05-11Z FT $
* @package		Kepviselojeloltek
* @subpackage 	Controllers
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
require_once (JPATH_ROOT.DS.'components'.DS.'com_temakorok'.DS.'models'.DS.'temakorok.php');

/**
 * Variant Controller
 *
 * @package    
 * @subpackage Controllers
 */
class KepviselojeloltekController extends JControllerLegacy {

	protected $_mainmodel = 'item';
	protected $_itemname = 'Item';    
	protected $_context = "com_kepviselojeloltek";
    protected $config = false;
	/**
	 * Constructor
	 */
		 
	public function __construct($config = array ()) {
		
		parent :: __construct($config);
    
    // browser paraméterek ellenörzése, ha kell javitása
    if (JRequest::getVar('limit')=='') JRequest::setVar('limit',20);
    if (JRequest::getVar('limitstart')=='') JRequest::setVar('limitstart',0);
    if (JRequest::getVar('order')=='') JRequest::setVar('order',1);

		if(isset($config['viewname'])) $this->_viewname = $config['viewname'];
		if(isset($config['mainmodel'])) $this->_mainmodel = $config['mainmodel'];
		if(isset($config['itemname'])) $this->_itemname = $config['itemname']; 

		JRequest :: setVar('view', $this->_viewname);

    // általánosan használt helper
    if (file_exists(JPATH_ROOT.DS.'components'.DS.'com_temakorok'.DS.'helpers'.DS.'temakorok.php')) {
      include JPATH_ROOT.DS.'components'.DS.'com_temakorok'.DS.'helpers'.DS.'temakorok.php';
      $this->temakorokHelper = new TemakorokHelper();
    }	
    $temakor_id = JRequest::getVar('temakor');
    $this->config = $this->temakorokHelper->getConfig($temakor_id);
  }

  public function display() {
		
		$document =& JFactory::getDocument();
	
		$viewType	= $document->getType();
		$view = & $this->getView($this->_viewname,$viewType);
		$model = & $this->getModel($this->_mainmodel);
	
		$view->setModel($model,true);		
		$view->display();
	}
	/** 
	 * képviseletet vállalok form
	 * @return void
	 * @JRequest integer temakor
	 */            
  public function add() {
    $user = JFactory::getUser();
    if ($user->id == 0) {
      echo '<div class="errorMsg">Access denied</div>';
      return;
    }
    $temakor_id = JRequest::getVar('temakor',0);
    $db = JFactory::getDBO();
    // nézzük, hogy már nem képviselő jelőlt-e?
    $db->setQuery('select * 
    from #__kepviselojeloltek 
    where user_id="'.$user->id.'" and temakor_id="'.$temakor_id.'"');
    $item = $db->loadObject();
    if ($item == false) {
      $item = new stdClass();
      $item->id = 0;
      $item->user_id = $user->id;
      $item->temakor_id = $temakor_id;
      $item->leiras = '';
    }
    $item->name = $user->name;
    $item->username = $user->username;
    
    // témakör beolvasása
    $temakorModel = new TemakorokModelTemakorok();
    $temakor = $temakorModel->getItem($temakor_id);
    if ($temakor == false) {
      $temakor = new stdclass();
      $temakor->id = 0;
      $temakor->megnevezes = 'Általános';
    }
    
    // hozzáférés ellenörzés
    if (($this->temakorokHelper->isAdmin($user) == false) & ($temakor->id > 0)) {
      if ((($temakor->lathatosag == 1) & ($user->id == 0)) |
          (($temakor->lathatosag == 2) & ($this->temakorokHelper->userTag($temakor->id,$user) == false))
         ) {  
        $this->setMessage(JText::_('TEMAKOR_NEKED_NEM_ELERHETO'));
        $this->setRedirect(JURI::base().'index.php?option=com_temakorok&view=temakoroklist'.
               '&task=browse');
        $this->redirect();
      }
    }
    
    // képviseltek beolvasása
    $db->setQuery('select u.id, u.name, u.username
    from #__users u, #__kepviselok k
    where u.id = k.user_id and k.temakor_id="'.$temakor_id.'" and 
          k.kepviselo_id="'.$user->id.'" and  k.lejarat > now() 
    order by u.name      
    ');
    $kepviseltek = $db->loadObjectList();
    
    // akciók definiálása
    $akciok = array();
    $akciok['ok'] = JURI::base().'index.php?option=com_kepviselojeloltek&view=kepviselojeloltek&task=save';
    $akciok['delete'] = JURI::base().'index.php?option=com_kepviselojeloltek&view=kepviselojeloltek'.
         '&temakor='.$temakor_id.'&task=delete&user='.$user->id;
    if ($temakor_id == 0)
      $akciok['cancel'] = JURI::base().'index.php?option=com_temakorok&view=temakoroklist';
    else
      $akciok['cancel'] = JURI::base().'index.php?option=com_szavazasok&view=szavazasoklist&temakor='.$temakor_id;
    $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                      '&id='.JText::_('KEPVISELOJELOLTSUGO').'&Itemid=435&tmpl=component';
         
    // form megjelenítése
    $grav_url = "http://www.gravatar.com/avatar/".md5(strtolower( trim( $user->email)));
		$document =& JFactory::getDocument();
		$viewType	= $document->getType();
		$view = $this->getView('kepviselojeloltek',$viewType);
    $view->set('Title',JText::_('KEPVISELOJELOLT'));
    $view->set('Temakor',$temakor);
    $view->set('User',$user);
    $view->set('Item',$item);
    $view->set('Kepviseltek',$kepviseltek);
    $view->set('Akciok',$akciok);
    $view->set('Config',$this->config);
    $view->set('Avatar',
    '<img src="'.$grav_url.'" with="50" />');
    $view->setLayout('form');
    $view->display();
  }
  /**
   * képernyőn megadott adatok tárolása
   * @return void
   * @JRequest integer temakor
   * @JRequest integer user
   * @JRequest integer leiras
   */
  public function save() {
    // Check for request forgeries
    JRequest :: checkToken() or jexit('Invalid Token');
    $user = JFactory::getUser();
    $temakor_id = JRequest::getVar('temakor',0);
    $user_id = JRequest::getVar('user_id',0);
    if ($user->id != $user->id) {
      echo '<div class="errorMsg">Access denied</div>';
      return;
    }
    $db = JFactory::getDBO();
    
    // témakör beolvasása
    $temakorModel = new TemakorokModelTemakorok();
    $temakor = $temakorModel->getItem($temakor_id);
    
    if ($temakor == false) {
      $temakor = new stdclass();
      $temakor->id = 0;
      $temakor->megnevezes = 'Általános';
    }
    
    // hozzáférés ellenörzés
    if (($this->temakorokHelper->isAdmin($user) == false) & ($temakor->id > 0)) {
      if ((($temakor->lathatosag == 1) & ($user->id == 0)) |
          (($temakor->lathatosag == 2) & ($this->temakorokHelper->userTag($temakor->id,$user) == false))
         ) {  
        $this->setMessage(JText::_('TEMAKOR_NEKED_NEM_ELERHETO'));
        $this->setRedirect(JURI::base().'index.php?option=com_temakorok&view=temakoroklist'.
               '&task=browse');
        $this->redirect();
      }
    }
    
    $db->setQuery('select * 
    from #__kepviselojeloltek 
    where user_id="'.$user->id.'" and temakor_id="'.$temakor_id.'"'); 
    $item = $db->loadObject();
    if ($item == false) {
      $item = new stdClass();
      $item->id = 0;
    }
    $item->user_id = $user->id;
    $item->temakor_id = $temakor_id;
    $item->leiras = JRequest::getVar('leiras','','POST','STRING',JREQUEST_ALLOWHTML);
    $model = $this->getModel('kepviselojeloltek');
    if ($model->store($item))
      $this->setMessage(JText::_('KEPVISELOJELOLTTAROLVA'));
    else
      $this->setMessage($model->getError());
      
    if ($temakor_id == 0)
      $this->setRedirect(JURI::base().'index.php?option=com_temakorok&view=temakoroklist');
    else
      $this->setRedirect(JURI::base().'index.php?option=com_szavazasok&view=szavazasoklist'.
        '&temakor='.$temakor_id);
    $this->redirect();
  }       
  /**
   * képernyőn megadott adatok alapján képviselok rekord törlése - HA MEGENGEDETT
   * @return void
   * @JRequest integer temakor
   * @JRequest integer user
   */
  public function delete() {
    // Check for request forgeries
    $user = JFactory::getUser();
    $db = JFactory::getDBO();
    $temakor_id = JRequest::getVar('temakor');
    
    // témakör beolvasása
    $temakorModel = new TemakorokModelTemakorok();
    $temakor = $temakorModel->getItem($temakor_id);
    if ($temakor == false) {
      $temakor = new stdclass();
      $temakor->id = 0;
      $temakor->megnevezes = 'Általános';
    }
    
    // hozzáférés ellenörzés
    if (($this->temakorokHelper->isAdmin($user) == false) & ($temakor->id > 0)) {
      if ((($temakor->lathatosag == 1) & ($user->id == 0)) |
          (($temakor->lathatosag == 2) & ($this->temakorokHelper->userTag($temakor->id,$user) == false))
         ) {  
        $this->setMessage(JText::_('TEMAKOR_NEKED_NEM_ELERHETO'));
        $this->setRedirect(JURI::base().'index.php?option=com_temakorok&view=temakoroklist'.
               '&task=browse');
        $this->redirect();
      }
    }
    
    if ($user->id = JRequest::getVar('user')) {
       // nézzük van-e képviseltje?
       $db->setQuery('select * from #__kepviselok
       where temakor_id='.$temakor_id.' and kepviselo_id='.$user->id);
       $res = $db->loadObjectList();
       if (count($res)==0) {
         $db->setQuery('delete from #__kepviselojeloltek
         where user_id='.$user->id.' and temakor_id='.$temakor_id);
         if ($db->query())
            $this->setMessage(JText::_('KEPVISELOJELOLTTOROLVE'));
         else
            $this->setMessage($db->getErrorMsg());   
       } else {
         $this->setMessage(JText::_('NEMTOROLHETOVANKEPVISELTTAG'));
       }
       if ($temakor_id == 0)
         $this->setRedirect(JURI::base().'index.php?option=com_temakorok&view=temakoroklist');
       else
         $this->setRedirect(JURI::base().'index.php?option=com_szavazasok&view=szavazasoklist'.
           '&temakor='.$temakor_id);
       $this->redirect();
    } else {
      echo '<div class="errorMsg">Access denied</div>';
      return;
    }  
  }       

}// class
  	

  
?>