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

JLoader::import('joomla.application.component.modellist');

class SitemapModelSitemaps extends JModelList {

	protected function populateState() {
		$this->setState('list.start', 0);
		$this->setState('list.limit', 0);

		$filter_order 		= JRequest::getCmd('filter_order', 'id');
		$filter_order_Dir 	= JRequest::getCmd('filter_order_Dir', 'asc');

		$this->setState('filter_order', $filter_order);
		$this->setState('filter_order_Dir', $filter_order_Dir);
	}

	public function __construct($config = array()) {

		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array('id', 'title', 'alias', 'published');
		}

		// For pulling menu items
		// if (empty($config['filter_fields'])) {
		// 	$config['filter_fields'] = array('id', 'menutype', 'alias', 'path', 'link');
		// }

		parent::__construct($config);

	}

	public function getListQuery() {
		
		$db =& JFactory::getDBO();

		$query = $db->getQuery(true);

		$query->select('id, title, alias, published');

		$query->from('#__sitemap_sitemaps');

		$query->order($db->getEscaped($this->getState('filter_order', 'id')) . ' ' . $db->getEscaped($this->getState('filter_order_Dir', 'asc')));

		return $query;

	}
}

?>