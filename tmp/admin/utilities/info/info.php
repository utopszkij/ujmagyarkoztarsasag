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
 * @version     3.5.6 2015-05-17
 * @since       3.5.6
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * class icagendaInfo
 */
class icagendaInfo
{
	/**
	 * Function to add comment with iCagenda version (used for faster support)
	 *
	 * @since	3.4.0
	 */
	static public function commentVersion()
	{
		$params		= JComponentHelper::getParams('com_icagenda');
		$release	= $params->get('release', '');
		$icsys		= $params->get('icsys', 'core');

		$icagenda	= 'iCagenda ' . strtoupper($icsys) . ' ' . $release;

		if ($icsys == 'core')
		{
			$icagenda.= ' by Jooml!C - http://www.joomlic.com';
		}

		echo "<!-- " . $icagenda . " -->";

		return true;
	}
}
