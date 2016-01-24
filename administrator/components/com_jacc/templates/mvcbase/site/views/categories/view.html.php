<?php
/**
 * @version		$Id: view.html.php 125 2012-10-09 11:09:48Z michel $ 
 * @copyright	Copyright (C) ##date## Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');
require_once(JPATH_COMPONENT.'/helpers/route.php');

/**
 * ##Component## categories view.
 *
 * @package		com_ ##component##
 * @subpackage	views
 */
class ##Component##ViewCategories extends JViewLegacy
{
	protected $state = null;
	protected $item = null;
	protected $items = null;

	/**
	 * Display the view
	 *
	 * @return	mixed	False on error, null otherwise.
	 */
	function display($tpl = null)
	{
		
		 
		// Initialise variables
		$state		= $this->get('State');
		$items		= $this->get('Items');
		$parent		= $this->get('Parent');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseWarning(500, implode("\n", $errors));
			return false;
		}

		if ($items === false) {
			return JError::raiseWarning(404, JText::_('JGLOBAL_CATEGORY_NOT_FOUND'));
		}

		if ($parent == false) {
			return JError::raiseWarning(404, JText::_('JGLOBAL_CATEGORY_NOT_FOUND'));
		}

		$params = &$state->params;

		$items = array($parent->id => $items);

		$this->assign('maxLevelcat', $params->get('maxLevelcat', -1));
		$this->assignRef('params', $params);
		$this->assignRef('parent', $parent);
		$this->assignRef('items', $items);

		$this->_prepareDocument();

		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{
		$app	= JFactory::getApplication();
		$document = JFactory::getDocument();
		$menus	= $app->getMenu();
		$title	= null;

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();

		if ($menu) {
			$title = isset($menu->title) ? $menu->title : $menu->name;
			$this->params->def('page_heading', $this->params->get('page_title', $title));
		} else {
			$this->params->def('page_heading', JText::_('##Component##_Title'));
		}
		$title = $this->params->get('page_title', '');
		if (empty($title)) {
			$title = htmlspecialchars_decode($app->getCfg('sitename'));
		} elseif ($app->getCfg('sitename_pagetitles', 0)) {
			$title = JText::sprintf('JPAGETITLE', htmlspecialchars_decode($app->getCfg('sitename')), $title);
		}
		$document->setTitle($title);
	}
}
