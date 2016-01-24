<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Tom-Henning (MaW) / Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     3.5.13 2015-10-17
 * @since       3.2.9
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

require_once JPATH_COMPONENT . '/helpers/iCalcreator.class.php';

$app			= JFactory::getApplication();

// Load Joomla config options
$sitename		= $app->getCfg('sitename');
$offset			= $app->getCfg('offset');

// Load event data
$this_item		= (array) $this->data->items;
$item			= array_shift($this_item);

// Get date from the session (current date of the event page)
$session		= JFactory::getSession();
$session_date	= $session->get('date_value');

if ($session_date)
{
	$eventDateTime	= iCDate::isDate($session_date) ? $session_date : '';
}
else
{
	$url_date		= $app->input->get('date', '');

	if ($url_date)
	{
		$sd_ex			= explode('-', $url_date);
		$eventDateTime	= $sd_ex['0'] . '-' . $sd_ex['1'] . '-' . $sd_ex['2'] . ' ' . $sd_ex['3'] . ':' . $sd_ex['4'] . ':00';
	}
}

$new_date		= isset($eventDateTime) ? $eventDateTime : $item->next;

// Set Time Offset for date of the event
$dateTimeZone	= new DateTimeZone($offset);
$dateTime		= new DateTime($new_date, $dateTimeZone);
$timeOffset		= $dateTimeZone->getOffset($dateTime);
$timezone		= ($timeOffset / 3600);

$event_date		= isset($eventDateTime)
				? date('Y-m-d-H-i', (strtotime($eventDateTime) - $timeOffset))
				: date('Y-m-d-H-i', (strtotime($item->next) - $timeOffset));

// Set vCalendar config;
$config = array( "unique_id" => $sitename
  // set a (site) unique id
               , "TZID"      => $offset );
  // opt. "calendar" timezone

// Create a new calendar instance
$v = new vCalendar($config);
$v->setConfig( 'filename', 'icagenda.ics' );
$v->prodid = 'iCagenda';

//$tz = 'UTC';
$tz = $offset;
$v->setProperty( 'method', 'PUBLISH' );
$v->setProperty( 'X-WR-CALDESC', '' );
$v->setProperty( 'X-WR-TIMEZONE', $tz);
$xprops = array( 'X-LIC-LOCATION' => $tz);

if (version_compare(PHP_VERSION, '5.3.0') >= 0)
{
	iCalUtilityFunctions::createTimezone($v, $tz, $xprops);
}

$s_dates		= $item->dates;
$single_dates	= unserialize($s_dates);

$ex			= explode('-', $event_date);
$this_date	= $ex['0'].'-'.$ex['1'].'-'.$ex['2'].' '.$ex['3'].':'.$ex['4'];

$startdate	= date('Y-m-d-H-i', strtotime($item->start_datetime)-$timeOffset);
$enddate	= date('Y-m-d-H-i', strtotime($item->end_datetime)-$timeOffset);

if ( ($event_date >= $startdate)
	&& ($event_date <= $enddate)
	&& ( ! in_array($this_date, $single_dates)) )
{
	$weekdays	= ($item->weekdays || $item->weekdays == '0') ? true : false;

	if ($weekdays)
	{
		$startdate	= date('Y-m-d-H-i', strtotime($this_date));
		$enddate	= date('Y-m-d', strtotime($this_date)) . '-' . date('H-i', strtotime($item->end_datetime)-$timeOffset);
	}

	$ex_S = explode('-', $startdate);
	$ex_E = explode('-', $enddate);

	$start_Datetime	= $ex_S['0'] . $ex_S['1'] . $ex_S['2'] . 'T' . $ex_S['3'] . $ex_S['4'] . '00Z';
	$end_Datetime	= $ex_E['0'] . $ex_E['1'] . $ex_E['2'] . 'T' . $ex_E['3'] . $ex_E['4'] . '00Z';
//	$start_Date = $ex_S['0'].$ex_S['1'].$ex_S['2'];
//	$end_Date = $ex_E['0'].$ex_E['1'].$ex_E['2'];
}
else
{
	$start_Datetime = $end_Datetime = $ex['0'] . $ex['1'] . $ex['2'] . 'T' . $ex['3'] . $ex['4'] . '00Z';
//	$start_Date = $end_Date = $ex['0'].$ex['1'].$ex['2'];
}

// Not yet used
$urllink	= JUri::getInstance()->toString();
$cleanurl	= preg_replace('/&tmpl=[^&]*/', '', $urllink);
$cleanurl	= preg_replace('/&vcal=[^&]*/', '', $cleanurl);

$vevent = &$v->newComponent('vevent');
$vevent->setProperty('categories', $item->cat_title);
$vevent->setProperty('summary', $item->title);
$vevent->setProperty('description', strip_tags($item->desc));
$vevent->setProperty('url', $item->Event_Link);
$vevent->setUID($item->id);

if ($item->contact_name != '')
{
	$vevent->setOrganizer($item->contact_name, $item->contact_email);
}

//if ($item->displaytime == 1)
//{
	$vevent->setProperty('dtstart', $start_Datetime);
	$vevent->setProperty('dtend', $end_Datetime);
//}
//else
//{
	// All day event (if time not displayed)
//	$vevent->setProperty('dtstart', $start_Date, array("VALUE" => "DATE"));
//	$vevent->setProperty('dtend', $end_Date, array("VALUE" => "DATE"));
//	//$vevent->setProperty ("duration" , "PT24H");
//}

$vevent->setProperty('location',$item->place_name);

$v->returnCalendar();
