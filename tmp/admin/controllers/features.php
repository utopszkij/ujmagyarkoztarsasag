<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      doorknob & Cyril Rezé
 * @link        http://www.joomlic.com
 *
 * @version     3.4.0 2014-07-02
 * @since       3.4.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport('joomla.application.component.controlleradmin');

/**
 * Features list controller class.
 */
class iCagendaControllerFeatures extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	3.4.0
	 */
	public function getModel($name = 'feature', $prefix = 'iCagendaModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}
}
