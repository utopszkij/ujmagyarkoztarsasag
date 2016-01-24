<?php
/**
* @version		$Id: default_controller.php 96 2011-08-11 06:59:32Z michel $
* @package		Beallitasok
* @subpackage 	Controllers
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * BeallitasokBeallitasok Controller
 *
 * @package    Beallitasok
 * @subpackage Controllers
 */
class BeallitasokControllerBeallitasok extends BeallitasokController
{
	/**
	 * Constructor
	 */
	protected $_viewname = 'beallitasok'; 
	 
	public function __construct($config = array ()) 
	{
		parent :: __construct($config);
		JRequest :: setVar('view', $this->_viewname);

	}
	

	
	
}// class
?>