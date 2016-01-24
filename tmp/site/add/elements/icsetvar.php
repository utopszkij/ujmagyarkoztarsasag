<?php
/**
 *------------------------------------------------------------------------------
 *	iCagenda Set Var for Theme Packs
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version 	3.5.12 2015-10-06
 * @since       3.2.8
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

// loading iCagenda PARAMS (Component + menu)
$app			= JFactory::getApplication();
$params			= $app->getParams();
$isSef			= $app->getCfg('sef');

$jview			= JRequest::getCmd('view', '');
$jlayout		= JRequest::getCmd('layout', 'default');

$layouts_array	= array('event', 'registration');
$ic_main_list	= ! in_array($jlayout, $layouts_array) ? true : false;

$datesDisplay	= $params->get('datesDisplay', 1);

$eventTimeZone	= null;
$only_startdate	= ($item->weekdays || $item->weekdays == '0') ? false : true;


	if ($ic_main_list)
	{
		$this_date		= JHtml::date($evt, 'Y-m-d H:i', $eventTimeZone);
		$date_today		= JHtml::date('now', 'Y-m-d');
		$period			= unserialize($item->period);
		$period			= is_array($period) ? $period : array();
		$is_in_period	= (in_array($this_date, $period)) ? true : false;

		if ($is_in_period
			&& $item->weekdays == ''
			&& strtotime($item->startdatetime) <= strtotime($date_today)
			&& strtotime($item->enddatetime) >= strtotime($date_today)
			)
		{
			$ongoing = true;
		}
		else
		{
			$ongoing = false;
		}

		// Day in Date Box (list of events)
		$EVENT_DAY			= $this->day_display_global ? icagendaEvents::day($evt, $item) : false;
		// Month in Date Box (list of events)
		$EVENT_MONTHSHORT	= $this->month_display_global ? icagendaEvents::dateBox($this_date, 'monthshort', $ongoing) : false;
		// Year in Date Box (list of events)
		$EVENT_YEAR			= $this->year_display_global ? icagendaEvents::dateBox($evt, 'year', $ongoing) : false;
		// Time in Date Box (list of events)
		$EVENT_TIME			= ($this->time_display_global && $item->displaytime == 1)
							? icagendaEvents::dateToTimeFormat($evt)
							: false;

		// Load Event Data
		$EVENT_DATE			= iCModeliChelper::nextDate($evt, $item);
		$EVENT_SET_DATE		= iCModeliChelper::eventUrlDate($evt);
		$READ_MORE			= ($this->shortdesc_display_global == '' && !$item->shortdesc)
							? iCModeliChelper::readMore($item->url, $item->desc, '[&#46;&#46;&#46;]')
							: false;

		// URL to event details view (list of events)
		if ($datesDisplay == 1)
		{
			$date_var		= ($isSef == '1') ? '?date=' : '&amp;date=';
			$set_url_date	= $date_var . $EVENT_SET_DATE;
			$date_url		= ($only_startdate && in_array($this_date, $period))
							? ''
							: $date_var . $EVENT_SET_DATE;

			$EVENT_URL = $item->url . $date_url;
		}
		else
		{
			$EVENT_URL = $item->url;
		}
	}
	else
	{
		$EVENT_URL = $item->url;
	}


	/**
	 *	Event Header
	 */
	$BACK_ARROW				= $item->BackArrow;

	$EVENT_SHARING			= $item->share_event;
	$EVENT_REGISTRATION		= $item->reg;

	// Event Title
	$EVENT_TITLE			= $item->titleFormat;
	$EVENT_TITLEBAR			= $item->titlebar;


	/**
	 *	Event Dates
	 */
	$TEXT_FOR_NEXTDATE		= $item->dateText;
	$EVENT_NEXT				= $item->next;
	$EVENT_NEXTDATE			= $item->nextDate;
