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
	protected $items = null;

	public function display($tpl = null) {
		$this->items = $this->get('Items');

		$this->user = JFactory::getUser();

		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));

			return false;
		}

		$this->setLayout('sitemap');

		parent::display($tpl);
	}
}

?>