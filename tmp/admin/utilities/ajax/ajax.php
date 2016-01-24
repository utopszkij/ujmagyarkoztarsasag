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
 * @version     3.5.9 2015-07-30
 * @since       3.5.9
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * class icagendaAjax
 */
class icagendaAjax
{
	/**
	 * Function to return options for date select, depending of event
	 *
	 * @since	3.5.9
	 */
	static public function getOptionsEventDates($view = null, $id = null)
	{
		$jinput		= JFactory::getApplication()->input;
		$regid		= $jinput->get('regid', '0');
		$eventid	= $jinput->get('eventid', '0');

		$data	= JFactory::getApplication()->getUserState('com_icagenda.' . $view . '.data', array());
		$date	= isset($data['date']) ? $data['date'] : '';

		$date_format_global	= JComponentHelper::getParams('com_icagenda')->get('date_format_global', 'Y - m - d');
		$separator			= JComponentHelper::getParams('com_icagenda')->get('date_separator', ' ');

		if ($eventid != 0 && $view == 'mail')
		{
			$db		= JFactory::getDbo();
			$query	= $db->getQuery(true);
			$query->select('r.id as reg_id, r.date AS reg_date, r.period AS reg_period, r.eventid AS reg_eventid, sum(r.people) AS reg_count')
				->from('`#__icagenda_registration` AS r');
			$query->select('e.startdate AS startdate, e.enddate AS enddate, e.weekdays AS weekdays')
				->join('LEFT', $db->quoteName('#__icagenda_events') . ' AS e ON e.id = r.eventid');
			$query->where('r.state = 1');
			$query->where('r.email <> ""');
			$query->group('r.date');
			$query->where('r.eventid = ' . (int) $eventid);
			$db->setQuery($query);

			$result = $db->loadObjectList();
		}
		elseif ($view == 'registration')
		{
			$db	= JFactory::getDbo();

			$query = $db->getQuery(true);
			$query->select('next AS next, dates AS dates,
							startdate AS startdate, enddate AS enddate, weekdays AS weekdays,
							id AS id, state AS state, access AS access, params AS params');
			$query->from('`#__icagenda_events` AS e');
			$query->where(' e.id = ' . $eventid);

			$db->setQuery($query);

			$i = $db->loadObject();

			if ($regid != 0)
			{
				$reg_query	= $db->getQuery(true);
				$reg_query->select('r.id as reg_id, r.date AS reg_date, r.period AS reg_period, r.eventid AS reg_eventid')
					->from('`#__icagenda_registration` AS r');
				$reg_query->where('r.id = ' . (int) $regid);
				$db->setQuery($reg_query);

				$obj = $db->loadObject();

				$reg_date	= $obj->reg_date;
				$reg_period	= $obj->reg_period;
			}
			else
			{
				$reg_date	= '';
				$reg_period	= '';
			}
		}

		$options = '';

		if ($view == 'mail')
		{
			$options.= '<option value="">' . JText::_('COM_ICAGENDA_SELECT_DATE') . '</option>';
			$options.= '<option value="all"';
			$options.= ($date == 'all') ? ' selected="selected"' : '';
			$options.= '>' . strtoupper(JText::_('COM_ICAGENDA_REGISTRATION_ALL_DATES')) . '</option>';
		}
		elseif ($i && $view == 'registration')
		{
			$options.= self::getOptionsAllDates($i, 'registration', $reg_date, $reg_period);
		}

		if (isset($result) && $view == 'mail')
		{
			foreach($result as $r)
			{
				// Full period (no single date selected, supposes registration for full period)
				if ( ! $r->reg_date && $r->reg_period == 0)
				{
					// Check the period if is separated into individual dates
					$is_full_period = ($r->weekdays || $r->weekdays == '0') ? false : true;

					if ($is_full_period
						&& iCDate::isDate($r->startdate)
						&& iCDate::isDate($r->enddate))
					{
						$option_value = '0';
						$option_date = self::formatDate($r->startdate) . ' &#x279c; ' . self::formatDate($r->startdate);
					}
					else
					{
						$option_value	= '0';
						$option_date	= JText::_( 'COM_ICAGENDA_ADMIN_REGISTRATION_FOR_ALL_PERIOD' );
					}
				}

				// All dates of the event (single dates + period)
				elseif ( ! $r->reg_date && $r->reg_period == 1)
				{
					$option_value	= '1';
					$option_date	= JText::_( 'COM_ICAGENDA_ADMIN_REGISTRATION_FOR_ALL_DATES' );
				}

				// One date selected (from single dates or split period into single dates)
				else
				{
					if (iCDate::isDate($r->reg_date))
					{
						$regDate		= iCGlobalize::dateFormat($r->reg_date, $date_format_global, $separator);
						$time			= date('H:i', strtotime($r->reg_date));
						$regTime		= ($time && $time != '00:00') ? ' - ' . $time : '';
					}

					$option_value	= $r->reg_date;

					// Date format (global option).
					// NOTE: Date saved in database with versions before 3.3.8 can not be formatted
					//       Will return a string (date in old format) with double quote.
					$option_date	= iCDate::isDate($r->reg_date) ? $regDate . $regTime : '"' . $r->reg_date . '"';
				}

				$options.= '<option value="' . $option_value . '"';
				$options.= ($date == $option_value) ? ' selected="selected"' : '';
				$options.= '>' . $option_date . ' (&#10003;' . $r->reg_count . ')</option>';
			}
		}

		echo $options;

		Jexit();
	}

	static public function getOptionsAllDates($i, $view = null, $reg_date = null, $reg_period = null)
	{
		$options = '';

		if ($i)
		{
			// Set Event Params
			$eventparam		= new JRegistry($i->params);

			$typeReg		= $eventparam->get('typeReg');

			// Registration type for event is set to "All dates of the event"
			if ($typeReg == '2')
			{
				if ( $reg_period != 1 )
				{
					$options.= '<option value="' . $reg_date . '" selected="selected">' . JText::_('COM_ICAGENDA_SELECT_DATE') . '</option>';
					$options.= '<option value="update"';
					$options.= '>' . JText::_('COM_ICAGENDA_ADMIN_REGISTRATION_FOR_ALL_DATES') . '</option>';
				}
				else
				{
					$options.= '<option value=""';
					$options.= ' selected="selected"';
					$options.= '>' . JText::_('COM_ICAGENDA_ADMIN_REGISTRATION_FOR_ALL_DATES') . '</option>';
				}
			}
			else
			{
				if ( ( ! $reg_date && $reg_period == 1)
					|| ($reg_date && ! iCDate::isDate($reg_date))
					|| ( ! $reg_date && $reg_period == 0)
					|| ( iCDate::isDate($reg_date) && $reg_period == 1) )
				{
					$options.= '<option value="' . $reg_date . '"';
					$options.= ' selected="selected"';
					$options.= '>' . JText::_('COM_ICAGENDA_SELECT_DATE') . '</option>';
				}

				// Declare AllDates array
				$AllDates		= array();

				// Get WeekDays setting
				$WeeksDays		= iCDatePeriod::weekdaysToArray($i->weekdays);

				// If Single Dates, added each one to All Dates for this event
				$singledates	= iCString::isSerialized($i->dates) ? unserialize($i->dates) : array();

				foreach($singledates as $sd)
				{
					if (iCDate::isDate($sd))
					{
						array_push($AllDates, $sd);
					}
				}

				// If Period Dates, added each one to All Dates for this event (filter week Days, and if date not null)
				$perioddates = iCDatePeriod::listDates($i->startdate, $i->enddate);

				if (isset($perioddates)
					&& is_array($perioddates))
				{
					// Check the period if is separated into individual dates
					$is_full_period = ($i->weekdays || $i->weekdays == '0') ? false : true;

					if ($is_full_period
						&& iCDate::isDate($i->startdate)
						&& iCDate::isDate($i->enddate))
					{
						$value_datetime = '';

						$options.= '<option value="' . $value_datetime . '"';

						if ($reg_date == '' && $reg_period != 1)
						{
							$date_exist = true;
							$options.= ' selected="selected"';
						}

						$options.= '>' . self::formatDate($i->startdate) . ' &#x279c; ' . self::formatDate($i->startdate) . '</option>';
					}
					else
					{
						foreach ($perioddates as $Dat)
						{
							if (in_array(date('w', strtotime($Dat)), $WeeksDays))
							{
								// May not work in php < 5.2.3 (should return false if date null since 5.2.4)
								$isValid = iCDate::isDate($Dat);

								if ($isValid)
								{
									$SingleDate = date('Y-m-d H:i', strtotime($Dat));
									array_push($AllDates, $SingleDate);
								}
							}
						}
					}
				}

				// get Time Format
				$timeformat = JComponentHelper::getParams('com_icagenda')->get('timeformat', '1');

				$lang_time = ($timeformat == 1) ? 'H:i' : 'h:i A';

				if ( ! empty($AllDates))
				{
					sort($AllDates);
				}

				foreach($AllDates as $date)
				{
					if (iCDate::isDate($date))
					{
						$value_datetime = date('Y-m-d H:i:s', strtotime($date));

						$options.= '<option value="' . $value_datetime . '"';

						if ($reg_date == $value_datetime)
						{
							$date_exist = true;
							$options.= ' selected="selected"';
						}

						$options.= '>' . self::formatDate($date) . ' - ' . date($lang_time, strtotime($date)) . '</option>';
					}
				}
			}

			return $options;
		}

		return false;
	}


	// Function to get Format Date (using option format, and translation)
	static public function formatDate($date)
	{
		// Date Format Option (Global Component Option)
		$date_format_global	= JComponentHelper::getParams('com_icagenda')->get('date_format_global', 'Y - m - d');
		$format				= ($date_format_global != 0) ? $date_format_global : 'Y - m - d'; // Previous 3.5.6 setting

		// Separator Option
		$separator			= JComponentHelper::getParams('com_icagenda')->get('date_separator', ' ');

		if ( ! is_numeric($format))
		{
			// Update old Date Format options of versions before 2.1.7
			$format = str_replace(array('nosep', 'nosep', 'sepb', 'sepa'), '', $format);
			$format = str_replace('.', ' .', $format);
			$format = str_replace(',', ' ,', $format);
		}

		$dateFormatted = iCGlobalize::dateFormat($date, $format, $separator);

		return $dateFormatted;
	}
}
