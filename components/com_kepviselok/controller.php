<?php
/**
* @version		$Id:controller.php  1 2014-05-12Z FT $
* @package		Kepviselok
* @subpackage 	Controllers
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
require_once(JPATH_ROOT . '/components/com_jcomments/jcomments.php');

/**
 * Variant Controller
 *
 * @package    
 * @subpackage Controllers
 */
class KepviselokController extends JControllerLegacy
{

	protected $_viewname = 'item';
	protected $_mainmodel = 'item';
	protected $_itemname = 'Item';    
	protected $_context = "com_kepviselok";
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

		JRequest :: setVar('view', $this->_viewname);
    // általánosan használt helper
    if (file_exists(JPATH_ROOT.DS.'components'.DS.'com_temakorok'.DS.'helpers'.DS.'temakorok.php')) {
      include JPATH_ROOT.DS.'components'.DS.'com_temakorok'.DS.'helpers'.DS.'temakorok.php';
      $this->temakorokHelper = new TemakorokHelper();
    }
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
   * adott képviselő adatlap megjelenítése
   * hivhatja: "...képviselője" gomb vagy a képviselő választásnál a névre kattintás   
   * @return void
   * @JRequest integer id
   * @JRequest integer temakor
   */               
	public function show() {
    JHTML::_('behavior.modal'); 
    $user = JFactory::getUser();
    $temakor_id = JRequest::getVar('temakor',0);
    $config = $this->temakorokHelper->getConfig($temakor_id);    
    if ($user->id == 0) {
      echo '<div class="errorMsg">Access denied</div>';
      return;
    }
    $db = JFactory::getDBO();

    // a bejelentkezett user képviselője
    if (JRequest::getVar('id') == '') {
      $db->setQuery('select k.*,j.leiras 
      from #__kepviselok k
      left outer join #__kepviselojeloltek j on j.temakor_id = k.temakor_id and j.user_id = k.kepviselo_id 
      where k.user_id="'.$user->id.'" and k.temakor_id="'.$temakor_id.'"
      ');
      $item = $db->loadObject();
    }
    
    // a getVar('id') képviselő
    if ($item == false) {
      $item = new stdclass();
      $item->id = 0;
      $item->kepviselo_id = JRequest::getVar('id');
      $item->user_id = 0;  // ez jelzi, hogy nem az adott user képviselője
      $db->setQuery('select leiras
      from #__kepviselojeloltek
      where user_id="'.JRequest::getVar('id').'" and temakor_id="'.JRequest::getVar('temakor').'"');
      $res = $db->loadObject();
      if ($res)
         $item->leiras = $res->leiras;
      // az aktuális user képviselője?
      $db->setQuery('select k.*,j.leiras 
      from #__kepviselok k
      left outer join #__kepviselojeloltek j on j.temakor_id = k.temakor_id and j.user_id = k.kepviselo_id 
      where k.user_id="'.$user->id.'" and k.kepviselo_id = "'.$item->kepviselo_id.'" and k.temakor_id="'.$temakor_id.'"
      ');
      $res = $db->loadObject();
      if ($res) {
        $item = $res;
      }   
    }

    $item->name = $user->name;
    $item->username = $user->username;
    //$kuser = JFactory::getUser($item->kepviselo_id);
    $db->setQuery('SELECT * FROM #__users WHERE id="'.$item->kepviselo_id.'"');
    $kuser = $db->loadObject();
    
    $grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $kuser->email )));
    $item->kimage = '<img src="'.$grav_url.'" width="50" height="50" />';
    $item->kname = $kuser->name;
    $item->kusername = $kuser->username;
    $item->kemail = $kuser->email;
    
    // témakör beolvasása
    $db->setQuery('select * from #__temakorok where id="'.$temakor_id.'"');
    $temakor = $db->loadObject();
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
    
    // van ált. képviselője?
    $altKepviseloje = 0;
    $altKepviseloLink = '';
    $altKepviseloImg = '';
    $altKepviseloNev = '';
    $db->setQuery('select k.kepviselo_id, u.name 
    from #__kepviselok k, #__users u
    where k.kepviselo_id = u.id and
            k.user_id = "'.$kuser->id.'" and k.temakor_id=0 and k.szavazas_id = 0 and
            k.lejarat >= "'.date('Y-m-d').'"');
    $res = $db->loadObject();
    if ($db->getErrorNum() > 0) 
       $db->stderr();
    if ($res) {
      $altKepviseloje = $res->kepviselo_id;
      $kepviseloUser = JFactory::getUser($altKepviseloje);
      if ($kepviseloUser) {
          $altKepviseloLink = JURI::base().'index.php?option=com_kepviselok&view=kepviselok&task=show&id='.$altKepviseloje;
          $altKepviseloNev = $kepviseloUser->name;
		  $altKepviseloImg = getAvatar($kepviseloUser->id);
      }  
    }
    
    // van témakör képviselője?
    $temaKepviseloje = 0;
    $temaKepviseloLink = '';
    $temaKepviseloImg = '';
    $temaKepviseloNev = '';
    if ($temakor_id > 0) {
      $db->setQuery('select k.kepviselo_id, u.name 
      from #__kepviselok k, #__users u
      where k.kepviselo_id = u.id and
              k.user_id = "'.$kuser->id.'" and k.temakor_id="'.$temakor_id.'" and k.szavazas_id = 0 and
              k.lejarat >= "'.date('Y-m-d').'"');
      $res = $db->loadObject();
      if ($db->getErrorNum() > 0) 
         $db->stderr();
      if ($res) {
        $temaKepviseloje = $res->kepviselo_id;
        $kepviseloUser = JFactory::getUser($temaKepviseloje);
        if ($kepviseloUser) {
            $temaKepviseloLink = JURI::base().'index.php?option=com_kepviselok&view=kepviselok&task=show&id='.$temaKepviseloje;
            $temaKepviseloNev = $kepviseloUser->name;
    		$temaKepviseloImg = getAvatar($kepviseloUser->id);
        }  
      }
    }
    
    // képviseltek beolvasása
    $db->setQuery('select u.id, u.name, u.username
    from #__users u, #__kepviselok k
    where u.id = k.user_id and k.temakor_id="'.$temakor_id.'" and 
          k.kepviselo_id="'.$item->kepviselo_id.'" 
    order by u.name      
    ');
    $kepviseltek = $db->loadObjectList();
    
    // akciók definiálása
    $akciok = array();
    
    //DBG echo '<p>user->id='.$user->id.' item->user_id='.$item->user_id.'</p>
    //<p>'.$db->getQuery().'</p>';
    
    if ($user->id == $item->user_id)
      $akciok['delete'] = JURI::base().'index.php?option=com_kepviselok&view=kepviselok'.
         '&temakor='.$temakor_id.'&task=delete&user='.$user->id;
    else
      $akciok['save'] = JURI::base().'index.php?option=com_kepviselok&view=kepviselok&task=save'.
         '&temakor='.$temakor_id.'&id='.$item->kepviselo_id;
         
    $akciok['szavazatok'] = JURI::base().'index.php?option=com_kepviselok&view=kepviselok&task=szavazatok'.
         '&temakor='.$temakor_id.'&id='.$item->kepviselo_id;
    if ($item->id == 0)
      $akciok['valaszt'] = JURI::base().'index.php?option=com_kepviselok&view=kepviselok&task=add'.
         '&temakor='.$temakor_id;
    else if ($temakor_id == 0)
      $akciok['temakorok'] = JURI::base().'index.php?option=com_temakorok&view=temakoroklist';
    else
      $akciok['temakor'] = JURI::base().'index.php?option=com_szavazasok&view=szavazasoklist&temakor='.$temakor_id;
    $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                      '&id='.JText::_('KEPVISELOSUGO').'&Itemid=435&tmpl=component';
                       
    // form megjelenítése
		$document =& JFactory::getDocument();
		$viewType	= $document->getType();
		$view = $this->getView('kepviselok',$viewType);
    $view->set('Title',JText::_('KEPVISELO'));
    $view->set('Temakor',$temakor);
    $view->set('User',$user);
    $view->set('Item',$item);
    $view->set('altKepviseloLink',$altKepviseloLink);
    $view->set('altKepviseloImg',$altKepviseloImg);
    $view->set('altKepviseloNev',$altKepviseloNev);
    $view->set('temaKepviseloLink',$temaKepviseloLink);
    $view->set('temaKepviseloImg',$temaKepviseloImg);
    $view->set('temaKepviseloNev',$temaKepviseloNev);
    /*
    if ($config->atruhazas_lefele_titkos == 1) {
       for ($i=0; $i<count($kepviseltek); $i++) {
         $kepviseltek[$i]->name = '---';
         $kepviseltek[$i]->username = '';
       } 
    }
    */
    $view->set('Config',$config);
    $view->set('Kepviseltek',$kepviseltek);
    $view->set('KepviseltekDarab',count($kepviseltek));
    $view->set('Akciok',$akciok);

    // kacsolodó cikk id-jének elérése és átadása a viewer-nek
    $db->setQuery('SELECT id from #__content WHERE alias="k'.$item->kepviselo_id.'"');
    $res = $db->loadObject();
    if ($res) {
      $view->set('CommentId',$res->id);
    } else {
      $view->set('CommentId',0);
    }
    
    $view->setLayout('show');
    $view->display();
   }
  /**
   * adott user-hez új képviselőt választ (böngésző képernyő)
   * @return void
   * @JRequest integer temakor
   * @JRequest integer limitstart
   * @JRequest integer limit
   * @JRequest string filterStr
   * @JRequest integer order                     
   */               
  public function add() {
    JHTML::_('behavior.modal'); 
    $total = 0;
    $pagination = null;
    $user = JFactory::getUser();
    if ($user->id == 0) {
      echo '<div class="errorMsg">Access denied</div>';
      return;
    }
    $db = JFactory::getDBO();
    $document = JFactory::getDocument();
		$viewType	= $document->getType();
		$view = & $this->getView('jelolteklist',$viewType);
		$model = & $this->getModel('jelolteklist');
    // alapértelmezett browser status beolvasása sessionból
    $session = JFactory::getSession();
    $brStatusStr = $session->get('jelolteklist_status');
    if ($brStatusStr == '') {
      $brStatusStr = '{"limit":20,"limitstart":0,"order":1,"filterStr":""}';
    }
    $brStatus = JSON_decode($brStatus);
    
    $limitStart = JRequest::getVar('limitstart',$brStatus->limitstart);
    $limit = JRequest::getVar('limit',$brStatus->limit);
    $order = JRequest::getVar('order',$brStatus->order);
    $filterStr = urldecode(JRequest::getVar('filterStr',$brStatus->filterStr));
    
    // browser status save to session and JRequest
    $brStatus->limit = $limit;
    $brStatus->limitStart = $limitStart;
    $brStatus->order = $order;
    $brStatus->filterStr = $filterStr;
    // ebben az esetben inkább ne jegyezze meg....
    //$session->set('jelolteklist_status', JSON_encode($brStatus));
    JRequest::setVar('limit',$limit);
    JRequest::setVar('limitstart',$limitstart);
    JRequest::setVar('order',$order);
    JRequest::setVar('filterStr',$filterStr);
    
   
    // adattábla tartalom elérése és átadása a view -nek
    $items = $model->getItems();
    //DBG echo '<p>'.$model->getDBO()->getQuery().'</p>';
    $view->set('Items',$items);

    // témakör beolvasása
    $db->setQuery('select * from #__temakorok where id="'.JRequest::getVar('temakor',0).'"');
    $view->Temakor = $db->loadObject();
    if ($view->Temakor == false) {
      $view->Temakor = new stdclass();
      $view->Temakor->megnevezes = JText::_('ALTALANOS');
      $view->Temakor->id = 0;
    }
    
    // browser müködéshez linkek definiálása
    $reorderLink =
       JURI::base().'index.php?option=com_kepviselok&view=kepviselok&task=add'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&filterStr='.urlencode($filterStr);
    $doFilterLink =
       JURI::base().'index.php?option=com_kepviselok&view=kepviselok&task=add'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&order='.JRequest::getVar('order','1');
    $itemLink = JURI::base().'index.php?option=com_kepviselok&view=kepviselok&task=save'.
       '&temakor='.JRequest::getVar('temakor');
    $itemLink2 = JURI::base().'index.php?option=com_kepviselok&view=kepviselok&task=show'.
       '&temakor='.JRequest::getVar('temakor').
       '&return='.urlencode(JURI::base().'index.php?option=com_kepviselok&view=kepviselok&task=add&temakor='.JRequest::getVar('temakor'));
    $view->set('reorderLink',$reorderLink);
    $view->set('doFilterLink',$doFilterLink);
    $view->set('itemLink',$itemLink);
    $view->set('itemLink2',$itemLink2);

    // akciók definiálása
    $akciok = array();
    if (JRequest::getVar('temakor','0') == 0) 
      $akciok['back'] = JURI::base().'index.php?option=com_temakorok&view=temakoroklist';
    else 
    $akciok['back'] = JURI::base().'index.php?option=com_szavazasok&view=szavazasoklist'.
      '&temakor='.JRequest::getvar('temakor');
    $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                      '&id='.JText::_('JELOLTEKSUGO').'&Itemid=435&tmpl=component';
    $view->set('Akciok',$akciok);
    
    //lapozósor definiálása
    jimport( 'joomla.html.pagination' );    
    $total = $model->getTotal($filterStr);
    $pagination = new JPagination($total, $limitStart, $limit);
    $pagination->setAdditionalUrlParam('order',$order);
    $pagination->setAdditionalUrlParam('filterStr',urlencode($filterStr));
    $view->set('LapozoSor', $pagination->getListFooter());
    
    // display
    $view->setLayout('browse');
    $view->display();  }
  /**
   * képviselő eddigi szavazatainak megjelenítése
   * (böngésző képernyő)   
   * @return void
   * @JRequest integer temakor
   * @JRequest integer id  - kepviselo_id
   * @JRequest integer limitstart
   * @JRequest integer limit
   * @JRequest string filterStr
   * @JRequest integer order                     
   */
  public function szavazatok() {
    JHTML::_('behavior.modal'); 
    $total = 0;
    $pagination = null;
    $user = JFactory::getUser();
    $db = JFactory::getDBO();
    $document = JFactory::getDocument();
		$viewType	= $document->getType();
		$view = & $this->getView('szavazatoklist',$viewType);
		$model = & $this->getModel('szavazatoklist');
    // alapértelmezett browser status beolvasása sessionból
    $session = JFactory::getSession();
    $brStatusStr = $session->get('szavazasoklist_status');
    if ($brStatusStr == '') {
      $brStatusStr = '{"limit":20,"limitstart":0,"order":1,"filterStr":""}';
    }
    $brStatus = JSON_decode($brStatus);
    
    $limitStart = JRequest::getVar('limitstart',$brStatus->limitstart);
    $limit = JRequest::getVar('limit',$brStatus->limit);
    $order = JRequest::getVar('order',$brStatus->order);
    $filterStr = urldecode(JRequest::getVar('filterStr',$brStatus->filterStr));
    
    // browser status save to session and JRequest
    $brStatus->limit = $limit;
    $brStatus->limitStart = $limitStart;
    $brStatus->order = $order;
    $brStatus->filterStr = $filterStr;
    // ebben az esetben inkább ne jegyezze meg....
    //$session->set('szavazatoklist_status', JSON_encode($brStatus));
    JRequest::setVar('limit',$limit);
    JRequest::setVar('limitstart',$limitStart);
    JRequest::setVar('order',$order);
    JRequest::setVar('filterStr',$filterStr);
    
   
    // adattábla tartalom elérése és átadása a view -nek
    $items = $model->getItems();
    //DBG echo '<p>'.$model->getDBO()->getQuery().'</p>';
    
    // items-temakor-user hozzáférés ellenörzés
    if ($this->temakorokHelper->isAdmin($user) == false) {
      for ($i=0; $i<count($items); $i++) {
        $item = $items[$i];
        if ((($item->lathatosag == 1) & ($user->id == 0)) |
            (($item->lathatosag == 2) & ($this->temakorokHelper->userTag($item->id,$user) == false))
           ) {
           // letiltott
           $items[$i]->szmegenevezes = '***';
           $items[$i]->amegenevezes  = '***';
           $items[$i]->pozicio  = '**';
        }
      }
    }
    
    $view->set('Items',$items);

    // témakör beolvasása
    $db->setQuery('select * from #__temakorok where id="'.JRequest::getVar('temakor',0).'"');
    $view->Temakor = $db->loadObject();
    if ($view->Temakor == false) {
      $view->Temakor = new stdclass();
      $view->Temakor->megnevezes = JText::_('ALTALANOSKEPVISELO');
      $view->Temakor->id = 0;
    } else {
      $view->Temakor->megnevezes .= ' '.JText::_('KEPVISELO');
    }
    
    // képviselő adatok beolvasása
    $view->set('Kuser',JFactory::getUser(JRequest::getVar('id',0)));
    
    // browser müködéshez linkek definiálása
    $reorderLink =
       JURI::base().'index.php?option=com_kepviselok&view=kepviselok&task=szavazatok'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&filterStr='.urlencode($filterStr).
       '&temakor='.JRequest::getVar('temakor').
       '&id='.JRequest::getVar('id',0);
    $doFilterLink =
       JURI::base().'index.php?option=com_kepviselok&view=kepviselok&task=add'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&order='.JRequest::getVar('order','1').
       '&temakor='.JRequest::getVar('temakor').
       '&id='.JRequest::getVar('id',0);
    $view->set('reorderLink',$reorderLink);
    $view->set('doFilterLink',$doFilterLink);

    // akciók definiálása
    $akciok = array();
    $akciok['back'] = JURI::base().'index.php?option=com_kepviselok&view=kepviselok&task=show'.
       '&temakor='.JRequest::getVar('temakor').
       '&id='.JRequest::getVar('id',0);
    $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                      '&id='.JText::_('SZAVAZATOKSUGO').'&Itemid=435&tmpl=component';
    $view->set('Akciok',$akciok);
    
    //lapozósor definiálása
    jimport( 'joomla.html.pagination' );    
    $total = $model->getTotal($filterStr);
    $pagination = new JPagination($total, $limitStart, $limit);
    $pagination->setAdditionalUrlParam('order',$order);
    $pagination->setAdditionalUrlParam('filterStr',urlencode($filterStr));
    $view->set('LapozoSor', $pagination->getListFooter());
    
    // display
    $view->setLayout('browse');
    $view->display(); 
  }       
  /**
   * adott userhez kiválasztott képviselőt tárolja
   * @return void
   * @JRequest integer temakor
   * @JRequest integer id
   */               
  public function save() {
    $user = JFactory::getUser();
    $temakor_id = JRequest::getVar('temakor',0);
    $id = JRequest::getVar('id',0);
    $db = JFactory::getDBO();
    if ($user->id == 0) {
      echo '<div class="errorMsg">Access denied</div>';
      return;
    }
    
    // témakör beolvasása
    $db->setQuery('select * from #__temakorok where id="'.$temakor_id.'"');
    $temakor = $db->loadObject();
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
    
    
    // van már képviselője?
    $db->setQuery('select * from #__kepviselok
    where user_id="'.$user->id.'" and temakor_id="'.$temakor_id.'"');
    $res = $db->loadObject();
    
    if ($res == false) {
      $db->setQuery('INSERT INTO #__kepviselok (user_id,kepviselo_id,temakor_id,szavazas_id,lejarat)
                     VALUES("'.$user->id.'","'.$id.'","'.$temakor_id.'","0","2200-12-31")');
      if ($db->query())
    
    
    
    
    
        $this->setMessage(JText::_('KEPVISELOTAROLVA'));
      else
        $this->setMessage($db->getErrorMsg());                  
    }
    if ($temakor_id == 0) 
      $this->setRedirect(JURI::base().'index.php?option=com_temakorok&view=temakoroklist');
    else
      $this->setRedirect(JURI::base().'index.php?option=com_szavazasok&view=szavazasoklist'.
      '&temakor='.$temakor_id);
    $this->redirect();
  }
  /**
   * adott userhez tartozó képviselőt törli
   * @return void
   * @JRequest integer temakor
   * @JRequest integer id
   */               
  public function delete() {
    $user = JFactory::getUser();
    $temakor_id = JRequest::getVar('temakor',0);
    $id = JRequest::getVar('id',0);
    $db = JFactory::getDBO();
    if ($user->id == 0) {
      echo '<div class="errorMsg">Access denied</div>';
      return;
    }
    
    // témakör beolvasása
    $db->setQuery('select * from #__temakorok where id="'.$temakor_id.'"');
    $temakor = $db->loadObject();
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
    
    $db->setQuery('DELETE FROM #__kepviselok 
                   WHERE user_id="'.$user->id.'" and temakor_id="'.$temakor_id.'"');
    if ($db->query())
        $this->setMessage(JText::_('KEPVISELOTOROLVE'));
    else
        $this->setMessage($db->getErrorMsg());                  
    if ($temakor_id == 0) 
      $this->setRedirect(JURI::base().'index.php?option=com_temakorok&view=temakoroklist');
    else
      $this->setRedirect(JURI::base().'index.php?option=com_szavazasok&view=szavazasoklist'.
      '&temakor='.$temakor_id);
    $this->redirect();
  }

}// class
  	

  
?>