<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril RezŽ, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril RezŽ (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     3.5.9 2015-07-30
 * @since       1.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport('joomla.application.component.controllerform');

/**
 * Event controller class.
 */
class iCagendaControllerMail extends JControllerForm
{
	function __construct()
	{
		$this->view_list = 'icagenda';
		parent::__construct();
	}

	/**
	 * Return Ajax to load date select options
	 *
	 * @since 3.5.9
	 */
	function dates()
	{
		icagendaAjax::getOptionsEventDates('mail');

		// Cut the execution short
//		JFactory::getApplication()->close();
	}

	/**
	 * Send the mail
	 *
	 * @return void
	 *
	 * @since 3.5.9
	 */
	public function send()
	{
		// Check for request forgeries.
		JSession::checkToken('request') or jexit(JText::_('JINVALID_TOKEN'));

		$app	= JFactory::getApplication();
		$jinput	= $app->input;
		$model	= $this->getModel('Mail');

		if ( ! $model->send())
		{
//			$msg = 'ok';
//			$type = 'message';
//		}
//		else
//		{
//			$msg = 'NOT ok';
//			$type = 'error';

			// Get the user data.
			if (version_compare(JVERSION, '3.0', 'lt'))
			{
				$requestData = JRequest::getVar('jform', array(), 'post');
			}
			else
			{
				$requestData = $this->input->post->get('jform', array(), 'array');
			}

			// Save the data in the session.
			$app->setUserState('com_icagenda.mail.data', $requestData);

			// Redirect back to the newsletter screen.
			$this->setRedirect(JRoute::_('index.php?option=com_icagenda&view=mail&layout=edit', false));
//			$this->setredirect('index.php?option=com_icagenda&view=mail&layout=edit', $msg, $type);

			return false;
		}

		// Flush the data from the session.
		$app->setUserState('com_icagenda.mail.data', null);

//		$msg = $model->getError();

		// Redirect back to the newsletter screen.
		$this->setRedirect(JRoute::_('index.php?option=com_icagenda&view=mail&layout=edit', false));
//		$this->setredirect('index.php?option=com_icagenda&view=mail&layout=edit', $msg, $type);

		return true;
	}

	/**
	 * Cancel the mail
	 *
	 * @return void
	 *
	 * @since 3.5.9
	 */
	public function cancel($key = null)
	{
		// Check for request forgeries.
		JSession::checkToken('request') or jexit(JText::_('JINVALID_TOKEN'));

		$app	= JFactory::getApplication();

		// Flush the data from the session.
		$app->setUserState('com_icagenda.mail.data', null);

		$this->setRedirect(JRoute::_('index.php?option=com_icagenda', false));
	}
}
