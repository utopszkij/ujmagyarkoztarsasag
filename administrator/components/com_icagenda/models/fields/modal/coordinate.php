<?php
/** 
 *	iCagenda
 *----------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright	Copyright (C) 2012 JOOMLIC - All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Jooml!C - http://www.joomlic.com
 * 
 * @update		2013-04-18
 * @version		2.1.7
 *----------------------------------------------------------------------------
*/

// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');


class JFormFieldModal_coordinate extends JFormField
{
	protected $type='modal_coordinate';
	
	protected function getInput()
	{	
		$def=JRequest::getVar('def');
		if ($def=='')$def=$this->value;
	
	
	
		$html= '
			<!--div class="clr"></div>
			<div id="map_canvas" style="width:100%; height:300px"></div><br/>
			<label>'.JText::_('COM_ICAGENDA_FORM_LBL_EVENT_GPS').'</label>&nbsp;<input name="'.$this->name.'" id="jform_coordinate" type="text" size="41" value="'.$def.'"/-->
			<div class="clr"></div>
			<!--input name="latitude" id="lat" type="text"/>
			<input name="longitude" id="lng" type="text"/-->';

		
			$html.= '<input name="'.$this->name.'" id="lat" type="text" size="41" value="'.$this->value.'"/>
		<!--script>
			document.getElementById("coords").value=document.getElementById("lat").value+", "+document.getElementById("lng").value;
		</script-->';

		return $html;
	}
}