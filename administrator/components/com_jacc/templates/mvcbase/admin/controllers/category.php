<?php
/**
 * @version		$Id: category.php 124 2012-10-08 15:08:17Z michel $
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport( 'joomla.application.component.controller' );

/**
 * The Menu Item Controller
 *
 * @package		Joomla.Administrator
 * @subpackage	com_categories
 * @since		1.6
 */
class ##Component##ControllerCategory extends JControllerLegacy
{
	
	private $_context = "com_##component##_categories";
	/**
	 * Constructor.
	 *
	 * @param	array An optional associative array of configuration settings.
	 * @see		JController
	 */
	public function __construct($config = array())
	{
		

		$this->_viewname = 'category';
		$this->_mainmodel = 'category';
		$this->_itemname = 'Category';  		
		parent::__construct($config);
		
		// Register proxy tasks.
		$this->registerTask('save2copy', 'save');
		$this->registerTask('save2new', 'save');
		$this->registerTask('apply', 'save');
		$this->registerTask('cancel', 'cancel');
	}
	


	/**
	 * Dummy method to redirect back to standard controller
	 *
	 * @return	void
	 */
	public function display()
	{
			switch($this->getTask())
		{
			case 'add'     :
			{
				JRequest::setVar( 'hidemainmenu', 1);
				JRequest::setVar( 'layout', 'form');
				JRequest::setVar( 'view', $this->_viewname);
				JRequest::setVar( 'edit', false);

			} break;
			case 'edit'    :
			{
				JRequest::setVar( 'hidemainmenu', 1 );
				JRequest::setVar( 'layout', 'form'  );
				JRequest::setVar( 'view', $this->_viewname);
				JRequest::setVar( 'edit', true );

			} break;
			}
		parent :: display();
	}

	/**
	 * Method to add a new category.
	 *
	 * @return	void
	 */
	public function add()
	{
		// Initialize variables.
		$app = &JFactory::getApplication();

		// Clear the row edit information from the session.
		$app->setUserState('com_categories.edit.category.id', null);
		$app->setUserState('com_categories.edit.category.data', null);
		$app->setUserState('com_categories.edit.category.type', null);

		// Check if we are adding for a particular extension
		$extension = $app->getUserStateFromRequest($this->_context.'.filter.extension', 'extension', 'com_content');

		// Redirect to the edit screen.
		$this->setRedirect(JRoute::_('index.php?option=com_##component##&view=category&layout=edit&extension='.$extension, false));
	}

	/**
	 * Method to edit an existing category.
	 *
	 * @return	void
	 */
	public function edit()
	{
		// Initialize variables.
	
		$app	= &JFactory::getApplication();
		$pks	= JRequest::getVar('cid', array(), '', 'array');

		// Get the id of the group to edit.
		$id		=  (empty($pks) ? JRequest::getInt('item_id') : (int) array_pop($pks));

		// Get the model.
		$model	= &$this->getModel('Category');

		$extension = $app->getUserStateFromRequest('com_##component##_categories.filter.extension', 'extension', 'com_##component##');
		// Check that this is not a new category.
		if ($id > 0) {
			$item = $model->getItem($id);

			// If not already checked out, do so.
			if ($item->checked_out == 0) {
				if (!$model->checkout($id)) {
					// Check-out failed, go back to the list and display a notice.
					$message = JText::sprintf('JError_Checkout_failed', $model->getError());
					$this->setRedirect('index.php?option=com_##component##&view=category&extension='.$extension.'&item_id='.$id, $message, 'error');
					return false;
				}
			}
		}

		// Check if we are adding for a particular extension
		
		// Push the new row id into the session.
		$app->setUserState('com_##component##_categories.edit.category.id', $id);
		
		$app->setUserState('com_##component##_categories.edit.category.data', null);
		$app->setUserState('com_##component##_categories.edit.category.type', null);

		$this->setRedirect('index.php?option=com_##component##&view=category&layout=edit&extension='.$extension);

		return true;
	}

	/**
	 * Method to cancel an edit
	 *
	 * Checks the item in, sets item ID in the session to null, and then redirects to the list page.
	 *
	 * @return	void
	 */
	public function cancel()
	{
		JRequest::checkToken() or jexit(JText::_('JInvalid_Token'));

		// Initialize variables.
		$app	= &JFactory::getApplication();
		$model	= &$this->getModel('Category');

		// Get the previous row id.
		$previousId	= (int) $app->getUserState('com_##component##_categories.edit.category.id');
		$extension = $app->getUserStateFromRequest('com_##component##_categories.filter.extension', 'extension');
		

		// If rows ids do not match, checkin previous row.
		if ($model->checkin($previousId)) {
			// Redirect to the list screen.
			$this->setRedirect(JRoute::_('index.php?option=com_##component##&view=categories&extension='.$extension, false));
		} else {
			// Check-in failed
			$message = JText::sprintf('JError_Checkin_failed', $model->getError());
			$this->setRedirect('index.php?option=com_##component##&view=categories&extension='.$extension, $message, 'error');
		}

		// Clear the row edit information from the session.
		$app->setUserState('com_##component##_categories.edit.category.id', null);
		$app->setUserState('com_##component##_categories.edit.category.data', null);
		$app->setUserState('com_##component##_categories.edit.category.type', null);
	}

