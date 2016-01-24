<?php defined('_JEXEC') or die('Restricted access'); ?>
##codestart##
/**
* @version		$Id: default_controller.php 96 2011-08-11 06:59:32Z michel $
* @package		##Component##
* @subpackage 	Controllers
* @copyright	Copyright (C) ##year##, ##author##. All rights reserved.
* @license ###license##
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * ##Component####Name## Controller
 *
 * @package    ##Component##
 * @subpackage Controllers
 */
class ##Component##Controller##Name## extends ##Component##Controller
{
	/**
	 * Constructor
	 */
	protected $_viewname = '##name##'; 
	 
	public function __construct($config = array ()) 
	{
		parent :: __construct($config);
		JRequest :: setVar('view', $this->_viewname);

	}
	
##ifdefFieldchecked_outStart##
##ifdefFieldchecked_out_timeStart##	
	
	function cancel()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$this->setRedirect( 'index.php?option=##com_component##&view=##name##' );
		
		$model = $this->getModel('##name##');

		$model ->checkin();
	}	
	
	function edit() 
	{
		$document =& JFactory::getDocument();

		$viewType	= $document->getType();
		$viewType	= $document->getType();
		$viewName	= JRequest::getCmd( 'view', $this->_viewname);
				
		$view = & $this->getView( $viewName, $viewType);
		$view->setLayout('form');
		$cid = JRequest :: getVar('cid', array (
			0
		), 'get', 'array');
		$id = $cid[0];
		if ($id  > 0) {
			$model = &$this->getModel($this->_viewname);

			// If not already checked out, do so.
			$model->setId($id); 
			$item = $model->getItem();
			if ($item->checked_out == 0) {
				
				if (!$model->checkout()) {
					// Check-out failed, go back to the list and display a notice.
					$message = JText::sprintf('JError_Checkout_failed', $model->getError());
					$this->setRedirect('index.php?option=##com_component##&view=##name##', $message, 'error');
					return false;
				}
			}
		}
		
		JRequest::setVar( 'hidemainmenu', 1 );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar( 'view', $this->_viewname);
		JRequest::setVar( 'edit', true );
				
		$view->setModel($model, true);
		$view->display();
	}
	

	/**
	 * stores the item
	 */
	function save() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');
		
		$db = & JFactory::getDBO();  

		$post = JRequest :: getVar('jform', array(), 'post', 'array');
		$cid = JRequest :: getVar('cid', array (
			0
		), 'post', 'array');
		$post['id'] = (int) $cid[0];	
		
		$model = $this->getModel('##name##');
		if ($model->store($post)) {
			$msg = JText :: _($this->_itemname .' Saved');
			$model->checkin();
		} else {
			$msg = $model->getError(); 
		}
        
		switch ($this->getTask())
		{
			case 'apply':
				$link = 'index.php?option=##com_component##&view=##name##.&task=edit&cid[]='.$model->getId() ;
				break;

			case 'save':
			default:
				$link = 'index.php?option=##com_component##&view=##name##';
				break;
		}
        

		$this->setRedirect($link, $msg);
	}
	
##ifdefFieldchecked_out_timeEnd##
##ifdefFieldchecked_outEnd##
##ifdefFieldpublishedStart##		
	public function publish() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');

		$cid = JRequest :: getVar('cid', array (), 'post', 'array');
		JArrayHelper :: toInteger($cid);

		if (count($cid) < 1) {
			JError :: raiseError(500, JText :: _('Select an item to publish'));
		}

		$model = $this->getModel('##name##');
		if (!$model->publish($cid, 1)) {
			echo "<script> alert('" . $model->getError(true) . "'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect('index.php?option=##com_component##&view=##name##');
	}

	public function unpublish() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');

		$cid = JRequest :: getVar('cid', array (), 'post', 'array');
		JArrayHelper :: toInteger($cid);

		if (count($cid) < 1) {
			JError :: raiseError(500, JText :: _('Select an item to unpublish'));
		}

		$model = $this->getModel('##name##');
		if (!$model->publish($cid, 0)) {
			echo "<script> alert('" . $model->getError(true) . "'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect('index.php?option=##com_component##&view='.$this->_viewname);
	}
##ifdefFieldpublishedEnd##	
##ifdefFieldorderingStart##
	public function orderup() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');

		$model = $this->getModel('##name##');
		$model->move(-1);

		$this->setRedirect('index.php?option=##com_component##&view='.$this->_viewname);
	}

	public function orderdown() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');

		$model = $this->getModel('##name##');
		$model->move(1);

		$this->setRedirect('index.php?option=##com_component##&view='.$this->_viewname);
	}

	public function saveorder() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');

		$cid = JRequest :: getVar('cid', array (), 'post', 'array');
		$order = JRequest :: getVar('order', array (), 'post', 'array');
		JArrayHelper :: toInteger($cid);
		JArrayHelper :: toInteger($order);

		$model = $this->getModel('##name##');
		$model->saveorder($cid, $order);

		$msg = JText :: _('New ordering saved');
		$this->setRedirect('index.php?option=##com_component##&view='.$this->_viewname, $msg);
	}
##ifdefFieldorderingEnd##	
}// class
##codeend##