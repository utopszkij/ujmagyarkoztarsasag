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
 * @version 	3.5.7 2015-07-16
 * @since       1.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport('joomla.application.component.modelitem');
jimport('joomla.html.parameter');
jimport('joomla.registry.registry');

jimport('joomla.user.helper');
jimport('joomla.access.access');

class iCModelItem extends JModelItem
{

    /**
	  * li-de integrációban van ez a funkció használva
	  * MYSQL -el az adott user által látható,
	  * a mai napon vagy késöbb lévő eseményeket kell kigyüjteni.
	  * @return array  tömb elem : éééé-hh-nn oo-pp_####
	*/  
    static function getAlldates() {
		$user = JFactory::getUser();
		$db = JFactory::getDBO();
		$result = array();
		$query = $db->getQuery();
		$query->clear();
		$query->select('e.id, e.startdate as date');
		$query->from('`#__icagenda_events` AS e');
		$query->leftJoin('#__szavazasok as lidesz on e.alias like concat("sz-", lidesz.id,"-%")');
		$query->leftJoin('#__temakorok as lidet on lidet.id = lidesz.temakor_id');
		$query->leftJoin('#__tagok as lideta on lideta.temakor_id = lidesz.temakor_id and lideta.user_id = "'.$user->id.'"');
		$query->where('((lidet.lathatosag = 0) or
		(lidet.lathatosag = 1 and "'.$user->id.'" > 0) or
		(lidet.lathatosag = 2 and lideta.user_id is not null) 
		)');
		$query->where('e.startdate >= "'.date('Y-m-d 00:00:00').'"');
		$query->order('e.startdate');
		//DBG echo '<pre>'.$query.'</pre>';
		$db->setQuery($query);
		$res = $db->loadObjectList();
		foreach ($res as $res1) {
			$result[] = $res1->date.'_'.$res1->id;
		}
		return $result;
	}

	/**
	 * @var
	 */
	protected $msg;
	protected $filters;
	protected $options;
	protected $itObj;
	protected $where;

	protected $searchInFields = array('title', 'c.catid');

	/**
	 * Load the iChelper class
	 */
	public function __construct($config = array())
	{
		$config['filter_fields'] = array_merge($this->searchInFields, array('c.catid'));

		parent::__construct($config);

		// Load the helper class
		JLoader::register('iCModeliChelper', JPATH_SITE . '/components/com_icagenda/helpers/ichelper.php');
	}


	/**
	 * Model Builder
	 */
	protected function startiCModel()
	{
		$this->filters	= array();
		$this->options	= array();
		$this->items	= array();
		$this->itObj	= new stdClass;
	}


	/**
	 * Table importation
	 */
	public function getTable($type = 'icagenda', $prefix = 'icagendaTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}


	/**
	 * Get all data
	 */
	protected function getItems($structure)
	{
		// Return Items
		if (isset($this->items) && is_array($this->items))
		{
			$this->items = $this->getDBitems();
		}

		foreach ($structure as $k => $v)
		{
			$this->itObj->$k = $this->$k($v);
		}

		return $this->itObj;
	}


	/**
	 * Add the filters to be used in queries
	 */
	protected function addFilter($name, $value)
	{
		$this->filters[$name] = $value;
	}


	/**
	 * Add the options you use to obtain the various data in the right setting
	 */
	protected function addOption($name, $value)
	{
		$this->options[$name]=$value;
	}


	/**
	 * Fetch data from DB
	 */
	protected function getDBitems()
	{
		// Check valid NEXT DATE
		icagendaEventsData::getNext();

		$app = JFactory::getApplication();
		$jinput = $app->input;
		$params = $app->getParams();

		// Get Settings
		$filterTime		= $params->get('time', 1);

		$jlayout		= JRequest::getCmd('layout', '');
		$layouts_array	= array('event', 'registration', 'actions');
		$layout			= in_array($jlayout, $layouts_array) ? $jlayout : '';

		// Set vars
		$nodate			= '0000-00-00 00:00:00';
		$eventTimeZone	= null;
		$datetime_today	= JHtml::date('now', 'Y-m-d H:i:s'); // Joomla Time Zone
		$date_today		= JHtml::date('now', 'Y-m-d'); // Joomla Time Zone
		$time_today		= JHtml::date('now', 'H:i:s'); // Joomla Time Zone

		// Get List Type option (list of events / list of dates)
		$allDatesDisplay = $this->options['datesDisplay'];

		// Preparing connection to db
		$db	= Jfactory::getDbo();

		// Preparing the query
		$query = $db->getQuery(true);

		// Selectable items
		$query->select('e.*,
			e.place as place_name, e.coordinate as coordinate, e.lat as lat, e.lng as lng,
			c.id as cat_id, c.title as cat_title, c.color as cat_color, c.desc as cat_desc, c.alias as cat_alias');

		// join
		$query->from('`#__icagenda_events` AS e');
		
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
		
		$query->leftJoin('`#__icagenda_category` AS c ON c.id = e.catid');
		$query->where('c.state = 1');

		// Where (filters)
		$filters = $this->filters;

		$where = 'e.state = ' . $filters['state'];

		$user		= JFactory::getUser();
		$userLevels	= $user->getAuthorisedViewLevels();
		$userGroups	= $user->groups;
		$groupid	= JComponentHelper::getParams('com_icagenda')->get('approvalGroups', array("8"));
		$groupid	= is_array($groupid) ? $groupid : array($groupid);

		// Test if user login have Approval Rights
		if ( !array_intersect($userGroups, $groupid)
			&& !in_array('8', $userGroups) )
		{
			$where.= ' AND e.approval <> 1';
		}
		else
		{
			$where.= ' AND e.approval < 2';
		}

		// ACCESS Filtering (if not list, use layout access control (event, registration))
		if ( ! $layout
			&& ! in_array('8', $userGroups) )
		{
			$useraccess = implode(', ', $userLevels);

			$where.= ' AND e.access IN (' . $useraccess . ')';
		}

		// LANGUAGE Filtering
		$where.= ' AND (e.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . '))';

		unset($filters['state']);

		$k = '0';
		$this_id = null;

		if (isset($filters))
		{
			foreach($filters as $k=>$v)
			{
				// normal cases
				if ($k != 'key' && $k != 'next' && $k != 'e.catid' && $k != 'id')
				{
					$where.= ' AND '.$k.' LIKE "%'.$v.'%"';
				}

				// in case of search
				if ($k == 'key')
				{
					$keys = explode(' ', $v);

					foreach ($keys as $ke)
					{
						$where.= ' AND (e.title LIKE \'%' . $ke . '%\' OR ';
						$where.= ' e.desc LIKE \'%' . $ke . '%\' OR ';
						$where.= ' e.address LIKE \'%' . $ke . '%\' OR ';
						$where.= ' e.place LIKE \'%' . $ke . '%\' OR ';
						$where.= ' c.title LIKE \'%' . $ke . '%\')';
					}
				}

				// in the case of category
				$mcatidtrue = $this->options['mcatid'];

				if ( ! is_array($mcatidtrue))
				{
					$catold = $mcatidtrue;
					$mcatid = array($mcatidtrue);
				}
				else
				{
					$catold = '0';
					$mcatid = $mcatidtrue;
				}

				if ( ! in_array('0', $mcatid)
					|| ($catold != 0) )
				{
					if ($k == 'e.catid')
					{
						if (!is_array($v))
						{
							$v = array('' . $v . '');
						}

						$v = implode(', ', $v);

						$where.= ' AND ' . $k . ' IN (' . $v . ')';
					}
				}

				// in case of id
				if ($k == 'id')
				{
					//check if ID is a number
					if (is_numeric($v))
					{
						$this_id = (int) $v; // if event id is set in url

						$where.= ' AND e.id=' . $v;
					}
					else
					{
						//ERROR Message
					}
				}
			}
		}

		// Features - extract the number of displayable icons per event
		$query->select('feat.count AS features');
		$sub_query = $db->getQuery(true);
		$sub_query->select('fx.event_id, COUNT(*) AS count');
		$sub_query->from('`#__icagenda_feature_xref` AS fx');
		$sub_query->innerJoin("`#__icagenda_feature` AS f ON fx.feature_id=f.id AND f.state=1 AND f.icon<>'-1'");
		$sub_query->group('fx.event_id');
		$query->leftJoin('(' . (string) $sub_query . ') AS feat ON e.id=feat.event_id');

		// Filter by Features
		if (!$layout) // if view is list of events (temporary fix for calendar event links to details view)
		{
			$query->where(icagendaEventsData::getFeaturesFilter());
		}

		// Registrations total
		$query->select('r.count AS registered');
		$sub_query = $db->getQuery(true);
		$sub_query->select('r.eventid, sum(r.people) AS count');
		$sub_query->from('`#__icagenda_registration` AS r');

		$get_date = JRequest::getVar('date', '');

		if ($get_date)
		{
			$ex = explode('-', $get_date);

			if (strlen(iCDate::dateToNumeric($get_date)) != '12')
			{
				$event_url	= JURI::getInstance()->toString();
				$cleanurl	= preg_replace('/&date=[^&]*/', '', $event_url);
				$cleanurl	= preg_replace('/\?date=[^\?]*/', '', $cleanurl);

				// redirect and remove date var, if not correctly set
//				$app->redirect($cleanurl , JText::_( 'COM_ICAGENDA_ERROR_URL_DATE_NOT_FOUND' ));
				$app->redirect($cleanurl);

				return false;
			}

			if (count($ex) == 5)
			{
				$dateday = $ex['0'] . '-' . $ex['1'] . '-' . $ex['2'] . ' ' . $ex['3'] . ':' . $ex['4'] . ':00';

				$sub_query->where('r.date = ' . $db->q($dateday));
			}
		}

		$sub_query->where('r.state > 0');
		$sub_query->group('r.eventid');
		$query->leftJoin('(' . (string) $sub_query . ') AS r ON e.id=r.eventid');

		if ( ! $layout)
		{
			$number_per_page	= $this->options['number'];
			$orderdate			= $this->options['orderby'];
			$getpage			= JRequest::getVar('page', '1');

			$start = $number_per_page * ($getpage - 1);

			$all_dates_with_id	= icagendaEventsData::getAllDates();

			$count_all_dates	= count($all_dates_with_id);

			// Set list of PAGE:IDS
			$pages = ceil($count_all_dates / $number_per_page);
			$list_id = array();

			for ($n = 1; $n <= $pages; $n++)
			{
				$dpp_array = array();

				$page_nb		= $number_per_page * ($n - 1);
				$dates_per_page	= array_slice($all_dates_with_id, $page_nb, $number_per_page, true);

				foreach ($dates_per_page AS $dpp)
				{
					$dpp_alldates_array	= explode('_', $dpp);
					$dpp_date			= $dpp_alldates_array['0'];
					$dpp_id				= $dpp_alldates_array['1'];
					$dpp_array[]		= $dpp_id;
				}

				$list_id[] = implode(', ', $dpp_array) . '::' . $n;
			}

			$this_ic_ids = '';

			if ($list_id)
			{
				foreach ($list_id as $a)
				{
					$ex_listid = explode('::', $a);
					$ic_page = $ex_listid[1];
					$ic_ids = $ex_listid[0];

					if ($ic_page == $getpage)
					{
						$this_ic_ids = $ic_ids ? $ic_ids : '0';
					}
				}

				if ($this_ic_ids)
				{
					$where.= ' AND (e.id IN (' . $this_ic_ids . '))';
				}
				else
				{
					return false; // No Event (if 'All Dates' option selected)
				}
			}
		}

		// Query $where list
		$query->where($where);

		$db->setQuery($query);
		$loaddb = $db->loadObjectList();

		$registrations = icagendaEventsData::registeredList($this_id);

		// Extract the feature details, if needed
		foreach ($loaddb as $record)
		{
			if (is_null($record->features))
			{
				$record->features = array();
			}
			else
			{
				$query = $db->getQuery(true);
				$query->select('DISTINCT f.icon, f.icon_alt');
				$query->from('`#__icagenda_feature_xref` AS fx');
				$query->innerJoin("`#__icagenda_feature` AS f ON fx.feature_id=f.id AND f.state=1 AND f.icon<>'-1'");
				$query->where('fx.event_id=' . $record->id);
				$query->order('f.ordering DESC'); // Order descending because the icons are floated right
				$db->setQuery($query);
				$record->features = $db->loadObjectList();
			}

//			if (is_null($record->registered))
//			{
//				$record->registered = array();
//			}
//			else
//			{
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
//			}
		}

		if ((!$layout && count($all_dates_with_id) > 0)
			|| $layout)
		{
			return $loaddb;
		}
	}


	/**
	 *
	 * ALL DATES - iCmodel
	 *
	 */
	protected function eventAllDates($i)
	{
		// Set vars
		$nodate = '0000-00-00 00:00:00';
		$ic_nodate = '0000-00-00 00:00';
		$eventTimeZone = null;

		// Get Data
		$tNext			= $i->next;
		$tDates			= $i->dates;
		$tId			= $i->id;
		$tState			= $i->state;
		$tEnddate		= $i->enddate;
		$tStartdate		= $i->startdate;
		$tWeekdays		= $i->weekdays;

		// Declare eventAllDates array
		$eventAllDates = array();

		// Get WeekDays Array
		$WeeksDays = iCDatePeriod::weekdaysToArray($tWeekdays);

		// If Single Dates, added each one to All Dates for this event
		$singledates = iCString::isSerialized($tDates) ? unserialize($tDates) : array();

		foreach ($singledates as $sd)
		{
			$isValid = iCDate::isDate($sd);

			if ( $isValid )
			{
				array_push($eventAllDates, $sd);
			}
		}

		// If Period Dates, added each one to All Dates for this event (filter week Days, and if date not null)
//		$StDate = JHtml::date($tStartdate, 'Y-m-d H:i', $eventTimeZone);
//		$EnDate = JHtml::date($tEnddate, 'Y-m-d H:i', $eventTimeZone);

		$perioddates = iCDatePeriod::listDates($i->startdate, $i->enddate);

		if ( (isset ($perioddates))
			&& ($perioddates != NULL) )
		{
			foreach ($perioddates as $Dat)
			{
				if (in_array(date('w', strtotime($Dat)), $WeeksDays))
				{
					$isValid = iCDate::isDate($Dat);

					if ($isValid)
					{
//						$SingleDate = JHtml::date($Dat, 'Y-m-d H:i', $eventTimeZone);
						$SingleDate = date('Y-m-d H:i', strtotime($Dat));

						array_push($eventAllDates, $SingleDate);
					}
				}
			}
		}

		return $eventAllDates;
	}

	/**
	 *
	 * EVENT DETAILS
	 *
	 */

	public function startdatetime($i)
	{
		return $i->startdate;
	}
	protected function enddatetime($i)
	{
		return $i->enddate;
	}
	protected function start_datetime($i)
	{
		return $i->startdate;
	}
	protected function end_datetime($i)
	{
		return $i->enddate;
	}
	protected function contact_name($i)
	{
		return $i->name;
	}
	protected function contact_email($i)
	{
		return $i->email;
	}

	protected function access($i){return $i->access;}
	protected function address($i){return $i->address;}
	protected function approval($i){return $i->approval;}
	protected function city($i){return $i->city;}
	protected function country($i){return $i->country;}
	protected function customfields($i){return $i->customfields;}
	protected function dates($i){return $i->dates;}
	protected function displaytime($i){return $i->displaytime;}
	protected function email($i){return $i->email;}
	protected function file($i){return $i->file;}
	protected function period($i){return $i->period;}
	protected function phone($i){return $i->phone;}
	protected function state($i){return $i->state;}
	protected function website($i){return $i->website;}
	protected function weekdays($i){return $i->weekdays;}

	protected function cat_desc($i){return $i->cat_desc;}
	protected function place_name($i){return $i->place_name;}


	// Set Meta-title for an event
	protected function metaTitle($i)
	{
		$limit = '70';
		$metaTitle = iCFilterOutput::fullCleanHTML($i->title);

		if ( strlen($metaTitle) > $limit )
		{
			$string_cut	= substr($metaTitle, 0, $limit);
			$last_space	= strrpos($string_cut, ' ');
			$string_ok	= substr($string_cut, 0, $last_space);
			$metaTitle = $string_ok;
		}

		return $metaTitle;
	}

	// Set Meta-description for an event
	protected function metaDesc($i)
	{
		$limit = '160';
		$metaDesc = iCFilterOutput::fullCleanHTML($i->metadesc);

		if ( empty($metaDesc) )
		{
			$metaDesc = iCFilterOutput::fullCleanHTML($i->desc);
		}

		if ( strlen($metaDesc) > $limit )
		{
			$string_cut	= substr($metaDesc, 0, $limit);
			$last_space	= strrpos($string_cut, ' ');
			$string_ok	= substr($string_cut, 0, $last_space);
			$metaDesc = $string_ok;
		}

		return $metaDesc;
	}

	// Set Meta-description as Short Description
	protected function metaAsShortDesc($i)
	{
		$metaAsShortDesc = iCFilterOutput::fullCleanHTML($i->metadesc);

		return $metaAsShortDesc;
	}


	protected function BackURL($i)
	{
		// Get Current Itemid
		//$this_itemid = JRequest::getInt('Itemid');

		//$BackURL = str_replace('&amp;','&', JRoute::_('index.php?option=com_icagenda&view=list&Itemid='.$this_itemid));
		$BackURL = 'javascript:history.go(-1)';

		return $BackURL;
	}

