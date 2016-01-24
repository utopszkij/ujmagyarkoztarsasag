<?php
/**
* @version		$Id:controller.php  1 2013-09-17Z FT $
* @package		Joomla site
* @subpackage amcomponent defview controller
* @copyright	Copyright (C) 2013, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');
/**
 * Variant Controller
 *
 * @package    
 * @subpackage Controllers
 */
class DefviewController extends JControllerLegacy {
	protected $viewName = '';
  protected $helper = false;
 	/**
	 * Constructor
	 */
	public function __construct() {
		parent :: __construct();
	}
  public function setViewName($value) {
    $this->viewName = $value;
    // load language file
    $lang = JFactory::getLanguage();
    $extension = JRequest::getVar('option').'_'.$value;
    $base_dir = JPATH_SITE;
    $language_tag = $lang->getTag();
    $reload = true;
    $lang->load($extension, $base_dir, $language_tag, $reload);	
  }
  /**
   * display editor form
   * JRequest: ordering, limitstart, limit, filterStr, parent, id, Itemid     
   */
  public function edit() {
    if (file_exists(JPATH_COMPONENT.DS.'helpers'.DS.$this->viewName.'.php')) {
      include_once JPATH_COMPONENT.DS.'helpers'.DS.$this->viewName.'.php';
      $helperName = ucfirst($this->viewName).'Helper';
      $this->helper = new $helperName ();
    }
    $model = $this->getModel($this->viewName);
    $model->setViewname($this->viewName);
    $view = $this->getView($this->viewName,'html');
    $view->setViewname($this->viewName);
    $view->setModel($model);
    
    // push lister staus to listStatusStack
    $session = JFactory::getSession();
    $listStatusStack = JSON_decode( $session->get('listStatusStack','[]'));
    $listStatusStr = '{"ordering":"'.JRequest::getVar('ordering','id').'",'.
'"limitstart":"'.JRequest::getVar('limitstart','0').'",'.
'"limit":"'.JRequest::getVar('limit','20').'",'.
'"Itemid":"'.JRequest::getVar('Itemid','0').'",'.
'"filterStr":"'.JRequest::getVar('filterStr','').'",'.
'"parent":"'.JRequest::getVar('parent','').'"}';
    $listStatusStack[] = JSON_decode( $listStatusStr );               
    $session->set('listStatusStack', JSON_encode($listStatusStack)); 

    $item = $model->getItem(JRequest::getVar('id'));
    if ($this->helper) {
       if (!$this->helper->accessRight($item,'edit')) {
            $this->setMessage(JText::_(strtoupper($this->viewName).'_ACCES_DENIED'));
            $this->cancel();
            return;
       }
    }
    $view->Item = $item;
    $view->Title = JText::_(strtoupper($this->viewName).'_EDIT');
    $view->setLayout('form');
    $view->display();
    return;
  }
  /**
   * display add form
   * JRequest: ordering, limitstart, limit, filterStr, parent, id, Itemid     
   */
  public function add() {
    if (file_exists(JPATH_COMPONENT.DS.'helpers'.DS.$this->viewName.'.php')) {
      include_once JPATH_COMPONENT.DS.'helpers'.DS.$this->viewName.'.php';
      $helperName = ucfirst($this->viewName).'Helper';
      $this->helper = new $helperName ();
    }
    $model = $this->getModel($this->viewName);
    $model->setViewname($this->viewName);
    $view = $this->getView($this->viewName,'html');
    $view->setViewname($this->viewName);
    $view->setModel($model);
    
    // push lister staus to listStatusStack
    $session = JFactory::getSession();
    $listStatusStack = JSON_decode( $session->get('listStatusStack','[]'));
    $listStatusStr = '{"ordering":"'.JRequest::getVar('ordering','id').'",'.
'"limitstart":"'.JRequest::getVar('limitstart','0').'",'.
'"limit":"'.JRequest::getVar('limit','20').'",'.
'"Itemid":"'.JRequest::getVar('Itemid','0').'",'.
'"filterStr":"'.JRequest::getVar('filterStr','').'",'.
'"parent":"'.JRequest::getVar('parent','').'"}';
    $listStatusStack[] = JSON_decode( $listStatusStr );               
    $session->set('listStatusStack', JSON_encode($listStatusStack)); 

    $item = $model->getItem(0);
    if ($this->helper) {
       if (!$this->helper->accessRight($item,'add')) {
            $this->setMessage(JText::_(strtoupper($this->viewName).'_ACCES_DENIED'));
            $this->cancel();
            return;
       }
    }
    $view->Item = $item;
    $view->Title = JText::_(strtoupper($this->viewName).'_ADD');
    $view->setLayout('form');
    $view->display();
    return;
  }
  /**
   * display show form
   * @request: ordering, limitstart, limit, filterStr, parent, id, Itemid 
   * @session {$id}_poll
   * @result void
   */
  public function show() {
    if (file_exists(JPATH_COMPONENT.DS.'helpers'.DS.$this->viewName.'.php')) {
      include_once JPATH_COMPONENT.DS.'helpers'.DS.$this->viewName.'.php';
      $helperName = ucfirst($this->viewName).'Helper';
      $this->helper = new $helperName ();
    }
    $model = $this->getModel($this->viewName);
    $model->setViewname($this->viewName);
    $view = $this->getView($this->viewName,'html');
    $view->setViewname($this->viewName);
    $view->setModel($model);
    
    // push lister staus to listStatusStack
    $session = JFactory::getSession();
    $listStatusStack = JSON_decode( $session->get('listStatusStack','[]'));
    $listStatusStr = '{"ordering":"'.JRequest::getVar('ordering','id').'",'.
'"limitstart":"'.JRequest::getVar('limitstart','0').'",'.
'"limit":"'.JRequest::getVar('limit','20').'",'.
'"Itemid":"'.JRequest::getVar('Itemid','0').'",'.
'"filterStr":"'.JRequest::getVar('filterStr','').'",'.
'"parent":"'.JRequest::getVar('parent','').'"}';
    $listStatusStack[] = JSON_decode( $listStatusStr );               
    $session->set('listStatusStack', JSON_encode($listStatusStack)); 

    $item = $model->getItem(JRequest::getVar('id'));
    if ($this->helper) {
       if (!$this->helper->accessRight($item,'show')) {
            $this->setMessage(JText::_(strtoupper($this->viewName).'_ACCES_DENIED'));
            $this->cancel();
            return;
       }
    }
    $view->Item = $item;
    $view->Title = JText::_(strtoupper($this->viewName).'_SHOW');
    $view->setLayout('show');
    $view->display();
    return;
  }
  
