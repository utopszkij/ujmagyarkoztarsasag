<?php
/**
* @module		VJ Database Tool
* @copyright	Copyright (C) 2015 vj-tools.com
* @license		GPL
*/

define('_JEXEC', 1);
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
error_reporting(E_ERROR);
$host = $_SERVER['HTTP_HOST'];
$uri = $_SERVER['REQUEST_URI'];
/*
if (!$_SERVER['HTTP_REFERER'] || (strpos($host . $uri, substr($_SERVER['HTTP_REFERER'], strpos($_SERVER['HTTP_REFERER'], '//') + 2, -32)) === FALSE && strpos(substr($_SERVER['HTTP_REFERER'], strpos($_SERVER['HTTP_REFERER'], '//') + 2, -32), $host . $uri) === FALSE)) {
	die('Direct access not permitted');
}
*/


define('DS', DIRECTORY_SEPARATOR);

define('JPATH_BASE', dirname(__FILE__) . '/../../../');

require_once JPATH_BASE . '/includes/defines.php';

require_once JPATH_BASE . '/includes/framework.php';

JFactory::getApplication('administrator');

if (!JFactory::getUser()->authorise('core.admin'))
{
    exit;
}

function adminer_object() {
	include_once "./plugins/plugin.php";
	
	foreach (glob("plugins/*.php") as $filename) {
		include_once "./$filename";
	}
	
	$plugins = array(
		new AdminerFrames
	);

	return new AdminerPlugin($plugins);
}
define('MyAdminerConst', TRUE);
include "./adminer/file.php";
?>