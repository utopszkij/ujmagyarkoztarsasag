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
 * @version     3.3.7 2014-05-18
 * @since       3.3.7
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');

class JFormFieldModal_iC_editor extends JFormField
{
	/**
	 * The form field type.
	 */
	protected $type = 'modal_iC_editor';

	/**
	 * Method to get the field input markup.
	 */
	protected function getInput()
	{
		$icName = $this->name;
		$icDefault = $this->default;
		$icValue = $this->value;

		if (strpos($icValue,'\n') !== false)
		{
			$array_newline = array('\\n', '\n');
			$icValue = str_replace($array_newline, '<br />', $icValue);
		}

		$get_period_string = JText::_('COM_ICAGENDA_REGISTRATION_EMAIL_USER_PERIOD_DEFAULT_BODY');
		$get_date_string = JText::_('COM_ICAGENDA_REGISTRATION_EMAIL_USER_DATE_DEFAULT_BODY');

		if  ($icValue == 'COM_ICAGENDA_REGISTRATION_EMAIL_USER_PERIOD_DEFAULT_BODY')
		{
			$icBody = $get_period_string;
		}
		elseif ($icValue == 'COM_ICAGENDA_REGISTRATION_EMAIL_USER_DATE_DEFAULT_BODY')
		{
			$icBody = $get_date_string;
		}
		else
		{
			$icBody = $icValue;
		}

		$editor = JFactory::getEditor();

		$html	= array();

		$html[] = '<div id="'.$this->name.'_ic_editor"><fieldset class="span9 iCleft">';
		$html[] = $editor->display($this->name, $icBody, "100%", "300", "300", "20", 1, null, null, null, array('mode' => 'advanced'));
		$html[] = '</fieldset></div>';

		return implode("\n", $html);
	}
}
