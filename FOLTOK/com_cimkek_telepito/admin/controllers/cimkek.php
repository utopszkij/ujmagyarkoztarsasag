<?php
/**
* @version		$Id: default_controller.php 96 2011-08-11 06:59:32Z michel $
* @package		Cimkek
* @subpackage 	Controllers
* @copyright	Copyright (C) 2015, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * CimkekCimkek Controller
 *
 * @package    Cimkek
 * @subpackage Controllers
 */
class CimkekControllerCimkek extends CimkekController
{
	/**
	 * Constructor
	 */
	protected $_viewname = 'cimkek'; 
	 
	public function __construct($config = array ()) 
	{
		parent :: __construct($config);
		JRequest :: setVar('view', $this->_viewname);

	}
	

	
	
}// class
?>