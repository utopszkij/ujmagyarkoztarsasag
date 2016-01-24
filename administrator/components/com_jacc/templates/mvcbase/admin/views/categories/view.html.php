<?php
/**
 * @version		$Id: view.html.php 125 2012-10-09 11:09:48Z michel $
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * Categories view class for the Category package.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_categories
 * @since		1.6
 */
class ##Component##ViewCategories extends JViewLegacy
{
	protected $state;
	protected $items;
	protected $pagination;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		
		JHTML::stylesheet( 'fields.css', 'administrator/components/com_##component##/assets/') ;

		//Show a categories multi select (called from com_menu) 
		if ($this->getLayout() == 'element') {		
			parent::display($tpl);	
			return;
		}
		
		$state		= $this->get('State');
		$items		= $this->get('Items');
		$pagination	= $this->get('Pagination');
	
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		
	

		// Preprocess the list of items to find ordering divisions.
		foreach ($items as $i => &$item) {
			// TODO: Complete the ordering stuff with nested sets
			$item->order_up = true;
			$item->order_dn = true;
		}

		$this->assignRef('state', $state);
		$this->assignRef('items', $items);
		$this->assignRef('pagination',	$pagination);

		$this->_setToolbar();
		parent::display($tpl);
	}

	/**
	 * Display the toolbar
	 */
	protected function _setToolbar($name = 'Categories_Categories_Title')
	{
		$state = $this->get('State');
		$extension	= $state->get('filter.extension');

		// Need to load the menu language file as mod_menu hasn't been loaded yet.
		$lang = &JFactory::getLanguage();
		$lang->load($extension.'.menu');

		JToolBarHelper::title(
			JText::_($name),
			'category.png'
		);
		JToolBarHelper::custom('category.edit', 'new.png', 'new_f2.png', 'New', false);
		JToolBarHelper::custom('category.edit', 'edit.png', 'edit_f2.png', 'Edit', true);
		JToolBarHelper::divider();
		JToolBarHelper::custom('publish', 'publish.png', 'publish_f2.png', 'Publish', true);
		JToolBarHelper::custom('unpublish', 'unpublish.png', 'unpublish_f2.png', 'Unpublish', true);

		if ($state->get('filter.published') == -2) {
			JToolBarHelper::deleteList('', 'delete');
		} else {
			JToolBarHelper::trash('trash');
		} 
		JToolBarHelper::divider();
		JToolBarHelper::custom('rebuild', 'refresh.png', 'refresh_f2.png', 'JToolbar_Rebuild', false);
		JToolBarHelper::divider();


	}
}
