<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     iCagenda
 * @subpackage  utilities
 * @copyright   Copyright (c)2012-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     3.4.0 2014-06-29
 * @since       3.4.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * class icagendaClass
 */
class icagendaClass
{
	/**
	 * Function to set an alert message if a class from Utilities is not loaded
	 *
	 * @since	3.4.0
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
}
