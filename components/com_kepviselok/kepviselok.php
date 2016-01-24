<?php
/**
 * @version $Id: #component#.php 125 2012-10-09 11:09:48Z michel $ 1 2014-05-12Z FT $
* @package	Kepviselok
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
 */

//--No direct access
defined('_JEXEC') or die('=;)');

// DS has removed from J 3.0
if(!defined('DS')) {
	define('DS','/');
}

// Require the base controller
require_once( JPATH_COMPONENT.'/controller.php' );

jimport('joomla.application.component.model');
require_once( JPATH_COMPONENT.'/models/model.php' );
jimport('joomla.application.component.helper');
JHTML::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.'/helpers' );
//set the default view
$task = JRequest::getWord('task');


$config 	=& JComponentHelper::getParams( 'com_kepviselok' );

$controller = JRequest::getWord('view', 'kepviselok');

$ControllerConfig = array();

// Require specific controller if requested
if ($controller) {   
   $path = JPATH_COMPONENT.'/controllers/'.$controller.'.php';
   $ControllerConfig = array('viewname'=>strtolower($controller),'mainmodel'=>strtolower($controller),'itemname'=>ucfirst(strtolower($controller)));  
   if (file_exists($path)) {
       require_once $path;
   } else {

	   $controller = '';	   
   }
}


// Create the controller
$classname    = 'KepviselokController'.$controller;
$controller   = new $classname($ControllerConfig );

// Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) );

// Redirect if set by the controller
$controller->redirect();