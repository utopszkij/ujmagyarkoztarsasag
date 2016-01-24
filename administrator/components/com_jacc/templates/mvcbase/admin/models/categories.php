<?php
/**
 * @version		$Id: categories.php 127 2012-10-16 14:19:02Z michel $
 * @copyright 	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

jimport('joomla.application.component.model');



/**
 * Categories Component Categories Model
 *
 * @package		Joomla.Administrator
 * @subpackage	com_categories
 * @since		1.6
 */
class ##Component##ModelCategories extends JModelLegacy
{
	/**
	 * Model context string.
	 *
	 * @var		string
	 */

	
	/**
	 * @var		string	The URL option for the component.	
	 */
	protected $option = null;
	
	protected $_context = 'com_##component##_categories.categories';
	
	public function __construct()
	{
		parent::__construct();
		if (!isset($this->_state) and isset($this->state) ) $this->_state = $this->state;
		
		$app = &JFactory::getApplication('administrator');
		
		if (empty($this->option)) {
			$r = null;
			if (!preg_match('/(.*)Model/i', get_class($this), $r)) {
				JError::raiseError(500, JText::_('No Model name'));
			}
			$this->option = 'com_'.strtolower($r[1]);
		}
		
		$limit			=	 	$app ->getUserStateFromRequest( 'global.list.limit', 'limit', $app->getCfg('list_limit', 0), 'int' );
		$limitstart	= 		$app ->getUserStateFromRequest( $this->option.'.limitstart', 'limitstart', 0, 'int' );

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
	
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);

		
	}	
	
	/**
	 * Method to get a pagination object 
	 *
	 * @access public
	 * @return integer
	 */
	public function getPagination()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_pagination)) {
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}

		return $this->_pagination;
	}
	
	
	/**
	 * Method to get a list of items.
	 *
	 * @return	mixed	An array of objects on success, false on failure.
	 */
	public function &getItems()
	{
		$this->_populateState();		
		// Get a unique key for the current list state.
		$key = $this->_getStoreId($this->_context);

		// Try to load the value from internal storage.
		if (!empty ($this->_lists[$key])) {
			return $this->_lists[$key];
		}

		// Load the list.
		$query	= $this->_getListQuery();
		$rows	= $this->_getList((string) $query, $this->getState('limitstart'), $this->getState('limit'));

		// Add the rows to the internal storage.
		$this->_lists[$key] = $rows;

		return $this->_lists[$key];
	}	
	/**
	 * Method to auto-populate the model state.
	 *
	 * @since	1.6
	 */
	private function _populateState()
	{
		
		$app = &JFactory::getApplication();

		$search = $app->getUserStateFromRequest($this->_context.'.search', 'filter_search');
		$this->setState('filter.search', $search);

		$extension = $app->getUserStateFromRequest($this->_context.'.filter.extension', 'extension');

		$this->setState('filter.extension', $extension);

		$access = $app->getUserStateFromRequest($this->_context.'.filter.access', 'filter_access', 0, 'int');
		$this->setState('filter.access', $access);

		$published 	= $app->getUserStateFromRequest($this->_context.'.published', 'filter_published', '1');
		$this->setState('filter.published', $published);

		// List state information
		$limit 		= $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'));
		$this->setState('list.limit', $limit);

		$limitstart = $app->getUserStateFromRequest($this->_context.'.limitstart', 'limitstart', 0);
		$this->setState('list.limitstart', $limitstart);

		$orderCol	= $app->getUserStateFromRequest($this->_context.'.ordercol', 'filter_order', 'a.lft');
		$this->setState('list.ordering', $orderCol);

		$orderDirn	= $app->getUserStateFromRequest($this->_context.'.orderdirn', 'filter_order_Dir', 'asc');
		$this->setState('list.direction', $orderDirn);
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param	string		$id	A prefix for the store id.
	 *
	 * @return	string		A store id.
	 */
	protected function _getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('list.start');
		$id	.= ':'.$this->getState('list.limit');
		$id	.= ':'.$this->getState('list.ordering');
		$id	.= ':'.$this->getState('list.direction');
		$id	.= ':'.$this->getState('filter.search');
		$id	.= ':'.$this->getState('filter.extension');
		$id	.= ':'.$this->getState('filter.published');

		return md5($id);
	}

	/**
	 * @param	boolean	True to join selected foreign information
	 *
	 * @return	string
	 */
	private function _getListQuery($resolveFKs = true)
	{
		// Create a new query object.
		$query = $this->_db->getQuery(true);

		// Select the required fields from the table.

		$query->select('a.*');
		$query->from('#__##component##_categories AS a');


		// Filter by extension
		if ($extension = $this->getState('filter.extension')) {
			$query->where('a.extension = '.$this->_db->quote($extension));
		}

		// Filter by access level.
		if ($access = $this->getState('filter.access')) {
			$query->where('a.access = ' . (int) $access);
		}

		// Filter by published state
		$published = $this->getState('filter.published');

		if (is_numeric($published)) {
			$query->where('a.published = ' . (int) $published);
		} else if ($published === '') {
			$query->where('(a.published IN (0, 1))');
		}

		// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = '.(int) substr($search, 3));
			} else if (stripos($search, 'author:') === 0) {
				$search = $this->_db->Quote('%'.$this->_db->getEscaped(substr($search, 7), true).'%');
				$query->where('ua.name LIKE '.$search.' OR ua.username LIKE '.$search);
			} else {
				$search = $this->_db->Quote('%'.$this->_db->getEscaped($search, true).'%');
				$query->where('a.title LIKE '.$search.' OR a.alias LIKE '.$search);
			}
		}

		// Add the list ordering clause.
		$query->order($this->_db->quoteName($this->getState('list.ordering', 'a.title')).' '.$this->getState('list.direction', 'ASC'));

		//echo nl2br(str_replace('#__','jos_',$query));
		return $query;
	}
	/**
	 * Method to get the total number of published items.
	 *
	 * @return	int		The number of published items.
	 */
	public function getTotal()
	{
		// Get a unique key for the current list state.
		$key = $this->_getStoreId($this->_context);

		// Try to load the value from internal storage.
		if (!empty ($this->_totals[$key])) {
			return $this->_totals[$key];
		}

		// Load the total.
		$query = $this->_getListQuery();
		$return = (int)$this->_getListCount((string) $query);

		// Check for a database error.
		if ($this->_db->getErrorNum()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Push the value into internal storage.
		$this->_totals[$key] = $return;

		return $this->_totals[$key];
	}	
}
