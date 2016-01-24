<?php
/**
 * @version		$Id: categories.php 124 2012-10-08 15:08:17Z michel $
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport( 'joomla.application.component.controller');

/**
 * The Menu Item Controller
 *
 * @package		Joomla.Administrator
 * @subpackage	com_categories
 * @since		1.6
 */
class ##Component##ControllerCategories extends JControllerLegacy
{
	private $_context		= 'com_##component##_categories';
	private $_viewname		= 'categories';
	/**
	 * Constructor.
	 *
	 * @param	array An optional associative array of configuration settings.
	 * @see		JController
	 */
	public function __construct($config = array())
	{
		parent:: __construct($config);	
		
		
		$db = JFactory::getDBO();
		$db->setQuery('SELECT * FROM #__##component##_categories');
		$rows = $db->loadObjectList();

		$this->_viewname = 'categories';
		$this->_mainmodel = 'categories';
		$this->_itemname = 'Category';  		
		// Register proxy tasks.
		$this->registerTask('unpublish', 'publish');
		$this->registerTask('trash', 'publish');
		$this->registerTask('delete', 'trash');
		$this->registerTask('orderup', 'ordering');
		$this->registerTask('orderdown', 'ordering');
		$this->registerTask('accessregistered', 'access');
		$this->registerTask('accesspublic', 'access');
		$this->registerTask('accessspecial', 'access');
	}

	/**
	 * shows the categories mulit select (for com_menu)
	 */
	public function element() 
	{
		JRequest::setVar( 'layout', 'element'  );
		JRequest::setVar( 'view', $this->_viewname);
		parent::display();
		 
	}
	
	/**
	 * Display the view
	 */
	public function display() 
	{
	
		$document =& JFactory::getDocument();
		$layout		= 'default';
		
		$viewType	= $document->getType();
		$view = &$this->getView('categories', $viewType);
        //get the model
		$model = $this->getModel('Categories');
	
		$view->setModel( $model, true );
		$view->display();
	}



	function access() 
	{
			// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JInvalid_Token'));

		// Get items to publish from the request.
		$pks	= JRequest::getVar('cid', array(), '', 'array');
		$values	= array('accessregistered' => 1, 'accesspublic' => 0, 'accessspecial' => 2);
		$task	= $this->getTask();
		$value	= JArrayHelper::getValue($values, $task, 0, 'int');
		
		if (empty($pks)) {
			JError::raiseWarning(500, JText::_('JError_No_items_selected'));
		} else {
			// Get the model.
			$model = $this->getModel('Category');

			// Remove the items.
			if (!$model->access($pks, $value)) {
				$this->setMessage($model->getError());
			}
		}
		$app = &JFactory::getApplication();
		$extension = $app->getUserStateFromRequest($this->_context.'.filter.extension', 'extension', 'com_##component##');

		$this->setRedirect('index.php?option=com_##component##&view=categories&extension='.$extension);
	}
	
	/**
	 * Removes an item
	 */
	public function trash()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JInvalid_Token'));

		// Get items to remove from the request.
		$pks	= JRequest::getVar('cid', array(), 'post', 'array');
		$n		= count($pks);
	
		if (empty($pks)) {
			JError::raiseWarning(500, JText::_('JError_No_items_selected'));
			
		} else {
			
			// Get the model.
			$model = $this->getModel('Category');

			// Remove the items.
			if ($model->delete($pks)) {
				$this->setMessage(JText::sprintf('JSuccess_N_items_deleted', $n));
			} else {
				$this->setMessage($model->getError());
			}
		}
		$app = &JFactory::getApplication();
		$extension = $app->getUserStateFromRequest($this->_context.'.filter.extension', 'extension', 'com_##component##');

		$this->setRedirect('index.php?option=com_##component##&view=categories&extension='.$extension);
	}

	/**
	 * Method to change the published state of selected rows.
	 *
	 * @return	void
	 */
	public function publish()
	{
		

		// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JInvalid_Token'));

		// Get items to publish from the request.
		$pks	= JRequest::getVar('cid', array(), '', 'array');
		$values	= array('publish' => 1, 'unpublish' => 0, 'trash' => -2);
		$task	= $this->getTask();
		$value	= JArrayHelper::getValue($values, $task, 0, 'int');

		if (empty($pks)) {
			JError::raiseWarning(500, JText::_('JError_No_items_selected'));
		} else {
			// Get the model.
			$model	= $this->getModel('Category');

			// Publish the items.
			if ($model->publish($pks, $value)) {
				
				$this->setMessage($value ? JText::_('JSuccess_N_items_published') : JText::_('JSuccess_N_items_unpublished'));
				
			} else {
				
				$this->setMessage($model->getError());
				
			}
		}
		$app = &JFactory::getApplication();
		$extension = $app->getUserStateFromRequest($this->_context.'.filter.extension', 'extension', 'com_content');
		$this->setRedirect('index.php?option=com_##component##&view=categories&extension='.$extension);
	}

	/**
	 * Method to reorder selected rows.
	 *
	 * @return	bool	False on failure or error, true on success.
	 */
	public function ordering()
	{
		JRequest::checkToken() or jexit(JText::_('JInvalid_Token'));

		// Initialize variables.
		$pks	= JRequest::getVar('cid', null, 'post', 'array');
		$model	= &$this->getModel('Category');

		// Attempt to move the row.
		$return = $model->ordering(array_pop($pks), $this->getTask() == 'orderup' ? -1 : 1);
		$app = &JFactory::getApplication();
		$extension = $app->getUserStateFromRequest($this->_context.'.filter.extension', 'extension', 'com_content');

		if ($return === false) {
			// Reorder failed.
			$message = JText::sprintf('JError_Reorder_failed', $model->getError());
			$this->setRedirect('index.php?option=com_##component##&view=categories&extension='.$extension, $message, 'error');
			return false;
		} else {
			// Reorder succeeded.
			$message = JText::_('JSuccess_Item_reordered');
			$this->setRedirect('index.php?option=com_##component##&view=categories&extension='.$extension, $message);
			return true;
		}
	}

	/**
	 * Rebuild the nested set tree.
	 *
	 * @return	bool	False on failure or error, true on success.
	 */
	public function rebuild()
	{
		JRequest::checkToken() or jexit(JText::_('JInvalid_Token'));
		$app = &JFactory::getApplication();
		$extension = $app->getUserStateFromRequest($this->_context.'.filter.extension', 'extension', 'com_content');
		$this->setRedirect('index.php?option=com_##component##&view=categories&extension='.$extension);

		// Initialize variables.
		$model = &$this->getModel('Category');

		if ($model->rebuild()) {
			// Reorder succeeded.
			$this->setMessage(JText::_('Categories_Rebuild_success'));
			return true;
		} else {
			// Rebuild failed.
			$this->setMessage(JText::sprintf('Categories_Rebuild_failed'));
			return false;
		}
	}
}