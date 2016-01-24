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

JPATH_ROOT . DS . 'components' . DS . 'com_content' . DS . 'helpers' . DS . 'route.php';

class plgQmapCategories extends JPlugin {

	protected $items;

	protected function getLinks() {

		$db =& JFactory::getDBO();

		$query = $db->getQuery(true);
		$query->select('id, alias');
		$query->from('#__categories');
		$query->where('level > 0 AND extension = "com_content"');
		$query->order('alias', 'asc');

		$db->setQuery($query);

		$this->items = $db->loadObjectList();

		foreach ($this->items as $key => $item) {
			$this->items[$key]->link = JRoute::_(ContentHelperRoute::getCategoryRoute($item->id));
		}

		return $this->items;

	}

	public function onNewSitemap($context) {

		return $this->getLinks();
	
	}
}

?>