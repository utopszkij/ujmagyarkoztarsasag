<?php
/**
* @version		$Id:controller.php  1 2013-09-17Z FT $
* @package		Joomla site
* @subpackage amcomponent components controller
* @copyright	Copyright (C) 2013, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');
require 'components/com_ammvc/assets/PHP-Parser-0.9.3/lib/bootstrap.php'; 
require 'components/com_ammvc/assets/includes/phpchecker.php'; 
/**
 * Variant Controller
 *
 * @package    
 * @subpackage Controllers
 */
class ComponentsController extends JControllerLegacy {
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
    $extension = 'com_ammvc_'.$value;
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
      include JPATH_COMPONENT.DS.'helpers'.DS.$this->viewName.'.php';
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
   * file editor
   * @param string $fileName
   * @param string $title
   * @param string $tmplName      
   **/     
   protected function editfile($title,$tmplName) {
    $this->save(false);
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
    
    $item = $model->getItem(JRequest::getVar('id'));
    if ($title == 'MODEL')
      $fileName = JPATH_COMPONENT.DS.'models'.DS.$item->name.'.php';
    else if ($title == 'VIEW')
      $fileName = JPATH_COMPONENT.DS.'views'.DS.$item->name.DS.'view.html.php';
    else if ($title == 'CONTROLLER')
      $fileName = JPATH_COMPONENT.DS.'controllers'.DS.$item->name.'.php';
    else if ($title == 'HELPER')
      $fileName = JPATH_COMPONENT.DS.'helpers'.DS.$item->name.'.php';
    else if ($title == 'TABLE')
      $fileName = JPATH_COMPONENT.DS.'tables'.DS.$item->name.'.php';
    else if ($title == 'FORM XML')
      $fileName = JPATH_COMPONENT.DS.'models'.DS.'forms'.DS.$item->name.'.xml';
    else if ($title == 'CSS')
      $fileName = JPATH_COMPONENT.DS.'assets'.DS.$item->name.'.css';
    else if ($title == 'Language en-GB')
      $fileName = JPATH_SITE.DS.'language'.DS.'en-GB'.DS.'en-GB.com_ammvc_'.$item->name.'.ini';
    else if ($title == 'Language hu-HU')
      $fileName = JPATH_SITE.DS.'language'.DS.'hu-HU'.DS.'hu-HU.com_ammvc_'.$item->name.'.ini';
    else if ($title == 'TMPL default_list')
      $fileName = JPATH_COMPONENT.DS.'views'.DS.$item->name.DS.'tmpl'.DS.'default_list.php';
    else if ($title == 'TMPL default_buttons')
      $fileName = JPATH_COMPONENT.DS.'views'.DS.$item->name.DS.'tmpl'.DS.'default_buttons.php';
    else if ($title == 'TMPL default_filterform')
      $fileName = JPATH_COMPONENT.DS.'views'.DS.$item->name.DS.'tmpl'.DS.'default_filterform.php';
    else if ($title == 'TMPL form')
      $fileName = JPATH_COMPONENT.DS.'views'.DS.$item->name.DS.'tmpl'.DS.'form.php';
    else if ($title == 'TMPL show')
      $fileName = JPATH_COMPONENT.DS.'views'.DS.$item->name.DS.'tmpl'.DS.'show.php';
    else
      $filename = '???';  
      
    $item->fileName = $fileName;
    if ($this->helper) {
       if (!$this->helper->accessRight($item,'edit')) {
            $this->setMessage(JText::_(strtoupper($this->viewName).'_ACCES_DENIED'));
            $this->cancel();
            return;
       }
    }
    if (file_exists($fileName)) {
      $item->lines = file($fileName);
      // textarea problem
      for ($i=0; $i<count($item->lines); $i++) {
        $item->lines[$i] = str_replace('<textarea>','{textarea}',$item->lines[$i]);
        $item->lines[$i] = str_replace('</textarea>','{/textarea}',$item->lines[$i]);
      }
    } else {
      $item->lines = array();
      $item->lines[] = $fileName.' file not found ';
    }
    $view->Item = $item;
    $view->Title = $item->name.' '.$title;
    $view->setLayout($tmplName);
    $view->display();
    return;
   }    
  /**
   * model editor form kirajzolása
   * @pram none
   * @return void
   * @JRequest integer id
   */               
  public function editmodel() {
    $this->editfile('MODEL','editmodel');
    return;
  }
  /**
   * viewer editor form kirajzolása
   * @pram none
   * @return void
   * @JRequest integer id
   */               
  public function editview() {
    $this->editfile('VIEW','editview');
    return;
  }
   /**
   * controller editor form kirajzolása
   * @pram none
   * @return void
   * @JRequest integer id
   */               
  public function editcontroller() {
    $this->editfile('CONTROLLER','editcontroller');
    return;
  }
  /**
   * helper editor form kirajzolása
   * @pram none
   * @return void
   * @JRequest integer id
   */               
  public function edithelper() {
    $this->editfile('HELPER','edithelper');
    return;
  }
  /**
   * table editor form kirajzolása
   * @pram none
   * @return void
   * @JRequest integer id
   */               
  public function edittable() {
    $this->editfile('TABLE','edittable');
    return;
  }
  /**
   * formxml editor form kirajzolása
   * @pram none
   * @return void
   * @JRequest integer id
   */               
  public function editformxml() {
    $this->editfile('FORM XML','editformxml');
    return;
  }
  /**
   * css editor form kirajzolása
   * @pram none
   * @return void
   * @JRequest integer id
   */               
  public function editcss() {
    $this->editfile('CSS','editcss');
    return;
  }
  /**
   * Language en-GB editor form kirajzolása
   * @pram none
   * @return void
   * @JRequest integer id
   */               
  public function editen() {
    $this->editfile('Language en-GB','editen');
    return;
  }
  /**
   * Language hu-HU editor form kirajzolása
   * @pram none
   * @return void
   * @JRequest integer id
   */               
  public function edithu() {
    $this->editfile('Language hu-HU','edithu');
    return;
  }
  /**
   * default-list template editor form kirajzolása
   * @pram none
   * @return void
   * @JRequest integer id
   */               
  public function editlist() {
    $this->editfile('TMPL default_list','editlist');
    return;
  }
  /**
   * default-buttons template editor form kirajzolása
   * @pram none
   * @return void
   * @JRequest integer id
   */               
  public function editbuttons() {
    $this->editfile('TMPL default_buttons','editbuttons');
    return;
  }
  /**
   * default-filterform template editor form kirajzolása
   * @pram none
   * @return void
   * @JRequest integer id
   */               
  public function editfilterform() {
    $this->editfile('TMPL default_filterform','editfilterform');
    return;
  }
  /**
   * form template editor form kirajzolása
   * @pram none
   * @return void
   * @JRequest integer id
   */               
  public function editform() {
    $this->editfile('TMPL form','editform');
    return;
  }
  /**
   * show template editor form kirajzolása
   * @pram none
   * @return void
   * @JRequest integer id
   */               
  public function editshow() {
    $this->editfile('TMPL show','editshow');
    return;
  }
  

