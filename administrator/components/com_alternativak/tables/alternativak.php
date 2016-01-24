<?php
/**
* @version		$Id:alternativak.php  1 2014-04-24 06:23:24Z FT $
* @package		Alternativak
* @subpackage 	Tables
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl TableAlternativak class
*
* @package		Alternativak
* @subpackage	Tables
*/
class TableAlternativak extends JTable
{
	
   /** @var int id- Primary Key  **/
   public $id = null;

   /** @var varchar megnevezes  **/
   public $megnevezes = null;

   /** @var int temakor_id  **/
   public $temakor_id = null;

   /** @var int szavazas_id  **/
   public $szavazas_id = null;

   /** @var text leiras  **/
   public $leiras = null;

   /** @var int letrehozo  **/
   public $letrehozo = null;

   /** @var date letrehozva  **/
   public $letrehozva = null;




	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) 
	{
		parent::__construct('#__alternativak', 'id', $db);
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
		if (trim($this->megnevezes) == '') {
			$this->setError(JText::_('Your Alternativak must contain a megnevezes.')); 
			return false;
		}
		**/		

		return true;
	}
}
