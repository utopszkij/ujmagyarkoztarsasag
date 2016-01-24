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
 * @version     3.2.0.1 2013-09-22
 * @since       3.2.0.1
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');

class JFormFieldModal_ictext_type extends JFormField
{
	protected $type='modal_ictext_type';

	protected function getInput()
	{
		jimport('joomla.application.component.helper');

		$icagendaParams = JComponentHelper::getParams('com_icagenda');

		$replace = array("jform", "[", "]");
		$name = str_replace($replace, "", $this->name);
		$Type = $icagendaParams->get($name, '');

		$Type_default = $name.'_default';
		$Type_content = $name.'_custom';

		$class_default = '';
		$class_custom = '';
		$checked_default = '';
		$checked_custom = '';
		if ($Type == '') {
			$class_default = 'btn-success';
			$checked_default = ' checked="checked"';
			$checked_custom = '';
		}
		elseif ($Type == '2') {
			$class_custom = 'btn-success';
			$checked_default = '';
			$checked_custom = ' checked="checked"';
		} else {
			$class_default = 'btn-success';
			$checked_default = ' checked="checked"';
			$checked_custom = '';
		}

		$html	= array();
		$html[]	= '<fieldset class="radio btn-group">';
		$html[]	= '<label class="'.$class_default.'">'.JText::_( 'IC_DEFAULT' ).'<input type="radio"  id="'.$name.'_0" name="'.$this->name.'" value=""  onClick="icdefault_'.$name.'();"'.$checked_default.' /></label>';
		$html[]	= '<label class="'.$class_custom.'">'.JText::_( 'IC_CUSTOM_TEXT' ).'<input type="radio"  id="'.$name.'_2" name="'.$this->name.'" value="2"  onClick="iccustom_'.$name.'();"'.$checked_custom.' /></label>';
		$html[]	= '</fieldset>';



		$html[]	= '<script type="text/javascript">';
		$html[]	= 'function icdefault_'.$name.'()';
		$html[]	= '{';
//		$html[]	= 'document.getElementById("'.$Type_default.'").style.display = "block";';
		$html[]	= 'document.getElementById("'.$Type_content.'").style.display = "none";';
		$html[]	= '$("#'.$name.'_0").attr("checked", "checked");';
		$html[]	= '}';
		$html[]	= 'function iccustom_'.$name.'()';
		$html[]	= '{';
//		$html[]	= 'document.getElementById("'.$Type_default.'").style.display = "none";';
		$html[]	= 'document.getElementById("'.$Type_content.'").style.display = "block";';
		$html[]	= '$("#'.$name.'_2").attr("checked", "checked");';
		$html[]	= '}';
		$html[]	= '</script>';

		return implode("\n", $html);
	}
}
