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

JLoader::import('joomla.plugin.plugin');

class plgQmapMenu extends JPlugin {

	protected $items;

	protected function getLinks() {

		$db =& JFactory::getDBO();

		$query = $db->getQuery(true);
		$query->select('link, alias, id');
		$query->from('#__menu');
		$query->where('parent_id > 0 AND published = 1 AND client_id = 0 AND type != "url"');
		$query->order('alias', 'asc');

		$db->setQuery($query);

		$this->items = $db->loadObjectList();

		foreach ($this->items as $key => $item) {
			$this->items[$key]->link = JRoute::_($item->link . '&Itemid=' . $item->id);
		}

		return $this->items;

	}

	public function onNewSitemap($context) {

		return $this->getLinks();

	}
}

?>