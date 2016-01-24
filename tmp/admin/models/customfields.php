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
 * @version     3.4.0 2014-07-16
 * @since		3.4.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of iCagenda custom fields.
 */
class iCagendaModelcustomfields extends JModelList
{
	/**
	 * Constructor.
	 *
	 * @param	array		An optional associative array of configuration settings.
	 * @see		JController
	 * @since	3.4.0
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'cf.id',
				'ordering', 'cf.ordering',
				'state', 'cf.state',
				'title', 'cf.title',
				'slug', 'cf.slug',
				'parent_form', 'cf.parent_form',
				'type', 'cf.type',
				'required', 'cf.required',
			);
		}

		parent::__construct($config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	3.4.0
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $app->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $app->getUserStateFromRequest($this->context.'.filter.state', 'filter_published', '', 'string');
		$this->setState('filter.state', $published);

		// Filter (dropdown) parent form
		$parent_form = $this->getUserStateFromRequest($this->context.'.filter.parent_form', 'filter_parent_form', '', 'string');
		$this->setState('filter.parent_form', $parent_form);

		// Filter (dropdown) field type
		$type = $this->getUserStateFromRequest($this->context.'.filter.type', 'filter_type', '', 'string');
		$this->setState('filter.type', $type);

		// Load the parameters.
		$params = JComponentHelper::getParams('com_icagenda');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('cf.title', 'asc');
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
	 * @since	3.4.0
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id.= ':' . $this->getState('filter.search');
		$id.= ':' . $this->getState('filter.state');

		return parent::getStoreId($id);
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 * @since	3.4.0
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
				'cf.*'
			)
		);
		$query->from('`#__icagenda_customfields` AS cf');

		// Join over the users for the checked out user.
		$query->select('uc.name AS editor');
		$query->join('LEFT', '#__users AS uc ON uc.id=cf.checked_out');

		// Filter by published state
		$published = $this->getState('filter.state');

		if (is_numeric($published))
		{
			$query->where($db->qn('cf.state') . ' = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where($db->qn('cf.state') . ' IN (0, 1)');
		}

		// Filter by Parent Form
		$parent_form = $db->escape($this->getState('filter.parent_form'));

		if (!empty($parent_form))
		{
			$query->where($db->qn('cf.parent_form') . ' = ' . (int) $parent_form);
		}

		// Filter by Field Type
		$type = $db->escape($this->getState('filter.type'));

		if (!empty($type))
		{
			$query->where($db->qn('cf.type') . ' = ' . (string) $db->q($type));
		}

		// Search Filters
		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where($db->qn('cf.id') . ' = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->Quote('%'.$db->escape($search, true).'%');
				$query->where('( cf.title LIKE '.$search.'  OR  cf.slug LIKE '.$search.'  OR  cf.type LIKE '.$search.' )');
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
	 * Gets a list of Parent Forms.
	 *
	 * @since	3.4.0
	 */
	function getParentForm()
	{
		$list['1'] = JText::_('COM_ICAGENDA_CUSTOMFIELD_PARENT_REGISTRATION_FORM');
		$list['2'] = JText::_('COM_ICAGENDA_CUSTOMFIELD_PARENT_EVENT_EDIT');

		return $list;
	}

	/**
	 * Gets a list of Field Types.
	 *
	 * @since	3.4.0
	 */
	function getFieldTypes()
	{
		$type['text'] = JText::_('COM_ICAGENDA_CUSTOMFIELD_TYPE_TEXT');
		$type['list'] = JText::_('COM_ICAGENDA_CUSTOMFIELD_TYPE_LIST');
		$type['radio'] = JText::_('COM_ICAGENDA_CUSTOMFIELD_TYPE_RADIO');

		return $type;
	}
}
