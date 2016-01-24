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
 * @version     3.5.13 2015-11-21
 * @since       3.2.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport('joomla.application.component.modelitem');
jimport('joomla.form.form');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

/**
 * iCagenda Submit Event Model
 */
class iCagendaModelSubmit extends JModelItem
{
	protected $data;

	protected $msg;

	function getForm()
	{
	    $form = JForm::getInstance('submit', JPATH_COMPONENT . '/models/forms/submit.xml');

		if (empty($form))
		{
			return false;
		}

	    return $form;
	}

	public function test_input($data)
	{
		$this->data = trim($data);
		$this->data = stripslashes($this->data);

		return $this->data;
	}

	public function getData()
	{
		$app		= JFactory::getApplication();
		$user		= JFactory::getUser();
		$lang		= JFactory::getLanguage();
		$session	= JFactory::getSession();

		jimport( 'joomla.filter.output' );

		$eventTimeZone = null;
		$error_messages = array();

		// Get Params
		$params = $app->getParams();

		$submitAccess = $params->get('submitAccess', '');
		$approvalGroups = $params->get('approvalGroups', array("8"));

		$user_id		= $user->get('id');

		// logged-in Users: Name/User Name Option
		$nameJoomlaUser	= $params->get('nameJoomlaUser', 1);
		$u_name			= ($nameJoomlaUser == 1) ? $user->get('name') : $user->get('username');

		// Redirection settings
		$baseURL		= JURI::base();
		$subpathURL		= JURI::base(true);

		$baseURL		= str_replace('/administrator', '', $baseURL);
		$subpathURL		= str_replace('/administrator', '', $subpathURL);

		$urlsend		= str_replace('&amp;','&', JRoute::_('index.php?option=com_icagenda&view=submit&layout=send'));

		// Sub Path filtering
		$subpathURL		= ltrim($subpathURL, '/');

		// URL List filtering
		$urlsend		= ltrim($urlsend, '/');

		if (substr($urlsend, 0, strlen($subpathURL)+1) == "$subpathURL/")
		{
			$urlsend = substr($urlsend, strlen($subpathURL)+1);
		}

		$urlsend		= rtrim($baseURL, '/') . '/' . ltrim($urlsend, '/');

		// Get return params
		$submit_return			= $params->get('submitReturn', '');
		$submit_return_article	= $params->get('submitReturn_Article', $urlsend);
		$submit_return_url		= $params->get('submitReturn_Url', $urlsend);

		if (($submit_return == 1) && is_numeric($submit_return_article))
		{
			$url_return = JURI::root().'index.php?option=com_content&view=article&id=' . $submit_return_article;
		}
		elseif ($submit_return == 2)
		{
			$url_return = $submit_return_url;
		}
		else
		{
			$url_return = $urlsend;
		}

		// Set alert messages
		$alert_title			= $params->get('alert_title', '');
		$alert_body				= $params->get('alert_body', '');
		$url_redirect			= isset($urlsend_custom) ? $urlsend_custom : $urlsend; // Url custom not yet available.
		$alert_title_redirect	= $alert_title ? $alert_title : JText::_( 'COM_ICAGENDA_EVENT_SUBMISSION' );
		$alert_body_redirect	= $alert_body ? $alert_body : JText::_( 'COM_ICAGENDA_EVENT_SUBMISSION_CONFIRMATION' );

		// Set post data
		$this->data						= new stdClass();
		$this->data->id					= null;
		$this->data->asset_id			= JRequest::getVar('asset_id', '', 'post');
		$this->data->ordering			= 0;
		$this->data->state				= 1;


		// Control: if Manager
		jimport( 'joomla.access.access' );
		$adminUsersArray = array();

		foreach ($approvalGroups AS $ag)
		{
			$adminUsers			= JAccess::getUsersByGroup($ag, False);
			$adminUsersArray	= array_merge($adminUsersArray, $adminUsers);
		}

		$this->data->approval			= (in_array($user_id, $adminUsersArray)) ? '0' : '1';
		$this->data->access				= 1 ;
		$this->data->language			= '*';
//		$menuID 						= JRequest::getVar('menuID', '', 'post');


		// USER NAME
		$this->data->username 			= JRequest::getVar('username', '', 'post');

		if ( ! $this->data->username)
		{
			$error_messages[] = JText::sprintf('COM_ICAGENDA_FORM_VALIDATE_FIELD_REQUIRED_NAME', JText::_('COM_ICAGENDA_SUBMIT_FORM_USER_NAME'));
		}

		// USER EMAIL
		$this->data->created_by_email	= JRequest::getVar('created_by_email', '', 'post');

		if ( ! $this->data->created_by_email)
		{
			$error_messages[] = JText::sprintf('COM_ICAGENDA_FORM_VALIDATE_FIELD_REQUIRED_NAME', JText::_('COM_ICAGENDA_SUBMIT_FORM_USER_EMAIL'));
		}


		// EVENT TITLE
		$this->data->title 				= JRequest::getVar('title', '', 'post');

		if ( ! $this->data->title)
		{
			$error_messages[] = JText::sprintf('COM_ICAGENDA_FORM_VALIDATE_FIELD_REQUIRED_NAME', JText::_('COM_ICAGENDA_FORM_LBL_EVENT_TITLE'));
		}


		// EVENT CATEGORY
		$this->data->catid 				= JRequest::getVar('catid', '', 'post');

		if ( ! $this->data->catid)
		{
			$error_messages[] = JText::sprintf('COM_ICAGENDA_FORM_VALIDATE_FIELD_REQUIRED_NAME', JText::_('COM_ICAGENDA_FORM_LBL_EVENT_CATID'));
		}


		// EVENT IMAGE - Get and Upload Image
		$image							= JRequest::getVar('image', null, 'files', 'array');
		$image_session					= JRequest::getVar('image_session', '', 'post');

		if ($image_session && empty($image))
		{
			$this->data->image = $image_session;
		}
		else
		{
			$this->data->image = $image;

			// Process upload of files
			$this->data->image = $this->frontendImageUpload($this->data->image);
		}

		$noDateTime			= '0000-00-00 00:00:00';
		$noDateTimeShort	= '0000-00-00 00:00';


		// Get Single Dates
		$single_dates 					= JRequest::getVar('dates', '', 'post');

//		$dates = iCString::isSerialized($single_dates) ? unserialize($single_dates) : $this->getDates($single_dates);
        if (iCString::isSerialized($single_dates))
		{
			$dates = unserialize($single_dates);
		}
		else
		{
			$dates = $this->getDates($single_dates);

			if ($lang->getTag() == 'fa-IR'
				&& $dates != array('0000-00-00 00:00')
				&& $dates != array('')
				)
			{
				$dates_to_sql = array();

				foreach ($dates AS $date)
				{
					if (iCDate::isDate($date))
					{
						$year		= date('Y', strtotime($date));
						$month		= date('m', strtotime($date));
						$day		= date('d', strtotime($date));
						$time		= date('H:i', strtotime($date));

						$converted_date = iCGlobalizeConvert::jalaliToGregorian($year, $month, $day, true) . ' ' . $time;
						$dates_to_sql[] = date('Y-m-d H:i', strtotime($converted_date));
					}
				}

				$dates = $dates_to_sql;
			}
		}

//		$dates = !empty($dates[0]) ? $dates : array($noDateTime);
		rsort($dates);

		$datesall = iCDate::isDate($dates[0]) ? $dates[0] : $noDateTimeShort;

		if ($datesall != $noDateTimeShort)
		{
			$this->data->dates 			= serialize($dates);
		}
		else
		{
			$no_date_array				= array($noDateTimeShort);
			$this->data->dates 			= serialize($no_date_array);
		}


		// Set Next Date from Single Dates
		$dates_array = unserialize($this->data->dates);

		$today	= JHtml::date('now', 'Y-m-d H:i:s', $eventTimeZone);
		$next	= JHtml::date($this->data->dates[0], 'Y-m-d H:i:s', $eventTimeZone);

		rsort($dates_array);

		$nextDate = $next;

		if ($next <= $today)
		{
			foreach ($dates_array as $date)
			{
				$single_date = JHtml::date($date, 'Y-m-d H:i:s', $eventTimeZone);

				if ($single_date >= $today)
				{
					$nextDate = $single_date;
				}
			}
		}

		$single_dates_next = $nextDate;


		// PERIOD DATES
		$this->data->startdate			= JRequest::getVar('startdate', '', 'post');
		$this->data->enddate			= JRequest::getVar('enddate', '', 'post');

		$isDate_startdate	= iCDate::isDate($this->data->startdate);
		$isDate_enddate		= iCDate::isDate($this->data->enddate);

		$this->data->startdate	= $isDate_startdate ? $this->data->startdate : $noDateTime;
		$this->data->enddate	= $isDate_enddate ? $this->data->enddate : $noDateTime;

		// Dates from the period
		if ($isDate_startdate && $isDate_enddate)
		{
			$startdate	= $this->data->startdate;
			$enddate	= $this->data->enddate;

			if ($startdate == $noDateTime
				&& $enddate != $noDateTime)
			{
				$enddate = $noDateTime;
			}

			$startcontrol	= JHtml::date($startdate, 'Y-m-d H:i', $eventTimeZone);
			$endcontrol		= JHtml::date($enddate, 'Y-m-d H:i', $eventTimeZone);

			$errorperiod = '';

			if ($startcontrol > $endcontrol)
			{
				$errorperiod = '1';
			}
			else
			{
				$period_all_dates_array	= iCDatePeriod::listDates($startdate, $enddate);
			}

			// Serialize Dates of the Period
			if ($isDate_startdate && $isDate_enddate)
			{
				if ($errorperiod != '1')
				{
					$this->data->period = serialize($period_all_dates_array);
					$ctrl = unserialize($this->data->period);

					if (is_array($ctrl))
					{
						$period = unserialize($this->data->period);
					}
					else
					{
						$period = $this->getPeriod($this->data->period);
					}

					if ($lang->getTag() == 'fa-IR')
					{
						$period_to_sql = array();

						foreach ($period AS $date)
						{
							if (iCDate::isDate($date))
							{
								$year		= date('Y', strtotime($date));
								$month		= date('m', strtotime($date));
								$day		= date('d', strtotime($date));
								$time		= date('H:i', strtotime($date));

								$converted_date = iCGlobalizeConvert::jalaliToGregorian($year, $month, $day, true) . ' ' . $time;
								$period_to_sql[] = date('Y-m-d H:i', strtotime($converted_date));
							}
						}

						$period = $period_to_sql;
					}

					rsort($period);

					$this->data->period = serialize($period);
				}
				else
				{
					$this->data->period = '';
				}
			}

			$period_dates_next = $this->data->startdate;

			$dates_next		= JHtml::date($single_dates_next, 'Y-m-d H:i:s', $eventTimeZone);
			$period_next	= JHtml::date($period_dates_next, 'Y-m-d H:i:s', $eventTimeZone);

			if ($dates_next < $period_next)
			{
				$this->data->next = $period_next;
			}
			else
			{
				$this->data->next = $dates_next;
			}
		}
		else
		{
			$this->data->period	= '';
			$this->data->next	= $single_dates_next;
		}

		// Period and Single Dates not displayed
		if ( (in_array($noDateTime, $dates_array) || in_array($noDateTimeShort, $dates_array))
			&& ( ! $isDate_startdate || ! $isDate_enddate) )
		{
			$this->data->state	= '0';
			$this->data->next	= $today;

			// Error message if no valid dates
			$error_messages[] = JText::sprintf('COM_ICAGENDA_FORM_WARNING', JText::_('COM_ICAGENDA_FORM_ERROR_NO_DATES'));
		}


		// WEEK DAYS
		$this->data->weekdays 			= JRequest::getVar('weekdays', '', 'post');

		if (!isset($this->data->weekdays)
			&& !is_array($this->data->weekdays))
		{
			$this->data->weekdays = '';
		}

		if (isset($this->data->weekdays)
			&& is_array($this->data->weekdays))
		{
			$this->data->weekdays = implode(",", $this->data->weekdays);
		}

		// Joomla 3.x/2.5 SWITCH
		if (version_compare(JVERSION, '3.0', 'ge'))
		{
			$this->data->desc 			= JFactory::getApplication()->input->get('desc', '', 'RAW');
		}
		else
		{
			$this->data->desc 			= JRequest::getVar('desc', '', 'post', 'string', JREQUEST_ALLOWHTML);
		}

		$this->data->shortdesc 			= JRequest::getVar('shortdesc', '', 'post');
		$this->data->metadesc 			= JRequest::getVar('metadesc', '', 'post');
		$this->data->place 				= JRequest::getVar('place', '', 'post');
		$this->data->email 				= JRequest::getVar('email', '', 'post');
		$this->data->phone 				= JRequest::getVar('phone', '', 'post');
		$this->data->website 			= JRequest::getVar('website', '', 'post');

		// ATTACHMENT FILE
		$file							= JRequest::getVar('file', null, 'files', 'array');
		$file_session					= JRequest::getVar('file_session', '', 'post');

		if ($file_session && empty($file))
		{
			$this->data->file = $file_session;
		}
		else
		{
			$this->data->file = $file;

			// Process upload of files
			$this->data->file = $this->frontendFileUpload($this->data->file);
		}



		$this->data->address 			= JRequest::getVar('address', '', 'post');
		$this->data->city 				= JRequest::getVar('city', '', 'post');
		$this->data->country 			= JRequest::getVar('country', '', 'post');
		$this->data->lat 				= JRequest::getVar('lat', '', 'post');
		$this->data->lng 				= JRequest::getVar('lng', '', 'post');

		$this->data->created_by			= $user_id;
		$this->data->created_by_alias	= JRequest::getVar('created_by_alias', '', 'post');
		$this->data->created			= JHtml::Date( 'now', 'Y-m-d H:i:s' );
		$this->data->checked_out		= JRequest::getVar('checked_out', '', 'post');
		$this->data->checked_out_time 	= JRequest::getVar('checked_out_time', '', 'post');

		$this->data->params				= JRequest::getVar('params', '', 'post');
		$this->data->site_itemid		= JRequest::getVar('site_itemid', '0', 'post');
		$site_menu_title				= JRequest::getVar('site_menu_title', '', 'post');


		// Generate Alias
		$this->data->alias				= JFilterOutput::stringURLSafe($this->data->title);

		// Alias is not generated if non-latin characters, so we fix it by using created date, or title if unicode is activated, as alias
		if ($this->data->alias == null)
		{
			if (JFactory::getConfig()->get('unicodeslugs') == 1)
			{
				$this->data->alias = JFilterOutput::stringURLUnicodeSlug($this->data->title);
			}
			else
			{
				$this->data->alias = JFilterOutput::stringURLSafe($this->data->created);
			}
		}

		// Convert the params field to a string.
		if ( isset($this->data->params)
			&& is_array($this->data->params) )
		{
			$parameter = new JRegistry;
			$parameter->loadArray($this->data->params);
			$this->data->params = (string)$parameter;
		}

		$this->data->asset_id = null;

		$custom_fields		= JRequest::getVar('custom_fields', '', 'post');

		// Check if Custom Fields required not empty
		$customfields_list = icagendaCustomfields::getListCustomFields(2, 1);

		if ($customfields_list)
		{
			foreach ($customfields_list AS $cf)
			{
				if (isset($custom_fields[$cf->cf_slug])
					&& $cf->cf_required == 1
					&& $custom_fields[$cf->cf_slug] == '')
				{

					$options_required = array('list', 'radio');

					// If type is list or radio, should have options
					if ((in_array($cf->cf_type, $options_required) && $cf->cf_options)
						|| ! in_array($cf->cf_type, $options_required))
					{
						$error_messages[] = JText::_( 'COM_ICAGENDA_FORM_VALIDATE_FIELD_REQUIRED' ) . ' ' . $cf->cf_title;
					}
				}
			}
		}

		$address_session	= JRequest::getVar('address_session', '', 'post');
		$submit_tos			= JRequest::getVar('submit_tos', '', 'post');

		// Set Form Data to Session
		$session->set('ic_submit', $this->data);
		$session->set('custom_fields', $custom_fields);

		$session->set('ic_submit_dates', $this->data->dates);
		$session->set('ic_submit_catid', $this->data->catid);
		$session->set('ic_submit_shortdesc', $this->data->shortdesc);
		$session->set('ic_submit_metadesc', $this->data->metadesc);
		$session->set('ic_submit_city', $this->data->city);
		$session->set('ic_submit_country', $this->data->country);
		$session->set('ic_submit_lat', $this->data->lat);
		$session->set('ic_submit_lng', $this->data->lng);
		$session->set('ic_submit_address', $this->data->address);
		$session->set('ic_submit_tos', $submit_tos);

		// Captcha Control
		$captcha			= JRequest::getVar('recaptcha_response_field', '', 'post');
		$captcha_plugin		= $params->get('captcha') ? $params->get('captcha') : $app->getCfg('captcha');
		$submit_captcha		= $params->get('submit_captcha', 1);

		if ($captcha_plugin && $submit_captcha != '0')
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

			$res = $dispatcher->trigger('onCheckAnswer', $captcha);

			if (!$res[0])
			{
				// message if captcha is invalid
				$error_messages[] = JText::sprintf('COM_ICAGENDA_FORM_ERROR', JText::_('COM_ICAGENDA_FORM_ERROR_INCORRECT_CAPTCHA_SOL'));
			}
		}