	/**
	 * Method to save a category.
	 *
	 * @return	void
	 */
	public function save()
	{
		// Check for request forgeries.
		JRequest::checkToken() or jexit(JText::_('JInvalid_Token'));

		// Initialize variables.
		$app	= &JFactory::getApplication();
		$model	= &$this->getModel('Category');
		$task	= $this->getTask();

		
		// Get the posted values from the request.
		$data	= JRequest::getVar('jform', array(), 'post', 'array');

		$extension = $data['extension'];
		// Populate the row id from the session.
		$data['id'] = (int) $app->getUserState('com_categories.edit.category.id');

		// The save2copy task needs to be handled slightly differently.
		if ($task == 'save2copy') {
			// Check-in the original row.
			if (!$model->checkin()) {
				// Check-in failed, go back to the item and display a notice.
				$message = JText::sprintf('JError_Checkin_saved', $model->getError());
				$this->setRedirect('index.php?option=com_##component##&view=category&layout=edit&extension='.$extension, $message, 'error');
				return false;
			}

			// Reset the ID and then treat the request as for Apply.
			$data['id']	= 0;
			$task		= 'apply';
		}

		// Validate the posted data.
		$form	= &$model->getForm();
		if (!$form) {
			JError::raiseError(500, $model->getError());
			return false;
		}
		$data	= $model->validate($form, $data);

		// Check for validation errors.
		if ($data === false) {
			// Get the validation messages.
			$errors	= $model->getErrors();

			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
				if (JError::isError($errors[$i])) {
					$app->enqueueMessage($errors[$i]->getMessage(), 'notice');
				} else {
					$app->enqueueMessage($errors[$i], 'notice');
				}
			}

			// Save the data in the session.
			$app->setUserState('com_##component##_categories.edit.category.data', $data);

			// Redirect back to the edit screen.
			$this->setRedirect(JRoute::_('index.php?option=com_##component##&view=category&layout=edit&extension='.$extension, false));
			return false;
		}

		// Attempt to save the data.
		if (!$model->save($data)) {
			// Save the data in the session.
			$app->setUserState('com_##component##_categories.edit.category.data', $data);

			// Redirect back to the edit screen.
			$this->setMessage(JText::sprintf('JError_Save_failed', $model->getError()), 'notice');
			$this->setRedirect(JRoute::_('index.php?option=com_##component##&view=category&layout=edit&extension='.$extension, false));
			return false;
		}

		// Save succeeded, check-in the row.
		if (!$model->checkin($model->getState('category.id'))) {
			// Check-in failed, go back to the row and display a notice.
			$message = JText::sprintf('JError_Checkin_saved', $model->getError());
			$this->setRedirect('index.php?option=com_##component##&view=category&layout=edit&extension='.$extension, $message, 'error');
			return false;
		}

		$this->setMessage(JText::_('JController_Save_success'));

		// Redirect the user and adjust session state based on the chosen task.
		switch ($task)
		{
			case 'apply':
				// Set the row data in the session.
				$app->setUserState('com_##component##_categories.edit.category.id', $model->getState('category.id'));
				$app->setUserState('com_##component##_categories.edit.category.data', null);
				$app->setUserState('com_##component##_categories.edit.category.type', null);

				// Redirect back to the edit screen.
				$this->setRedirect(JRoute::_('index.php?option=com_##component##&view=category&layout=edit&extension='.$extension, false));
				break;

			case 'save2new':
				// Clear the row id and data in the session.
				$app->setUserState('com_##component##_categories.edit.category.id', null);
				$app->setUserState('com_##component##_categories.edit.category.data', null);
				$app->setUserState('com_##component##_categories.edit.category.type', null);

				// Redirect back to the edit screen.
				$this->setRedirect(JRoute::_('index.php?option=com_##component##&view=category&layout=edit&extension='.$extension, false));
				break;

			default:
				// Clear the row id and data in the session.
				$app->setUserState('com_##component##_categories.`.id', null);
				$app->setUserState('com_##component##_categories.edit.category.data', null);
				$app->setUserState('com_##component##_categories.edit.category.type', null);

				// Redirect to the list screen.
				$this->setRedirect(JRoute::_('index.php?option=com_##component##&view=categories&extension='.$extension, false));
				break;
		}
	}

	/**
	 * Method to run batch opterations.
	 *
	 * @return	void
	 */
	function batch()
	{
		JRequest::checkToken() or jexit(JText::_('JInvalid_Token'));

		// Initialize variables.
		$app	= &JFactory::getApplication();
		$model	= &$this->getModel('Category');
		$vars	= JRequest::getVar('batch', array(), 'post', 'array');
		$cid	= JRequest::getVar('cid', array(), 'post', 'array');
		$extension = $app->getUserStateFromRequest('com_##component##_categories.filter.extension', 'extension');
		// Preset the redirect
		$this->setRedirect('index.php?option=com_##component##&view=categories&extension='.$extension);

		// Attempt to run the batch operation.
		if ($model->batch($vars, $cid)) {
			$this->setMessage(JText::_('Categories_Batch_success'));
			return true;
		} else {
			$this->setMessage(JText::_(JText::sprintf('Categories_Error_Batch_failed', $model->getError())));
			return false;
		}
	}
}
