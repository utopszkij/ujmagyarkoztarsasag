<?php
/**
* @version		$Id:kepviselok.php  1 2014-05-12 12:13:55Z FT $
* @package		Kepviselok
* @subpackage 	Tables
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl TableKepviselok class
*
* @package		Kepviselok
* @subpackage	Tables
*/
class TableKepviselok extends JTable
{
	
   /** @var varchar id  **/
   public $id = null;

   /** @var int user_id  **/
   public $user_id = null;

   /** @var int kepviselo_id  **/
   public $kepviselo_id = null;

   /** @var int temakor_id  **/
   public $temakor_id = null;

   /** @var int szavazas_id  **/
   public $szavazas_id = null;

   /** @var date lejarat  **/
   public $lejarat = null;




	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) 
	{
		parent::__construct('#__kepviselok', 'id', $db);
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
			$this->setError(JText::_('Your Kepviselok must contain a id.')); 
			return false;
		}
		**/		

		return true;
	}
}
