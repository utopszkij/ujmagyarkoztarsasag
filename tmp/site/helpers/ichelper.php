<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version 	3.5.11 2015-09-02
 * @since       3.2.8
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport('joomla.application.component.modelitem');
jimport( 'joomla.html.parameter' );
jimport( 'joomla.registry.registry' );

jimport('joomla.user.helper');
jimport('joomla.access.access');

class iCModeliChelper extends JModelItem
{
	// SubTitle Events list
//	public static function iCheader($total, $getpage, $arrowtext, $number_per_page, $pagination)
	public static function iCheader($total, $arrowtext, $number_per_page, $pagination)
	{
		// loading iCagenda PARAMS
		$app		= JFactory::getApplication();
		$jinput		= $app->input;

		$getpage	= $jinput->get('page', '1');

		$iCparams	= $app->getParams();

		$time		= $iCparams->get('time', '1');
		$headerList	= $iCparams->get('headerList', 1);

		if ($time == '0')
		{
			// COM_ICAGENDA_ALL
			$header_title	= JText::_( 'COM_ICAGENDA_HEADER_ALL_TITLE' );
			$header_many	= JText::sprintf( 'COM_ICAGENDA_HEADER_ALL_MANY_EVENTS', $total );
			$header_one		= JText::sprintf( 'COM_ICAGENDA_HEADER_ALL_ONE_EVENT', $total );
			$header_noevt	= JText::_( 'COM_ICAGENDA_HEADER_ALL_NO_EVENT' );
		}
		elseif ($time == '1')
		{
			// COM_ICAGENDA_OPTION_TODAY_AND_UPCOMING
			$header_title	= JText::_( 'COM_ICAGENDA_HEADER_TODAY_AND_UPCOMING_TITLE' );
			$header_many	= JText::sprintf( 'COM_ICAGENDA_HEADER_TODAY_AND_UPCOMING_MANY_EVENTS', $total );
			$header_one		= JText::sprintf( 'COM_ICAGENDA_HEADER_TODAY_AND_UPCOMING_ONE_EVENT', $total );
			$header_noevt	= JText::_( 'COM_ICAGENDA_HEADER_TODAY_AND_UPCOMING_NO_EVENT' );
		}
		elseif ($time == '2')
		{
			// COM_ICAGENDA_OPTION_PAST
			$header_title	= JText::_( 'COM_ICAGENDA_HEADER_PAST_TITLE' );
			$header_many	= JText::sprintf( 'COM_ICAGENDA_HEADER_PAST_MANY_EVENTS', $total );
			$header_one		= JText::sprintf( 'COM_ICAGENDA_HEADER_PAST_ONE_EVENT', $total );
			$header_noevt	= JText::_( 'COM_ICAGENDA_HEADER_PAST_NO_EVENT' );
		}
		elseif ($time == '3')
		{
			// COM_ICAGENDA_OPTION_FUTURE
			$header_title	= JText::_( 'COM_ICAGENDA_HEADER_UPCOMING_TITLE' );
			$header_many	= JText::sprintf( 'COM_ICAGENDA_HEADER_UPCOMING_MANY_EVENTS', $total );
			$header_one		= JText::sprintf( 'COM_ICAGENDA_HEADER_UPCOMING_ONE_EVENT', $total );
			$header_noevt	= JText::_( 'COM_ICAGENDA_HEADER_UPCOMING_NO_EVENT' );
		}
		elseif ($time == '4')
		{
			// COM_ICAGENDA_OPTION_TODAY
			$header_title	= JText::_( 'COM_ICAGENDA_HEADER_TODAY_TITLE' );
			$header_many	= JText::sprintf( 'COM_ICAGENDA_HEADER_TODAY_MANY_EVENTS', $total );
			$header_one		= JText::sprintf( 'COM_ICAGENDA_HEADER_TODAY_ONE_EVENT', $total );
			$header_noevt	= JText::_( 'COM_ICAGENDA_HEADER_TODAY_NO_EVENT' );
		}

		$report = $report2 = '';

		if ($total == 1)
		{
			$report.= '<span class="ic-subtitle-string">' . $header_one . '</span>';
		}
		if ($total == 0)
		{
			$report.= '<span class="ic-subtitle-string">' . $header_noevt . '</span>';
		}
		if ($total > 1)
		{
			$report.= '<span class="ic-subtitle-string">' . $header_many . '</span>';
		}

		$num = $number_per_page;

		// No display if number does not exist
		$pages = ($num == NULL) ? 1 : ceil($total/$num);

		$page_nb = $getpage;

		if (JRequest::getVar('page') == NULL)
		{
			$page_nb = 1;
		}

		$report2.= ($pages <= 1)
					? ''
					: ' <span class="ic-subtitle-pages"> - ' . JText::_( 'COM_ICAGENDA_EVENTS_PAGE' ) . ' '
						. $page_nb . ' / ' . $pages . '</span>';

		// Tag for header title depending of show_page_heading setting
		$menuItem	= $app->getMenu()->getActive();

    	if (is_object($menuItem)
    		&& $menuItem->params->get('show_page_heading', 1))
    	{
			$tag = 'h2';
		}
		else
		{
			$tag = 'h1';
		}

		// Display Header title/subtitle (options)
		if ($headerList == 1)
		{
			$header = '<div class="ic-header-container">';
			$header.= '<' . $tag . ' class="ic-header-title">' . $header_title . '</' . $tag . '>';
			$header.= '<div class="ic-header-subtitle">' . $report . ' ' . $report2 . '</div>';
		}
		elseif ($headerList == 2)
		{
			$header = '<div class="ic-header-container">';
			$header.= '<' . $tag . ' class="ic-header-title">' . $header_title . '</' . $tag . '>';
		}
		elseif ($headerList == 3)
		{
			$header = '<div class="ic-header-container">';
			$header.= '<div class="ic-header-subtitle">' . $report . ' ' . $report2 . '</div>';
		}
		elseif ($headerList == 4)
		{
			$header = '<div>';
		}

		$header.='</div>';
		$header.= '<br/>';

		return $header;
	}

