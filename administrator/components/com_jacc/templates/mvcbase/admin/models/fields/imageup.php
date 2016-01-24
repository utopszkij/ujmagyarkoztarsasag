<?php
/**
 * @version		$Id: imageup.php 96 2011-08-11 06:59:32Z michel $
 * @copyright	Copyright (C) ##year##, ##author##. All rights reserved.
 * @license ###license## 
 */

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

/**
 * Form Field class for the Joomla Framework.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_##component##
 */
class JFormFieldImageup extends JFormField
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	public $type = 'Imageup';

	protected function getInput()
	{
		// Initialize some field attributes.
		$config 	=& JComponentHelper::getParams( 'com_##component##' );
	    $width = $config->get('imgwidth3',60);
	    $height = $config->get('imgheight3',80);
		$class		= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';
		$folder		= $this->element['folder'] ? $this->element['folder'] : 'com_##component##';
		$src = $this->value ? JURI::root(true).$this->value : "";
		$id="";
		$html = array();
		$html[] = 	'<div  style="height:'.$height.'px;" id="'.$this->id.'uploader" class="fltlft">';
		$html[] = 	'<input class="inputbox" type="file" name="image_replace" id="'.$this->id.'uploader_replace" /></div>';
		$html[] = 	'<div id="'.$this->id.'uploader_button" class="fltlft"><button onclick="javascript:Joomla.submitform(\'upload\', document.getElementById(\''.$this->id.'uploadForm\'));return false;" name="upload" value="'.JText::_('Upload').'">'.JText::_('Upload').'</button>'; 	
		$html[] = 	'<input type="hidden" value="'.$this->value.'" name="'.$this->name.'" id="'.$this->id.'" />';
		$html[] = 	'<img style="margin-left:50px;" src="'.$src.'" id="'.$this->id.'previewimage" /></div>';						          			                 

		$html[] = 	'<div id="'.$this->id.'uploader_form_inner">';	 						
		$html[] = 	'<input class="inputbox" type="file" name="image" id="'.$this->id.'jform_image" />';        	      
     	$html[] = 	'<input type="hidden" name="option" value="com_##component##" />';
		$html[] = 	'<input type="hidden" name="task" value="upload" />';
		$html[] = 	'<input type="hidden" name="folder" value="'.$folder.'" />';
		$html[] = 	'<input type="hidden" name="view" value="imageup" />';
		$html[] = 	JHTML::_( 'form.token' );
		$html[] = 	'</div><div style="clear:both"></div>';
		
		$this->_addJs($this->id);	

		return implode('',$html);
	}
	
	private function _addJs($id) 
	{
        $js = "
	    window.addEvent('domready',function(){
			var co = $('".$id."uploader_replace').getCoordinates();
			var cou = $('".$id."uploader').getCoordinates();
			var cob = $('".$id."uploader_button').getCoordinates();
			var form = new Element('form', {'action' : 'index.php', 'method' : 'post', 'name' : '".$id."uploadForm', 'id' : '".$id."uploadForm',  'enctype' : 'multipart/form-data'});
			form.inject(document.body);
			$('".$id."uploader_form_inner').inject(form);
			$('".$id."uploader_replace').setStyle('display','none');	
			form.setStyle('position','absolute');
			form.setStyle('top',co.top + 'px');
			form.setStyle('left',co.left + 'px');
			$('".$id."uploader_button').setStyle('position','absolute');
			$('".$id."uploader_button').setStyle('top',cob.top + 'px');
			$('".$id."uploader_button').setStyle('left',cob.left + 'px');						
			$('".$id."uploader').setStyle('width',cou.width + 'px');
			var iFrame".$id." = new iFrameFormRequest('".$id."uploadForm',{
				onRequest: function(){
				},
				onComplete: function(response){
					if(response == 'error' || response == 'noimage' || response == 'nofile') {
							return;
					}  
					var x = eval('(' + response + ')');
					$('".$id."previewimage').src = '".JURI::root(true)."' + x.thumbs.uri; 
					$('".$id."').value = x.thumbs.uri;
				}
			});
		});";
        $document = JFactory::getDocument();
        $document->addScript(JURI::base().'components/com_##component##/assets/imageup.js');
        $document->addScriptDeclaration($js);
	}
}