<?php
/**
* @module		VJ Database Tool
* @copyright	Copyright (C) 2015 vj-tools.com
* @license		GPL
*/

defined('_JEXEC') or die('Direct Access to this location is not allowed.');
error_reporting(E_ERROR);
define ("DS", DIRECTORY_SEPARATOR);
JTable::addIncludePath(JPATH_COMPONENT.DS.'database');
require_once(JPATH_COMPONENT.DS.'controller.php');

$controller = new VJDatabaseToolController();
$task = JRequest::getCmd('task');
$controller->registerDefaultTask('databasetool');
$controller->execute($task);
$controller->redirect();

?>