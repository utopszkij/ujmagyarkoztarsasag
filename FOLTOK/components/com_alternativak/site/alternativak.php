<?php
/**
* @version $Id: #component#.php 125 2012-10-09 11:09:48Z michel $ 1 2014-04-04Z FT $
* @package	Szavazasok
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
* 
* Alapértelmezetten az adotttémakör szavazásainak rendezhető, lapozható, 
* szürhető listája jelenik meg
* 
* A lehetséges user interakciók:
* Tagok --> a témakörbe regisztrált tagok listája:  com_tagok tagoklis 
* Súgó  --> súgó szöveg megjelenítése
* Új alternativa --> alternativa felvitel  képernyő
* szavazás módositás --> szavazás modositó képernyő com_szavazasok szavazasok edit
* szavazok --> szavazó képernyő com_szavazasok szavazasok szavazoform
* eredmény --> szavazás eredmény képernyő com_szavazasok szavazasok eredmeny 
* vissza gomb click --> temakör lista com_temakorok temakoroklist
* 
* Más taskokk általi  aktiválások
* saját edit ás add képernyő --> adat tárolás 
* saját deleteform képernyő --> törlés   
* com_szavazasok show/edit --> módosító képernyő
* com_szavazasok show/deleteform --> törlés ellenörző kérdés képernyő
*  
*/

//--No direct access
defined('_JEXEC') or die('=;)');

// DS has removed from J 3.0
if(!defined('DS')) {
	define('DS','/');
}


require_once( JPATH_COMPONENT.'/controller.php' );
jimport('joomla.application.component.model');
jimport('joomla.application.component.helper');
JHTML::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.'/helpers' );
// ===============set the default values ========================
$task = JRequest::getWord('task','browse');
$config 	=& JComponentHelper::getParams( 'com_alternativak' );
$viewname = JRequest::getWord('view', 'alternativaklist');
// ==============================================================
// load specific controller if exists
$path = JPATH_COMPONENT.'/controllers/'.$viewname.'.php';
if (file_exists($path)) {
    require_once $path;
    $controllername = $viewname;
} else {
    $controllername = '';
}

$ControllerConfig = array('viewname'=>strtolower($viewname),
                          'mainmodel'=>strtolower($viewname),
                          'itemname'=>ucfirst(strtolower($viewname)));  

// Create the controller
$classname    = 'AlternativakController'.$controllername;

$controller   = new $classname ($ControllerConfig);
// Perform the Request task
$controller->execute( $task );
// Redirect if set by the controller
$controller->redirect();