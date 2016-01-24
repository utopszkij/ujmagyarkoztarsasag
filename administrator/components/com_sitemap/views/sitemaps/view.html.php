<?php

/**
* Qlue Sitemap
*
* @author Jon Boutell
* @package QMap
* @license GNU/GPL
* @version 1.0
*
* This component gathers information from various Joomla Components and 
* compiles them into a sitemap, supporting both an HTML view and an XML 
* format for search engines.
*
*/

defined('_JEXEC') or die('Restricted Access');

JLoader::import('joomla.application.component.view');

class SitemapViewSitemaps extends JView {
	protected $items 		= null;
	protected $pagination 	= null;
	protected $state 		= null;

	public function display($tpl = null) {
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');

		$this->sortDirection 	= $this->state->get('filter_order_Dir');
		$this->sortColumn		= $this->state->get('filter_order');

		$this->user = JFactory::getUser();

		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));

			return false;
		}

		$this->addToolbar();

		parent::display($tpl);
	}

	public function addToolbar() {

		JToolBarHelper::title(JText::_(COM_SITEMAP), 'generic.png');

		$result = SitemapHelper::getActions();

		if ($result->get('core.create')) {
			JToolBarHelper::addNew('sitemap.add');
		}

		if ($result->get('core.edit')) {
			JToolBarHelper::editList('sitemap.edit');
		}

		JToolBarHelper::divider();

		if ($result->get('core.edit.state')) {
			JToolBarHelper::publishList('sitemaps.publish');
			JToolBarHelper::unpublishList('sitemaps.unpublish');
		}		
		
		if ($result->get('core.delete')) {
			JToolBarHelper::deleteList(JText::_(COM_SITEMAP_DELETE_CONFIRM), 'sitemaps.delete');
		}
		
	}
}

?>