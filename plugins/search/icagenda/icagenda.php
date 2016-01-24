<?php
/**
 *	Plugin Search - iCagenda :: Search
 *----------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril Rezé, Jooml!C - All rights reserved

 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @update      3.5.13 2015-11-21
 * @version		1.5
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *----------------------------------------------------------------------------
*/


// No direct access to this file
defined('_JEXEC') or die( 'Restricted access' );

// Require the component's router file
require_once JPATH_SITE .  '/components/com_icagenda/router.php';

/**
 * All functions need to get wrapped in class PlgSearchiCagenda
 */
class PlgSearchiCagenda extends JPlugin
{
	/**
	 * Constructor
	 *
	 * @access      protected
	 * @param       object  $subject The object to observe
	 * @param       array   $config  An array that holds the plugin configuration
	 * @since       1.0
	 */
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	// Define a function to return an array of search areas.
	// Note the value of the array key is normally a language string
	function onContentSearchAreas()
	{
		$search_name = $this->params->get('search_name', JText::_('ICAGENDA_PLG_SEARCH_SECTION_EVENTS') );
		if ($search_name == 'ICAGENDA_PLG_SEARCH_SECTION_EVENTS') $search_name = 'Events';

		return array('icagenda' => $search_name);
	}

	// The real function has to be created. The database connection should be made.
	// The function will be closed with an } at the end of the file.
	/**
	 * The sql must return the following fields that are used in a common display
	 * routine: href, title, section, created, text, browsernav
	 *
	 * @param string Target search string
	 * @param string mathcing option, exact|any|all
	 * @param string ordering option, newest|oldest|popular|alpha|category
	 * @param mixed An array if the search it to be restricted to areas, null if search all
	 */
	function onContentSearch( $text, $phrase='', $ordering='', $areas=null )
	{
		$db		= JFactory::getDBO();
		$app	= JFactory::getApplication();
		$tag	= JFactory::getLanguage()->getTag();
		$user	= JFactory::getUser();
		$groups	= implode(',', $user->getAuthorisedViewLevels());

		// If the array is not correct, return it:
		if (is_array( $areas ))
		{
			if (!array_intersect( $areas, array_keys( $this->onContentSearchAreas() ) ))
			{
				return array();
			}
		}

		// Now retrieve the plugin parameters
		$search_name	= $this->params->get('search_name', JText::_('ICAGENDA_PLG_SEARCH_SECTION_EVENTS') );
		if ($search_name == 'ICAGENDA_PLG_SEARCH_SECTION_EVENTS') $search_name = 'Events';
		$search_limit	= $this->params->get('search_limit', '50' );
		$search_target	= $this->params->get('search_target', '0' );

		// Use the PHP function trim to delete spaces in front of or at the back of the searching terms
		$text = trim( $text );

		// Return Array when nothing was filled in.
		if ($text == '')
		{
			return array();
		}

		// Database part.
		$wheres = array();

		switch ($phrase)
		{
			// Search exact
			case 'exact':
				$text           = $db->Quote( '%'.$db->escape( $text, true ).'%', false );
				$wheres2        = array();
				$wheres2[]      = 'LOWER(e.title) LIKE '.$text;
				$wheres2[]      = 'LOWER(e.shortdesc) LIKE '.$text;
				$wheres2[]      = 'LOWER(e.desc) LIKE '.$text;
				$wheres2[]      = 'LOWER(e.metadesc) LIKE '.$text;
				$wheres2[]      = 'LOWER(e.place) LIKE '.$text;
				$wheres2[]      = 'LOWER(e.city) LIKE '.$text;
				$wheres2[]      = 'LOWER(e.country) LIKE '.$text;
				$wheres2[]      = 'LOWER(e.address) LIKE '.$text;
				$wheres2[]      = 'LOWER(c.title) LIKE '.$text;
				$where          = '(' . implode( ') OR (', $wheres2 ) . ')';
				break;

			// Search all or any
			case 'all':
			case 'any':

			// Set default
			default:
				$words  = explode( ' ', $text );
				$wheres = array();

				foreach ($words as $word)
				{
					$word           = $db->Quote( '%'.$db->escape( $word, true ).'%', false );
					$wheres2        = array();
					$wheres2[]      = 'LOWER(e.title) LIKE '.$word;
					$wheres2[]      = 'LOWER(e.shortdesc) LIKE '.$word;
					$wheres2[]      = 'LOWER(e.desc) LIKE '.$word;
					$wheres2[]      = 'LOWER(e.metadesc) LIKE '.$word;
					$wheres2[]      = 'LOWER(e.place) LIKE '.$word;
					$wheres2[]      = 'LOWER(e.city) LIKE '.$word;
					$wheres2[]      = 'LOWER(e.country) LIKE '.$word;
					$wheres2[]      = 'LOWER(e.address) LIKE '.$word;
					$wheres2[]      = 'LOWER(c.title) LIKE '.$word;
					$wheres[]       = implode( ' OR ', $wheres2 );
				}

				$where = '(' . implode( ($phrase == 'all' ? ') AND (' : ') OR ('), $wheres ) . ')';
				break;
		}

		// Ordering of the results
		switch ( $ordering )
		{
			//Alphabetic, ascending
			case 'alpha':
				$order = 'e.title ASC';
				break;

			// Oldest first
			case 'oldest':
				$order = 'e.next ASC';
				break;

			// Popular first
			case 'popular':

			// Newest first
			case 'newest':
				$order = 'e.next DESC';
				break;

			// Category
			case 'category':
				$order = 'c.title ASC';
				break;

			// Default setting: alphabetic, ascending
			default:
				$order = 'e.title ASC';
		}

		// Section
		$section = $search_name;

		// List of Events menu Itemid Request
		$iC_list_menus = self::iClistMenuItemsInfo();
		$nb_menu = count($iC_list_menus);
		$nolink = $nb_menu ? false : true;

		// Get User groups allowed to approve event submitted
		$userID = $user->id;
		$userLevels = $user->getAuthorisedViewLevels();
		$userGroups = $user->getAuthorisedGroups();

		$groupid = JComponentHelper::getParams('com_icagenda')->get('approvalGroups', array("8"));

		jimport( 'joomla.access.access' );
		$adminUsersArray = array();

		foreach ($groupid AS $gp)
		{
			$adminUsers = JAccess::getUsersByGroup($gp, false);
			$adminUsersArray = array_merge($adminUsersArray, $adminUsers);
		}

		// The database query;
		$query  = $db->getQuery(true);
		$query->select('e.title AS title, e.created AS created, e.next AS next, e.displaytime AS displaytime, e.desc AS text, e.id AS eventID, e.alias AS alias, c.id AS catid, e.language AS language');
		$query->select($query->concatenate(array($db->Quote($section), 'c.title'), " / ").' AS section');
		$query->select('"'.$search_target.'" AS browsernav');
		$query->from('#__icagenda_events AS e');
		$query->innerJoin('#__icagenda_category as c ON c.id = e.catid');
		$query->where('c.state = 1');

		// START Hack for Upcoming Filtering
//		$datetime_today	= JHtml::date('now', 'Y-m-d H:i'); // Joomla Time Zone

//		$query->where('e.next >= ' . $db->q($datetime_today));
		// END Hack for Upcoming Filtering

		$query->where('('. $where .')' . 'AND e.state = 1 AND e.access IN ('. $groups .') ');


		// if user logged-in has no Approval Rights, not approved events won't be displayed.
		if (!in_array($userID, $adminUsersArray)
			AND !in_array('8', $userGroups))
		{
			$query->where(' e.approval <> 1 ');
		}

		// Filter by language.
		if ($app->isSite() && JLanguageMultilang::isEnabled())
		{
			$query->where('e.language in (' . $db->quote($tag) . ',' . $db->quote('*') . ')');
		}

		$query->order($order);

		// Set query
		$db->setQuery( $query, 0, $search_limit );
		$iCevents = $db->loadObjectList();
//		$limit -= count($list);

		// The 'output' of the displayed link.
		if (isset($iCevents))
		{
			foreach($iCevents as $key => $iCevent)
			{
				// set menu link for each event (itemID) depending of category and/or language
				$onecat = $multicat = '0';
				$link_one = $link_multi = '';

				$item_catid = $iCevent->catid;

				$array_menus_cat_not_set = array();

				foreach ($iC_list_menus AS $iCm)
				{
					$value = explode('-', $iCm);
					$iCmenu_id = $value['0'];
					$iCmenu_mcatid = $value['1'];
					$iCmenu_lang = $value['2'];

					$iCmenu_mcatid_array = !is_array ($iCmenu_mcatid) ? explode(',', $iCmenu_mcatid) : '';


					if ($iCmenu_mcatid
						&& $iCmenu_lang == $iCevent->language)
					{
						$nb_cat_filter = count($iCmenu_mcatid_array);

						for ($i = $iCevent->catid; in_array($i, $iCmenu_mcatid_array); $i++)
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
					else
					{
						array_push($array_menus_cat_not_set, $iCmenu_id);
					}
				}

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
					$linkid = count($array_menus_cat_not_set) ? $array_menus_cat_not_set['0'] : null;
				}

				$event_slug = empty($iCevent->alias) ? $iCevent->eventID : $iCevent->eventID . ':' . $iCevent->alias;

				$date_next = JHtml::date($iCevent->next, JText::_( 'DATE_FORMAT_LC3' ), null);
				$time_next = JHtml::date($iCevent->next, 'H:i', null);

				$display_time = $iCevent->displaytime ? ' ' . $time_next : '';

				$iCevents[$key]->title = $iCevent->title . ' (' . $date_next . $display_time . ')';

				$iCevents[$key]->href = 'index.php?option=com_icagenda&view=list&layout=event&id='
										. $event_slug . '&Itemid=' . $linkid;
			}
		}

		// If menu item iCagenda list of events exists, returns events found.
		if ($nolink)
		{
			// Displays a warning that no menu item to the list of events is published.
			$app->enqueueMessage(JText::_( 'ICAGENDA_PLG_SEARCH_ALERT_NO_ICAGENDA_MENUITEM' ), 'warning');
		}
		else
		{
			//Return the search results in an array
			return $iCevents;
		}
	}


	/**
	 * Function to return all published 'List of Events' menu items
	 *
	 * @access	public static
	 * @param	none
	 * @return	array of menu item info this way : Itemid-mcatid-lang
	 *
	 * @since	1.2
	 */
	static public function iClistMenuItemsInfo()
	{
		$app = JFactory::getApplication();

		// List all menu items linking to list of events
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('m.title, m.published, m.id, m.params, m.language')
			->from('`#__menu` AS m')
			->where( "(link = 'index.php?option=com_icagenda&view=list') AND (published = 1)" );
		$db->setQuery($query);
		$link = $db->loadObjectList();

		$iC_list_menus = array();

		foreach ($link as $iClistMenu)
		{
			$menuitemid	= $iClistMenu->id;
			$menulang	= $iClistMenu->language;

			if ($menuitemid)
			{
				$menu = $app->getMenu();
				$menuparams = $menu->getParams( $menuitemid );
			}

			$mcatid = $menuparams->get('mcatid');

			if (is_array($mcatid))
			{
				$mcatid = implode(',', $mcatid);
			}

			array_push($iC_list_menus, $menuitemid . '-' . $mcatid . '-' . $menulang);
		}

		return $iC_list_menus;
	}
}
