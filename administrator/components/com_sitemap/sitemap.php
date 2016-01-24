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



$user = JFactory::getUser();



if (!$user->authorise('core.manage', 'com_sitemap')) {

	return JError::raiseWarning(403, JText::_('JERROR_ALERTNOAUTHOR'));

}

JLoader::register('SitemapHelper', JPATH_COMPONENT . DS . 'helpers' . DS . 'helper.php');


JLoader::import('joomla.application.component.controller');



$controller = JController::getInstance('Sitemap');



$task = JRequest::getCmd('task');



$controller->execute($task);



$controller->redirect();



?>