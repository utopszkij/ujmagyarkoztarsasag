<?php
/**
 * @version		$Id: category.php 125 2012-10-09 11:09:48Z michel $
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('JPATH_BASE') or die;


require_once(JPATH_COMPONENT_ADMINISTRATOR.'/tables/tablenested.php');


/**
 * Category table
 *
 * @package 	Joomla.Framework
 * @subpackage	Table
 * @since		1.0
 */
class JTableAmmvcCategory extends AmmvcJTableNested
{
	/**
	 * @var int Primary key
	 */
	public $id = null;


	/**
	 *  @var varchar
	 */
	public $path = null;

	/**
	 *  @var string
	 */
	public $extension = null;

	/**
	 *  @var string The
	 */
	public $title = null;

	/**
	 *  @var string The the alias for the category
	 */
	public $alias = null;

	/**
	 *  @var string
	 */
	public $description = null;

	/**
	 *  @var int
	 */
	public $published = null;

	/**
	 *  @var boolean
	 */
	public $checked_out = 0;

	/**
	 *  @var time
	 */
	public $checked_out_time = null;

	/**
	 *  @var int
	 */
	public $access = null;

	/**
	 *  @var string
	 */
	public $params = '';

	public $created_user_id = null;

	public $created_time = null;

	public $modified_user_id = null;

	public $modified_time = null;

	public $hits = null;

	/**
	 *  @var string
	 */
	public $language = null;

	/**
	 * @param database A database connector object
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__ammvc_categories', 'id', $db);
		
		$this->access = version_compare(JVERSION,'3.0','lt') ? (int) JFactory::getConfig()->getValue('access') : (int) JFactory::getConfig()->get('access');		
	}

	/**
	 * Method to compute the default name of the asset.
	 * The default name is in the form `table_name.id`
	 * where id is the value of the primary key of the table.
	 *
	 * @return	string
	 */
	protected function _getAssetName()
	{
		$k = $this->getKeyName();
		return $this->extension.'.category.'.(int) $this->$k;
	}

	/**
	 * Method to return the title to use for the asset table.
	 *
	 * @return	string
	 * @since	1.6
	 */
	protected function _getAssetTitle()
	{
		return $this->title;
	}

	

	/**
	 * Method to delete a row from the database table by primary key value.
	 *
	 * @param	mixed	An optional primary key value to delete.  If not set the
	 * 					instance property value is used.
	 * @return	boolean	True on success.
	 * @since	1.0
	 * @link	http://docs.joomla.org/JTable/delete
	 */
	public function delete($pk = null)
	{
		// Initialize variables.
		$k = $this->getKeyName();
		$pk = (is_null($pk)) ? $this->$k : $pk;

		// If no primary key is given, return false.
		if ($pk === null) {
			return false;
		}
		
	

		// Delete the row by primary key.
		$this->_db->setQuery(
			'DELETE FROM `'.$this->_tbl.'`' .
			' WHERE `'.$this->getKeyName().'` = '.$this->_db->quote($pk)
		);

		$this->_db->query();

		// Check for a database error.
		if ($this->_db->getErrorNum()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return true;
	}	
	/**
	 * Get the parent asset id for the record
	 *
	 * @return	int
	 */
	protected function _getAssetParentId()
	{
		// Initialize variables.
	
		$assetId = null;

		// This is a category under a category.
		if ($this->parent_id > 1) {
			// Build the query to get the asset id for the parent category.
			$query = new JQuery;
			$query->select('asset_id');
			$query->from('#__ammvc_categories');
			$query->where('id = '.(int) $this->parent_id);

			// Get the asset id from the database.
			$this->_db->setQuery($query);
			if ($result = $this->_db->loadResult()) {
				$assetId = (int) $result;
			}
		} elseif ($assetId === null) {
			// This is a category that needs to parent with the extension.
			// Build the query to get the asset id for the parent category.
			$query = new JQuery;
			$query->select('id');
			$query->from('#__assets');
			$query->where('name = '.$this->_db->quote($this->extension));

			// Get the asset id from the database.
			$this->_db->setQuery($query);
			if ($result = $this->_db->loadResult()) {
				$assetId = (int) $result;
			}
		}

		// Return the asset id.
		if ($assetId) {
			return $assetId;
		} else {
			return parent::_getAssetParentId();
		}
	}
	
	/**
	 * Overloaded bind function.
	 *
	 * @param	array		named array
	 * @return	null|string	null is operation was satisfactory, otherwise returns an error
	 * @see		JTable:bind
	 * @since	1.5
	 */
	public function bind($array, $ignore = '')
	{


	    if (isset($array['params']) && is_array($array['params'])) {
			$registry = new JRegistry();
			$registry->loadArray($array['params']);
			$array['params'] = (string)$registry;
		}

		if (isset($array['metadata']) && is_array($array['metadata'])) {
			$registry = new JRegistry();
			$registry->loadArray($array['metadata']);
			$array['metadata'] = (string)$registry;
		}

		// Bind the rules. Joomla 1.6 & gt
		$jv = new JVersion(); 
        if($jv->RELEASE > 1.5) {
		    if (isset($array['rules']) && is_array($array['rules'])) {
			    $rules = new JRules($array['rules']);
			    $this->setRules($rules);	
		    }
        } 

		return parent::bind($array, $ignore);
	}	
	
	/**
	 * Override check function
	 *
	 * @return	boolean
	 * @see		JTable::check
	 * @since	1.5
	 */
	public function check()
	{
		// Check for a title.
		if (trim($this->title) == '') {
			$this->setError(JText::sprintf('must contain a title', JText::_('Category')));
			return false;
		}

		if (empty($this->alias)) {
			$this->alias = strtolower($this->title);
		}

		$this->alias = JFilterOutput::stringURLSafe($this->alias);
		if (trim(str_replace('-', '', $this->alias)) == '') {
			$datenow = &JFactory::getDate();
			$this->alias = $datenow->format('Y-m-d-H-i-s');
		}

		return true;
	}
}
