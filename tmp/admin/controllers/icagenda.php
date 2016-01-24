<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril RezŽ, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril RezŽ (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     3.0 2013-05-05
 * @since       1.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport('joomla.application.component.controlleradmin');

/**
 * Categories list controller class.
 */
// J2.5 : class iCagendaControlleriCagenda extends JControllerAdmin
class iCagendaControlleriCagenda extends JControllerLegacyAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function &getModel($name = 'icagenda', $prefix = 'iCagendaModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}
