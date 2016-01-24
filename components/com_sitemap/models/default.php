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

class SitemapModelDefault extends JModelList {

	public function getTable($name = 'Sitemap', $prefix = 'SitemapTable', $config = array()) {
		return JTable::getInstance($name, $prefix, $config);
	}

	public function populateState() {
		$this->setState('list.start', 0);
		$this->setState('list.limit', 0);

		$app = JFactory::getApplication();
		$params = $app->getParams();

		$id = JRequest::getInt('id', $params->getValue('id'));

		$this->setState('sitemap.id', $id);
	}

	public function getItems() {

		$dispatcher = JDispatcher::getInstance();

		JPluginHelper::importPlugin('qmap');
		$results = $dispatcher->trigger('onNewSitemap', array('com_sitemap.sitemap'));

		if (JRequest::getVar('format') == 'xml') {

			$links = array();

			foreach ($results as $plugin) {

				foreach ($plugin as $key => $item) {
					$links[] = $plugin[$key]->link;
				}
			}

			$results = array_unique($links);

		}

		return $results;

	}

	public function getItem($id = null) {
		if ($this->sitemap === null) {

			if ($id == null) {
				$id = $this->getState('sitemap.id');
			}

			$table = $this->getTable();

			$table->load($id);
			$data = $table->getProperties(1);

			$this->sitemap = JArrayHelper::toObject($data, 'JObject');

		}

		return $this->sitemap;
	}

}

?>