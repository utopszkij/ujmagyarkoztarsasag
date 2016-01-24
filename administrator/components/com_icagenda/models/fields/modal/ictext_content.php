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

class JFormFieldModal_ictext_content extends JFormField
{
	protected $type='modal_ictext_content';

	protected function getInput()
	{

		jimport('joomla.application.component.helper');
		$icagendaParams = JComponentHelper::getParams('com_icagenda');

		$Explode = explode('_', $this->name);
		$TypeName = $Explode[0].']';

		$replace = array("jform", "[", "]");
		$name = str_replace($replace, "", $TypeName);
		$icContent = $icagendaParams->get($name.'_Content', '');

		$Type = $icagendaParams->get($name, '');

		$Type_default = $name.'_default';
		$Type_content = $name.'_custom';


		$editor = JFactory::getEditor();

		$html	= array();

		$html[] = '<div id="'.$Type_content.'"><fieldset class="span9 iCleft">';
		$html[] = $editor->display($this->name, $icContent, "100%", "300", "300", "20", 1, null, null, null, array('mode' => 'advanced'));
		$html[] = '</fieldset></div>';

		if ($Type == '2') {
			$html[] = '<script type="text/javascript">';
//			$html[] = 'document.getElementById("'.$Type_default.'").style.display = "none";';
			$html[] = 'document.getElementById("'.$Type_content.'").style.display = "block";';
			$html[] = '</script>';
		} else {
			$html[] = '<script type="text/javascript">';
			$html[] = 'document.getElementById("'.$Type_content.'").style.display = "none";';
			$html[] = '</script>';
		}

		return implode("\n", $html);
	}
}