//	$EVENT_DAY				= $item->day;
//	$EVENT_MONTHSHORT		= $item->monthShort;

	// Get var 'date_value' set to session in event details view
	$session = JFactory::getSession();
	$get_date = $session->get('date_value', '');

	if (!$get_date)
	{
		$get_date = JRequest::getVar('date', '');
	}

	if ($get_date)
	{
		$ex = explode('-', $get_date);

		if (count($ex) == 5)
		{
			$dateday = $ex['0'].'-'.$ex['1'].'-'.$ex['2'].' '.$ex['3'].':'.$ex['4'];
		}
		else
		{
			$dateday = '';
		}
	}

	$timeformat = $params->get('timeformat');

	$timedisplay = '';
	$timedisplay = $item->displaytime;

	$lang_time = '';

	if ($get_date)
	{
		$EVENT_THIS_DATE = iCModeliChelper::formatDate($dateday);

		if ($timedisplay == 1)
		{
			if ($timeformat == 1)
			{
				$lang_time = strftime('%H:%M', strtotime($dateday));
			}
			else
			{
				$lang_time = strftime('%I:%M %p', strtotime($dateday));
			}

			$EVENT_THIS_DATE.= ' <small>' . $lang_time;

			$weekdays_array = explode (',', $item->weekdays);
			$weekdays = count($weekdays_array);

			if ( !empty($weekdays) && $item->periodTest
				&& ($lang_time != $item->endTime) )
			{
				$EVENT_THIS_DATE.= ' - ' . $item->endTime;
			}

			$EVENT_THIS_DATE.= '</small>';
		}

		$dates_array	= unserialize($item->dates);
		$dates_array	= is_array($dates_array) ? $dates_array : array();
		$period_array	= unserialize($item->period);
		$period_array	= is_array($period_array) ? $period_array : array();

		// Period with no weekdays selected
		if (isset($EVENT_THIS_DATE)
			&& empty($weekdays)
			&& in_array($dateday, $period_array)
			)
		{
			$EVENT_VIEW_DATE_TEXT	= $TEXT_FOR_NEXTDATE;
			$EVENT_VIEW_DATE		= $EVENT_NEXTDATE;
		}

		// Single Date or date in a period with weekdays selection
		elseif (isset($EVENT_THIS_DATE)
			&& !empty($weekdays)
			&& (in_array($dateday, $dates_array) || in_array($dateday, $period_array))
			)
		{
			$EVENT_VIEW_DATE_TEXT	= JTEXT::_('COM_ICAGENDA_EVENT_DATE');
			$EVENT_VIEW_DATE		= $EVENT_THIS_DATE;
		}

		// Next/Last Date (if type is list of events)
		else
		{
			$EVENT_VIEW_DATE_TEXT	= $TEXT_FOR_NEXTDATE;
			$EVENT_VIEW_DATE		= $EVENT_NEXTDATE;
		}
	}
	else
	{
		$EVENT_VIEW_DATE_TEXT	= $TEXT_FOR_NEXTDATE;
		$EVENT_VIEW_DATE		= $EVENT_NEXTDATE;
	}

	/**
	 *	Feature Icons
	 */
	$FEATURES_ICONSIZE_LIST		= $params->get('features_icon_size_list');
	$FEATURES_ICONSIZE_EVENT	= $params->get('features_icon_size_event');
	$SHOW_ICON_TITLE			= $params->get('show_icon_title');
	// Get media path
	$params_media = JComponentHelper::getParams('com_media');
	$image_path = $params_media->get('image_path', 'images');
	$FEATURES_ICONROOT_LIST		= JUri::root() . $image_path . '/icagenda/feature_icons/' . $FEATURES_ICONSIZE_LIST . '/';
	$FEATURES_ICONROOT_EVENT	= JUri::root() . $image_path . '/icagenda/feature_icons/' . $FEATURES_ICONSIZE_EVENT . '/';
	$FEATURES_ICONS				= array();

	if (isset($item->features) && is_array($item->features)
		&& (!empty($FEATURES_ICONSIZE_LIST) || !empty($FEATURES_ICONSIZE_EVENT)))
	{
		foreach ($item->features as $feature)
		{
			$FEATURES_ICONS[] = array('icon' => $feature->icon, 'icon_alt' => $feature->icon_alt);
		}
	}


	/**
	 *	Event Image and Thumbnails
	 */
	$EVENT_IMAGE			= $item->image;
	$EVENT_IMAGE_TAG		= $item->imageTag;

	$IMAGE_LARGE = $IMAGE_MEDIUM = $IMAGE_SMALL = $IMAGE_XSMALL = '';

	if ($EVENT_IMAGE)
	{
		$default_thumbnail = 'media/com_icagenda/images/nophoto.jpg';

		if (icagendaClass::isLoaded('icagendaThumb'))
		{
//			$IMAGE_LARGE			= icagendaThumb::sizeLarge($item->image, null, true);
			$IMAGE_MEDIUM			= ($ic_main_list) ? icagendaThumb::sizeMedium($item->image) : '';
//			$IMAGE_SMALL			= icagendaThumb::sizeSmall($item->image);
//			$IMAGE_XSMALL			= icagendaThumb::sizeXSmall($item->image);
			$IMAGE_LARGE_HTML		= ( ! $ic_main_list) ? icagendaThumb::sizeLarge($item->image, 'imgTag', true) : '';
//			$IMAGE_MEDIUM_HTML		= icagendaThumb::sizeMedium($item->image, 'imgTag');
//			$IMAGE_SMALL_HTML		= icagendaThumb::sizeSmall($item->image, 'imgTag');
//			$IMAGE_XSMALL_HTML		= icagendaThumb::sizeXSmall($item->image, 'imgTag');
		}
		else
		{
			$IMAGE_LARGE = $IMAGE_MEDIUM = $IMAGE_SMALL = $IMAGE_XSMALL = '';
			$IMAGE_LARGE_HTML = $IMAGE_MEDIUM_HTML = $IMAGE_SMALL_HTML = $IMAGE_XSMALL_HTML = '';
		}
	}


	/**
	 *	Event Details - Description, Meta-description and Intro Text
	 */
	$EVENT_DESC				= ($item->desc || $item->shortdesc) ? true : false;
