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

require_once JPATH_ROOT . DS . 'components' . DS . 'com_content' . DS . 'helpers' . DS . 'route.php';

class plgQmapContent extends JPlugin {

	protected $items;

	protected function getLinks() {

		// Get a copy of the dbo
		$db =& JFactory::getDBO();

		// Get an empty query
		$query = $db->getQuery(true);

		// Select columns
		$query->select('id, catid, alias');

		// Select the table
		$query->from('#__content');

		// Conditionals
		$query->where('state = 1 OR state = -1');

		$query->order('alias', 'asc');

		// Sets the query (doesn't run it)
		$db->setQuery($query);

		// Runs the query, gets the results, returns as an object
		$this->items = $db->loadObjectList();

		// Loop through each object and append a formatted link to it
		foreach ($this->items as $key => $item) {
			$this->items[$key]->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->id, $item->catid));
		}

		return $this->items;

	}

	public function onNewSitemap($context) {

		return $this->getLinks();
	}
}

?>