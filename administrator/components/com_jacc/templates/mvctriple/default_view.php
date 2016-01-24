<?php defined('_JEXEC') or die('Restricted access'); ?>
##codestart##
/**
* @version		$Id:##name##.php 1 ##date##Z ##sauthor## $
* @package		##Component##
* @subpackage 	Tables
* @copyright	Copyright (C) ##year##, ##author##. All rights reserved.
* @license ###license##
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

 
class ##Component##View##Name##  extends JViewLegacy {

	public function display($tpl = null) 
	{
		$app = &JFactory::getApplication('');
		
		if ($this->getLayout() == 'form') {
		
			$this->_displayForm($tpl);		
			return;
		}
		$context			= 'com_##component##'.'.'.strtolower($this->getName()).'.list.';
##ifdefFieldpublishedStart##
		$filter_state = $app->getUserStateFromRequest($context . 'filter_state', 'filter_state', '', 'word');
##ifdefFieldpublishedEnd##		
		$filter_order = $app->getUserStateFromRequest($context . 'filter_order', 'filter_order', $this->get('DefaultFilter'), 'cmd');
		$filter_order_Dir = $app->getUserStateFromRequest($context . 'filter_order_Dir', 'filter_order_Dir', '', 'word');
		$search = $app->getUserStateFromRequest($context . 'search', 'search', '', 'string');
		$search = JString :: strtolower($search);
		
		// Get data from the model
		$items = & $this->get('Data');
		$total = & $this->get('Total');
		$pagination = & $this->get('Pagination');
##ifdefFieldpublishedStart##			
		//create the lists
		$lists = array();
		$lists['state'] = JHTML :: _('grid.state', $filter_state);
##ifdefFieldpublishedEnd##			
		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;
		// search filter
		$lists['search'] = $search;
		$items = $this->get('Data');
		
		//pagination
		$pagination = & $this->get( 'Pagination' );
		
		$this->assignRef('user', JFactory :: getUser());
		$this->assign('lists', $lists);	
		$this->assign('items', $items);		
		$this->assign('total', $total);
		$this->assign('pagination', $pagination);		
		parent::display();
	}
	
	/**
	 *  Displays the form
 	 * @param string $tpl   
     */
	public function _displayForm($tpl)
	{
		
		jimport('joomla.form.formvalidator');		
		JHTML::stylesheet( 'fields.css', 'administrator/components/com_##component##/assets/' );

		$db			=& JFactory::getDBO();
		$uri 		=& JFactory::getURI();
		$user 		=& JFactory::getUser();
		$form		= $this->get('Form');
		
		$lists = array();

		$editor = & JFactory :: getEditor();

		//get the item
		$item	=& $this->get('item');
		
		if(!version_compare(JVERSION,'3.0','lt')) {
			$form->bind(JArrayHelper::fromObject($item));
		} else {
			$form->bind($item);
		}
		
		$isNew		= ($item->##primary## < 1);			

		// Edit or Create?
		if ($isNew) {
			// initialise new record
			$item->published = 1;
		}
	
		$lists['published'] 		= JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $item->published );
		
	 	$this->assign('form', $form);
	 
		$this->assignRef('lists', $lists);
		$this->assignRef('editor', $editor);
		$this->assignRef('item', $item);
		$this->assignRef('isNew', $isNew);
	
		parent::display($tpl);
	}
}
##codeend##