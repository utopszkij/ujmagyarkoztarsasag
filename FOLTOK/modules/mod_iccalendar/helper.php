<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda - mod_iccalendar
 * @copyright   Copyright (c)2012-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C) - doorknob
 * @link        http://www.joomlic.com
 *
 * @version 	3.5.7 2015-07-14
 * @since       3.1.9 (1.0)
 *------------------------------------------------------------------------------
*/

/**
 *	iCagenda - iC calendar
 */


// No direct access to this file
defined('_JEXEC') or die();

jimport('joomla.methods');
jimport('joomla.environment.request');
jimport('joomla.application.component.helper');

// Module Class
class modiCcalendarHelper
{
	private function construct($params)
	{
		$this->modid				= $params->get('id');
		$this->template				= $params->get('template');
		$this->format				= $params->get('format');
		$this->date_separator		= $params->get('date_separator');
		$this->setTodayTimezone		= $params->get('setTodayTimezone');
		$this->displayDatesTimezone	= $params->get('displayDatesTimezone');
		$this->filtering_shortDesc	= $params->get('filtering_shortDesc', '');
		$this->catid				= $params->get('mcatid');
		$this->number				= $params->get('number');
		$this->onlyStDate			= $params->get('onlyStDate');
		$this->firstMonth			= $params->get('firstMonth', null);
		$this->month_nav			= $params->get('month_nav', '1');
		$this->year_nav				= $params->get('year_nav', '1');

//		$linkid						= JRequest::getInt('Itemid');
		$this->itemid				= JRequest::getInt('Itemid');
		$this->mod_iccalendar		= '#mod_iccalendar_' . $this->modid;

		// Get media path
		$params_media				= JComponentHelper::getParams('com_media');
		$image_path					= $params_media->get('image_path', 'images');

		// Features Options
		$this->features_icon_size	= $params->get('features_icon_size');
		$this->show_icon_title		= $params->get('show_icon_title');
		$this->features_icon_root	= JURI::base() . "{$image_path}/icagenda/feature_icons/{$this->features_icon_size}/";

		// First day of the current month
		$this_month	= $this->firstMonth
					? date("Y-m-d", strtotime("+1 month", strtotime($this->firstMonth)))
					: JHtml::date('now', 'Y-m-01', null);

		$iccaldate					= JRequest::getVar('iccaldate', ''); // Get date set in month/year navigation

		// This should be the first day of a month
		$date_start = $iccaldate ? date('Y-m-01', strtotime($iccaldate)) : $this_month;

		// Add filter to restrict the number of events using the 'next' date
		if ($date_start > $this_month)
		{
			// Month to be displayed is in the future
			// Events required start from the current month
			$filter_start = $this_month;
		}
		else
		{
			// Month to be displayed is current or past
			// Events required start from the display month
			$filter_start = $date_start;
		}

		$this->date_start = $date_start;

		$this->addFilter('e.next', '' . $filter_start . '', '>=');

		// An end date for selection is not possible because it may prevent display of past events where the next
		// scheduled instance of an event is after the end of the display month
//		$filter_end = date('Y-m-d', strtotime('+1 month', strtotime($this->date_start)));
//		$this->addFilter('e.next', "'$filter_end'",'<');

		// Get Array of categories to be displayed
		if (isset($this->catid)
			&& ! empty($this->catid))
		{
			$cat_filter_param = $this->catid;

			if ( ! is_array($cat_filter_param))
			{
				$catFilter = array($cat_filter_param);
			}
			else
			{
				$catFilter = $cat_filter_param;
			}

			$cats_option = implode(', ', $catFilter);

			if ($catFilter != array(0))
			{
				$this->addFilter('e.catid', '(' . $cats_option . ')', ' IN ');
			}
		}
	}


	function start($params)
	{
		$this->construct($params);
	}


	function addFilter($key, $var, $for = NULL)
	{
		$for = ($for == NULL) ? '=' : $for;

		$this->filter[] = $key . $for . $var;
	}


