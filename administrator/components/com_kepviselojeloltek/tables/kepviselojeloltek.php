<?php
/**
* @version		$Id:kepviselojeloltek.php  1 2014-05-11 07:38:36Z FT $
* @package		Kepviselojeloltek
* @subpackage 	Tables
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl TableKepviselojeloltek class
*
* @package		Kepviselojeloltek
* @subpackage	Tables
*/
class TableKepviselojeloltek extends JTable
{
	
   /** @var int id- Primary Key  **/
   public $id = null;

   /** @var int user_id  **/
   public $user_id = null;

   /** @var int temakor_id  **/
   public $temakor_id = null;

   /** @var int szavazas_id  **/
   public $szavazas_id = null;

   /** @var text leiras  **/
   public $leiras = null;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) 
	{
		parent::__construct('#__kepviselojeloltek', 'id', $db);
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
			$this->setError(JText::_('Your Kepviselojeloltek must contain a id.')); 
			return false;
		}
		**/		

		return true;
	}
}