	protected function BackArrow($i)
	{
		// Get Current Itemid
		$this_itemid	= JRequest::getInt('Itemid');

		$jlayout		= JRequest::getCmd('layout', '');
		$layouts_array	= array('event', 'registration');
		$layout			= in_array($jlayout, $layouts_array) ? $jlayout : '';

		$manageraction	= JRequest::getVar('manageraction', '');
		$referer		= isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

		// RTL css if site language is RTL
		$lang			= JFactory::getLanguage();
		$back_icon		= ($lang->isRTL()) ? 'iCicon iCicon-nextic' : 'iCicon iCicon-backic';

		if ($layout != ''
			&& strpos($referer,'registration') === false
			&& !$manageraction)
		{
			if ($referer != "")
			{
				$BackArrow = '<a class="iCtip" href="' . str_replace(array('"', '<', '>', "'"), '', $referer) .'" title="' . JText::_( 'COM_ICAGENDA_BACK' ) . '"><span class="' . $back_icon . '"></span> <span class="small">' . JText::_( 'COM_ICAGENDA_BACK' ) .'</span></a>';
			}
			else
			{
				$BackArrow = '';
				return false;
			}
		}
		elseif ($manageraction || strpos($referer,'registration') !== false)
		{
			$BackArrow = '<a class="iCtip" href="' . JRoute::_('index.php?option=com_icagenda&Itemid=' . $this_itemid) .'" title="'. JText::_( 'COM_ICAGENDA_BACK' ) .'"><span class="' . $back_icon . '"></span> <span class="small">' . JText::_( 'COM_ICAGENDA_BACK' ) . '</span></a>';
		}
		else
		{
			return false;
		}

		return $BackArrow;
	}


	protected function ApprovedNotification ($creatorEmail, $eventUsername, $eventTitle, $eventLink)
	{
		$app = JFactory::getApplication();

		// Load Joomla Config Mail Options
		$sitename	= $app->getCfg('sitename');
		$mailfrom	= $app->getCfg('mailfrom');
		$fromname	= $app->getCfg('fromname');

		// Create User Mailer
		$approvedmailer = JFactory::getMailer();

		// Set Sender of Notification Email
		$approvedmailer->setSender(array( $mailfrom, $fromname ));

		// Set Recipient of Notification Email
		$approvedmailer->addRecipient($creatorEmail);

		// Set Subject of Notification Email
		$approvedsubject = JText::sprintf('COM_ICAGENDA_APPROVED_USEREMAIL_SUBJECT', $eventTitle);
		$approvedmailer->setSubject($approvedsubject);

		// Set Body of Notification Email
		$approvedbodycontent = JText::sprintf( 'COM_ICAGENDA_SUBMISSION_ADMIN_EMAIL_HELLO', $eventUsername) . ',<br /><br />';
		$approvedbodycontent.= JText::sprintf( 'COM_ICAGENDA_APPROVED_USEREMAIL_BODY_INTRO', $sitename) . '<br /><br />';
//		$approvedbodycontent.= JText::_( 'COM_ICAGENDA_APPROVED_USEREMAIL_EVENT_LINK' ).'<br />';

		$eventLink_html = '<br /><a href="' . $eventLink . '">' . $eventLink . '</a>';
		$approvedbodycontent.= JText::sprintf( 'COM_ICAGENDA_APPROVED_USEREMAIL_EVENT_LINK', $eventLink_html ).'<br /><br />';

//		$approvedbodycontent.= '<a href="' . $eventLink . '">' . $eventLink . '</a><br /><br />';
		$approvedbodycontent.= '<hr><small>' . JText::_( 'COM_ICAGENDA_APPROVED_USEREMAIL_EVENT_LINK_INFO' ) . '</small><br /><br />';

		$approvedbody = rtrim($approvedbodycontent);

		$approvedmailer->isHTML(true);
		$approvedmailer->Encoding = 'base64';

		$approvedmailer->setBody($approvedbody);

		// Send User Notification Email
		if (isset($creatorEmail))
		{
			$send = $approvedmailer->Send();
		}
	}

