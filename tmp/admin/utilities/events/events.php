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
 * @version     3.5.13 2015-11-21
 * @since       3.4.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * class icagendaEvents
 */
class icagendaEvents
{
	/**
	 * Function to return event access (access levels, approval and event access status)
	 *
	 * @access	public static
	 * @param	$id - id of the event
	 * @return	list array of access levels, approval and event access status
	 *
	 * @since	3.4.0
	 */
	static public function eventAccess($id = null)
	{
		// Preparing connection to db
		$db = Jfactory::getDbo();

		// Preparing the query
		$query = $db->getQuery(true);
		$query->select('e.state AS evtState, e.approval AS evtApproval, e.access AS evtAccess')
			->from($db->qn('#__icagenda_events').' AS e')
			->where($db->qn('e.id').' = '.$db->q($id));
		$query->select('v.title AS accessName')
			->join('LEFT', $db->quoteName('#__viewlevels') . ' AS v ON v.id = e.access');
		$db->setQuery($query);
		$eventAccess = $db->loadObject();

		if ($eventAccess)
		{
			return $eventAccess;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Function to return feature Icons for an event
	 *
	 * @access	public static
	 * @param	$id - id of the event
	 * @return	list array of feature icons
	 *
	 * @since	3.4.0
	 */
	public static function featureIcons($id = null)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('DISTINCT f.icon, f.icon_alt');
		$query->from('`#__icagenda_feature_xref` AS fx');
		$query->innerJoin("`#__icagenda_feature` AS f ON fx.feature_id=f.id AND f.state=1 AND f.icon<>'-1'");
		$query->where('fx.event_id=' . $id);
		$query->order('f.ordering DESC'); // Order descending because the icons are floated right
		$db->setQuery($query);
		$feature_icons = $db->loadObjectList();

		return $feature_icons;
	}

	/**
	 * Function to return footer list of events
	 *
	 * @since	3.4.0
	 */
	public static function isListOfEvents()
	{
		$app = JFactory::getApplication();
		$params = $app->getParams();
		$list_of_events = $params->get('copy', '');
		$core = $params->get('icsys');
		$string = '<a href="ht';
		$string.= 'tp://icag';
		$string.= 'enda.jooml';
		$string.= 'ic.com" target="_blank" style="font-weight: bold; text-decoration: none !important;">';
		$string.= 'iCagenda';
		$string.= '</a>';
		$icagenda = JText::sprintf('ICAGENDA_THANK_YOU_NOT_TO_REMOVE', $string);
		$default = '&#80;&#111;&#119;&#101;&#114;&#101;&#100;&nbsp;&#98;&#121;&nbsp;';
		$footer = '<div style="text-align: center; font-size: 10px; text-decoration: none"><p>';
		$footer.= preg_match('/iCagenda/',$icagenda) ? $icagenda : $default . $string;
		$footer.= '</p></div>';

		if ($list_of_events || $core == 'core')
		{
			echo $footer;
		}
	}

	/**
	 * DAY in Date Box (list of events)
	 *
	 * @since 3.5.0
	 */
	public static function day($date, $item = null)
	{
		$eventTimeZone	= null;

		$this_date		= JHtml::date($date, 'Y-m-d H:i', $eventTimeZone);
		$day_date		= JHtml::date($date, 'd', $eventTimeZone);
		$day_today		= JHtml::date('now', 'd');
		$date_today		= JHtml::date('now', 'Y-m-d');

		if ($item)
		{
			$weekdays		= $item->weekdays;
			$period			= unserialize($item->period);
			$period			= is_array($period) ? $period : array();
			$is_in_period	= (in_array($this_date, $period)) ? true : false;
			$startdate		= $item->startdatetime;
			$day_startdate	= JHtml::date($startdate, 'd', $eventTimeZone);
			$enddate		= $item->enddatetime;
			$day_enddate	= JHtml::date($enddate, 'd', $eventTimeZone);
		}

		if ($item && $is_in_period
			&& $weekdays == ''
			&& strtotime($startdate) <= strtotime($date_today)
			&& strtotime($enddate) >= strtotime($date_today)
			)
		{
			$day = '';

			if ($day_today > $day_startdate)
			{
//				$day.= '<span style="font-size: 14px; vertical-align: middle">' . $day_startdate . '&nbsp;</span>';
//				$day.= '<span style="font-size: 16px; vertical-align: middle">&#8676;</span>';
			}
			else
			{
//				$day.= '<span style="font-size: 14px; vertical-align: middle; color: transparent; text-shadow: none; text-decoration: none;">' . $day_startdate . '&nbsp;</span>';
//				$day.= '<span style="font-size: 16px; vertical-align: middle; color: transparent; text-shadow: none; text-decoration: none;">&#8676;</span>';
			}

//			$day.= '<span style="border-radius: 10px; padding: 0 5px; border: 2px dotted gray;">' . $day_today . '</span>';
			$day.= '<span class="ic-current-period">' . $day_today . '</span>';
//			$day.= $day_today;

			if ($day_today < $day_enddate)
			{
//				$day.= '<span style="font-size: 16px; vertical-align: middle">&#8677;</span>';
//				$day.= '<span style="font-size: 14px; vertical-align: middle">&nbsp;' . $day_enddate . '</span>';
			}
			else
			{
//				$day.= '<span style="font-size: 16px; vertical-align: middle; color: transparent; text-shadow: none; text-decoration: none;">&#8677;</span>';
//				$day.= '<span style="font-size: 14px; vertical-align: middle; color: transparent; text-shadow: none; text-decoration: none;">' . $day_enddate . '&nbsp;</span>';
			}

			return $day;
		}
		else
		{
			return $day_date;
		}
	}

	/**
	 * MONTH SHORT in Date Box (list of events)
	 *
	 * @since 3.5.0
	 */
	public static function dateBox($date, $type, $ongoing = null)
	{
		$datetime_today		= JHtml::date('now', 'Y-m-d H:i');

		$monthshort_date	= iCDate::monthShortJoomla($date);
		$monthshort_today	= iCDate::monthShortJoomla($datetime_today);
		$year_date			= JHtml::date($date, 'Y', null);
//		$year_date			= date('Y', strtotime($date));
		$year_today			= JHtml::date('now', 'Y');

		if ($ongoing)
		{
			switch($type)
			{
				case 'monthshort': $value = $monthshort_today; break;
				case 'year': $value = $year_today; break;
			}
		}
		else
		{
			switch($type)
			{
				case 'monthshort': $value = $monthshort_date; break;
				case 'year': $value = $year_date; break;
			}
		}

		return $value;
	}

// DEPRECATED 3.6
	/**
	 * Function to return time formated depending on AM/PM option
	 * Format Time (eg. 00:00 (AM/PM))
	 * $oldtime to be removed (not used since 2.0.0)
	 *
	 * @since 3.4.1
	 */
	public static function dateToTimeFormat($evt, $oldtime = null)
	{
		$app			= JFactory::getApplication();
		$params			= $app->getParams();
		$timeformat		= $params->get('timeformat', 1);
		$eventTimeZone	= null;

		$date_time		= strtotime(JHtml::date($evt, 'Y-m-d H:i', $eventTimeZone));
 		$t_time			= date('H:i', $date_time);

		$time_format	= ($timeformat == 1) ? '%H:%M' : '%I:%M %p';
		$lang_time		= strftime($time_format, strtotime($t_time));

		$time = ($oldtime != NULL && $t_time == '00:00') ? $oldtime : JText::_($lang_time);

		return $time;
	}

	/**
	 * Function to return Auto Short Description (Full Description > Short)
	 *
	 * @since 3.5.6
	 */
	public static function shortDescription($text, $isModule = null, $option = null, $limit = null)
	{
		$descdata		= $text;
		$desc_full		= self::deleteAllBetween('{', '}', $descdata);

		// Menu Options
		$app			= JFactory::getApplication();
		$params			= $app->getParams();

//		$limitGlobal	= ! $isModule ? $params->get('limitGlobal', 0) : 1;
//		$customlimit	= ! $isModule ? $params->get('limit', '100') : false;
		$limitGlobal	= ! $isModule ? $params->get('limitGlobal', 0) : 0;
		$customlimit	= ! $isModule ? $params->get('limit', '100') : $limit;

		// Global Options Component iCagenda
		$iCparams		= JComponentHelper::getParams('com_icagenda');

		if ($limitGlobal == 1)
		{
			$limit = $params->get('ShortDescLimit', '100');
		}
		else
		{
			$limit_global_option = $iCparams->get('ShortDescLimit', '100');
			$limit = is_numeric($customlimit) ? $customlimit : $limit_global_option;
		}

		// Html tags removal Global Option (component iCagenda) - Short Description
		$Filtering_ShortDesc_Global	= $iCparams->get('Filtering_ShortDesc_Global', '');
		$HTMLTags_ShortDesc_Global	= $iCparams->get('HTMLTags_ShortDesc_Global', array());

		// Get Module Option
		$Filtering_ShortDesc_Module	= $isModule ? $option : '';

		/**
		 * START Filtering HTML method
		 */
		$limit				= is_numeric($limit) ? $limit : false;

		// Gets length of the short desc, when not filtered
		$limit_not_filtered	= substr($desc_full, 0, $limit);
		$text_length		= strlen($limit_not_filtered);

		// Gets length of the short desc, after html filtering
		$limit_filtered		= preg_replace('/[\p{Z}\s]{2,}/u', ' ', $limit_not_filtered);
		$limit_filtered		= strip_tags($limit_filtered);
		$text_short_length	= strlen($limit_filtered);

		// Sets Limit + special tags authorized
		$limit_short		= $limit + ($text_length - $text_short_length);

		// Replaces all authorized html tags with tag strings
		if (empty($Filtering_ShortDesc_Module)
			&& ($Filtering_ShortDesc_Global == '1') )
		{
			$desc_full = str_replace('+', '@@', $desc_full);
			$desc_full = in_array('1', $HTMLTags_ShortDesc_Global) ? str_replace('<br>', '+@br@', $desc_full) : $desc_full;
			$desc_full = in_array('1', $HTMLTags_ShortDesc_Global) ? str_replace('<br/>', '+@br@', $desc_full) : $desc_full;
			$desc_full = in_array('1', $HTMLTags_ShortDesc_Global) ? str_replace('<br />', '+@br@', $desc_full) : $desc_full;
			$desc_full = in_array('2', $HTMLTags_ShortDesc_Global) ? str_replace('<b>', '+@b@', $desc_full) : $desc_full;
			$desc_full = in_array('2', $HTMLTags_ShortDesc_Global) ? str_replace('</b>', '@bc@', $desc_full) : $desc_full;
			$desc_full = in_array('3', $HTMLTags_ShortDesc_Global) ? str_replace('<strong>', '@strong@', $desc_full) : $desc_full;
			$desc_full = in_array('3', $HTMLTags_ShortDesc_Global) ? str_replace('</strong>', '@strongc@', $desc_full) : $desc_full;
			$desc_full = in_array('4', $HTMLTags_ShortDesc_Global) ? str_replace('<i>', '@i@', $desc_full) : $desc_full;
			$desc_full = in_array('4', $HTMLTags_ShortDesc_Global) ? str_replace('</i>', '@ic@', $desc_full) : $desc_full;
			$desc_full = in_array('5', $HTMLTags_ShortDesc_Global) ? str_replace('<em>', '@em@', $desc_full) : $desc_full;
			$desc_full = in_array('5', $HTMLTags_ShortDesc_Global) ? str_replace('</em>', '@emc@', $desc_full) : $desc_full;
			$desc_full = in_array('6', $HTMLTags_ShortDesc_Global) ? str_replace('<u>', '@u@', $desc_full) : $desc_full;
			$desc_full = in_array('6', $HTMLTags_ShortDesc_Global) ? str_replace('</u>', '@uc@', $desc_full) : $desc_full;
		}
		elseif ( $Filtering_ShortDesc_Module == '2'
			|| (($Filtering_ShortDesc_Global == '') && empty($Filtering_ShortDesc_Module)) )
		{
			$desc_full		= '@i@'.$desc_full.'@ic@';
			$limit_short	= $limit_short + 7;
		}
		else
		{
			$desc_full		= $desc_full;
		}

		// Removes HTML tags
		$desc_nohtml	= strip_tags($desc_full);

		// Replaces all sequences of two or more spaces, tabs, and/or line breaks with a single space
		$desc_nohtml	= preg_replace('/[\p{Z}\s]{2,}/u', ' ', $desc_nohtml);

		// Replaces all spaces with a single +
		$desc_nohtml	= str_replace(' ', '+', $desc_nohtml);

		if (strlen($desc_nohtml) > $limit_short)
		{
			// Cuts full description, to get short description
			$string_cut	= substr($desc_nohtml, 0, $limit_short);

			// Detects last space of the short description
			$last_space	= strrpos($string_cut, '+');

			// Cuts the short description after last space
			$string_ok	= substr($string_cut, 0, $last_space);

			// Counts number of tags converted to string, and returns lenght
			$nb_br			= substr_count($string_ok, '+@br@');
			$nb_plus		= substr_count($string_ok, '@@');
			$nb_bopen		= substr_count($string_ok, '@b@');
			$nb_bclose		= substr_count($string_ok, '@bc@');
			$nb_strongopen	= substr_count($string_ok, '@strong@');
			$nb_strongclose	= substr_count($string_ok, '@strongc@');
			$nb_iopen		= substr_count($string_ok, '@i@');
			$nb_iclose		= substr_count($string_ok, '@ic@');
			$nb_emopen		= substr_count($string_ok, '@em@');
			$nb_emclose		= substr_count($string_ok, '@emc@');
			$nb_uopen		= substr_count($string_ok, '@u@');
			$nb_uclose		= substr_count($string_ok, '@uc@');

			// Replaces tag strings with html tags
			$string_ok	= str_replace('@br@', '<br />', $string_ok);
			$string_ok	= str_replace('@b@', '<b>', $string_ok);
			$string_ok	= str_replace('@bc@', '</b>', $string_ok);
			$string_ok	= str_replace('@strong@', '<strong>', $string_ok);
			$string_ok	= str_replace('@strongc@', '</strong>', $string_ok);
			$string_ok	= str_replace('@i@', '<i>', $string_ok);
			$string_ok	= str_replace('@ic@', '</i>', $string_ok);
			$string_ok	= str_replace('@em@', '<em>', $string_ok);
			$string_ok	= str_replace('@emc@', '</em>', $string_ok);
			$string_ok	= str_replace('@u@', '<u>', $string_ok);
			$string_ok	= str_replace('@uc@', '</u>', $string_ok);
			$string_ok	= str_replace('+', ' ', $string_ok);
			$string_ok	= str_replace('@@', '+', $string_ok);

			$text = $string_ok;

			// Close html tags if not closed
			if ($nb_bclose < $nb_bopen) $text = $string_ok.'</b>';
			if ($nb_strongclose < $nb_strongopen) $text = $string_ok.'</strong>';
			if ($nb_iclose < $nb_iopen) $text = $string_ok.'</i>';
			if ($nb_emclose < $nb_emopen) $text = $string_ok.'</em>';
			if ($nb_uclose < $nb_uopen) $text = $string_ok.'</u>';

			$return_text = $text.' ';

			$descShort	= $limit ? $return_text : '';
		}
		else
		{
			$desc_full	= $desc_nohtml;
			$desc_full	= str_replace('@br@', '<br />', $desc_full);
			$desc_full	= str_replace('@b@', '<b>', $desc_full);
			$desc_full	= str_replace('@bc@', '</b>', $desc_full);
			$desc_full	= str_replace('@strong@', '<strong>', $desc_full);
			$desc_full	= str_replace('@strongc@', '</strong>', $desc_full);
			$desc_full	= str_replace('@i@', '<i>', $desc_full);
			$desc_full	= str_replace('@ic@', '</i>', $desc_full);
			$desc_full	= str_replace('@em@', '<em>', $desc_full);
			$desc_full	= str_replace('@emc@', '</em>', $desc_full);
			$desc_full	= str_replace('@u@', '<u>', $desc_full);
			$desc_full	= str_replace('@uc@', '</u>', $desc_full);
			$desc_full	= str_replace('+', ' ', $desc_full);
			$desc_full	= str_replace('@@', '+', $desc_full);

			$descShort	= $limit ? $desc_full : '';
		}
		/** END Filtering HTML function */

		return $descShort;
	}

	/**
	 * Function to check if user has access rights to defined access
	 *
	 * $accessLevel		Access level of the item to check User Permissions
	 *
	 * If in super user group, always allowed
	 */
	static public function accessLevels($accessLevel)
	{
		// Get User Access Levels
		$user		= JFactory::getUser();
		$userLevels	= $user->getAuthorisedViewLevels();
		$userGroups = $user->getAuthorisedGroups();

		// Control: if access level, or Super User
		if (in_array($accessLevel, $userLevels)
			|| in_array('8', $userGroups))
		{
			return true;
		}

		return false;
	}

	/**
	 * Process a string in a JOOMLA_TRANSLATION_STRING standard.
	 * This method processes a string and replaces all accented UTF-8 characters by unaccented
	 * ASCII-7 "equivalents" and the string is uppercase. Spaces replaced by underscore.
	 *
	 * @param   string  $string  String to process
	 *
	 * @return  string  Processed string
	 *
	 * @since   3.3.3
	 */
	public static function deleteAllBetween($start, $end, $string)
	{
		$startPos = strpos($string, $start);
		$endPos = strpos($string, $end);

		if (!$startPos || !$endPos)
		{
			return $string;
		}

		$textToDelete = substr($string, $startPos, ($endPos + strlen($end)) - $startPos);

		return str_replace($textToDelete, '', $string);
	}
}
