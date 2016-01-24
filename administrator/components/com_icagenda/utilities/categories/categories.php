<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     iCagenda
 * @subpackage  utilities
 * @copyright   Copyright (c)2014-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     3.4.0 2014-05-12
 * @since       3.4.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * class icagendaCategories
 */
class icagendaCategories
{
	/**
	 * Function to return list of categories
	 *
	 * @access	public static
	 * @param	$state (if not defined, state is published ('1'))
	 * @return	list array of categories
	 *
	 * @since   1.0.0
	 */
	static public function getList($state = null)
	{
		// Preparing connection to db
		$db		= JFactory::getDbo();

		// Preparing the query
		$query	= $db->getQuery(true);
		$query->select('c.color AS color, c.title AS title')
			->from('#__icagenda_category AS c');

		if ($state) $query->where("(c.state = '$state')");

		$db->setQuery($query);
		$list = $db->loadObjectList();

		if ($list)
		{
			return $list;
		}
		else
		{
			return false;
		}
	}
}
