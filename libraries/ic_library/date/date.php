<?php
/**
 *------------------------------------------------------------------------------
 *  iC Library - Library by Jooml!C, for Joomla!
 *------------------------------------------------------------------------------
 * @package     iC Library
 * @subpackage  date
 * @copyright   Copyright (c)2014-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     1.2.4 2015-05-06
 * @since       1.0.3
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * class iCDate
 */
class iCDate
{
	/**
	 * Function to test if date is a valid Datetime
	 *
	 * @access	public static
	 * @param	$date : date to be tested (1993-04-30 14:33:00)
	 * @return	alias
	 *
	 * @since   1.1.0
	 */
	static public function isDate($date)
	{
		$stamp = strtotime($date);

		$date_numeric = iCDate::dateToNumeric($date);

		$date_valid = str_replace('0', '', $date_numeric);

		if ( ! is_numeric($stamp)
			|| ! $date_valid)
		{
			return false;
		}

		return true;
	}

	/**
	 * Function to convert datetime to numeric
	 *
	 * @access	public static
	 * @param	$date: date to convert (1993-04-30 14:33:00 -> 19930430143300)
	 * @return	alias
	 *
	 * @since   1.1.0
	 */
	static public function dateToNumeric($date)
	{
		$date = preg_replace("/[^0-9]/","", $date);

		return $date;
	}

	/**
	 * Function to convert datetime to alias
	 *
	 * @access	public static
	 * @param	$date: date to convert (1993-04-30 14:33:00 -> 1993-04-30-14-33-00)
	 * 			$format: format of the date before convertion (eg. Y-m-d if only date)
	 * 			default format: use parent format
	 * @return	alias
	 *
	 * @since   1.0.3
	 */
	static public function dateToAlias($date, $format = null)
	{
		if ($format)
		{
			$date = date($format, strtotime($date));
		}

		if (self::isDate($date))
		{
			$replace = array(' ', ':');
			$date = str_replace($replace, '-', $date);

			return $date;
		}

		return false;
	}

	/**
	 * Format Month Short Core - From Joomla language file xx-XX.ini (eg. Apr)
	 *
	 * @access	public static
	 * @param	$date: date to convert (1993-04-30 14:33:00 -> Apr)
	 * @return	translation string for MONTH_SHORT
	 *
	 * @since   1.2.0
	 */
	static public function monthShortJoomla($date)
	{
		$month				= date('F', strtotime($date));
		$monthShortJoomla	= JText::_($month . '_SHORT');

		return $monthShortJoomla;
	}
}