		// Get the message queue
		if (count($error_messages))
		{
			$app->enqueueMessage('<strong>' . JText::_( 'COM_ICAGENDA_FORM_NC' ) . '</strong>', 'error');

			foreach ($error_messages AS $msg)
			{
				$app->enqueueMessage($msg, 'error');
			}

			return false;
		}

		// clear the data so we don't process it again
		$session->clear('ic_submit');
		$session->clear('custom_fields');
		$session->clear('ic_submit_dates');
		$session->clear('ic_submit_catid');
		$session->clear('ic_submit_shortdesc');
		$session->clear('ic_submit_metadesc');
		$session->clear('ic_submit_city');
		$session->clear('ic_submit_country');
		$session->clear('ic_submit_lat');
		$session->clear('ic_submit_lat');
		$session->clear('ic_submit_address');
		$session->clear('ic_submit_tos');

		// insert Event in Database
		$db = JFactory::getDbo();

		if (($this->data->username != NULL)
			&& ($this->data->title != NULL)
			&& ($this->data->created_by_email != NULL))
		{
			$db->insertObject('#__icagenda_events', $this->data, id);
		}
		else
		{
			JError::raiseError(500, implode('<br />', $errors));

			return false;
		}

		// Save Custom Fields to database
		if (isset($custom_fields) && is_array($custom_fields))
		{
			icagendaCustomfields::saveToData($custom_fields, $this->data->id, 2);
		}


