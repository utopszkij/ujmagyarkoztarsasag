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
 * @version     3.5.9 2015-08-01
 * @since       3.3.3
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');

class JFormFieldModal_evt extends JFormField
{
	protected $type = 'modal_evt';

	protected function getInput()
	{
		$jinput		= JFactory::getApplication()->input;
		$view		= $jinput->get('view');
		$id			= $jinput->get('id', null);
		$eventid	= $jinput->get('eventid', $this->value);

		$class		= isset($this->class) ? ' class="' . $this->class . '"' : '';

		$typeReg = $db_date = $db_period = $db_date_is_valid = '';

		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('e.title, e.state, e.id, e.weekdays, e.params')
			->from('`#__icagenda_events` AS e');

		if ($view == 'mail')
		{
			// Join Total of registrations
			$query->select('r.count AS registered');
			$sub_query = $db->getQuery(true);
			$sub_query->select('r.state, r.date AS reg_date, r.period AS reg_period, r.eventid, sum(r.people) AS count');
			$sub_query->from('`#__icagenda_registration` AS r');
			$sub_query->where('r.state = 1');
			$sub_query->where('r.email <> ""');
			$sub_query->group('r.eventid');
			$query->leftJoin('(' . (string) $sub_query . ') AS r ON (e.id = r.eventid)');
			$query->where('r.count > 0');
		}

		$query->order('e.title ASC');

		$db->setQuery($query);
		$events	= $db->loadObjectList();

		if ($eventid != 0 && $view == 'registration')
		{
			$query	= $db->getQuery(true);
			$query->select('r.date AS reg_date, r.period AS reg_period')
				->from('`#__icagenda_registration` AS r');
			$query->where('r.eventid = ' . (int) $eventid);
			$query->where('r.id = ' . (int) $id);
			$db->setQuery($query);
			$reg	= $db->loadObject();
			$db_date			= $reg->reg_date;
			$db_date_is_valid	= iCDate::isDate($db_date);
			$db_period			= $reg->reg_period;
		}

		// User state used in Newsletter
		$data				= JFactory::getApplication()->getUserState('com_icagenda.mail.data', array());
		$session_eventid	= isset($data['eventid']) ? $data['eventid'] : $eventid;
		$session_date		= isset($data['date']) ? $data['date'] : '';

		$html = '<div style="margin-bottom: 10px">';
		$html.= '<select id="' . $this->id . '_id"' . $class . ' name="' .
			$this->name . '">';

		$value = isset($this->value) ? $this->value : '';

		$html.= '<option value=""';

		if ( ! $id || ! $this->value)
		{
			$html.= ' selected="selected"';
		}

		$html.= '>' . JText::_('COM_ICAGENDA_SELECT_EVENT') . '</option>';

		foreach ($events as $e)
		{
			if ($e->state == '1')
			{
				$html.= '<option value="' . $e->id . '"';

				if ($eventid == $e->id)
				{
					$eventparam			= new JRegistry($e->params);
					$typeReg			= $eventparam->get('typeReg', 1);
					$weekdays			= $e->weekdays;

					$html.= ' selected="selected"';
				}

				if ($view == 'registration')
				{
					$html.= '>' . $e->title . ' (id:' . $e->id . ')</option>';
				}
				else
				{
					$html.= '>' . $e->title . ' (&#10003;' . $e->registered . ' - id:' . $e->id . ')</option>';
				}
			}
			elseif ($eventid == $e->id)
			{
				$html.= '<option value="' . $value . '"';
				$html.= ' selected="selected"';
				$html.= '>' . JText::_('COM_ICAGENDA_REGISTRATION_EVENT_NOT_PUBLISHED') . '</option>';
			}
		}

		$html.= '</select>';
		$html.= '</div>';

		$id_display = $id ? '&id=' . (int) $id : '';

		if ($view == 'registration')
		{
			// Info message with 'Registration Type' option setting, if the saved date is not in the list of dates for selected event.
			if ($typeReg == 1)
			{
				$reg_type = JText::_('COM_ICAGENDA_REG_BY_INDIVIDUAL_DATE');
			}
			elseif ($typeReg == 2)
			{
				$reg_type = JText::_('COM_ICAGENDA_REG_FOR_ALL_DATES');
			}
			else
			{
				$reg_type = JText::_('COM_ICAGENDA_REG_BY_DATE_OR_PERIOD');
			}

			$registration_type = '<strong>' . $reg_type . '</strong>';

			$alert_reg_type = '<div class="alert alert-info">';
			$alert_reg_type.= '<small>' . JText::sprintf('COM_ICAGENDA_REGISTRATION_TYPE_FOR_THIS_EVENT', $registration_type) . '</small>';
			$alert_reg_type.= '</div>';
			$alert_reg_type = addslashes($alert_reg_type);

			// Alert message for a date saved with a version before 3.3.3 (date not formatted as expected in sql format)
			$date_no_longer_exists = '<strong>"' . $db_date . '"</strong>';
			$alert_date_format = '<div class="ic-alert ic-alert-note"><span class="iCicon-info"></span> <strong>' . JText::_('NOTICE') . '</strong><br />' . JText::sprintf('COM_ICAGENDA_REGISTRATION_ERROR_DATE_CONTROL', $date_no_longer_exists) . '</div>';
			$alert_date_format = addslashes($alert_date_format);

			// Alert message if a date does not exist anymore for the selected event
			$alert_date_no_longer_exists = '<div class="alert alert-error"><strong>' . JText::_('COM_ICAGENDA_FORM_WARNING') . '</strong><br /><small>' . JText::sprintf('COM_ICAGENDA_REGISTRATION_DATE_NO_LONGER_EXISTS', $date_no_longer_exists) . '</small></div>';
			$alert_date_no_longer_exists = addslashes($alert_date_no_longer_exists);

			// Alert message if a date does not exist anymore for the selected event
			$alert_full_period_no_longer_exists = '<div class="alert alert-error"><strong>' . JText::_('COM_ICAGENDA_FORM_WARNING') . '</strong><br /><small>' . JText::sprintf('COM_ICAGENDA_REGISTRATION_PERIOD_NO_LONGER_EXISTS', $date_no_longer_exists) . '</small></div>';
			$alert_full_period_no_longer_exists = addslashes($alert_full_period_no_longer_exists);

			// Alert message if a date or period is set for the registration, but event registration type is now 'for all dates of the event'
			$for_all_dates = '<strong>' . JText::_('COM_ICAGENDA_ADMIN_REGISTRATION_FOR_ALL_DATES') . '</strong>';
			$alert_by_date_no_longer_possible = '<div class="alert alert-error"><strong>' . JText::_('COM_ICAGENDA_FORM_WARNING') . '</strong><br /><small>' . JText::sprintf('COM_ICAGENDA_REGISTRATION_BY_DATE_NO_LONGER_POSSIBLE', $for_all_dates, $for_all_dates) . '</small></div>';
			$alert_by_date_no_longer_possible = addslashes($alert_by_date_no_longer_possible);

			// Alert message if registration for all dates of the event, but event registration type is now 'select list of dates'
			$by_date = '<strong>' . JText::_('COM_ICAGENDA_ADMIN_REGISTRATION_BY_INDIVIDUAL_DATE') . '</strong>';
			$alert_for_all_dates_no_longer_possible = '<div class="alert alert-error"><strong>' . JText::_('COM_ICAGENDA_FORM_WARNING') . '</strong><br /><small>' . JText::sprintf('COM_ICAGENDA_REGISTRATION_FOR_ALL_DATES_NO_LONGER_POSSIBLE', $by_date) . '</small></div>';
			$alert_for_all_dates_no_longer_possible = addslashes($alert_for_all_dates_no_longer_possible);

			$html.= '<div id="date-alert">';
			$html.= '</div>';

			if ($typeReg == '1')
			{
				?>
				<script type="text/javascript">
					jQuery(document).ready(function($) {
						var value = $('#jform_date_id').val(),
							db_date = '<?php echo $db_date; ?>',
							db_period = '<?php echo $db_period; ?>',
							db_weekdays = '<?php echo $weekdays; ?>',
							db_date_is_valid = '<?php echo $db_date_is_valid; ?>',
							alert_reg_type = '<?php echo $alert_reg_type; ?>',
							alert_date_format = '<?php echo $alert_date_format; ?>',
							alert_date_no_longer_exists = '<?php echo $alert_date_no_longer_exists; ?>',
							alert_full_period_no_longer_exists = '<?php echo $alert_full_period_no_longer_exists; ?>',
							alert_for_all_dates_no_longer_possible = '<?php echo $alert_for_all_dates_no_longer_possible; ?>';

						if ( db_date == '' && db_period == '1' ) {
							// Registration for all dates, not possible if registration type is per date
							$('#date-alert').html(alert_reg_type+alert_for_all_dates_no_longer_possible);
						}
						else if ( !db_date_is_valid && db_date !== '' ) {
							// Date is not empty, but not a valid sql format (registration before release 3.3.3)
							$('#date-alert').html(alert_reg_type+alert_date_format);
						}
						else if ( db_date !== value && db_period !== '0') {
							// Date is not empty, but date is not anymore set for this event
							$('#date-alert').html(alert_date_no_longer_exists);
						}
						else if ( db_date == '' && db_period == '0' &&
							db_weekdays !== '' && db_weekdays !== '0') {
							// Date is not empty, but date is not anymore set for this event
							$('#date-alert').html(alert_full_period_no_longer_exists);
						}

						$('#jform_date_id').change(function(e) {
							$('#jform_period').val('0');
							$('#date-alert').html('');
						});
					});
				</script>
				<?php
			}
			elseif ($typeReg == '2')
			{
				?>
				<script type="text/javascript">
					jQuery(document).ready(function($) {
						var value = $('#jform_date_id').val(),
							db_date = '<?php echo $db_date; ?>',
							db_period = '<?php echo $db_period; ?>',
							alert_reg_type = '<?php echo $alert_reg_type; ?>',
							alert_by_date_no_longer_possible = '<?php echo $alert_by_date_no_longer_possible; ?>';

						$('#date-alert').html(alert_reg_type);

						if ( db_period !== '1' ) {
							// Date is empty, not possible if registration type is per date
							$('#date-alert').html(alert_reg_type+alert_by_date_no_longer_possible);
						}

						$('#jform_date_id').change(function(e) {
//							if ( value == 'update' ) {
								$('#jform_period').val('1');
								$('#date-alert').html('');
//							}
						});
					});
				</script>
			<?php
			}
		}
		?>
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			var view = '<?php echo $view; ?>',
				regid = '<?php echo $id; ?>',
				eventid = '<?php echo $session_eventid; ?>',
				date = '<?php echo $session_date; ?>',
				list_target_id = 'jform_date_id',
				list_select_id = '<?php echo $this->id; ?>_id',
				initial_target_html = '<option value=""><?php echo JText::_("COM_ICAGENDA_SELECT_NO_EVENT_SELECTED"); ?>...</option>',
				loading = '<?php echo JText::_("IC_LOADING"); ?>';

			if (eventid) {
				$('#'+list_target_id).removeAttr('readonly');
				$('#'+list_target_id).val(date);

				$.ajax({url: 'index.php?option=com_icagenda&task='+view+'.dates&eventid='+eventid+'&regid='+regid,
					success: function(output) {
							$('#'+list_target_id).html(output);
					},
					error: function (xhr, ajaxOptions, thrownError) {
							alert(xhr.status + " "+ thrownError);
					}
				});

				$('#'+list_select_id).change(function(e) {
					$('#'+list_target_id).removeAttr('readonly');

					var selectvalue = $(this).val();

					$('#'+list_target_id).html('<option value="">'+loading+'</option>');

					if (selectvalue == "") {
						$('#'+list_target_id).attr('readonly', 'true');
						$('#'+list_target_id).html(initial_target_html);
					} else {
						$.ajax({url: 'index.php?option=com_icagenda&task='+view+'.dates&eventid='+selectvalue+'&regid='+regid,
							success: function(output) {
									$('#'+list_target_id).html(output);
							},
							error: function (xhr, ajaxOptions, thrownError) {
									alert(xhr.status + " "+ thrownError);
							}
						});
					}
				});
			} else {
				$('#'+list_target_id).attr('readonly', 'true');
				$('#'+list_target_id).html(initial_target_html);

				$('#'+list_select_id).change(function(e) {
					$('#'+list_target_id).removeAttr('readonly');

					var selectvalue = $(this).val();

					$('#'+list_target_id).html('<option value="">'+loading+'</option>');

					if (selectvalue == "") {
						$('#'+list_target_id).attr('readonly', 'true');
						$('#'+list_target_id).html(initial_target_html);
					} else {
						$.ajax({url: 'index.php?option=com_icagenda&task='+view+'.dates&eventid='+selectvalue+'&regid='+regid,
							success: function(output) {
									$('#'+list_target_id).html(output);
							},
							error: function (xhr, ajaxOptions, thrownError) {
									alert(xhr.status + " "+ thrownError);
							}
						});
					}
				});
			}
		});
		</script>
		<?php

		return $html;
	}
}
