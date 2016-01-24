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
 * @version     3.4.0 2014-07-02
 * @since       1.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_icagenda')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

/**
 * iCagenda helper.
 */
class iCagendaHelper
{
	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($submenu)
	{
		if(version_compare(JVERSION, '3.0', 'lt'))
		{
			JSubMenuHelper::addEntry(
				JText::_('COM_ICAGENDA_TITLE_ICAGENDA'),
				'index.php?option=com_icagenda&view=icagenda',
				$submenu == 'icagenda'
			);
			if (JFactory::getUser()->authorise('icagenda.access.categories', 'com_icagenda'))
			{
				JSubMenuHelper::addEntry(
					JText::_('COM_ICAGENDA_TITLE_CATEGORIES'),
					'index.php?option=com_icagenda&view=categories',
					$submenu == 'categories'
				);
			}
			if (JFactory::getUser()->authorise('icagenda.access.events', 'com_icagenda'))
			{
				JSubMenuHelper::addEntry(
					JText::_('COM_ICAGENDA_TITLE_EVENTS'),
					'index.php?option=com_icagenda&view=events',
					$submenu == 'events'
				);
			}
			if (JFactory::getUser()->authorise('icagenda.access.registrations', 'com_icagenda'))
			{
				JSubMenuHelper::addEntry(
					JText::_('COM_ICAGENDA_TITLE_REGISTRATION'),
					'index.php?option=com_icagenda&view=registrations',
					$submenu == 'registrations'
				);
			}
			if (JFactory::getUser()->authorise('icagenda.access.newsletter', 'com_icagenda'))
			{
				JSubMenuHelper::addEntry(
					JText::_('COM_ICAGENDA_TITLE_NEWSLETTER'),
					'index.php?option=com_icagenda&view=mail&layout=edit',
					$submenu == 'newsletter'
				);
			}
			if (JFactory::getUser()->authorise('icagenda.access.customfields', 'com_icagenda'))
			{
				JSubMenuHelper::addEntry(
					JText::_('COM_ICAGENDA_TITLE_CUSTOMFIELDS'),
					'index.php?option=com_icagenda&view=customfields',
					$submenu == 'customfields'
				);
			}
			if (JFactory::getUser()->authorise('icagenda.access.features', 'com_icagenda'))
			{
				JSubMenuHelper::addEntry(
					JText::_('COM_ICAGENDA_TITLE_FEATURES'),
					'index.php?option=com_icagenda&view=features',
					$submenu == 'features'
				);
			}
			if (JFactory::getUser()->authorise('icagenda.access.themes', 'com_icagenda'))
			{
				JSubMenuHelper::addEntry(
					JText::_('COM_ICAGENDA_THEMES'),
					'index.php?option=com_icagenda&view=themes',
					$submenu == 'themes'
				);
			}
			JSubMenuHelper::addEntry(
				JText::_('COM_ICAGENDA_INFO'),
				'index.php?option=com_icagenda&view=info',
				$submenu == 'info'
			);

			$document = JFactory::getDocument();

			/**
			 * Set Titles iCagenda
			 */
			if ($submenu == 'icagenda')
			{
				$document->setTitle(JText::_('COM_ICAGENDA'));
			}
			if ($submenu == 'categories')
			{
				$document->setTitle(JText::_('COM_ICAGENDA') . ' | ' . JText::_('COM_ICAGENDA_TITLE_CATEGORIES'));
			}
			if ($submenu == 'events')
			{
				$document->setTitle(JText::_('COM_ICAGENDA') . ' | ' . JText::_('COM_ICAGENDA_TITLE_EVENTS'));
			}
			if ($submenu == 'registrations')
			{
				$document->setTitle(JText::_('COM_ICAGENDA') . ' | ' . JText::_('COM_ICAGENDA_TITLE_REGISTRATION'));
			}
			if ($submenu == 'newsletter')
			{
				$document->setTitle(JText::_('COM_ICAGENDA') . ' | ' . JText::_('COM_ICAGENDA_TITLE_NEWSLETTER'));
			}
			if ($submenu == 'customfields')
			{
				$document->setTitle(JText::_('COM_ICAGENDA') . ' | ' . JText::_('COM_ICAGENDA_TITLE_CUSTOMFIELDS'));
			}
			if ($submenu == 'features')
			{
				$document->setTitle(JText::_('COM_ICAGENDA') . ' | ' . JText::_('COM_ICAGENDA_TITLE_FEATURES'));
			}
			if ($submenu == 'themes')
			{
				$document->setTitle(JText::_('COM_ICAGENDA') . ' | ' . JText::_('COM_ICAGENDA_THEMES'));
			}
			if ($submenu == 'info')
			{
				$document->setTitle(JText::_('COM_ICAGENDA') . ' | ' . JText::_('COM_ICAGENDA_INFO'));
			}

			$document->addStyleDeclaration('
				.icon48icagenda{background: url(../media/com_icagenda/images/XXX.png);}
				.icon-48-events {background: url(../media/com_icagenda/images/all_events-48.png) no-repeat;}
				.icon-48-event {background: url(../media/com_icagenda/images/new_event-48.png) no-repeat;}
				.icon-48-registration {background: url(../media/com_icagenda/images/registration-48.png) no-repeat;}
				.icon-48-categories {background: url(../media/com_icagenda/images/all_cats-48.png) no-repeat;}
				.icon-48-category {background: url(../media/com_icagenda/images/new_cat-48.png) no-repeat;}
				.icon-48-generic {background: url(../media/com_icagenda/images/iconicagenda48.png) no-repeat;}
				.icon-48-mail {background: url(../media/com_icagenda/images/newsletter-48.png) no-repeat;}
				.icon-48-themes {background: url(../media/com_icagenda/images/themes-48.png) no-repeat;}
				.icon-48-customfields {background: url(../media/com_icagenda/images/customfields-48.png) no-repeat;}
				.icon-48-info {background: url(../media/com_icagenda/images/info-48.png) no-repeat;}
			');
		}
		else
		{
			JHtmlSidebar::addEntry(
				JText::_('COM_ICAGENDA_TITLE_ICAGENDA'),
				'index.php?option=com_icagenda&view=icagenda',
				$submenu == 'icagenda'
			);
			if (JFactory::getUser()->authorise('icagenda.access.categories', 'com_icagenda'))
			{
				JHtmlSidebar::addEntry(
					JText::_('COM_ICAGENDA_TITLE_CATEGORIES'),
					'index.php?option=com_icagenda&view=categories',
					$submenu == 'categories'
				);
			}
			if (JFactory::getUser()->authorise('icagenda.access.events', 'com_icagenda'))
			{
				JHtmlSidebar::addEntry(
					JText::_('COM_ICAGENDA_TITLE_EVENTS'),
					'index.php?option=com_icagenda&view=events',
					$submenu == 'events'
				);
			}
			if (JFactory::getUser()->authorise('icagenda.access.registrations', 'com_icagenda'))
			{
				JHtmlSidebar::addEntry(
					JText::_('COM_ICAGENDA_TITLE_REGISTRATION'),
					'index.php?option=com_icagenda&view=registrations',
					$submenu == 'registrations'
				);
			}
			if (JFactory::getUser()->authorise('icagenda.access.newsletter', 'com_icagenda'))
			{
				JHtmlSidebar::addEntry(
					JText::_('COM_ICAGENDA_TITLE_NEWSLETTER'),
					'index.php?option=com_icagenda&view=mail&layout=edit',
					$submenu == 'newsletter'
				);
			}
			if (JFactory::getUser()->authorise('icagenda.access.customfields', 'com_icagenda'))
			{
				JHtmlSidebar::addEntry(
					JText::_('COM_ICAGENDA_TITLE_CUSTOMFIELDS'),
					'index.php?option=com_icagenda&view=customfields',
					$submenu == 'customfields'
				);
			}
			if (JFactory::getUser()->authorise('icagenda.access.features', 'com_icagenda'))
			{
				JHtmlSidebar::addEntry(
					JText::_('COM_ICAGENDA_TITLE_FEATURES'),
					'index.php?option=com_icagenda&view=features',
					$submenu == 'features'
				);
			}
			if (JFactory::getUser()->authorise('icagenda.access.themes', 'com_icagenda'))
			{
				JHtmlSidebar::addEntry(
					JText::_('COM_ICAGENDA_THEMES'),
					'index.php?option=com_icagenda&view=themes',
					$submenu == 'themes'
				);
			}
			JHtmlSidebar::addEntry(
				JText::_('COM_ICAGENDA_INFO'),
				'index.php?option=com_icagenda&view=info',
				$submenu == 'info'
			);
		}
	}

	/**
	 * Gets a list of the actions that can be performed.
	 */
	public static function getActions($messageId = 0)
	{
		$user   = JFactory::getUser();
		$result = new JObject;

		if (empty($messageId))
		{
			$assetName = 'com_icagenda';
		}
		else
		{
			$assetName = 'com_icagenda.message.'.(int) $messageId;
		}

		$actions = array(
			'core.admin',
			'core.manage',
			'core.create',
			'core.edit',
			'core.delete',
			'core.edit.state',
			'core.edit.own',
			'icagenda.access.categories',
			'icagenda.access.events',
			'icagenda.access.registrations',
			'icagenda.access.newsletter',
			'icagenda.access.customfields',
			'icagenda.access.features',
			'icagenda.access.themes'
		);

		foreach ($actions as $action)
		{
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}

	/**
	 * Tests whether a string is serialized before attempting to unserialize it
	 *
	 * ( TO BE REMOVED WHEN ALL CALLS FROM IC LIBRARY !!! )
	 */
	public static function isSerialized($str)
	{
		return ($str == serialize(false) || @unserialize($str) !== false);
	}
}
