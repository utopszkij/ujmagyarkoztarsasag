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

class JFormFieldModal_ictxt_content extends JFormField
{
	/**
	 * The form field type.
	 */
	protected $type = 'modal_ictxt_content';

	/**
	 * Method to get the field input markup.
	 */
	protected function getInput()
	{
		jimport('joomla.application.component.helper');
		$icagendaParams = JComponentHelper::getParams('com_icagenda');

		$replace = array("jform", "[", "]", "Content");
		$name = str_replace($replace, "", $this->name);

		$tosContent = $icagendaParams->get($name.'Content', '');
		$tos_Type = $icagendaParams->get($name.'_Type', '');

		$editor = JFactory::getEditor();

		$html	= array();

		$html[] = '<div id="'.$name.'_custom"><fieldset class="span9 iCleft">';
		$html[] = $editor->display($this->name, $tosContent, "100%", "300", "300", "20", 1, null, null, null, array('mode' => 'advanced'));
		$html[] = '</fieldset></div>';

		if ($tos_Type == '2') {
			$html[] = '<script type="text/javascript">';
			$html[] = 'document.getElementById("'.$name.'_custom").style.display = "block";';
			$html[] = '</script>';
		} else {
			$html[] = '<script type="text/javascript">';
			$html[] = 'document.getElementById("'.$name.'_custom").style.display = "none";';
			$html[] = '</script>';
		}

		return implode("\n", $html);
	}
}
