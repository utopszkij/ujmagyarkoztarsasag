<?php
/**
* @version		$Id:cimkek.php  1 2015-10-08 08:36:24Z FT $
* @package		Cimkek
* @subpackage 	Tables
* @copyright	Copyright (C) 2015, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl TableCimkek class
*
* @package		Cimkek
* @subpackage	Tables
*/
class TableCimkek extends JTable
{
	
   /** @var int id- Primary Key  **/
   public $id = null;

   /** @var varchar cimke  **/
   public $cimke = null;




	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) 
	{
		parent::__construct('#__cimkek', 'id', $db);
	}

	/**
	* Overloaded bind function
	*
	* @acces public
	* @param array $hash named array
	* @return null|string	null is operation was satisfactory, otherwise returns an error
	* @see JTable:bind
	* @since 1.5
	*/
	public function bind($array, $ignore = '')
	{ 
		
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



		/** check for valid name */
		/**
		if (trim($this->cimke) == '') {
			$this->setError(JText::_('Your Cimkek must contain a cimke.')); 
			return false;
		}
		**/		

		return true;
	}
}