	// Class Method
	function getStamp($params)
	{
		$iCparams		= JComponentHelper::getParams('com_icagenda');
		$eventTimeZone	= null;

		// Itemid Request (automatic detection of the first iCagenda menu-link, by menuID)
		$iC_list_menus	= icagendaMenus::iClistMenuItemsInfo();
		$nb_menu		= count($iC_list_menus);
		$nolink			= $nb_menu ? false : true;

		$app			= JFactory::getApplication();
		$menu			= $app->getMenu();
		$isSef			= $app->getCfg( 'sef' );
		$date_var		= ($isSef == 1) ? '?date=' :'&amp;date=';

		// Check if GD is enabled on the server
		if (extension_loaded('gd') && function_exists('gd_info'))
		{
			$thumb_generator = $iCparams->get('thumb_generator', 1);
		}
		else
		{
			$thumb_generator = 0;
		}

		$datetime_today	= JHtml::date('now', 'Y-m-d H:i');
		$timeformat		= $iCparams->get('timeformat', 1);
		$lang_time		= ($timeformat == 1) ? 'H:i' : 'h:i A';

		// Check if fopen is allowed
		$result	= ini_get('allow_url_fopen');
		$fopen	= empty($result) ? false : true;

		$this->start($params);

		// Get the database
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		// Build the query
		$query->select('e.*,
				e.place as place_name,
				c.title as cat_title,
				c.alias as cat_alias,
				c.color as cat_color,
				c.ordering as cat_order
			')
    		->from($db->qn('#__icagenda_events').' AS e')
			->leftJoin($db->qn('#__icagenda_category').' AS c ON '.$db->qn('c.id').' = '.$db->qn('e.catid'));

		//+FT li-de témakör láthatóság ellenörzés
		$user = JFactory::getUser();
		$query->leftJoin('#__szavazasok as lidesz on e.alias like concat("sz-", lidesz.id,"-%")');
		$query->leftJoin('#__temakorok as lidet on lidet.id = lidesz.temakor_id');
		$query->leftJoin('#__tagok as lideta on lideta.temakor_id = lidesz.temakor_id and lideta.user_id = "'.$user->id.'"');
		$query->where('((lidet.lathatosag = 0) or
		(lidet.lathatosag = 1 and "'.$user->id.'" > 0) or
		(lidet.lathatosag = 2 and lideta.user_id is not null) 
		)');
		//+FT li-de témakör láthatóság ellenörzés



			// Where Category is Published
		$query->where('c.state = 1');

		// Where State is Published
		$query->where('e.state = 1');

		// Where event is Approved
		$query->where('e.approval = 0');

		// Add filters
		if (isset($this->filter))
		{
			foreach ($this->filter as $filter)
			{
				$query->where($filter);
			}
		}

		// Check Access Levels
		$user		= JFactory::getUser();
		$userID		= $user->id;
		$userLevels	= $user->getAuthorisedViewLevels();

		if (version_compare(JVERSION, '3.0', 'lt'))
		{
			$userGroups = $user->getAuthorisedGroups();
		}
		else
		{
			$userGroups = $user->groups;
		}

		$userAccess = implode(', ', $userLevels);

		if (!in_array('8', $userGroups))
		{
			$query->where('e.access IN (' . $userAccess . ')');
		}

		// Features - extract the number of displayable icons per event
		$query->select('feat.count AS features');
		$sub_query = $db->getQuery(true);
		$sub_query->select('fx.event_id, COUNT(*) AS count');
		$sub_query->from('`#__icagenda_feature_xref` AS fx');
		$sub_query->innerJoin("`#__icagenda_feature` AS f ON fx.feature_id=f.id AND f.state=1 AND f.icon<>'-1'");
		$sub_query->group('fx.event_id');
		$query->leftJoin('(' . (string) $sub_query . ') AS feat ON e.id=feat.event_id');

		// Registrations total
		$query->select('r.count AS registered, r.date AS reg_date');
		$sub_query = $db->getQuery(true);
		$sub_query->select('r.eventid, sum(r.people) AS count, r.date AS date');
		$sub_query->from('`#__icagenda_registration` AS r');
		$sub_query->where('r.state > 0');
		$sub_query->group('r.eventid');
		$query->leftJoin('(' . (string) $sub_query . ') AS r ON e.id=r.eventid');
		
		// Run the query
		$db->setQuery($query);

		// Invoke the query
		$result = $db->loadObjectList();

		$registrations = icagendaEventsData::registeredList();

		foreach ($result AS $record)
		{
			$record_registered = array();

			foreach ($registrations AS $reg_by_event)
			{
				$ex_reg_by_event = explode('@@', $reg_by_event);

				if ($ex_reg_by_event[0] == $record->id)
				{
					$record_registered[] = $ex_reg_by_event[0] . '@@' . $ex_reg_by_event[1] . '@@' . $ex_reg_by_event[2];
				}
			}

			$record->registered = $record_registered;
		}

		// Set start/end dates of the current month
		$current_date_start	= $this->date_start;
		$month_start		= date('m', strtotime($current_date_start));
		$month_end			= date('m', strtotime("+1 month", strtotime($current_date_start)));

		$year_end			= ($month_start == '12')
							? date('Y', strtotime("+1 year", strtotime($this->date_start)))
							: date('Y', strtotime($this->date_start));

		$current_date_end	= $year_end . '-' . $month_end . '-01';

		$days = $this->getDays($this->date_start, 'Y-m-d H:i');

		$total_items		= 0;
		$displayed_items	= 0;

		foreach ($result as $item)
		{
			// Extract the feature details, if needed
			$features = array();

			if (is_null($item->features) || empty($this->features_icon_size))
			{
				$item->features = array();
			}
			else
			{
				$item->features = icagendaEvents::featureIcons($item->id);
			}

			if (isset($item->features) && is_array($item->features))
			{
				foreach ($item->features as $feature)
				{
					$features[] = array('icon' => $feature->icon, 'icon_alt' => $feature->icon_alt);
				}
			}

			// list calendar dates
			$AllDates = array();

			$next = isset($next) ? $next : '';

			$allSingleDates_array = $this->getDatelist($item->dates, $next);

			// If Single Dates, added to all dates for this event
			if (isset($datemultiplelist)
				&& $datemultiplelist != NULL
				&& is_array($datemultiplelist))
			{
				$allSingleDates_array = array_merge($AllDates, $datemultiplelist);
			}

			foreach ($allSingleDates_array as $sd)
			{
				$this_date = JHtml::date($sd, 'Y-m-d', null);

				if (strtotime($this_date) >= strtotime($current_date_start)
					&& strtotime($this_date) < strtotime($current_date_end))
				{
					array_push($AllDates, $sd);
				}
			}

			// Get WeekDays Array
			$WeeksDays			= iCDatePeriod::weekdaysToArray($item->weekdays);

			// Get Period Dates
			$StDate				= JHtml::date($item->startdate, 'Y-m-d H:i', $eventTimeZone);
			$EnDate				= JHtml::date($item->enddate, 'Y-m-d H:i', $eventTimeZone);
			$perioddates		= iCDatePeriod::listDates($item->startdate, $item->enddate, $eventTimeZone);

			$onlyStDate			= isset($this->onlyStDate) ? $this->onlyStDate : '';

			// Check the period if individual dates
			$only_startdate		= ($item->weekdays || $item->weekdays == '0') ? false : true;

//			if (isset($perioddates) && $perioddates != NULL)
//			{
				if ($onlyStDate == 1)
				{
					if (strtotime($StDate) >= strtotime($current_date_start)
						&& strtotime($StDate) < strtotime($current_date_end))
					{
						array_push($AllDates, date('Y-m-d H:i', strtotime($item->startdate)));
					}
				}
				else
				{
					foreach ($perioddates as $Dat)
					{
						$this_date = JHtml::date($Dat, 'Y-m-d', null);

						if (in_array(date('w', strtotime($Dat)), $WeeksDays))
						{
							$SingleDate = date('Y-m-d H:i', strtotime($Dat));

							if (strtotime($this_date) >= strtotime($current_date_start)
								&& strtotime($this_date) < strtotime($current_date_end))
							{
								array_push($AllDates, $SingleDate);
							}
						}
					}
				}
//			}

			rsort($AllDates);


			// requête Itemid
			$iCmenuitem = $params->get('iCmenuitem', '');

			if (is_numeric($iCmenuitem))
			{
				$linkid = $iCmenuitem;
			}
			else
			{
				$linkid = icagendaMenus::thisEventItemid($item->next, $item->catid);
			}

			$eventnumber	= $item->id ? $item->id : null;
			$event_slug		= $item->alias ? $item->id . ':' . $item->alias : $item->id;

			$total_items = $total_items + 1;

			if ( $linkid
				&& ! $nolink
				&& JComponentHelper::getComponent('com_icagenda', true)->enabled
				)
			{
				$displayed_items = $displayed_items + 1;
				$urlevent = JRoute::_('index.php?option=com_icagenda&amp;view=list&amp;layout=event&amp;id=' . $event_slug . '&amp;Itemid=' . (int)$linkid);
			}
			else
			{
				$urlevent = '#';
			}

			$descShort = icagendaEvents::shortDescription($item->desc, true, $this->filtering_shortDesc);


			/**
			 * Get Thumbnail
			 */

			// START iCthumb

			// Set if run iCthumb
			if ($item->image
				&& $thumb_generator == 1)
			{
				// Generate small thumb if not exist
				$thumb_img = icagendaThumb::sizeSmall($item->image);
			}
			elseif ($item->image
				&& $thumb_generator == 0)
			{
				$thumb_img = $item->image;
			}
			else
			{
				$thumb_img = $item->image ? 'media/com_icagenda/images/nophoto.jpg' : '';
			}

			// END iCthumb



			$evtParams = '';
			$evtParams = new JRegistry($item->params);

			// Display Time
			$r_time			= $params->get('dp_time', 1) ? true : false;

			// Display City
			$r_city			= $params->get('dp_city', 1) ? $item->city : false;

			// Display Country
			$r_country		= $params->get('dp_country', 1) ? $item->country : false;

			// Display Venue Name
			$r_place		= $params->get('dp_venuename', 1) ? $item->place_name : false;

			// Display Intro Text
			$dp_shortDesc	= $params->get('dp_shortDesc', '');

			// Short Description
			if ($dp_shortDesc == '1')
			{
				$descShort		= $item->shortdesc ? $item->shortdesc : false;
			}
			// Auto-Introtext
			elseif ($dp_shortDesc == '2')
			{
				$descShort		= $descShort ? $descShort : false;
			}
			// Hide
			elseif ($dp_shortDesc == '0')
			{
				$descShort		= false;
			}
			// Auto (First Short Description, if does not exist, Auto-generated short description from the full description. And if does not exist, will use meta description if not empty)
			else
			{
				$e_shortdesc	= $item->shortdesc ? $item->shortdesc : $descShort;
				$descShort		= $e_shortdesc ? $e_shortdesc : $item->metadesc;
			}

			// Display Registration Infos
			$dp_regInfos	= $params->get('dp_regInfos', 1);

			$maxTickets		= ($dp_regInfos == 1) ? $evtParams->get('maxReg', '1000000') : false;
			$typeReg		= ($dp_regInfos == 1) ? $evtParams->get('typeReg', '1') : false;

			$event = array(
				'id'					=> (int)$item->id,
				'Itemid'				=> (int)$linkid,
				'title'					=> $item->title,
				'next'					=> $this->formatDate($item->next),
				'image'					=> $thumb_img,
				'file'					=> $item->file,
				'address'				=> $item->address,
				'city'					=> $r_city,
				'country'				=> $r_country,
				'place'					=> $r_place,
				'description'			=> $item->desc,
				'descShort'				=> $descShort,
				'cat_title'				=> $item->cat_title,
				'cat_order'				=> $item->cat_order,
				'cat_color'				=> $item->cat_color,
				'nb_events'				=> count($item->id),
				'no_image'				=> JTEXT::_('MOD_ICCALENDAR_NO_IMAGE'),
				'params'				=> $item->params,
				'features_icon_size'	=> $this->features_icon_size,
				'features_icon_root'	=> $this->features_icon_root,
				'show_icon_title'		=> $this->show_icon_title,
				'features'				=> $features,
				'item'					=> $item,
			);

			// Access Control
			$access			= $item->access ? $item->access : '1';

			// Language Control
			$languages		= array(JFactory::getLanguage()->getTag(), '*');
			$eventLang		= isset($item->language) ? $item->language : '*';

			// Get Option Dislay Time
			$displaytime	= isset($item->displaytime) ? $item->displaytime : '';

			$events_per_day	= array();

			// Get List of Dates
			if ((in_array($access, $userLevels) || in_array('8', $userGroups))
				&& in_array($eventLang, $languages)
				&& is_array($event)
				&& $linkid
				)
			{
				foreach ($AllDates as $d)
				{
					$next_date_control	= date('Y-m-d H:i', strtotime($d));

					if ($only_startdate && in_array($next_date_control, $perioddates))
					{
						$set_date_in_url = '';
					}
					else
					{
						$set_date_in_url = $date_var . iCDate::dateToAlias($d, 'Y-m-d H:i');
					}

					if ($r_time)
					{
						$time = array(
							'time'			=> date($lang_time, strtotime($d)),
							'displaytime'	=> $displaytime,
							'url'			=> $urlevent . $set_date_in_url
						);
					}
					else
					{
						$time = array(
							'time'			=> '',
							'displaytime'	=> '',
							'url'			=> $urlevent . $set_date_in_url
						);
					}

					$event = array_merge($event, $time);

					$this_date = $item->reg_date ? date('Y-m-d H:i:s', strtotime($d)) : 'period';

					$registrations	= ($dp_regInfos == 1) ? true : false;
					$registered		= ($dp_regInfos == 1)
									? self::getNbTicketsBooked($this_date, $item->registered, $eventnumber, $set_date_in_url)
									: false;
					$maxTickets		= ($maxTickets != '1000000') ? $maxTickets : false;
					$TicketsLeft	= ($dp_regInfos == 1 && $maxTickets)
									? ($maxTickets - self::getNbTicketsBooked($this_date, $item->registered, $eventnumber, $set_date_in_url))
									: false;

					// If period started, and registration is set to "for all dates of the event"
					if ($maxTickets
						&& strtotime($item->startdate) < strtotime($datetime_today)
						&& $typeReg == 2
						)
					{
						$date_sold_out	= JText::_('MOD_ICCALENDAR_REGISTRATION_CLOSED');
					}
					elseif ($maxTickets)
					{
						$date_sold_out	= ($TicketsLeft <= 0) ? JText::_('MOD_ICCALENDAR_REGISTRATION_DATE_NO_TICKETS_LEFT') : false;
					}
					else
					{
						$date_sold_out	= false;
					}

					$reg_infos = array(
						'registrations'	=> $registrations,
						'registered'	=> $registered,
						'maxTickets'	=> $maxTickets,
						'TicketsLeft'	=> $TicketsLeft,
						'date_sold_out'	=> $date_sold_out
					);

					$event = array_merge($event, $reg_infos);

					foreach ($days as $k => $dy)
					{
						$d_date		= JHtml::date($d, 'Y-m-d', $eventTimeZone);
						$dy_date	= date('Y-m-d', strtotime($dy['date']));

						if ($d_date == $dy_date)
						{
							array_push ($days[$k]['events'], $event);
						}
					}
				}
			}
		}

		$i = '';

		if ($nolink || !JComponentHelper::getComponent('com_icagenda', true)->enabled)
		{
			do {
				echo '<div style="color:#a40505; text-align: center;"><b>info :</b></div><div style="color:#a40505; font-size: 0.8em; text-align: center;">'.JText::_( 'MOD_ICCALENDAR_COM_ICAGENDA_MENULINK_UNPUBLISHED_MESSAGE' ).'</div>';
			} while ($i > 0);
  		}

		$db = JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('id AS nbevt')->from('`#__icagenda_events` AS e')->where('e.state > 0');
		$db->setQuery($query);
		$nbevt = $db->loadResult();
		$nbevt = count($nbevt);

		$no_event_message = '<div class="ic-msg-no-event">' . JText::_('MOD_ICCALENDAR_NO_EVENT') . '</div>';

		if ($nbevt == NULL)
		{
			echo $no_event_message;
  		}

		$total_items = count($result);

		if ($displayed_items == '0'
			&& $total_items > 0)
		{
			echo $no_event_message;
		}

		if ($total_items > $displayed_items)
		{
			$not_displayed = ($total_items - $displayed_items);
			$user = JFactory::getUser();

			if ($user->authorise('core.admin'))
			{
				echo '<div class="alert alert-warning">' . JText::sprintf('IC_MODULE_ALERT_EVENTS_NOT_DISPLAYED', $not_displayed) . '</div>';
			}
		}

		return $days;

	}

	public static function getNbTicketsBooked($date, $event_registered, $event_id, $set_date_in_url)
	{
		$event_registered	= is_array($event_registered) ? $event_registered : array();
		$nb_registrations	= 0;

		foreach ($event_registered AS $reg)
		{
			$ex_reg = explode('@@', $reg); // eventid@@date@@people

			if ( ! $date || $date == 'period')
			{
				$nb_registrations = $nb_registrations + $ex_reg[2];
			}
			elseif (date('Y-m-d H:i', strtotime($date)) == date('Y-m-d H:i', strtotime($ex_reg[1])))
			{
				$nb_registrations = $nb_registrations + $ex_reg[2];
			}
			elseif ( ! $set_date_in_url && $ex_reg[1] == 'period' && $event_id == $ex_reg[0])
			{
				$nb_registrations = $nb_registrations + $ex_reg[2];
			}
		}

		return $nb_registrations;
	}


	// Function to get Format Date (using option format, and translation)
	protected function formatDate($date)
	{
		// Date Format Option (Global Component Option)
		$date_format_global	= JComponentHelper::getParams('com_icagenda')->get('date_format_global', 'Y - m - d');
		$date_format_global	= ($date_format_global != 0) ? $date_format_global : 'Y - m - d'; // Previous 3.5.6 setting

		// Date Format Option (Module Option)
		$date_format_module	= isset($this->format) ? $this->format : '';
		$date_format_module	= ($date_format_module != 0) ? $date_format_module : ''; // Previous 3.5.6 setting

		// Set Date Format option to be used
		$format				= $date_format_module ? $date_format_module : $date_format_global;

		// Separator Option
		$separator			= isset($this->date_separator) ? $this->date_separator : ' ';

		if ( ! is_numeric($format))
		{
			// Update old Date Format options of versions before 2.1.7
			$format = str_replace(array('nosep', 'nosep', 'sepb', 'sepa'), '', $format);
			$format = str_replace('.', ' .', $format);
			$format = str_replace(',', ' ,', $format);
		}

		$dateFormatted = iCGlobalize::dateFormat($date, $format, $separator, false);

		return $dateFormatted;
	}


	// Function to get TimeZone offset
	function get_timezone_offset($remote_tz, $origin_tz = null)
	{
		if ($origin_tz === null)
		{
			if (!is_string($origin_tz = date_default_timezone_get()))
			{
				return false; // A UTC timestamp was returned -- bail out!
			}
		}

		$origin_dtz	= new DateTimeZone($origin_tz);
		$remote_dtz	= new DateTimeZone($remote_tz);
		$origin_dt	= new DateTime("now", $origin_dtz);
		$remote_dt	= new DateTime("now", $remote_dtz);
		$offset		= $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);

		return $offset;
	}


