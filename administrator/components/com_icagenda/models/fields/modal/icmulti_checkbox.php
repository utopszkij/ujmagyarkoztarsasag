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
 * @version     3.2.6 2013-11-21
 * @since       3.2.6
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');

class JFormFieldModal_icmulti_checkbox extends JFormField
{
	protected $type='modal_icmulti_checkbox';

	protected function getLabel()
	{
	   return ' ';
	}

	protected function getInput()
	{

		$Explode = explode('_', $this->name);
		$TypeName = $Explode[0].']';

		$replace = array("jform", "[params]", "[", "]");
		$name = str_replace($replace, "", $TypeName);

		$selected = $this->value;
		if (!is_array($selected)) $selected = array();

		$check_1 = ' checked="checked"';
		$check_2 = ' checked="checked"';

		if (in_array('1', $selected)) {
			$check_1 = ' checked="checked"';
		} else {
			$check_1 = '';
		}
		if (in_array('2', $selected)) {
			$check_2 = ' checked="checked"';
		} else {
			$check_2 = '';
		}

		$Type_none = $name.'_none';
		$Type_checkbox = $name.'_checkbox';

		$html	= array();

		$html[] = '<div id="'.$Type_checkbox.'"><fieldset class="span9 iCleft">';
//		$html[] = '<input type="text" value="'.$this->value.'" name="'.$this->name.'"/>';
		$html[] = '<div style="display: inline-block"><input type="checkbox" value="1" name="'.$this->name.'[]"'.$check_1.'/>&nbsp;'.JText::_( 'ICTITLE' ).'</div>';
		$html[] = '<div style="display: inline-block"><input type="checkbox" value="2" name="'.$this->name.'[]"'.$check_2.'/>&nbsp;'.JText::_( 'ICDESC' ).'</div>';
		$html[] = '</fieldset></div>';

		$html[] = '<script type="text/javascript">';
		$html[] = 'document.getElementById("'.$Type_checkbox.'").style.display = "none";';
		$html[] = 'if (typeset == 1) {';
		$html[] = 'document.getElementById("'.$Type_checkbox.'").style.display = "block";';
		$html[] = '}';
//		$html[] = 'if (typeset == 0) {';
//		$html[] = 'document.getElementById("'.$Type_checkbox.'").style.display = "none";';
//		$html[] = '}';
		$html[] = '</script>';

		return implode("\n", $html);
	}
}