	protected function ManagerIcons ($i)
	{
		$app = JFactory::getApplication();

		// Get Current Itemid
		$this_itemid = JRequest::getInt('Itemid');

		// Get Current Url
		$returnURL = base64_encode(JURI::getInstance()->toString());

		$event_slug = empty($i->alias) ? $i->id : $i->id . ':' . $i->alias;

		// Set Manager Actions Url
		$managerActionsURL = 'index.php?option=com_icagenda&view=list&layout=event&id=' . $event_slug . '&Itemid=' . $this_itemid;

		// Set Email Notification Url to event
		$linkEmailUrl = JURI::base() . 'index.php?option=com_icagenda&view=list&layout=event&id=' . $event_slug . '&Itemid=' . $this_itemid;

		// Get Approval Status
		$approved = $i->approval;

		// Get User groups allowed to approve event submitted
		$groupid = JComponentHelper::getParams('com_icagenda')->get('approvalGroups', array("8"));

		$groupid = is_array($groupid) ? $groupid : array($groupid);

		// Get User Infos
		$user	= JFactory::getUser();

		$icid	= $user->get('id');
		$icu	= $user->get('username');
		$icp	= $user->get('password');

		// Get User groups of the user logged-in
		if (version_compare(JVERSION, '3.0', 'lt'))
		{
			$userGroups = $user->getAuthorisedGroups();
		}
		else
		{
			$userGroups = $user->groups;
		}

		$baseURL = JURI::base();
		$subpathURL = JURI::base(true);

		$baseURL = str_replace('/administrator', '', $baseURL);
		$subpathURL = str_replace('/administrator', '', $subpathURL);

		$urlcheck = str_replace('&amp;','&', JRoute::_('administrator/index.php?option=com_icagenda&view=events').'&icu=' . $icu . '&icp=' . $icp . '&filter_search=' . $i->id);

		// Sub Path filtering
		$subpathURL = ltrim($subpathURL, '/');

		// URL Event Check filtering
		$urlcheck = ltrim($urlcheck, '/');

		if (substr($urlcheck, 0, strlen($subpathURL)+1) == "$subpathURL/")
		{
			$urlcheck = substr($urlcheck, strlen($subpathURL)+1);
		}

		$urlcheck = rtrim($baseURL, '/') . '/' . ltrim($urlcheck, '/');

		$icu_approve	= JRequest::getVar('manageraction', '');

		$jlayout		= JRequest::getCmd('layout', '');
		$layouts_array	= array('event', 'registration');
		$icu_layout		= in_array($jlayout, $layouts_array) ? $jlayout : '';
//		$icu_layout = JRequest::getVar('layout', '');

		if ( array_intersect($userGroups, $groupid)
			|| in_array('8', $userGroups) )
		{
			if ($approved == 1)
			{
				if (version_compare(JVERSION, '3.0', 'lt'))
				{
					$approvalButton = '<a class="iCtip" href="'.JRoute::_($managerActionsURL.'&manageraction=approve').'" title="'.JText::_( 'COM_ICAGENDA_APPROVE_AN_EVENT_LBL' ).'"><div class="iCicon-16 approval"></div></a>';
 				}
 				else
 				{
					$approvalButton = '<a class="iCtip" href="'.JRoute::_($managerActionsURL.'&manageraction=approve').'" title="'.JText::_( 'COM_ICAGENDA_APPROVE_AN_EVENT_LBL' ).'"><button type="button" class="btn btn-micro btn-warning btn-xs"><i class="icon-checkmark"></i></button></a>';
				}

				if ( ($icu_layout == 'event')
					&& ($icu_approve == 'approve') )
				{
        			$db		= Jfactory::getDbo();
					$query	= $db->getQuery(true);
        			$query->clear();
					$query->update(' #__icagenda_events ');
					$query->set(' approval = 0 ' );
					$query->where(' id = ' . (int) $i->id );
					$db->setQuery((string)$query);
					$db->query($query);
					$approveSuccess = '"'.$i->title.'"';
					$alertmsg = JText::sprintf('COM_ICAGENDA_APPROVED_SUCCESS', $approveSuccess);
					$alerttitle = JText::_( 'COM_ICAGENDA_APPROVED' );
					$alerttype = 'success';
					$approvedLink = JRoute::_($managerActionsURL);

					self::ApprovedNotification($i->created_by_email, $i->username, $i->title, $linkEmailUrl);
					$app->enqueueMessage($alertmsg, $alerttitle, $alerttype);
				}
				else
				{
					return $approvalButton;
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	// Function Email Cloaking
	protected function emailLink ($i)
	{
		if ($i->email != NULL)
		{
			return JHtml::_('email.cloak', $i->email);
		}
	}

	// Image URL
	protected function image ($i)
	{
		$ic_image = JURI::base() . $i->image;

		if ($i->image)
		{
			return $ic_image;
		}

		return false;
	}


	// Get Items
	protected function items($atr)
	{
		// Initialize controls
		$access = '0';
		$control = '';

		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('a.title, a.published, a.id')
			->from('`#__menu` AS a')
			->where( "(link = 'index.php?option=com_icagenda&view=list') AND (published > 0)" );
		$db->setQuery($query);
		$link = $db->loadObjectList();
		$itemid = JRequest::getVar('Itemid');

		$parentnav = $itemid;

		foreach ($link as $l)
		{
			if (($l->published == '1') AND ($l->id == $parentnav))
			{
				$linkexist = '1';
			}
		}

		if (is_numeric($parentnav) && !is_array($parentnav) && !$parentnav == 0 && $linkexist == 1)
		{
			$atr	= $atr['item'];
			$items	= $this->items;
			$itDef	= new stdClass;

			if ($this->items == NULL)
			{
				return NULL;
			}
			else
			{
				foreach($items as $i)
				{
					// Language Control
					$lang = JFactory::getLanguage();
					$eventLang = '';
					$langTag = '';
					$langTag = $lang->getTag();

					if (isset($i->language))
					{
						$eventLang = $i->language;
					}
					if ($eventLang == '' || $eventLang == '*')
					{
						$eventLang = $langTag;
					}

					if ($i->next != '0000-00-00 00:00:00')
					{
						$it	= new stdClass;
						$id	= $i->id;

						foreach($atr as $k => $v)
						{
							// Corrige Notice : Undefined property: stdClass::
							if (!empty($i->$k))
							{
								// functions
								$it->$k = $i->$k;
							}
							else
							{
								// data
								if (method_exists($this, $k))
								{
									$it->$k = $this->$k($i);
								}
							}
						}
						$itDef->$id = $it;
					}
				}
			}

			return $itDef;
		}
		else
		{
			JError::raiseError('404', JTEXT::_('JERROR_LAYOUT_PAGE_NOT_FOUND'));

			return false;
		}
	}


	// Set event Url
	protected function url ($i)
	{
		$menuID			= $this->options['Itemid'];
		$eventnumber	= $i->id;
		$event_slug		= empty($i->alias) ? $i->id : $i->id . ':' . $i->alias;

		$url			= JRoute::_('index.php?option=com_icagenda&view=list&layout=event&id=' . $event_slug . '&Itemid=' . (int)$menuID);

		if (is_numeric($menuID) && is_numeric($eventnumber)
			&& !is_array($menuID) && !is_array($eventnumber)
			)
		{
			return $url;
		}
		else
		{
			$url = JRoute::_('index.php');

			return $url;
		}
	}

	// Get event Url for Add To Cal
	protected function Event_Link($i)
	{
		$lien			= $this->options['Itemid'];
		$eventnumber	= $i->id;
		$event_slug		= empty($i->alias) ? $i->id : $i->id . ':' . $i->alias;
		$date			= $i->next;

		// Get the "event" URL
		$baseURL	= JURI::base();
		$subpathURL	= JURI::base(true);

		$baseURL	= str_replace('/administrator', '', $baseURL);
		$subpathURL	= str_replace('/administrator', '', $subpathURL);

		$urlevent	= str_replace('&amp;','&', JRoute::_('index.php?option=com_icagenda&view=list&layout=event&Itemid=' . (int)$lien . '&id=' . $event_slug));

		// Sub Path filtering
		$subpathURL	= ltrim($subpathURL, '/');

		// URL Event Details filtering
		$urlevent	= ltrim($urlevent, '/');

		if (substr($urlevent, 0, strlen($subpathURL)+1) == "$subpathURL/")
		{
			$urlevent = substr($urlevent, strlen($subpathURL)+1);
		}

		$urlevent	= rtrim($baseURL,'/').'/'.ltrim($urlevent,'/');

		$url		= $urlevent;

		if (is_numeric($lien) && is_numeric($eventnumber)
			&& !is_array($lien) && !is_array($eventnumber)
			)
		{
			return $url;
		}
		else
		{
			$url = JRoute::_('index.php');

			return JURI::base().$url;
		}

	}

	// Title with link to details
	//
	// DEPRECATED
	protected function titleLink($i)
	{
		return '<a href="' . $this->url($i) . '">' . $i->title . '</a>';
	}

	// Title + Manager Icons
	protected function titlebar($i)
	{
		$this_itemid		= JRequest::getInt('Itemid');
		$list_title_length	= JComponentHelper::getParams('com_icagenda')->get('list_title_length', '');

		$i_title			= $this->titleFormat($i);

		$jlayout			= JRequest::getCmd('layout', '');
		$layouts_array		= array('event', 'registration');
		$layout				= in_array($jlayout, $layouts_array) ? $jlayout : '';

		$mbString			= extension_loaded('mbstring');

		$title_length		= $mbString ? mb_strlen($i_title, 'UTF-8') : strlen($i_title);

		if (empty($layout)
			&& ! empty($list_title_length))
		{
			$title	= $mbString
					? trim(mb_substr($i_title, 0, $list_title_length, 'UTF-8'))
					: trim(substr($i_title, 0, $list_title_length));

			$new_title_length = $mbString ? mb_strlen($title, 'UTF-8') : strlen($title);

			if ($new_title_length < $title_length)
			{
				$title.= '...';
			}
		}
		else
		{
			$title = $i_title;
		}

		$approval = $i->approval;

		$event_slug = empty($i->alias) ? $i->id : $i->id . ':' . $i->alias;

		// Set Manager Actions Url
		$managerActionsURL	= 'index.php?option=com_icagenda&view=list&layout=event&id=' . $event_slug . '&Itemid=' . $this_itemid;

		$unapproved			= '<a class="iCtip" href="' . JRoute::_($managerActionsURL) . '" title="'.JText::_( 'COM_ICAGENDA_APPROVE_AN_EVENT_LBL' ).'"><small><span class="iCicon-open-details"></span></small></a>';

		if ($title != NULL && $approval == 1)
		{
			return $title . ' ' . $unapproved;
		}
		elseif ($title != NULL && $approval != 1)
		{
			return $title;
		}

		return NULL;
	}

	// Title
	protected function titleFormat($i)
	{
		$text_transform	= JComponentHelper::getParams('com_icagenda')->get('titleTransform', '');
		$mbString		= extension_loaded('mbstring');

		if ($text_transform == 1)
		{
			$titleFormat = $mbString ? iCString::mb_ucfirst(mb_strtolower($i->title)) : ucfirst(strtolower($i->title));

			return $titleFormat;
		}
		elseif ($text_transform == 2)
		{
			$titleFormat = $mbString ? mb_convert_case($i->title, MB_CASE_TITLE, "UTF-8") : ucwords(strtolower($i->title));

			return $titleFormat;
		}
		elseif ($text_transform == 3)
		{
			$titleFormat = $mbString ? mb_strtoupper($i->title, "UTF-8") : strtoupper($i->title);

			return $titleFormat;
		}
		elseif ($text_transform == 4)
		{
			$titleFormat = $mbString ? mb_strtolower($i->title, "UTF-8") : strtolower($i->title);

			return $titleFormat;
		}

		return $i->title;
	}

	// Title
	protected function title($i)
	{
		return $i->title;
	}

	// Short Description
	public function shortdesc($i)
	{
		$shortdesc = $i->shortdesc ? $i->shortdesc : NULL;

		return $shortdesc;
	}

	// Description
	public function desc($i)
	{
		$desc = $i->desc ? $i->desc : NULL;

		return $desc;
	}

	// Short Description (content prepare)
	protected function shortDescription($i)
	{
		$text				= JHtml::_('content.prepare', $i->shortdesc);
		$shortDescription	= $i->shortdesc ? $text : NULL;

		return $shortDescription;
	}

	// Full Description (content prepare)
	protected function description($i)
	{
		$text			= JHtml::_('content.prepare', $i->desc);
		$description	= $i->desc ? $text : NULL;

		return $description;
	}

	// Auto Short Description (Full Description > Short)
	protected function descShort($i)
	{
		$descShort = icagendaEvents::shortDescription($i->desc);

		return $descShort;
	}


	// Image TAG
	protected function imageTag($i)
	{
		if (!$i->image == NULL)
		{
			return '<img src="' . $i->image . '" alt="" />';
		}
	}


	// File TAG
	protected function fileTag($i)
	{
		return '<a class="icDownload" href="' . $i->file . '" target="_blank">' . JText::_( 'COM_ICAGENDA_EVENT_DOWNLOAD' ) . '</a>';
	}


	// Website TAG
	protected function websiteLink($i)
	{
		$gettarget	= JComponentHelper::getParams('com_icagenda')->get('targetLink', '');
		$target		= !empty($gettarget) ? '_blank' : '_parent';

		$link		= iCUrl::urlParsed($i->website, 'scheme');

		return '<a href="' . $link . '" target="' . $target . '">' . $i->website . '</a>';
	}


	/**
	 * TIME
	 */

	// Format Time (eg. 00:00)
	protected function evenTime($i)
	{
		if ($this->displaytime($i) == 1)
		{
			return icagendaEvents::dateToTimeFormat($i->next);
		}
		else
		{
			return NULL;
		}
	}


	/**
	 * DAY
	 */

	// Day
	protected function day ($i)
	{
		$eventTimeZone	= null;
		$day_date		= JHtml::date($i->next, 'd', $eventTimeZone);

		return $day_date;
	}

	// Day of the week, Full - From Joomla language file xx-XX.ini (eg. Saturday)
	protected function weekday ($i)
	{
		$eventTimeZone	= null;
		$full_weekday	= JHtml::date($i->next, 'l', $eventTimeZone);
		$weekday		= JText::_($full_weekday);

		return $weekday;
	}

	// Day of the week, Short - From Joomla language file xx-XX.ini (eg. Sat)
	protected function weekdayShort ($i)
	{
		$eventTimeZone	= null;
		$short_weekday	= JHtml::date($i->next, 'D', $eventTimeZone);
		$weekdayShort	= JText::_($short_weekday);

		return $weekdayShort;
	}


	/**
	 * MONTHS
	 */

	// Function used for special characters
	function substr_unicode($str, $s, $l = null)
	{
    	return join("", array_slice(
		preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY), $s, $l));
	}

	// Format Month (eg. December)
	protected function month ($i)
	{
		$eventTimeZone	= null;
		$full_month		= JHtml::date($i->next, 'F', $eventTimeZone);
		$lang_month		= JText::_($full_month);

		return $lang_month;
	}


	// Format Month Numeric - (eg. 07)
	protected function monthNum ($i)
	{
		$eventTimeZone	= null;
		$monthNum		= JHtml::date($i->next, 'm', $eventTimeZone);

		return $monthNum;
	}


	/**
	 * YEAR
	 */

	// Format Year Numeric - (eg. 2013)
	protected function year ($i)
	{
		$eventTimeZone	= null;
		$year			= JHtml::date($i->next, 'Y', $eventTimeZone);

		return $year;
	}

	// Format Year Short Numeric - (eg. 13)
	protected function yearShort ($i)
	{
		$eventTimeZone	= null;
		$yearShort		= JHtml::date($i->next, 'y', $eventTimeZone);

		return $yearShort;
	}


	////////////
	// DATES
	////////////

	/**
	 * Next Date Text
	 *
	 * @version 3.5.6
	 */
	protected function dateText($i)
	{
		$eventTimeZone		= null;

		$dates				= iCString::isSerialized($i->dates) ? unserialize($i->dates) : array(); // returns array
		$period				= iCString::isSerialized($i->period) ? unserialize($i->period) : array(); // returns array
		$weekdays			= $i->weekdays;

		$site_today_date	= JHtml::date('now', 'Y-m-d');
		$UTC_today_date		= JHtml::date('now', 'Y-m-d', $eventTimeZone);

		$alldates_array 	= array_merge($dates, $period);
 		$alldates			= array_filter($alldates_array, function($var) {return $var == iCDate::isDate($var);});

		$next_date			= date('Y-m-d', strtotime($i->next));
		$next_datetime		= date('Y-m-d H:i', strtotime($i->next));

		$next_is_in_period	= in_array($next_datetime, $period) ? true : false;

		$totDates			= count($alldates);

		if ($totDates > 1
			&& $next_date > $site_today_date)
		{
			rsort($alldates);

			$last_date = JHtml::date($alldates[0], 'Y-m-d', $eventTimeZone);

			if ( ! $next_is_in_period
				&& $last_date == $next_date)
			{
				$dateText = JText::_( 'COM_ICAGENDA_EVENT_DATE_LAST' );
			}
			elseif ( ! $next_is_in_period)
			{
				$dateText = JText::_( 'COM_ICAGENDA_EVENT_DATE_FUTUR' );
			}
			elseif ($next_is_in_period
				&& $weekdays == NULL)
			{
				$dateText = JText::_( 'COM_ICAGENDA_LEGEND_DATES' );
			}
			else
			{
				$dateText = JText::_( 'COM_ICAGENDA_EVENT_DATE' );
			}
		}
		elseif ($totDates > 1
			&& $next_date < $site_today_date)
		{
			if ($totDates == 2)
			{
				$dateText	= $next_is_in_period
							? JText::_( 'COM_ICAGENDA_EVENT_DATE' )
							: JText::_( 'COM_ICAGENDA_EVENT_DATE_PAST' );
			}
			else
			{
				$dateText	= ($next_is_in_period && $weekdays == NULL)
							? JText::_( 'COM_ICAGENDA_LEGEND_DATES' )
							: JText::_( 'COM_ICAGENDA_EVENT_DATE_PAST' );
			}
		}
		elseif ($next_date == $site_today_date)
		{
			$dateText = $next_is_in_period ? JText::_( 'COM_ICAGENDA_EVENT_DATE_PERIOD_NOW' ) : JText::_( 'COM_ICAGENDA_EVENT_DATE_TODAY' );
		}
		else
		{
			$dateText = JText::_( 'COM_ICAGENDA_EVENT_DATE' );
		}

		return $dateText;
	}

	/**
	 * Get Next Date (or Last Date)
	 *
	 * @version 3.4.0-rc
	 */
	protected function nextDate($i)
	{
		$eventTimeZone = null;

		$period			= unserialize($i->period); // returns array
		$startdatetime	= $i->startdate;
		$enddatetime	= $i->enddate;
		$weekdays		= $i->weekdays;

		$site_today_date	= JHtml::date('now', 'Y-m-d');
		$UTC_today_date		= JHtml::date('now', 'Y-m-d', $eventTimeZone);

		$next_date			= JHtml::date($i->next, 'Y-m-d', $eventTimeZone);
		$next_datetime		= JHtml::date($i->next, 'Y-m-d H:i', $eventTimeZone);

		$start_date			= JHtml::date($i->startdate, 'Y-m-d', $eventTimeZone);
		$end_date			= JHtml::date($i->enddate, 'Y-m-d', $eventTimeZone);

		// Check if date from a period with weekdays has end time of the period set in next.
//		$time_next_datetime	= JHtml::date($next_datetime, 'H:i', $eventTimeZone);
		$time_next_datetime	= date('H:i', strtotime($next_datetime));
		$time_startdate		= JHtml::date($i->startdate, 'H:i', $eventTimeZone);
		$time_enddate		= JHtml::date($i->enddate, 'H:i', $eventTimeZone);

		if ($next_date == $site_today_date
			&& $time_next_datetime == $time_enddate)
		{
			$next_datetime = $next_date . ' ' . $time_startdate;
		}

		if ($period != NULL && in_array($next_datetime, $period))
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
			$nextDate.= $this->formatDate($i->next);
			$nextDate.= '</span>';

			if ($this->displaytime($i) == 1)
			{
				$nextDate.= ' <span class="ic-single-starttime">' . $this->startTime($i) . '</span>';

				if ($this->startTime($i) != $this->endTime($i))
				{
					$nextDate.= $separator . '<span class="ic-single-endtime">' . $this->endTime($i) . '</span>';
				}
			}

			$nextDate.= $end_span;
		}
		elseif ( $next_is_in_period
			&& ($weekdays == null) )
		{
			// Next in the period & different start/end date & no weekday selected
			$start	= '<span class="ic-period-startdate">';
			$start	.= $this->startDate($i);
			$start	.= '</span>';

			$end	= '<span class="ic-period-enddate">';
			$end	.= $this->endDate($i);
			$end	.= '</span>';

			if ($this->displaytime($i) == 1)
			{
				$start		.= ' <span class="ic-period-starttime">' . $this->startTime($i) . '</span>';
				$end		.= ' <span class="ic-period-endtime">' . $this->endTime($i) . '</span>';
			}

			$nextDate = $start_span . $start . $separator . $end . $end_span;
		}
		else
		{
			// Next is a single date
			$nextDate = $start_span;
			$nextDate.= '<span class="ic-single-next">';
			$nextDate.= $this->formatDate($i->next);
			$nextDate.= '</span>';

			if ($this->displaytime($i) == 1)
			{
				$nextDate.= ' <span class="ic-single-starttime">' . $this->evenTime($i) . '</span>';
			}

			$nextDate.= $end_span;
		}

		return $nextDate;
	}


	// Control Upcoming dates Period
	protected function periodControl ($i)
	{
		$eventTimeZone		= null;
		$date_today			= JHtml::date('now', 'Y-m-d');
		$datetime_enddate	= JHtml::date($i->enddate, 'Y-m-d H:i', $eventTimeZone);
		$upPeriod			= '1';

		if (strtotime($datetime_enddate) > strtotime($date_today))
		{
			return $upPeriod;
		}
	}


	public static function getNbTicketsBooked($date, $event_registered, $event_id = null, $date_control = null)
	{
		$eventTimeZone		= null;
		$event_registered	= is_array($event_registered) ? $event_registered : array();
		$nb_registrations	= 0;

		// Get Date if set in url as var
		$get_date = JRequest::getVar('date', null);

		if ( ! $get_date && $date_control)
		{
			$get_date = null;
		}

		foreach ($event_registered AS $reg)
		{
			$ex_reg = explode('@@', $reg); // eventid@@date@@people

			if ( ! $date || $date == 'period')
			{
				$nb_registrations = $nb_registrations + $ex_reg[2];
			}
			elseif ($get_date
				&& $event_id == $ex_reg[0]
				&& date('Y-m-d H:i', strtotime($date)) == date('Y-m-d H:i', strtotime($ex_reg[1]))
				)
			{
				$nb_registrations = $nb_registrations + $ex_reg[2];
			}
			elseif ( ! $get_date
				&& $event_id == $ex_reg[0]
				&& $ex_reg[1] == 'period'
				)
			{
				$nb_registrations = $nb_registrations + $ex_reg[2];
			}
			elseif ( ! $get_date
				&& $event_id == $ex_reg[0]
				&& date('Y-m-d H:i', strtotime($date)) == date('Y-m-d H:i', strtotime($ex_reg[1]))
				)
			{
				$nb_registrations = $nb_registrations + $ex_reg[2];
			}
		}

		return $nb_registrations;
	}


	// Ticket(s) booked
	protected function totalRegistered($i)
	{
		$eventTimeZone		= null;
		$date_today			= JHtml::date('now', 'Y-m-d');
		$allDates			= $this->eventAllDates($i);
		$typeReg			= $this->evtParams($i)->get('typeReg', '');
		$perioddates		= iCDatePeriod::listDates($i->startdate, $i->enddate, $eventTimeZone);

		// Check the period if individual dates
		$only_startdate		= ($i->weekdays || $i->weekdays == '0') ? false : true;

		sort($allDates);

		$total_tickets_booked = 0;

		// Get Date if set in url as var
		$get_date = JRequest::getVar('date', null);

		if ($get_date)
		{
			$ex = explode('-', $get_date);

			if (count($ex) == 5)
			{
				$dateday = $ex['0'] . '-' . $ex['1'] . '-' . $ex['2'] . ' ' . $ex['3'] . ':' . $ex['4'];
			}
			else
			{
				$dateday = '';
			}
		}
		else
		{
			$dateday = '';
		}

		$this_date	= ! empty($dateday) ? JHtml::date($dateday, 'Y-m-d H:i:s', $eventTimeZone) : null;

		// By Single Dates (registration type is not for all dates of the events)
		if ($typeReg != 2)
		{
			foreach ($allDates as $k => $d)
			{
				$date_control	= JHtml::date($d, 'Y-m-d H:i', $eventTimeZone);

				if ($only_startdate && in_array($date_control, $perioddates))
				{
					$is_full_period = true;
				}
				else
				{
					$is_full_period = false;
				}

				$datetime_date	= date('Y-m-d H:i:s', strtotime($d));
				$nb_tickets		= self::getNbTicketsBooked($datetime_date, $i->registered, $i->id, $is_full_period);

				// NO Date in URL - FULL PERIOD (no weekdays) - Date IS in the PERIOD
				if ( ! $get_date && $only_startdate && in_array($date_control, $perioddates))
				{
					$total_tickets_booked		= $nb_tickets;
				}

				// Date in URL - FULL PERIOD (no weekdays) - Date IS NOT in the PERIOD
				elseif ($get_date && $only_startdate && ! in_array($date_control, $perioddates))
				{
					if ($nb_tickets > 0
						&& strtotime($this_date) == strtotime($datetime_date))
					{
						$total_tickets_booked	= $total_tickets_booked + $nb_tickets;
					}

					// Only one date for registration, and the setting option of event is set to list of dates (equals "for all dates of event)
					elseif (count($allDates) == 1)
					{
						$nb_tickets				= self::getNbTicketsBooked(null, $i->registered, $i->id, $is_full_period);
						$total_tickets_booked	= $total_tickets_booked + $nb_tickets;
					}
				}

				// Date in URL - PERIOD is Individual DATES (weekdays selected)
				elseif ($get_date && ! $only_startdate)
				{
					if ($nb_tickets > 0
						&& strtotime($this_date) == strtotime($datetime_date))
					{
						$total_tickets_booked	= $total_tickets_booked + $nb_tickets;
					}
				}

				// NO Date in URL (all tickets for the events, not taking into account the dates)
				elseif (! $get_date)
				{
					if ($nb_tickets > 0)
					{
						$total_tickets_booked	= self::getNbTicketsBooked(null, $i->registered, $i->id, $is_full_period);
					}
				}
			}
		}
		else
		{
			$nb_tickets = self::getNbTicketsBooked('period', $i->registered, $i->id);
			$total_tickets_booked = $nb_tickets;
		}

		return $total_tickets_booked;
	}

	// Ticket(s) could be booked
	protected function ticketsCouldBeBooked($i)
	{
		$eventTimeZone		= null;
		$date_today			= JHtml::date('now', 'Y-m-d');
		$allDates			= $this->eventAllDates($i);
		$max_tickets		= $this->evtParams($i)->get('maxReg', '1000000');
		$typeReg			= $this->evtParams($i)->get('typeReg', '1');
		$perioddates		= iCDatePeriod::listDates($i->startdate, $i->enddate, $eventTimeZone);

		// Check the period if individual dates
		$only_startdate		= ($i->weekdays || $i->weekdays == '0') ? false : true;

		sort($allDates);

		$total_tickets_bookable = 0;

		foreach ($allDates as $k => $d)
		{
			$date_control	= JHtml::date($d, 'Y-m-d H:i', $eventTimeZone);
			$is_in_period	= in_array($date_control, $perioddates) ? true : false;

			if ($only_startdate && $is_in_period)
			{
				$is_full_period = true;
			}
			else
			{
				$is_full_period = false;
			}

			$datetime_date		= date('Y-m-d H:i:s', strtotime($d));
			$datetime_startdate	= date('Y-m-d H:i:s', strtotime($i->startdate));
			$datetime_enddate	= date('Y-m-d H:i:s', strtotime($i->enddate));

			$nb_tickets_left	= $max_tickets - self::getNbTicketsBooked($datetime_date, $i->registered, $i->id, $is_full_period);

			if ($is_full_period
				&& $typeReg == 2
				&& (strtotime($datetime_startdate) < strtotime($date_today))
				)
			{
				$total_tickets_bookable = 0;
			}
			elseif (strtotime($d) > strtotime($date_today))
			{
				if ($nb_tickets_left > 0)
				{
					$total_tickets_bookable = $total_tickets_bookable + $nb_tickets_left;
				}
			}
		}

		if ($total_tickets_bookable > 0)
		{
			return true;
		}

		return false;
	}


	// Dates Drop list Registration
	protected function datelistMkt($i)
	{
		$eventTimeZone		= null;
		$date_today			= JHtml::date('now', 'Y-m-d');
		$date_time_today	= JHtml::date('now', 'Y-m-d H:i');
		$allDates			= $this->eventAllDates($i);
		$timeformat			= $this->options['timeformat'];
		$max_tickets		= $this->evtParams($i)->get('maxReg', '1000000');
		$perioddates		= iCDatePeriod::listDates($i->startdate, $i->enddate, $eventTimeZone);
		$regUntilEnd		= JComponentHelper::getParams('com_icagenda')->get('reg_end_period', 0);

		// Check the period if individual dates
		$only_startdate		= ($i->weekdays || $i->weekdays == '0') ? false : true;

		$lang_time = ($timeformat == 1) ? 'H:i' : 'h:i A';

		sort($allDates);

		$p = 0;

		foreach ($allDates as $k => $d)
		{
			$date_control = JHtml::date($d, 'Y-m-d H:i', $eventTimeZone);

			if ($only_startdate && in_array($date_control, $perioddates))
			{
				$is_full_period = true;
				$datetime_date	= ($regUntilEnd == 1)
								? date('Y-m-d H:i:s', strtotime($i->enddate))
								: date('Y-m-d H:i:s', strtotime($i->startdate));
			}
			else
			{
				$is_full_period = false;
				$datetime_date	= date('Y-m-d H:i:s', strtotime($d));
			}

			$nb_tickets_left	= $max_tickets - self::getNbTicketsBooked($datetime_date, $i->registered, $i->id, $is_full_period);

			$date_today_compare	= ($this->displaytime($i) == 1) ? $date_time_today : $date_today;

			if (strtotime($datetime_date) > strtotime($date_today_compare)
				&& $nb_tickets_left > 0)
			{
				$tickets_left = ($max_tickets != '1000000') ? ' [' . $nb_tickets_left . ']' : '';

				if ($is_full_period)
				{
					if ($p == 0)
					{
						$upDays[$k] = '@@' . $this->formatDate($i->startdate) . ' &#x279c; ' . $this->formatDate($i->enddate) . $tickets_left;
						$p = $p+1;
					}
				}
				else
				{
					$date = $this->formatDate($d);

					$event_time = ($this->displaytime($i) == 1) ? ' - '.date($lang_time, strtotime($datetime_date)) : '';

					$upDays[$k] = $datetime_date . '@@' . $date . $event_time . $tickets_left;
				}
			}
		}

		if (isset($upDays))
		{
			return $upDays;
		}
	}

	// Function return true if upcoming dates for Booking
	protected function upcomingDatesBooking($i)
	{
		if (count($this->datelistMkt($i)) > 0)
		{
			return true;
		}

		return false;
	}

	// All Single Dates in Event Details Page
	protected function datelistUl ($i)
	{
		$iCparams		= JComponentHelper::getParams('com_icagenda');
		$timeformat		= $this->options['timeformat'];

		// Hide/Show Option
		$SingleDates			= $iCparams->get('SingleDates', 1);

		// Access Levels Option
//		$accessSingleDates		= $iCparams->get('accessSingleDates', 1);

		// Order by Dates
		$SingleDatesOrder		= $iCparams->get('SingleDatesOrder', 1);

		// List Model
		$SingleDatesListModel	= $iCparams->get('SingleDatesListModel', 1);

		if ($SingleDates == 1)
		{
//			if ($this->accessLevels($accessSingleDates))
//			{
//				$days = unserialize($i->dates);
				$days = iCString::isSerialized($i->dates) ? unserialize($i->dates) : array(); // returns array

				if ($SingleDatesOrder == 1)
				{
					rsort($days);
				}
				elseif ($SingleDatesOrder == 2)
				{
					sort($days);
				}

				$totDates = count($days);

				if ($timeformat == 1)
				{
					$lang_time = 'H:i';
				}
				else
				{
					$lang_time = 'h:i A';
				}

				// Detect if Singles Dates, and no single date with null value
				$displayDates = false;
				$nbDays = count($days);

				foreach ($days as $k => $d)
				{
					if ($d != '0000-00-00 00:00' && $d != '0000-00-00 00:00:00'
						&& $nbDays != 0)
					{
						$displayDates = true;
					}
				}

				$daysUl = '';

				if ($displayDates)
				{
					if ($SingleDatesListModel == '2')
					{
						$n = 0;
						$daysUl.= '<div class="alldates"><i>'. JText::_( 'COM_ICAGENDA_LEGEND_DATES' ).': </i>';

						foreach ($days as $k => $d)
						{
							$n	= $n+1;
							$fd	= $this->formatDate($d);

							$timeDate	= ($this->displaytime($i) == 1)
										? ' <span class="evttime">'.date($lang_time, strtotime($d)).'</span>'
										: '';

							if ($n <= ($totDates-1))
							{
								$daysUl.= '<span class="alldates">'.$fd.$timeDate.'</span> - ';
							}
							elseif ($n == $totDates)
							{
	   							$daysUl.= '<span class="alldates">'.$fd.$timeDate.'</span>';
							}
						}

						$daysUl.= '</div>';
					}
					else
					{
						$daysUl.= '<ul class="alldates">';

						foreach ($days as $k => $d)
						{
							$fd	= $this->formatDate($d);

							$timeDate	= ($this->displaytime($i) == 1)
										? ' <span class="evttime">'.date($lang_time, strtotime($d)).'</span>'
										: '';

							$daysUl.= '<li class="alldates">'.$fd.$timeDate.'</li>';
						}

						$daysUl.= '</ul>';
					}
				}

				if ($totDates > '0')
				{
					return $daysUl;
				}
				else
				{
					return false;
				}
//			}
//			else
//			{
//				return false;
//			}
		}
		else
		{
			return false;
		}
	}

	// Function Period Display in Registration
	protected function periodDisplay($i)
	{
		if ($this->eventHasPeriod($i))
		{
			if (iCDate::isDate($i->startdate) || iCDate::isDate($i->enddate))
			{
				$show = '1';

				return $show;
			}
		}
	}

	// Format Start Date of a period
	protected function startDate($i)
	{
		return $this->formatDate($i->startdate);;
	}

	// Format End Date of a period
	protected function endDate($i)
	{
		return $this->formatDate($i->enddate);
	}

	// Start Day of a period (numeric 1)
	protected function startDay($i)
	{
		$day_format		= 'd-m-Y';
		$start_day		= date($day_format, strtotime($i->startdate));
		$format			= '%e';

		if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
		{
			$format = preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $format);
		}

		$startDay	= iCDate::isDate($i->startdate)
					? strftime($format, strtotime($start_day))
					: '&nbsp;&nbsp;';

		return $startDay;
	}

	// End Day of a period (numeric 1)
	protected function endDay($i)
	{
		$day_format		= 'd-m-Y';
		$end_day		= date($day_format, strtotime($i->enddate));
		$format			= '%e';

		if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
		{
			$format = preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $format);
		}

		$endDay	= iCDate::isDate($i->enddate)
				? strftime($format, strtotime($end_day))
				: '&nbsp;&nbsp;';

		return $endDay;
	}

