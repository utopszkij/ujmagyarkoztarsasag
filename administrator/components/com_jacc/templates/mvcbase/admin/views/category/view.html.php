<?php
/**
 * @version		$Id: view.html.php 118 2012-10-02 08:52:27Z michel $
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * HTML View class for the Categories component
 *
 * @static
 * @package		Joomla.Administrator
 * @subpackage	com_categories
 */
class ##Component##ViewCategory extends JViewLegacy
{
	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		
			
		JHTML::stylesheet( 'fields.css', 'administrator/components/com_##component##/assets/' );
		JHTML::_('behavior.formvalidation');
		JHTML::_('behavior.keepalive');		

		$state		= $this->get('State');
		$item		= $this->get('Item');
		$form		= $this->get('Form');
		$modules	= $this->get('Modules');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$form->bind($item);
		
		$this->assignRef('state', $state);
		$this->assignRef('item', $item);
		$this->assignRef('form', $form);

		parent::display($tpl);
		JRequest::setVar('hidemainmenu', true);
		$this->_setToolBar();
	}

	/**
	 * Build the default toolbar.
	 *
	 * @return	void
	 */
	protected function _setToolBar($name='Category')
	{
		$user		= &JFactory::getUser();
		$isNew		= ($this->item->id == 0);
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
		$addeditname = $isNew ? 'Add' : 'Edit';
		
		JToolBarHelper::title(JText::_($name).": ".JText::_($addeditname), 'category-add');
	
		// If not checked out, can save the item.
		if ($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id')) {
			JToolBarHelper::apply('apply');
			JToolBarHelper::save('save');
		}

		if (empty($this->item->id)) {
			JToolBarHelper::cancel('cancel');
		} else {
			JToolBarHelper::cancel('cancel', 'Close');
		}
			JToolBarHelper::divider();
	}
}