	// Navigator Events list
//	public static function pagination($count_items, $getpage, $arrowtext, $number_per_page, $pagination)
	public static function pagination($count_items, $arrowtext, $number_per_page, $pagination)
	{
		$app	= JFactory::getApplication();
		$jinput	= $app->input;

		$getpage = $jinput->get('page', 1);

		// If number of pages < or = 1, no display of pagination
		if (($count_items / $number_per_page) <= 1)
		{
			$nav = '';
		}
		else
		{
			// first check whether there are elements of those selected
			$ctrlNext = ($count_items > $number_per_page) ? 1 : NULL;
			$ctrlBack = ($getpage && $getpage > 1) ? 1 : NULL;

			$num = $number_per_page;

			// No display if number not exist
			$pages = ($num == NULL) ? 1 : ceil($count_items / $number_per_page);

			$nav = '<div class="navigator">';

			// in the case of text next/prev
			$textnext = ($arrowtext == 1) ? JText::_( 'JNEXT' ) : '';
			$textback = ($arrowtext == 1) ? JText::_( 'JPREV' ) : '';

			$parentnav = JRequest::getInt('Itemid');

			$mainframe = JFactory::getApplication();
			$isSef = $mainframe->getCfg( 'sef' );

			if ($isSef == '1')
			{
				$urlpage = JRoute::_(JURI::current().'?');
			}
			elseif ($isSef == '0')
			{
				$urlpage = 'index.php?option=com_icagenda&amp;view=list&amp;Itemid='.(int)$parentnav.'&amp;';
			}

			if ($pages >= 2)
			{
				if ($ctrlBack != NULL)
				{
					if ($getpage && $getpage < $pages)
					{
						$pageBack	= $getpage-1;
						$pageNext	= $getpage+1;

						$nav.= '<a class="icagenda_back iCtip" href="' . JRoute::_($urlpage . 'page=' . $pageBack) . '" title="' . $textback . '"><span class="iCicon iCicon-backic"></span> ' . $textback . '&nbsp;</a>';
						$nav.= '<a class="icagenda_next iCtip" href="' . JRoute::_($urlpage . 'page=' . $pageNext) . '" title="' . $textnext . '">&nbsp;' . $textnext . ' <span class="iCicon iCicon-nextic"></span></a>';

//						$nav.= '<div class="icagenda_back"><button class="iCtip" onclick="prevNav(); return false;" title="' . JText::_( 'JPREV' ) . '"><a href="#"><span class="iCicon iCicon-backic"></span> ' . $pageBack . $textback . '&nbsp;</a></button></div>';

//						$nav.= '<div class="icagenda_next"><button class="iCtip" onclick="nextNav(); return false;" title="' . JText::_( 'JNEXT' ) . '"><a href="#">&nbsp;' . $textnext . $pageNext . ' <span class="iCicon iCicon-nextic"></span></a></button></div>';
					}
					else
					{
						$pageBack	= $getpage-1;

						$nav.= '<a class="icagenda_back iCtip" href="' . JRoute::_($urlpage . 'page=' . $pageBack) . '" title="' . $textback . '"><span class="iCicon iCicon-backic"></span> ' . $textback . '&nbsp;</a>';

//						$nav.= '<div class="icagenda_back"><button class="iCtip" onclick="prevNav(); return false;" title="' . JText::_( 'JPREV' ) . '"><a href="#"><span class="iCicon iCicon-backic"></span> ' . $pageBack . $textback . '&nbsp;</a></button></div>';
					}
				}

				if ($ctrlNext != NULL)
				{
					if ( ! $getpage)
					{
						$pageNext	= 2;
					}
					else
					{
						$pageNext	= $getpage+1;
						$pageBack	= $getpage-1;
					}

					if (empty($pageBack))
					{
						$nav.= '<a class="icagenda_next iCtip" href="' . JRoute::_($urlpage . 'page=' . $pageNext) . '" title="' . $textnext . '">&nbsp;' . $textnext . ' <span class="iCicon iCicon-nextic"></span></a>';

//						$nav.= '<div class="icagenda_next"><button class="iCtip" onclick="nextNav(); return false;" title="' . JText::_( 'JNEXT' ) . '"><a href="#">&nbsp;' . $textnext . $pageNext . ' <span class="iCicon iCicon-nextic"></span></a></button></div>';
					}
				}

//				$nav.= '<div id="currentpage"></div>';

//				$nav.= '<script>';
//				$nav.= 'function prevNav()';
//				$nav.= '{';
//				$nav.= '	document.getElementById("currentpage").innerHTML = "<input type=\"hidden\" name=\"page\" value=\"' . $pageBack . '\" />";';
//				$nav.= '	this.form.submit();';
//				$nav.= '}';
//				$nav.= 'function nextNav()';
//				$nav.= '{';
//				$nav.= '	document.getElementById("currentpage").innerHTML = "<input type=\"hidden\" name=\"page\" value=\"' . $pageNext . '\" />";';
//				$nav.= '	this.form.submit();';
//				$nav.= '}';
//				$nav.= '</script>';
			}

			if ($pagination == 1)
			{
				/* Pagination */

				if (empty($pageBack))
				{
					$nav.= '<div style="text-align:left">[ ';
				}
				elseif ($getpage && $getpage == $pages)
				{
					$nav.= '<div style="text-align:right">[ ';
				}
				else
				{
					$nav.= '<div style="text-align:center">[ ';
				}

				/* Boucle sur les pages */
				for ($i = 1 ; $i <= $pages ; $i++)
				{
					if ($i==1 || (($getpage-5) < $i && $i < ($getpage+5)) || $i==$pages)
					{
						if ($i == $pages && $getpage < ($pages-5))
						{
							$nav.= '...';
						}

						if ($i == $getpage)
						{
							$nav.= ' <b>' . $i . '</b>';
						}
						else
						{
							$nav.= ' <a href="' . $urlpage . 'page=' . $i . '"';
							$nav.= ' class="iCtip"';
							$nav.= ' title="' . JText::sprintf( 'COM_ICAGENDA_EVENTS_PAGE_PER_TOTAL', $i, $pages ) . '">';
							$nav.= $i;
							$nav.= '</a>';
						}

						if ($i == 1 && $getpage > 6)
						{
							$nav.= '...';
						}
					}
				}

				$nav.= ' ]</div>';
			}

			$nav.= '</div>';
		}

		return $nav;
	}

