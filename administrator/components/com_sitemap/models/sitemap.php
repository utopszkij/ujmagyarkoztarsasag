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

JLoader::import('joomla.application.component.modeladmin');

class SitemapModelSitemap extends JModelAdmin {

	public function getTable($name = 'Sitemap', $prefix = 'SitemapTable', $config = array()) {
		return JTable::getInstance($name, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true) {
		$form = $this->loadForm('com_sitemap.sitemap', 'sitemap', array('control' => 'jform', 'load_data' => $loadData));

		return $form;
	}

	public function loadFormData() {
		$app = JFactory::getApplication();

		$data = $app->getUserState('com_sitemap.edit.sitemap.data', array());

		if (empty($data)) {
			$data = $this->getItem();
		}

		return $data;
	}

}

?>