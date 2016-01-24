<?php
/**
 * Kunena Component
 * @package Kunena.Framework
 * @subpackage HTML
 *
 * @copyright (C) 2008 - 2014 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 *
 * Taken from Joomla Platform 11.1
 * @copyright   Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 **/
defined ( '_JEXEC' ) or die ();

/**
 * Utility class for creating HTML Grids
 */
abstract class JHtmlKunenaGrid
{
	/**
	 * Display a boolean setting widget.
	 *
	 * @param   integer  $i			The row index.
	 * @param   integer  $value		The value of the boolean field.
	 * @param   string   $taskOn	Task to turn the boolean setting on.
	 * @param   string   $taskOff	Task to turn the boolean setting off.
	 *
	 * @return  string   The boolean setting widget.
	 */
	static function boolean($i, $value, $taskOn = null, $taskOff = null) {
		// Load the behavior.
		self::behavior();

		// Build the title.
		$title = ($value) ? JText::_('COM_KUNENA_YES') : JText::_('COM_KUNENA_NO');
		$title .= '::'.JText::_('COM_KUNENA_LIB_CLICK_TO_TOGGLE_STATE');

		// Build the <a> tag.
		$bool	= ($value) ? 'true' : 'false';
		$task	= ($value) ? $taskOff : $taskOn;
		$toggle	= (!$task) ? false : true;

		if ($toggle) {
			$html = '<a class="grid_'.$bool.' hasTip" title="'.$title.'" rel="{id:\'cb'.$i.'\', task:\''.$task.'\'}" href="#toggle"></a>';
		}
		else {
			$html = '<a class="grid_'.$bool.'" rel="{id:\'cb'.$i.'\', task:\''.$task.'\'}"></a>';
		}

		return $html;
	}

	/**
	 * @param   string   $title	The link title
	 * @param   string   $order	The order field for the column
	 * @param   string   $direction	The current direction
	 * @param   string|int   $selected	The selected ordering
	 * @param   string|null   $task	An optional task override
	 * @param   string   $new_direction	An optional direction for the new column
	 * @param   string|null   $form
	 *
	 * @return  string
	 */
	public static function sort($title, $order, $direction = 'asc', $selected = 0, $task=NULL, $new_direction='asc', $form=null) {
		$direction	= strtolower($direction);
		if ($order != $selected) {
			$direction = $new_direction;
		} else {
			$direction	= ($direction == 'desc') ? 'asc' : 'desc';
		}

		$html = '<a href="javascript:kunenatableOrdering(\''.$order.'\',\''.$direction.'\',\''.$task.'\',\''.$form.'\');" title="'.JText::_('COM_KUNENA_LIB_CLICK_TO_SORT_THIS_COLUMN').'">';
		$html .= JText::_($title);

		if ($order == $selected) {
			$html .= '<span class="grid_'.$direction.'"></span>';
		}

		$html .= '</a>';

		return $html;
	}

	/**
	 * @param   integer $rowNum	The row index
	 * @param   integer $recId	The record id
	 * @param   boolean $checkedOut
	 * @param   string $name	The name of the form element
	 *
	 * @return  string
	 */
	public static function id($rowNum, $recId, $checkedOut=false, $name='cid') {
		if ($checkedOut) {
			return '';
		}
		else {
			return '<input type="checkbox" id="cb'.$rowNum.'" name="'.$name.'[]" value="'.$recId.'" onclick="Joomla.isChecked(this.checked);" title="'.JText::sprintf('COM_KUNENA_LIB_CHECKBOX_ROW_N', ($rowNum + 1)).'" />';
		}
	}

	public static function checkedOut($row, $i, $identifier = 'id') {
		$userid = JFactory::getUser()->get('id');

		$result = false;
		if ($row instanceof JTable) {
			$result = $row->isCheckedOut($userid);
		}
		else {
			$result = JTable::isCheckedOut($userid, $row->checked_out);
		}

		$checked = '';
		if ($result) {
			$checked = self::_checkedOut($row);
		}
		else {
			if ($identifier == 'id') {
				$checked = self::id($i, $row->$identifier);
			}
			else {
				$checked = self::id($i, $row->$identifier, $result, $identifier);
			}
		}

		return $checked;
	}

	/**
	 * @param   integer  $i
	 * @param   mixed    $value	Either the scalar value, or an object (for backward compatibility, deprecated)
	 * @param   string   $prefix	An optional prefix for the task
	 *
	 * @return  string
	 */
	public static function published($i, $value, $prefix='') {
		if (is_object($value)) {
			$value = $value->published;
		}

		$task	= $value ? 'unpublish' : 'publish';
		$alt	= $value ? JText::_('COM_KUNENA_PUBLISHED') : JText::_('COM_KUNENA_UNPUBLISHED');
		$action = $value ? JText::_('COM_KUNENA_LIB_UNPUBLISH_ITEM') : JText::_('COM_KUNENA_LIB_PUBLISH_ITEM');

		$href = '<a class="grid_'.$task.' hasTip" href="#" onclick="return listItemTask(\'cb'. $i .'\',\''. $prefix.$task .'\')" alt="'.$alt.'" title="'. $alt .'::'. $action .'"></a>';

		return $href;
	}

