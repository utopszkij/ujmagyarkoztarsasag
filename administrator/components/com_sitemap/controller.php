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

JLoader::import('joomla.application.component.controller');

class SitemapController extends JController {
	public function display($cache = false){
		$view = JRequest::getCmd('view', 'sitemaps');

		JRequest::setVar('view', $view);

		parent::display($cache);
	}
}

?>