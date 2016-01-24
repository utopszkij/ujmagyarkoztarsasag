<?php
/**
 * @version		$Id: sql.php 118 2012-10-02 08:52:27Z michel $
 * @author	   	mliebler
 * @package    Jacc
 * @subpackage Controllers
 * @copyright  	Copyright (C) 2010, mliebler. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * Jacc Standard Controller
 *
 * @package Jacc   
 * @subpackage Controllers
 */
class JaccControllerSql extends JControllerLegacy
{

	/**
	 * Constructor
	 */
		 
	public function __construct($config = array ()) 
	{
		
		parent :: __construct($config);
	
	}
	
	function display() 
	{
		
		$config =& JFactory::getConfig();
		$dbprefix = version_compare(JVERSION,'3.0','lt') ? $config->getValue('config.dbprefix') : $config->get('dbprefix');
		$sqlFile =  JPATH_COMPONENT_ADMINISTRATOR.DS.'sql'.DS.'example.sql';
		$sql = file_get_contents($sqlFile);

		print "<pre>";
		print str_replace('#__', $dbprefix, $sql);
		print "</pre>";
	}	
}
?>