	// Generate the days of the month
	function getDays($d, $f)
	{
		$lang = JFactory::getLanguage();
		$eventTimeZone = null;

		// Set Nb of days for the current month in Jalali/Persian calendar
		if ($lang->getTag() == 'fa-IR')
		{
			$date_to_persian	= $d;
			$persian_month		= date('m', strtotime($date_to_persian));
			$persian_year		= date('Y', strtotime($date_to_persian));
			$leap_year			= fa_IRDate::leap_persian($persian_year);

			if ($persian_month < 7)
			{
				$days = 31;
			}
			elseif ($persian_month == 12)
			{
				$days = $leap_year ? 30 : 29;
			}
			else
			{
				$days = 30;
			}
		}
		else
		{
			$days = date("t", strtotime($d));
		}

		// Set Month and Year
		$ex_data	= explode('-', $d);
		$month		= $ex_data[1];
		$year		= $ex_data[0];
		$jour		= $ex_data[2];

		$list = array();

		//
		// Setting function of the visitor Time Zone
		//
		$today = time();

		$config			= JFactory::getConfig();
		$joomla_offset	= $config->get('offset');

		$displayDatesTimezone = '0'; // Option not active

		$opt_TimeZone = isset($this->setTodayTimezone) ? $this->setTodayTimezone : '';

		$gmt_today			= gmdate('Y-m-d H:i:s', $today);
		$today_timestamp	= strtotime($gmt_today);
		$GMT_timezone		= 'Etc/UTC';

		if ($opt_TimeZone == 'SITE')
		{
			// Joomla Server Time Zone
			$visitor_timezone	= $joomla_offset;
			$offset				= $this->get_timezone_offset($GMT_timezone, $visitor_timezone);
			$visitor_today		= JHtml::date(($today_timestamp+$offset), 'Y-m-d H:i:s', null);
			$UTCsite			= $offset / 3600;

			if ($UTCsite > 0) $UTCsite = '+'.$UTCsite;

			if ($displayDatesTimezone == '1')
			{
				echo '<small>' . JHtml::date('now', 'Y-m-d H:i:s', true) . ' UTC' . $UTCsite . '</small><br />';
			}
		}
		elseif ($opt_TimeZone == 'UTC')
		{
			// UTC Time Zone
			$offset			= 0;
			$visitor_today = JHtml::date(($today_timestamp+$offset), 'Y-m-d H:i:s', null);
			$UTC			= $offset / 3600;

			if ($UTC > 0) $UTC = '+'.$UTC;

			if ($displayDatesTimezone == '1')
			{
				echo '<small>' . gmdate('Y-m-d H:i:s', $today) . ' UTC' . $UTC . '</small><br />';
			}
		}
		else
		{
			$visitor_today = JHtml::date(($today_timestamp), 'Y-m-d H:i:s', null);
		}

		$date_today	= str_replace(' ', '-', $visitor_today);
		$date_today	= str_replace(':', '-', $date_today);
		$ex_data	= explode('-', $date_today);
		$v_month	= $ex_data[1];
		$v_year		= $ex_data[0];
		$v_day		= $ex_data[2];
		$v_hours	= $ex_data[3];
		$v_minutes	= $ex_data[4];

		for ($a = 1; $a <= $days; $a++)
		{
			$calday = $a;

			$this_date_a = $year . '-' . $month . '-' . $a;

			if (($a == $v_day) && ($month == $v_month) && ($year == $v_year))
			{
				$classDay = 'style_Today';
			}
			else
			{
				$classDay = 'style_Day';
			}

			$datejour			= date('Y-m-d', strtotime($this_date_a));
			$this_year_month	= $year . '-' . $month . '-00';
			$list_a_date		= date('Y-m-d H:i', strtotime($this_date_a));

			// Set Date in tooltip header
			$list[$calday]['dateTitle']		= $this->formatDate($datejour);

//			$list[$calday]['datecal']		= JHtml::date($this_date_a, 'j', null);
//			$list[$calday]['monthcal']		= JHtml::date($this_date_a, 'm', null);
//			$list[$calday]['yearcal']		= JHtml::date($this_date_a, 'Y', null);

			$list[$calday]['date']			= date('Y-m-d H:i', strtotime($this_date_a));

//			$list[$calday]['dateFormat']	= strftime($f, strtotime($this_date_a));
			$list[$calday]['week']			= date('N', strtotime($this_date_a));
			$list[$calday]['day']			= '<div class="' . $classDay . '">' . $a . '</div>';

			// Set cal_date
			$list[$calday]['this_day']		= date('Y-m-d', strtotime($this_date_a));

			// Added in 2.1.2 (change in NAME_day.php)
			$list[$calday]['ifToday']		= $classDay;
			$list[$calday]['Days']			= $a;

			// Set event array
			$list[$calday]['events']		= array();
		}

		return $list;
	}
	/***/

