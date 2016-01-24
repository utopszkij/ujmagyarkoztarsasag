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
 * @version     3.2.3 2013-10-17
 * @since       3.2.3
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');

class JFormFieldModal_icvalue_field extends JFormField
{
	protected $type='modal_icvalue_field';

	protected function getInput()
	{

		$Explode = explode('_', $this->name);
		$TypeName = $Explode[0].']';

		$replace = array("jform", "[params]", "[", "]");
		$name = str_replace($replace, "", $TypeName);

		$Type_default = $name.'_default';
		$Type_content = $name.'_custom';

		$html	= array();

		$html[] = '<div id="'.$Type_content.'"><fieldset class="span9 iCleft">';
		$html[] = '<input type="text" value="'.$this->value.'" name="'.$this->name.'"/>';
		$html[] = '</fieldset></div>';

		$html[] = '<script type="text/javascript">';
		$html[] = 'if (typeset == 1) {';
		$html[] = 'document.getElementById("'.$Type_content.'").style.display = "block";';
		$html[] = '}';
		$html[] = 'if (typeset == 0) {';
		$html[] = 'document.getElementById("'.$Type_content.'").style.display = "none";';
		$html[] = '}';
		$html[] = '</script>';

		return implode("\n", $html);
	}
}
