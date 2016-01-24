<?php
/**
 * @version		$Id: inputlist.php 127 2012-10-16 14:19:02Z michel $
 * @package		Joomla.Framework
 * @subpackage	Form
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');

/**
 * Form Field class for the Joomla Framework.
 *
 * @package		Joomla.Framework
 * @subpackage	Form
 * @since		1.6
 */
class JFormFieldInputlist extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Inputlist';

	/**
	 * Flag to tell the field to always be in multiple values mode.
	 *
	 * @var		boolean
	 * @since	1.6
	 */
	protected $forceMultiple = true;

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
		// Initialize variables.
		$html = array();

		$document = JFactory::getDocument();
		
		$document->addScriptDeclaration(
		    "window.addEvent('domready', function() {
		    		$$('.removeview').each(function(el) {
		    				el.addEvent('click',function(event) {
		    					var id= this.id.replace('rm-','div-');
		    					$(id).destroy();
		    				});
					});
	 				$('addvc').addEvent('click',function() {
		 				var container = new Element('div').set('class','width-100 fltrt').set('id','div-jform_params_views' + numcvpairs).inject($('vcpairs-container'));
		 				var input = new Element('input').set('name','jform[params][views][' + numcvpairs + '][name]').set('type','text').set('class','inputlist').set('id','jform_params_views' + numcvpairs).inject(container);
		 				var label = new Element('label').set('style','min-width:20px;clear:none;display:inline');
		 				var radio = new Element('input').set('type','radio').set('style','display:inline;margin-right:15px').set('name','jform[params][views][' + numcvpairs + '][option]');
		 				var input = new Element('button').set({
			 				type: 'button',
				 			value: '".JText::_('Remove')."',	
							id: 'rm-jform_params_views' + numcvpairs,
							text: '".JText::_('Remove')."',
							events: {
						        click: function(){
			    					var id= this.id.replace('rm-','div-');
			    					$(id).destroy(); 			    					
							        }
							}						        
						}).inject(container);
						label.clone().set('text','".JText::_('Backend')."').injectBefore(input);
						radio.clone().set('value','backend').injectBefore(input);
						label.clone().set('text','".JText::_('Frontend')."').injectBefore(input);
						radio.clone().set('value','frontend').injectBefore(input);
						label.clone().set('text','".JText::_('Both')."').injectBefore(input);
						radio.clone().set('value','both').set('checked',true).injectBefore(input);												
						numcvpairs = numcvpairs +1;
					});
					
					
					
			});"		
		);
		
		// Initialize some field attributes.
		$class = $this->element['class'] ? ' class="inputlist '.(string) $this->element['class'].'"' : ' class="inputlist"';
        $html[] = '<div><button type="button"  id="addvc" name="addvc" value="'.JText::_('Add View/Controller pair').'">'.JText::_('Add View/Controller pair').'</button></div>';  

		// Build the checkbox field output.
        if(is_array($this->value) && count($this->value)) {            
		    foreach ($this->value as $i => $value) {
                if(!is_array($value)) {
                    continue;   
                }
                $name = str_replace('[]','['.(int) $i.']',$this->name);     
                if(!isset($value['option'])) $value['option'] = 'frontend';
                $checked1 = ($value['option'] == 'backend') ? 'checked="checked"' : "";
                $checked2 = ($value['option'] == 'frontend') ? 'checked="checked"': "";
                $checked3 = ($value['option'] == 'both') ? 'checked="checked"': "";
                
			    $html[] = '<div id="div-'.$this->id.$i.'" class="width-100 fltrt"><input type="text" id="'.$this->id.$i.'" name="'.$this->name.'[name]"' .
					' value="'.htmlspecialchars($value['name'], ENT_COMPAT, 'UTF-8').'"'.$class.'/>'.
			        '<label style="min-width:20px;clear:none;display:inline">'.JText::_('Backend').'</label><input style="display:inline;margin-right:15px"  type="radio" name="'.$name.'[option]" value="backend" '.$checked1.' />'.
			        '<label style="min-width:20px;clear:none;display:inline;">'.JText::_('Frontend').'</label><input style="display:inline;margin-right:15px"  type="radio" name="'.$name.'[option]" value="frontend" '.$checked2.' />'.
			    	'<label style="min-width:20px;clear:none;display:inline;">'.JText::_('Both').'</label><input style="display:inline;margin-right:15px"  type="radio" name="'.$name.'[option]" value="both" '.$checked3.' />'.
			        '<button type="button" class="removeview" id="rm-'.$this->id.$i.'" value="'.JText::_('Remove').'">'.JText::_('Remove').'</button></div>';

		    }
        }         		 
		return implode($html);
	}

}