	/**
	 * Single Dates list for one event
	 */
	private function getDatelist($dates, $next)
	{
		$dates	= iCString::isSerialized($dates) ? unserialize($dates) : array();
		$da		= array();

		foreach ($dates as $d)
		{
			if (strtotime($d) >= strtotime($next) && iCDate::isDate($d))
			{
				array_push($da, date('Y-m-d H:i', strtotime($d)));
			}
		}

		return $da;
	}


	/** Systeme de navigation **/
	function getNav($date_start, $modid)
	{
		$app	= JFactory::getApplication();
		$isSef	= $app->getCfg( 'sef' );

		// Return Current URL
		$url	= JUri::getInstance()->toString() . '#tag';
		$url	= preg_replace('/&iccaldate=[^&]*/', '', $url);
		$url	= preg_replace('/\?iccaldate=[^\?]*/', '', $url);

		// Set Separator for Navigation Var
		$separator = strpos($url, '?') !== false ? '&amp;' : '?';

		// Remove fragment (hashtag could be added by a third party extension, eg. nonumber framework)
		$parsed_url	= parse_url($url);
		$fragment	= isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';

		$url	= str_replace($fragment, '', $url);

		// Return Current URL Filtered
		$url	= htmlspecialchars($url);

		// Start Date
		$ex_date	= explode('-', $date_start);
		$year		= $ex_date[0];
		$month		= $ex_date[1];
		$day		= 1;

		if ($month != 1)
		{
			$backMonth = $month-1;
			$backYear = $year;
		}
		elseif ($month == 1)
		{
			$backMonth = 12;
			$backYear = $year-1;
		}

		if ($month != 12)
		{
			$nextMonth = $month+1;
			$nextYear = $year;
		}
		elseif ($month == 12)
		{
			$nextMonth = 1;
			$nextYear = $year+1;
		}

		$backYYear = $year-1;
		$nextYYear = $year+1;

		// Create Navigation Arrows
		$classBackYear	= 'backicY icagendabtn_' . $modid;
		$urlBackYear	= $url . $separator . 'iccaldate=' . $backYYear . '-' . $month . '-' . $day;
		$iconBackYear	= '<span class="iCicon iCicon-backicY"></span>';

		$backY	= '<a class="' . $classBackYear . '" href="' . $urlBackYear . '" rel="nofollow">' . $iconBackYear . '</a>';

		$classBackMonth	= 'backic icagendabtn_' . $modid;
		$urlBackMonth	= $url . $separator . 'iccaldate=' . $backYear . '-' . $backMonth . '-' . $day;
		$iconBackMonth	= '<span class="iCicon iCicon-backic"></span>';

		$back	= '<a class="' . $classBackMonth . '" href="' . $urlBackMonth . '" rel="nofollow">' . $iconBackMonth . '</a>';

		$classNextMonth	= 'nextic icagendabtn_' . $modid;
		$urlNextMonth	= $url . $separator . 'iccaldate=' . $nextYear . '-' . $nextMonth . '-' . $day;
		$iconNextMonth	= '<span class="iCicon iCicon-nextic"></span>';

		$next	= '<a class="' . $classNextMonth . '" href="' . $urlNextMonth . '" rel="nofollow">' . $iconNextMonth . '</a>';

		$classNextYear	= 'nexticY icagendabtn_' . $modid;
		$urlNextYear	= $url . $separator . 'iccaldate=' . $nextYYear . '-' . $month . '-' . $day;
		$iconNextYear	= '<span class="iCicon iCicon-nexticY"></span>';

		$nextY	= '<a class="' . $classNextYear . '" href="' . $urlNextYear . '" rel="nofollow">' . $iconNextYear . '</a>';

		if ( ! $this->month_nav) $back = $next = '';
		if ( ! $this->year_nav) $backY = $nextY = '';

		/** translate the month in the calendar module -- Leland Vandervort **/
		$dateFormat = date('Y-m-d', strtotime($date_start));

		// split out the month and year to obtain translation key for JText using joomla core translation
		$t_day		= strftime("%d", strtotime("$dateFormat"));
		$t_month	= date('F', strtotime($dateFormat));
		$t_year		= strftime("%Y", strtotime("$dateFormat"));

		$lang		= JFactory::getLanguage();
		$langTag	= $lang->getTag();

		$yearBeforeMonth = array('ar-AA', 'ja-JP');

		$monthBeforeYear = in_array($langTag, $yearBeforeMonth) ? 0 : 1;

		/**
		 * Get prefix, suffix and separator for month and year in calendar title
		 */

		// Separator Month/Year
		$separator_month_year = JText::_('SEPARATOR_MONTH_YEAR');
		if ($separator_month_year == 'CALENDAR_SEPARATOR_MONTH_YEAR_FACULTATIVE')
		{
			$separator_month_year = ' ';
		}
		elseif ($separator_month_year == 'NO_SEPARATOR')
		{
			$separator_month_year = '';
		}

		// Prefix Month (Facultative)
		$prefix_month = JText::_('PREFIX_MONTH');
		if ($prefix_month == 'CALENDAR_PREFIX_MONTH_FACULTATIVE')
		{
			$prefix_month = '';
		}

		// Suffix Month (Facultative)
		$suffix_month = JText::_('SUFFIX_MONTH');
		if ($suffix_month == 'CALENDAR_SUFFIX_MONTH_FACULTATIVE')
		{
			$suffix_month = '';
		}

		// Prefix Year (Facultative)
		$prefix_year = JText::_('PREFIX_YEAR');
		if ($prefix_year == 'CALENDAR_PREFIX_YEAR_FACULTATIVE')
		{
			$prefix_year = '';
		}

		// Suffix Year (Facultative)
		$suffix_year = JText::_('SUFFIX_YEAR');
		if ($suffix_year == 'CALENDAR_SUFFIX_YEAR_FACULTATIVE')
		{
			$suffix_year = '';
		}

		$SEP	= $separator_month_year;
		$PM		= $prefix_month;
		$SM		= $suffix_month;
		$PY		= $prefix_year;
		$SY		= $suffix_year;

		// Get MONTH_CAL string or if not translated, use MONTHS
		$array_months = array(
			'JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE',
			'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER'
		);

		$cal_string			= $t_month . '_CAL';
		$missing_cal_string	= iCFilterOutput::stringToJText($cal_string);

		if ( in_array($missing_cal_string, $array_months) )
		{
			// if MONTHS_CAL strings not translated in current language, use MONTHS strings
			$month_J = JText::_( $t_month );
		}
		else
		{
			// Use MONTHS_CAL strings when translated in current language
			$month_J = JText::_( $t_month . '_CAL' );
		}

		// Set Calendar Title
		if ($monthBeforeYear == 0)
		{
			$title = $PY . $t_year . $SY . $SEP . $PM . $month_J . $SM;
		}
		else
		{
			$title = $PM . $month_J . $SM . $SEP . $PY . $t_year . $SY;
		}

		// Set Nav Bar for calendar
		$html = '<div class="icnav">' . $backY . $back . $nextY . $next;
		$html.= '<div class="titleic">' . $title . '</div>';
		$html.= '</div><div style="clear:both"></div>';

		return $html;
	}
}


