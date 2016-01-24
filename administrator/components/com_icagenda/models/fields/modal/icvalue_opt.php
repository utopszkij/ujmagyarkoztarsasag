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
 * @version     3.2.9 2013-12-22
 * @since       3.2.3
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');

class JFormFieldModal_icvalue_opt extends JFormField
{
	protected $type='modal_icvalue_opt';

	protected function getInput()
	{

		$replace = array("jform", "params", "[", "]");
		$name = str_replace($replace, "", $this->name);

		$Type = $this->value;

		if ($name == 'calendarclosebtn') {
			$default_text = JText::_( 'JTOOLBAR_DEFAULT' );
		} else {
			$default_text = JText::_( 'JGLOBAL_USE_GLOBAL' );
		}

		$Type_default = $name.'_default';
		$Type_content = $name.'_custom';

		$class_default = '';
		$class_custom = '';
		$checked_default = ' checked="checked"';
		$checked_custom = '';
		if ($Type == '0') {
			$class_default = 'btn-primary';
			$checked_default = ' checked="checked"';
			$checked_custom = '';
		}
		elseif ($Type == '1') {
			$class_custom = 'btn-success';
			$checked_default = '';
			$checked_custom = ' checked="checked"';
		} else {
			$class_default = 'btn-primary';
			$checked_default = ' checked="checked"';
			$checked_custom = '';
		}

		$html	= array();


		$html[]	= '<fieldset class="radio btn-group">';
		$html[]	= '<label class="'.$class_default.'">'.$default_text.'<input type="radio"  id="'.$name.'_0" name="'.$this->name.'" value="0"  onClick="icdefault_'.$name.'();"'.$checked_default.' /></label>';
		$html[]	= '<label class="'.$class_custom.'">'.JText::_( 'COM_ICAGENDA_LBL_CUSTOM_VALUE' ).'<input type="radio"  id="'.$name.'_1" name="'.$this->name.'" value="1"  onClick="iccustom_'.$name.'();"'.$checked_custom.' /></label>';
		$html[]	= '</fieldset>';


		$html[]	= '<script type="text/javascript">';
		$html[]	= 'var typeset = '.$Type.';';
		$html[]	= 'function icdefault_'.$name.'()';
		$html[]	= '{';
		$html[]	= 'document.getElementById("'.$Type_content.'").style.display = "none";';
		$html[]	= '$("#'.$name.'_0").attr("checked", "checked");';
		$html[]	= '}';
		$html[]	= 'function iccustom_'.$name.'()';
		$html[]	= '{';
		$html[]	= 'document.getElementById("'.$Type_content.'").style.display = "block";';
		$html[]	= '$("#'.$name.'_1").attr("checked", "checked");';
		$html[]	= '}';
		$html[]	= '</script>';

		return implode("\n", $html);
	}
}
