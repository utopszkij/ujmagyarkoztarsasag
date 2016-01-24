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
 * @version     3.2.5 2013-11-10
 * @since       3.2.5
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');

class JFormFieldModal_ictxt_type extends JFormField
{
	/**
	 * The form field type.
	 */
	protected $type = 'modal_ictxt_type';

	/**
	 * Method to get the field input markup.
	 */
	protected function getInput()
	{
		jimport('joomla.application.component.helper');
		$icagendaParams = JComponentHelper::getParams('com_icagenda');

		$replace = array("jform", "[", "]", "_Type");
		$name = str_replace($replace, "", $this->name);

		$Type = $name.'_Type';
		$tos_Type = $icagendaParams->get($Type, '');

		$class_default = '';
		$class_article = '';
		$class_custom = '';
		$checked_default = '';
		$checked_article = '';
		$checked_custom = '';
		if ($tos_Type == '') {
			$class_default = 'btn-success';
			$checked_default = ' checked="checked"';
			$checked_article = '';
			$checked_custom = '';
		}
		elseif ($tos_Type == '1') {
			$class_article = 'btn-success';
			$checked_default = '';
			$checked_article = ' checked="checked"';
			$checked_custom = '';
		}
		elseif ($tos_Type == '2') {
			$class_custom = 'btn-success';
			$checked_default = '';
			$checked_article = '';
			$checked_custom = ' checked="checked"';
		} else {
			$class_default = 'btn-success';
			$checked_default = ' checked="checked"';
			$checked_article = '';
			$checked_custom = '';
		}

		$html	= array();
		$html[]	= '<fieldset class="radio btn-group">';
		$html[]	= '<label class="'.$class_default.'">'.JText::_( 'IC_DEFAULT' ).'<input type="radio"  id="'.$name.'_Type0" name="'.$this->name.'" value=""  onClick="tosdefault_'.$name.'();"'.$checked_default.' /></label>';
		$html[]	= '<label class="'.$class_article.'">'.JText::_( 'IC_ARTICLE' ).'<input type="radio"  id="'.$name.'_Type1" name="'.$this->name.'" value="1"  onClick="tosarticle_'.$name.'();"'.$checked_article.' /></label>';
		$html[]	= '<label class="'.$class_custom.'">'.JText::_( 'IC_CUSTOM_TEXT' ).'<input type="radio"  id="'.$name.'_Type2" name="'.$this->name.'" value="2"  onClick="toscustom_'.$name.'();"'.$checked_custom.' /></label>';
		$html[]	= '</fieldset>';



		$html[]	= '<script type="text/javascript">';
		$html[]	= 'function tosdefault_'.$name.'()';
		$html[]	= '{';
		$html[]	= 'document.getElementById("'.$name.'_default").style.display = "block";';
		$html[]	= 'document.getElementById("'.$name.'_article").style.display = "none";';
		$html[]	= 'document.getElementById("'.$name.'_custom").style.display = "none";';
		$html[]	= '$("#'.$name.'_Type0").attr("checked", "checked");';
		$html[]	= '}';
		$html[]	= 'function tosarticle_'.$name.'()';
		$html[]	= '{';
		$html[]	= 'document.getElementById("'.$name.'_default").style.display = "none";';
		$html[]	= 'document.getElementById("'.$name.'_article").style.display = "block";';
		$html[]	= 'document.getElementById("'.$name.'_custom").style.display = "none";';
		$html[]	= '$("#'.$name.'_Type1").attr("checked", "checked");';
		$html[]	= '}';
		$html[]	= 'function toscustom_'.$name.'()';
		$html[]	= '{';
		$html[]	= 'document.getElementById("'.$name.'_default").style.display = "none";';
		$html[]	= 'document.getElementById("'.$name.'_article").style.display = "none";';
		$html[]	= 'document.getElementById("'.$name.'_custom").style.display = "block";';
		$html[]	= '$("#'.$name.'_Type2").attr("checked", "checked");';
		$html[]	= '}';
		$html[]	= '</script>';

		return implode("\n", $html);
	}
}
