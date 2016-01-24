<?php
/**
* @version		$Id:controller.php  1 2014-04-04Z FT $
* @package		Beállitások
* @subpackage 	Controllers
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
jimport( 'joomla.form.form' );

/**
 * Variant Controller
 *
 * @package    
 * @subpackage Controllers
 */
class BeallitasokController extends JControllerLegacy {
	protected $_viewname = 'beallitasok';
	protected $_mainmodel = 'beallitasok';
	protected $_itemname = 'Item';    
	protected $_context = "com_beallitasok";
	/**
	 * Constructor
	 */
	public function __construct($config = array ()) {
		parent :: __construct($config);
		if(isset($config['viewname'])) $this->_viewname = $config['viewname'];
		if(isset($config['mainmodel'])) $this->_mainmodel = $config['mainmodel'];
		if(isset($config['itemname'])) $this->_itemname = $config['itemname']; 
		JRequest :: setVar('view', $this->_viewname);
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
   * adat form kirajzolása
   * @return void
   */         
  public function form() {
		$document =& JFactory::getDocument();
  	$viewType	= $document->getType();
		$view = & $this->getView($this->_viewname,$viewType);
		$model = & $this->getModel($this->_mainmodel);
		$view->setModel($model,true);
    $item = $model->getItem(1);
		$form = JForm::getInstance('beallitasok',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_beallitasok'.DS.'models'.DS.'forms'.DS.'beallitasok.xml');
    $form->bind($item);
    $view->set('form',$form);
    $view->set('Item',$item);
    $view->set('Msg','');
    $view->set('okLink',JURI::ROOT().'index.php?option=com_beallitasok&view=beallitasok&task=save');
    $view->set('cancelLink', JURI::root().'index.php?option=com_temakorok&view=temakoroklist');
    $view->set('helpLink',JURI::root().'index.php?option=com_content&view=article&id=12&Itemid=435&tmpl=component');
    $view->setLayout('form');		
		$view->display();
  }
  /**
   * adat form tárolása
   * &JRequest formfields   
   * @return void
   */         
  public function save() {
		$document =& JFactory::getDocument();
		$viewType	= $document->getType();
		$view = & $this->getView($this->_viewname,$viewType);
		$model = & $this->getModel($this->_mainmodel);
    $item = new stdclass();
    $item->id = 1;
    $item->json = JRequest::getVar('json');
		$view->setModel($model,true);
    if ($model->save($item)) {
      $this->setMessage(JText::_('BEALLITASOKTAROLVA'));
      $this->setRedirect(JURI::root().'index.php?option=com_temakorok&view=temakoroklist');
      $this->redirect();		
    } else {
      $view->setLayout('form');		
      $item = $model->bind($_POST);
      $view->set('Item',$item);
      $view->set('Msg',$model->getMessage());
      $view->set('okLink',JURI::ROOT().'/index.php?option=com_beallitasok&view=beallitasok&task=save');
      $view->set('cancelLink', JURI::root().'/index.php?option=com_temakorok&view=temakoroklist');
      $view->set('helpLink',JURI::root().'/index.php?option=com_content&view=article&id=12&Itemid=435&tmpl=component');
		  $view->display();
    }  
  }

}// class
  	

  
?>