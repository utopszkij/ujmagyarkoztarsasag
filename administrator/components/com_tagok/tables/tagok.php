<?php
/**
* @version		$Id:tagok.php  1 2014-05-06 09:26:42Z FT $
* @package		Tagok
* @subpackage 	Tables
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl TableTagok class
*
* @package		Tagok
* @subpackage	Tables
*/
class TableTagok extends JTable
{
	
   /** @var varchar id  **/
   public $id = null;

   /** @var int temakor_id  **/
   public $temakor_id = null;

   /** @var int user_id  **/
   public $user_id = null;

   /** @var int admin  **/
   public $admin = null;




	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) 
	{
		parent::__construct('#__tagok', 'id', $db);
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
			$this->setError(JText::_('Your Tagok must contain a id.')); 
			return false;
		}
		**/		

		return true;
	}
}