	// End Month of a period (numeric 01)
	protected function endMonthNum($i)
	{
		$eventTimeZone	= null;
		$endMonthNum	= JHtml::date($i->enddate, 'm', $eventTimeZone);

		return JText::_($endMonthNum);
	}

	// End Month of a period (text January)
	protected function endMonth($i)
	{
		$eventTimeZone	= null;
		$endMonth		= JHtml::date($i->enddate, 'F', $eventTimeZone);

		return JText::_($endMonth);
	}

	// End Year of a period (numeric 2001)
	protected function endYear($i)
	{
		$eventTimeZone	= null;
		$endYear		= JHtml::date($i->enddate, 'Y', $eventTimeZone);

		return JText::_($endYear);
	}

	// Format Start Time of a period
	protected function startTime($i)
	{
		$eventTimeZone		= null;
		$datetime_startdate	= JHtml::date($i->startdate, 'Y-m-d H:i', $eventTimeZone);
		$timeformat			= $this->options['timeformat'];

		$lang_time = ($timeformat == 1) ? 'H:i' : 'h:i A';

		$startTime = date($lang_time, strtotime($datetime_startdate));

		if ($this->displaytime($i) == 1)
		{
			return $startTime;
		}
	}

	// Format End Time of a period
	protected function endTime($i)
	{
		$eventTimeZone		= null;
		$datetime_enddate	= JHtml::date($i->enddate, 'Y-m-d H:i', $eventTimeZone);
		$timeformat			= $this->options['timeformat'];

		$lang_time = ($timeformat == 1) ? 'H:i' : 'h:i A';

		$endTime = date($lang_time, strtotime($datetime_enddate));

		if ($this->displaytime($i) == 1)
		{
			return $endTime;
		}
	}


	// Display period text width Format Date (eg. from 00-00-0000 to 00-00-0000)
	protected function periodDates ($i)
	{
		$iCparams = JComponentHelper::getParams('com_icagenda');

		// Hide/Show Option
		$PeriodDates = $iCparams->get('PeriodDates', 1);

		// Access Levels Option
		$accessPeriodDates = $iCparams->get('accessPeriodDates', 1);

		// List Model
		$SingleDatesListModel = $iCparams->get('SingleDatesListModel', 1);

		// First day of the week
		$firstday_week_global = $iCparams->get('firstday_week_global', 1);

		// WeekDays
		$weekdays = $i->weekdays;
		$weekdaysall = empty($weekdays) ? true : false;

		if ($firstday_week_global == '1')
		{
			$weekdays_array = explode (',', $weekdays);

			if (in_array('0', $weekdays_array))
			{
				$weekdays = str_replace('0', '', $weekdays);
				$weekdays = $weekdays.',7';
			}
		}

		if (!$weekdaysall)
		{
			$weekdays_array = explode (',', $weekdays);
			$wdaysArray = array();

			foreach ($weekdays_array AS $wd)
			{
				if ($firstday_week_global != '1')
				{
					if ($wd == 0) $wdaysArray[] = JText::_( 'SUNDAY' );
				}
				if ($wd == 1) $wdaysArray[] = JText::_( 'MONDAY' );
				if ($wd == 2) $wdaysArray[] = JText::_( 'TUESDAY' );
				if ($wd == 3) $wdaysArray[] = JText::_( 'WEDNESDAY' );
				if ($wd == 4) $wdaysArray[] = JText::_( 'THURSDAY' );
				if ($wd == 5) $wdaysArray[] = JText::_( 'FRIDAY' );
				if ($wd == 6) $wdaysArray[] = JText::_( 'SATURDAY' );
				if ($firstday_week_global == '1')
				{
					if ($wd == 7) $wdaysArray[] = JText::_( 'SUNDAY' );
				}
			}

			$last  = array_slice($wdaysArray, -1);
			$first = join(', ', array_slice($wdaysArray, 0, -1));
			$both  = array_filter(array_merge(array($first), $last));

			// RTL css if site language is RTL
			$lang = JFactory::getLanguage();

			if ( $lang->isRTL() )
			{
				$arrow_list = '&#8629;';
			}
			else
			{
				$arrow_list = '&#8627;';
			}

			$wdays = $arrow_list . ' <small><i>' . join(' & ', $both) . '</i></small>';
		}
		else
		{
			$wdays = '';
		}

		$showDays ='';

		if ( $PeriodDates == 1 )
		{
			// NOT CURRENTLY USED (is this option needed?)
//			if ( $this->accessLevels($accessPeriodDates) )
//			{
				$startDate	= $this->formatDate($i->startdate);
				$endDate	= $this->formatDate($i->enddate);

				if ($startDate == $endDate)
				{
					$start = $this->startDate($i);
					$end = '';

					if ($this->displaytime($i) == 1)
					{
						if ($this->startTime($i) !== $this->endTime($i))
						{
							$timeOneDay = '<span class="evttime">'.$this->startTime($i).' - '.$this->endTime($i).'</span>';
						}
						else
						{
							$timeOneDay = '<span class="evttime">'.$this->startTime($i).'</span>';
						}
					}
					else
					{
						$timeOneDay = '';
					}
				}
				else
				{
					$start = ucfirst(JText::_( 'COM_ICAGENDA_PERIOD_FROM' )).' '.$this->startDate($i).' <span class="evttime">'.$this->startTime($i).'</span>';
					$end = JText::_( 'COM_ICAGENDA_PERIOD_TO' ).' '.$this->endDate($i).' <span class="evttime">'.$this->endTime($i).'</span>';
					$showDays = $wdays;
					$timeOneDay = '';
				}

				if ($SingleDatesListModel == 2)
				{
					$period = '<div class="alldates"><i>'. JText::_( 'COM_ICAGENDA_EVENT_PERIOD' ).': </i>'.$start.' '.$end.' '.$timeOneDay;
					if (!empty($showDays))
					{
						$period.= '<br /><span style="margin-left:30px">'.$showDays.'</span>';
					}
					$period.= '</div>';
				}
				else
				{
					$period = '<ul class="alldates"><li>'.$start.' '.$end.' '.$timeOneDay;
					if (!empty($showDays))
					{
						$period.= '<br/>'.$showDays;
					}
					$period.= '</li></ul>';
				}

				if ($this->eventHasPeriod($i))
				{
					if (($i->startdate!='0000-00-00 00:00:00') AND ($i->enddate!='0000-00-00 00:00:00'))
					{
						return $period;
					}
				}
				else
				{
					return false;
				}
//			}
//			else
//			{
//				return false;
//			}
		}
		else
		{
			return false;
		}
	}


