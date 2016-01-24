<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     3.5.2 2015-03-13
 * @since       3.4.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');

class JFormFieldModal_thumbs extends JFormField
{
	protected $type='modal_thumbs';

	protected function getInput()
	{
		$replace = array("jform", "params", "[", "]");
		$name_input = str_replace($replace, "", $this->name);

		jimport('joomla.application.component.helper');
		$iCparams = JComponentHelper::getParams('com_icagenda');

		if ($name_input == 'thumb_large')
		{
			$thumbOptions = $iCparams->get('thumb_large');
			$width = is_numeric($thumbOptions[0]) ? $thumbOptions[0] : '900';
			$height = is_numeric($thumbOptions[1]) ? $thumbOptions[1] : '600';
			$quality = is_numeric($thumbOptions[2]) ? $thumbOptions[2] : '100';
			$crop = $thumbOptions[3] ? $thumbOptions[3] : false;
			$default_width = '900';
			$default_height = '600';
			$default_quality = '100';
			$default_crop = '0';
		}
		elseif ($name_input == 'thumb_medium')
		{
			$thumbOptions = $iCparams->get('thumb_medium');
			$width = is_numeric($thumbOptions[0]) ? $thumbOptions[0] : '300';
			$height = is_numeric($thumbOptions[1]) ? $thumbOptions[1] : '300';
			$quality = is_numeric($thumbOptions[2]) ? $thumbOptions[2] : '100';
			$crop = $thumbOptions[3] ? $thumbOptions[3] : false;
			$default_width = '300';
			$default_height = '300';
			$default_quality = '100';
			$default_crop = '0';
		}
		elseif ($name_input == 'thumb_small')
		{
			$thumbOptions = $iCparams->get('thumb_small');
			$width = is_numeric($thumbOptions[0]) ? $thumbOptions[0] : '100';
			$height = is_numeric($thumbOptions[1]) ? $thumbOptions[1] : '100';
			$quality = is_numeric($thumbOptions[2]) ? $thumbOptions[2] : '100';
			$crop = $thumbOptions[3] ? $thumbOptions[3] : false;
			$default_width = '100';
			$default_height = '100';
			$default_quality = '100';
			$default_crop = '0';
		}
		elseif ($name_input == 'thumb_xsmall')
		{
			$thumbOptions = $iCparams->get('thumb_xsmall');
			$width = is_numeric($thumbOptions[0]) ? $thumbOptions[0] : '48';
			$height = is_numeric($thumbOptions[1]) ? $thumbOptions[1] : '48';
			$quality = is_numeric($thumbOptions[2]) ? $thumbOptions[2] : '80';
			$crop = $thumbOptions[3] ? $thumbOptions[3] : true;
			$default_width = '48';
			$default_height = '48';
			$default_quality = '80';
			$default_crop = '1';
		}

		$crop_false = $crop_true = '';

		if (!empty($crop))
		{
			$crop_true = ' selected="selected"';
		}
		else
		{
			$crop_false = ' selected="selected"';
		}

		$quality_80 = '';

		if ($quality == '80')
		{
			$quality_80 =  ' selected="selected"';
		}

		$quality_values = array('100', '95', '90', '85', '80', '75', '70', '60', '50');

		$html = array();

		$html[] = '<div class="span2">' . JText::_('IC_WIDTH') . '<br />';
		$html[] = '<input type="text" class="input-mini" name="'.$this->name.'[]" value="'.$width.'" default="'.$default_width.'"/></div>';

		$html[] = '<div class="span2">' . JText::_('IC_HEIGHT') . '<br />';
		$html[] = '<input type="text" class="input-mini" name="'.$this->name.'[]" value="'.$height.'" default="'.$default_height.'"/></div>';

		$html[] = '<div class="span2">' . JText::_('IC_QUALITY') . '<br />';
		$html[] = '<select id="ThumbMedium_quality" class="input-small" name="'.$this->name.'[]" value="'.$quality.'">';

		foreach ($quality_values AS $qv)
		{
			$html[] = '<option value="'.$qv.'"';

			if ($qv == $quality)
			{
				$html[] = ' selected="selected"';
			}

			$html[] = '>' . JText::_('IC'.$qv.'') . '</option>';
		}

		$html[] = '</select></div>';

		$html[] = '<div class="span2">' . JText::_('IC_CROPPED') . '<br />';
		$html[] = '<select id="ThumbMedium_crop" class="input-small" name="' . $this->name . '[]" value="' . $crop . '">';
		$html[] = '<option value="0" ' . $crop_false . '>'.JText::_('JNO').'</option>';
		$html[] = '<option value="1" ' . $crop_true . '>'.JText::_('JYES').'</option>';
		$html[] = '</select></div>';

		return implode("\n", $html);
	}
}
