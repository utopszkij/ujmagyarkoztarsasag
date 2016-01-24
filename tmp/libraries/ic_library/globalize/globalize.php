<?php
/**
 *------------------------------------------------------------------------------
 *  iC Library - Library by Jooml!C, for Joomla!
 *------------------------------------------------------------------------------
 * @package     iC Library
 * @subpackage  Globalize
 * @copyright   Copyright (c)2014-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     1.3.3 2015-09-05
 * @since       1.3.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * class iCGlobalize
 */
class iCGlobalize
{
	/**
	 * Function to get Format Date (using option format, and translation)
	 *
	 * @access	public static
	 * @param	$date : date to be formatted (1993-04-30 14:33:00)
	 * 			$option : date format selected
	 * @return	formatted date
	 *
	 * @since   1.3.0
	 */
	static public function dateFormat($date, $option, $separator, $tz = false)
	{
		$eventTimeZone	= $tz ? $tz : null;

		$lang			= JFactory::getLanguage();
		$langTag		= $lang->getTag();
		$langName		= $lang->getName();

		if ( ! file_exists(JPATH_LIBRARIES . '/ic_library/globalize/culture/' . $langTag . '.php'))
		{
			$langTag = 'en-GB';
		}

		$globalize		= JPATH_LIBRARIES . '/ic_library/globalize/culture/' . $langTag . '.php';
		$iso			= JPATH_LIBRARIES . '/ic_library/globalize/culture/iso.php';

		// Languages with English ordinal suffix for the day of the month, 2 characters
		$en_langs = array('en-GB', 'en-US');

		// Set iso format if format is equal to zero (Y-m-d)
		$option = ($option == '0') ? 'Y - m - d' : $option;

		if (is_numeric($option))
		{
			require $globalize;

			// Format with "th" only for english languages
			if ( ! in_array($langTag, $en_langs))
			{
				if ($option == '5') $option = '4';
				if ($option == '9') $option = '7';
				if ($option == '10') $option = '8';
			}

			// No Short month for Persian language
			elseif ($langTag == 'fa-IR')
			{
				if ($option == '3') $option = '2';
				if ($option == '11') $option = '7';
				if ($option == '12') $option = '8';
			}

			$format = ${"datevalue_" . $option};
		}
		else
		{
			require $iso;

			$format = $option;
		}

		// Load Globalization Date Format if selected

		// Explode components of the date
		$exformat = explode (' ', $format);

		// Settings datetime, month and day
		$thisDate	= date('Y-m-d H:i:s', strtotime($date));
		$month_n	= JHtml::date($thisDate, 'n', $eventTimeZone); // 1 through 12
		$day_w		= JHtml::date($thisDate, 'w', $eventTimeZone); // 0 (for Sunday) through 6 (for Saturday)

		// Strings of translation for convertion
		$array_days	= array(
			'SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'
		);

		$array_days_short = array(
			'SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'
		);

		$array_months = array(
			'JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE',
			'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER'
		);

		$dateFormatted	= '';

		// Creates date formatted
		foreach ($exformat as $k => $val)
		{
			switch($val)
			{
				// Day
				case 'd':
					$val = JHtml::date($thisDate, 'd', $eventTimeZone);
					break;

				case 'j':
					$val = JHtml::date($thisDate, 'j', $eventTimeZone);
					break;

				case 'D':
					// A textual representation of day of the week, three letters (use Joomla Translation string)
					$val = JText::_($array_days_short[$day_w]);
					break;

				case 'l':
					// A full textual representation of the day of the week (use Joomla Translation string)
					$val = JText::_($array_days[$day_w]);
					break;

				case 'S':
					$val = '<sup>' . JHtml::date($thisDate, 'S', $eventTimeZone) . '</sup>';
					break;

				case 'jS':
					$val = JHtml::date($thisDate, 'j', $eventTimeZone) . '<sup>' . JHtml::date($thisDate, 'S', $eventTimeZone) . '</sup>';
					break;

				// Month
				case 'm':
					$val = JHtml::date($thisDate, 'm', $eventTimeZone);
					break;

				case 'F':
					// A full textual representation of a month (use Joomla Translation string)
					$val = JText::_($array_months[($month_n-1)]);
					break;

				case 'M':
					// A short textual representation of a month (use Joomla Translation string)
					$val = JText::_($array_months[($month_n-1)] . '_SHORT');
					break;

				case 'n':
					$val = JHtml::date($thisDate, 'n', $eventTimeZone);
					break;

				// year (v3)
				case 'Y':
					$val = JHtml::date($thisDate, 'Y', $eventTimeZone);
					break;

				case 'y':
					$val = JHtml::date($thisDate, 'y', $eventTimeZone);
					break;

				// Separator of the components
				case '*':
					$val = $separator;
					break;
				case '_':
					$val = '&nbsp;';
//					$val = '&#160;';
					break;

				// day
				case 'N':
					$val = strftime("%u", strtotime("$thisDate"));
					break;
				case 'w':
					$val = strftime("%w", strtotime("$thisDate"));
					break;
				case 'z':
					$val = strftime("%j", strtotime("$thisDate"));
					break;

				// week
				case 'W':
					$val = JHtml::date($thisDate, 'W', $eventTimeZone);
					break;

				// Default
				default:
					$val;
					break;
			}

			$dateFormatted.= ($k !== 0) ? '' . $val : $val;
		}

		return $dateFormatted;
	}
}
