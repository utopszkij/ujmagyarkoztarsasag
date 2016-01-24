<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     iCagenda
 * @subpackage  utilities
 * @copyright   Copyright (c)2012-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     3.5.10 2015-08-14
 * @since       3.4.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * class icagendaForm
 */
class icagendaForm
{
	/**
	 * Function to return script validation for a form used in iCagenda
	 *
	 * @access	public static
	 * @param	$parent_form form type ID ('1' registration, '2' event edit or new)
	 * 			// $form_location ('site' or 'admin')
	 * @return	script
	 *
	 * @since   3.4.0
	 */
	static public function submit($parent_form = null)
	{
		if (!$parent_form) return false;
		if ($parent_form == 1) $parent_name = 'registration';
		if ($parent_form == 2) $parent_name = 'event';

		$app	= JFactory::getApplication();
		$lang	= JFactory::getLanguage();

		$id_suffix = ($lang->getTag() == 'fa-IR') ? '_jalali' : '';

		if ($app->isAdmin())
		{
			$params		= JComponentHelper::getParams('com_icagenda');
		}
		elseif ($app->isSite())
		{
			$params		= $app->getParams();
		}

		$submit_periodDisplay = $params->get('submit_periodDisplay', 1);
		$submit_datesDisplay = $params->get('submit_datesDisplay', 1);

		JText::script('COM_ICAGENDA_REGISTRATION_NO_EVENT_SELECTED_ALERT');
		JText::script('COM_ICAGENDA_FORM_NC');
		JText::script('COM_ICAGENDA_FORM_NO_DATES_ALERT');
		JText::script('COM_ICAGENDA_TERMS_AND_CONDITIONS_NOT_CHECKED_REGISTRATION');
		JText::script('COM_ICAGENDA_ALERT_TEXT_EXCEEDS_CHARACTER_LIMIT');

		$prefix_id = $app->isAdmin() ? 'jform_' : '';

		// Copyleft function strpos
		// +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
		// +   improved by: Onno Marsman
		// +   bugfixed by: Daniel Esteban
		// +   improved by: Brett Zamir (http://brett-zamir.me)
		// +     edited by: Cyril Rezé (http://www.joomlic.com)
		// *     example 1: strpos('Kevin van Zonneveld', 'e', 5);
		// *     returns 1: 14

		$ic_script = array();

		if ( $app->isSite() )
		{
			$ic_script[] = '	function iCheckForm() {';
			$ic_script[] = '		var agree = document.getElementById("formAgree");';

			if ($parent_form == 2)
			{
				$ic_script[] = '		if (agree.checked) {';
				$ic_script[] = '			document.getElementById("tos").value = "checked";';
				$ic_script[] = '		}';
			}
		}
		elseif ( $app->isAdmin() )
		{
			$ic_script[] = 'jQuery(document).ready(function() {';
			$ic_script[] = '	Joomla.submitbutton = function(task) {';
		}

		if ($parent_form == 1 && $app->isAdmin())
		{
			$ic_script[] = '		var eventid = document.getElementById("' . $prefix_id . 'eventid_id");';
			$ic_script[] = '		if ((eventid.value == "") && (task != "' . $parent_name . '.cancel")) {';
			$ic_script[] = '			alert(Joomla.JText._("COM_ICAGENDA_REGISTRATION_NO_EVENT_SELECTED_ALERT"));';
			$ic_script[] = '			return false;';
			$ic_script[] = '		}';
		}

		if ($parent_form == 2)
		{
			$ic_script[] = '		function strpos (haystack, needle, offset) {';
			$ic_script[] = '			var i = (haystack + "").indexOf(needle, (offset || 0));';
			$ic_script[] = '			return i === -1 ? false : i;';
			$ic_script[] = '		}';

			$ic_script[] = '		var nodate = "0";';
			$ic_script[] = '		var noserialdate = \'a:1:{i:0;s:19:"0000-00-00 00:00:00";}\';';
			$ic_script[] = '		var noserialdate2 = \'a:1:{i:0;s:16:"0000-00-00 00:00";}\';';
			$ic_script[] = '		var emptydatetime = "0000-00-00 00:00:00";';

			if ($submit_periodDisplay && $app->isSite())
			{
				$ic_script[] = '		var startDate = document.getElementById("startdate' . $id_suffix . '");';
				$ic_script[] = '		var endDate = document.getElementById("enddate' . $id_suffix . '");';
				$ic_script[] = '		var isValidStartDate = strpos(startDate.value, nodate, 0);';
				$ic_script[] = '		var isValidEndDate = strpos(endDate.value, nodate, 0);';
			}
			elseif ($app->isAdmin())
			{
				$ic_script[] = '		var startDate = document.getElementById("startdate' . $id_suffix . '");';
				$ic_script[] = '		var endDate = document.getElementById("enddate' . $id_suffix . '");';
				$ic_script[] = '		var isValidStartDate = strpos(startDate.value, nodate, 0);';
				$ic_script[] = '		var isValidEndDate = strpos(endDate.value, nodate, 0);';
			}
			if ($submit_datesDisplay && $app->isSite())
			{
				$ic_script[] = '		var Dates = document.getElementById("' . $prefix_id . 'dates_id");';
				$ic_script[] = '		var isValidSingleDate = strpos(Dates.value, nodate, 2);';
			}
			elseif ($app->isAdmin())
			{
				$ic_script[] = '		var Dates = document.getElementById("' . $prefix_id . 'dates_id");';
				$ic_script[] = '		var isValidSingleDate = strpos(Dates.value, nodate, 2);';
			}

			$ic_script[] = '		if (';

			if ($submit_datesDisplay && $app->isSite())
			{
				$ic_script[] = '			( !isValidSingleDate';
				$ic_script[] = '			|| (Dates.value == noserialdate && isValidSingleDate)';
				$ic_script[] = '			|| (Dates.value == noserialdate2 && isValidSingleDate)';
				$ic_script[] = '			|| Dates.value == "" )';
			}
			elseif ($app->isAdmin())
			{
				$ic_script[] = '			( !isValidSingleDate';
				$ic_script[] = '			|| (Dates.value == noserialdate && isValidSingleDate)';
				$ic_script[] = '			|| (Dates.value == noserialdate2 && isValidSingleDate)';
				$ic_script[] = '			|| Dates.value == "" )';
			}

			if ($submit_periodDisplay && $submit_datesDisplay && $app->isSite())
			{
				$ic_script[] = '			&& ';
			}

			if ($submit_periodDisplay && $app->isSite())
			{
				$ic_script[] = '			( (!isValidStartDate || (startDate.value == emptydatetime)) )';
			}
			elseif ($app->isAdmin())
			{
				$ic_script[] = '			&& ( (!isValidStartDate || (startDate.value == emptydatetime)) )';
			}

			if ($app->isAdmin()) $ic_script[] = '			&& ( task != "' . $parent_name . '.cancel" ) ';

			$ic_script[] = '		) {';
			$ic_script[] = '			alert(Joomla.JText._("COM_ICAGENDA_FORM_NO_DATES_ALERT"));';
			$ic_script[] = '			document.getElementById("message_error").innerHTML = "'
											. JText::_("COM_ICAGENDA_FORM_NO_DATES_ALERT") . '";';
			$ic_script[] = '			document.getElementById("form_errors").style.display = "block";';

			if ($submit_periodDisplay && $app->isSite())
			{
				$ic_script[] = '			document.getElementById("startdate' . $id_suffix . '").value = emptydatetime;';
				$ic_script[] = '			document.getElementById("enddate' . $id_suffix . '").value = emptydatetime;';
				$ic_script[] = '			document.getElementById("startdate' . $id_suffix . '").addClass("ic-date-invalid");';
				$ic_script[] = '			document.getElementById("enddate' . $id_suffix . '").addClass("ic-date-invalid");';
			}
			elseif ($app->isAdmin())
			{
				$ic_script[] = '			document.getElementById("startdate' . $id_suffix . '").value = emptydatetime;';
				$ic_script[] = '			document.getElementById("enddate' . $id_suffix . '").value = emptydatetime;';
				$ic_script[] = '			document.getElementById("startdate' . $id_suffix . '").addClass("ic-date-invalid");';
				$ic_script[] = '			document.getElementById("enddate' . $id_suffix . '").addClass("ic-date-invalid");';
			}

			if ($submit_datesDisplay && $app->isSite())
			{
				$ic_script[] = '			document.getElementById("dTable' . $id_suffix . '").addClass("ic-date-invalid");';
			}
			elseif ($app->isAdmin())
			{
				$ic_script[] = '			document.getElementById("dTable' . $id_suffix . '").addClass("ic-date-invalid");';
			}

			$ic_script[] = '			scroll_to = document.getElementById("ic-dates-fieldset");';
			$ic_script[] = '			scroll_to.scrollIntoView();';
			$ic_script[] = '			return false;';
			$ic_script[] = '		}';
			$ic_script[] = '		else {';
			$ic_script[] = '			document.getElementById("form_errors").style.display = "none";';

			if ($submit_periodDisplay && $app->isSite())
			{
				$ic_script[] = '			document.getElementById("startdate' . $id_suffix . '").removeClass("ic-date-invalid");';
				$ic_script[] = '			document.getElementById("enddate' . $id_suffix . '").removeClass("ic-date-invalid");';
			}
			elseif ($app->isAdmin())
			{
				$ic_script[] = '			document.getElementById("startdate' . $id_suffix . '").removeClass("ic-date-invalid");';
				$ic_script[] = '			document.getElementById("enddate' . $id_suffix . '").removeClass("ic-date-invalid");';
			}

			if ($submit_datesDisplay && $app->isSite())
			{
				$ic_script[] = '			document.getElementById("dTable' . $id_suffix . '").removeClass("ic-date-invalid");';
			}
			elseif ($app->isAdmin())
			{
				$ic_script[] = '			document.getElementById("dTable' . $id_suffix . '").removeClass("ic-date-invalid");';
			}

			$ic_script[] = '		}';

			if ($submit_periodDisplay && $app->isSite())
			{
				$ic_script[] = '		if (isValidStartDate && !isValidEndDate) {';
				$ic_script[] = '			document.getElementById("enddate' . $id_suffix . '").value = startDate.value;';
				$ic_script[] = '		}';
			}
			elseif ($app->isAdmin())
			{
				$ic_script[] = '		if (isValidStartDate && !isValidEndDate) {';
				$ic_script[] = '			document.getElementById("enddate' . $id_suffix . '").value = startDate.value;';
				$ic_script[] = '		}';
			}
		}

		$customfields = icagendaCustomfields::getCustomfields($parent_form);

		if ($customfields && $app->isAdmin())
		{
			$options_required = array('list', 'radio');

			foreach ($customfields as $icf)
			{
				// If type is list or radio, should have options. All, field required.
				if (((in_array($icf->type, $options_required) && $icf->options)
					|| ! in_array($icf->type, $options_required))
					&& $icf->required)
				{
					$ic_script[] = '		var ' . $icf->slug . '_slug = document.getElementById("' . $icf->slug . '_slug");';
					$ic_script[] = '		if ( ( ' . $icf->slug . '_slug.value == "" ) ';

					if ($app->isAdmin()) $ic_script[] = '			&& ( task != "' . $parent_name . '.cancel" ) ';

					$ic_script[] = '		) {';
					$ic_script[] = '			alert(Joomla.JText._("COM_ICAGENDA_FORM_NC"));';
					$ic_script[] = '			document.getElementById("message_error").innerHTML = "'
												. JText::sprintf("COM_ICAGENDA_FORM_VALIDATE_FIELD_REQUIRED_NAME", $icf->title) . '";';
					$ic_script[] = '			document.getElementById("form_errors").style.display = "block";';
					$ic_script[] = '			document.getElementById("' . $icf->alias . '_alias").addClass("ic-field-invalid");';
					$ic_script[] = '			document.getElementById("' . $icf->slug . '_slug").addClass("ic-field-invalid");';
					$ic_script[] = '			scroll_to = document.getElementById("' . $icf->alias . '_alias");';
					$ic_script[] = '			scroll_to.scrollIntoView();';
					$ic_script[] = '			return false;';
					$ic_script[] = '		}';
					$ic_script[] = '		else {';
					$ic_script[] = '			document.getElementById("form_errors").style.display = "none";';
					$ic_script[] = '			document.getElementById("' . $icf->alias . '_alias").removeClass("ic-field-invalid");';
					$ic_script[] = '			document.getElementById("' . $icf->slug . '_slug").removeClass("ic-field-invalid");';
					$ic_script[] = '		}';
				}
			}
		}

		if ($app->isAdmin())
		{
			$ic_script[] = '		if (task == "' . $parent_name . '.cancel"';
			$ic_script[] = '			|| document.formvalidator.isValid(document.id("' . $parent_name . '-form")))';
			$ic_script[] = '		{';
			$ic_script[] = '			// do field validation';
			$ic_script[] = '			Joomla.submitform(task, document.getElementById("' . $parent_name . '-form"));';
			$ic_script[] = '		}';
			$ic_script[] = '		else {';
			$ic_script[] = '			alert("' . JText::_("JGLOBAL_VALIDATION_FORM_FAILED") . '");';
			$ic_script[] = '		}';
		}

		if ($app->isSite())
		{
			$ic_script[] = '		if (!agree.checked) {';
			if ($parent_form == 1) $ic_script[] = '			alert(Joomla.JText._("COM_ICAGENDA_TERMS_AND_CONDITIONS_NOT_CHECKED_REGISTRATION"));';
			if ($parent_form == 2) $ic_script[] = '			alert(Joomla.JText._("COM_ICAGENDA_TERMS_OF_SERVICE_NOT_CHECKED_SUBMIT_EVENT"));';
			$ic_script[] = '			scroll_to = document.getElementById("content");';
			$ic_script[] = '			scroll_to.scrollIntoView();';
			$ic_script[] = '			return false;';
			$ic_script[] = '		}';
		}

		$ic_script[] = '	}';

		if ($app->isAdmin())
		{
			$ic_script[] = '});';
		}

		return implode("\n", $ic_script);
	}

