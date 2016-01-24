<?php
/**
* @version		$Id:szavazasok.php  1 2014-04-13 13:21:32Z FT $
* @package		Szavazasok
* @subpackage 	Tables
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl TableSzavazasok class
*
* @package		Szavazasok
* @subpackage	Tables
*/
class TableSzavazasok extends JTable
{
	
   /** @var int id- Primary Key  **/
   public $id = null;

   /** @var varchar megnevezes  **/
   public $megnevezes = null;

   /** @var int temakor_id  **/
   public $temakor_id = null;

   /** @var text leiras  **/
   public $leiras = null;

   /** @var int titkos  **/
   public $titkos = null;

   /** @var int szavazok  **/
   public $szavazok = null;

   /** @var int alternativajavaslok  **/
   public $alternativajavaslok = null;

   /** @var date vita1_vege  **/
   public $vita1_vege = null;

   /** @var date vita2_vege  **/
   public $vita2_vege = null;

   /** @var date szavazas_vege  **/
   public $szavazas_vege = null;

   /** @var int vita1  **/
   public $vita1 = null;

   /** @var int vita2  **/
   public $vita2 = null;

   /** @var int szavazas  **/
   public $szavazas = null;

   /** @var int lezart  **/
   public $lezart = null;

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
		parent::__construct('#__szavazasok', 'id', $db);
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
			$this->setError(JText::_('Your Szavazasok must contain a megnevezes.')); 
			return false;
		}
		**/		

		return true;
	}
}
