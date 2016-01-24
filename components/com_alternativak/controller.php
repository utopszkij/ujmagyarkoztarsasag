<?php
/**
* @version		$Id:controller.php  1 2014-04-04Z FT $
* @package		Alternativak
* @subpackage 	Controllers
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/
//+ 2014.09.10 Az alternativa név csak akkor link ha jogosult módosítani

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
require_once(JPATH_ROOT . '/components/com_jcomments/jcomments.php');
require_once (JPATH_ROOT.DS.'components'.DS.'com_temakorok'.DS.'models'.DS.'temakorok.php');

/**
 * Variant Controller
 *
 * @package    
 * @subpackage Controllers
 */
class AlternativakController extends JControllerLegacy {
  protected $NAME='alternativak';
	protected $_viewname = 'item';
	protected $_mainmodel = 'item';
	protected $_itemname = 'Item';    
	protected $_context = "com_alternativak";
  protected $temakorokHelper = null;
  protected $temakor_id = 0;
  protected $szavazas_id = 0;
  protected $temakor = null;
  protected $szavazas = null;
  protected $temakor_admin = false;
  protected $helper = null;
  protected $model = null;
  protected $view = null;
	/**
	 * Constructor
	 */
	public function __construct($config = array ()) {
		parent::__construct($config);
        if(isset($config['viewname'])) $this->_viewname = $config['viewname'];
            if(isset($config['mainmodel'])) $this->_mainmodel = $config['mainmodel'];
            if(isset($config['itemname'])) $this->_itemname = $config['itemname']; 
        
        // browser paraméterek ellenörzése, ha kell javitása
        if (JRequest::getVar('limit')=='') JRequest::setVar('limit',20);
        if (JRequest::getVar('limitstart')=='') JRequest::setVar('limitstart',0);
        if (JRequest::getVar('order')=='') JRequest::setVar('order',1);

        $this->temakor_id = JRequest::getVar('temakor','0');
        $this->szavazas_id = JRequest::getVar('szavazas','0');
        $db = JFactory::getDBO();
        $temakorModel = new TemakorokModelTemakorok();
        $this->temakor = $temakorModel->getItem($this->temakor_id);
        
        $db->setQuery('select * from #__szavazasok where id="'.$this->szavazas_id.'"');
        $this->szavazas = $db->loadObject();
        $db->setQuery('select * from #__tagok 
        where temakor_id="'.$this->temakor_id.'" and user_id="'.JFactory::getUser()->id.'"');
        $res = $db->loadObject();
        if ($res) {
          $this->temakor_admin = ($res->admin == 1);
        }	    
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

		$document =& JFactory::getDocument();
		$viewType	= $document->getType();
		$this->view = $this->getView($this->_viewname,$viewType);
		$this->model = $this->getModel($this->_mainmodel);
		$this->view->setModel($this->model,true);		
		JRequest :: setVar('view', $this->_viewname);
	}
  /**
   * user alternativa felvivő?
   * @return boolean
   */         
  private function alternativa_felvivo($user) {
    $result = false;
    $aj = $this->szavazas->alternativajavaslok;  //10-szavazók, 11-adminok
    $sz = $this->szavazas->szavazok;
   
    if (($aj == 10) & ($sz == 1) & ($user->id > 0))
      $result = true;
    if (($aj == 11) & ($this->szavazasIndito($this->szavazas->id,$user)))
      $result = true;
    if (($aj == 11) & ($this->temakorIndito($this->temakor_id,$user)))
      $result = true;
    if (($aj == 11) & ($this->temakorokHelper->temakorAdmin($this->temakor_id,$user)))
      $result = true;
    if (($aj == 10) & ($sz == 2) & ($this->temakorokHelper->userTag($this->temakor_id,$user,false)))
      $result = true;
    if (($aj == 10) & ($sz == 3) & ($this->temakorokHelper->userTag($this->temakor_id,$user,true)))
      $result = true;
    if ($this->temakorokHelper->isAdmin($user))
      $result = true;  
    //DBG echo '<hr>alternativa_felvivo ='.$result.' aj='.$aj.' sz='.$sz.'<hr>';
    return $result;
  }
  /**
   * a megadott témakörnek ez a user az inditója?
   */      
  private function temakorIndito($temakor_id,$user) {
    return (($user->id == $this->temakor->felvivo) & ($user->id > 0));
  }
  /**
   * a megadott szavazásnak ez a user az inditója?
   */      
  private function szavazasIndito($szavazas_id,$user) {
    return (($user->id == $this->szavazas->letrehozo) & ($user->id > 0));
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
	 * @request integer temakor
	 * @request integer szavazas      
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
      $brStatusStr = '{"limit":20,"limitStart":0,"order":1,"filterStr":"","temakor_id":0,"szavazas_id":0}';
    }
    $brStatus = JSON_decode($brStatusStr);
    
    $limitStart = JRequest::getVar('limitstart',$brStatus->limitstart);
    $limit = JRequest::getVar('limit',$brStatus->limit);
    $order = JRequest::getVar('order',$brStatus->order);
    $filterStr = urldecode(JRequest::getVar('filterStr',$brStatus->filterStr));
    if ($this->temakor_id=='') $this->temakor_id = $brStatus->temakor_id;
    if ($this->szavazas_id=='') $this->szavazas_id = $brStatus->szavazas_id;
    
    // browser status save to session and JRequest
    $brStatus->limit = $limit;
    $brStatus->limitStart = $limitStart;
    $brStatus->order = $order;
    $brStatus->filterStr = $filterStr;
    $brStatus->temakor_id = $this->temakor_id;
    $brStatus->szavazas_id = $this->szavazas_id;
    $session->set($this->NAME.'list_status', JSON_encode($brStatus));
    JRequest::setVar('limit',$limit);
    JRequest::setVar('limitstart',$limitStart);
    JRequest::setVar('order',$order);
    JRequest::setVar('filterStr',$filterStr);
    JRequest::setVar('temakor',$this->temakor_id);
    JRequest::setVar('szavazas',$this->szavazas_id);
    // adattábla tartalom elérése és átadása a view -nek
    $items = $this->model->getItems();
	$db->setQuery('select sum(igen) igen, sum(nem) nem
	from #__szavazasok_in
	where szavazas_id = '.$db->quote($this->szavazas_id));
	$igenNem = $db->loadObject();
	
    // user szavazott?
    $db->setQuery('select * from #__szavazok where szavazas_id="'.$this->szavazas->id.'" and user_id="'.$user->id.'"');
    $szavazo = $db->loadObject();
    //DBG echo $this->model->getDBO()->getQuery();
    
    if ($this->model->getError() != '')
      $this->view->Msg = $this->model->getError();
    $this->view->set('Items',$items);
	$this->view->set('igen',$igenNem->igen);
	$this->view->set('nem',$igenNem->nem);
    $this->view->set('Temakor',$this->temakor);
    $this->view->set('Szulok',$this->temakorokHelper->getSzulok());
    $this->view->set('Szavazas',$this->szavazas);
    $this->view->set('Szavazo',$szavazo);
    $this->view->set('Title',JText::_('ALTERNATIVAK'));
    $this->view->set('TemakorGroupId',$this->temakorokHelper->getTemakorGroupId($this->temakor->id));
    //+ 2014.09.10 Az alternativa név csak akkor link ha jogosult módosítani
    $this->view->set('isAdmin',$this->temakorokHelper->isAdmin($user));
    $this->view->set('temakor_admin', $this->temakor_admin);
    $this->view->set('user', $user);
    //- 2014.09.10 Az alternativa név csak akkor link ha jogosult módosítani

    // hányan szavaztak már?
    $db->setQuery('select count(distinct szavazo_id) cc from #__szavazatok where szavazas_id="'.$this->szavazas->id.'"');
    $res = $db->loadObject();
    $szavaztak = $res->cc;
    $this->view->set('szavaztak', $szavaztak);
       

    // browser müködéshez linkek definiálása
    if ($this->szavazas->vita1 == 1) {
      $itemLink =
        JURI::base().'index.php?option=com_alternativak&view=alternativak'.
        '&task=edit'.
        '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
        '&filterStr='.urlencode($filterStr).
        '&order='.JRequest::getVar('order','1').
        '&temakor='.$this->temakor_id.
        '&szavazas='.$this->szavazas_id;
    } else {
      $itemLink = '';
    }    
    $backLink =
       JURI::base().'index.php?option=com_szavazasok&view=szavazasoklist'.
       '&temakor='.$this->temakor_id.'&task=browse';
    $homeLink =
       JURI::base().'index.php?option=com_temakorok&view=temakoroklist'.
       '&task=browse';
       
    $this->view->set('itemLink',$itemLink);
    $this->view->set('backLink',$backLink);
    $this->view->set('homeLink',$homeLink);
   
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
    where  user_id = "'.$user->id.'"');
    $res = $db->loadObject();
    if ($db->getErrorNum() > 0) 
       $db->stderr();
    if ($res) {
      $kepviseloJelolt = true;
    }
    
    // kik az alternativa felvivők?
    $alternativa_felvivo = $this->alternativa_felvivo($user);

    // akciók definiálása
    $akciok = array();
    if ($this->temakorokHelper->isAdmin($user) | 
        (($szavazas_felvivo == 10) & ($this->szavazas->szavazok = 1) & ($user->id > 0)) |
        (($szavazas_felvivo == 10) & ($this->temakorokHelper->userTag($this->temakor_id,$user))) |
        ($this->temakor_admin) |
        ($this->alternativa_felvivo($user))
       ) {
      if (($this->szavazas->vita1 == 1) | ($this->szavazas->elbiralas_alatt == 1)) { 
        $akciok['ujAlternativa'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=add'.
         '&temakor='.$this->temakor_id.'&szavazas='.$this->szavazas_id.
         '&limit='.JRequest::getVar('limit',20).
         '&limitstart='.JRequest::getVar('limitstart',0).
         '&order='.JRequest::getVar('order',1).
         '&filterStr='.JRequest::getVar('filterStr','');
      }   
    }  

    if (($this->temakorokHelper->isAdmin($user)) |
        ($this->temakor_admin) |
        ($this->szavazas->letrehozo == $user->id)) {  
      $akciok['szavazasedit'] = JURI::base().'index.php?option=com_szavazasok&view=szavazasok&task=edit'.
      '&temakor='.$this->temakor_id.'&szavazas='.$this->szavazas_id;
    }

    if (($this->temakorokHelper->isAdmin($user)) |
        ($this->temakor_admin) |
        ($this->szavazas->letrehozo == $user->id)) {  
      $akciok['szavazastorles'] = JURI::base().'index.php?option=com_szavazasok&view=szavazasok&task=deleteform'.
      '&temakor='.$this->temakor_id.'&szavazas='.$this->szavazas_id;;
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

    if (($this->temakorokHelper->isAdmin($user)) |
        ($this->temakor_admin) |
        ($this->temakorIndito($this->temakor_id,$user))) {
      if (($this->szavazas->vita1 == 1) | ($this->szavazas->elbiralas_alatt == 1)) {    
	    $akciok['alternativaedit'] = JURI::base().'index.php?option=com_alternativak&view=alternativak&task=edit'.
        '&temakor='.$this->temakor_id.'&szavazas='.$this->szavazas_id;
      }  
    }

    if (($this->temakorokHelper->isAdmin($user)) |
        ($this->temakor_admin) |
        ($this->temakorIndito($this->temakor_id,$user))) {  
      if (($this->szavazas->vita1 == 1) | ($this->szavazas->elbiralas_alatt == 1)) {    
        $akciok['alternativatorles'] = JURI::base().'index.php?option=com_alternativak&view=alternativak&task=deleteform'.
        '&temakor='.$this->temakor_id.'&szavazas='.$this->szavazas_id;
      }  
    }

    if ((($this->szavazas->szavazas == 1) & ($user->id > 0)) | ($this->szavazas->szavazok == 0)) {
      // a szavazás folyamatban van és bejelntkezett user vagy a szavazáson mindenki szavazhat
      $db = JFactory::getDBO();
      $db->setQuery('select id from #__szavazatok
      where szavazas_id="'.$this->szavazas_id.'" and
      user_id="'.$user->id.'"');
      $res = $db->loadObjectList();
      if (count($res) == 0) {
        // ez a user még nem szavazott
        if (($this->szavazas->szavazok==1) |
            (($this->szavazas->szavazok==2) & ($this->temakorokHelper->userTag($this->temakor_id,$user,false))) |
            (($this->szavazas->szavazok==3) & ($this->temakorokHelper->userTag($this->temakor_id,$user,true)))  
           ) {
          $akciok['szavazok'] = JURI::base().'index.php?option=com_szavazasok&view=szavazasok&task=szavazoform&temakor='.$this->temakor_id.
             '&szavazas='.$this->szavazas_id;
        }     
      } else {
         $akciok['szavaztal'] = 'Y';
         if ($this->szavazas->titkos == 0) {
           $akciok['szavazatTorles'] = JURI::base().'index.php?option=com_alternativak&&task=szavazattorles&temakor='.$this->temakor_id.
                   '&szavazas='.$this->szavazas_id;
         }          
      }       
    }
    // if ($this->szavazas->lezart == 1) {
      $akciok['eredmeny'] = JURI::base().'index.php?option=com_szavazasok&view=szavazasok&task=eredmeny&temakor='.$this->temakor_id.
              '&szavazas='.$this->szavazas_id;
    // } 
    if (($this->szavazas->szavazas == 1) & ($user->id > 0)) {
      $akciok['emailszavazas'] = JURI::base().'index.php?option=com_szavazasok&view=szavazasok&task=meghivo&temakor='.$this->temakor_id.'&szavazas='.$this->szavazas_id;
    }         

    $akciok['copy'] = JURI::base().'index.php?option=com_alternativak&view=alternativaklist&task=copy'.
       '&temakor='.$this->temakor_id.'&szavazas='.$this->szavazas_id;
    $akciok['tagok'] = JURI::base().'index.php?option=com_tagok&temakor='.$this->temakor_id;
    $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                      '&id='.JText::_(strtoupper($this->NAME).'LIST_SUGO').'&Itemid=435&tmpl=component';
    $akciok['deleteSzavazas'] = JURI::base().'index.php?option=com_szavazasok&view=szavazasok&task=deleteform'.
             '&temakor='.$this->temakor_id.
             '&szavazas='.$this->szavazas_id;
    
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
          $altKepviselo['kepviselojeLink'] = JURI::base().'index.php?option=com_kepviselok&task=show&id='.$altKepviseloje;
		  $altKepviselo['image'] = getAvatar($altKepviseloje);
          $altKepviselo['nev'] = $kepviseloUser->name;
        }  
      }
      if ($kepviseloje > 0) {
        $kepviseloUser = JFactory::getUser($kepviseloje);
        if ($kepviseloUser) {
          $kepviselo['kepviselojeLink'] = JURI::base().'index.php?option=com_kepviselok&task=show&id='.$kepviseloje;
  		   $kepviselo['image'] = getAvatar($kerpviseloje);
          $kepviselo['nev'] = $kepviseloUser->name;
        }  
      } else if ($kepviseloJelolt) {
        $kepviselo['kepviseloJeloltLink'] = JURI::base().'index.php?option=com_kepviselo&task=edit&id='.$user->id;
      } else {
        $kepviselo['kepviselotValasztLink'] = JURI::base().'index.php?option=com_kepviselok&task=find&temekor='.$this->temakor_id.'&szavazas=0';
        $kepviselo['ujJeloltLink'] =  JURI::base().'index.php?option=com_kepviselojeloltek&task=add&temekor='.$this->temakor_id.'&szavazas=0&id='.$user->id;
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
    $db->setQuery('SELECT id from #__content WHERE alias="sz'.$this->szavazas_id.'"');
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
   * @return void
   */
  public function add() {
    jimport('hs.user.user');
    JHTML::_('behavior.modal'); 
    $user = JFactory::getUser();
    $db = JFactory::getDBO();

    // kik az alternativa felvivők?
    $alternativa_felvivo = $this->alternativa_felvivo($user);

    if (($this->temakorokHelper->isAdmin($user) | 
         (($szavazas_felvivo == 10) & ($this->szavazas->szavazok = 1) & ($user->id > 0)) |
         (($szavazas_felvivo == 10) & ($this->temakorokHelper->userTag($this->temakor_id,$user))) |
         ($this->temakor_admin) |
         ($this->alternativa_felvivo($user))
        ) & 
       ($this->szavazas->vita1 == 1) 
       ){ 
      $item = $this->model->getItem(0);
      if ($this->model->getError() != '')
        $this->view->Msg = $this->model->getError();
      $item->szavazok = $this->temakor->szavazok;
      $this->view->set('Item',$item);
      $this->view->set('Temakor',$this->temakor);
      $this->view->set('Szavazas',$this->szavazas);
      $this->view->set('Title', JText::_('UJALTERNATIVA'));
      
      // akciok definiálása
      $akciok = array();
      $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=save';
      $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
                          '&temakor='.$this->temakor->id.
                          '&szavazas='.$this->szavazas->id;
      $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                        '&id='.JText::_('UJALTERNATIVA_SUGO').'&Itemid=435&tmpl=component'; 
      $this->view->set('Akciok',$akciok);
      
      // form megjelenités
      $this->view->setLayout('form');
      $this->view->display();
    } else {
      echo '<div class="errorMsg">Access denied</div>';
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
    $db->setQuery('select letrehozo from #__alternativak where id="'.JRequest::getVar('alternativa').'"');
    $res = $db->loadObject();
    if ($res == fase) {
       echo '<div class="errorMsg">'.JText::_('WRONG_ALTERNATIVA_ID').':'.JRequest::getVar('alternativa').'</div>';
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
        ($res->letrehozo == $user->id)
       ) {
      $item = $this->model->getItem(JRequest::getVar('alternativa'));
      if ($this->model->getError() != '')
        $this->view->Msg = $this->model->getError();
      $this->view->set('Item',$item);
      $this->view->set('Temakor',$this->temakor);
      $this->view->set('Szavazas',$this->szavazas);
      $this->view->set('Title', JText::_('ALTERNATIVAMODOSITAS'));
      
      // akciok definiálása
      $akciok = array();
      $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=save';
      $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
                          '&temakor='.$this->temakor->id.
                          '&szavazas='.$this->szavazas->id;
      $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                        '&id='.JText::_('ALTERNATIVAMODOSITAS_SUGO').'&Itemid=435&tmpl=component';
      if ($this->szavazas->vita1==1) {
        if (($this->temakorokHelper->isAdmin($this->temakor_id,$user)) |
            ($this->temakor_admin))
        $akciok['delete'] = JURI::base().'index.php?option=com_alternativak&view=alternativak'.
             '&task=deleteform'.
             '&temakor='.$this->temakor->id.
             '&szavazas='.$this->szavazas->id.
             '&alternativa='.$item->id.
             '&id='.$item->id;
      }                   
      $this->view->set('Akciok',$akciok);
      
      // form megjelenités
      $this->view->setLayout('form');
      $this->view->display();
    } else {
      echo '<div class="errorMsg">Access denied</div>';
    }
  } // edit task
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
    $db->setQuery('select letrehozo from #__alternativak where id="'.JRequest::getVar('alternativa').'"');
    $res = $db->loadObject();
    if ($res == fase) {
       echo '<div class="errorMsg">'.JText::_('WRONG_ALTERNATIVA_ID').':'.JRequest::getVar('alternativa').'</div>';
       return;
    }
    if ($this->temakorokHelper->isAdmin($user)) {
      $item = $this->model->getItem(JRequest::getVar('alternativa'));
      if ($this->model->getError() != '')
         $this->view->Msg = $this->model->getError();
      $this->view->set('Item',$item);
      $this->view->set('Temakor',$this->temakor);
      $this->view->set('Szavazas',$this->szavazas);
      $this->view->set('Title', JText::_('ALTERNATIVATORLES'));
      
      // akciok definiálása
      $akciok = array();
      $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=delete'.
                                       '&temakor='.$this->temakor->id.
                                       '&szavazas='.$this->szavazas->id.
                                       '&alternativa='.$item->id;
      ;
      $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
                                       '&temakor='.$this->temakor->id.
                                       '&szavazas='.$this->szavazas->id;
      $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                        '&id='.JText::_('ALTERNATIVATORLES_SUGO').'&Itemid=435&tmpl=component'; 
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

    // kik az alternativa felvivők?
    $alternativa_felvivo = $this->alternativa_felvivo($user);

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


    if (($this->temakorokHelper->isAdmin($user) | 
         (($szavazas_felvivo == 10) & ($this->szavazas->szavazok = 1) & ($user->id > 0)) |
         (($szavazas_felvivo == 10) & ($this->temakorokHelper->userTag($this->temakor_id,$user))) |
         ($this->temakor_admin) |
         ($this->alternativa_felvivo($user))
        ) & 
       ($this->szavazas->vita1 == 1) 
       ){ 
      $item = $this->model->bind($_POST);
  		if ($this->model->store($item)) {
        $link =
        JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
        '&limit='.JRequest::getVar('limit','20').
        '&limitstart='.JRequest::getVar('limitstart').
        '&filterStr='.urlencode(JRequest::getVar('filterStr')).
        '&temakor='.urlencode(JRequest::getVar('temakor')).
        '&szavazas='.urlencode(JRequest::getVar('szavazas')).
        '&order='.JRequest::getVar('order');
		if ($item->id == 0) {
		  $db->setQuery('select * from #__content where alias="uj-alternativa-koszonet"');
		  $res = $db->loadObject();
		  if ($res)
             $this->setMessage($res->introtext);
		  else	  
             $this->setMessage(JText::_('ALTERNATIVATAROLVA'));
		} else {
           $this->setMessage(JText::_('ALTERNATIVATAROLVA'));
		}   
        $this->setRedirect($link);
        $this->redirect();
      } else {
    		$this->view->setModel($this->model,true);
        $this->view->Msg = $this->model->getError();
        $this->view->set('Item',$item);
        if ($item->id == 0) {
           $this->view->set('Title', JText::_('UJALTERNATIVA'));
        } else {
           $this->view->set('Title', JText::_('ALTERNATIVAMODOSITAS'));
        }   
        // akciok definiálása
        $akciok = array();
        $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=save';
        $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
          '&temakor='.$this->temakor->id.
          '&szavazas='.$this->szavazas->id;
        if ($item->id == 0)
          $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                            '&id='.JText::_('UJALTERNATIVA_SUGO').'&Itemid=435&tmpl=component'; 
        else
          $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                            '&id='.JText::_('ALTERNATIVAMODOSITAS_SUGO').'&Itemid=435&tmpl=component'; 
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
    if (JRequest::getVar($secret) != '1') {
         echo '<div class="errorMsg">'.JText::_('WRONG_SECRET').'</div>';
         return;
    }
    $user = JFactory::getUser();
    if (($this->szavazas->szavazas == 1) |
        ($this->szavazas->lezart == 1)) {
         echo '<div class="errorMsg">'.JText::_('NEMTOROLHETO').':'.JRequest::getVar('alternativa').'</div>';
         return;
    }
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

    if ($this->temakorokHelper->isAdmin($user)) {
      $item = $this->model->getItem(JRequest::getVar('alternativa'));
      if ($item == fase) {
         echo '<div class="errorMsg">'.JText::_('WRONG_ALTERNATIVA_ID').':'.JRequest::getVar('alternativa').'</div>';
         return;
      }
      if ($this->model->delete($item)) {
        $link =
        JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
        '&limitstart=0&temakor='.$this->temakor->id.
        '&szavazas='.$this->szavazas->id;
        $this->setMessage(JText::_('ALTERNATIVATOROLVE'));
        $this->setRedirect($link);
        $this->redirect();
      } else {
        $link =
        JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
        '&limitstart=0&temakor='.$this->temakor->id.
        '&szavazas='.$this->szavazas->id;
        $this->setMessage($this->model->getError());
        $this->setRedirect($link);
        $this->redirect();
      }
    } else {
      echo '<div class="errorMsg">Access denied</div>';
    }
  } // delete task
  /**
   * saját szavazatom törlése
   * @JRequest integer szavazas szavazas_id
   * @JRequest integer temakor  temakor_id
   * @retturn void
   * aktuuális user szavazatát törli
   */                  
  public function szavazattorles() {
    $db = JFactory::getDBO();
    $db->setQuery('select * from #__szavazasok where id='.JRequest::getVar('szavazas',0));
    $szavazas = $db->loadObject();
    $user = JFactory::getUser();
    if (($user->id > 0) & ($szavazas->titkos == 0) & ($szavazas->szavazas == 1)) {
      $this->setRedirect(JURI::base().'index.php?option=com_alternativak'.
         '&temakor='.JRequest::getVar('temakor',0).
         '&szavazas='.JRequest::getVar('szavazas',0));
      $db->setQuery('delete from #__szavazatok
      where szavazas_id="'.JRequest::getVar('szavazas',0).'" and 
            user_id="'.$user->id.'"');
      if (!$db->query()) {
        $this->setMessage($db->getErrorMsg());
        $this->redirect();
      }
      $db->setQuery('delete from #__szavazok
      where szavazas_id="'.JRequest::getVar('szavazas',0).'" and 
            user_id="'.$user->id.'"');
      if (!$db->query()) {
        $this->setMessage($db->getErrorMsg());
        $this->redirect();
      }
      $this->redirect();
    } else {
      echo '<div class="errorMsg">Access denied user='.$user->id.' titkos:'.$szavazas->titkos.' szavazas='.$szavazas->szavazas.'</div>';
      exit();
    } 
  }
  /**
   * task a user a copy ikonra klikkelt
   * @JRequest integer $temakor
   * @JRequest integer szavazas
   * @return void
   */               
  public function copy() {
    $session = JFactory::getSession();
    $session->set('clipboard_szavazas_id',JRequest::getVar('szavazas',0));
    $this->setRedirect(JURI::base().'index.php?option=com_alternativak&view=alternativaklist'.
         '&temakor='.JRequest::getVar('temakor',0).
         '&szavazas='.JRequest::getVar('szavazas',0));
    $this->setMessage(JText::_('SZAVAZAS_VAGOLAPRA_MASOLVA'));
    $this->redirect();
  }
  
  /**
    * user a szavazásra javaslom ikonra kattintott
	* @JRequest integer szavazas
	* @JRequest integer temakor
	* @returb void
	*/
  public function igenclick() {
	  $user = JFactory::getUser();
	  $db = JFactory::getDBO();
	  $szavazas_id = JRequest::getVar('szavazas');
	  $temakor_id = JRequest::getVar('temakor');
      $db->setQuery('select * from #__szavazasok where id='.$db->quote($szavazas_id));
	  $szavazas = $db->loadObject();	
      $db->setQuery('select * from #__temakorok where id='.$db->quote($temakor_id));
	  $this->temakor = $db->loadObject();	
	
    // hozzáférés ellenörzés
    if ($this->temakorokHelper->isAdmin($user) == false) {
      if ((($this->temakor->lathatosag == 1) & ($user->id == 0)) |
          (($this->temakor->lathatosag == 2) & ($this->temakorokHelper->userTag($this->temakor->id,$user) == false))
         ) {  
        // Redirect to login
        $this->temakorokHelper->getLogin(JText::_('TEMAKOR_NEKED_NEM_ELERHETO'));
      }
    }

 	  if ($user->id > 0) {
        $db->setQuery('select * from #__szavazasok where id='.$db->quote($szavazas_id));
		$szavazas = $db->loadObject();	
		if ($szavazas->vita1 == 1) {
			$db->setQuery('select * from #__szavazasok_in where szavazas_id='.$db->quote($szavazas_id).' and user_id='.$user->id);
			$res = $db->loadObject();
			if ($res) {
			  if ($res->igen != 1) {	
  			    $db->setQuery('update #__szavazasok_in 
			    set igen = igen + 1, nem = nem -1
			    where szavazas_id='.$db->quote($szavazas_id).' and user_id='.$user->id);
			    if ($db->query() == false) $db->sderr();
			  }	
			} else {
			  $db->setQuery('insert into #__szavazasok_in
			  values ('.$szavazas_id.','.$user->id.',1,0)');	
 		      if ($db->query() == false) $db->sderr();
			}
		}	
	  }
	  $this->browse();
  }
  
  /**
    * user a szavazásra javaslom ikonra kattintott
	* @JRequest integer szavazas
	* @JRequest integer temakor
	* @returb void
	*/
  public function nemclick() {
	  $user = JFactory::getUser();
	  $db = JFactory::getDBO();
	  $szavazas_id = JRequest::getVar('szavazas');
	  $temakor_id = JRequest::getVar('temakor');
      $db->setQuery('select * from #__szavazasok where id='.$db->quote($szavazas_id));
	  $szavazas = $db->loadObject();	
      $db->setQuery('select * from #__temakorok where id='.$db->quote($temakor_id));
	  $this->temakor = $db->loadObject();	

    // hozzáférés ellenörzés
    if ($this->temakorokHelper->isAdmin($user) == false) {
      if ((($this->temakor->lathatosag == 1) & ($user->id == 0)) |
          (($this->temakor->lathatosag == 2) & ($this->temakorokHelper->userTag($this->temakor->id,$user) == false))
         ) {  
        // Redirect to login
        $this->temakorokHelper->getLogin(JText::_('TEMAKOR_NEKED_NEM_ELERHETO'));
      }
    }
	  
	  if ($user->id > 0) {
		if ($szavazas->vita1 == 1) {
			$db->setQuery('select * from #__szavazasok_in where szavazas_id='.$db->quote($szavazas_id).' and user_id='.$user->id);
			$res = $db->loadObject();
			if ($res) {
			  if ($res->nem != 1) {	
    			$db->setQuery('update #__szavazasok_in 
	   		    set igen = igen - 1, nem = nem + 1
			    where szavazas_id='.$db->quote($szavazas_id).' and user_id='.$user->id);
			    if ($db->query() == false) $db->sderr();
			  }	
			} else {
			  $db->setQuery('insert into #__szavazasok_in
			  values ('.$szavazas_id.','.$user->id.',0,1)');	
			  if ($db->query() == false) $db->sderr();
			}
		}	
	  }
	  $this->browse();
  } 
}// class
  
?>