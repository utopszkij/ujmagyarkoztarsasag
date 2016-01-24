<?php
/**
* @version		$Id:controller.php  1 2014-05-06Z FT $
* @package		Tagok
* @subpackage 	Controllers
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
require_once JPATH_BASE.DS.'components'.DS.'com_temakorok'.DS.'models'.DS.'temakorok.php';

/**
 * Variant Controller
 *
 * @package    
 * @subpackage Controllers
 */
class TagokController extends JControllerLegacy {
  protected $NAME = 'tagok';
  protected $temakor_id = 0;
  protected $temakor = false;
  protected $temakor_admin = false;
  protected $temakorokHelper = false;
	protected $_viewname = 'item';
	protected $_mainmodel = 'item';
	protected $_itemname = 'Item';    
	protected $_context = "com_tagok";
	/**
	 * Constructor
	 */
		 
	public function __construct($config = array ()) {
		parent :: __construct($config);
    
        // browser paraméterek ellenörzése, ha kell javitása
        if (JRequest::getVar('limit')=='') JRequest::setVar('limit',20);
        if (JRequest::getVar('limitstart')=='') JRequest::setVar('limitstart',0);
        if (JRequest::getVar('order')=='') JRequest::setVar('order',1);

        // általánosan használt helper
        if (file_exists(JPATH_BASE.DS.'components'.DS.'com_temakorok'.DS.'helpers'.DS.'temakorok.php')) {
          include JPATH_BASE.DS.'components'.DS.'com_temakorok'.DS.'helpers'.DS.'temakorok.php';
          $this->temakorokHelper = new TemakorokHelper();
        }
    
        // saját helper
        //if (file_exists(JPATH_COMPONENT.DS.'helpers'.DS.'temakorok.php')) {
        //  include JPATH_COMPONENT.DS.'helpers'.DS.'temakorok.php';
        //  $this->helper = new TemakorokHelper();
        //}

		if(isset($config['viewname'])) $this->_viewname = $config['viewname'];
		if(isset($config['mainmodel'])) $this->_mainmodel = $config['mainmodel'];
		if(isset($config['itemname'])) $this->_itemname = $config['itemname']; 
		JRequest :: setVar('view', $this->_viewname);
        $this->temakor_id = JRequest::getVar('temakor',0);
        if ($this->temakor_id == '') $this->temakor_id = 0;
        $db = JFactory::getDBO();
        $temakorModel = new TemakorokModelTemakorok;
        $this->temakor = $temakorModel->getItem($this->temakor_id);
        $document =& JFactory::getDocument();
		$viewType	= $document->getType();
		$this->model = $this->getModel($this->_mainmodel);
        $this->view = $this->getView($this->_viewname,$viewType);
		$this->view->setModel($this->model,true);
        $db->setQuery('select * from #__tagok 
        where temakor_id="'.$this->temakor_id.'" and user_id="'.JFactory::getUser()->id.'"');
        $res = $db->loadObject();
        if ($res) {
          $this->temakor_admin = ($res->admin == 1);
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
   * nrowsw form
   * @return void
   * &JRequest: limit, limitstart, filterStr, order
   */            
	public function browse() {
    JHTML::_('behavior.modal'); 
    $total = 0;
    $pagination = null;
    $user = JFactory::getUser();
    $db = JFactory::getDBO();

    // hozzáférés ellenörzés
    if ($this->temakorokHelper->isAdmin($user) == false) {
      if ((($this->temakor->lathatosag == 1) & ($user->id == 0)) |
          (($this->temakor->lathatosag == 2) & ($this->temakorokHelper->userTag($this->temakor_id,$user) == false))
         ) {  
        $this->setMessage(JText::_('TEMAKOR_NEKED_NEM_ELERHETO'));
        $this->setRedirect(JURI::base().'index.php?option=com_temakorok&view=temakoroklist'.
               '&task=browse');
        $this->redirect();
      }
    }

    // alapértelmezett browser status beolvasása sessionból
    $session = JFactory::getSession();
    $brStatusStr = $session->get($this->NAME.'list_status');
    if ($brStatusStr == '') {
      $brStatusStr = '{"limit":20,"limitstart":0,"order":1,"filterStr":""}';
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
    //DBG echo '<p>'.$this->model->getDBO()->getQuery().'</p>';
    $this->view->set('Items',$items);
    
    // browser müködéshez linkek definiálása
    $reorderLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&temakor='.$this->temakor_id.
       '&filterStr='.urlencode($filterStr);
    $doFilterLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&temakor='.$this->temakor_id.
       '&order='.JRequest::getVar('order','1');
    $itemLink = JURI::base().'index.php?option=com_tagok&view=tagok&task=edit'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&filterStr='.urlencode($filterStr).
       '&temakor='.$this->temakor_id.
       '&order='.JRequest::getVar('order','1');
    $this->view->set('reorderLink',$reorderLink);
    $this->view->set('doFilterLink',$doFilterLink);
    $this->view->set('itemLink',$itemLink);
    $adminLink = '';
    $delLink = '';
    if ((TemakorokHelper::isAdmin($user)) |
        (TemakorokHelper::temakorAdmin($temakor_id,$user)))  {
       $adminLink = JURI::base().'index.php?option=com_tagok&view=tagok&task=admin'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart='.$limitStart.
       '&filterStr='.urlencode($filterStr).
       '&temakor='.$this->temakor_id.
       '&order='.JRequest::getVar('order','1');
       $delLink = JURI::base().'index.php?option=com_tagok&view=tagok&task=torol'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart='.$limitStart.
       '&filterStr='.urlencode($filterStr).
       '&temakor='.$this->temakor_id.
       '&order='.JRequest::getVar('order','1');
    }
    $this->view->set('adminLink',$adminLink);
    $this->view->set('delLink',$delLink);
    
    // akciók definiálása
    $akciok = array();
    if ($this->temakorokHelper->isAdmin($user) | 
        (($this->temakor_admin) & ($user->id > 0))
       ) {
      if ($this->temakor_id > 0) 
         $akciok['ujTag'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list&task=ujTag'.
         '&temakor='.$this->temakor_id;
    }  
    if ($this->temakor_id > 0)
      $akciok['temakor'] = JURI::base().'index.php?option=com_szavazasok&view=szavazasoklist&task=browse'.
       '&temakor='.$this->temakor_id;
    else
      $akciok['temakorok'] = JURI::base().'index.php?option=com_temakorok&view=temakoroklist&task=browse';
    $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                      '&id='.JText::_(strtoupper($this->NAME).'LIST_SUGO').'&Itemid=435&tmpl=component';
    $this->view->set('Akciok',$akciok);
    $this->view->set('Title',JText::_('TAGOK'));
    $this->view->set('Temakor',$this->temakor);
    //lapozósor definiálása
    jimport( 'joomla.html.pagination' );    
    $total = $this->model->getTotal($filterStr);
    $pagination = new JPagination($total, $limitStart, $limit);
    $pagination->setAdditionalUrlParam('order',$order);
    $pagination->setAdditionalUrlParam('filterStr',urlencode($filterStr));
    $pagination->setAdditionalUrlParam('temakor',$this->temakor_id);
    $this->view->set('LapozoSor', $pagination->getListFooter());
    $this->view->display();
  }
  /**
   * ujTag felvételi form
   * @return void
   * &JRequest: limit, limitstart, filterStr, order
   */            
	public function ujTag() {
    JHTML::_('behavior.modal'); 
    $total = 0;
    $pagination = null;
    $user = JFactory::getUser();
    $db = JFactory::getDBO();
    if ((!$this->temakorokHelper->isAdmin($user)) & 
        (!$this->temakor_admin)) {
        echo '<div class="">Access denied</div>';
        return;
    }    
    // alapértelmezett browser status beolvasása sessionból
    $session = JFactory::getSession();
    $brStatusStr = '{"limit":20,"limitstart":0,"order":1,"filterStr":""}';
    $brStatus = JSON_decode($brStatusStr);
    
    $limitStart = JRequest::getVar('limitstart',$brStatus->limitstart);
    $limit = JRequest::getVar('limit',$brStatus->limit);
    $order = JRequest::getVar('order',$brStatus->order);
    $filterStr = urldecode(JRequest::getVar('filterStr',$brStatus->filterStr));
    
    JRequest::setVar('limit',$limit);
    JRequest::setVar('limitstart',$limitStart);
    JRequest::setVar('order',$order);
    JRequest::setVar('filterStr',$filterStr);
    
   
    // adattábla tartalom elérése és átadása a view -nek
    $items = $this->model->getItems();
    
    //DBG echo $this->model->getDBO()->getQuery();
    
    $this->view->set('Items',$items);
    
    // browser müködéshez linkek definiálása
    $reorderLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list&tas=ujTag'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&temakor='.$this->temakor_id.
       '&filterStr='.urlencode($filterStr);
    $doFilterLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list&task=ujTag'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&temakor='.$this->temakor_id.
       '&order='.JRequest::getVar('order','1');
    if ($this->temakor_id > 0)   
       $itemLink = JURI::base().'index.php?option=com_tagok&view=tagok&task=doujtag'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&filterStr='.urlencode($filterStr).
       '&temakor='.$this->temakor_id.
       '&order='.JRequest::getVar('order','1');
    $this->view->set('reorderLink',$reorderLink);
    $this->view->set('doFilterLink',$doFilterLink);
    $this->view->set('itemLink',$itemLink);
    
    // akciók definiálása
    $akciok = array();
    if ($this->temakor_id > 0)
      $akciok['temakor'] = JURI::base().'index.php?option=com_szavazasok&view=szavazasoklist&task=browse'.
       '&temakor='.$this->temakor_id;
    else
      $akciok['temakorok'] = JURI::base().'index.php?option=com_temakorok&view=temakoroklist&task=browse';
    $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                      '&id='.JText::_('UJTAG_SUGO').'&Itemid=435&tmpl=component';
    $this->view->set('Akciok',$akciok);
    $this->view->set('Title',JText::_('UJTAG'));
    $this->view->set('Temakor',$this->temakor);
    //lapozósor definiálása
    jimport( 'joomla.html.pagination' );    
    $total = $this->model->getTotal($filterStr);
    $pagination = new JPagination($total, $limitStart, $limit);
    $pagination->setAdditionalUrlParam('order',$order);
    $pagination->setAdditionalUrlParam('filterStr',urlencode($filterStr));
    $pagination->setAdditionalUrlParam('temakor',$this->temakor_id);
    $this->view->set('LapozoSor', $pagination->getListFooter());
    $this->view->setLayout('ujtag');
    $this->view->display();
  }
  /**
   * ujtag tárolása
   * @return void
   * @JRequest integer temakor 
   * @JRequest integer tag
   */              
  public function doujtag() {
    $user = JFactory::getUser();
    $db = JFactory::getDBO();
    if ((!$this->temakorokHelper->isAdmin($user)) & 
        (!$this->temakor_admin)) {
        echo '<div class="">Access denied</div>';
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
    
    $db->setQuery('select * from #__tagok 
    where temakor_id="'.JRequest::getVar('temakor').'" and user_id="'.JRequest::getVar('tag').'"');
    $res = $db->loadObject();
    if ($res == false) {
      $db->setQuery('insert into #__tagok (temakor_id,user_id,admin)
      values ("'.JRequest::getVar('temakor').'","'.JRequest::getVar('tag').'",0);
      ');
      $db->query();
    } 
    
    // tag beirása az usergroup alá
    $db->setQuery('INSERT INTO #__user_usergroup_map
    select '.JRequest::getVar('tag').', id
    from #__usergroups
    where title =  "['.$this->temakor->id.'] '.$this->temakor->megnevezes.'"
    limit 1'
    );
    $db->query();
     
    $this->setMessage(JText::_('UJTAGFELVEVE'));
    $this->setRedirect(JURI::base().'index.php?option=com_tagok&view=tagoklist&temakor='.JRequest::getVar('temakor'));
    $this->redirect();    
  }
  /**
   * tag módosító form
   * @return void
   * @Jrequest integer $temakor        
   * @Jrequest integer $tag    
   */
   public function edit() {
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
    
    $db->setQuery('select u.*,t.admin 
    from #__users u
    left outer join #__tagok t
        on t.user_id = u.id and t.temakor_id = '.JRequest::getVar('temakor',0).'
    where u.id='.JRequest::getVar('tag'));
    $item = $db->loadObject();
    $this->view->set('Item',$item);
    $this->view->set('Temakor',$this->temakor);
    if (($this->temakor_id > 0) &
        ($this->temakor_admin | $this->temakorokHelper->isAdmin($this->temakor_id,$user))) {
       $this->view->set('Title',JText::_('TAGMODOSITAS'));
       $this->view->set('Mode','edit');
    } else {
       $this->view->set('Title',JText::_('TAG'));
       $this->view->set('Mode','show');
    } 
     // akciók definiálása
    $akciokk=array();
    $akciok['ok'] = JURI::base().'index.php?option=com_tagok&view=tagok&task=save';
    if (($this->temakor_id > 0) &
        ($this->temakor_admin | $this->temakorokHelper->isAdmin($this->temakor_id,$user))
       ) 
      $akciok['delete'] = JURI::base().'index.php?option=com_tagok&view=tagok&task=deleteform'.
              '&temakor='.$this->temakor_id.
              '&tag='.JRequest::getVar('tag');
    $akciok['cancel'] = JURI::base().'index.php?option=com_tagok&view=tagoklist&task=browse&temakor='.$this->temakor->id;
    $akciok['sendmail'] = JURI::base().'index.php?option=com_tagok&view=tagok&task=mailform&temakor='.$this->temakor->id.
       '&tag='.JRequest::getVar('tag').'&nick='.$item->username;
    $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                        '&id='.JText::_('TAGMODOSITAS_SUGO').'&Itemid=435&tmpl=component';      
    $this->view->set('Akciok',$akciok);
    $this->view->setLayout('form');
    $this->view->display();
   }
   /**
    * delete form kirajzolása
    * @return void
    * @JRequest integer temakor
    * @JRequest integer tag
    */ 
    public function deleteform() {
     $user = JFactory::getUser();
     if ((!$this->temakorokHelper->isAdmin($user)) & 
        (!$this->temakor_admin)) {
        echo '<div class="">Access denied</div>';
        return;
     }
     $db = JFactory::getDBO();
     $db->setQuery('select u.*,t.admin 
     from #__users u
     left outer join #__tagok t
        on t.user_id = u.id and t.temakor_id = '.JRequest::getVar('temakor',0).'
     where u.id='.JRequest::getVar('tag'));
     $item = $db->loadObject();
     $this->view->set('Item',$item);
     $this->view->set('Temakor',$this->temakor);
     $this->view->set('Title',JText::_('TAGTORLES'));
     
     // akciók definiálása
     $akciokk=array();
     $akciok['ok'] = JURI::base().'index.php?option=com_tagok&view=tagok&task=delete'.
             '&temakor='.$this->temakor_id.
             '&tag='.JRequest::getVar('tag');
     $akciok['cancel'] = JURI::base().'index.php?option=com_tagok&view=tagoklist&task=browse&temakor='.$this->temakor->id;
     $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                        '&id='.JText::_('TAGTORLES_SUGO').'&Itemid=435&tmpl=component';      
     $this->view->set('Akciok',$akciok);
     $this->view->setLayout('delete');
     $this->view->display();
    }
    /**
     * tag törlése
     * @return void
     * @JRequest integer temakor
     * @JRequest integer tag
     */
     public function delete() {
       $user = JFactory::getUser();
       if ((!$this->temakorokHelper->isAdmin($user)) & 
           (!$this->temakor_admin) & 
		   ($user->id != JRequest::getVar('tag'))
		  ) {
        echo '<div class="">Access denied</div>';
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

       $session = JFactory::getSession();
       $secret = $session->get('secret');
       if (JRequest::getVar($secret) != '1') {
        echo '<div class="">Access denied. wrong secret code.</div>';
        return;
       }
       $db = JFactory::getDBO();
       
       $db->setQuery('delete from #__tagok
       where temakor_id="'.JRequest::getVar('temakor').'" and user_id="'.JRequest::getVar('tag').'"');
       if ($db->query()) {
         $this->setMessage(JText::_('TAGTOROLVE'));
       } else {
         $this->setMessage($db->getErrorMsg());
       }  

       $db->setQuery('select id from #__usergroups
       where title="['.$this->temakor->id.'] '.$this->temakor->megnevezes.'"
       ');
       $res = $db->loadObject();
       if ($res) {
         $db->setQuery('delete from #__user_usergroup_map
         where group_id="'.$res->id.'" and user_id="'.JRequest::getVar('tag').'"');
         $db->query();
       }
       
       $this->setRedirect(JURI::base().'index.php?option=com_tagok&view=tagoklist&temakor='.JRequest::getVar('temakor'));
       $this->redirect();    
     }
     /**
      * tag módositás tárolása
      * @return void
      * @JRequest integer temakor
      * @JRequest integer tag
      */                              
     public function save() {
       // Check for request forgeries
       JRequest :: checkToken() or jexit('Invalid Token');
       $user = JFactory::getUser();
       if ((!$this->temakorokHelper->isAdmin($user)) & 
        (!$this->temakor_admin)) {
        echo '<div class="">Access denied</div>';
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
       
       $db->setQuery('update #__tagok
       set admin="'.JRequest::getVar('admin').'"
       where user_id="'.JRequest::getVar('tag').'" and temakor_id="'.JRequest::getVar('temakor').'";
       ');
       if ($db->query()) 
         $this->setMessage(JText::_('TAGMODOSITVA'));
       else
         $this->setMessage($db->getErrorMsg());
       $this->setRedirect(JURI::base().'index.php?option=com_tagok&view=tagoklist&temakor='.JRequest::getVar('temakor'));
       $this->redirect();    
     }
     /**
      * user jelentkezik témakör tagnak
      * @return void
      * @JRequest integer temakor
      * @JRequest integer user
      */                              
     public function jelentkezes() {
       $db = JFactory::getDBO();
       $user = JFactory::getUser();
       $user_id = JRequest::getVar('user',0);
       
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
       
       if (($this->temakor_id > 0) & ($user_id > 0) & ($user->id == $user_id)) {
         $db->setQuery('select * from #__tagok where temakor_id='.$this->temakor_id.' and user_id='.$user_id);
         $res = $db->loadObject();
         if ($res == false) {
            $db->setQuery('insert into #__tagok (temakor_id,user_id,admin)
            values ("'.$this->temakor_id.'","'.$user_id.'",0)');
            $db->query();
           $this->setMessage(JText::_('UJTAGFELVEVE'));
           $this->setRedirect(JURI::base().'index.php?option=com_tagok&view=tagoklist&temakor='.JRequest::getVar('temakor'));
           $this->redirect();    
         } else {
           $this->setMessage(JText::_('MARTAG'));
           $this->setRedirect(JURI::base().'index.php?option=com_tagok&view=tagoklist&temakor='.JRequest::getVar('temakor'));
           $this->redirect();    
         }
       } else {
           $this->setMessage('access denied');
           $this->setRedirect(JURI::base().'index.php?option=com_tagok&view=tagoklist&temakor='.JRequest::getVar('temakor'));
           $this->redirect();    
       }
     }
     /**
      * e-mail küldés adott usernek form
      * @return void
      * @JRequest integer temakor
      * @JRequest integer tag
      * @JRequest string nick  
      * @JRequest string return (opcionális)                            
      */            
     public function mailform() {
       echo 'email form';
       $session = JFactory::getSession();
       $secret = md5(date('ymdhis'));
       $session->set('secret',$secret);
       $sender = JFactory::getUser();
       $to = JFactory::getUser(JRequest::getVar('tag'));
       if ($to->username != JRequest::getVar('nick')) {
         echo '<div class="errorMsg">Access denied</div>';
         return;
       }
       $return = JRequest::getVar('return','');
       if ($return != '')
         $cancelLink = base64_decode($return);
        else
         $cancelLink = JURI::base()."index.php?option=com_tagok&view=tagoklist&temakor=".JRequest::getVar('temakor',0);
       if (($sender->id > 0) & ($to->id > 0)) {
         echo '<form action="'.JURI::base().'index.php?option=com_tagok&view=tagok&task=mail" method="post">
           <input type="hidden" name="temakor" value="'.JRequest::getVar('temakor').'" />
           <input type="hidden" name="tag" value="'.JRequest::getVar('tag').'" />
           <input type="hidden" name="return" value="'.JRequest::getVar('return','').'" />
           <input type="hidden" name="'.$secret.'" value="1" />
           <h2>'.JText::_('EMAILTKULD').'</h2>
           <h3>'.JText::_('CIMZETT').':'.$to->name.' ('.$to->username.')</h3>
           <p>'.JText::_('TARGY').'</p>
           <p><input type="text" name="targy" size="80" style="width:400px;" /></p>
           <p>'.JText::_('SZOVEG').':</p>
           <p><textarea name="szoveg" rows="10" cols="80" style="width:400px"></textarea></p>
           <p>&nbsp;</p>
           <center>
             <button type="submit" class="akcioGomb btnOK">'.JText::_('RENDBEN').'</button>
             <button type="button" onclick="location='."'".$cancelLink."';".'" 
                     class="akcioGomb btnCancel">'.JText::_('MEGSEM').'</button>
           </center>
         </form>
         ';
       } else {
          echo '<div class="errorMsg">Acces denied, login requed</div>';
          return;
       }
     }
     /**
      * levél elküldése
      * @return void
      * @JRequest integer temakor
      * @JRequest integer tag
      * @JRequest string targy
      * @JRequest string szoveg
      * @JRequest urlencoded string return   (opcionális)   
      */                                          
     public function mail() {
     
        $session = JFactory::getSession();
        $secret = $session->get('secret','@');
        $sender = JFactory::getUser();
        $to = JFactory::getUser(JRequest::getVar('tag'));
        $return = JRequest::getVar('return','');
        $return = urldecode($return);
        if (($sender->id <= 0) | ($to->id <= 0) | (JRequest::getVar($secret)!=1)) {
          echo '<div class="errorMsg">Acces denied</div>';
          return;
        }
        $mail = JFactory::getmailer();
        $mail->CharSet = 'utf-8';
        //$mail->clearAllRecipient();
        $mail->addRecipient($to->email);
        $mail->isHTML(false);
        $mail->setBody(JRequest::getVar('szoveg'));
        $mail->setSubject(JRequest::getVar('targy'));
        $sender = array();
        $sender[0] = $sender->email;
        $sender[1] = $sender->name;
        $mail->setSender($sender);
        if ( $mail->send()) {
          $this->setMessage(JText::_('EMAILKULDVE'));
        } else {
          $this->setMessage('error in send email '.
          '<br />to:'.$to->email.
          '<br />from:'.$sender->email.
          '<br />subject:'.JRequest::getVar('targy').
          '<br />body:'.JRequest::getVar('szoveg'));
        }  
        if ($return != '')
          $this->setRedirect($return);
        else
          $this->setRedirect(JURI::base().'index.php?option=com_tagok&view=tagoklist&temakor='.JRequest::getVar('temakor'));
        $this->redirect();
     }
     /**
      * delete my account első képernyő
      */
      public function deletemyaccount() {
        $user = JFactory::getUser();
        if ($user-yid > 0) {
          echo '<h1>FIGYELEM!  Ha a tovább linkre kattint véglegesen törlődik a fiókja amivel jelenleg ezt az oldalt használja!</h1>';
          echo '<p> <p><center><a style="background-color:red; color:white; padding:5px; font-size:18px; font-weight:bolder" href="index.php?option=com_tagok&task=deletemyaccount2">Tovább; a fiók végleges törléséhez</a></center>';
          echo '<p> </p>';
        } else {
          $this->setRedirect('index.php');
          $this->redirect();
        }
      }
     /**
      * delete my account végrehajtása
      */
      public function deletemyaccount2() {
        $user = JFactory::getUser();
        $db = JFactory::getDBO();
        if ($user->id > 0) {
          $user->username = "deleted_".$user->id;
          $user->email = $user->username;
          $user->password = md5($user->username.rand(1000.2000));
          $db->setQuery('update #__users set 
           username="'.$user->username.'", 
           email="'.$user->email.'", password="'.$user->password.'", block=1
           where id="'.$user->id.'"');
          $db->query();
          $userToken = JSession::getFormToken();
          $this->setRedirect('index.php?option=com_users&task=user.logout&'.$userToken.'=1');
          $this->redirect();
        }
      }
    /**
      * admin task
      * feladat a JRequest -ben adott rekordban az ADMIN jellemző módosítása
      * ezután redirekt a browserre
      */
    public function admin() {
      $user = JFactory::getUser();  
      $id = JRequest::getVar('id',0);
      $temakor = JRequest::getVar('temakor',0);
      if ((TemakorokHelper::isAdmin($user)) |
        (TemakorokHelper::temakorAdmin($temakor,$user)))  {
        $db = JFactory::getDBO();
        $db->setQuery('update #__tagok
        set admin=if(admin=1,0,1)
        where temakor_id="'.$temakor.'" and user_id="'.$id.'"');
        $db->query();        
      }
      $this->setRedirect(JURI::base().'index.php?option=com_tagok&view=tagoklist&temakor='.JRequest::getVar('temakor'));
      $this->redirect();
    }      
   /**
      * delete task
      * feladat a JRequest -ben adott rekord törlése
      * ezután redirekt a browserre
      */
    public function torol() {
      $user = JFactory::getUser();  
      $id = JRequest::getVar('id',0);
      $temakor = JRequest::getVar('temakor',0);
      if ((TemakorokHelper::isAdmin($user)) |
          (TemakorokHelper::temakorAdmin($temakor,$user)))  {
        if ($id != $user->id) {      
          $db = JFactory::getDBO();
          $db->setQuery('delete from #__tagok
          where temakor_id="'.$temakor.'" and user_id="'.$id.'"');
          $db->query();        
        }
      }
      $this->setRedirect(JURI::base().'index.php?option=com_tagok&view=tagoklist&temakor='.JRequest::getVar('temakor'));
      $this->redirect();
    }      
}// class
  
?>