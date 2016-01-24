<?php
/**
 * @version		$Id:jacc.php  1 2010-08-15 12:57:56Z Michael Liebler $
 * @package		Jacc
 * @subpackage 	Tables
 * @copyright	Copyright (C) 2010, mliebler. All rights reserved.
 * @license #http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Jimtawl Tablejacc class
 *
 * @package		Jacc
 * @subpackage	Tables
 */
class TableJacc extends JTable 
{
	
  /** @var int(11) id - Primary Key  **/
	public $id = null;

	/** @var varchar(50) name  **/
	public $name = null;

	/** @var varchar(50) version  **/
	public $version = null;

	/** @var text tables  **/
	public $tables = null;

	/** @var text description  **/
	public $description = null;

	/** @var tinyint use  **/
	public $use = null;
	 
	/** @var datetime created  **/
	public $created = null;

	/** @var tinyint published  **/
	public $published = null;

	/** @var text params  **/
	public $params = null;




	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) 
	{

		parent::__construct('#__jacc', 'id', $db);
	}

	/**
	 * Overloaded bind function
	 * @access public
	 * @param array $hash named array
	 * @return null|string	null is operation was satisfactory, otherwise returns an error
	 */

	public function bind($array, $ignore = '')
	{
		
	    if (key_exists( 'params', $array ) && is_array( $array['params'] )) {
			$array['params'] = json_encode($array['params']);
		}

		return parent::bind($array, $ignore);
	}

	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 * @since 1.0
	 */
	public function check()
	{

		if ($this->id === 0) {
			$this->ordering = $this->getNextOrder();
		}	
			
		if (!$this->created) {
			$date = JFactory::getDate();
			$this->created = $date->format("Y-m-d H:i:s");
		}
				
		return true;
	}
}
