<?php
/** 
 *	iCagenda
 *----------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright	Copyright (C) 2012 JOOMLIC - All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Jooml!C - http://www.joomlic.com
 * 
 * @since		1.0
 *----------------------------------------------------------------------------
*/

// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');

JHTML::_('stylesheet', 'style.css', 'administrator/components/com_icagenda/add/css/');

class JFormFieldModal_param_place extends JFormField
{
	protected $type='modal_param_place';
	
	protected function getInput()
	{
		
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('a.place, a.id, a.coordinate')
			->from('`#__icagenda_events` AS a');
		$db->setQuery($query);
		$loc = $db->loadObjectList();
	
		$html= '
			<select id="'.$this->id.'_id"'.$class.' place="'.$this->place.'">
			<option value="NULL">-</option>';
		foreach ($loc as $l){
			$html.='<option value="'.$l->id.'"';
			if ($this->value == $l->id){
				$html.='selected="selected"';
			}
			$html.='>'.$l->place.'</option>';
			$span.='<span id="coord'.$l->id.'" style="display:none;">'.$l->coordinate.'</span>';
		}
		$html.='</select>'.$span;
			
		return $html;
	}
}