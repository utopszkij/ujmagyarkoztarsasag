<?php
/** 
 *	iCagenda
 *----------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright	Copyright (C) 2012 JOOMLIC - All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Jooml!C - http://www.joomlic.com
 * 
 * @since		1.3
 *----------------------------------------------------------------------------
*/

// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');


JText::script('COM_ICAGENDA_TP_CURRENT');
JText::script('COM_ICAGENDA_TP_CLOSE');
JText::script('COM_ICAGENDA_TP_TITLE');
JText::script('COM_ICAGENDA_TP_TIME');
JText::script('COM_ICAGENDA_TP_HOUR');
JText::script('COM_ICAGENDA_TP_MINUTE');


class JFormFieldModal_period extends JFormField
{
	protected $type='modal_period';
	
	protected function getInput()
	{
		$html ='<script>
		$(function(){
			$(\'#jform_period\').datetimepicker({
				dateFormat: \'yy-mm-dd\',
				hourGrid: 4,
				minuteGrid: 10
			});
		})

		</script>
		<input type="text" id="'.$this->id.'" class="'.$this->class.'" name="'.$this->name.'" value="'.$this->value.'"/>';
		$html ='<input type="text" id="'.$this->id.'" class="'.$this->class.'" name="'.$this->name.'" value="'.$this->value.'"/>';
			
		return $html;
	}
}