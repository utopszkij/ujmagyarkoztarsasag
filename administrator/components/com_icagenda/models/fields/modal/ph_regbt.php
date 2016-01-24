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
 * @version     3.1.3 2013-08-08
 * @since       3.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');

class JFormFieldModal_ph_regbt extends JFormField
{
	protected $type='modal_ph_regbt';

	protected function getInput()
	{
		$class = JRequest::getVar('class');

		jimport('joomla.application.component.helper');
		$icagendaParams = JComponentHelper::getParams('com_icagenda');
		$extRegButtonText = $icagendaParams->get('RegButtonText');

		if (!isset($extRegButtonText)) { $extRegButtonText = JText::_( 'COM_ICAGENDA_REGISTRATION_REGISTER'); }

		$html ='<input type="text" id="'.$this->id.'" class="'.$class.'" name="'.$this->name.'" value="'.$this->value.'" placeholder="'.$extRegButtonText.'"/>';

		return $html;
	}
}