  /**
   * save data from POST
   * JRequest: form fields     
   */       
  public function save($redirec = true) {
    $fn = '';
    $fv = '';
    JRequest :: checkToken() or jexit('Invalid Token');		
    if (file_exists(JPATH_COMPONENT.DS.'helpers'.DS.$this->viewName.'.php')) {
      include_once JPATH_COMPONENT.DS.'helpers'.DS.$this->viewName.'.php';
      $helperName = ucfirst($this->viewName).'Helper';
      $this->helper = new $helperName ();
    }
    $model = & $this->getModel($this->viewName);
    $model->setViewname($this->viewName);
    $form = &JForm::getInstance($this->viewName,
           JPATH_COMPONENT.DS.'models'.DS.'forms/'.$this->viewName.'.xml');     
    // bind item from POST
    $item0 = $model->getItem(JRequest::getVar('id',0));
    $item = array();
    foreach ($item0 as $fn => $fv) {
      // a html kodot is tartalmazható elemeket másképpen kell beolvasni!
      $field = $form->getField($fn);
      if ($field) {
        if ($field->type == 'editor')
           $item[$fn] = JRequest::getVar($fn,$item0->$fn,'POST','STRING',JREQUEST_ALLOWHTML);
        else
           $item[$fn] = JRequest::getVar($fn,$item0->$fn);
      }   
    }
    // checkboxok kezelése
    //if ($item['publish']=='') $item['publish'] = '0';
    
    if ($this->helper) {
       if (!$this->helper->accessRight($item,'save')) {
            $this->setMessage(JText::_(strtoupper($this->viewName).'_ACCES_DENIED'));
            $this->cancel();
            return;
       }
    }
    
    if ($model->check($item)) {
          if ($model->save($item)) {
            $this->setMessage(JText::_(strtoupper($this->viewName).'_SAVED'));
            if ($redirect)
               $this->cancel();
            else
               return;   
          } else {
            $this->setMessage($model->getErrorMsg());
            $this->cancel();
          }  
    } else {
      $app = JFactory::getApplication(); 
      $app->enqueueMessage($model->getErrorMsg(), 'error');
  		$view = & $this->getView($this->viewName,'html');
      $view->setViewname($this->viewName);
  		$model = & $this->getModel($this->viewName);
  		$view->setModel($model);		
      $view->setLayout('form');		
      $view->Item = $item;
      if ($item->id == 0)
        $view->Title = JText::_(strtoupper($this->viewName).'_ADD');
      else
        $view->Title = JText::_(strtoupper($this->viewName).'_EDIT');
      $view->setLayout('form');
	  	$view->display();
    }
  }
  /**
   * do cancelClick: redirect to lister
   * JRequest: --     
   */      
  public function cancel() {
    // pop lister status from listStatusStack
    $session = JFactory::getSession();
    $listStatusStack = JSON_decode( $session->get('listStatusStack','[]'));
    $listStatus = $listStatusStack[count($listStatusStack) - 1];
    unset($listStatusStack[count($listStatusStack) - 1]);
    $link = JURI::base().'index.php?option='.JRequest::getVar('option').
    '&task='.$this->viewName.'.list'.
    '&limitstart='.$listStatus->limitstart.
    '&limit='.$listStatus->limit.
    '&ordering='.$listStatus->ordering.
    '&parent='.$listStatus->parent.
    '&filterStr='.url_encode($listStatus->filterStr).
    '&Itemid='.$listStatus->Itemid;
    $this->setRedirect($link);
  }
  /**
   * delete data from database
   * JRequest: id     
   */
  public function delete() {
     if (file_exists(JPATH_COMPONENT.DS.'helpers'.DS.$this->viewName.'.php')) {
      include_once JPATH_COMPONENT.DS.'helpers'.DS.$this->viewName.'.php';
      $helperName = ucfirst($this->viewName).'Helper';
      $this->helper = new $helperName ();
    }
		$model = & $this->getModel($this->viewName);
    $model->setViewname($this->viewName);
    $form = &JForm::getInstance($this->viewName,
           JPATH_COMPONENT.DS.'models'.DS.'forms'.DS.$this->viewName.'.xml');     
    // bind item from POST
    $id = JRequest::getVar('id',0);
    $item = $model->getItem($id);

    if ($this->helper) {
       if (!$this->helper->accessRight($item,'delete')) {
            $this->setMessage(JText::_(strtoupper($this->viewName).'_ACCES_DENIED'));
            $this->cancel();
            return;
       }
    }

    // check 
    if ($model->canDelete($id)) {
          if ($model->delete($id)) {
            $this->setMessage(JText::_(strtoupper($this->viewName).'_DELETED'));
            $this->cancel();
          } else {
            $this->setMessage($model->getErrorMsg());
            $this->cancel();
          }  
    } else {
          $this->setMessage($model->getErrorMsg());
          $this->cancel();
    }
  }       
  /**
   * list
   * JRequest ordering,limitstart,limit,filterStr   
   */
  public function browse() {
     if (file_exists(JPATH_COMPONENT.DS.'helpers'.DS.$this->viewName.'.php')) {
      include_once JPATH_COMPONENT.DS.'helpers'.DS.$this->viewName.'.php';
      $helperName = ucfirst($this->viewName).'Helper';
      $this->helper = new $helperName ();
    }
    $model = $this->getModel($this->viewName);
    $model->setViewName($this->viewName);
    $view = $this->getView($this->viewName,'html');
    $view->setViewName($this->viewName);
    $view->setModel($model);
    $view->helper = $this->helper;
    $items = $model->getItems(JRequest::getVar('ordering','id'),
                              JRequest::getVar('limitstart',0),
                              JRequest::getVar('limit',20),
                              url_decode(JRequest::getVar('filterStr','')));
    if ($this->helper) {
       if (!$this->helper->accessRight($items,'list')) {
            // if acces denied in other method then 
            //    the other method set errorMessage
            //    the other method call cancel method
            //    the cancell method call this method
            // error message set only if before not set 
            if ($this->getMessage()=='')
              $this->setMessage(JText::_(strtoupper($this->viewName).'_ACCES_DENIED'));
            $this->setRedirect('index.php');
            return;
       }
    }
    $view->Items = $items;
    $view->Total = $model->getTotal(JRequest::getVar('filterStr',''));
    $view->Title = JText::_(strtoupper($this->viewName).'_LIST');
    $view->setLayout('default');
    $view->display('buttons');
    $view->display('filterform');
    $view->display('list');
    return;
  }       

  /**
    * default display method (not used)
  */      
	public function display() {
		$document =& JFactory::getDocument();
		$viewType	= $document->getType();
		$view = & $this->getView($this->viewName,$viewType);
		$model = & $this->getModel($this->viewName);
		$view->setModel($model,true);		
    $view->setLayout('form');		
		$view->display();
	}
}// class
?>