class cal
{
	public $data;
	public $template;
	public $t_calendar;
	public $t_day;
	public $nav;
	public $fontcolor;
	private $header_text;

	function __construct ($data, $t_calendar, $t_day, $nav,
		$mon, $tue, $wed, $thu, $fri, $sat, $sun,
		$firstday,
		$calfontcolor, $OneEventbgcolor, $Eventsbgcolor, $bgcolor, $bgimage, $bgimagerepeat,
		$na, $nb, $nc, $nd, $ne, $nf, $ng,
		$moduleclass_sfx, $modid, $template, $ictip_ordering, $header_text)
	{
		$this->data				= $data;
		$this->t_calendar		= $t_calendar;
		$this->t_day			= $t_day;
		$this->nav				= $nav;
		$this->mon				= $mon;
		$this->tue				= $tue;
		$this->wed				= $wed;
		$this->thu				= $thu;
		$this->fri				= $fri;
		$this->sat				= $sat;
		$this->sun				= $sun;
		$this->na				= $na;
		$this->nb				= $nb;
		$this->nc				= $nc;
		$this->nd				= $nd;
		$this->ne				= $ne;
		$this->nf				= $nf;
		$this->ng				= $ng;
		$this->firstday			= $firstday;
		$this->calfontcolor		= $calfontcolor;
		$this->OneEventbgcolor	= $OneEventbgcolor;
		$this->Eventsbgcolor	= $Eventsbgcolor;
		$this->bgcolor			= $bgcolor;
		$this->bgimage			= $bgimage;
		$this->bgimagerepeat	= $bgimagerepeat;
		$this->moduleclass_sfx	= $moduleclass_sfx;
		$this->modid			= $modid;
		$this->template			= $template;
		$this->ictip_ordering	= $ictip_ordering;
		$this->header_text		= $header_text;
	}


