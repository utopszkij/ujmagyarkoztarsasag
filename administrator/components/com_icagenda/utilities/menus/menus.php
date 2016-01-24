<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     iCagenda
 * @subpackage  utilities
 * @copyright   Copyright (c)2014-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     3.5.13 2015-11-23
 * @since       3.4.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * class icagendaCategories
 */
class icagendaMenus
{
	/**
	 * Function to return all published 'List of Events' menu items
	 *
	 * @access	public static
	 * @param	none
	 * @return	array of menu item info this way : Itemid-mcatid-lang
	 *
	 * @since	3.4.0
	 */
	static public function iClistMenuItemsInfo()
	{
		$app			= JFactory::getApplication();
//		$params			= $app->getParams();

		$options_time	= JComponentHelper::getParams('com_icagenda')->get('time', '0');

		// List all menu items linking to list of events
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('m.title, m.published, m.id, m.params, m.language')
			->from('`#__menu` AS m')
			->where( "(m.link = 'index.php?option=com_icagenda&view=list') AND (m.published = 1)" );

		if (JLanguageMultilang::isEnabled())
		{
			$query->where('m.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
		}

		$db->setQuery($query);
		$link = $db->loadObjectList();

		$iC_list_menus = array();

		foreach ($link as $iClistMenu)
		{
			$menuitemid	= $iClistMenu->id;

			if ($menuitemid)
			{
				$menu		= $app->getMenu();
				$menuparams	= $menu->getParams($menuitemid);

				$mcatid		= $menuparams->get('mcatid', '');
				$menufilter	= $menuparams->get('time') ? $menuparams->get('time') : $options_time;

				if (is_array($mcatid))
				{
					$mcatid	= implode(',', $mcatid);
				}

				array_push($iC_list_menus, $menuitemid . '_' . $mcatid . '_' . $menufilter);
			}
		}

		return $iC_list_menus;
	}

	/**
	 * Function to return all published 'List of Events' menu items
	 *
	 * @access	public static
	 * @param	none
	 * @return	array of menu item info this way : Itemid-mcatid-lang
	 *
	 * @since	3.4.0
	 */
	static public function iClistMenuItems()
	{
		$app = JFactory::getApplication();

		// List all menu items linking to list of events
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('m.title, m.published, m.id, m.params, m.language')
			->from('`#__menu` AS m')
			->where( "(m.link = 'index.php?option=com_icagenda&view=list') AND (m.published = 1)" );

		if (JLanguageMultilang::isEnabled())
		{
			$query->where('m.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
		}

		$query->order('m.id ASC');

		$db->setQuery($query);
		$iC_list_menu_items = $db->loadObjectList();

		if ($iC_list_menu_items)
		{
			return $iC_list_menu_items;
		}
		else
		{
			return array();
		}
	}

	/**
	 * Function to return menu Itemid to display an event
	 *
	 * @access	public static
	 * @return	menu Itemid
	 *
	 * @since	3.5.7
	 */
	static public function thisEventItemid($date, $category, $array_menuitems = null)
	{
		$iC_list_menus = $array_menuitems ? $array_menuitems : self::iClistMenuItemsInfo();

		$datetime_today	= JHtml::date('now', 'Y-m-d H:i');
		$date_today		= JHtml::date('now', 'Y-m-d');

		// set menu link for each event (itemID) depending of category and/or language
		$onecat		= $multicat		= '0';
		$link_one	= $link_multi	= '';

		$menu_IDs_category	= array();
		$menu_IDs_all		= array();
		$itemID_is_set		= 0;

		foreach ($iC_list_menus AS $iCm)
		{
			$value			= explode('_', $iCm);
			$iCmenu_id		= $value['0'];
			$iCmenu_mcatid	= $value['1'];
			$iCmenu_filter	= $value['2'];

			$iCmenu_mcatid_array = ! is_array($iCmenu_mcatid) ? explode(',', $iCmenu_mcatid) : array();

			// Menu can display past events
			if ($iCmenu_filter == 2
				&& strtotime($date) < strtotime($datetime_today)
				&& ! $itemID_is_set)
			{
				// If menu category filter is set, and item category is in filtered categories
				if (in_array($category, $iCmenu_mcatid_array))
				{
					$menu_IDs_category[] = $iCmenu_id;
					$itemID_is_set = $itemID_is_set + 1;
				}
				elseif ( ! $iCmenu_mcatid)
				{
					$menu_IDs_all[] = $iCmenu_id;
				}
			}

			// Menu can display today's events
			elseif ($iCmenu_filter == 4
				&& strtotime($date) > strtotime($date_today)
				&& strtotime($date) < strtotime("+1 DAY", strtotime($date_today))
				&& ! $itemID_is_set)
			{
				// If menu category filter is set, and item category is in filtered categories
				if (in_array($category, $iCmenu_mcatid_array))
				{
					$menu_IDs_category[] = $iCmenu_id;
					$itemID_is_set = $itemID_is_set + 1;
				}
				elseif ( ! $iCmenu_mcatid)
				{
					$menu_IDs_all[] = $iCmenu_id;
				}
			}

			// Menu can display today's events and upcoming events
			elseif ($iCmenu_filter == 1
				&& strtotime($date) >= strtotime($date_today)
				&& ! $itemID_is_set)
			{
				// If menu category filter is set, and item category is in filtered categories
				if (in_array($category, $iCmenu_mcatid_array))
				{
					$menu_IDs_category[] = $iCmenu_id;
					$itemID_is_set = $itemID_is_set + 1;
				}
				elseif ( ! $iCmenu_mcatid)
				{
					$menu_IDs_all[] = $iCmenu_id;
				}
			}

			// Menu can display upcoming events
			elseif ($iCmenu_filter == 3
				&& strtotime($date) > strtotime($datetime_today)
				&& ! $itemID_is_set)
			{
				// If menu category filter is set, and item category is in filtered categories
				if (in_array($category, $iCmenu_mcatid_array))
				{
					$menu_IDs_category[] = $iCmenu_id;
					$itemID_is_set = $itemID_is_set + 1;
				}
				elseif ( ! $iCmenu_mcatid)
				{
					$menu_IDs_all[] = $iCmenu_id;
				}
			}

			// Menu can display all events
			elseif ($iCmenu_filter == '0'
				&&  ! $itemID_is_set)
			{
				// If menu category filter is set, and item category is in filtered categories
				if (in_array($category, $iCmenu_mcatid_array))
				{
					$menu_IDs_category[] = $iCmenu_id;
					$itemID_is_set = $itemID_is_set + 1;
				}
				elseif ( ! $iCmenu_mcatid)
				{
					$menu_IDs_all[] = $iCmenu_id;
				}
			}

			if ($iCmenu_mcatid)
			{
				$nb_cat_filter = count($iCmenu_mcatid_array);

				for ($i = $category; in_array($i, $iCmenu_mcatid_array); $i++)
				{
					if ($nb_cat_filter == 1)
					{
						$link_one = $iCmenu_id;
					}
					elseif ($nb_cat_filter > 1)
					{
						$link_multi = $iCmenu_id;
					}
				}
			}
		}

		if (count($menu_IDs_category))
		{
			if ($link_one)
			{
				$linkid = $link_one;
			}
			elseif ($link_multi)
			{
				$linkid = $link_multi;
			}
			else
			{
				$linkid = $menu_IDs_category[0];
			}
		}
		elseif (count($menu_IDs_all))
		{
			$linkid = $menu_IDs_all[0];
		}
		else
		{
//			$linkid = '#';
			$linkid = null;
		}

		return $linkid;
	}
}
