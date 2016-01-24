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
 * @version     3.4.0 2014-07-13
 * @since       3.4.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * class icagendaTheme
 */
class icagendaTheme
{
	/**
	 * Function to Check Theme Packs Compatibility
	 *
	 * @return	list of Incompatible Theme Packs
	 *
	 * @since	3.4.0
	 */
	static public function checkThemePacks()
	{
		// Check Theme Packs Compatibility
		icagendaTheme::checkIncompatibleThemePacks('CUSTOM_FIELDS',
													'event',
													'COM_ICAGENDA_TITLE_CUSTOMFIELDS',
													'http://www.icagenda.com/theme-pack-upgrade/3-4-0-add-custom-fields');

		icagendaTheme::checkIncompatibleThemePacks('FEATURES_ICONS',
													'events',
													'COM_ICAGENDA_TITLE_FEATURES',
													'http://www.icagenda.com/theme-pack-upgrade/3-4-0-add-feature-icons');
	}
	/**
	 * Function to set an alert message if a string is missing in a theme pack
	 *
	 * @params	$string				string to be checked
	 * 			$file_name			file to be tested
	 * 			$functionnality		functionnality not usable with theme pack
	 *
	 * @return	list of Incompatible Theme Packs
	 *
	 * @since	3.4.0
	 */
	static public function checkIncompatibleThemePacks($string, $file_name, $functionnality, $info_url = null)
	{
		$app = JFactory::getApplication();

		// Render list of incompatible Theme Packs
		$list = self::incompatibleList($string, $file_name);

		if ($list)
		{
			if (version_compare(JVERSION, '3.0', 'lt'))
			{
				$im_list	= implode('<br /> - ', $list);
				$setlist	= ' - '.$im_list.' ';
			}
			else
			{
				$im_list	= implode('</li><li>', $list);
				$setlist	= '<ul><li>'.$im_list.'</li></ul>';
			}

			$title = 'COM_ICAGENDA_THEME_PACKS_COMPATIBILITY';
			$description = 'COM_ICAGENDA_THEME_PACKS_INCOMPATIBLE_ALERT';

			// Set Alert Message
			$alert	= array();

			if (count($list) >= 1)
			{
				$alert[]	= '<div style="clear:both">';
				$alert[]	=  '<b>'.JText::_( $title ).'</b>';
				$alert[]	= '<p>';
				$alert[]	=  JText::sprintf( $description, '<strong>' . JText::_($functionnality) . '</strong>' );
				if ($info_url) $alert[]	=  ' <a class="modal" rel="{size: {x: 700, y: 500}, handler:\'iframe\'}" href="'.$info_url.'">' .JText::_( 'IC_MORE_INFORMATION' ). '</a>';
				$alert[]	= '</p>';

				$alert[]	= '<p>';
				$alert[]	= $setlist;
				$alert[]	= '</p>';

				$alert[]	= '</div>';
			}

			$alert_message = implode("\n", $alert);

			$app->enqueueMessage($alert_message, 'warning');
		}
	}

	/*
	 * Function to check if 'string' is defined inside the file THEME_$file.php for each Theme Pack.
	 *
	 * @return	list of incompatible Theme Packs.
	 *
	 * @since	3.4.0
	 */
	static public function incompatibleList($string, $file_name)
	{
		$array_themes = Array();

		$dirname = JPATH_SITE.'/components/com_icagenda/themes/packs';

		if (ini_get('allow_url_fopen') && file_exists($dirname))
		{
			$handle = opendir($dirname);

			while (false !== ($theme = readdir($handle)))
			{
				if ( !is_file($dirname.$theme)
					&& $theme!= '.'
					&& $theme!='..'
					&& $theme!='index.php'
					&& $theme!='index.html'
					&& $theme!='.DS_Store'
					&& $theme!='.thumbs' )
				{
					$day_php = $dirname.'/'.$theme.'/'.$theme.'_day.php';
					$event_php = $dirname.'/'.$theme.'/'.$theme.'_event.php';
					$events_php = $dirname.'/'.$theme.'/'.$theme.'_events.php';
					$registration_php = $dirname.'/'.$theme.'/'.$theme.'_registration.php';

					$array_files_php = array($day_php, $event_php, $events_php, $registration_php);

					$count = 0;

					foreach ($array_files_php AS $file_php)
					{
						if (iCFile::hasString($string, $file_php))
						{
							$count = $count+1;
						}
					}

					if ($count < 1)
					{
						array_push($array_themes, $theme);
					}
				}
			}

			$handle = closedir($handle);
		}

		sort($array_themes);

		if ($array_themes) return $array_themes;

		return false;
	}
}