	/**
	 * Function to set timepicker.js and date function strings of translation
	 *
	 * @access	public static
	 *
	 * @since   3.4.1
	 */
	static public function loadDateTimePickerJSLanguage()
	{
		// icdates.js Strings of Translation
		JText::script('COM_ICAGENDA_DELETE_DATE');

		// timepicker.js Strings of Translation
		JText::script('JANUARY');
		JText::script('FEBRUARY');
		JText::script('MARCH');
		JText::script('APRIL');
		JText::script('MAY');
		JText::script('JUNE');
		JText::script('JULY');
		JText::script('AUGUST');
		JText::script('SEPTEMBER');
		JText::script('OCTOBER');
		JText::script('NOVEMBER');
		JText::script('DECEMBER');

		JText::script('SA');
		JText::script('SU');
		JText::script('MO');
		JText::script('TU');
		JText::script('WE');
		JText::script('TH');
		JText::script('FR');

		JText::script('COM_ICAGENDA_TP_CURRENT');
		JText::script('COM_ICAGENDA_TP_CLOSE');
		JText::script('COM_ICAGENDA_TP_TITLE');
		JText::script('COM_ICAGENDA_TP_TIME');
		JText::script('COM_ICAGENDA_TP_HOUR');
		JText::script('COM_ICAGENDA_TP_MINUTE');
	}
}