	// Function to get Format Date (event item)
	protected function formatDate($date)
	{
		// Date Format Option (Global Component Option)
		$date_format_global	= JComponentHelper::getParams('com_icagenda')->get('date_format_global', 'Y - m - d');
		$date_format_global	= ($date_format_global != 0) ? $date_format_global : 'Y - m - d'; // Previous 3.5.6 setting

		// Date Format Option (Menu Option)
		$date_format_menu	= JFactory::getApplication()->getParams()->get('format', '');
		$date_format_menu	= ($date_format_menu != 0) ? $date_format_menu : ''; // Previous 3.5.6 setting

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


	/**
	 * GOOGLE MAPS
	 */

	// Latitude
	protected function lat ($i)
	{
		if (($i->coordinate != NULL) && ($i->lat == '0.0000000000000000'))
		{
			$ex			= explode(', ', $i->coordinate);
			$latresult	= $ex[0];
		}
		elseif ($i->lat != '0.0000000000000000')
		{
			$latresult	= $i->lat;
		}
		else
		{
			$latresult	= NULL;
		}

		return $latresult;
	}

	// Longitude
	protected function lng ($i)
	{
		if (($i->coordinate != NULL) && ($i->lng == '0.0000000000000000'))
		{
			$ex			= explode(', ', $i->coordinate);
			$lngresult	= $ex[1];
		}
		elseif ($i->lng != '0.0000000000000000')
		{
			$lngresult	= $i->lng;
		}
		else
		{
			$lngresult	= NULL;
		}

		return $lngresult;
	}

	// Function Map
	protected function map ($i)
	{
		$maplat	= $this->lat($i);
		$maplng	= $this->lng($i);
		$mapid	= $i->id;

		$iCgmap = '<div class="icagenda_map" id="map_canvas'.(int)$mapid.'" style="width:'.$this->options['m_width'].'; height:'.$this->options['m_height'].'"></div>';
		$iCgmap.= '<script type="text/javascript">';
		$iCgmap.= 'initialize('.$maplat.', '.$maplng.', '.(int)$mapid.');';
		$iCgmap.= '</script>';

		return $iCgmap;
	}

	// Function Map
	protected function coordinate ($i)
	{
		// Hide/Show Option
		$GoogleMaps			= JComponentHelper::getParams('com_icagenda')->get('GoogleMaps', 1);

		// Access Levels Option
		$accessGoogleMaps	= JComponentHelper::getParams('com_icagenda')->get('accessGoogleMaps', 1);

		$maplat				= $this->lat($i);
		$maplng				= $this->lng($i);

		if ($GoogleMaps == 1
			&& $this->accessLevels($accessGoogleMaps)
			&& $maplat != NULL
			&& $maplng != NULL
			)
		{
			return true;
		}

		return false;
	}


	/**
	 * Registered Users List
	 */

	// Participant List Display
	protected function participantList($i)
	{
		$iCparams				= JComponentHelper::getParams('com_icagenda');

		// Get Option if usage of iCagenda registration form for this event
		$evtParams				= $this->evtParams($i);
		$regLink				= $evtParams->get('RegButtonLink', '');

		// Hide/Show Option
		$participantList		= $iCparams->get('participantList', 1);

		// Access Levels Option
		$accessParticipantList	= $iCparams->get('accessParticipantList', 1);

		if ($participantList == 1
			&& ! $regLink
			&& $this->accessLevels($accessParticipantList)
			)
		{
			return $participantList;
		}

		return false;
	}


	// Display Title List of Participants (if no slide effect)
	protected function participantListTitle($i)
	{
		// Get Option if usage of iCagenda registration form for this event
		$evtParams			= $this->evtParams($i);
		$regLink			= $evtParams->get('RegButtonLink', '');

		$participantList	= $this->options['participantList'];
		$participantSlide	= $this->options['participantSlide'];

		$registration		= $this->statutReg($i) ? $this->statutReg($i) : '';

		if ($participantSlide == 0
			&& $registration == 1
			&& $participantList == 1
			&& !$regLink
			)
		{
			return JText::_( 'COM_ICAGENDA_EVENT_LIST_OF_PARTICIPANTS');
		}
	}

	// Display Registered Users
	protected function registeredUsers($i)
	{
		$eventTimeZone = null;

		// Get Component PARAMS
		$iCparams = JComponentHelper::getParams('com_icagenda');

		// Preparing connection to db
		$db	= JFactory::getDBO();
		// Preparing the query
		$query = $db->getQuery(true);
		$query->select(' r.userid AS userid, r.name AS registeredUsers, r.date as regDate, r.people as regPeople, r.email as regEmail,
						u.name AS name, u.username AS username')
			->from('#__icagenda_registration AS r')
			->leftJoin('#__users as u ON u.id = r.userid')
			->where('(r.eventId='.(int)$i->id.') AND (r.state > 0)');
		$db->setQuery($query);

		$registeredUsers	= $db->loadObjectList();
		$nbusers			= count($registeredUsers);
		$nbmax				= $nbusers-1;
		$registration		= '';
		$registration		= $this->statutReg($i);
		$n					= '0';

		// Slide Params
		$participantList	= $iCparams->get('participantList', 1);
		$participantSlide	= $iCparams->get('participantSlide', 1);
		$participantDisplay	= $iCparams->get('participantDisplay', 1);
		$fullListColumns	= $iCparams->get('fullListColumns', 'tiers');

		// logged-in Users: Name/User Name Option
		$nameJoomlaUser		= $iCparams->get('nameJoomlaUser', 1);

		// Get Type Registration (for all dates or per date)
		$typeReg			= $this->evtParams($i)->get('typeReg', 1);

		// Get Date if set in url as var
		$get_date			= JRequest::getVar('date', null);

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
		else
		{
			$dateday = '';
		}

		$this_date	= JHtml::date($dateday, 'Y-m-d H:i', $eventTimeZone);

		// Start List of Participants
		jimport( 'joomla.html.html.sliders' );
		$slider_c = '';

		$list_participants = '';

		if ($participantList == 1 && $registration == 1)
		{
			$n_list='names_noslide';

			if ($participantSlide == 1)
			{
				$n_list = 'names_slide';
				$slider_c = 'class="pane-slider content"';
				$list_participants.= JHtml::_('sliders.start', 'icagenda', array('useCookie'=>0, 'startOffset'=>-1, 'startTransition'=>1));
				$list_participants.= JHtml::_('sliders.panel', JText::_('COM_ICAGENDA_EVENT_LIST_OF_PARTICIPANTS'), 'slide1');
			}

			foreach ($registeredUsers as $reguser)
			{
				$this_reg_date	= strtotime($reguser->regDate)
								? JHtml::date($reguser->regDate, 'Y-m-d H:i', $eventTimeZone)
								: $reguser->regDate;

				if ( ($this_reg_date == $this_date)
					|| ($typeReg == 2)
					)
				{
					$n = $n+1;
				}

				// Registration by dates, and registration date is not filled
				elseif ($typeReg == 1
					&& ! $this_reg_date)
				{
					$n = $n+1;
				}
			}

			if ($nbusers == NULL || ($n == 0 && ! empty($get_date)))
			{
				$list_participants.= '<div ' . $slider_c . '>';
				$list_participants.= '&nbsp;'.JText::_( 'COM_ICAGENDA_NO_REGISTRATION').'&nbsp;';
				$list_participants.= '</div>';
			}

			// Full display
			elseif ($participantDisplay == 1)
			{
				$column = isset($fullListColumns) ? $fullListColumns : 'tiers';

				$list_participants.= '<div ' . $slider_c . '>';

				foreach ($registeredUsers as $reguser)
				{
					$this_reg_date	= strtotime($reguser->regDate)
									? JHtml::date($reguser->regDate, 'Y-m-d H:i', $eventTimeZone)
									: $reguser->regDate;

					if ( ($this_reg_date == $this_date || empty($get_date))
						|| $typeReg == 2
						|| ($typeReg == 1 && ! $this_reg_date)
						)
					{
						$avatar = md5( strtolower( trim( $reguser->regEmail ) ) );

						// Get Username and name
						if ( ! empty($reguser->userid))
						{
							$data_name		= $reguser->name;
							$data_username	= $reguser->username;

							if ($nameJoomlaUser == 1)
							{
								$reguser->registeredUsers = $reguser->registeredUsers;
							}
							else
							{
								$reguser->registeredUsers = $data_username;
							}
						}

						$regDate = '';

						if (strtotime($reguser->regDate)) // Test if registered date before 3.3.3 could be converted
						{
							// Control if date valid format (Y-m-d H:i)
							$datetime_format	= 'Y-m-d H:i:s';
							$datetime_input		= $reguser->regDate;
							$datetime_input		= trim($datetime_input);
							$datetime_is_valid	= date($datetime_format, strtotime($datetime_input)) == $datetime_input;

							if ($datetime_is_valid) // New Data value (since 3.3.3)
							{
								$ex_reg_datetime_db	= explode (' ', $datetime_input);
								$registered_date	= $this->formatDate(date('Y-m-d', strtotime($ex_reg_datetime_db['0'])));
								$reg_time_get		= isset($ex_reg_datetime_db['1']) ? $ex_reg_datetime_db['1'] : '';
							}
							else // Test if old date format (before 3.3.3) could be converted. If not, displays old format.
							{
								$ex_reg_datetime	= explode (' - ', trim($reguser->regDate));

								// Control if date valid format (Y-m-d) - Means could be converted
								$date_format		= 'Y-m-d H:i:s';
								$date_input			= $ex_reg_datetime['0'];
								$date_input			= trim($date_input);
								$date_str			= strtotime($date_input);
								$date_is_valid		= date($date_format, $date_str) == $date_input;

								if ($date_is_valid)
								{
									$registered_date = $this->formatDate(date('Y-m-d', $date_str));
								}
								else
								{
									$registered_date = $ex_reg_datetime['0'];
								}

								$reg_time_get = isset($ex_reg_datetime['1']) ? $ex_reg_datetime['1'] : '';
							}

							$regDate.= $registered_date;

							if ($reg_time_get)
							{
								$regDate.= ' - '.date('H:i', strtotime($reg_time_get));
							}
						}
						else
						{
							$regDate.= $reguser->regDate;
						}

						if ($n <= $nbmax || $n == $nbusers)
						{
							$list_participants.= '<table class="list_table ' . $column . '" cellpadding="0"><tbody><tr><td class="imgbox"><img alt="' . $reguser->registeredUsers . '"  src="http://www.gravatar.com/avatar/' . $avatar . '?s=36&d=mm"/></td><td valign="middle"><span class="list_name">' . $reguser->registeredUsers . '</span><span class="list_places"> (' . $reguser->regPeople . ')</span><br /><span class="list_date">' . $regDate . '</span></td></tr></tbody></table>';
						}
					}
				}
				$list_participants.= '</div>';
			}

			// Avatar display
			elseif ($participantDisplay == 2)
			{
				$list_participants.= '<div ' . $slider_c . '>';

				foreach ($registeredUsers as $reguser)
				{
					$this_reg_date	= strtotime($reguser->regDate)
									? JHtml::date($reguser->regDate, 'Y-m-d H:i', $eventTimeZone)
									: $reguser->regDate;

					if ( ($this_reg_date == $this_date || empty($get_date))
						|| $typeReg == 2
						|| ($typeReg == 1 && ! $this_reg_date)
						)
					{
						$avatar	= md5(strtolower(trim($reguser->regEmail)));

						// Get Username and name
						if ( ! empty($reguser->userid))
						{
							$data_name		= $reguser->name;
							$data_username	= $reguser->username;

							if ($nameJoomlaUser == 1)
							{
								$reguser->registeredUsers = $data_name;
							}
							else
							{
								$reguser->registeredUsers = $data_username;
							}
						}

						if ($n <= $nbmax || $n == $nbusers)
						{
							$list_participants.= '<div style="width: 76px; height: 80px; float:left; margin:2px; text-align:center;"><img style="border-radius: 3px 3px 3px 3px; margin:2px 0px;" alt="' . $reguser->registeredUsers . '"  src="http://www.gravatar.com/avatar/' . $avatar . '?s=48&d=mm"/><br/><strong style="text-align:center; font-size:9px;">' . $reguser->registeredUsers . '</strong></div>';
						}
					}
				}
				$list_participants.= '</div>';
			}

			// Name/username display
			elseif ($participantDisplay == 3)
			{
				$list_participants.= '<div ' . $slider_c . '>';
				$list_participants.= '<div class="' . $n_list . '">';

				$list_username = '';

				foreach ($registeredUsers as $reguser)
				{
					$this_reg_date	= strtotime($reguser->regDate)
									? JHtml::date($reguser->regDate, 'Y-m-d H:i', $eventTimeZone)
									: $reguser->regDate;

					if ( ($this_reg_date == $this_date ||empty($get_date))
						|| $typeReg == 2
						|| ($typeReg == 1 && ! $this_reg_date)
						)
					{

						// Get Username and name
						if ( ! empty($reguser->userid))
						{
							$data_name		= $reguser->name;
							$data_username	= $reguser->username;

							if ($nameJoomlaUser == 1)
							{
								$reguser->registeredUsers = $data_name;
							}
							else
							{
								$reguser->registeredUsers = $data_username;
							}
						}

						$list_username.= $reguser->registeredUsers . ', ';
					}
				}

				$list_participants.= trim($list_username, ", ");

				$list_participants.= '</div>';
				$list_participants.= '</div>';
			}

			if ($participantSlide == 1)
			{
				$list_participants.= JHtml::_('sliders.end');
			}
		}
		else
		{
			$list_participants.= '';
		}

		return $list_participants;
	}


	/**
	 * SPECIAL FUNCTIONS
	 */

	// function Event Options
	protected function evtParams($i)
	{
		$evtParams = '';
		$evtParams = new JRegistry($i->params);

		return $evtParams;
	}

	// Function if Period Dates exist // DEPRECATED
	protected function periodTest($i)
	{
		$daysp = unserialize($i->period);

		if ($daysp != NULL)
		{
			return true;
		}

		return false;
	}

	/*
	 * Function if Period Dates exist for this event
	 */
	protected function eventHasPeriod($i)
	{
		$period_dates = iCString::isSerialized($i->period) ? unserialize($i->period) : array(); // returns array

		if (count($period_dates) > 0)
		{
			return true;
		}

		return false;
	}


	/* TO BE MOVED TO UTILITIES LIBRARY
	 * Function to check if user has access rights to defined access
	 *
	 * $accessLevel		Access level of the item to check User Permissions
	 *
	 * If in super user group, always allowed
	 */
	protected function accessLevels($accessLevel)
	{
		// Get User Access Levels
		$user		= JFactory::getUser();
		$userLevels	= $user->getAuthorisedViewLevels();
		$userGroups = version_compare(JVERSION, '3.0', 'ge') ? $user->groups : $user->getAuthorisedGroups();

		// Control: if access level, or Super User
		if (in_array($accessLevel, $userLevels)
			|| in_array('8', $userGroups))
		{
			return true;
		}

		return false;
	}


	/*
	 * Function to detect if info details exist in an event,
	 * and to hide or show it depending of Options (display and access levels)
	 */
	protected function infoDetails($i)
	{
		// Hide/Show Option
		$infoDetails		= JComponentHelper::getParams('com_icagenda')->get('infoDetails', 1);

		// Access Levels Option
		$accessInfoDetails	= JComponentHelper::getParams('com_icagenda')->get('accessInfoDetails', 1);

		if ( ($infoDetails == 1 && $this->accessLevels($accessInfoDetails))
			&& (($this->statutReg($i) == '1' && $this->maxNbTickets($i))
				|| $i->phone
				|| $i->email
				|| $i->website
				|| $i->address
				|| $i->file
				)
			)
		{
			return true;
		}

		return false;
	}


	/**
	 * ADDTHIS - Social Networks
	 */

	// function to override general options display of AddThis in event details view
	protected function ateventshow($i)
	{
		$atevent		= $this->options['atevent'];
		$evtParams		= $this->evtParams($i);
		$eventatvent	= $evtParams->get('atevent', '');

		$show = ($eventatvent == '') ? $atevent : $eventatvent;

		return $show;
	}

	// function option display AddThis social networks sharing
	protected function share_event($i)
	{
		$at = $this->ateventshow($i);

		if ($at == 1)
		{
			$share = $this->share($i);
		}
		else
		{
			$share = NULL;
		}

		return $share;
	}

	// function AddThis social networks sharing
	protected function share ($i)
	{
		$addthis	= $this->options['addthis'];
		$float		= $this->options['atfloat'];
		$icon		= $this->options['aticon'];

		if ($float == 1)
		{
			$floataddthis	= 'floating';
			$float_position	= 'position: fixed;';
			$float_side		= 'left';
		}
		elseif ($float == 2)
		{
			$floataddthis	= 'floating';
			$float_position	= 'position: fixed;';
			$float_side		= 'right';
		}
		else
		{
			$floataddthis	= 'default';
			$float_position	= '';
			$float_side		= 'right';
		}

		if ($icon == 2)
		{
			$iconaddthis	= '32x32';
		}
		else
		{
			$iconaddthis	= '16x16';
		}

		$at_div = '<div class="share ic-share" style="' . $float_position . '">';
		$at_div.= '<!-- AddThis Button BEGIN -->';
		$at_div.= '<div class="addthis_toolbox';
		$at_div.= ' addthis_' . $floataddthis . '_style';
		$at_div.= ' addthis_' . $iconaddthis . '_style"';
		$at_div.= ' style="' . $float_side . ': 2%; top: 40%;">';
		$at_div.= '<a class="addthis_button_preferred_1"></a>';
		$at_div.= '<a class="addthis_button_preferred_2"></a>';
		$at_div.= '<a class="addthis_button_preferred_3"></a>';
		$at_div.= '<a class="addthis_button_preferred_4"></a>';
		$at_div.= '<a class="addthis_button_compact"></a>';
		$at_div.= '<a class="addthis_counter addthis_bubble_style"></a>';
		$at_div.= '</div>';

		if ($addthis)
		{
			$at_div.= '<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>';
			$at_div.= '<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=' . $this->options['addthis'] . '"></script>';
		}
		else
		{
			$at_div.= '<script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>';
			$at_div.= '<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5024db5322322e8b"></script>';
		}

		$at_div.= '<!-- AddThis Button END -->';
		$at_div.= '</div>';

		return $at_div;
	}


	/**
	 * REGISTRATIONS
	 */

	// function url to iCagenda registration page
	protected function iCagendaRegForm ($i)
	{
		$event_slug = empty($i->alias) ? $i->id : $i->id . ':' . $i->alias;

		$iCagendaRegForm = JROUTE::_('index.php?option=com_icagenda&view=list&layout=registration&Itemid='. (int) $this->options['Itemid'] . '&id=' . $event_slug);

		return $iCagendaRegForm;
	}

	// function link to registration page
	protected function regUrl($i)
	{
		$event_slug = empty($i->alias) ? $i->id : $i->id . ':' . $i->alias;

		$icagenda_form = JRoute::_('index.php?option=com_icagenda&view=list&layout=registration&Itemid='. (int) $this->options['Itemid'] . '&id=' . $event_slug);

		$evtParams			= $this->evtParams($i);
		$regLink			= $evtParams->get('RegButtonLink', '');
		$regLinkArticle		= $evtParams->get('RegButtonLink_Article', $icagenda_form);
		$regLinkUrl			= $evtParams->get('RegButtonLink_Url', $icagenda_form);
		$RegButtonTarget	= $evtParams->get('RegButtonTarget', '0');

		if ($RegButtonTarget == 1)
		{
			$browserTarget = '_blank';
		}
		else
		{
			$browserTarget = '_parent';
		}

		if ($regLink == 1 && is_numeric($regLinkArticle))
		{
			$regUrl = JURI::root() . 'index.php?option=com_content&view=article&id=' . $regLinkArticle . '" rel="nofollow" target="' . $browserTarget;
		}
		elseif ($regLink == 2)
		{
			$regUrl = $regLinkUrl . '" rel="nofollow" target="' . $browserTarget;
		}
		else
		{
			$regUrl = $icagenda_form . '" rel="nofollow" target="' . $browserTarget;
		}

		return $regUrl;
	}

	/*
	 * Function to return Registration Status for this event
	 */
	protected function statutReg($i)
	{
		$gstatutReg		= $this->options['statutReg'];

		$evtParams		= $this->evtParams($i);
		$evtstatutReg	= $evtParams->get('statutReg', '');

		// Control and edit param values to iCagenda v3
		if ($evtstatutReg == '2')
		{
			$evtstatutReg = '0';
		}

		$statutReg = ($evtstatutReg != '') ? $evtstatutReg : $gstatutReg;

		return $statutReg;
	}

	/*
	 * Function to return Registration Access Level for this event
	 */
	protected function accessReg($i)
	{
		$reg_form_access	= JComponentHelper::getParams('com_icagenda')->get('reg_form_access', 1);
		$evtParams			= $this->evtParams($i);
		$accessReg			= $evtParams->get('accessReg', $reg_form_access);

		return $accessReg;
	}

	// function Registration Type TO BE CHECKED IF USED AS FUNCTION
	protected function typeReg($i)
	{
		$evtParams	= $this->evtParams($i);
		$typeReg	= $evtParams->get('typeReg', '');

		return $typeReg;
	}

	// function Max places per registration
	protected function maxRlist($i)
	{
		$maxRlist = '';
		$gmaxRlist = $this->options['maxRlist'];

		$evtParams			= $this->evtParams($i);
		$evtmaxRlistGlobal	= $evtParams->get('maxRlistGlobal');
		$evtmaxRlist		= $evtParams->get('maxRlist');

		// Control and edit param values to iCagenda v3
		if ($evtmaxRlistGlobal == '1')
		{
			$evtmaxRlistGlobal = '';
		}
		elseif ($evtmaxRlistGlobal == '0')
		{
			$evtmaxRlistGlobal = '2';
		}

		if ($evtmaxRlistGlobal == '2')
		{
			$maxRlist = $evtmaxRlist;
		}
		else
		{
			$maxRlist = $gmaxRlist;
		}

		return $maxRlist;
	}

	// Keep for B/C : DEPRECATED!
	// Function Max Registrations per event (OLD before 3.2.8, for use with old theme packs or custom one)
	protected function maxReg($i)
	{
		$evtParams	= $this->evtParams($i);
		$maxReg		= $evtParams->get('maxReg', '1000000');

		return $maxReg;
	}

	// function Max Nb Tickets (Control if set)
	protected function maxNbTickets($i)
	{
		$maxNbTickets = $this->evtParams($i)->get('maxReg', '1000000');

		if ($maxNbTickets != '1000000'
			&& ($this->statutReg($i) == '1'))
		{
			return $maxNbTickets;
		}
	}

	// function Email Required
	protected function emailRequired($i)
	{
		return $this->options['emailRequired'];
	}

	// function Phone Required
	protected function phoneRequired($i)
	{
		return $this->options['phoneRequired'];
	}

	// function pre-formated to display Register button and registered bubble
	protected function reg($i)
	{
		$reg					= $this->statutReg($i);
		$accessreg				= $this->accessReg($i);
		$nbreg					= $this->totalRegistered($i);
		$maxreg					= $this->maxReg($i);
		$upcomingDatesBooking	= $this->upcomingDatesBooking($i);
		$ticketsCouldBeBooked	= $this->ticketsCouldBeBooked($i);
		$regUntilEnd			= JComponentHelper::getParams('com_icagenda')->get('reg_end_period', 0);
		$typeReg				= $this->evtParams($i)->get('typeReg', '1');

		// Initialize controls
		$date_today			= JHtml::date('now', 'Y-m-d');
		$date_time_today	= JHtml::date('now', 'Y-m-d H:i');
		$access		= '0';
		$control	= '';
		$TextRegBt	= '';

		$get_date = JRequest::getVar('date', '');

		if ($get_date)
		{
			$ex = explode('-', $get_date);

			$dateday	= (count($ex) == 5)
						? $ex['0'].'-'.$ex['1'].'-'.$ex['2'].' '.$ex['3'].':'.$ex['4']
						: '';

			$date_is_upcoming = (strtotime($dateday) > strtotime($date_time_today)) ? true : false;

			$is_full_period = false;
		}
		else
		{
			$period				= unserialize($i->period);
			$period				= is_array($period) ? $period : array();
			$only_startdate		= ($i->weekdays || $i->weekdays == '0') ? false : true;
			$datetime_startdate	= JHtml::date($i->startdate, 'Y-m-d H:i', null);

			if ($only_startdate && in_array($datetime_startdate, $period))
			{
				$is_full_period = true;
			}
			else
			{
				$is_full_period = false;
			}

			if (count($period) > 0
				&& $only_startdate
				&& (strtotime($datetime_startdate) < strtotime($date_time_today))
				)
			{
				$date_is_upcoming	= false;
			}
			else
			{
				$date_is_upcoming	= true;
			}
		}

		// Access Control
		$user		= JFactory::getUser();
		$userLevels	= $user->getAuthorisedViewLevels();

		$evtParams	= $this->evtParams($i);
		$regLink	= $evtParams->get('RegButtonLink', '');

		if ($evtParams->get('RegButtonText'))
		{
			$TextRegBt = $evtParams->get('RegButtonText');
		}
		elseif ($this->options['RegButtonText'])
		{
			$TextRegBt = $this->options['RegButtonText'];
		}
		else
		{
			$TextRegBt = JText::_( 'COM_ICAGENDA_REGISTRATION_REGISTER');
		}

		$regButton_type = ''; // DEV. NOT IN USE

		if ($regButton_type == 'button') // DEV. NOT IN USE
		{
			$doc = JFactory::getDocument();
			$style = '.regis_button {'
					. 'text-transform: none !important;'
					. 'padding: 10px 14px 10px;'
					. '-webkit-border-radius: 10px;'
					. '-moz-border-radius: 10px;'
					. 'border-radius: 10px;'
					. 'color: #FFFFFF;'
					. 'background-color: #D90000;'
					. '*background-color: #751616;'
					. 'background-image: -ms-linear-gradient(top,#D90000,#751616);'
					. 'background-image: -webkit-gradient(linear,0 0,0 100%,from(#D90000),to(#751616));'
					. 'background-image: -webkit-linear-gradient(top,#D90000,#751616);'
					. 'background-image: -o-linear-gradient(top,#D90000,#751616);'
					. 'background-image: linear-gradient(top,#D90000,#751616);'
					. 'background-image: -moz-linear-gradient(top,#D90000,#751616);'
					. 'background-repeat: repeat-x;'
					. 'filter: progid:dximagetransform.microsoft.gradient(startColorstr="#D90000",endColorstr="#751616",GradientType=0);'
					. 'filter: progid:dximagetransform.microsoft.gradient(enabled=false);'
					. '*zoom: 1;'
					. '-webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,0.2),0 1px 2px rgba(0,0,0,0.05);'
					. '-moz-box-shadow: inset 0 1px 0 rgba(255,255,255,0.2),0 1px 2px rgba(0,0,0,0.05);'
					. 'box-shadow: inset 0 1px 0 rgba(255,255,255,0.2),0 1px 2px rgba(0,0,0,0.05);'
					. '}'
					. '.regis_button:hover {'
					. 'color: #F9F9F9;'
					. 'background-color: #b60000;'
					. '*background-color: #531111;'
					. 'background-image: -ms-linear-gradient(top,#b60000,#531111);'
					. 'background-image: -webkit-gradient(linear,0 0,0 100%,from(#b60000),to(#531111));'
					. 'background-image: -webkit-linear-gradient(top,#b60000,#531111);'
					. 'background-image: -o-linear-gradient(top,#b60000,#531111);'
					. 'background-image: linear-gradient(top,#b60000,#531111);'
					. 'background-image: -moz-linear-gradient(top,#b60000,#531111);'
					. 'background-repeat: repeat-x;'
					. 'filter: progid:dximagetransform.microsoft.gradient(startColorstr="#b60000",endColorstr="#531111",GradientType=0);'
					. 'filter: progid:dximagetransform.microsoft.gradient(enabled=false);'
					. '*zoom: 1;'
					. '}';
			$doc->addStyleDeclaration( $style );
		}


		if ($reg == 1)
		{
			$dates_bookable	= $this->datelistMkt($i) ? $this->datelistMkt($i) : array();
			$this_event_url	= JURI::getInstance()->toString();
			$cleanurl		= preg_replace('/&date=[^&]*/', '', $this_event_url);
			$cleanurl		= preg_replace('/\?date=[^\?]*/', '', $cleanurl);

			$isSef = JFactory::getApplication()->getCfg( 'sef' );
			$date_var = ($isSef == 1) ? '?date=' :'&amp;date=';

			$select_date = '<div style="display: block; max-height: 130px; width: 180px; overflow-y: auto;">';

			foreach ($dates_bookable AS $d)
			{
				$ex_d		= explode('@@', $d);
				$date_url	= date('Y-m-d-H-i', strtotime($ex_d[0]));
				$select_date.= '<div class="ic-tip-link">';
				$select_date.= '<a href="' . $cleanurl . $date_var . $date_url . '" class="ic-title-cal-tip" rel="nofollow" target="_parent">';
				$select_date.= '&#160;' . $ex_d[1] . '&#160;';
				$select_date.= '</a>';
				$select_date.= '</div>';

				// If date to be set as other date is the current next date
				$is_next = ($date_url == date('Y-m-d-H-i', strtotime($i->next))) ? true : false;
			}

			$select_date.= '</div>';

			$reg_button = '<div class="ic-registration-box">';

			if ($upcomingDatesBooking
				&& $ticketsCouldBeBooked
				)
			{
				if (in_array($accessreg, $userLevels))
				{
					if ($this->totalRegistered($i) == $this->maxReg($i))
					{
						$reg_button.= '<a class="ic-addtocal" title="' . htmlspecialchars($select_date) . '" rel="nofollow">';
						$reg_button.= '<div class="ic-btn ic-btn-info ic-btn-small ic-event-full">';
						$reg_button.= '<i class="iCicon iCicon-people"></i>&nbsp;' . JText::_('COM_ICAGENDA_REGISTRATION_DATE_NO_TICKETS_LEFT');
						$reg_button.= '</div>';
						$reg_button.= '<br />';
						$reg_button.= '<span class="ic-select-another-date">' . JText::_('COM_ICAGENDA_REGISTRATION_REGISTER_ANOTHER_DATE') . '</span>';
						$reg_button.= '</a>';
					}
					elseif ($date_is_upcoming
						|| $is_next)
					{
						$reg_button.= '<a href="' . $this->regUrl($i) . '" rel="nofollow">';
						$reg_button.= '<div class="ic-btn ic-btn-success ic-btn-small ic-event-register regis_button">';
						$reg_button.= '<i class="iCicon iCicon-register"></i>&nbsp;' . $TextRegBt;
						$reg_button.= '</div>';
						$reg_button.= '</a>';
					}
					else
					{
						$reg_button.= '<a class="ic-addtocal" title="' . htmlspecialchars($select_date) . '" rel="nofollow">';
						$reg_button.= '<div class="ic-btn ic-btn-info ic-btn-small ic-event-finished">';
						$reg_button.= '<i class="iCicon iCicon-people"></i>&nbsp;' . JText::_('COM_ICAGENDA_REGISTRATION_DATE_NO_TICKETS_LEFT');
						$reg_button.= '</div>';
						$reg_button.= '<br />';
						$reg_button.= '<span class="ic-select-another-date">' . JText::_('COM_ICAGENDA_REGISTRATION_REGISTER_ANOTHER_DATE') . '</span>';
						$reg_button.= '</a>';
					}
				}
				else
				{
					$reg_button.= '<a href="' . $this->regUrl($i) . '" rel="nofollow">';
					$reg_button.= '<div class="ic-btn ic-btn-danger ic-btn-small ic-event-register regis_button">';
					$reg_button.= '<i class="iCicon iCicon-private"></i>&nbsp;' . $TextRegBt;
					$reg_button.= '</div>';
					$reg_button.= '</a>';
				}
			}
			elseif ( $upcomingDatesBooking
				&& ! $ticketsCouldBeBooked
				&& $regUntilEnd == 1
				&& $is_full_period
				)
			{
				$reg_button.= '<a href="' . $this->regUrl($i) . '" rel="nofollow">';
				$reg_button.= '<div class="ic-btn ic-btn-success ic-btn-small ic-event-register regis_button">';
				$reg_button.= '<i class="iCicon iCicon-register"></i>&nbsp;' . $TextRegBt;
				$reg_button.= '</div>';
				$reg_button.= '</a>';
			}
			elseif ($upcomingDatesBooking
				&& ! $ticketsCouldBeBooked
				)
			{
				if ( ! $date_is_upcoming || $typeReg == 2)
				{
					$reg_button.= '<div class="ic-btn ic-btn-default ic-btn-small ic-event-finished">';
					$reg_button.= '<i class="iCicon iCicon-blocked"></i>&nbsp;' . JText::_('COM_ICAGENDA_REGISTRATION_CLOSED');
					$reg_button.= '</div>';
				}
				else
				{
					$reg_button.= '<div class="ic-btn ic-btn-info ic-btn-small ic-event-full">';
					$reg_button.= '<i class="iCicon iCicon-people"></i>&nbsp;' . JText::_('COM_ICAGENDA_REGISTRATION_EVENT_FULL');
					$reg_button.= '</div>';
				}
			}
			elseif ( ! $upcomingDatesBooking)
			{
				$reg_button.= '<div class="ic-btn ic-btn-default ic-btn-small ic-event-finished">';
				$reg_button.= '<i class="iCicon iCicon-blocked"></i>&nbsp;' . JText::_('COM_ICAGENDA_REGISTRATION_CLOSED');
				$reg_button.= '</div>';
			}
			else
			{
				return false;
			}

			if (!$regLink)
			{
				$reg_button.= '&nbsp;<i class="iCicon iCicon-people ic-people"></i>';
				$reg_button.= '<div class="ic-registered" >' . $this->totalRegistered($i) . '</div>';
			}

			$reg_button.= '</div>';
		}
		else
		{
			return false;
		}

		return $reg_button;
	}

	/** // TO BE CHECKED TO USE UTILITIES
	 * Loads the Event's custom fields for this item
	 *
	 * @return object list.
	 * @since   3.4.0
	 */
	public function loadEventCustomFields($i)
	{
		// Get the database connector.
		$db = JFactory::getDBO();

		// Get the query from the database connector.
		$query = $db->getQuery(true);

		// Build the query programatically (using chaining if desired).
		$query->select('cfd.*, cf.title AS title')
			// Use the qn alias for the quoteName method to quote table names.
			->from($db->qn('#__icagenda_customfields_data') . ' AS cfd');

		$query->leftJoin('#__icagenda_customfields AS cf ON cf.slug = cfd.slug');

		$query->where($db->qn('cfd.parent_id').' = '.(int) $i->id);
		$query->where($db->qn('cfd.parent_form').' = 2');
		$query->where($db->qn('cf.parent_form').' = 2');
		$query->where($db->qn('cfd.state').' = 1');
		$query->where($db->qn('cf.state').' = 1');
		$query->order('cf.ordering ASC');

		// Tell the database connector what query to run.
		$db->setQuery($query);

		// Invoke the query or data retrieval helper.
		return $db->loadObjectList();
	}


	// Save of a registration, and automatic email (TO BE MOVED TO A NEW MODEL/VIEW)
	public function registration($array)
	{
		$menu_items	= icagendaMenus::iClistMenuItems();
		$itemid		= JRequest::getVar('Itemid');

		$linkexist	= '';

		foreach ($menu_items as $l)
		{
			if (($l->published == '1') && ($l->id == $itemid))
			{
				$linkexist = '1';
			}
		}

		if (is_numeric($itemid)
			&& $itemid != 0
			&& $linkexist == 1
			)
		{
			// Import params - Limit Options for User Registration
			$app			= JFactory::getApplication();
			$date			= JFactory::getDate();
			$params			= $app->getParams();
			$isSef			= $app->getCfg('sef');
			$eventTimeZone	= null;

			$data = new stdClass();

			// Set the values
			$data->id = null;
			$data->eventid = '0';

			$data->userid	= isset($array['uid']) ? $array['uid'] : '';
			if (isset($array['name'])) $data->name = $array['name'];
			$data->email	= isset($array['email']) ? $array['email'] : '';
			$data->phone	= isset($array['phone']) ? $array['phone'] : '';
			if (isset($array['date'])) $data->date = $array['date'];
			if (isset($array['period'])) $data->period = $array['period'];
			if (isset($array['people'])) $data->people = $array['people'];
			$data->notes	= isset($array['notes']) ? htmlentities(strip_tags($array['notes'])) : '';
			if (isset($array['event'])) $data->eventid = $array['event'];
			if (isset($array['menuID'])) $data->itemid = $array['menuID'];

			$data->created		= $date->toSql();
			$data->created_by	= $data->userid;

			$current_url		= isset($array['current_url']) ? $array['current_url'] : 'index.php';
			$max_nb_of_tickets	= isset($array['max_nb_of_tickets']) ? $array['max_nb_of_tickets'] : '1000000';
			$tos				= isset($array['tos']) ? 'checked' : '';
			$custom_fields		= isset($array['custom_fields']) ? $array['custom_fields'] : false;
//			$tickets_left		= isset($array['tickets_left']) ? $array['tickets_left'] : '1000000';
			$email2				= isset($array['email2']) ? $array['email2'] : false;

			// Filter Name
			$array['name'] = str_replace("'", '’', $array['name']);
			$array['name'] = (string) preg_replace('/[\x00-\x1F\x7F]/', '', $array['name']);

			// Set Form Data to Session
			$session = JFactory::getSession();
			$session->set('ic_registration', $array);
			$session->set('ic_submit_tos', $tos);
			$custom_fields_array = isset($array['custom_fields']) ? (array) $array['custom_fields'] : array();
			$session->set('custom_fields', $custom_fields_array);
			$session->set('email2', $email2);

			// Control if still ticket left
			$db		= JFactory::getDbo();
			$query	= $db->getQuery(true);
			// Registrations total
			$query->select('sum(r.people) AS registered');
			$query->from('`#__icagenda_registration` AS r');
			$query->where('r.state > 0');
			$query->where('r.date = ' . $db->q($data->date));
			$query->where('r.eventid = ' . (int) $data->eventid);
			$db->setQuery($query);
			$registered = $db->loadObject()->registered;

			$data->checked_out_time = date('Y-m-d H:i:s');

			// Set Date in url
			$datesDisplay	= $params->get('datesDisplay', 1);

			$date_alias		= $data->date ? iCDate::dateToAlias(date('Y-m-d H:i', strtotime($data->date))) : false;
			$date_var		= ($isSef == 1) ? '?date=' :'&amp;date=';

			$this_date		= $date_alias ? $date_var . $date_alias : '';
			$dateInUrl	= ($datesDisplay === 1) ? $this_date : '';

			// Get the "event" URL
			$baseURL = JURI::base();
			$subpathURL = JURI::base(true);

			$baseURL	= str_replace('/administrator', '', $baseURL);
			$subpathURL	= str_replace('/administrator', '', $subpathURL);

			// Sub Path filtering
			$subpathURL = ltrim($subpathURL, '/');

			// URL Event Details filtering
			$urlEvent	= str_replace('&amp;', '&', JRoute::_('index.php?option=com_icagenda&view=list&layout=event&Itemid=' . (int) $data->itemid . '&id=' . (int) $data->eventid)) . $dateInUrl;
			$urlEvent	= ltrim($urlEvent, '/');

			if (substr($urlEvent, 0, strlen($subpathURL) + 1) == "$subpathURL/")
			{
				$urlEvent = substr($urlEvent, strlen($subpathURL) + 1);
			}

			$urlEvent	= rtrim($baseURL, '/') . '/' . ltrim($urlEvent, '/');

			// URL List filtering
			$urlList	= str_replace('&amp;', '&', JRoute::_('index.php?option=com_icagenda&view=list&Itemid=' . (int) $data->itemid));
			$urlList	= ltrim($urlList, '/');

			if (substr($urlList, 0, strlen($subpathURL)+1) == "$subpathURL/")
			{
				$urlList = substr($urlList, strlen($subpathURL)+1);
			}

			$urlList	= rtrim($baseURL, '/') . '/' . ltrim($urlList, '/');

			// URL Registration filtering // NOT USED
			$urlRegistration	= str_replace('&amp;','&', JRoute::_('index.php?option=com_icagenda&view=list&layout=registration&Itemid=' . (int) $data->itemid . '&id=' . (int) $data->eventid));
			$urlRegistration	= ltrim($urlRegistration, '/');

			if (substr($urlRegistration, 0, strlen($subpathURL)+1) == "$subpathURL/")
			{
				$urlRegistration = substr($urlRegistration, strlen($subpathURL)+1);
			}

			$urlRegistration	= rtrim($baseURL, '/') . '/' . ltrim($urlRegistration, '/');

			// URL Payment filtering
			$urlPayment	= str_replace('&amp;','&', JRoute::_('index.php?option=com_icagenda&view=list&layout=actions&Itemid=' . (int) $data->itemid . '&id=' . (int) $data->eventid));
			$urlPayment	= ltrim($urlPayment, '/');

			if (substr($urlPayment, 0, strlen($subpathURL)+1) == "$subpathURL/")
			{
				$urlPayment = substr($urlPayment, strlen($subpathURL)+1);
			}

			$urlPayment	= rtrim($baseURL, '/') . '/' . ltrim($urlPayment, '/');

			$urlPayment	= $urlPayment . '?status=payment';



			// Check number of tickets left
			$tickets_left = $max_nb_of_tickets - $registered;

			// IF NO TICKETS LEFT
			if ($tickets_left <= 0)
			{
				$app->enqueueMessage(JText::_('COM_ICAGENDA_ALERT_NO_TICKETS_AVAILABLE'), 'warning');

				$app->redirect(htmlspecialchars_decode($urlEvent));
			}

			// IF NOT ENOUGH TICKETS LEFT
			elseif ($tickets_left < $data->people)
			{
				$msg = JText::_('COM_ICAGENDA_ALERT_NOT_ENOUGH_TICKETS_AVAILABLE') . '<br />';
				$msg.= JText::sprintf('COM_ICAGENDA_ALERT_NOT_ENOUGH_TICKETS_AVAILABLE_NOW', $tickets_left) . '<br />';
				$msg.= JText::_('COM_ICAGENDA_ALERT_NOT_ENOUGH_TICKETS_AVAILABLE_CHANGE_NUMBER');

				$app->enqueueMessage($msg, 'error');

				$app->redirect(htmlspecialchars_decode($current_url));
			}


			// CONTROL NAME VALUE
			$name_isValid = '1';

//			$pattern = "#[/\\\\/\<>/\"%;=\[\]\+()&]|^[0-9]#i";
			$pattern = "#[/\\\\/\<>/\";=\[\]\+()%&]#i";

        	if ($array['name'])
        	{
				$nbMatches = preg_match($pattern, $array['name']);

				// Name contains invalid characters
				if ($nbMatches && $nbMatches == 1)
				{
					$name_isValid = '0';
					$app->enqueueMessage(JText::sprintf( 'COM_ICAGENDA_REGISTRATION_NAME_NOT_VALID' , '<b>' . htmlentities($array['name'], ENT_COMPAT, 'UTF-8') . '</b>'), 'error');
				}

				// Name is less than 2 characters
				if (strlen(utf8_decode($array['name'])) < 2)
				{
					$name_isValid = '0';
					$app->enqueueMessage(JText::_( 'COM_ICAGENDA_REGISTRATION_NAME_MINIMUM_CHARACTERS'), 'error');
				}
        	}
        	else
        	{
				$app->enqueueMessage(JText::_( 'COM_ICAGENDA_FORM_VALIDATE_FIELD_REQUIRED') . ' ' . JText::_( 'ICAGENDA_REGISTRATION_FORM_NAME' ), 'error');
			}

			$data->name = filter_var($data->name, FILTER_SANITIZE_STRING);

			// CONTROL EMAIL VALUE
			$emailRequired	= $params->get('emailRequired', 1);
			$emailConfirm	= $params->get('emailConfirm', 1);

			// Check if Email not empty
			if ($emailRequired
				&& ! $data->email)
			{
				$app->enqueueMessage(JText::_( 'COM_ICAGENDA_FORM_VALIDATE_FIELD_REQUIRED' ) . ' ' . JText::_( 'ICAGENDA_REGISTRATION_FORM_EMAIL' ), 'error');
			}

			// Check if Confirm Email equals Email
			if ($emailConfirm
				&& empty($data->userid)
				&& $data->email != $email2)
			{
				$app->enqueueMessage(JText::_( 'COM_ICAGENDA_FORM_VALIDATE_FIELD_INVALID' ) . ' ' . JText::_( 'IC_FORM_EMAIL_CONFIRM_LBL' ) . '<br />' . JText::_( 'COM_ICAGENDA_FORM_VALIDATE_FIELD_EMAIL2_MESSAGE' ), 'error');
			}

			// Advanced Checkdnsrr email
			$emailCheckdnsrr	= JComponentHelper::getParams('com_icagenda')->get('emailCheckdnsrr', '0');

			if (!empty($data->email))
			{
				$validEmail = true;
				$checkdnsrr = true;

				if (($emailCheckdnsrr == 1) AND (function_exists('checkdnsrr')))
				{
					$provider = explode('@', $data->email);
					if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
					{
						if (version_compare(phpversion(), '5.3.0', '<'))
						{
							$checkdnsrr = true;
						}
					}
					else
					{
						$checkdnsrr = checkdnsrr($provider[1]);
					}
				}
				else
				{
					$checkdnsrr = true;
				}
			}
			else
			{
				$checkdnsrr = true;
			}

			// Check if valid email address
			$validEmail = $validEmail ? $this->validEmail($data->email) : false;

			if ( ! $checkdnsrr
				|| ! $validEmail
				&& $data->email
				)
			{
				// message if email is invalid
				$app->enqueueMessage(JText::_( 'COM_ICAGENDA_REGISTRATION_EMAIL_NOT_VALID' ), 'error');
			}

			$eventid	= $data->eventid;

			$period		= (isset($data->period)) ? $data->period : '0';

			$people		= $data->people;
			$name		= $data->name;
			$email		= $data->email;
			$phone		= $data->phone;
			$notes		= html_entity_decode($data->notes);
			$dateReg	= $data->date;

			$limitRegEmail	= $params->get('limitRegEmail', 1);
			$limitRegDate	= $params->get('limitRegDate', 1);

			$alreadyexist	= 'no';

			if ($limitRegEmail == 1 || $limitRegDate == 1)
			{
				$cf = JRequest::getString('email', '', 'post');

				if ($limitRegDate == 0)
				{
					$query = "
						SELECT COUNT(*)
						FROM `#__icagenda_registration`
						WHERE `email` = '$cf' AND `eventid`='$eventid' AND `state`='1'
					";
				}
				elseif ($limitRegDate == 1)
				{
					$query = "
						SELECT COUNT(*)
						FROM `#__icagenda_registration`
						WHERE `email` = '$cf' AND `eventid`='$eventid' AND `date`='$dateReg' AND `state`='1'
					";
				}

				$db->setQuery($query);

				if ($email != NULL)
				{
					if ( $db->loadResult() )
					{
						$alreadyexist = 'yes';
						$app->enqueueMessage(JText::_( 'COM_ICAGENDA_REGISTRATION_EMAIL_ALERT' ) . ' ' . $email, 'error');
					}
					else
					{
						$alreadyexist = 'no';
					}
				}
			}

			$email	= $email ? $email : JText::_( 'COM_ICAGENDA_NOT_SPECIFIED' );

			// Check if Phone not empty
			$phoneRequired	= $params->get('phoneRequired', 1);

			if ($phoneRequired
				&& ! $phone)
			{
				$app->enqueueMessage(JText::_( 'COM_ICAGENDA_FORM_VALIDATE_FIELD_REQUIRED' ) . ' ' . JText::_( 'ICAGENDA_REGISTRATION_FORM_PHONE' ), 'error');
			}

			$phone	= $phone ? $phone : JText::_( 'COM_ICAGENDA_NOT_SPECIFIED' );

			// Check if Custom Fields required not empty
			$customfields_list = icagendaCustomfields::getListCustomFields($data->id, 1, 1);

			if ($customfields_list)
			{
				foreach ($customfields_list AS $cf)
				{
					if ($cf->cf_required == 1)
					{
						if ($custom_fields[$cf->cf_slug] == '')
						{
							$app->enqueueMessage(JText::_( 'COM_ICAGENDA_FORM_VALIDATE_FIELD_REQUIRED' ) . ' ' . $cf->cf_title, 'error');
						}
					}
				}
			}

			// Check if ToS not checked
			if ( ! $tos)
			{
				$app->enqueueMessage(JText::_( 'COM_ICAGENDA_TERMS_AND_CONDITIONS_NOT_CHECKED_REGISTRATION' ), 'error');
			}

			// RECAPTCHA
			$captcha_plugin	= $params->get('captcha') ? $params->get('captcha') : $app->getCfg('captcha');
			$reg_captcha	= JComponentHelper::getParams('com_icagenda')->get('reg_captcha', 1);

			if ($captcha_plugin && $reg_captcha != '0')
			{
				JPluginHelper::importPlugin('captcha');

				// JOOMLA 3.x/2.5 SWITCH
				if (version_compare(JVERSION, '3.0', 'ge'))
				{
					$dispatcher = JEventDispatcher::getInstance();
				}
				else
				{
					$dispatcher = JDispatcher::getInstance();
				}

				$res		= $dispatcher->trigger('onCheckAnswer', $array['recaptcha_response_field']);

				if ( ! $res[0])
				{
					// message if captcha is invalid
					$app->enqueueMessage(JText::_( 'PLG_RECAPTCHA_ERROR_INCORRECT_CAPTCHA_SOL' ), 'error');
				}
			}


			// Get the message queue
			$error_messages = $app->getMessageQueue();

			if (count($error_messages))
			{
				$app->redirect(htmlspecialchars_decode($current_url));

				return false;
			}

			// clear the data so we don't process it again
			$session->clear('ic_registration');
			$session->clear('custom_fields');
			$session->clear('ic_submit_tos');
			$session->clear('email2');


			/**
			 *	SAVE REGISTRATION DATA TO DATABASE
			 */

			// Option Email required
			if ($emailRequired == '1')
			{
				if (is_numeric($eventid) && is_numeric($period) && is_numeric($people) && $name != NULL && $email != NULL)
				{
					$db->insertObject( '#__icagenda_registration', $data, id );
				}
			}
			else
			{
				if (is_numeric($eventid) && is_numeric($period) && is_numeric($people) && $name != NULL)
				{
					$db->insertObject( '#__icagenda_registration', $data, id );
				}
			}


			/**
			 *	SAVE CUSTOM FIELDS TO DATABASE
			 */

			if ($custom_fields && is_array($custom_fields))
			{
				icagendaCustomfields::saveToData($custom_fields, $data->id, 1);
			}


			/**
			 *	NOTIFICATION EMAILS
			 */
			$author= '0';

			// Preparing the query
			$query = $db->getQuery(true);
			$query->select('e.title AS title, e.startdate AS startdate, e.enddate AS enddate,
					e.created_by AS authorID, e.email AS contactemail, e.displaytime AS displaytime')
				->from('#__icagenda_events AS e')
				->where("(e.id=$data->eventid)");
			$db->setQuery($query);
			$title			= $db->loadObject()->title;
			$startdate		= $db->loadObject()->startdate;
			$enddate		= $db->loadObject()->enddate;
			$authorID		= $db->loadObject()->authorID;
			$contactemail	= $db->loadObject()->contactemail;
			$displayTime	= $db->loadObject()->displaytime;

			$startD = $this->formatDate($startdate);
			$endD = $this->formatDate($enddate);
			$startT = JHtml::date($startdate, 'H:i', $eventTimeZone);
			$endT = JHtml::date($enddate, 'H:i', $eventTimeZone);

			$regDate = $this->formatDate($data->date);
			$regTime = JHtml::date($data->date, 'H:i', $eventTimeZone);

			$regDateTime		= !empty($displayTime) ? $regDate.' - '.$regTime : $regDate;
			$regStartDateTime	= !empty($displayTime) ? $startD.' - '.$startT : $startD;
			$regEndDateTime		= !empty($displayTime) ? $endD.' - '.$endT : $endD;

			$periodreg = $data->period;

			$defaultemail			= $params->get('regEmailUser', '1');
			$emailUserSubjectPeriod	= $params->get('emailUserSubjectPeriod', '');
			$emailUserBodyPeriod	= $params->get('emailUserBodyPeriod', '');
			$emailUserSubjectDate	= $params->get('emailUserSubjectDate', '');
			$emailUserBodyDate		= $params->get('emailUserBodyDate', '');

			$emailAdminSend			= $params->get('emailAdminSend', '1');
			$emailAdminSend_select	= $params->get('emailAdminSend_select', array('0'));
			$emailAdminSend_custom	= $params->get('emailAdminSend_Placeholder', '');

			$emailUserSend			= $params->get('emailUserSend', '1');

			$eUSP = isset($emailUserSubjectPeriod)
					? $emailUserSubjectPeriod
					: JText::_( 'COM_ICAGENDA_REGISTRATION_EMAIL_USER_PERIOD_DEFAULT_SUBJECT' );

			$eUBP = isset($emailUserBodyPeriod)
					? $emailUserBodyPeriod
					: JText::_( 'COM_ICAGENDA_REGISTRATION_EMAIL_USER_PERIOD_DEFAULT_BODY' );

			$eUSD = isset($emailUserSubjectDate)
					? $emailUserSubjectDate
					: JText::_( 'COM_ICAGENDA_REGISTRATION_EMAIL_USER_DATE_DEFAULT_SUBJECT' );

			$eUBD = isset($emailUserBodyDate)
					? $emailUserBodyDate
					: JText::_( 'COM_ICAGENDA_REGISTRATION_EMAIL_USER_DATE_DEFAULT_BODY' );

			$period_set = substr($startdate, 0, 4);

			if ($periodreg == 1
				|| ($array['date'] == '' && !$periodreg))
			{
				$periodd 		= ($period_set != '0000')
								? JText::sprintf( 'COM_ICAGENDA_REGISTERED_EVENT_PERIOD', $startD, $startT, $endD, $endT )
								: '';
				$adminsubject	= JText::_( 'COM_ICAGENDA_REGISTRATION_EMAIL_ADMIN_DEFAULT_SUBJECT' );
				$adminbody 		= JText::_( 'COM_ICAGENDA_REGISTRATION_EMAIL_ADMIN_PERIOD_DEFAULT_BODY' );

				if ($defaultemail == 0)
				{
					$subject	= $eUSP;
					$body		= $eUBP;
				}
				else
				{
					$subject	= JText::_( 'COM_ICAGENDA_REGISTRATION_EMAIL_USER_PERIOD_DEFAULT_SUBJECT' );
					$body		= JText::_( 'COM_ICAGENDA_REGISTRATION_EMAIL_USER_PERIOD_DEFAULT_BODY' );
				}
			}
			else
			{
//				$periodd		= ($period_set != '0000')
//								? JText::sprintf( 'COM_ICAGENDA_REGISTERED_EVENT_DATE', $regDate, '' )
//								: '';
				$periodd		= JText::sprintf( 'COM_ICAGENDA_REGISTERED_EVENT_DATE', $regDate, '' );
				$adminsubject	= JText::_( 'COM_ICAGENDA_REGISTRATION_EMAIL_ADMIN_DEFAULT_SUBJECT' );
				$adminbody		= JText::_( 'COM_ICAGENDA_REGISTRATION_EMAIL_ADMIN_DATE_DEFAULT_BODY' );

				if ($defaultemail == 0)
				{
					$subject	= $eUSD;
					$body		= $eUBD;
				}
				else
				{
					$subject	= JText::_( 'COM_ICAGENDA_REGISTRATION_EMAIL_USER_DATE_DEFAULT_SUBJECT' );
					$body		= JText::_( 'COM_ICAGENDA_REGISTRATION_EMAIL_USER_DATE_DEFAULT_BODY' );
				}
			}

			// Get the site name
			$sitename	= $app->getCfg('sitename');

			$siteURL = JURI::base();
			$siteURL = rtrim($siteURL,'/');

			// Get Author Email
			$authormail = '';

			if ($authorID != NULL)
			{
				// Preparing the query
				$query = $db->getQuery(true);
				$query->select('email AS authormail, name AS authorname')->from('#__users AS u')->where("(u.id=$authorID)");
				$db->setQuery($query);
				$authormail = $db->loadObject()->authormail;
				$authorname = $db->loadObject()->authorname;

				if ($authormail == NULL)
				{
					$authormail	= $app->getCfg('mailfrom');
				}
			}

			// Generates filled custom fields into email body
			$customfields = icagendaCustomfields::getListNotEmpty($data->id);

 			$custom_fields = '';

			$newline = ($defaultemail == '0') ? "<br />" : "\n";

			if ($customfields)
			{
				foreach ($customfields AS $customfield)
				{
					$cf_value = isset($customfield->cf_value) ? $customfield->cf_value : JText::_('IC_NOT_SPECIFIED');
					$custom_fields.= $customfield->cf_title . ": " . $cf_value . $newline;
				}
			}

			// MAIL REPLACEMENTS
			$replacements = array(
				"\\n"				=> "\n",
				'[SITENAME]'		=> $sitename,
				'[SITEURL]'			=> $siteURL,
				'[AUTHOR]'			=> $authorname,
				'[AUTHOREMAIL]'		=> $authormail,
				'[CONTACTEMAIL]'	=> $contactemail,
				'[TITLE]'			=> $title,
//				'[EVENTID]'			=> is_numeric($data->eventid) ? (int) $data->eventid : null,
				'[EVENTURL]'		=> $urlEvent,
				'[NAME]'			=> $name,
				'[EMAIL]'			=> $email,
				'[PHONE]'			=> $phone,
				'[PLACES]'			=> $people,
				'[CUSTOMFIELDS]'	=> $custom_fields,
//				'[NOTES]'			=> $notes ? $notes : JText::_('COM_ICAGENDA_NOT_SPECIFIED'),
				'[NOTES]'			=> $notes,
				'[DATE]'			=> $regDate,
				'[TIME]'			=> $regTime,
				'[DATETIME]'		=> $regDateTime,
				'[STARTDATE]'		=> $startD,
				'[ENDDATE]'			=> $endD,
				'[STARTDATETIME]'	=> $regStartDateTime,
				'[ENDDATETIME]'		=> $regEndDateTime,
				'&nbsp;'			=> ' ',
			);

			foreach ($replacements as $key => $value)
			{
				$subject = str_replace($key, $value, $subject);
				$body = str_replace($key, $value, $body);
				$adminsubject = str_replace($key, $value, $adminsubject);
				$adminbody = str_replace($key, $value, $adminbody);
			}

			// Set Sender of USER and ADMIN emails
			$mailer = JFactory::getMailer();
			$adminmailer = JFactory::getMailer();

			$mailfrom	= $app->getCfg('mailfrom');
			$fromname	= $app->getCfg('fromname');

			$mailer->setSender(array( $mailfrom, $fromname ));
			$adminmailer->setSender(array( $mailfrom, $fromname ));

			// Set Recipient of USER email
			$user = JFactory::getUser();

			if (!isset($data->email))
			{
				$recipient = $user->email;
			}
			else
			{
				$recipient = $data->email;
			}

			$mailer->addRecipient($recipient);

			// Set Recipient of ADMIN email
			$admin_array = array();

			if (in_array('0', $emailAdminSend_select))
			{
				array_push($admin_array, $mailfrom);
			}

			if (in_array('1', $emailAdminSend_select))
			{
				array_push($admin_array, $authormail);
			}

			if (in_array('2', $emailAdminSend_select))
			{
				$customs_emails = explode(',', $emailAdminSend_custom);
				$customs_emails = str_replace(' ','',$customs_emails);

				foreach ($customs_emails AS $cust_mail)
				{
					array_push($admin_array, $cust_mail);
				}
			}

			if (in_array('3', $emailAdminSend_select))
			{
				array_push($admin_array, $contactemail);
			}

			$adminrecipient = $admin_array;
			$adminmailer->addRecipient($adminrecipient);

			// Set Subject of USER and ADMIN email
			$mailer->setSubject($subject);
			$adminmailer->setSubject($adminsubject);

			// Set Body of USER and ADMIN email
			if ($defaultemail == 0)
			{
				// HTML custom notification email send to user
				$mailer->isHTML(true);
				$mailer->Encoding = 'base64';
			}

			$adminbody = str_replace("<br />", "\n", $adminbody);

			$mailer->setBody($body);
			$adminmailer->setBody($adminbody);

			// Optional file attached
//			$mailer->addAttachment(JPATH_COMPONENT.DS.'assets'.DS.'document.pdf');

			// Send USER email confirmation, if enabled
			if ($emailUserSend == 1
				&& isset($data->email) )
			{
				$send = $mailer->Send();
			}

			// Send ADMIN email notification, if enabled
			if ($emailAdminSend == 1)
			{
				if ($emailAdminSend == 1
					&& isset($data->eventid)
					&& $data->eventid != '0'
					&& $data->name != NULL
					)
				{
					$sendadmin = $adminmailer->Send();
				}
			}

			$evtParams			= $this->evtParams($i);
			$reg_payment		= $evtParams->get('icpayment', '');
			$iCpaymentPlugin	= JPluginHelper::getPlugin('content', 'ic_payment');

			if ($iCpaymentPlugin)
			{
				$plgParams		= new JRegistry($iCpaymentPlugin->params);
				$reg_payment	= $reg_payment ? $reg_payment : $plgParams->get('icpayment', '');
			}

			if ($alreadyexist == 'no')
			{
				$thank_you = JText::_( 'COM_ICAGENDA_REGISTRATION_TY' ) . ' ' . $data->name;
				$thank_you.= ', ' . JText::sprintf( 'COM_ICAGENDA_REGISTRATION', $title );
				$thank_you.= '<br />' . $periodd . ' (<a href="' . $urlEvent . '">'. JText::_( 'COM_ICAGENDA_REGISTRATION_EVENT_LINK' ) . '</a>)';

				// redirect after successful registration
				$app->enqueueMessage($thank_you, 'message');

				if ($reg_payment)
				{
					$app->redirect(htmlspecialchars_decode($urlPayment));
				}
				else
				{
					$app->redirect(htmlspecialchars_decode($urlList));
				}
			}
		}
		else
		{
			JError::raiseError('404', JTEXT::_('JERROR_LAYOUT_PAGE_NOT_FOUND'));

			return false;
		}
	}


	/**
	 * ESSENTIAL FUNCTIONS
	 */

	// Function to convert font color, depending on category color
	function fontColor($i)
	{
		$color = isset($i->cat_color) ? $i->cat_color : '';

		$hex_R	= substr($color, 1, 2);
		$hex_G	= substr($color, 3, 2);
		$hex_B	= substr($color, 5, 2);
		$RGBhex	= hexdec($hex_R) . ',' . hexdec($hex_G) . ',' . hexdec($hex_B);

		$RGB	= explode(',', $RGBhex);
		$RGBa	= $RGB[0];
		$RGBb	= $RGB[1];
		$RGBc	= $RGB[2];

		$somme	= ($RGBa + $RGBb + $RGBc);

		if ($somme > '600')
		{
			$fcolor = 'fontColor';
		}
		else
		{
			$fcolor = '';
		}

		return $fcolor;
	}

	private function validEmail($email)
	{
		$isValid	= true;
		$atIndex	= strrpos($email, "@");

		if (is_bool($atIndex) && !$atIndex)
		{
			$isValid = false;
		}
		else
		{
			$domain		= substr($email, $atIndex+1);
			$local		= substr($email, 0, $atIndex);
			$localLen	= strlen($local);
			$domainLen	= strlen($domain);

			if ($localLen < 1 || $localLen > 64)
			{
				// local part length exceeded
				$isValid = false;
			}
			elseif ($domainLen < 1 || $domainLen > 255)
			{
				// domain part length exceeded
				$isValid = false;
			}
			elseif ($local[0] == '.' || $local[$localLen-1] == '.')
			{
				// local part starts or ends with '.'
				$isValid = false;
			}
			elseif (preg_match('/\\.\\./', $local))
			{
				// local part has two consecutive dots
				$isValid = false;
			}
			elseif (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
			{
				// character not valid in domain part
				$isValid = false;
			}
			elseif (preg_match('/\\.\\./', $domain))
			{
				// domain part has two consecutive dots
				$isValid = false;
			}
			elseif (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local)))
			{
				// character not valid in local part unless
				// local part is quoted
				if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local)))
				{
					$isValid = false;
				}
			}

			// Check the domain name
			if ($isValid
				&& !$this->is_valid_domain_name($domain))
			{
				return false;
			}

			// Uncomment below to have PHP run a proper DNS check (risky on shared hosts!)
			/**
			if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A"))) {
				// domain not found in DNS
				$isValid = false;
			}
			/**/
		}

