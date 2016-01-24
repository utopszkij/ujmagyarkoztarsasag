<?php
/**
* @module		VJ Database Tool
* @copyright	Copyright (C) 2015 vj-tools.com
* @license		GPL
*/

defined('_JEXEC') or die('Direct Access to this location is not allowed.');
error_reporting(E_ERROR);
define ("DS", DIRECTORY_SEPARATOR);
jimport('joomla.application.component.controller');

$version = new JVersion(); 
if ($version->RELEASE >= 3.0) {
	class VJDatabaseToolControllerInner extends JControllerLegacy {}
} else {
	class VJDatabaseToolControllerInner extends JController {}
}

class VJDatabaseToolController extends VJDatabaseToolControllerInner {
	function __construct() {
		parent::__construct();
	}
	
	function databasetool() {
		require_once(JPATH_COMPONENT.DS.'admin.vjdatabasetool.html.php');
		$option = JRequest::getCmd('option');
		HTML_VJDatabaseTool::databasetool($option);
	}
	
}

?>