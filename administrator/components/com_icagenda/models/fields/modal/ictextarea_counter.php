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
 * @version     3.5.0 2015-02-14
 * @since       3.4.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');

/**
 * Textarea with a counter. Short Description and Meta Description
 *
 * @package		iCagenda
 * @subpackage	com_icagenda
 * @since		3.4.0
 */
class JFormFieldModal_ictextarea_counter extends JFormField
{
	protected $type = 'modal_ictextarea_counter';

	protected function getInput()
	{
		$app		= JFactory::getApplication();
		$replace	= array("jform", "[", "]");
		$name		= str_replace($replace, "", $this->name);
		$nb_chars	= strlen(trim(utf8_decode($this->value)));
		$class		= !empty($this->class) ? ' class="' . $this->class . '"' : '';

		if ($app->isAdmin())
		{
			$params	= JComponentHelper::getParams('com_icagenda');
			$iCparams	= JComponentHelper::getParams('com_icagenda');
		}
		else
		{
			$params	= $app->getParams();
			$iCparams	= JComponentHelper::getParams('com_icagenda');
		}

		$session = JFactory::getSession();
		$ic_submit_shortdesc = $session->get('ic_submit_shortdesc', '');
		$ic_submit_metadesc = $session->get('ic_submit_metadesc', '');

		$event_shortdesc = $ic_submit_shortdesc ? $ic_submit_shortdesc : $this->value;
		$event_metadesc = $ic_submit_metadesc ? $ic_submit_metadesc : $this->value;

		if ($name == 'shortdesc')
		{
			$ic_max_component	= $iCparams->get('char_limit_short_description', '100');
			$ic_max				= $params->get('char_limit_short_description', '100');
			$ic_max				= ($ic_max_component >= $ic_max) ? $ic_max : $ic_max_component;
		}
		elseif ($name == 'metadesc')
		{
			$ic_max_component	= $iCparams->get('char_limit_meta_description', '160');
			$ic_max				= $params->get('char_limit_meta_description', '160');
			$ic_max				= ($ic_max_component >= $ic_max) ? $ic_max : $ic_max_component;
		}
		else
		{
			$ic_max = $params->get('ShortDescLimit', '100');
		}

		// Alert if text stored in the database exceeds the character limit currently set.
		$display_alert	= ($nb_chars > $ic_max) ? true : false;

		$count_value = $nb_chars ? ($ic_max-$nb_chars) : $ic_max;
		$ic_size = (strlen($ic_max))-1;
		$ic_size = $ic_size ? $ic_size : '1';

		$counter_input = '<input id="' . $name . '-counter"';
//		$counter_input.= ' onblur="iCtextCounter(this.form.' . $this->name . ', this, ' . $ic_max . ');"';
		$counter_input.= ' class="valid"';
//		$counter_input.= ' onfocus="this.blur();"';
//		$counter_input.= ' tabindex="999" maxlength="' . $ic_size . '" size="' . $ic_size . '"';
		$counter_input.= ' size="' . $ic_size . '"';
		$counter_input.= ' value="' . $count_value . '"';
		$counter_input.= ' name="counter_' . $name . '">';

		$html = '<div>';

		if ($display_alert)
		{
			$html.= '<div class="alert alert-danger"><h3>Warning</h3><strong>'
					. JText::sprintf('COM_ICAGENDA_ALERT_S_TEXT_S_EXCEEDS_CHARACTER_LIMIT', $this->title) . '</strong><br />'
					. JText::_('COM_ICAGENDA_ALERT_EDIT_TEXT_TO_FIT_CHAR_LIMIT') . '<br /><br /><u>'
					. JText::sprintf('COM_ICAGENDA_ALERT_S_TEXT_S_CURRENTLY_STORED_IN_DATABASE', $this->title) . '</u> :<br/><i>'
					. $this->value . '</i></div>';
		}
		$html.= '<textarea';
		$html.= ' onKeyPress="iCtextCounter(this, this.form.counter_' . $name.', ' . $ic_max . ');"';
		$html.= ' onKeyUp="iCtextCounter(' . $name . ', counter_' . $name . ', ' . $ic_max . ');"';
		$html.= ' onkeydown="iCtextCounter(' . $name . ', counter_' . $name . ', ' . $ic_max . ');"';
		$html.= ' onmouseout="iCtextCounter(' . $name . ', counter_' . $name . ', ' . $ic_max . ');"';
//		$html.= ' onpaste="' . $name . 'useractions();"';
		$html.= $class . ' name="' . $this->name . '" id="' . $name . '">';

		if ($name == 'shortdesc')
		{
			$html.= $event_shortdesc;

			// clear the data so we don't process it again
			$session->clear('ic_submit_shortdesc');
		}
		elseif ($name == 'metadesc')
		{
			$html.= $event_metadesc;

			// clear the data so we don't process it again
			$session->clear('ic_submit_metadesc');
		}
		else
		{
			$html.= $this->value;
		}

		$html.= '</textarea>';

		$html.= '</div>';
		$html.= '<div id="'.$name.'-counter-container" class="ic-counter-container">';
		$html.= '<div class="ic-counter">';
		$html.= JText::sprintf('COM_ICAGENDA_MAXIMUM_N_CHARACTERS', $ic_max);
		$html.= '</div> ';
		$html.= '<div class="ic-counter">';
		$html.= JText::sprintf('COM_ICAGENDA_N_REMAINING', $counter_input);
		$html.= '</div>';
		$html.= '</div>';
		$html.= '<div>&nbsp;</div>';

//		$html.= '<textarea';
//		$html.= ' onMouseOut="CheckFieldLength(this.' . $name . ', \'' . $name . '_charcount\', \'' . $name . '_remaining\', 140);"';
//		$html.= ' onKeyDown="CheckFieldLength(this.' . $name . ', \'' . $name . '_charcount\', \'' . $name . '_remaining\', 140);"';
//		$html.= ' onkeyup="CheckFieldLength(this.' . $name . ', \'' . $name . '_charcount\', \'' . $name . '_remaining\', 140);"';
//		$html.= $class . ' name="' . $this->name . '" id ="' . $name . '">';
//		$html.= '</textarea>';
//		$html.= '<h2><span id="' . $name . '_charcount">0</span> characters entered   | <span id="' . $name . '_remaining">140</span> characters remaining</h2>';

		return $html;
	}
}
