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
 * @version     3.5.3 2014-03-24
 * @since       3.2.10
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');

class JFormFieldModal_ictext_Placeholder extends JFormField
{
	protected $type='modal_ictext_Placeholder';

	protected function getInput()
	{
		$class = JRequest::getVar('class');

		jimport('joomla.application.component.helper');
		$icagendaParams = JComponentHelper::getParams('com_icagenda');

		$replace = array("jform", "[", "]", "_Placeholder");
		$name = str_replace($replace, "", $this->name);

		$Type = $name . '_Placeholder';
		$tos_Type = $icagendaParams->get($Type);

		$placeholder = ( ! isset($tos_Type)) ? JText::_( 'COM_ICAGENDA_' . strtoupper($name) . '_PLACEHOLDER') : '';

		$html ='<input type="text" id="' . $this->id . '" class="' . $class . ' input-xxlarge" name="' . $this->name . '" value="' . $this->value . '" placeholder="' . $placeholder . '"/>';

		return $html;
	}
}
