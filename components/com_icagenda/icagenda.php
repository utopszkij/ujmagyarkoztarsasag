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
 * @version     3.4.0 2014-12-14
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
if (!defined('DS')) define('DS',DIRECTORY_SEPARATOR);

// Get Application
$app = JFactory::getApplication();

// Check Errors: iC Library & iCagenda Utilities
$UTILITIES_DIR = is_dir(JPATH_ADMINISTRATOR . '/components/com_icagenda/utilities');

if ( (!$UTILITIES_DIR)
	|| (!class_exists('iCLibrary')) )
{
	$alert_message = JText::_('ICAGENDA_CAN_NOT_LOAD').'<br />';
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

	return false;
}

// Load Utilities
JLoader::registerPrefix('icagenda', JPATH_ADMINISTRATOR . '/components/com_icagenda/utilities');

// Test if translation is missing, set to en-GB by default
$language = JFactory::getLanguage();
$language->load('com_icagenda', JPATH_SITE, 'en-GB', true);
$language->load('com_icagenda', JPATH_SITE, null, true);

// Set Input J3
// not in use, because of known issues with JInput and Magic Quotes (Deprecated in PHP 5.3.0 and removed in PHP 5.4.0).
$iCinput = $app->input;

// Load Vector iCicons Font
JHtml::stylesheet( 'media/com_icagenda/icicons/style.css' );

// CSS files which could be overridden into your site template. (eg. /templates/my_template/css/com_icagenda/icagenda-front.css)
JHtml::stylesheet( 'com_icagenda/icagenda-front.css', false, true );
JHtml::stylesheet( 'com_icagenda/tipTip.css', false, true );

// Set iCtip
$iCtip	 = array();
$iCtip[] = '	jQuery(document).ready(function(){';
$iCtip[] = '		jQuery(".iCtip").tipTip({maxWidth: "200", defaultPosition: "top", edgeOffset: 1});';
$iCtip[] = '	});';

// Add the script to the document head.
JFactory::getDocument()->addScriptDeclaration(implode("\n", $iCtip));

// Require the base controller
require_once( JPATH_COMPONENT.'/controller.php' );

// Require specific controller if requested
if ( $controller = JRequest::getVar( 'controller' ) )
{
	$path = JPATH_COMPONENT.'/controllers/'.$controller.'.php';
	if ( file_exists( $path ) ) { require_once $path; }
	else { $controller = ''; }
}

// Create the controller
$classname	= 'icagendaController'.ucfirst($controller);
$controller	= new $classname( );

// Perform the Requested task
$controller->execute( JRequest::getVar( 'task' ) );

// Redirect if set by the controller
$controller->redirect();
