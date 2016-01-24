<?php
/**
* @version		$Id:beallitasok.php  1 2014-04-11 06:38:46Z FT $
* @package		Beallitasok
* @subpackage 	Tables
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl TableBeallitasok class
*
* @package		Beallitasok
* @subpackage	Tables
*/
class TableBeallitasok extends JTable
{
	
   /** @var varchar id  **/
   public $id = null;

   /** @var int temakor_felvivo  **/
   public $json = '';




	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) 
	{
		parent::__construct('#__beallitasok', 'id', $db);
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
		if (trim($this->id) == '') {
			$this->setError(JText::_('Your Beallitasok must contain a id.')); 
			return false;
		}
		**/		

		return true;
	}
}
