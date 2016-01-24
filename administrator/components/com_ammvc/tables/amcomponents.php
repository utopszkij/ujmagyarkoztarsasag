<?php
/**
* @version		$Id:amcomponents.php  1 2014-04-04 07:15:47Z FT $
* @package		Ammvc
* @subpackage 	Tables
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl TableAmcomponents class
*
* @package		Ammvc
* @subpackage	Tables
*/
class TableAmcomponents extends JTable
{
	
   /** @var int id- Primary Key  **/
   public $id = null;

   /** @var varchar title  **/
   public $title = null;

   /** @var text description  **/
   public $description = null;

   /** @var varchar name  **/
   public $name = null;

   /** @var varchar author  **/
   public $author = null;

   /** @var varchar authoremail  **/
   public $authoremail = null;

   /** @var varchar licence  **/
   public $licence = null;

   /** @var varchar version  **/
   public $version = null;




	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) 
	{
		parent::__construct('#__amcomponents', 'id', $db);
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
		if (trim($this->title) == '') {
			$this->setError(JText::_('Your Amcomponents must contain a title.')); 
			return false;
		}
		**/		

		return true;
	}
}
