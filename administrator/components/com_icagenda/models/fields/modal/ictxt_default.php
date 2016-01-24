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

class JFormFieldModal_ictxt_default extends JFormField
{
	/**
	 * The form field type.
	 */
	protected $type = 'modal_ictxt_default';

	/**
	 * Method to create a blank label.
	 */
	protected function getLabel()
	{
	   return ' ';
	}

	/**
	 * Method to get the field input markup.
	 */
	protected function getInput()
	{
		jimport('joomla.application.component.helper');
		$icagendaParams = JComponentHelper::getParams('com_icagenda');

		$replace = array("jform", "[", "]", "Default");
		$name = str_replace($replace, "", $this->name);

		$tos_Type = $icagendaParams->get($name.'_Type', '');

		$Type_default = $name.'_default';
		$Type_article = $name.'_article';
		$Type_content = $name.'_custom';

		$html	= array();

		$html[] = '<div id="'.$name.'_default"><fieldset class="span9 iCleft">';
		$html[] = '<div class="alert alert-error">';
		if(version_compare(JVERSION, '3.0', 'ge')) {
			$html[] = '<i class="icon-warning-2"></i>';
		}
		$html[] = ' '.JText::sprintf( 'COM_ICAGENDA_TERMS_IMPORTANT_INFOS', $this->description ).'</div><div>'.JText::_( 'COM_ICAGENDA_SUBMIT_TOS_TYPE_DEFAULT_LBL' ).'<br /><small>'.$this->description.'</small></div><div class="alert alert-info">'.JText::_( $this->description ).'</div>';
		$html[] = '<input type="hidden" id="'.$this->id.'_id" name="'.$this->name.'" value="'.$this->value.'" />';
		$html[] = '</fieldset></div>';

		if ($tos_Type == '') {
			$html[] = '<script type="text/javascript">';
			$html[] = 'document.getElementById("'.$name.'_default").style.display = "block";';
			$html[] = '</script>';
		} else {
			$html[] = '<script type="text/javascript">';
			$html[] = 'document.getElementById("'.$name.'_default").style.display = "none";';
			$html[] = '</script>';
		}

		return implode("\n", $html);
	}
}
