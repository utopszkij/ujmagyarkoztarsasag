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
 * @version     3.1.10 2013-09-11
 * @since       3.2
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * Extended Utility class for the iCagenda component.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_iCagenda
 * @since       3.2
 */
class JHtmlEvents
{

	public static function approveEvents()
	{
		$states = array(
			1	=> array(
				'img'				=> 'tick.png',
				'task'				=> 'approve',
				'text'				=> '',
				'active_title'		=> 'COM_ICAGENDA_TOOLBAR_APPROVE',
				'inactive_title'	=> '',
				'tip'				=> true,
				'active_class'		=> 'unpublish',
				'inactive_class'	=> 'unpublish'
			),
			0	=> array(
				'img'				=> 'publish_x.png',
				'task'				=> '',
				'text'				=> '',
				'active_title'		=> '',
				'inactive_title'	=> 'COM_ICAGENDA_APPROVED',
				'tip'				=> true,
				'active_class'		=> 'publish',
				'inactive_class'	=> 'publish'
			)
		);
		return $states;
	}
}