//	$EVENT_DESCRIPTION		= $item->description;
	$EVENT_META				= $item->metaAsShortDesc;

	$desc_display_event = $params->get('desc_display_event', '');

	if ($desc_display_event == '1') // full desc
	{
		$EVENT_SHORTDESC	= false;
		$EVENT_DESCRIPTION	= $item->description ? $item->description : false;
	}
	elseif ($desc_display_event == '2') // short desc
	{
		$EVENT_SHORTDESC	= $item->shortDescription ? $item->shortDescription : false;
		$EVENT_DESCRIPTION	= false;
	}
	elseif ($desc_display_event == '3') // short and full desc
	{
		$EVENT_SHORTDESC	= $item->shortDescription ? $item->shortDescription : false;
		$EVENT_DESCRIPTION	= $item->description ? $item->description : false;
	}
	elseif ($desc_display_event == '0') // Hide
	{
		$EVENT_SHORTDESC	= false;
		$EVENT_DESC			= false;
		$EVENT_DESCRIPTION	= false;
	}
	else // Auto (First Full Description, if does not exist, will use Short Description if not empty)
	{
		$EVENT_SHORTDESC	= false;
		$EVENT_DESCRIPTION	= $item->description ? $item->description : $item->shortDescription;
	}


	/**
	 *	Events List - Intro Text
	 */
	$shortdesc_display_global = $params->get('shortdesc_display_global', '');
	$Filtering_ShortDesc_Global = JComponentHelper::getParams('com_icagenda')->get('Filtering_ShortDesc_Global', '');

	if ($shortdesc_display_global == '1') // short desc
	{
		$EVENT_DESCSHORT	= $item->shortdesc ? $item->shortdesc : false;

		if ($EVENT_DESCSHORT)
		{
			$EVENT_DESCSHORT	= empty($Filtering_ShortDesc_Global) ? '<i>' . $EVENT_DESCSHORT . '</i>' : $EVENT_DESCSHORT;
		}
	}
	elseif ($shortdesc_display_global == '2') // Auto-Introtext
	{
		$EVENT_DESCSHORT	= $item->descShort ? $item->descShort : false;
	}
	elseif ($shortdesc_display_global == '0') // Hide
	{
		$EVENT_DESCSHORT	= false;
	}
	else // Auto (First Short Description, if does not exist, Auto-generated short description from the full description. And if does not exist, will use meta description if not empty)
	{
		$short_description = $item->shortdesc ? $item->shortdesc : $item->descShort;

		$metaAsShortDesc = $item->metaAsShortDesc;

		if ($metaAsShortDesc)
		{
			$metaAsShortDesc	= empty($Filtering_ShortDesc_Global) ? '<i>' . $metaAsShortDesc . '</i>' : $metaAsShortDesc;
		}

		$EVENT_DESCSHORT	= $short_description ? $short_description : $metaAsShortDesc;
	}

	$EVENT_INTRO_TEXT = $EVENT_DESCSHORT; // New var name since 3.4.0


	/**
	 *	Custom Fields
	 */
	$CUSTOM_FIELDS	= $item->loadEventCustomFields;


	/**
	 *	Event Information
	 */
	$EVENT_INFOS			= $item->infoDetails;

	// All Dates ON
	if (
//		$get_date
//		&&
		$item->maxNbTickets
		&& $item->maxNbTickets != '1000000'
		)
	{
//		$SEATS_AVAILABLE	= (isset($dateday) && isset($item->totalRegistered))
		$SEATS_AVAILABLE	= isset($item->totalRegistered)
							? ($item->maxNbTickets - $item->totalRegistered)
							: '';

//		if (isset($dateday) && $SEATS_AVAILABLE === 0)
		if ($SEATS_AVAILABLE === 0)
		{
			$SEATS_AVAILABLE	= JText::_('COM_ICAGENDA_REGISTRATION_DATE_NO_TICKETS_LEFT');
		}

//		$MAX_NB_OF_SEATS	= (isset($dateday))
//							? $item->maxNbTickets
//							: false;
		$MAX_NB_OF_SEATS	= $item->maxNbTickets;
	}
	// All Dates ON
	else
	{
		$SEATS_AVAILABLE		= false;
		$MAX_NB_OF_SEATS		= false;
	}

	$EVENT_VENUE			= $params->get('venue_display_global') ? $item->place_name : false;
	$EVENT_CITY				= $params->get('city_display_global') ? $item->city : false;
	$EVENT_COUNTRY			= $params->get('country_display_global') ? $item->country : false;
	$EVENT_POSTAL_CODE		= $params->get('city_display_global') ? $item->city : false;

	$EVENT_PHONE			= $item->phone;
	$EVENT_EMAIL			= $item->email;
	$EVENT_EMAIL_CLOAKING	= $item->emailLink;
	$EVENT_WEBSITE			= $item->website;
	$EVENT_WEBSITE_LINK		= $item->websiteLink;
