<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     3.5.13 2015-11-21
 * @since       1.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of iCagenda records.
 */
class iCagendaModelEvents extends JModelList
{
	/**
	 * Constructor.
	 *
	 * @param	array		An optional associative array of configuration settings.
	 * @see		JController
	 * @since	1.0
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				'ordering', 'a.ordering',
				'state', 'a.state',
				'approval', 'a.approval',
				'created', 'a.created',
				'title', 'a.title',
				'username', 'a.username',
				'email', 'a.email',
				'category', 'category',
				'image', 'a.image',
				'file', 'a.file',
				'next', 'a.next',
				'place', 'a.place',
				'city', 'a.city',
				'country', 'a.country',
				'desc', 'a.desc',
				'params', 'a.params',
				'location', 'a.location',
				'category_id',
				'site_itemid', 'a.site_itemid',
				'language', 'e.language',
			);
		}

		parent::__construct($config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 * @since	1.0
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter search.
		$search = $app->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		// Load the filter state.
		$published = $app->getUserStateFromRequest($this->context.'.filter.state', 'filter_published', '', 'string');
		$this->setState('filter.state', $published);

		// Filter (dropdown) category
		$category = $this->getUserStateFromRequest($this->context.'.filter.category', 'filter_category');
		$this->setState('filter.category', $category);

		// Filter categoryId
		$categoryId = $this->getUserStateFromRequest($this->context . '.filter.category_id', 'filter_category_id');
		$this->setState('filter.category_id', $categoryId);

		// Filter (dropdown) upcoming
		$upcoming = $this->getUserStateFromRequest($this->context.'.filter.upcoming', 'filter_upcoming', '', 'string');
		$this->setState('filter.upcoming', $upcoming);

		// Filter (dropdown) Frontend Menu Itemid
		$site_itemid = $this->getUserStateFromRequest($this->context.'.filter.site_itemid', 'filter_site_itemid', '', 'string');
		$this->setState('filter.site_itemid', $site_itemid);

		// Load the parameters.
		$params = JComponentHelper::getParams('com_icagenda');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('a.id', 'desc');
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param	string		$id	A prefix for the store id.
	 * @return	string		A store id.
	 * @since	1.0
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id.= ':' . $this->getState('filter.search');
		$id.= ':' . $this->getState('filter.state');
		$id.= ':' . $this->getState('filter.category_id');
		$id.= ':' . $this->getState('filter.site_itemid');

		return parent::getStoreId($id);
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 * @since	1.0
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.*'
			)
		);
		$query->from('`#__icagenda_events` AS a');

		// Join over the language
		$query->select('l.title AS language_title')
			->join('LEFT', $db->quoteName('#__languages') . ' AS l ON l.lang_code = a.language');

		// Join over the users for the checked out user.
		$query->select('uc.name AS editor');
		$query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');

		// Join over the asset groups.
		$query->select('ag.title AS access_level')
			->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');

		// Join the category
		$query->select('c.title AS category');
		$query->join('LEFT', '#__icagenda_category AS c ON c.id=a.catid');

		// Join over the users for the author.
		$query->select('ua.name AS author_name, ua.username AS author_username')
			->join('LEFT', '#__users AS ua ON ua.id = a.created_by');

		// Filter by published state
		$published = $this->getState('filter.state');

		if (is_numeric($published))
		{
			$query->where('a.state = '.(int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(a.state IN (0, 1))');
		}

		// Filter by search in title
		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = '.(int) substr($search, 3));
			}
			else
			{
				$search = $db->Quote('%'.$db->escape($search, true).'%');
				$query->where('( a.title LIKE '.$search.' OR a.username LIKE '.$search.' OR a.id LIKE '.$search.' OR a.email LIKE '.$search.' OR a.file LIKE '.$search.' OR a.place LIKE '.$search.' OR a.city LIKE '.$search.' OR a.country LIKE '.$search.' OR a.desc LIKE '.$search.' OR c.title LIKE '.$search.')');
			}
		}

		// Filter category (admin)
		$category = $db->escape($this->getState('filter.category'));

		if (!empty($category))
		{
			$query->where('(a.catid='.$category.')');
		}

		// Filter Frontend Menu Itemid (admin)
		$site_itemid = $db->escape($this->getState('filter.site_itemid'));

		if ($site_itemid == '0')
		{
			$query->where('(a.site_itemid = "0")');
		}
		elseif ($site_itemid)
		{
			$query->where('(a.site_itemid = ' . $site_itemid . ')');
		}

		// Filter by categories. (NOT USED (multiple-categories filter))
		$categoryId = $this->getState('filter.category_id');

		if (is_numeric($categoryId) && !empty($categoryId))
		{
			$query->where('a.catid = ' . $categoryId . '');
		}
		elseif (is_array($categoryId) && !empty($categoryId))
		{
			JArrayHelper::toInteger($categoryId);
			$categoryId = implode(',', $categoryId);
			$query->where('a.catid IN (' . $categoryId . ')');
		}


		// Filter Upcoming Dates
		$upcoming = $db->escape($this->getState('filter.upcoming'));

		if (!empty($upcoming))
		{
			if ($upcoming == '1')
			{
				$query->where(' a.next >= CURDATE()');
			}
			elseif ($upcoming == '2')
			{
				$query->where(' a.next < CURDATE() ');
			}
			elseif ($upcoming == '3')
			{
				$query->where(' a.next >= NOW() ');
			}
			elseif ($upcoming == '4')
			{
				$query->where(' a.next >= CURDATE() AND a.next < ( CURDATE() + INTERVAL 1 DAY ) ');
			}
		}

		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering');
		$orderDirn	= $this->state->get('list.direction');

		if ($orderCol && $orderDirn)
		{
			$query->order($db->escape($orderCol.' '.$orderDirn));
		}

		return $query;
	}


	/**
	 * Build an SQL query to load the list of all categories.
	 *
	 * @return	JDatabaseQuery
	 * @since	3.3.0
	 */
	function getCategories()
	{
		// Create a new query object.
		$db		= JFactory::getDBO();
		$query	= $db->getQuery(true);

		// Select the required fields from the table.
		$query->select('c.id AS catid, c.title AS category');
		$query->from('`#__icagenda_category` AS c');

		// Filter by published state
		$query->where('(c.state IN (0,1))');

		// Order Ordering ASC
		$query->order('c.ordering ASC');

		$db->setQuery($query);
		$categories = $db->loadObjectList();

		if (count($categories) > 0)
		{
			foreach ($categories as $cat)
			{
				$list[$cat->catid] = $cat->category;
			}

			return $list;
		}
		else
		{
			return array();
		}
	}

