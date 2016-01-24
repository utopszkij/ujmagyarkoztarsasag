<?php
/**
 * @version		$Id: jaccextensions.php 96 2011-08-11 06:59:32Z michel $
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('checkboxes');

/**
 * Form Field class for the Joomla Framework.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_jacc
 * @since		1.6
 */
class JFormFieldJaccExtensions extends JFormField
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	public $type = 'JaccExtensions';

	/**
	 * Flag to tell the field to always be in multiple values mode.
	 *
	 * @var		boolean
	 * @since	1.6
	 */
	protected $forceMultiple = true;

	protected function getInput()
	{
		// Initialize variables.
		$html = array();

		// Initialize some field attributes.
		$class = $this->element['class'] ? ' class="checkboxes '.(string) $this->element['class'].'"' : ' class="checkboxes"';

		// Start the checkbox field output.
		$html[] = '<fieldset style="width:100%" id="'.$this->id.'"'.$class.'>';

		// Get the field options.
		$options = $this->getOptions();

		// Build the checkbox field output.

		foreach ($options as $i => $option) {

			// Initialize some option attributes.
			$checked	= (in_array((string)$option->value,(array)$this->value) ? ' checked="checked"' : '');
			$class		= !empty($option->class) ? ' class="'.$option->class.'"' : '';
			$disabled	= !empty($option->disable) ? ' disabled="disabled"' : '';

			// Initialize some JavaScript option attributes.
			$onclick	= !empty($option->onclick) ? ' onclick="'.$option->onclick.'"' : '';
			if(isset($option->heading) && $option->heading) {
			    if($i > 0) {
			        $html[] = '</ul></div>';   
			    }
			    $html[] = '<div style="float:left;width:33%;"> <h3 '.$class.'>'.JText::_($option->text).'</h3>';
			    $html[] = '<ul>';    
			        
			} else {
			    $html[] = '<li>';
			    $html[] = '<input type="checkbox" id="'.$this->id.$i.'" name="'.$this->name.'"' .
					' value="'.htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8').'"'
					.$checked.$class.$onclick.$disabled.'/>';

			    $html[] = '<label for="'.$this->id.$i.'"'.$class.'>'.JText::_($option->text).'</label>';
			    $html[] = '</li>';
			}
		}
		$html[] = '</ul></div>';

		// End the checkbox field output.
		$html[] = '</fieldset>';

		return implode($html);
	}
	
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getOptions()
	{
		$app = JFactory::getApplication();
		$db = JFactory::getDbo();

		$extensions = array();
		$query = "SELECT name, version, '' as prefix, CONCAT( name, '-', version ) as text, CONCAT( LOWER(name), '-', version,'.zip' ) as file FROM #__jacc WHERE published > 0";
		
		$db->setQuery($query);
		
		$extensions[0] = $db->loadObjectlist(); 
		
		$query = "SELECT name, version, '' as prefix, CONCAT( name, '-', version ) as text, CONCAT( LOWER(name), '-', version,'.zip' ) as file FROM #__jacc_modules WHERE published > 0";
		
        $db->setQuery($query);        
		
		$extensions[1] = $db->loadObjectlist();
				
		$query = "SELECT name, version, 'plg_' as prefix, CONCAT( name, '-', version ) as text, CONCAT('plg_', LOWER(name), '-', version,'.zip' ) as file, folder FROM #__jacc_plugins WHERE published > 0"; 
		
        $db->setQuery($query);
		
		$extensions[2] = $db->loadObjectlist();
		
		$query = "SELECT name, version, 'tpl_' as prefix, CONCAT( name, '-', version ) as text, CONCAT('tpl_', LOWER(name), '-', version,'.zip' ) as file FROM #__jacc_templates WHERE published > 0"; 
		
        $db->setQuery($query);
		
        $extensions[3] = $db->loadObjectlist();
	
        $names = array(JText::_('Components'), JText::_('Modules'), JText::_('Plugins'),JText::_('Templates'));
        $types = array(JText::_('component'), JText::_('module'), JText::_('plugin'),JText::_('template'));
		for($i =0; $i <count($extensions);$i++) {   
		    if(count($extensions[$i])) {
		        $tmp = new stdClass;
		        $tmp->value = null;
		        $tmp->text = '<strong>'.$names[$i].'</strong>';
		        $tmp->heading = "true";
		        $options[] = $tmp;  
		    }
		    for($e = 0; $e<count($extensions[$i]); $e++) {
		    	$item = $extensions[$i][$e];

		    	if($i > 1) {
		    		$extensions[$i][$e]->file = $item->prefix.JFilterOutput::stringURLSafe($item->name). '-'.$item->version.'.zip';
		    	}  
		        if(JFile::exists(JPATH_COMPONENT_ADMINISTRATOR.DS.'archives'.DS.$extensions[$i][$e]->file)) {
		            $tmp = $extensions[$i][$e];
		            $value = $this->_getValue ($tmp,$types[$i]);
		            $options[] = JHtml::_('select.option', (string) $value, trim((string) $tmp->text), 'value', 'text');
		        }
		    }    
			
		}		
		
		return $options;
	}
	
	private function _getValue ($object,$type) {
        $value['type'] = $type;
        if(isset($object->folder)) {
            $value['group'] = $object->folder;
        }
        $value['file'] = $object->file;
        $value['id'] = $object->name;
        return json_encode($value);    	    
	} 
	
}
		
