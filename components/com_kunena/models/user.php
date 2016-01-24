<?php
/**
 * Kunena Component
 * @package Kunena.Site
 * @subpackage Models
 *
 * @copyright (C) 2008 - 2014 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

/**
 * User Model for Kunena
 *
 * @since		2.0
 */
class KunenaModelUser extends KunenaModel {
	protected function populateState() {
		$active = $this->app->getMenu ()->getActive ();
		$active = $active ? (int) $active->id : 0;

		$layout = $this->getCmd ( 'layout', 'default' );
		$this->setState ( 'layout', $layout );

		$config = KunenaFactory::getConfig();

		// TODO: create state for item
		if ($layout != 'list') {
			return;
		}

		// List state information
		$limit = $this->getUserStateFromRequest ( "com_kunena.users_{$active}_list_limit", 'limit', $config->get('userlist_rows'), 'int' );
		if ($limit < 1 || $limit > 100) $limit = $config->get('userlist_rows');
		if ($limit < 1) $limit = 30;
		$this->setState ( 'list.limit', $limit );

		$value = $this->getUserStateFromRequest ( "com_kunena.users_{$active}_list_start", 'limitstart', 0, 'int' );
		$value -= $value % $limit;
		$this->setState ( 'list.start', $value );

		$value = $this->getUserStateFromRequest ( "com_kunena.users_{$active}_list_ordering", 'filter_order', 'id', 'cmd' );
		$this->setState ( 'list.ordering', $value );

		$value = $this->getUserStateFromRequest ( "com_kunena.users_{$active}_list_direction", 'filter_order_Dir', 'asc', 'word' );
		if ($value != 'asc')
			$value = 'desc';
		$this->setState ( 'list.direction', $value );

		$value = $this->app->input->get ( 'search', null, 'string' );
		if (!empty($value) && $value != JText::_('COM_KUNENA_USRL_SEARCH')) $this->setState ( 'list.search', $value );

		$db = JFactory::getDBO();
		$query = "SELECT user_id FROM `#__user_usergroup_map` WHERE group_id =8";
		$db->setQuery ( $query );
		$superadmins = (array) $db->loadColumn();
		if (!$superadmins) $superadmins = array(0);
		$this->setState ( 'list.exclude', implode(',', $superadmins));
	}

	public function getQueryWhere() {
		$where = '';

		// Hide super admins from the list
		if ( !KunenaFactory::getConfig()->superadmin_userlist )
		{
			$db = JFactory::getDBO();
			$query = "SELECT user_id FROM `#__user_usergroup_map` WHERE group_id =8";
			$db->setQuery ( $query );
			$superadmins = (array) $db->loadColumn();
			if (!$superadmins) $superadmins = array(0);
			$this->setState ( 'list.exclude', implode(',', $superadmins));

			$where = ' u.id NOT IN ('.$this->getState ( 'list.exclude' ).') AND ';
		}

		if ($this->config->userlist_count_users == '1' ) $where .= '(u.block=0 OR u.activation="")';
		elseif ($this->config->userlist_count_users == '2' ) $where .= '(u.block=0 AND u.activation="")';
		elseif ($this->config->userlist_count_users == '3' ) $where .= 'u.block=0';
		else $where .= '1';

		return $where;
	}

	public function getQuerySearch() {
		// TODO: add strict search from the beginning of the name
		$search = $this->getState ( 'list.search');
		$where = array();
		if ($search) {
			$db = JFactory::getDBO();
			if ($this->config->username) $where[] = "u.username LIKE '%{$db->escape($search)}%'";
			else $where[] = "u.name LIKE '%{$db->escape($search)}%'";
			$where = 'AND ('.implode(' OR ', $where).')';
		} else {
			$where = '';
		}

		return $where;
	}

	public function getTotal() {
		static $total = false;
		if ($total === false) {
			$db = JFactory::getDBO();
			$where = $this->getQueryWhere();
			$db->setQuery ( "SELECT COUNT(*) FROM #__users AS u WHERE {$where}" );
			$total = $db->loadResult ();
			KunenaError::checkDatabaseError();
		}
		return $total;
	}

	public function getCount() {
		static $total = false;
		if ($total === false) {
			$db = JFactory::getDBO();
			$where = $this->getQueryWhere();
			$search = $this->getQuerySearch();
			$query = "SELECT COUNT(*)
				FROM #__users AS u
				LEFT JOIN #__kunena_users AS ku ON ku.userid = u.id
				WHERE {$where} {$search}";
			$db->setQuery ( $query );
			$total = $db->loadResult ();
			KunenaError::checkDatabaseError();
		}
		return $total;
	}

	public function getItems() {
		// FIXME: use pagination object and redirect on illegal page (maybe in the view)
		// TODO: should we reset to page 1 when user makes a new search?
		static $items = false;
		if ($items === false) {
			$limitstart = $this->getState ( 'list.start');
			$limit = $this->getState ( 'list.limit');
			$count = $this->getCount();
			if ($count < $limitstart) {
				$limitstart = $count - ($count % $limit);
				$this->setState ( 'list.start', $limitstart );
			}

			$db = JFactory::getDBO();
			$where = $this->getQueryWhere();
			$search = $this->getQuerySearch();
			$query = "SELECT u.id
				FROM #__users AS u
				LEFT JOIN #__kunena_users AS ku ON ku.userid = u.id
				WHERE {$where} {$search}";
			$query .= " ORDER BY {$db->quoteName($this->getState ( 'list.ordering'))} {$this->getState ( 'list.direction')}";

			$db->setQuery ( $query, $limitstart, $limit );
			$items = $db->loadColumn();
			KunenaError::checkDatabaseError();

			// Prefetch all users/avatars to avoid user by user queries during template iterations
			$items = KunenaUserHelper::loadUsers($items);
		}
		return $items;
	}
}
