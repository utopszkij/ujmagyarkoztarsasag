<?php
/**
 *------------------------------------------------------------------------------
 *  iC Library - Library by Jooml!C, for Joomla!
 *------------------------------------------------------------------------------
 * @package     iC Library
 * @subpackage  color
 * @copyright   Copyright (c)2014-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     1.3.0 2015-05-15
 * @since       1.0.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * class iCLibrary
 */
abstract class iCLibrary
{
	/**
	 * Function to set an alert message if a class from Utilities is not loaded
	 *
	 * @since	1.0.0
	 */
	static public function isLoaded($class = null)
	{
		if (!class_exists($class) && $class)
		{
			$app = JFactory::getApplication();

			$alert_message = JText::sprintf('ICAGENDA_CLASS_NOT_FOUND', '<strong>' . $class . '</strong>') . '<br />'
							. JText::_('ICAGENDA_IS_NOT_CORRECTLY_INSTALLED');

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
		else
		{
			return true;
		}
	}

	/**
	 * Function to get microtime
	 *
	 * @since	1.3.0
	 */
	static public function getMicrotime()
	{
		list($usec_cal, $sec_cal) = explode(" ",microtime());
		return ((float)$usec_cal + (float)$sec_cal);
	}
}
