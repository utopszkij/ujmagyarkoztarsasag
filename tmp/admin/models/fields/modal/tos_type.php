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
 * @version     3.2.0 2013-09-18
 * @since       3.2.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');

class JFormFieldModal_tos_type extends JFormField
{
	protected $type='modal_tos_type';

	protected function getInput()
	{
		jimport('joomla.application.component.helper');

		$icagendaParams = JComponentHelper::getParams('com_icagenda');
		$tos_Type = $icagendaParams->get('tos_Type', '');
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
		$html[]	= '<label class="'.$class_default.'">'.JText::_( 'IC_DEFAULT' ).'<input type="radio"  id="tos_Type0" name="'.$this->name.'" value=""  onClick="tosdefault();"'.$checked_default.' /></label>';
		$html[]	= '<label class="'.$class_article.'">'.JText::_( 'IC_ARTICLE' ).'<input type="radio"  id="tos_Type1" name="'.$this->name.'" value="1"  onClick="tosarticle();"'.$checked_article.' /></label>';
		$html[]	= '<label class="'.$class_custom.'">'.JText::_( 'IC_CUSTOM_TEXT' ).'<input type="radio"  id="tos_Type2" name="'.$this->name.'" value="2"  onClick="toscustom();"'.$checked_custom.' /></label>';
		$html[]	= '</fieldset>';



		$html[]	= '<script type="text/javascript">';
//		$html[]	= 'var tos_Type0 = document.getElementById("tos_Type0").checked;';
//		$html[]	= 'var tos_Type1 = document.getElementById("tos_Type1").checked;';
//		$html[]	= 'var tos_Type2 = document.getElementById("tos_Type2").checked;';
//		$html[]	= 'if(tos_Type0==true)';
//		$html[]	= '{';
//		$html[]	= 'document.getElementByName("tos_Type").value = "";';
//		$html[]	= '$("#tos_Type1").attr("checked", "checked");';
//		$html[]	= '}';
//		$html[]	= 'if(tos_Type1==true)';
//		$html[]	= '{';
//		$html[]	= 'document.getElementByName("tos_Type").value = 1;';
//		$html[]	= '}';
//		$html[]	= 'if(tos_Type2==true)';
//		$html[]	= '{';
//		$html[]	= 'document.getElementByName("tos_Type").value = 2;';
//		$html[]	= '}';
//		$html[]	= '';
//		$html[]	= '';
		$html[]	= 'function tosdefault()';
		$html[]	= '{';
		$html[]	= 'document.getElementById("ic_default").style.display = "block";';
		$html[]	= 'document.getElementById("ic_article").style.display = "none";';
		$html[]	= 'document.getElementById("tos_custom").style.display = "none";';
		$html[]	= '$("#tos_Type0").attr("checked", "checked");';
		$html[]	= '}';
		$html[]	= 'function tosarticle()';
		$html[]	= '{';
		$html[]	= 'document.getElementById("ic_default").style.display = "none";';
		$html[]	= 'document.getElementById("ic_article").style.display = "block";';
		$html[]	= 'document.getElementById("tos_custom").style.display = "none";';
		$html[]	= '$("#tos_Type1").attr("checked", "checked");';
		$html[]	= '}';
		$html[]	= 'function toscustom()';
		$html[]	= '{';
		$html[]	= 'document.getElementById("ic_default").style.display = "none";';
		$html[]	= 'document.getElementById("ic_article").style.display = "none";';
		$html[]	= 'document.getElementById("tos_custom").style.display = "block";';
		$html[]	= '$("#tos_Type2").attr("checked", "checked");';
		$html[]	= '}';
		$html[]	= '</script>';

		return implode("\n", $html);
	}
}
