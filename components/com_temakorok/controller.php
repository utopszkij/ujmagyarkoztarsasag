<?php
/**
* @version		$Id:controller.php  1 2014-04-04Z FT $
* @package		Temakorok
* @subpackage 	Controllers
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
include_once JPATH_ADMINISTRATOR.'/components/com_users/models/group.php';

/**
 * Variant Controller
 *
 * @package    
 * @subpackage Controllers
 */
class TemakorokController extends JControllerLegacy {
  protected $NAME='temakorok';
  protected $_viewname = 'item';
  protected $_mainmodel = 'item';
  protected $_itemname = 'Item';    
  protected $_context = "com_temakorok";
  protected $temakorokHelper = null;
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
    
    // browser paraméterek ellenörzése, ha kell javitása
    if (JRequest::getVar('limit')=='') JRequest::setVar('limit',20);
    if (JRequest::getVar('limitstart')=='') JRequest::setVar('limitstart',0);
    if (JRequest::getVar('order')=='') JRequest::setVar('order',1);

    // általánosan használt helper
    if (file_exists(JPATH_COMPONENT.DS.'helpers'.DS.'temakorok.php')) {
      include JPATH_COMPONENT.DS.'helpers'.DS.'temakorok.php';
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
    $this->model->set('temakorokHelper',$this->temakorokHelper);
	$this->view->setModel($this->model,true);		
	JRequest :: setVar('view', $this->_viewname);
    
    // automatikus szavazás állapot változtatás
    $this->temakorokHelper->setSzavazasAllapot();
	}
  /**
   * kik a témakör felvivők?
   * @return integer 1- regisztráltak, 2-adminok
   */         
  private function temakor_felvivo() {
    // kik a témakor felvivők?
    $temakor_id = JRequest::getVar('temakor',0);
    $config = $this->temakorokHelper->getConfig($temakor_id);
    $result = $config->temakor_felvivok;
    return $result;
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
    $temakor_id = JRequest::getVar('temakor',0);
    $config = $this->temakorokHelper->getConfig($temakor_id);
    $kepviseletAtruhazasMegngedett = ($config->tobbszintu_atruhazas == 1);
    $total = 0;
    $pagination = null;
    $user = JFactory::getUser();
    $db = JFactory::getDBO();

    // alapértelmezett browser status beolvasása sessionból
    $session = JFactory::getSession();
    $brStatusStr = $session->get($this->NAME.'list_status');
    if ($brStatusStr == '') {
      $brStatusStr = '{"limit":20,"limitStart":0,"order":1,"filterStr":""}';
    }
    $brStatus = JSON_decode($brStatusStr);
    
    $limitStart = JRequest::getVar('limitstart',$brStatus->limitstart);
    $limit = JRequest::getVar('limit',$brStatus->limit);
    $order = JRequest::getVar('order',$brStatus->order);
    $filterStr = urldecode(JRequest::getVar('filterStr',$brStatus->filterStr));
    
    // browser status save to session and JRequest
    $brStatus->limit = $limit;
    $brStatus->limitStart = $limitStart;
    $brStatus->order = $order;
    $brStatus->filterStr = $filterStr;
    $session->set($this->NAME.'list_status', JSON_encode($brStatus));
    JRequest::setVar('limit',$limit);
    JRequest::setVar('limitstart',$limitStart);
    JRequest::setVar('order',$order);
    JRequest::setVar('filterStr',$filterStr);
    
   
    // adattábla tartalom elérése és átadása a view -nek
    $items = $this->model->getItems();
    $this->view->set('Items',$items);
    
    // browser müködéshez linkek definiálása
    $reorderLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&filterStr='.urlencode($filterStr);
    $doFilterLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&order='.JRequest::getVar('order','1');
    $itemLink =
       JURI::base().'index.php?option=com_szavazasok&view=szavazasoklist'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&filterStr='.urlencode($filterStr).
       '&order='.JRequest::getVar('order','1');
    $this->view->set('reorderLink',$reorderLink);
    $this->view->set('doFilterLink',$doFilterLink);
    $this->view->set('itemLink',$itemLink);
    
    // van ált. képviselője?
    $kepviseloje = 0;
    $db->setQuery('select k.kepviselo_id, u.name 
    from #__kepviselok k, #__users u
    where k.kepviselo_id = u.id and
            k.user_id = "'.$user->id.'" and k.temakor_id=0 and k.szavazas_id = 0 and
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
    where  user_id = "'.$user->id.'" and temakor_id=0');
    $res = $db->loadObject();
    if ($db->getErrorNum() > 0) 
       $db->stderr();
    if ($res) {
      $kepviseloJelolt = true;
    }
    
    // kik a témakor felvivők?
    $temakor_felvivo = $this->temakor_felvivo();

    // akciók definiálása
    $akciok = array();
    if ($this->temakorokHelper->isAdmin($user) | 
        (($temakor_felvivo == 1) & ($user->id > 0))
       ) {
      $akciok['ujTemakor'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=add';
    }  
    if ($this->temakorokHelper->isAdmin($user)) {  
      $akciok['beallitasok'] = JURI::base().'index.php?option=com_beallitasok';
    }
    $akciok['tagok'] = JURI::base().'index.php?option=com_tagok';
    $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                      '&id='.JText::_(strtoupper($this->NAME).'LIST_SUGO').'&Itemid=435&tmpl=component';
    $this->view->set('Akciok',$akciok);
   
    // globális képviselő/képviselő jelölt gombok definiálása
    $kepviselo = array();
    $kepviselo['kepviselojeLink'] = '';
    $kepviselo['kepviseloJeloltLink'] = '';
    $kepviselo['kepviselotValasztLink'] = '';
    $kepviselo['ujJeloltLink'] = '';
    if ($user->id > 0) {
      if ($kepviseloje > 0) {
        $kepviseloUser = JFactory::getUser($kepviseloje);
        if ($kepviseloUser) {
          $kepviselo['kepviselojeLink'] = JURI::base().'index.php?option=com_kepviselok&view=kepviselok&task=show&id='.$kepviseloje;
	      $kepviselo['image'] = getAvatar($kepviseloje);
          $kepviselo['nev'] = $kepviseloUser->name;
        }  
      } else if ($kepviseloJelolt) {
        $kepviselo['kepviseloJeloltLink'] = JURI::base().'index.php?option=com_kepviselojeloltek&view=kepviselojeloltek&task=add&id='.$user->id;
      } else {
        $kepviselo['kepviselotValasztLink'] = JURI::base().'index.php?option=com_kepviselok&view=kepviseloklist&task=add&temekor=0&szavazas=0';
        $kepviselo['ujJeloltLink'] =  JURI::base().'index.php?option=com_kepviselojeloltek&task=add&temekor=0&szavazas=0&id='.$user->id;
      }
      if ($kepviseletAtruhazasMegngedett) {
        if ($kepviseloje == 0) {
          $kepviselo['kepviselotValasztLink'] = JURI::base().'index.php?option=com_kepviselok&view=kepviseloklist&task=add&temekor=0&szavazas=0';
        }
        if (!$kepviseloJelolt) {
          $kepviselo['ujJeloltLink'] =  JURI::base().'index.php?option=com_kepviselojeloltek&task=add&temekor=0&szavazas=0&id='.$user->id;
        }
      }
    }
    $this->view->set('Kepviselo',$kepviselo);
    
    //lapozósor definiálása
    jimport( 'joomla.html.pagination' );    
    $total = $this->model->getTotal($filterStr);
    $pagination = new JPagination($total, $limitStart, $limit);
    $pagination->setAdditionalUrlParam('order',$order);
    $pagination->setAdditionalUrlParam('filterStr',urlencode($filterStr));
    $this->view->set('LapozoSor', $pagination->getListFooter());
    $this->view->display();
  } // browse task
  /**
   * szürés start
   * @JRequests: limit, limitstart, filterStr, order
   * @return void      
   */      
  public function dofilter() {
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
    // kik a témakor felvivők?
    $temakor_felvivo = $this->temakor_felvivo();
    if ($this->temakorokHelper->isAdmin($user) | 
        (($temakor_felvivo == 1) & ($user->id > 0))
       ) {
      $item = $this->model->getItem(JRequest::getVar('szulo',0));
      $item->id = 0;
      $item->megnevezes = '';
      $item->leiras = '';
      $item->letrehozo = $user->id;
      $item->letrehozva = date('Y-md H:i:s');
      $item->szulo = JRequest::getVar('szulo',0);
      $this->view->set('Item',$item);
      $this->view->set('Title', JText::_('UJTEMAKOR'));
      $this->view->set('Szulok', $this->temakorokHelper->getSzulok());

      // akciok definiálása
      $akciok = array();
      $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=save';
      if (JRequest::getVar('szulo',0) > 0)
        $akciok['cancel'] = JURI::base().'index.php?option=com_szavazasok&view=szavazasoklist&temakor='.JRequest::getVar('szulo',0);
      else
        $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list';
      $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                        '&id='.JText::_('UJTEMAKOR_SUGO').'&Itemid=435&tmpl=component'; 
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
    $item = $this->model->getItem(JRequest::getVar('temakor'));
    if ($item == fase) {
       echo '<div class="errorMsg">'.JText::_('WRONG_TEMAKOR_ID').':'.JRequest::getVar('temakor').'</div>';
       return;
    }
    if ($this->temakorokHelper->isAdmin($user) | 
        ($res->letrehozo == $user->id)
       ) {
      $this->view->set('Item',$item);
      $this->view->set('Title', JText::_('TEMAKORMODOSITAS'));
      $this->view->set('Szulok', $this->temakorokHelper->getSzulok());
	  $temakorTree = $this->temakorokHelper->getTemakorTree(0,'options',1,$item->szulo);
	  if ($item->szulo == 0)
		  $temakorTree = '<option value="0" selected="selected">'.JText::_('TEMAKOR_TREE_ROOT').'</option>'.$temakorTree;
	  else
		  $temakorTree = '<option value="0">'.JText::_('TEMAKOR_TREE_ROOT').'</option>'.$temakorTree;
      $this->view->set('temakorTree',$temakorTree);
      // akciok definiálása
      $akciok = array();
      $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=save';
      if (JRequest::getVar('szulo',0) > 0)
        $akciok['cancel'] = JURI::base().'index.php?option=com_szavazasok&view=szavazasoklist&temakor='.JRequest::getVar('szulo',0);
      else
        $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list';
      $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                        '&id='.JText::_('TEMAKORMODOSITAS_SUGO').'&Itemid=435&tmpl=component';
      $akciok['delete'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=deleteform'.
           '&temakor='.$item->id;
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
   
    if ($this->model->getItem(JRequest::getVar('temakor')) == fase) {
       echo '<div class="errorMsg">'.JText::_('WRONG_TEMAKOR_ID').':'.JRequest::getVar('temakor').'</div>';
       return;
    }
 
 if ($this->temakorokHelper->isAdmin($user)) {
      $item = $this->model->getItem(JRequest::getVar('temakor'));
      $this->view->set('Item',$item);
      $this->view->set('Title', JText::_('TEMAKORTORLES'));
      $this->view->set('Szulok', $this->temakorokHelper->getSzulok());
      
      // akciok definiálása
      $akciok = array();
      $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=delete'.
         '&temakor='.$item->id;
      if (JRequest::getVar('szulo',0) > 0)
        $akciok['cancel'] = JURI::base().'index.php?option=com_szavazasok&view=szavazasoklist&temakor='.JRequest::getVar('szulo',0);
      else
        $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list';
      $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                        '&id='.JText::_('TEMAKORTORLES_SUGO').'&Itemid=435&tmpl=component'; 
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
    $item = $this->model->bind($_POST);

	// a témakör fa hurkot mindenképpen meg kell akadályozni!
	$i = 0;
	$db->setQuery('select szulo from #__temakorok where id='.$db->quote($item->szulo));
	$res = $db->loadObject();
	while (($res) & ($i < TEMAKOR_TREE_LIMIT)) {
		$i++;
		$db->setQuery('select szulo from #__temakorok where id='.$db->quote($res->szulo));
		$res = $db->loadObject();
	}
	if ($item->id == $item->szulo) $i = TEMAKOR_TREE_LIMIT;
	if ($i >= TEMAKOR_TREE_LIMIT) {
		$db->setQuery('select szulo from #__temakorok where id='.$db->quote($item-yid));
		$res = $db->loadObject();
		if ($res)
			$item->szulo = $res->szulo;
		else
			$item->szulo = 0;	
		$this->view->setModel($this->model,true);
        $this->view->Msg = JText::_('TEMAKOR_TREE_LOOP');
        $this->view->set('Item',$item);
        if ($item->id == 0) {
           $this->view->set('Title', JText::_('UJTEMAKOR'));
        } else {
           $this->view->set('Title', JText::_('TEMAKORMODOSITAS'));
        } 
		$temakorTree = $this->temakorokHelper->getTemakorTree(0,'options',1,$item->szulo);
	    if ($item->szulo == 0)
		  $temakorTree = '<option value="0" selected="selected">'.JText::_('TEMAKOR_TREE_ROOT').'</option>'.$temakorTree;
	    else
		  $temakorTree = '<option value="0">'.JText::_('TEMAKOR_TREE_ROOT').'</option>'.$temakorTree;
		$this->view->set('temakorTree',$temakorTree);	
        // akciok definiálása
        $akciok = array();
        $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=save';
        if (JRequest::getVar('szulo',0) > 0)
          $akciok['cancel'] = JURI::base().'index.php?option=com_szavazasok&view=szavazasoklist&temakor='.JRequest::getVar('szulo',0);
        else
          $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list';
        if ($item->id == 0)
          $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                            '&id='.JText::_('UJTEMAKOR_SUGO').'&Itemid=435&tmpl=component'; 
        else
          $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                            '&id='.JText::_('TEMAKORMODOSITAS_SUGO').'&Itemid=435&tmpl=component'; 
        $this->view->set('Akciok',$akciok);
      
        // form megjelenités
        $this->view->setLayout('form');
        $this->view->display();
		return;
	}
	
    // kik a témakor felvivők?
    $temakor_felvivo = $this->temakor_felvivo();

    
    // jogosultság ellenörzés
    if (($this->temakorokHelper->isAdmin($user)) | 
        (($temakor_felvivo == 1) & ($user->id > 0) & (JRequest::getVar('id') == 0)) |
        (($this->temakorokHelper->temakorAdmin(JRequest::getVar('id'),$user)) & (JRequest::getVar('id') > 0))
        ) {
  		if ($this->model->store($item)) {
        if (JRequest::getVar('szulo',0) > 0)
          $link = JURI::base().'index.php?option=com_szavazasok&view=szavazasoklist&temakor='.JRequest::getVar('szulo',0);
        else
          $link =
          JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
          '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
          '&filterStr='.urlencode($filterStr).
          '&order='.$order;
        
        $this->setMessage(JText::_('TEMAKORTAROLVA'));
        $this->setRedirect($link);
        $this->redirect();
      } else {
   		$this->view->setModel($this->model,true);
        $this->view->Msg = $this->model->getError();
        $this->view->set('Item',$item);
        if ($item->id == 0) {
           $this->view->set('Title', JText::_('UJTEMAKOR'));
        } else {
           $this->view->set('Title', JText::_('TEMAKORMODOSITAS'));
        }   
		$temakorTree = $this->temakorokHelper->getTemakorTree(0,'options',1,$item->szulo);
	    if ($item->szulo == 0)
		  $temakorTree = '<option value="0" selected="selected">'.JText::_('TEMAKOR_TREE_ROOT').'</option>'.$temakorTree;
	    else
		  $temakorTree = '<option value="0">'.JText::_('TEMAKOR_TREE_ROOT').'</option>'.$temakorTree;
		$this->view->set('temakorTree',$temakorTree);	
        // akciok definiálása
        $akciok = array();
        $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=save';
        if (JRequest::getVar('szulo',0) > 0)
          $akciok['cancel'] = JURI::base().'index.php?option=com_szavazasok&view=szavazasoklist&temakor='.JRequest::getVar('szulo',0);
        else
          $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list';
        if ($item->id == 0)
          $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                            '&id='.JText::_('UJTEMAKOR_SUGO').'&Itemid=435&tmpl=component'; 
        else
          $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                            '&id='.JText::_('TEMAKORMODOSITAS_SUGO').'&Itemid=435&tmpl=component'; 
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
		JRequest :: checkToken() or jexit('Invalid Token');
    $user = JFactory::getUser();
    $db = JFactory::getDBO();
    if ($this->temakorokHelper->isAdmin($user)) {
      $item = $this->model->getItem(JRequest::getVar('temakor'));
      if ($item == fase) {
         echo '<div class="errorMsg">'.JText::_('WRONG_TEMAKOR_ID').':'.JRequest::getVar('temakor').'</div>';
         return;
      }
      if ($this->model->delete($item)) {
        $link =
        JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
        '&limitstart=0';
        $this->setMessage(JText::_('TEMAKORTOROLVE'));
        $this->setRedirect($link);
        $this->redirect();
      } else {
        $link =
        JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
        '&limitstart=0';
        $this->setMessage($this->model->getError());
        $this->setRedirect($link);
        $this->redirect();
      }
    } else {
      echo '<div class="errorMsg">Access denied</div>';
    }
  } // delete task
}// class
  
?>