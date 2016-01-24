<?php
/**
* @version		$Id: packages.php 118 2012-10-02 08:52:27Z michel $
* @package		Jacc
* @subpackage 	Tables
* @copyright	Copyright (C) 2011, Michael Liebler. All rights reserved.
* @license #http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl TablePackages class
*
* @package		Jacc
* @subpackage	Tables
*/
class TablePackages extends JTable
{
	
   /** @var int id- Primary Key  **/
   public $id = null;

   /** @var varchar name  **/
   public $name = null;

   /** @var varchar alias  **/
   public $alias = null;

   /** @var text description  **/
   public $description = null;

   /** @var tinyint published  **/
   public $published = null;

   /** @var datetime created  **/
   public $created = null;

   /** @var text params  **/
   public $params = null;

   /** @var int ordering  **/
   public $ordering = null;

   /** @var varchar version  **/
   public $version = null;

   /** @var varchar packagerurl  **/
   public $packagerurl = null;

   /** @var varchar updateurl  **/
   public $updateurl = null;




	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) 
	{
		parent::__construct('#__jacc_packages', 'id', $db);
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
		if ( isset( $array['params'] ) && is_array( $array['params'] ) )
        {
            $array['params'] = json_encode( $array['params'] );

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
			//get next ordering

			
			$this->ordering = $this->getNextOrder( );

		}		
		if (!$this->created) {
			$date = JFactory::getDate();
			$this->created = $date->format("Y-m-d H:i:s");
		}

		/** check for valid name */
		/**
		if (trim($this->name) == '') {
			$this->setError(JText::_('Your Packages must contain a name.')); 
			return false;
		}
		**/
		if(empty($this->alias)) {
			$this->alias = $this->name;
		}
		
		$this->alias = JFilterOutput::stringURLSafe($this->alias);
		
		/** check for existing alias */
		$query = 'SELECT '.$this->getKeyName().' FROM '.$this->_tbl.' WHERE alias = '.$this->_db->Quote($this->alias);
		$this->_db->setQuery($query);
		
		$xid = intval($this->_db->loadResult());

		if ($xid && $xid != intval($this->{$this->getKeyName()})) {		
			$this->setError(JText::_('Can\'t save to Packages. Name already exists'));
			return false;
		}
		return true;
	}
}