  /**
   * display add form
   * JRequest: ordering, limitstart, limit, filterStr, parent, id, Itemid     
   */
  public function add() {
    if (file_exists(JPATH_COMPONENT.DS.'helpers'.DS.$this->viewName.'.php')) {
      include JPATH_COMPONENT.DS.'helpers'.DS.$this->viewName.'.php';
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
      include JPATH_COMPONENT.DS.'helpers'.DS.$this->viewName.'.php';
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
  public function save($redirect = true) {
    JRequest :: checkToken() or jexit('Invalid Token');		
    if (file_exists(JPATH_COMPONENT.DS.'helpers'.DS.$this->viewName.'.php')) {
      include JPATH_COMPONENT.DS.'helpers'.DS.$this->viewName.'.php';
      $helperName = ucfirst($this->viewName).'Helper';
      $this->helper = new $helperName ();
    }
    $model = & $this->getModel($this->viewName);
    $model->setViewname($this->viewName);
    $form = &JForm::getInstance($this->viewName,
           JPATH_COMPONENT.DS.'models'.DS.'forms/'.$this->viewName.'.xml');     
    // bind item from POST
    $item0 = $model->getItem(JRequest::getvar('id',0));
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
          // save lines to file
          if (isset($_POST['lines'])) {
             $item['lines'] = $_POST['lines'];
             $item['fileName'] = $_POST['fileName'];
          } else {
             $item['lines'] = false;
          }
          
          // echo '<p>controller save <pre><code>'.$item['lines'].'</code></pre></p>'; exit();
          
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
      JFactory::getApplication()->enqueueMessage($model->getErrorMsg(), 'error');
  		$view = & $this->getView($this->viewName,'html');
      $view->setViewname($this->viewName);
  		$model = & $this->getModel($this->viewName);
  		$view->setModel($model);		
      $view->setLayout('form');		
      $view->Item = $item;
      if ($item['id'] == 0)
        $view->Title = JText::_(strtoupper($this->viewName).'_ADD');
      else
        $view->Title = JText::_(strtoupper($this->viewName).'_EDIT');
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
    $link = JURI::base().'index.php?option=com_ammvc'.
    '&task='.$this->viewName.'.list'.
    '&limitstart='.$listStatus->limitstart.
    '&limit='.$listStatus->limit.
    '&ordering='.$listStatus->ordering.
    '&parent='.$listStatus->parent.
    '&filterStr='.$listStatus->filterStr;
    $this->setRedirect($link);
  }
  /**
   * delete data from database
   * JRequest: id     
   */
  public function delete() {
     if (file_exists(JPATH_COMPONENT.DS.'helpers'.DS.$this->viewName.'.php')) {
      include JPATH_COMPONENT.DS.'helpers'.DS.$this->viewName.'.php';
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
      include JPATH_COMPONENT.DS.'helpers'.DS.$this->viewName.'.php';
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
                              JRequest::getVar('filterStr',''));
    if ($this->helper) {
       if (!$this->helper->accessRight($items,'list')) {
          //if ($this->getMessage()=='')
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
   * php check
   * @param string lines
   * @param string fileName
   * @param string caller          
   */     
  public function phpcheck() {
    $code = $_POST['lines'];
    $code = str_replace('{textarea','<textarea',$code);
    $code = str_replace('{/textarea}','</textarea>',$code);
    $id = JRequest::getVar('id');
    $fileName = JRequest::getVar('fileName');
    $caller = JRequest::getVar('caller');
    $parser     = new PHPParser_Parser(new PHPParser_Lexer);
    $phpChecker = new phpCheckerClass();
    if (strpos($fileName,'/tmpl/')>0) {
      // ez egy JView -be includolt file
      $phpChecker->nameSpace->addClass('this','JviewLegacy');
      $nsThis = & $phpChecker->nameSpace->items['this'];
      $items = $phpChecker->nameSpace->items['JviewLegacy']->items;
      foreach ($items as $item) {
        $nsThis->items[] = $item;
      }
      $nsThis->addClass('form','JForm');
      $nsThis->addClass('model','JModel');
      $nsThis->addClass('Item','stdClass');
      $nsThis->addClass('Pagination','JPagination');
      $nsThis->addArray('Items');
      $nsThis->addScalar('viewName');
      $nsThis->addScalar('Title');
      $nsThis->addScalar('Total');
    }
    echo '<form action="index.php?option=com_ammvc&id='.$id.'&task='.$caller.'">
    ';
    try {
      $stmts = $parser->parse($code);
      if ($phpChecker->stmtsChecker($stmts,$fileName))
        echo '<hr /><h2>'.$saveFileName.'<br />Saved not error</h2><hr />';
      else {
        $matches = array();
        $errorStr = $phpChecker->errorMsg;
        preg_match_all('/\(Line:\d+\)/', $errorStr, $matches);
        foreach ($matches[0] as $match) {
          $lineNo = str_replace('(Line:','',$match);
          $lineNo = str_replace(')','',$lineNo);
          $errorStr = str_replace($match,
              '(Line:<a href="javascript:parent.gotoLine('.$lineNo.')">'.$lineNo.'</a>)',
              $errorStr);
        }
        echo '<hr /><h2>'.$fileName.'<br />Saved, found error:</h2>'.$errorStr.'<hr />';
      }  
    } catch (PHPParser_Error $e) {
        $errorStr = $e->getMessage();
        preg_match_all('/line \d+/', $errorStr, $matches);
        foreach ($matches[0] as $match) {
          $lineNo = str_replace('line ','',$match);
          $errorStr = str_replace($match,
              '(Line:<a href="javascript:parent.gotoLine('.$lineNo.')">'.$lineNo.'</a>)',
              $errorStr);
        }
        echo '<h2>Saved</h2>'.$fileName.'<br />Parse Error: ', $errorStr.'<br />';
    }
    echo JHTML::_( 'form.token' );
    echo '</form>
    ';
  } 

  /**
    * default display method (not used)
  */      
	public function display() {
		$document =& JFactory::getDocument();
		$viewType	= $document->getType();
		$view = & $this->getView($this->_viewname,$viewType);
		$model = & $this->getModel($this->_mainmodel);
		$view->setModel($model,true);		
    $view->setLayout('form');		
		$view->display();
	}
}// class
?>