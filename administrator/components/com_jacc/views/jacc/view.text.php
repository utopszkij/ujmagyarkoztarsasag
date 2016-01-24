<?php
/**
* @version		$Id: view.text.php 125 2012-10-09 11:09:48Z michel $
* @package		Jacc
* @subpackage 	Views
* @copyright	Copyright (C) 2010, mliebler. All rights reserved.
* @license #http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/
//--No direct access
defined('_JEXEC') or die('=;)');

jimport( 'joomla.application.component.view');

class  JaccViewJacc   extends JViewLegacy
{
	/**
	 * componenthelp view display method
	 *
	 * @return void
	 **/
	public function display($tpl = null)
	{

		$this->addTemplatePath(JPATH_COMPONENT.'/templates/mvctriple');
		$db =  & JFactory::getDBO();
		
		$config =& JFactory::getConfig();
		$dbprefix = version_compare(JVERSION,'3.0','lt') ? $config->getValue('config.dbprefix') : $config->get('dbprefix');
		$model= &$this->getModel();
		
		//get the Component to create
		$item= $this->get('Item');
		$this->uses_categories =  $item->params->get('uses_categories');

		//Get Table and Template
		$mvcTable = $this->get('MvcTable');
		$mvcTemplate = $this->get('MvcTemplate');
		
		
		//init the strings that replaces the fields and fieldslist pattern
		$freplace = "\n";
		$fdetailsreplace = "\n";
		$fparamsreplace = "\n";
		$fdescreplace = "\n";
		$fsubdescreplace = "\n";
		
		$flistreplace = "\n";

		$time =  $item->created;
		
		$tableFields = $model->getTableFields($mvcTable);
		
		$parsedFields = array();
		
		$allfields = $tableFields->get('all'); 
		$hidentField = $allfields['hident'];		
		$this->hident = $hidentField->get('key');

		$primaryField = $allfields['primary'];		
		$this->primary = $primaryField->get('key');
				
		switch($mvcTemplate) {
				case 'table':
					$parsedFields = $tableFields->get('all'); 
					break;
				case 'tmplfrontend':
					$parsedFields = $tableFields->get('list'); 
					break;					
				case 'form' :
					$this->formfield = $tableFields->get('groups');
					break;
				case 'xmlmodel' :
					$this->formfield = $tableFields->get('all');
					break;					
				case 'templ' :
					$parsedFields = $tableFields->get('list');
					break;
				default: $freplace .='';			
		}
		
		foreach ($parsedFields  as $field) {
			$this->field = $field;
			
			switch($mvcTemplate) {
				case 'table':
					if (!$field->get('additional')) {
						$prim = $field->get('prim', false) ? '- Primary Key' : '';
						$default = $field->get('default') ? '"'.$field->get('default').'"' : 'null' ;						
						$freplace .= ''.
								'   /** @var '.$field->get('fieldtype').' '.$field->get('key').$prim."  **/\n".
								'   public $'.$field->get('key').' = '.$default.';'."\n\n";
					}
					break;	
				case 'tmplfrontend' :
	
						$freplace .= $this->replace_field($field, 'tmplfrontendrow');
					break;	
				case 'templ' :
					$freplace .= $this->replace_field($field, 'templhead');
					if ($field->get('key') == 'ordering') {
						
						$flistreplace.= $this->loadTemplate('templordering');
					} elseif ($field->get('key') == $this->hident) {
						$flistreplace .= $this->replace_field($field, 'templlist_hident');
					} else {
						
						$flistreplace .= $this->replace_field($field, 'templlist');
					}
					break;
				default:$freplace .='';
			}
		}

		$com_component = $item->name;
		$date = &JFactory::getDate();
		
		//last part of table name as (lowercase) name
		$name = substr(strrchr($mvcTable, '_'), 1);
		
		//Component Name as first part of camel case class names 
		$ComponentName = ucfirst(strtolower(str_replace('com_', '', $com_component)));

		//Replace the patterns
		$file = $this->loadTemplate($mvcTemplate);
		$file = str_replace("##Component##", $ComponentName, $file);
		$file = str_replace("##date##", $date->format('Y-m-d H:i:s'), $file);
		$file = str_replace("##com_component##", $com_component, $file);
		$file = str_replace("##title##", $this->hident, $file);
		$file = str_replace("##Name##", ucfirst($name), $file);
		$file = str_replace("##name##", strtolower($name), $file);
		$file = str_replace("##fields##", $freplace, $file);
		$file = str_replace("##fieldslist##", $flistreplace, $file);
		$file = str_replace("##primary##", $this->primary, $file);
		$file = str_replace("##time##", $time, $file);
		$file = str_replace("##codestart##", '<?php', $file);
		$file = str_replace("##codeend##", '?>', $file);
		$file = str_replace("##table##", $mvcTable, $file);
		
				
		//remove unneeded code parts
		$deleteList =  $tableFields->get('delete');
		
				
		foreach ($deleteList as $field) {
			$pattern = '/##ifdefField'.$field.'Start##.*##ifdefField'.$field.'End##/isU';
			$file	= preg_replace($pattern, '', $file);
		}

		$pattern = '/##ifnotdefField'.$field.'Start##.*##ifnotdefField'.$field.'End##/isU';
		$allFields = $tableFields->get('all');
		foreach ($allFields  as $field) {		
			$pattern = '/##ifnotdefField'.$field->get('key').'Start##.*##ifnotdefField'.$field->get('key').'End##/isU';
			$file	= preg_replace($pattern, '', $file);
		}		
		
		$pattern = '/\s+##ifdefField.*[Start|End]##+?/isU';
		$file	= preg_replace($pattern, '', $file);
		
		$pattern = '/\s+##ifnotdefField.*[Start|End]##+?/isU';
		$file	= preg_replace($pattern, '', $file);
		
		$file = str_replace("\n\r", "\n", $file);
		
		if (JRequest::getVar('mode') == 'return') {
			return $file;
		}
		while (@ob_end_clean());

		//Begin writing headers
		header("Cache-Control: max-age=60");
		header("Cache-Control: private");
		header("Content-Description: File Transfer");

		//Use the switch-generated Content-Type
		header("Content-Type: text/plain");

		//Force the download
		header("Content-Disposition: attachment; filename=\"".strtolower(JRequest::getVar('name')).".php\"");
		header("Content-Transfer-Encoding: binary");

		print $file;
	}

	// function
	private function replace_field($field, $tmpl)
	{
		$file = $this->loadTemplate($tmpl);
		$fieldupper = ucfirst($field->get('key'));

		if ($tmpl == 'templlist' and $field->get('key') == $this->hident) {
			$file = str_replace("##codestart##", '<a href="##codestart## echo $link; ##codeend##">##codestart##', $file);
			$file = str_replace("##field## ##codeend##", $field->get('key').' ?></a>', $file);
		} elseif ($tmpl == 'templlist' and strtolower($field->get('key')) == 'ordering') {
				
			$file = str_replace("\$row->##field##", "\$ordering", $file);

		} elseif ($tmpl == 'templlist' and strtolower($field->get('key')) == 'published') {

			$file = str_replace("\$row->##field##", "\$published", $file);

		} else {
				
			$file = str_replace("##field##", $field->get('key'), $file);
				
		}

		$file = str_replace("##codestart##", '<?php', $file);
		$file = str_replace("##codeend##", '?>', $file);
		return str_replace("##Field##", $fieldupper, $file);
	}

}// class

