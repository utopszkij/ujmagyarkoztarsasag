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

class JFormFieldModal_tos_content extends JFormField
{
	protected $type='modal_tos_content';

//	protected function getLabel()
//	{
//	   return ' ';
//	}

	protected function getInput()
	{

		jimport('joomla.application.component.helper');
		$icagendaParams = JComponentHelper::getParams('com_icagenda');
		$tosContent = $icagendaParams->get('tosContent', '');
		$tos_Type = $icagendaParams->get('tos_Type', '');


		$editor = JFactory::getEditor();
//		$editor = JEditor::getEditor();

		$html	= array();

		$html[] = '<div id="tos_custom"><fieldset class="span9 iCleft">';
		$html[] = $editor->display($this->name, $tosContent, "100%", "300", "300", "20", 1, null, null, null, array('mode' => 'advanced'));
		$html[] = '</fieldset></div>';

		if ($tos_Type == '2') {
			$html[] = '<script type="text/javascript">';
			$html[] = 'document.getElementById("ic_default").style.display = "none";';
			$html[] = 'document.getElementById("ic_article").style.display = "none";';
			$html[] = 'document.getElementById("tos_custom").style.display = "block";';
			$html[] = '</script>';
		} else {
			$html[] = '<script type="text/javascript">';
			$html[] = 'document.getElementById("tos_custom").style.display = "none";';
			$html[] = '</script>';
		}

		return implode("\n", $html);
	}
}
