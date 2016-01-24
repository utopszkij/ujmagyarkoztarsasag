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
 * @version     3.5.6 2015-06-23
 * @since       1.0
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

// J3 DS Define :
if ( ! defined('DS')) define('DS', DIRECTORY_SEPARATOR);

// Get Application
$app = JFactory::getApplication();

// Check Errors: iC Library & iCagenda Utilities
$UTILITIES_DIR = is_dir(JPATH_ADMINISTRATOR . '/components/com_icagenda/utilities');

if ( (!$UTILITIES_DIR)
	|| (!class_exists('iCLibrary')) )
{
	$alert_message = JText::_('ICAGENDA_CAN_NOT_LOAD') . '<br />';
	$alert_message.= '<ul>';
	if (!class_exists('iCLibrary')) $alert_message.= '<li>' . JText::_('IC_LIBRARY_NOT_LOADED') . '</li>';
	if (!$UTILITIES_DIR) $alert_message.= '<li>' . JText::_('ICAGENDA_A_FOLDER_IS_MISSING') . '</li>';
	$alert_message.= '</ul>';
	if (!$UTILITIES_DIR) $alert_message.= JText::_('ICAGENDA_IS_NOT_CORRECTLY_INSTALLED') . ' ';
	if (!$UTILITIES_DIR) $alert_message.= JText::_('ICAGENDA_INSTALL_AGAIN') . '<br />';
	if (!$UTILITIES_DIR) $alert_message.= JText::_('IC_ALTERNATIVELY') . ':<br /><ul>';
	if ($UTILITIES_DIR) $alert_message.= JText::_('IC_PLEASE') . ', ';
	if (!class_exists('iCLibrary'))
	{
		if (!$UTILITIES_DIR) $alert_message.= '<li>';
		$alert_message.= JText::_('IC_LIBRARY_CHECK_PLUGIN_AND_LIBRARY');
		if (!$UTILITIES_DIR) $alert_message.= '</li>';
	}
	if (!$UTILITIES_DIR)
	{
		$alert_message.= '<li>' . JText::Sprintf('ICAGENDA_UTILITIES_FIX_MANUAL'
						, '<strong>admin/utilities</strong>'
						, '<strong>administrator/components/com_icagenda/</strong>');
		$alert_message.= '</li></ul>';
	}

	// Get the message queue
	$messages = $app->getMessageQueue();

	$display_alert_message = false;

	// If we have messages
	if (is_array($messages) && count($messages))
	{
		// Check each message for the one we want
		foreach ($messages as $key => $value)
		{
			if ($value['message'] == $alert_message)
			{
				$display_alert_message = true;
			}
		}
	}

	if (!$display_alert_message)
	{
		$app->enqueueMessage($alert_message, 'error');
	}
}
else
{
	// Loads Utilities
	JLoader::registerPrefix('icagenda', JPATH_ADMINISTRATOR . '/components/com_icagenda/utilities');

	if ( ! defined('IC_LIBRARY'))
	{
		define('IC_LIBRARY', '1.3.0');
	}
}

// Set Input J3
$jinput = JFactory::getApplication()->input;

// Load Live Update & Joomla import
// Joomla 3.x / 2.5 SWITCH
if (version_compare(JVERSION, '3.0', 'ge'))
{
	require_once JPATH_ADMINISTRATOR . '/components/com_icagenda/liveupdate/liveupdate.php';

	if ($jinput->get('view') == 'liveupdate')
	{
		LiveUpdate::handleRequest(); return;
	}
}
else
{
	require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'/liveupdate'.DS.'liveupdate.php'; if (JRequest::getCmd('view','') == 'liveupdate')
	{
		LiveUpdate::handleRequest(); return;
	}
	jimport('joomla.application.component.controller');
}

// Set some global property
$document = JFactory::getDocument();
$document->addStyleDeclaration('.icon-48-icagenda {background-image: none);}');

// Load Vector iCicons Font
JHtml::stylesheet( 'media/com_icagenda/icicons/style.css' );

// CSS files which could be overridden into your site template. (eg. /templates/my_template/css/com_icagenda/icagenda-back.css)
JHtml::stylesheet( 'com_icagenda/icagenda-back.css', false, true );

// Load translations
$language = JFactory::getLanguage();
$language->load('com_icagenda', JPATH_ADMINISTRATOR, 'en-GB', true);
$language->load('com_icagenda', JPATH_ADMINISTRATOR, null, true);

// Access check.
if ( ! JFactory::getUser()->authorise('core.manage', 'com_icagenda'))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// Require helper file
JLoader::register('iCagendaHelper', dirname(__FILE__) . '/helpers/icagenda.php');

// Check config params
icagendaParams::encryptPassword();

// Get an instance of the controller prefixed by iCagenda
// Joomla 3.x / 2.5 SWITCH
if (version_compare(JVERSION, '3.0', 'ge'))
{
	$controller = JControllerLegacy::getInstance('iCagenda');

	// Perform the Request task
	$controller->execute($jinput->get('task'));
}
else
{
	$controller = JController::getInstance('iCagenda');

	// Perform the Request task
	$controller->execute(JRequest::getCmd('task'));
}

// Redirect if set by the controller
$controller->redirect();