//	$EVENT_ADDRESS			= $item->address;

	/**
	 *	Event Address
	 */
	if ( ! $ic_main_list && $item->address)
	{
		// Create an array to separate all strings between comma in individual parts
		$EVENT_STREET		= $item->address;
		$ADDRESS_EX			= explode(',', $EVENT_STREET);

		$country_to_check	= ($EVENT_COUNTRY == 'United States') ? 'USA' : $EVENT_COUNTRY;
		$country_removed	= false;
		$city_removed		= false;

		$i = 0;
		$count_ADDRESS_EX = count($ADDRESS_EX);

		for ($i; $i < $count_ADDRESS_EX; $i++)
		{
			// Remove the country from the full address
			if ($EVENT_COUNTRY && ! $country_removed
				&& strpos($EVENT_STREET, $country_to_check) !== false)
			{
				$country_removed		= true;

				// Remove country
				$EVENT_STREET		= substr( $EVENT_STREET, 0, strripos( $EVENT_STREET, ',' ) );
			}
			elseif ($EVENT_CITY && ! $city_removed
				&& strpos($EVENT_STREET, $EVENT_CITY) !== false)
			{
				$city_removed		= true;

				// Remove last value, until city is not found in the string
				$EVENT_STREET = substr( $EVENT_STREET, 0, strripos( $EVENT_STREET, ',' ) );
			}
		}

		if ($EVENT_STREET && $EVENT_POSTAL_CODE)
		{
			$EVENT_POSTAL_CODE = str_replace($EVENT_STREET . ', ', '', $item->address);
			$EVENT_POSTAL_CODE = substr( $EVENT_POSTAL_CODE, 0, strripos( $EVENT_POSTAL_CODE, ',' ) );
		}

		$EVENT_ADDRESS = $EVENT_STREET ? $EVENT_STREET . '<br />' : '';

		if ($EVENT_CITY && $EVENT_COUNTRY && $EVENT_POSTAL_CODE)
		{
			$EVENT_ADDRESS.= $EVENT_POSTAL_CODE . ', ' . $EVENT_COUNTRY . '<br />';
		}
		elseif ($EVENT_CITY && !$EVENT_COUNTRY && $EVENT_POSTAL_CODE)
		{
			$EVENT_ADDRESS.= $EVENT_POSTAL_CODE . '<br />';
		}
		elseif (!$EVENT_CITY && $EVENT_COUNTRY)
		{
			$EVENT_ADDRESS.= $EVENT_COUNTRY . '<br />';
		}
	}
	else
	{
		$EVENT_ADDRESS = false;
	}


	$GOOGLEMAPS_COORDINATES	= $item->coordinate;
	$EVENT_MAP				= $item->map;

	$EVENT_SINGLE_DATES		= $item->datelistUl;
	$EVENT_PERIOD			= $item->periodDates;

	$PARTICIPANTS_DISPLAY	= $item->participantList;
	$PARTICIPANTS_HEADER	= $item->participantListTitle;
	$EVENT_PARTICIPANTS		= $item->registeredUsers;

	$EVENT_ATTACHEMENTS		= $item->file;
	$EVENT_ATTACHEMENTS_TAG	= $item->fileTag;

	$CATEGORY_TITLE			= $item->cat_title;
	$CATEGORY_COLOR			= $item->cat_color;
	$CATEGORY_FONTCOLOR		= $item->fontColor;


	/**
	 *	Add Event Info from plugins (if exists)
	 */
	$onListAddEventInfo = $this->dispatcher->trigger('onListAddEventInfo', array('com_icagenda.list', &$item, &$this->params));

	$IC_LIST_ADD_EVENT_INFO = '';

	foreach ($onListAddEventInfo as $added_info)
	{
		$IC_LIST_ADD_EVENT_INFO.= '<div class="ic-list-add-event-info">' . $added_info . '</div>';
	}