	/**
	 * @param   integer  $i
	 * @param   string   $img	Image for a positive or on value
	 * @param   string   $alt
	 * @param   string   $task
	 * @param   string   $prefix	An optional prefix for the task
	 *
	 * @return  string
	 */
	public static function task($i, $img, $alt, $task, $prefix='') {
		$href = '<a href="javascript:void(0);" onclick="return listItemTask(\'cb' . $i .'\',\''. $prefix.$task .'\')"><img src="'. KunenaFactory::getTemplate()->getImagePath($img) .'" alt="'. $alt .'" title="'. $alt .'" /></a>';

		return $href;
	}

	/*
	public static function state(
		$filter_state = '*',
		$published = 'Published',
		$unpublished = 'Unpublished',
		$archived = null,
		$trashed = null
	) {
		$state = array(
			'' => '- ' . JText::_('JLIB_HTML_SELECT_STATE') . ' -',
			'P' => JText::_($published),
			'U' => JText::_($unpublished)
		);

		if ($archived) {
			$state['A'] = JText::_($archived);
		}

		if ($trashed) {
			$state['T'] = JText::_($trashed);
		}

		return JHtml::_(
			'select.genericlist',
			$state,
			'filter_state',
			array(
				'list.attr' => 'class="inputbox" size="1" onchange="Joomla.submitform();"',
				'list.select' => $filter_state,
				'option.key' => null
			)
		);
	}
	*/

	public static function order($rows, $image = 'filesave.png', $task = 'saveorder') {
		$href = '<a href="javascript:saveorder('.(count($rows)-1).', \''.$task.'\')" class="saveorder" title="'.JText::_('COM_KUNENA_LIB_SAVE_ORDER').'"></a>';

		return $href;
	}

	public static function orderUp($i, $task, $enabled = true, $alt = 'COM_KUNENA_LIB_MOVE_UP') {
		$alt = JText::_($alt);

		if ($enabled) {
			$html = '<a class="move_up" href="#order" rel="{id:\'cb'.$i.'\', task:\''.$task.'\'}" title="'.$alt.'"></a>';
		} else {
			$html = '<span class="move_up"></span>';
		}
		return $html;
	}

	public static function orderDown($i, $task, $enabled = true, $alt = 'COM_KUNENA_LIB_MOVE_DOWN') {
		$alt = JText::_($alt);

		if ($enabled) {
			$html = '<a class="move_down" href="#order" rel="{id:\'cb'.$i.'\', task:\''.$task.'\'}" title="'.$alt.'"></a>';
		} else {
			$html = '<span class="move_down"></span>';
		}
		return $html;
	}

	protected static function _checkedOut(&$row, $overlib = 1) {
		$hover = '';

		if ($overlib) {
			$text = addslashes(htmlspecialchars($row->editor, ENT_COMPAT, 'UTF-8'));

			$date	= JHtml::_('date',$row->checked_out_time, JText::_('DATE_FORMAT_LC1'));
			$time	= JHtml::_('date',$row->checked_out_time, 'H:i');

			$hover = '<span class="editlinktip hasTip" title="'. JText::_('COM_KUNENA_LIB_CHECKED_OUT') .'::'. $text .'<br />'. $date .'<br />'. $time .'">';
		}

		$checked = $hover .JHtml::_('image','admin/checked_out.png', NULL, NULL, true).'</span>';

		return $checked;
	}

	static function behavior() {
		static $loaded = false;

		if (!$loaded)
		{
			JHtml::_('behavior.tooltip');

			// Build the behavior script.
			$js = '
		window.addEvent(\'domready\', function(){
			actions = $$(\'a.move_up\');
			actions.combine($$(\'a.move_down\'));
			actions.combine($$(\'a.grid_true\'));
			actions.combine($$(\'a.grid_false\'));
			actions.combine($$(\'a.grid_trash\'));
			actions.combine($$(\'a.grid_action\'));
			actions.each(function(a){
				a.addEvent(\'click\', function(){
					args = JSON.decode(this.rel);
					listItemTask(args.id, args.task);
				});
			});
			$$(\'input.check-all-toggle\').each(function(el){
				el.addEvent(\'click\', function(){
					if (el.checked) {
						document.id(this.form).getElements(\'input[type=checkbox]\').each(function(i){
							i.checked = true;
						})
					}
					else {
						document.id(this.form).getElements(\'input[type=checkbox]\').each(function(i){
							i.checked = false;
						})
					}
				});
			});
		});';

			// Add the behavior to the document head.
			$document = JFactory::getDocument();
			$document->addScriptDeclaration($js);

			$loaded = true;
		}
	}
}