	function days()
	{
		$this_calfontcolor	= str_replace(' ', '', $this->calfontcolor);
		$calfontcolor		= ! empty($this_calfontcolor) ? ' color:' . $this->calfontcolor . ';' : '';
		$this_bgcolor		= str_replace(' ', '', $this->bgcolor);
		$bgcolor			= ! empty($this_bgcolor) ? ' background-color:' . $this->bgcolor . ';' : '';
		$this_bgimage		= str_replace(' ', '', $this->bgimage);
		$bgimage			= ! empty($this_bgimage) ? ' background-image:url(\'' . $this->bgimage . '\');' : '';
		$this_bgimagerepeat	= str_replace(' ', '', $this->bgimagerepeat);
		$bgimagerepeat		= ! empty($this_bgimagerepeat) ? ' background-repeat:' . $this->bgimagerepeat . ';' : '';
		$iCcal_style		= '';

		if ( ! empty($this_calfontcolor)
			|| ! empty($this_bgcolor)
			|| ! empty($this_bgimage)
			|| ! empty($this_bgimagerepeat) )
		{
			$iCcal_style.= 'style="';
		}

		$iCcal_style.= $calfontcolor . $bgcolor . $bgimage;
		$iCcal_style.= ($this_bgimagerepeat && $this_bgimage) ? $bgimagerepeat : '';
		$iCcal_style.= (empty($this_bgcolor) && empty($this_bgimage)) ? ' background-color: transparent; background-image: none;' : '';
		$iCcal_style.= '"';

		// Verify Hex color strings
		$OneEventbgcolor	= preg_match('/^#[a-f0-9]{6}$/i', $this->OneEventbgcolor) ? $this->OneEventbgcolor : '';
		$Eventsbgcolor		= preg_match('/^#[a-f0-9]{6}$/i', $this->Eventsbgcolor) ? $this->Eventsbgcolor : '';


		echo '<div class="' . $this->template . ' iccalendar ' . $this->moduleclass_sfx . '" ' . $iCcal_style . ' id="' . $this->modid . '">';


		if ($this->firstday == '0')
		{
			echo '<div id="mod_iccalendar_' . $this->modid . '">
			<div class="icagenda_header">' . $this->header_text . '
			</div>' . $this->nav . '
			<table id="icagenda_calendar" style="width:100%;">
				<thead>
					<tr>
						<th style="width:14.2857143%;background:' . $this->sun . ';">' . JText::_('SUN') . '</th>
						<th style="width:14.2857143%;background:' . $this->mon . ';">' . JText::_('MON') . '</th>
						<th style="width:14.2857143%;background:' . $this->tue . ';">' . JText::_('TUE') . '</th>
						<th style="width:14.2857143%;background:' . $this->wed . ';">' . JText::_('WED') . '</th>
						<th style="width:14.2857143%;background:' . $this->thu . ';">' . JText::_('THU') . '</th>
						<th style="width:14.2857143%;background:' . $this->fri . ';">' . JText::_('FRI') . '</th>
						<th style="width:14.2857143%;background:' . $this->sat . ';">' . JText::_('SAT') . '</th>
					</tr>
				</thead>
		';
		}
		elseif ($this->firstday == '1')
		{
			echo '<div id="mod_iccalendar_' . $this->modid . '">
			<div class="icagenda_header">' . $this->header_text . '
			</div>' . $this->nav . '
			<table id="icagenda_calendar" style="width:100%;">
				<thead>
					<tr>
						<th style="width:14.2857143%;background:' . $this->mon . ';">' . JText::_('MON') . '</th>
						<th style="width:14.2857143%;background:' . $this->tue . ';">' . JText::_('TUE') . '</th>
						<th style="width:14.2857143%;background:' . $this->wed . ';">' . JText::_('WED') . '</th>
						<th style="width:14.2857143%;background:' . $this->thu . ';">' . JText::_('THU') . '</th>
						<th style="width:14.2857143%;background:' . $this->fri . ';">' . JText::_('FRI') . '</th>
						<th style="width:14.2857143%;background:' . $this->sat . ';">' . JText::_('SAT') . '</th>
						<th style="width:14.2857143%;background:' . $this->sun . ';">' . JText::_('SUN') . '</th>
					</tr>
				</thead>
		';
		}

		switch ($this->data[1]['week'])
		{
			case $this->na:
				break;
			default:
				echo '<tr><td colspan="' . ($this->data[1]['week']-$this->firstday) . '"></td>';
				break;
		}

		foreach ($this->data as $d)
		{
			$stamp = new day($d);

			if ($this->firstday == '0')
			{
				switch($stamp->week)
				{
					case $this->na:
						echo '<tr><td style="background:' . $this->sun . ';">';
						break;
					case $this->nb:
						echo '<td style="background:' . $this->mon . ';">';
						break;
					case $this->nc:
						echo '<td style="background:' . $this->tue . ';">';
						break;
					case $this->nd:
						echo '<td style="background:' . $this->wed . ';">';
						break;
					case $this->ne:
						echo '<td style="background:' . $this->thu . ';">';
						break;
					case $this->nf:
						echo '<td style="background:' . $this->fri . ';">';
						break;
					case $this->ng:
						echo '<td style="background:' . $this->sat . ';">';
						break;
					default:
						echo '<td>';
						break;
				}
			}

			if ($this->firstday == '1')
			{
				switch($stamp->week)
				{
					case $this->na:
						echo '<tr><td style="background:' . $this->mon . ';">';
						break;
					case $this->nb:
						echo '<td style="background:' . $this->tue . ';">';
						break;
					case $this->nc:
						echo '<td style="background:' . $this->wed . ';">';
						break;
					case $this->nd:
						echo '<td style="background:' . $this->thu . ';">';
						break;
					case $this->ne:
						echo '<td style="background:' . $this->fri . ';">';
						break;
					case $this->nf:
						echo '<td style="background:' . $this->sat . ';">';
						break;
					case $this->ng:
						echo '<td style="background:' . $this->sun . ';">';
						break;
					default:
						echo '<td>';
						break;
				}
			}

			$count_events = count($stamp->events);

			if ($OneEventbgcolor
				&& $OneEventbgcolor != ' '
				&& $count_events == '1')
			{
				$bg_day = $OneEventbgcolor;
			}
			elseif ($Eventsbgcolor
				&& $Eventsbgcolor != ' '
				&& $count_events > '1')
			{
				$bg_day = $Eventsbgcolor;
			}
			else
			{
				$bg_day = isset($stamp->events[0]['cat_color']) ? $stamp->events[0]['cat_color'] : '#d4d4d4';
			}

			$bgcolor		= iCColor::getBrightness($bg_day);
			$bgcolor		= ($bgcolor == 'bright') ? 'ic-bright' : 'ic-dark';
			$order			= 'first';

			$multi_events	= isset($stamp->events[1]['cat_color']) ? 'icmulti' : '';

			// Ordering by time New Theme Packs (since 3.2.9)
			$events			= $stamp->events;

			// Option for Ordering is not yet finished. This developpement is in brainstorming...
			$ictip_ordering	= '1';
			$ictip_ordering	= $this->ictip_ordering;

			if ($ictip_ordering == '1_ASC-1_ASC' || $ictip_ordering == '1_ASC-1_DESC') $ictip_ordering = '1_ASC';
			if ($ictip_ordering == '2_ASC-2_ASC' || $ictip_ordering == '2_ASC-2_DESC') $ictip_ordering = '2_ASC';
			if ($ictip_ordering == '1_DESC-1_ASC' || $ictip_ordering == '1_DESC-1_DESC') $ictip_ordering = '1_DESC';
			if ($ictip_ordering == '2_DESC-2_ASC' || $ictip_ordering == '2_DESC-2_DESC') $ictip_ordering = '2_DESC';

			// Create Functions for Ordering
			// Default $newfunc_1_ASC_2_ASC - edited 2015-07-01 to fix ordering by Time when am/pm
			$newfunc_1_ASC_2_ASC = create_function('$a, $b', 'if ($a["time"] == $b["time"]){ return strcasecmp($a["cat_title"], $b["cat_title"]); } else { return strcasecmp(date("H:i", strtotime($a["time"])), date("H:i", strtotime($b["time"]))); }');

			$newfunc_1_ASC_2_DESC = create_function('$a, $b', 'if ($a["time"] == $b["time"]){ return strcasecmp($b["cat_title"], $a["cat_title"]); } else { return strcasecmp($a["time"], $b["time"]); }');
			$newfunc_1_DESC_2_ASC = create_function('$a, $b', 'if ($a["time"] == $b["time"]){ return strcasecmp($a["cat_title"], $b["cat_title"]); } else { return strcasecmp($b["time"], $a["time"]); }');
			$newfunc_1_DESC_2_DESC = create_function('$a, $b', 'if ($a["time"] == $b["time"]){ return strcasecmp($b["cat_title"], $a["cat_title"]); } else { return strcasecmp($b["time"], $a["time"]); }');

			$newfunc_2_ASC_1_ASC = create_function('$a, $b', 'if ($a["cat_title"] == $b["cat_title"]){ return strcasecmp($a["time"], $b["time"]); } else { return strcasecmp($a["cat_title"], $b["cat_title"]); }');
			$newfunc_2_ASC_1_DESC = create_function('$a, $b', 'if ($a["cat_title"] == $b["cat_title"]){ return strcasecmp($b["time"], $a["time"]); } else { return strcasecmp($a["cat_title"], $b["cat_title"]); }');
			$newfunc_2_DESC_1_ASC = create_function('$a, $b', 'if ($a["cat_title"] == $b["cat_title"]){ return strcasecmp($a["time"], $b["time"]); } else { return strcasecmp($b["cat_title"], $a["cat_title"]); }');
			$newfunc_2_DESC_1_DESC = create_function('$a, $b', 'if ($a["cat_title"] == $b["cat_title"]){ return strcasecmp($b["time"], $a["time"]); } else { return strcasecmp($b["cat_title"], $a["cat_title"]); }');

			$newfunc_1_ASC = create_function('$a, $b', 'return strcasecmp($a["time"], $b["time"]);');
			$newfunc_2_ASC = create_function('$a, $b', 'return strcasecmp($a["cat_title"], $b["cat_title"]);');

			$newfunc_1_DESC = create_function('$a, $b', 'return strcasecmp($b["time"], $a["time"]);');
			$newfunc_2_DESC = create_function('$a, $b', 'return strcasecmp($b["cat_title"], $a["cat_title"]);');

			// Order by time - Old Theme Packs (before 3.2.9) : Update Theme Pack to get all options
			usort($stamp->events, $newfunc_1_ASC_2_ASC);

			// Time ASC and if same time : Category Title ASC (default)
			if ($ictip_ordering == '1_ASC-2_ASC')
			{
				usort($events, $newfunc_1_ASC_2_ASC);
			}
			// Time ASC and if same time : Category Title DESC
			if ($ictip_ordering == '1_ASC-2_DESC')
			{
				usort($events, $newfunc_1_ASC_2_DESC);
			}
			// Time DESC and if same time : Category Title ASC
			if ($ictip_ordering == '1_DESC-2_ASC')
			{
				usort($events, $newfunc_1_DESC_2_ASC);
			}
			// Time DESC and if same time : Category Title DESC
			if ($ictip_ordering == '1_DESC-2_DESC')
			{
				usort($events, $newfunc_1_DESC_2_DESC);
			}

			// Category Title ASC and if same category : Time ASC
			if ($ictip_ordering == '2_ASC-1_ASC')
			{
				usort($events, $newfunc_2_ASC_1_ASC);
			}
			// Category Title ASC and if same category : Time DESC
			if ($ictip_ordering == '2_ASC-1_DESC')
			{
				usort($events, $newfunc_2_ASC_1_DESC);
			}
			// Category Title DESC and if same category : Time ASC
			if ($ictip_ordering == '2_DESC-1_ASC')
			{
				usort($events, $newfunc_2_DESC_1_ASC);
			}
			// Category Title DESC and if same category : Time DESC
			if ($ictip_ordering == '2_DESC-1_DESC')
			{
				usort($events, $newfunc_2_DESC_1_DESC);
			}

			// If main ordering and sub-ordering on Time : set TIME ASC (with no sub-ordering)
			if ($ictip_ordering == '1_ASC')
			{
				usort($events, $newfunc_1_ASC);
			}
			// If main ordering and sub-ordering on Category Title : set CATEGORY TITLE ASC (with no sub-ordering)
			if ($ictip_ordering == '2_ASC')
			{
				usort($events, $newfunc_2_ASC);
			}


			// Load template for day infotip
			require $this->t_day;

			switch('week')
			{
				case $this->ng:
					echo '</td></tr>';
					break;
				default:
					echo '</td>';
					break;
			}
		}

		switch ($stamp->week)
		{
			case $this->ng:
				break;
			default:
				echo '<td colspan="' . (7-$stamp->week) . '"></td></tr>';
				break;
		}

		echo '</table></div>';

		echo '</div>';

	}
}


class day
{
	public $date;
	public $week;
	public $day;
	public $month;
	public $year;
	public $events;
	public $fontcolor;

	function __construct($day)
	{
		foreach ($day as $k=>$v)
		{
			$this->$k = $v;
		}
	}
}
