<?php
/**
 * Kunena Component
 * @package Kunena.Framework
 * @subpackage Forum.Category.User
 *
 * @copyright (C) 2008 - 2014 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

/**
 * Class KunenaForumCategoryUserHelper
 */
abstract class KunenaForumCategoryUserHelper {
	// Global for every instance
	protected static $_instances = array();

	/**
	 * Get an instance of KunenaForumCategoryUser object.
	 *
	 * @param null|int	$category	The category id to load.
	 * @param mixed		$user		The user id to load - Can be only an integer.
	 * @param bool		$reload		Reload objects from the database.
	 *
	 * @return KunenaForumCategoryUser	The user category object.
	 */
	static public function get($category = null, $user = null, $reload = false) {
		if ($category instanceof KunenaForumCategory) {
			$category = $category->id;
		}
		$category = intval ( $category );
		$user = KunenaUserHelper::get($user);

		if ($category === null)
			return new KunenaForumCategoryUser (null, $user);

		if ($reload || empty ( self::$_instances [$user->userid][$category] )) {
			$user_categories = KunenaForumCategoryUserHelper::getCategories ( $category, $user );
			self::$_instances [$user->userid][$category] = array_pop( $user_categories );
		}

		return self::$_instances [$user->userid][$category];
	}

	/**
	 * Get categories for a specific user.
	 *
	 * @param bool|array|int	$ids		The category ids to load.
	 * @param mixed				$user		The user id to load.
	 *
	 * @return KunenaForumCategoryUser[]
	 */
	static public function getCategories($ids = false, $user=null) {
		$user = KunenaUserHelper::get($user);
		if ($ids === false) {
			// Get categories which are seen by current user
			$ids = KunenaForumCategoryHelper::getCategories();
		} elseif (!is_array ($ids) ) {
			$ids = array($ids);
		}
		// Convert category objects into ids
		foreach ($ids as $i=>$id) {
			if ($id instanceof KunenaForumCategory) $ids[$i] = $id->id;
		}
		$ids = array_unique($ids);
		self::loadCategories($ids, $user);

		$list = array ();
		foreach ( $ids as $id ) {
			if (!empty(self::$_instances [$user->userid][$id])) {
				$list [$id] = self::$_instances [$user->userid][$id];
			}
		}

		return $list;
	}

	// Internal functions

	/**
	 * Load categories for a specific user.
	 *
	 * @param array			$ids		The category ids to load.
	 * @param KunenaUser	$user
	 */
	static protected function loadCategories(array $ids, KunenaUser $user) {
		foreach ($ids as $i=>$id) {
			$iid = intval($id);
			if ($iid != $id || isset(self::$_instances [$user->userid][$id]))
				unset($ids[$i]);
		}
		if (empty($ids))
			return;

		$idlist = implode(',', $ids);
		$db = JFactory::getDBO ();
		$query = "SELECT * FROM #__kunena_user_categories WHERE user_id={$db->quote($user->userid)} AND category_id IN ({$idlist})";
		$db->setQuery ( $query );
		$results = (array) $db->loadAssocList ('category_id');
		KunenaError::checkDatabaseError ();

		foreach ( $ids as $id ) {
			if (isset($results[$id])) {
				$instance = new KunenaForumCategoryUser ();
				$instance->bind ( $results[$id] );
				$instance->exists(true);
				self::$_instances [$user->userid][$id] = $instance;
			} else {
				self::$_instances [$user->userid][$id] = new KunenaForumCategoryUser ($id, $user);
			}
		}
		unset ($results);
	}
}
