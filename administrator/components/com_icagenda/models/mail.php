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
 * @version     3.5.9 2015-07-30
 * @since       2.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport('joomla.application.component.modeladmin');
jimport('joomla.mail.mail');


/**
 * iCagenda model.
 */
class iCagendaModelMail extends JModelAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_ICAGENDA';

	/**
	 * Method to get the row form.
	 *
	 * @param   array    $data      An optional array of data for the form to interogate.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  JForm	A JForm object on success, false on failure
	 *
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_icagenda.mail', 'mail', array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 *
	 * @since   1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		if (version_compare(JVERSION, '3.0', 'lt'))
		{
			$data = JFactory::getApplication()->getUserState('com_icagenda.display.mail.data', array());

			if (empty($data))
			{
//				$data = $this->getItem();
				$data = JFactory::getApplication()->getUserState('com_icagenda.mail.data', array());
			}
		}
		else
		{
			$data = JFactory::getApplication()->getUserState('com_icagenda.display.mail.data', array());

			if (empty($data))
			{
				$data = JFactory::getApplication()->getUserState('com_icagenda.mail.data', array());
			}

			$this->preprocessData('com_icagenda.mail', $data);
		}

		return $data;
	}

	/**
	 * Method to preprocess the form
	 *
	 * @param   JForm   $form   A form object.
	 * @param   mixed   $data   The data expected for the form.
	 * @param   string  $group  The name of the plugin group to import (defaults to "content").
	 *
	 * @return  void
	 *
	 * @since   1.6
	 * @throws  Exception if there is an error loading the form.
	 */
	protected function preprocessForm(JForm $form, $data, $group = 'user')
	{
		parent::preprocessForm($form, $data, $group);
	}

	/**
	 * Send the email
	 *
	 * @return  boolean
	 */
	public function send()
	{
		$app    = JFactory::getApplication();
		$data   = $app->input->post->get('jform', array(), 'array');
		$user   = JFactory::getUser();
		$access = new JAccess;

		// Set Form Data to Session
		$session = JFactory::getSession();
		$session->set('ic_newsletter', $data);

		$mailer = JFactory::getMailer();
		$config = JFactory::getConfig();

		$send	= '';

		$sender = array(
		    $app->getCfg( 'mailfrom' ),
		    $app->getCfg( 'fromname' )
		    );

		$mailer->setSender($sender);

//		$list		= array_key_exists('list', $data) ? $data['list'] : ''; // DEPRECATED
		$eventid	= array_key_exists('eventid', $data) ? $data['eventid'] : '';
		$date		= array_key_exists('date', $data) ? $data['date'] : '';

		$db     = $this->getDbo();
		$query	= $db->getQuery(true);
		$query->select('r.email, r.eventid, r.state, r.date, r.people')
			->from('`#__icagenda_registration` AS r');
		$query->where('r.state = 1');
		$query->where('r.email <> ""');
		$query->where('r.eventid = ' . (int) $eventid);

		if ($date != 'all')
		{
			if (iCDate::isDate($date))
			{
				$query->where('r.date = ' . $db->q($date));
			}
			elseif ($date == 1)
			{
				$query->where('r.period = 1');
			}
			elseif ($date)
			{
				// Fix for old date saving data
				$query->where('r.date = ' . $db->q($date));
			}
			else
			{
				$query->where('r.period = 0');
			}
		}

		$db->setQuery($query);

		$result	= $db->loadObjectList();

		$list	= '';
		$people	= 0;

		foreach ($result as $v)
		{
			$list.= $v->email . ', ';
			$people = ($people + $v->people);
		}

		$subject	= array_key_exists('subject', $data) ? $data['subject'] : '';
		$messageget	= array_key_exists('message', $data) ? $data['message'] : '';

		$list_emails	= explode(', ', $list);

		// Remove dupplicated email addresses
		$recipient			= array_unique($list_emails);
		$dupplicated_emails	= count($list_emails) - count($recipient);

		$obj		= $subject;
		$message	= $messageget;

		$recipient	= array_filter($recipient);
//		$mailer->addRecipient($recipient);
//		$mailer->addRecipient($sender);
		$mailer->addBCC($recipient);

		$content	= stripcslashes($message);
		$body		= str_replace('src="images/', 'src="' . JURI::root() . '/images/', $content);

//		$mailer->setSender(array( $mailfrom, $fromname ));
		$mailer->setSubject($obj);
		$mailer->isHTML(true);
		$mailer->Encoding = 'base64';
		$mailer->setBody($body);

		if ($obj && $body && $eventid && ($date || $date == '0'))
		{
			$send = $mailer->Send();
		}

		if ($send !== true)
		{
		    $app->enqueueMessage(JText::_('COM_ICAGENDA_NEWSLETTER_ERROR_ALERT'), 'error');

		    if ( ! $obj)
		    {
		    	$app->enqueueMessage('- ' . JText::_('COM_ICAGENDA_NEWSLETTER_NO_OBJ_ALERT'), 'error');
		    }
		    if ( ! $body)
		    {
		    	$app->enqueueMessage('- ' . JText::_('COM_ICAGENDA_NEWSLETTER_NO_BODY_ALERT'), 'error');
		    }
		    if ( ! $eventid && ( ! $date && $date != '0'))
		    {
		    	$app->enqueueMessage('- ' . JText::_('COM_ICAGENDA_NEWSLETTER_NO_EVENT_SELECTED'), 'error');
		    }
		    elseif ( $eventid && ( ! $date && $date != '0'))
		    {
		    	$app->enqueueMessage('- ' . JText::_('COM_ICAGENDA_NEWSLETTER_NO_DATE_SELECTED'), 'error');
		    }

		    return false;
		}
		else
		{
		    $app->enqueueMessage('<h2>' . JText::_('COM_ICAGENDA_NEWSLETTER_SUCCESS') . '</h2>', 'message');

			$app->enqueueMessage($this->listSend($recipient, 0, $people), 'message');

			if ($dupplicated_emails)
			{
				$app->enqueueMessage('<i>' . JText::sprintf('COM_ICAGENDA_NEWSLETTER_NB_EMAIL_NOT_SEND', $dupplicated_emails) . '</i>', 'message');
			}

//			$app->setUserState('com_icagenda.mail.data', null);
//			echo '<pre>'.print_r($recipient, true).'</pre>';

		    return true;
		}
	}

	public function listSend($recipient, $level = 0, $people = null)
	{
		$number		= 0;
		$list_send	= '';

		foreach($recipient AS $key => $value)
		{
			if (is_array($value) | is_object($value))
			{
				parent::listArray($value, $level+=1);
			}
			else
			{
//				$number = ($key + 1);
				$number = ($number + 1);

				$list_send.= str_repeat("&nbsp;", $level*3);
				$list_send.= $number . " : " . $value . "<br>";
			}
		}

//		$list_send.= '<div>&nbsp;</div>';
		$list_send.= '<h4>' . JText::_('COM_ICAGENDA_NEWSLETTER_NB_EMAIL_SEND').' = ' . $number . '';
		$list_send.= '<small> (' . JText::_('COM_ICAGENDA_REGISTRATION_TICKETS').': ' . $people . ')</small></h4>';

		return $list_send;
	}
}
