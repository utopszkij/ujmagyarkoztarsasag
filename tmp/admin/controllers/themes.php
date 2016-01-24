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
 * @version     3.0 2013-06-03
 * @since       2.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport('joomla.application.component.controllerform');
jimport('joomla.client.helper');

class iCagendaControllerthemes extends JControllerForm
{
	protected	$option 		= 'com_icagenda';

	function __construct() {
		parent::__construct();
		$this->registerTask( 'themeinstall'  , 	'themeinstall' );
	}

	function themeinstall() {

		JRequest::checkToken() or die( 'Invalid Token' );
		$post	= JRequest::get('post');
		$theme = array();

		if (isset($post['theme_component'])) {
			$theme['component'] = 1;
		}

		if (empty($theme)) {

			$ftp =& JClientHelper::setCredentialsFromRequest('ftp');

			$model	= &$this->getModel( 'themes' );

			if ($model->install($theme)) {
				$cache = &JFactory::getCache('mod_menu');
				$cache->clean();
				$msg = JText::_('COM_ICAGENDA_SUCCESS_THEME_INSTALLED');
			}
		} else {
			$msg = JText::_('COM_ICAGENDA_ERROR_THEME_APPLICATION_AREA');
		}

		$this->setRedirect( 'index.php?option=com_icagenda&view=themes', $msg );
	}

	function cancel() {
		$this->setRedirect( 'index.php?option=com_icagenda' );
	}

}
?>
