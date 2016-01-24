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
 * @version     3.5.1 2015-02-27
 * @since       3.3.3
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');

/**
 * Supports a url type field.
 */
class JFormFieldModal_iclink_url extends JFormField
{
	/**
	 * The form field type.
	 */
	protected $type='modal_iclink_url';

	/**
	 * Method to get the field input markup.
	 */
	protected function getInput()
	{
		jimport('joomla.application.component.helper');
		$icagendaParams	= JComponentHelper::getParams('com_icagenda');

		$Explode		= explode('_', $this->name);
		$TypeName		= $Explode[0] . ']';

		$replace		= array("jform", "params", "[", "]");
		$name			= str_replace($replace, "", $TypeName);

		$Type			= JRequest::getVar('type');

		$Type_default	= $name.'_default';
		$Type_article	= $name.'_article';
		$Type_url		= $name.'_url';


		$editor = JFactory::getEditor();

		$html	= array();

		$html[] = '<div id="' . $Type_url . '"><fieldset class="span9 iCleft">';
		$html[] = '<input type="url" name="' . $this->name . '" value="' . $this->value . '" />';
		$html[] = '</fieldset></div>';

		// Article
		if ($Type == '1')
		{
			$html[] = '<script type="text/javascript">';
			$html[] = 'document.getElementById("' . $Type_article . '").style.display = "block";';
			$html[] = 'document.getElementById("' . $Type_url . '").style.display = "none";';
			$html[] = '</script>';
		}

		// URL
		elseif ($Type == '2')
		{
			$html[] = '<script type="text/javascript">';
			$html[] = 'document.getElementById("' . $Type_article . '").style.display = "none";';
			$html[] = 'document.getElementById("' . $Type_url . '").style.display = "block";';
			$html[] = '</script>';
		}

		// iCagenda default
		else
		{
			$html[] = '<script type="text/javascript">';
			$html[] = 'document.getElementById("' . $Type_article . '").style.display = "none";';
			$html[] = 'document.getElementById("' . $Type_url . '").style.display = "none";';
			$html[] = '</script>';
		}

		return implode("\n", $html);
	}
}
