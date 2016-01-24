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
 * @version     1.2.2 2015-03-06
 * @since       1.1.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * class iCDate
 */
class iCDatePeriod
{
	/**
	 * Function to return all dates of a period (from ... to ...)
	 *
	 * @access	public static
	 * @param	$startdate : start datetime of the period (0000-00-00 00:00:00)
	 * 			$enddate : end datetime of the period (0000-00-00 00:00:00)
	 * 			$timezone : Time zone to be used for the date.
	 *						Special cases: boolean true for user setting, boolean false for server setting.
	 *						Default: null, no timezone.
	 * @return	array of all dates of the period
	 *
	 * @since	1.1.0
	 */
	static public function listDates($startdate, $enddate, $timezone = null)
	{
		$test_startdate	= iCDate::isDate($startdate);
		$test_enddate	= iCDate::isDate($enddate);

		$out = array();

		if ($test_startdate && $test_enddate)
		{
			$timestartdate	= date('H:i', strtotime($startdate));
			$timeenddate	= date('H:i', strtotime($enddate));

			if (class_exists('DateInterval'))
			{
				// Create array with all dates of the period - PHP 5.3+
				$start = new DateTime($startdate);

				$interval = '+1 days';
				$date_interval = DateInterval::createFromDateString($interval);

				if ($timeenddate <= $timestartdate)
				{
					$end = new DateTime("$enddate +1 days");
				}
				else
				{
					$end = new DateTime($enddate);
				}

				// Return all dates.
				$perioddates = new DatePeriod($start, $date_interval, $end);

				foreach($perioddates as $date)
				{
					$out[] = (
						$date->format('Y-m-d H:i')
					);
				}
			}
			else
			{
				// TO BE REMOVED : when Joomla 2.5 and php 5.2 support will end
				// Create array with all dates of the period - PHP 5.2
				$nodate = '0000-00-00 00:00:00';

				if (($startdate != $nodate) && ($enddate != $nodate))
				{
					$start = new DateTime($startdate);

					if ($timeenddate <= $timestartdate)
					{
						$end = new DateTime("$enddate +1 days");
					}
					else
					{
						$end = new DateTime($enddate);
					}

					while($start < $end)
					{
						$out[] = $start->format('Y-m-d H:i');
						$start->modify('+1 day');
					}
				}
			}

			return $out;
		}
		else
		{
			return array();
		}
	}

	/**
	 * Return weekdays data to array of days of the week selected
	 *
	 * @access	public static
	 * @param	$weekdays : weekdays saved in database (x,x,x)
	 * @return	array of all weekdays of the period
	 *
	 * @since	1.2.0
	 */
	static public function weekdaysToArray($i_weekdays)
	{
		$allWeekDays	= array(0,1,2,3,4,5,6);

		$weekdays		= isset($i_weekdays) ? $i_weekdays : array();
		$weekdays		= explode (',', $weekdays);

		$weekdaysarray	= array();

		foreach ($weekdays as $day)
		{
			array_push($weekdaysarray, $day);
		}

		if (in_array('', $weekdaysarray)) // Joomla 2.5 multiple select
		{
			$arrayWeekDays = $allWeekDays;
		}
		elseif ($i_weekdays)
		{
			$arrayWeekDays = $weekdaysarray;
		}
		elseif (in_array('0', $weekdaysarray)) // Sunday only selected
		{
			$arrayWeekDays = $weekdaysarray;
		}
		else
		{
			$arrayWeekDays = $allWeekDays;
		}

		return $arrayWeekDays;
	}
}