		if ((isset($this->data->id)) AND ($this->data->id != '0') AND ($this->data->username != NULL) AND ($this->data->title != NULL))
		{
			self::notificationManagerEmail($this->data, $site_menu_title, $user_id);

			if ( !in_array($user_id, $adminUsersArray ))
			{
				self::notificationUserEmail($this->data, $urlsend);
			}
		}
		else
		{
			JError::raiseError(500, implode('<br />', $errors));

			return false;
		}

		// Redirect after successful submission
		if ($submit_return != 2)
		{
			$app->enqueueMessage($alert_body_redirect, $alert_title_redirect);
			$app->redirect(htmlspecialchars_decode($url_return));
		}
		else
		{
			$url_return = iCUrl::urlParsed($url_return, 'scheme');
			$app->redirect($url_return);
		}
	}


	protected function notificationManagerEmail($data, $site_menu_title, $user_id)
	{
		$event_id			= $data->id;
		$event_title		= $data->title;
		$event_site_itemid	= $data->site_itemid;
		$event_username		= $data->username;
		$event_user_email	= $data->created_by_email;
		$event_ref			= JHtml::date('now', 'Ymd') . $data->id;

		// Load iCagenda Global Options
		$iCparams = JComponentHelper::getParams('com_icagenda');

		// Load Joomla Application
		$app	= JFactory::getApplication();

		// Load Joomla Config Mail Options
		$sitename	= $app->getCfg('sitename');
		$mailfrom	= $app->getCfg('mailfrom');
		$fromname	= $app->getCfg('fromname');

		$siteURL = JURI::base();
		$siteURL = rtrim($siteURL,'/');

		// Itemid Request (automatic detection of the first iCagenda menu-link, by menuID, and depending of current language)
		$menu_items		= icagendaMenus::iClistMenuItems();
		$itemid_array	= array();

		foreach ($menu_items as $l)
		{
			array_push($itemid_array, $l->id);
		}

		sort($itemid_array);

		$itemID = $itemid_array[0];

		// Set Notification Email to each User groups allowed to approve event submitted
		$groupid = $iCparams->get('approvalGroups', array("8"));

		// Load Global Option for Autologin
		$autologin = $iCparams->get('auto_login', 1);

		jimport( 'joomla.access.access' );
		$adminUsersArray = array();

		foreach ($groupid AS $gp)
		{
			$adminUsers			= JAccess::getUsersByGroup($gp, False);
			$adminUsersArray	= array_merge($adminUsersArray, $adminUsers);
		}

        $db = JFactory::getDbo();
		$query = $db->getQuery(true);

		if ($user_id == NULL)
		{
			$user_id = 0;
		}

		if (!in_array($user_id, $adminUsersArray))
		{
			$matches = implode(',', $adminUsersArray);
			$query->select('ui.username AS username, ui.email AS email, ui.password AS passw, ui.block AS block, ui.activation AS activation')->from('#__users AS ui')->where( "ui.id IN ($matches) ");
		}
		else
		{
			$matches = $user_id;
			$query->select('ui.username AS username, ui.email AS email, ui.password AS passw, ui.block AS block, ui.activation AS activation')->from('#__users AS ui')->where( "ui.id = $matches ");
		}

		$db->setQuery($query);
        $managers = $db->loadObjectList();

        foreach ($managers AS $manager)
        {
			// Mail Replacements
			$replacements = array(
				"\\n"				=> "\n",
				'[SITENAME]'		=> $sitename,
				'[USERNAME]'		=> $event_username,
				'[EMAIL]'			=> $event_user_email,
				'[EVENT_TITLE]'		=> $event_title,
				'[EVENT_REF]'		=> $event_ref,
				'&nbsp;'			=> ' ',
			);

			if (!in_array($user_id, $adminUsersArray))
			{
				$type = 'approval';
			}
			else
			{
				$type = 'confirmation';
			}

			// Create Admin Mailer
			$adminmailer = JFactory::getMailer();

			// Set Sender of Notification Email
			$adminmailer->setSender(array( $mailfrom, $fromname ));

        	$username	= $manager->username;
        	$passw		= $manager->passw;
        	$email		= $manager->email;

			// Set Recipient of Notification Email
			$adminrecipient = $email;
			$adminmailer->addRecipient($adminrecipient);

			// Set Subject of Admin Notification Email
			if ( ! in_array($user_id, $adminUsersArray))
			{
				$adminsubject = JText::sprintf('COM_ICAGENDA_SUBMISSION_ADMIN_EMAIL_SUBJECT', $event_username, $sitename);
			}
			else
			{
				$adminsubject = JText::sprintf('COM_ICAGENDA_LEGEND_NEW_EVENT').': '.$event_title;
			}

			// Set Url to preview and checking of event submitted
			$baseURL = JURI::base();
			$subpathURL = JURI::base(true);

			$baseURL = str_replace('/administrator', '', $baseURL);
			$subpathURL = str_replace('/administrator', '', $subpathURL);

			if ($autologin == 1)
			{
				$urlpreview = str_replace('&amp;', '&', JRoute::_('index.php?option=com_icagenda&view=list&layout=event&id='.(int)$event_id.'&Itemid='.(int)$itemID.'&icu='.$username.'&icp='.$passw));
//				$urlcheck = str_replace('&amp;', '&', JRoute::_('administrator/index.php?option=com_icagenda&view=events&Itemid='.(int)$itemID).'&icu='.$username.'&icp='.$passw.'&filter_search='.$event_id);
			}
			else
			{
				$urlpreview = str_replace('&amp;', '&', JRoute::_('index.php?option=com_icagenda&view=list&layout=event&id='.(int)$event_id.'&Itemid='.(int)$itemID));
//				$urlcheck = str_replace('&amp;', '&', JRoute::_('administrator/index.php?option=com_icagenda&view=events&Itemid='.(int)$itemID).'&filter_search='.$event_id);
			}

//			$urlpreview = str_replace('&amp;', '&', $siteURL.'/index.php?option=com_icagenda&view=list&layout=event&id='.(int)$event_id.'&Itemid='.(int)$itemID.'&icu='.$username.'&icp='.$passw);
			$urlpreviewshort = str_replace('&amp;', '&', JRoute::_('index.php?option=com_icagenda&view=list&layout=event&id='.(int)$event_id.'&Itemid='.(int)$itemID));

//			$urlcheckshort = str_replace('&amp;', '&', $siteURL . '/administrator/index.php?option=com_icagenda&view=events');

			// Sub Path filtering
			$subpathURL = ltrim($subpathURL, '/');

			// URL Event Preview filtering
			$urlpreview			= ltrim($urlpreview, '/');
			$urlpreviewshort	= ltrim($urlpreviewshort, '/');

			if (substr($urlpreview, 0, strlen($subpathURL)+1) == "$subpathURL/")
			{
				$urlpreview = substr($urlpreview, strlen($subpathURL)+1);
			}

			if (substr($urlpreviewshort, 0, strlen($subpathURL)+1) == "$subpathURL/")
			{
				$urlpreviewshort = substr($urlpreviewshort, strlen($subpathURL)+1);
			}

			$urlpreview			= rtrim($baseURL, '/') . '/' . ltrim($urlpreview, '/');
			$urlpreviewshort	= rtrim($baseURL, '/') . '/' . ltrim($urlpreviewshort, '/');

			// URL Event Check filtering
//			$urlcheck = ltrim($urlcheck, '/');

//			if (substr($urlcheck, 0, strlen($subpathURL)+1) == "$subpathURL/")
//			{
//				$urlcheck = substr($urlcheck, strlen($subpathURL)+1);
//			}

//			$urlcheck = rtrim($baseURL, '/') . '/' . ltrim($urlcheck, '/');

			// Set Body of User Notification Email
			$adminbodycontent = JText::sprintf( 'COM_ICAGENDA_SUBMISSION_ADMIN_EMAIL_HELLO', $username) . ',<br /><br />';

			if ($type == 'approval')
			{
				$adminbodycontent.= JText::_( 'COM_ICAGENDA_SUBMISSION_ADMIN_EMAIL_NEW_EVENT' ).'<br /><br />';
				$adminbodycontent.= JText::sprintf( 'COM_ICAGENDA_SUBMISSION_ADMIN_EMAIL_APPROVE_INFO', $sitename).'<br /><br />';
				$adminbodycontent.= JText::_( 'COM_ICAGENDA_SUBMISSION_ADMIN_EMAIL_APPROVE_LINK' ).': <a href="'.$urlpreview.'">'.$urlpreviewshort.'</a><br /><br />';
			}

			if ($type == 'confirmation')
			{
				$adminbodycontent.= JText::_( 'COM_ICAGENDA_SUBMISSION_ADMIN_EMAIL_APPROVED_REVIEW' ).'<br /><br />';
				$adminbodycontent.= '<a href="' . $urlpreview . '">' . $urlpreviewshort . '</a><br /><br />';
			}

			$user_email_mailto = '<a href="mailto:' . $event_user_email . '">' . $event_user_email . '</a>';

			$adminbodycontent.= JText::sprintf( 'COM_ICAGENDA_SUBMISSION_ADMIN_EMAIL_SITE_MENUID', $event_site_itemid, $site_menu_title).'<br />';
			$adminbodycontent.= JText::sprintf( 'COM_ICAGENDA_SUBMISSION_ADMIN_EMAIL_USER_INFO', $event_username, $user_email_mailto).'<br /><br />';

			if ($autologin == 1)
			{
				$adminbodycontent.= '<hr><small>'.JText::sprintf( 'COM_ICAGENDA_SUBMISSION_ADMIN_EMAIL_FOOTER', $sitename).'<small>';
			}
			else
			{
				$adminbodycontent.= '<hr><small>'.JText::sprintf( 'COM_ICAGENDA_SUBMISSION_ADMIN_EMAIL_FOOTER_NO_AUTOLOGIN', $sitename).'<small>';
			}

			$adminbody = rtrim($adminbodycontent);

			// Apply Replacements
			foreach ($replacements as $key => $value)
			{
				$adminsubject	= str_replace($key, $value, $adminsubject);
				$adminbody		= str_replace($key, $value, $adminbody);
			}

			$adminmailer->isHTML(true);
			$adminmailer->Encoding = 'base64';

			// Set Subject
			$adminmailer->setSubject($adminsubject);

			// Set Body
			$adminmailer->setBody($adminbody);

			// Send User Notification Email
			if (isset($email))
			{
				if ($manager->block == '0' && empty($manager->activation))
				{
					$send = $adminmailer->Send();
				}
			}
		}
	}

	protected function notificationUserEmail ($data, $url)
	{
		$email			= $data->created_by_email;
		$username		= $data->username;
		$event_title	= $data->title;
		$event_ref		= JHtml::date( 'now', 'Ymd' ) . $data->id;

		// Load Joomla Application
		$app	= JFactory::getApplication();

		// Create User Mailer
		$mailer = JFactory::getMailer();

		// Load Joomla Config Mail Options
		$sitename	= $app->getCfg('sitename');
		$mailfrom	= $app->getCfg('mailfrom');
		$fromname	= $app->getCfg('fromname');

		// Set Sender of Notification Email
		$mailer->setSender(array( $mailfrom, $fromname ));

		// Set Recipient of User Notification Email
		$userrecipient = $data->created_by_email;
		$mailer->addRecipient($userrecipient);

		// MAIL
		$replacements = array(
			"\\n"				=> "\n",
			'[SITENAME]'		=> $sitename,
			'[EMAIL]'			=> $email,
			'[EVENT_TITLE]'		=> $event_title,
			'[EVENT_REF]'		=> $event_ref,
			'&nbsp;'			=> ' ',
		);

		// Set Body of Notification Email
		$user_submit_body = JText::sprintf( 'COM_ICAGENDA_USER_EMAIL_HELLO', $username ) . ',<br /><br />';
		$user_submit_body.= JText::sprintf( 'COM_ICAGENDA_EVENT_SUBMISSION_THANK_YOU', $sitename ) . '<br />';
		$user_submit_body.= JText::_( 'COM_ICAGENDA_EVENT_SUBMISSION_EDITOR_REVIEW' ) . '<br />';
		$user_submit_body.= JText::_( 'COM_ICAGENDA_EVENT_SUBMISSION_CONFIRMATION_EMAIL' ) . '<br /><br />';
		$user_submit_body.= JText::sprintf( 'COM_ICAGENDA_USER_EMAIL_EVENT_TITLE_AND_REF_NO', $event_title, $event_ref ) . '<br /><br />';
		$user_submit_body.= JText::_( 'COM_ICAGENDA_USER_EMAIL_BEST_REGARDS' ) . '<br />';

		$user_submit_body = rtrim($user_submit_body);

		foreach ($replacements as $key => $value)
		{
			$subject = str_replace($key, $value, $subject);
			$user_submit_body = str_replace($key, $value, $user_submit_body);
		}

		$mailer->isHTML(true);
		$mailer->Encoding = 'base64';

		// Set Subject of User Notification Email
		$subject = JText::sprintf( 'COM_ICAGENDA_EVENT_SUBMISSION_THANK_YOU', $sitename );
		$mailer->setSubject($subject);

		// Set Body of User Notification Email
		$mailer->setBody($user_submit_body);

		// Send User Notification Email
		if (isset($email))
		{
			$send = $mailer->Send();
		}
	}


	protected function getDates($dates)
	{
		$dates		= str_replace('d=', '', $dates);
		$dates		= str_replace('+', ' ', $dates);
		$dates		= str_replace('%3A', ':', $dates);
		$ex_dates	= explode('&', $dates);

		return $ex_dates;
	}

	protected function getPeriod($period)
	{
		$period		= str_replace('d=', '', $period);
		$period		= str_replace('+', ' ', $period);
		$period		= str_replace('%3A', ':', $period);
		$ex_period	= explode('&', $period);

		return $ex_period;
	}


	protected function frontendImageUpload ($image)
	{
		// Get Joomla Images PATH set
		$params		= JComponentHelper::getParams('com_media');
		$image_path	= $params->get('image_path');

		// Clean up filename
		$imagename	= JFile::makeSafe($image['name']);

		// Process filename
		while (JFile::exists(JPATH_ROOT . '/' . $image_path . '/icagenda/frontend/images/' . $imagename))
		{
			$src	= $image['tmp_name'];

			// Get Image title and extension type
			$decomposition = explode( '/' , $imagename );

			// in each parent
			$i = 0;
			while ( isset($decomposition[$i]) )
				$i++;
			$i--;
			$imgname		= $decomposition[$i];
			$fichier		= explode('.', $decomposition[$i]);
			$imgtitle		= $fichier[0];
			$imgextension	= isset($fichier[1]) ? $fichier[1] : '';

			// Increment filename if already exists
			$imagename		= iCString::increment($imgtitle, 'dash') . '.' . $imgextension;

			// Controls image mimetype, and fixes file extension if missing in filename
			$allowed_mimetypes	= array('jpg', 'jpeg', 'png', 'gif');

			if ( ! in_array($imgextension, $allowed_mimetypes))
			{
				$fileinfos		= getimagesize($src);
				$mimeType		= $fileinfos['mime'];
				$ex_mimeType	= explode('/', $mimeType);
				$file_extension	= $ex_mimeType[1];

				$imagename		= $imagename . '.' . $file_extension;
			}
		}

		if ($imagename != '')
		{
			//Set up the source and destination of the file
			$src	= $image['tmp_name'];
			$dest	=  JPATH_SITE . '/images/icagenda/frontend/images/' . $imagename;

			// Create Folder iCagenda in ROOT/IMAGES_PATH/icagenda and sub-folders if do not exist
			$folder[0][0]	=	'icagenda/frontend/' ;
			$folder[0][1]	= 	JPATH_ROOT . '/' . $image_path . '/' . $folder[0][0];
			$folder[1][0]	=	'icagenda/frontend/images/';
			$folder[1][1]	= 	JPATH_ROOT . '/' . $image_path . '/' . $folder[1][0];
			$error	 = array();

			foreach ($folder as $key => $value)
			{
				if (!JFolder::exists( $value[1]))
				{
					if (JFolder::create( $value[1], 0755 ))
					{
						$this->data = "<html>\n<body bgcolor=\"#FFFFFF\">\n</body>\n</html>";
						JFile::write($value[1]."/index.html", $this->data);
						$error[] = 0;
					}
					else
					{
						$error[] = 1;
					}
				}
				else //Folder exist
				{
					$error[] = 0;
				}
			}

			if ( JFile::upload($src, $dest, false) )
			{
				return 'images/icagenda/frontend/images/' . $imagename;
			}
		}
	}

	protected function frontendFileUpload ($file)
	{
		//Clean up filename to get rid of strange characters like spaces etc
		$filename = JFile::makeSafe($file['name']);

		if ($filename != '')
		{
			//Set up the source and destination of the file
			$src = $file['tmp_name'];
			$dest =  JPATH_SITE.'/images/icagenda/frontend/attachments/'.$filename;

			// Get Joomla Images PATH setting
			$params = JComponentHelper::getParams('com_media');
			$image_path = $params->get('image_path');

			// Create Folder iCagenda in ROOT/IMAGES_PATH/icagenda and sub-folders if do not exist
			$folder[0][0]	=	'icagenda/frontend/' ;
			$folder[0][1]	= 	JPATH_ROOT.'/'.$image_path.'/'.$folder[0][0];
			$folder[1][0]	=	'icagenda/frontend/attachments/';
			$folder[1][1]	= 	JPATH_ROOT.'/'.$image_path.'/'.$folder[1][0];
			$error	 = array();

			foreach ($folder as $key => $value)
			{
				if (!JFolder::exists( $value[1]))
				{
					if (JFolder::create( $value[1], 0755 ))
					{
						$this->data = "<html>\n<body bgcolor=\"#FFFFFF\">\n</body>\n</html>";
						JFile::write($value[1]."/index.html", $this->data);
						$error[] = 0;
					}
					else
					{
						$error[] = 1;
					}
				}
				else //Folder exist
				{
					$error[] = 0;
				}
			}

			if ( JFile::upload($src, $dest, false) )
			{
				return 'images/icagenda/frontend/attachments/' . $filename;
			}

		}
	}


	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since   1.6
	 *
	 * @return void
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication('site');

		// Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);
	}
}