		return $isValid;
	}


	// Check if a domain is valid
	function is_valid_domain_name($domain_name)
	{
		$pieces = explode(".", $domain_name);

		foreach ($pieces as $piece)
		{
			if (!preg_match('/^[a-z\d][a-z\d-]{0,62}$/i', $piece)
				|| preg_match('/-$/', $piece))
			{
				return false;
			}
		}

		return true;
	}


	// Url to add to Google Calendar
	protected function gcalendarUrl ($i)
	{
		$text			= $i->title.' ('.$i->cat_title.')';
		$details		= $i->desc;
		$venue			= $i->place_name;
		$s_dates		= $i->dates;
//		$single_dates	= unserialize($s_dates);
		$single_dates	= iCString::isSerialized($i->dates) ? unserialize($i->dates) : array(); // returns array
		$website		= $this->Event_Link($i);

		$location	= $venue ? $venue.' - '.$i->address : $i->address;

		$get_date	= '';
		$href		= '#';

		if (JRequest::getVar('date'))
		{
			// if 'All Dates' set
			$get_date = JRequest::getVar('date');
		}
		else
		{
			// if 'Only Next/Last Date' set
			$get_date = date('Y-m-d-H-i', strtotime($i->next));
		}

		$ex			= explode('-', $get_date);
		$this_date	= $ex['0'] . '-' . $ex['1'] . '-' . $ex['2'] . ' ' . $ex['3'] . ':' . $ex['4'];

		$startdate	= date('Y-m-d-H-i', strtotime($i->startdate));
		$enddate	= date('Y-m-d-H-i', strtotime($i->enddate));

		if ($this->eventHasPeriod($i)
			&& ($get_date >= $startdate)
			&& ($get_date <= $enddate)
			&& (!in_array($this_date, $single_dates))
			)
		{
			$weekdays	= ($i->weekdays || $i->weekdays == '0') ? true : false;

			if ($weekdays)
			{
				$startdate	= date('Y-m-d-H-i', strtotime($this_date));
				$enddate	= date('Y-m-d', strtotime($this_date)) . '-' . date('H-i', strtotime($i->enddate));
			}

			$ex_S	 = explode('-', $startdate);
			$ex_E	 = explode('-', $enddate);

			$dateday = $ex_S['0'] . $ex_S['1'] . $ex_S['2'] . 'T' . $ex_S['3'] . $ex_S['4'];
			$dateday.= '00/' . $ex_E['0'] . $ex_E['1'] . $ex_E['2'] . 'T' . $ex_E['3'] . $ex_E['4'] . '00';
		}
		else
		{
			$dateday = $ex['0'] . $ex['1'] . $ex['2'] . 'T' . $ex['3'] . $ex['4'];
			$dateday.= '00/' . $ex['0'] . $ex['1'] . $ex['2'] . 'T' . $ex['3'] . $ex['4'] . '00';
		}

		// Get the site name
		$sitename = JFactory::getApplication()->getCfg('sitename');

		$href = 'http://www.google.com/calendar/event?action=TEMPLATE';

		$mbString			= extension_loaded('mbstring');
		$text				= $mbString ? mb_substr($text, 0, 100, 'UTF-8') : substr($text, 0, 100);
		$len				= strrpos($text, ' ');  // interruption on a space
		$text				= substr($text, 0, $len);

		$href.= '&text=' . urlencode($text) . '...';
		$href.= '&dates=' . $dateday;
		$href.= '&location=' . urlencode($location);
		$href.= '&trp=true';

		$limit_reduc		= '37'; // 37 chars (&trp=true&details=&sf=true&output=xml)
		$limit_notlogged	= '785';
		$lenpart			= strlen($href);
		$lenlast			= 2068 - $lenpart - $limit_reduc - $limit_notlogged; // max link length minus (title+location)
		$details			= urlencode(strip_tags($details));
		$details			= substr($details, 0 , $lenlast);
		$len				= strrpos($details, '+');
		$details			= substr($details, 0 , $len);

		$href.= '&details=' . substr($details, 0, $lenlast) . '...';

		return $href;
	}


	// Url to add to Yahoo Calendar
	protected function yahoocalendarUrl ($i)
	{
		$text			= $i->title.' ('.$i->cat_title.')';
		$details		= $i->desc;
		$venue			= $i->place_name;
		$s_dates		= $i->dates;
//		$single_dates	= unserialize($s_dates);
		$single_dates	= iCString::isSerialized($i->dates) ? unserialize($i->dates) : array(); // returns array
		$website		= $this->Event_Link($i);

		$location	= $venue ? $venue.' - '.$i->address : $i->address;
		$get_date	= '';
		$href		= '#';
		$endday		= '';

		if (JRequest::getVar('date'))
		{
			// if 'All Dates' set
			$get_date = JRequest::getVar('date');
		}
		else
		{
			// if 'Only Next/Last Date' set
			$get_date = date('Y-m-d-H-i', strtotime($i->next));
		}

		$ex			= explode('-', $get_date);
		$this_date	= $ex['0'] . '-' . $ex['1'] . '-' . $ex['2'] . ' ' . $ex['3'] . ':' . $ex['4'];

		$startdate	= date('Y-m-d-H-i', strtotime($i->startdate));
		$enddate	= date('Y-m-d-H-i', strtotime($i->enddate));

		if ($this->eventHasPeriod($i)
			&& $get_date >= $startdate
			&& $get_date <= $enddate
			&& ! in_array($this_date, $single_dates)
			)
		{
			$weekdays	= ($i->weekdays || $i->weekdays == '0') ? true : false;

			if ($weekdays)
			{
				$startdate	= date('Y-m-d-H-i', strtotime($this_date));
				$enddate	= date('Y-m-d', strtotime($this_date)) . '-' . date('H-i', strtotime($i->enddate));
			}

			$ex_S		= explode('-', $startdate);
			$ex_E		= explode('-', $enddate);

			$dateday	= $ex_S['0'] . $ex_S['1'] . $ex_S['2'] . 'T' . $ex_S['3'] . $ex_S['4'] . '00';

//			$diff = strtotime($i->enddate) - strtotime($i->startdate);
//			$M = (floor($diff /60)) % 60;
//			$M = sprintf("%02d", $M);
//			$H = (floor($diff / 3600));

//			$duration	= ($H <= 24) ? $H . $M : '';
			$endday		= $ex_E['0'] . $ex_E['1'] . $ex_E['2'] . 'T' . $ex_E['3'] . $ex_E['4'] . '00';
		}
		else
		{
			$dateday	= $ex['0'] . $ex['1'] . $ex['2'] . 'T' . $ex['3'] . $ex['4'] . '00';
//			$duration	= '';
		}

		// Shortens the description, if more than 1000 characters
		$lengthMax			= '1000';
		$details			= urlencode(strip_tags($details));
		$details			= substr($details, 0, $lengthMax);
		$shortenedDetails	= strrpos($details, '+');
		$details			= substr($details, 0, $shortenedDetails);

		$href = "http://calendar.yahoo.com/?v=60";
		$href.= "&VIEW=d";
		$href.= "&in_loc=" . urlencode($location);
//		$href.= "&type=20";
		$href.= "&TITLE=" . urlencode($text);
		$href.= "&ST=" . $dateday;
		$href.= "&ET=" . $endday;
//		$href.= "&DUR=";
//		$href.= $duration ? "&DUR=" . $duration : '';
		$href.= "&DESC=" . substr($details, 0, $lengthMax) . '...';
		$href.= "&URL=" . urlencode($website);

		return $href;
	}

	// Url to add to Windows Live (Hotmail) Calendar
	protected function wlivecalendarUrl ($i)
	{
		$text			= $i->title.' ('.$i->cat_title.')';
		$details		= $i->desc;
		$venue			= $i->place_name;
		$s_dates		= $i->dates;
//		$single_dates	= unserialize($s_dates);
		$single_dates	= iCString::isSerialized($i->dates) ? unserialize($i->dates) : array(); // returns array
		$website		= $this->Event_Link($i);

		$location	= $venue ? $venue . ' - ' . $i->address : $i->address;
		$get_date	= '';
		$href		= '#';
		$endday		= '';

		if (JRequest::getVar('date'))
		{
			// if 'All Dates' set
			$get_date = JRequest::getVar('date');
		}
		else
		{
			// if 'Only Next/Last Date' set
			$get_date = date('Y-m-d-H-i', strtotime($i->next));
		}

		$ex			= explode('-', $get_date);
		$this_date	= $ex['0'] . '-' . $ex['1'] . '-' . $ex['2'] . ' ' . $ex['3'] . ':' . $ex['4'];

		$startdate	= date('Y-m-d-H-i', strtotime($i->startdate));
		$enddate	= date('Y-m-d-H-i', strtotime($i->enddate));

		if ( $this->eventHasPeriod($i)
			&& $get_date >= $startdate
			&& $get_date <= $enddate
			&& !in_array($this_date, $single_dates)
			)
		{
			$weekdays	= ($i->weekdays || $i->weekdays == '0') ? true : false;

			if ($weekdays)
			{
				$startdate	= date('Y-m-d-H-i', strtotime($this_date));
				$enddate	= date('Y-m-d', strtotime($this_date)) . '-' . date('H-i', strtotime($i->enddate));
			}

			$ex_S		= explode('-', $startdate);
			$ex_E		= explode('-', $enddate);

			$dateday	= $ex_S['0'] . $ex_S['1'] . $ex_S['2'] . 'T' . $ex_S['3'] . $ex_S['4'] . '00';
			$endday		= $ex_E['0'] . $ex_E['1'] . $ex_E['2'] . 'T' . $ex_E['3'] . $ex_E['4'] . '00';

		}
		else
		{
			$dateday	= $ex['0'] . $ex['1'] . $ex['2'] . 'T' . $ex['3'] . $ex['4'] . '00';
		}

		$href = "http://calendar.live.com/calendar/calendar.aspx?rru=addevent";
		$href.= "&dtstart=" . $dateday;
		$href.= isset($endday) ? "&dtend=" . $endday : '';
		$href.= "&summary=" . urlencode($text);
		$href.= "&location=" . urlencode($location);

		// Shortens the description, if more than 1000 characters
		$lengthMax			= '1000';
		$details			= urlencode(strip_tags($details));
		$details			= substr($details, 0, $lengthMax);
		$shortenedDetails	= strrpos($details, '+');
		$details			= substr($details, 0, $shortenedDetails);

		$href.= "&description=" . substr($details, 0, $lengthMax) . '...';

		return $href;
	}
}
