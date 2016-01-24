<?php
/**
* @version		$Id:temakorok.php  1 2014-04-04 11:03:10Z FT $
* @package		Temakorok
* @subpackage 	Tables
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl TableTemakorok class
*
* @package		Temakorok
* @subpackage	Tables
*/
class TableTemakorok extends JTable {
   public $id = null;
   public $szulo = null;
   public $megnevezes = null;
   public $leiras = null;
   public $lathatosag = null;
   public $szavazok = "1";
   public $szavazasinditok = "1";
   public $allapot = null;
   public $letrehozo = null;
   public $letrehozva = null;
   public $lezaro = null;
   public $lezarva = null;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db)	{
    parent::__construct('#__temakorok', 'id', $db);
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
	public function bind($array, $ignore = '')	{ 
		return parent::bind($array, $ignore);		
	}


	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 * @since 1.0
	 */
	public function check() {
   $result = true;
   $msg = '';
   if (trim($this->megnevezes) == '') {
     $result = false;
     $msg .= '<p>'.JText::_('TEAKOROK_MEGNEVEZES_REQUED').'</p>';
   }
   if ($msg != '')  $this->setError($msg);
   return $result;
 }
 /**
  * store date from propertys
  * @return boolean  
  */    
 public function store($updateNulls = false) {
   $user = JFactory::getUser();
   if ($this->id == 0) {
     $this->letrehozo = $user->id;
     $this->letrehozva = date('Y-m-d H:i:s');
     $this->lezaro = 0;
     $this->lezarva = '0000-00-00 00:00:00';
   }
   if ($this->allapot == '1') {
     if ($this->lezaro == 0) {
       $this->lezaro = $user->id;
       $this->lezarva = date('Y-m-d H:i:s');
     }
   } else {
     $this->lezaro = 0;
     $this->lezarva = '0000-00-00 00:00:00';
   }
   return parent::store($updateNulls);
 } 
}

?>