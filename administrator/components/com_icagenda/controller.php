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
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * Controller class - iCagenda.
 */
class iCagendaController extends JControllerLegacy
{
	/**
	 * Method to display a view.
	 *
	 * @param	boolean			$cachable	If true, the view output will be cached
	 * @param	array			$urlparams	An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 * @since	1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT . '/helpers/icagenda.php';

		// Set Input J3
		$jinput = JFactory::getApplication()->input;

		// Load the submenu.
		if (version_compare(JVERSION, '3.0', 'lt'))
		{
			iCagendaHelper::addSubmenu(JRequest::getCmd('view', 'icagenda'));
			$view = JRequest::getCmd('view', 'icagenda');
			JRequest::setVar('view', $view);
		}
		else
		{
			iCagendaHelper::addSubmenu($jinput->get('view', 'icagenda'));
			$view = $jinput->get('view', 'icagenda');
			$jinput->set('view', $view);
		}

		parent::display();

		return $this;
	}
}
