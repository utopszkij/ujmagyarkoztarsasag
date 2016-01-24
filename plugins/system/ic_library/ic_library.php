<?php
/**
 *	Plugin System - iC Library
 *----------------------------------------------------------------------------
 * @package     iC Library
 * @copyright   Copyright (c)2014-2015 Cyril Rezé, Jooml!C - All rights reserved

 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé / Jooml!C
 * @link        http://www.joomlic.com
 *
 * @version     1.2 2014-12-22
 * @since		1.0
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
 *----------------------------------------------------------------------------
*/


// No direct access to this file
defined('_JEXEC') or die();

/**
 * iC Library plugin class.
 *
 * @package     Joomla.plugin
 * @subpackage  System.iClib
 */
class plgSystemiC_library extends JPlugin
{
	/**
	 * Method to register iC library.
	 *
	 * return  void
	 */
	public function onAfterInitialise()
	{
		if (is_dir(JPATH_LIBRARIES . '/ic_library'))
		{
			JLoader::registerPrefix('iC', JPATH_LIBRARIES . '/ic_library');

			// Test if translation is missing, set to en-GB by default
			$language = JFactory::getLanguage();
			$language->load('lib_ic_library', JPATH_SITE, 'en-GB', true);
			$language->load('lib_ic_library', JPATH_SITE, null, true);
		}
	}

	/**
	 * Method to load Custom CSS from Component Config.
	 * NOTE: To be moved to a separate system plugin - iCagenda
	 */
	public function onAfterDispatch()
	{
		// Check if component is installed
		if ( file_exists(JPATH_ADMINISTRATOR . '/components/com_icagenda/icagenda.php') )
		{
			// Custom CSS loading
			$customCSS_activation = JComponentHelper::getParams('com_icagenda')->get('customCSS_activation', '0');
			$customCSS = JComponentHelper::getParams('com_icagenda')->get('customCSS', '');

			if (!empty($customCSS_activation) && $customCSS)
			{
				JFactory::getDocument()->addStyleDeclaration( $customCSS );
			}
		}
	}
}