	/**
	 * Build an SQL query to load the list of menu item itemid.
	 *
	 * @return	JDatabaseQuery
	 * @since	3.3.0
	 */
	function getMenuItemID()
	{
		// Create a new query object.
		$db		= JFactory::getDBO();
		$query	= $db->getQuery(true);

		// Select the required fields from the table.
		$query->select('m.id AS itemid, m.link AS menu_link, m.title AS menu_title');
		$query->from('`#__menu` AS m');

		// Filter by published state
		$query->where('(m.link = "index.php?option=com_icagenda&view=submit")');
		$query->where('(m.published IN (0,1))');

		$db->setQuery($query);
		$itemids = $db->loadObjectList();

		$list['0'] = 'Created in admin';

		if (count($itemids) > 0)
		{
			foreach ($itemids as $itemid)
			{
				$list[$itemid->itemid] = $itemid->itemid . ' - ' . $itemid->menu_title;
			}

			return $list;
		}
		else
		{
			return array();
		}
	}

	/**
	 * Gets a list of options for Upcoming (Events) Filter.
	 *
	 * @since	3.3.0
	 */
	function getUpcoming()
	{
		$list['1'] = JText::_('COM_ICAGENDA_OPTION_TODAY_AND_UPCOMING');
		$list['2'] = JText::_('COM_ICAGENDA_OPTION_PAST_EVENTS');
		$list['3'] = JText::_('COM_ICAGENDA_OPTION_UPCOMING_EVENTS');
		$list['4'] = JText::_('COM_ICAGENDA_OPTION_TODAY');

		return $list;
	}
}