	// Function to get Format Date (list of events)
	public static function formatDate($date)
	{
		// Date Format Option (Global Component Option)
		$date_format_global	= JComponentHelper::getParams('com_icagenda')->get('date_format_global', 'Y - m - d');
		$date_format_global	= ($date_format_global !== '0') ? $date_format_global : 'Y - m - d'; // Previous 3.5.6 setting

		// Date Format Option (Menu Option)
		$date_format_menu	= JFactory::getApplication()->getParams()->get('format', '');
		$date_format_menu	= ($date_format_menu !== '0') ? $date_format_menu : ''; // Previous 3.5.6 setting

		// Set Date Format option to be used
		$format				= $date_format_menu ? $date_format_menu : $date_format_global;

		// Separator Option
		$separator			= JFactory::getApplication()->getParams()->get('date_separator', ' ');

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


	// Set Date format for url
	public static function eventUrlDate($evt)
	{
		$evt_explode	= explode(' ', $evt);
		$dateday		= $evt_explode['0'] . '-' . str_replace(':', '-', $evt_explode['1']);

		return $dateday;
	}


	// Get Next Date (or Last Date)
	public static function nextDate($evt, $i)
	{
		$eventTimeZone = null;

		$singledates	= iCString::isSerialized($i->dates) ? unserialize($i->dates) : array(); // returns array
		$period			= iCString::isSerialized($i->period) ? unserialize($i->period) : array(); // returns array
		$startdatetime	= $i->startdatetime;
		$enddatetime	= $i->enddatetime;
		$weekdays		= $i->weekdays;

		$site_today_date	= JHtml::date('now', 'Y-m-d');
		$UTC_today_date		= JHtml::date('now', 'Y-m-d', $eventTimeZone);

		$next_date			= JHtml::date($evt, 'Y-m-d', $eventTimeZone);
		$next_datetime		= JHtml::date($evt, 'Y-m-d H:i', $eventTimeZone);

		$start_date			= JHtml::date($i->startdatetime, 'Y-m-d', $eventTimeZone);
		$end_date			= JHtml::date($i->enddatetime, 'Y-m-d', $eventTimeZone);

		// Check if date from a period with weekdays has end time of the period set in next.
//		$time_next_datetime	= JHtml::date($next_datetime, 'H:i', $eventTimeZone);
		$time_next_datetime	= date('H:i', strtotime($next_datetime));
		$time_startdate		= JHtml::date($i->startdatetime, 'H:i', $eventTimeZone);
		$time_enddate		= JHtml::date($i->enddatetime, 'H:i', $eventTimeZone);

		$data_next_datetime		= date('Y-m-d H:i', strtotime($evt));

		if ($next_date == $site_today_date
			&& $time_next_datetime == $time_enddate)
		{
			$next_datetime = $next_date . ' ' . $time_startdate;
		}

		if ( $period != NULL
			&& in_array($data_next_datetime, $period) )
		{
			$next_is_in_period = true;
		}
		else
		{
			$next_is_in_period = false;
		}

		// Highlight event in progress
		if ($next_date == $site_today_date)
		{
			$start_span	= '<span class="ic-next-today">';
			$end_span	= '</span>';
		}
		else
		{
			$start_span = $end_span = '';
		}

		$separator = '<span class="ic-datetime-separator"> - </span>';

		// Format Next Date
		if ( $next_is_in_period
			&& ($start_date == $end_date || $weekdays != null) )
		{
			// Next in the period & (same start/end date OR one or more weekday selected)
			$nextDate = $start_span;
			$nextDate.= '<span class="ic-period-startdate">';
			$nextDate.= self::formatDate($evt);
			$nextDate.= '</span>';

			if ($i->displaytime == 1)
			{
				$nextDate.= ' <span class="ic-single-starttime">' . icagendaEvents::dateToTimeFormat($startdatetime) . '</span>';

				if ( icagendaEvents::dateToTimeFormat($startdatetime) != icagendaEvents::dateToTimeFormat($enddatetime) )
				{
					$nextDate.= $separator . '<span class="ic-single-endtime">' . icagendaEvents::dateToTimeFormat($enddatetime) . '</span>';
				}
			}

			$nextDate.= $end_span;
		}
		elseif ( $next_is_in_period
			&& ($weekdays == null) )
		{
			// Next in the period & different start/end date & no weekday selected
			$start	= '<span class="ic-period-startdate">';
			$start	.= self::formatDate($startdatetime);
			$start	.= '</span>';

			$end	= '<span class="ic-period-enddate">';
			$end	.= self::formatDate($enddatetime);
			$end	.= '</span>';

			if ($i->displaytime == 1)
			{
				$start		.= ' <span class="ic-period-starttime">' . icagendaEvents::dateToTimeFormat($startdatetime) . '</span>';
				$end		.= ' <span class="ic-period-endtime">' . icagendaEvents::dateToTimeFormat($enddatetime) . '</span>';
			}

			$nextDate = $start_span . $start . $separator . $end . $end_span;
		}
		else
		{
			// Next is a single date
			$nextDate = $start_span;
			$nextDate.= '<span class="ic-single-next">';
			$nextDate.= self::formatDate($evt);
			$nextDate.= '</span>';

			if ($i->displaytime == 1)
			{
				$nextDate.= ' <span class="ic-single-starttime">' . icagendaEvents::dateToTimeFormat($evt) . '</span>';
			}

			$nextDate.= $end_span;
		}

		return $nextDate;
	}


	// Read More Button
	public static function readMore ($url, $desc, $content = '')
	{
		$iCparams		= JComponentHelper::getParams('com_icagenda');
		$limitGlobal	= $iCparams->get('limitGlobal', 0);

		if ($limitGlobal == 1)
		{
			$limit = $iCparams->get('ShortDescLimit', '100');
		}
		elseif ($limitGlobal == 0)
		{
			$customlimit = $iCparams->get('limit', '100');

			$limit = is_numeric($customlimit) ? $customlimit : $iCparams->get('ShortDescLimit', '100');
		}

		$limit = is_numeric($limit) ? $limit : '1';

		$readmore	= '';

		$readmore	= ($limit <= 1) ? '' : $content;
		$text		= preg_replace('/<img[^>]*>/Ui', '', $desc);

		if (strlen($text) > $limit)
		{
			$string_cut	= substr($text, 0, $limit);
			$last_space	= strrpos($string_cut, ' ');
			$string_ok	= substr($string_cut, 0, $last_space);
			$text		= $string_ok . ' ';
			$url		= $url;
			$text		= '<a href="' . $url . '" class="more">' . $readmore . '</a>';
		}
		else
		{
			$text		= '';
		}

		return $text;
	}
}
