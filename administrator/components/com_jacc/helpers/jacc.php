<?php
/**
 * @version		$Id: jacc.php 125 2012-10-09 11:09:48Z michel $
 * @package		Joomla.Framework
 * @subpackage		HTML
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.filesystem.folder');

class JaccHelper
{

		/*
	 * Submenu for Joomla 1.6
	 */
	public static function addSubmenu($vName = 'jacc')
	{
        
		JSubMenuHelper::addEntry(
			JText::_('Components'),
			'index.php?option=com_jacc&view=jacc',
			($vName == 'jacc')
		);
		
		JSubMenuHelper::addEntry(
			JText::_('Modules'),
			'index.php?option=com_jacc&view=modules',
			($vName == 'modules')
		);

		JSubMenuHelper::addEntry(
			JText::_('Plugins'),
			'index.php?option=com_jacc&view=plugins',
			($vName == 'plugins')
		);

		JSubMenuHelper::addEntry(
			JText::_('Templates'),
			'index.php?option=com_jacc&view=templates',
			($vName == 'templates')
		);
		
		JSubMenuHelper::addEntry(
			JText::_('Packages'),
			'index.php?option=com_jacc&view=packages',
			($vName == 'packages')
		);
		
		JSubMenuHelper::addEntry(
			JText::_('howto'),
			'index.php?option=com_jacc&view=howto',
			($vName == 'howto')
		);

	}
	
	/**
	 * Method to get version from manifest cache
	 * 
	 */
	public static function getVersion() 
	{
	    static $version;
	    if(!empty($version)) return $version;
	    $me = JComponentHelper::getComponent('com_jacc');
	    $db = JFactory::getDbo();
	    $query = "SELECT manifest_cache FROM #__extensions WHERE extension_id = ".(int) $me->id;	
	    $db->setQuery($query); 
	    $manifest_cache = 	$db->loadResult();
	    $manifest = json_decode($manifest_cache);
	    $version = isset($manifest->version) ? $manifest->version : 'unknown'; 	    
	    return $version;  
	}
	
	/**
	 * 
	 * Sorting callback function
	 * @param object $a
	 * @param object $b
	 */	
	public static function sortOrdering ($a,$b) 
	{
		    if ($a->ordering == $b->ordering) {
       			 return 0;
    		}
    		return ($a->ordering < $b->ordering) ? -1 : 1;
	}

	/**
	 * 
	 * This Method creates an object of several field lists
	 * 
	 * Example:
	 * $db = JFactory::getDB0;
	 * $tablefields = $db->getTableFields('#__book', false);
	 * $fields = JaccHelper::getSpecialFields($tablefields['#__book'])
	 * $all = $fields->get('all') // returns a list of all available tables
	 * $listfields = $fields->get('list') // fields which are usefull to display in the list view
	 * $delete = $fields->get('delete') // a list of common fields which are *not* present in the table
	 * $groups = $fields->get('groups') // the fields sorted by the groups which are defined by fields.xml  
	 * 
	 * @param array $tablefields - fields returned by $db->getTableFields($table, false);
	 * @return JObject $fields
	 */
	
	public static function getSpecialFields ($tablefields) 
	{


		jimport('joomla.utilities.xmlelement');
		$xml = simplexml_load_file(JPATH_COMPONENT.DS.'models'.DS.'fields.xml', 'JXMLElement');		
        
		$elements = $xml->xpath('fields');
		$fields = $xml->fields->xpath('descendant-or-self::field');
		$specialFields = array();
		foreach ($fields  as $field) {
			$fieldkey = (string) $field->key;
			$specialFields[$fieldkey] = new JObject();
			$specialFields[$fieldkey]->setProperties($field);
			$specialFields[$fieldkey]->set('delete', true);
		}
		$hident = null;
		$ordering = 10;
		$primfield= null;
		$firstVarcharField = null;
		foreach ($tablefields as $tablefield) {
			$legal = '/[^A-Z0-9_]/i';
			if (preg_match_all($legal, $tablefield->Field, $matches)) {
				$suggest = (string) preg_replace( $legal, '', $tablefield->Field);
				return 'Field '.$tablefield->Field. ' contains illegal characters. It\'s suggested to rename it as '.$suggest;
			} 
			$tablefield->Type =  strtolower(preg_replace('/\(.*\)/i', '', $tablefield->Type));
			
			//find something like a title or a name or sku as a human comprehensible identifier for this item
			if (strtolower($tablefield->Field) == 'title' || strtolower($tablefield->Field) == 'domain' || strtolower($tablefield->Field) == 'name' || strtolower($tablefield->Field) == 'sku') {	
				$hident = $tablefield->Field;
			} 

			//find the first varchar. this may be the ident too
			if ($tablefield->Type == 'varchar' && $firstVarcharField === null) {
					
					$firstVarcharField = $tablefield->Field;
			}			
			
			//find it in the special fields
			if (isset($specialFields[$tablefield->Field])) {			
				//set delete to false. According parts of the templates will not be deleted
				$specialFields[$tablefield->Field]->set('fieldtype', $tablefield->Type);
				$specialFields[$tablefield->Field]->set('default', $tablefield->Default);
				$specialFields[$tablefield->Field]->set('delete', false);
			} else {
				//this is not a special field. add it to the object. 
				if ($tablefield->Key == 'PRI') {
					$primfield = $tablefield->Field;					
					$specialFields['primary']->set('key', $tablefield->Field);					
					$specialFields['primary']->set('group', '');
					$specialFields['primary']->set('formfield', '');
					$specialFields['primary']->set('alt', '');
					$specialFields['primary']->set('ordering', 1);
					$specialFields['primary']->set('delete', false);
				} else {
						$specialFields[$tablefield->Field] = new JObject();
						$specialFields[$tablefield->Field]->set('key', $tablefield->Field);
						$specialFields[$tablefield->Field]->set('group', 'details');
						$specialFields[$tablefield->Field]->set('alt', '');
						
						//handle some special field types 
						switch($tablefield->Type) {
							case 'text':
							case 'mediumtext':
							case 'longtext':
								$specialFields[$tablefield->Field]->set('formfield', 'editor');
								break;
							case 'date':
							case 'datetime':
								$specialFields[$tablefield->Field]->set('formfield', 'calendar');
								break;
							case 'varchar':
									$specialFields[$tablefield->Field]->set('list', true);
							default:
								$specialFields[$tablefield->Field]->set('formfield', 'text');									
						}
						
						//set ordering
						$specialFields[$tablefield->Field]->set('ordering', $ordering);
						
						//set delete to false. According parts of the templates will not be deleted
						$specialFields[$tablefield->Field]->set('delete', false);
						//set the type
						$specialFields[$tablefield->Field]->set('fieldtype', $tablefield->Type);
						$specialFields[$tablefield->Field]->set('default', $tablefield->Default);
				}

				$ordering++; 
			}						
		}
		//find the human comprehensible identifier
		if ($hident === null ) {
			if ($firstVarcharField) {
				//we can use the first field of type varchar				
				$hident = $firstVarcharField;
				unset ($specialFields[$firstVarcharField]);
			} elseif ($primfield ) {
				$hident = $primfield; 
			} 
		} else {				
				unset ($specialFields[$hident]);
		}
		 
		//replace hident field 
		$specialFields['hident']->set('key', $hident);
		$specialFields['hident']->set('delete', false);	
	   	if ($primfield) {
			//add primary field as "additional" to the end
			$specialFields[$primfield] = clone($specialFields['primary']);
			$specialFields[$primfield]->set('additional', true);
			$specialFields[$primfield]->set('ordering', 99);
			$specialFields[$primfield]->set('list', true);
	   	}
		
	   	//collect fields by groups
	   	$groups = array();
		foreach ($specialFields as $field) {
			if (($group = $field->get('group')) && (!$field->get('delete'))) {
				if (!isset($groups[$group])) {
					$groups[$group] = array();
				}
				$groups[$field->get('group')][$field->key] = $field;  
			}		
		}  
		
		//sort groups
		foreach ($groups as &$group) {
			uasort($group, 'JaccHelper::sortOrdering');
		}
		
		//collect fields for the list view
		$list = array();
		
		foreach ($specialFields as $field) {
			if ($field->get('list') && (!$field->get('delete'))) {
				$list[$field->key] = $field;  
			}		
		}  
		
		//sort the list
		uasort($list, 'JaccHelper::sortOrdering');

		//collect not required fields 
		$delete = array();
		foreach ($specialFields as $field) {
			if (($field->get('delete'))) {
				$delete[] = $field->key;  
			}		
		}  
		
		foreach ($specialFields as $field=>$element) {
			if (($element->get('delete'))) {
				unset($specialFields[$field]);  
			}		
		}  
		
		
		
		$fields = new JObject();
		//a list of all present fields
		$fields->set('all', $specialFields);
		//the fields sorted by the groups which are defined by fields.xml 
		$fields->set('groups', $groups);
		//the fields which are usefull for a list view
		$fields->set('list', $list);
		//this fields are defined by fields.xml but don't occure in the table 
		$fields->set('delete', $delete);
	
		return $fields; 
	}

	/**
	 * 
	 * Create a Folder and add index.html 
	 * @param string $folder - the folder to create
	 */
	public static function createFolder($folder) 
	{
		if (JFolder::create($folder) === false) {
			return false;
		}
		
		$html = '<html><body bgcolor="#FFFFFF"></body></html>';
		file_put_contents($folder.DS.'index.html', $html);
		return true;
		
	}
	/**
	 * 
	 * Finds existing language files of the component 
	 * @param string $name - the component name
	 */
	public static function getLanguagefiles($name) 
	{
		$files_site = JFolder::files(JPATH_SITE.DS.'language', $filter = '*.'.$name.'*', $recurse = true, $fullpath = true);
		$files_admin = JFolder::files(JPATH_ADMINISTRATOR.DS.'language', $filter = '*.'.$name.'*', $recurse = true, $fullpath = true);
	}
	
	/**
	 * 
	 * Method to create a CREATE TABLE SQL 
	 * @param string $table 
	 * @param string $break - OS specific line end
	 */
	public static function export_table_structure($table,  $break = "\n")
	{

		$db = &JFactory::getDBO();
		$config =& JFactory::getConfig();
		$dbprefix = version_compare(JVERSION,'3.0','lt') ? $config->getValue('config.dbprefix') : $config->get('dbprefix');

		$break = ($break == "\n" OR $break == "\r\n" OR $break == "\r") ? $break : "\n";

		$sqlstring = "";

		$query = 'SHOW CREATE TABLE '. $table;
		$db->setQuery('SHOW CREATE TABLE '. $table);
		$data = $db->loadAssoc();

		$sqlstring .= str_replace("\n", $break, $data['Create Table']) . ";$break$break";
		$sqlstring = preg_replace("! AUTO_INCREMENT=(.*);!", ';', $sqlstring);
		$sqlstring = str_replace($dbprefix, '#__', $sqlstring);
		$sqlstring = str_replace("CREATE TABLE", 'CREATE TABLE IF NOT EXISTS', $sqlstring);
		$sqlstring = str_replace(" DEFAULT CHARSET=utf8", '', $sqlstring);

		return $sqlstring;
	}

/**
 * 
 * Method to create the SQL for categories 
 * @param string $lcomponent - the component name
 * @return string SQL
 */
	public static 	function getCatsql($lcomponent) 
	{

		return "
CREATE TABLE IF NOT EXISTS `#__".$lcomponent."_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) unsigned NOT NULL DEFAULT '0',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `lft` int(11) NOT NULL DEFAULT '0',
  `rgt` int(11) NOT NULL DEFAULT '0',
  `level` int(10) unsigned NOT NULL DEFAULT '0',
  `path` varchar(255) NOT NULL,
  `extension` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `description` varchar(5120) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `params` varchar(2048) NOT NULL,
  `metadesc` varchar(1024) NOT NULL,
  `metakey` varchar(1024) NOT NULL,
  `metadata` varchar(2048) NOT NULL,
  `created_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `modified_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `language` varchar(7) NOT NULL,
  `section` int(11) NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cat_idx` (`extension`,`published`,`access`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_path` (`path`),
  KEY `idx_left_right` (`lft`,`rgt`),
  KEY `idx_alias` (`alias`)
) TYPE=MyISAM;
Replace INTO `#__".$lcomponent."_categories`  VALUES(1, 0, 0, 0, 5, 0, '', 'system', 'ROOT', 'root', '', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', 0, 0);
";
	}



	public static function _replace($file, $item, $options=array()) 
	{
		
		$date = JFactory::getDate($item->created);

		$categorytask = ($item->params->get('uses_categories')) ? JaccHelper::getcategorytask () : "";

	    
		
		$reltable = isset($options['reltable']) ? $options['reltable'] : '';
		
		if((isset($options['submenu']) && trim($options['submenu']))) {
		    $options['submenu'] = "			<submenu>\n".$options['submenu']."\n			</submenu>";
		}
		
		$description = $item->description;
		$version = $item->version;
		$params = JComponentHelper::getParams('com_jacc');
		$com_component = $item->name;
		$lcomponent = strtolower(str_replace('com_', '', $com_component ));
		$component = ucfirst($lcomponent);

	        
		$file = str_replace("##table##", $reltable, $file);
		$file = str_replace("##categorytask##", $categorytask, $file);
		$file = str_replace("##codestart##", '<?php', $file);
		$file = str_replace("##codeend##", '?>', $file);

		$file = str_replace("##Component##", $component, $file);
		$file = str_replace("##description##", $description, $file);
		
		/**
		$file = str_replace("##defaultview##", $defaultview, $file);
		$file = str_replace("##firstname##", $firstName, $file);
		$file = str_replace("##Firstname##", $UFirstName, $file);

		**/
		$file = str_replace("##version##", $version, $file);
		$file = str_replace("##table##", $reltable, $file);
				
		$file = str_replace("##website##", $params->get('website'), $file);
		$file = str_replace("##author##", $params->get('author'), $file);
		$file = str_replace("##sauthor##", $params->get('sauthor'), $file);
		$file = str_replace("##email##", $params->get('email'), $file);
		$file = str_replace("##license##", $params->get('license'), $file);
		$file = str_replace("##component##", $lcomponent, $file);
		$file = str_replace("##date##", $date->format('Y-m-d'), $file);
		$file = str_replace("##year##", $date->format('Y'), $file);		
		$file = str_replace("##com_component##", $com_component, $file);

		foreach($options as $key => $value) {		    
		    $value = (string) $value;
		    $Ukey = ucfirst($key);
		    $Uvalue = ucfirst($value);
		    $file = str_replace("##".$key."##", $value, $file);
		    $file = str_replace("##".$Ukey."##", $Uvalue, $file);
		}
		
		/**
		$file = str_replace("##name##", $name, $file);
		$file = str_replace("##Name##", $UName, $file);
		$file = str_replace("##key##", $key, $file);
		$file = str_replace("##hident##", $hident, $file);
		$file = str_replace("##primary##", $primary, $file);
		$file = str_replace("##menuhelper##", $menuhelper, $file);
		$file = str_replace("##routerswitch##", $routerswitch, $file);
		$file = str_replace("##syslanguage##", $syslanguage, $file);		
		**/
		return $file;
	}

	public static function getcategorytask () 
	{
		return "
if (JRequest :: getWord('task') == 'categoryedit') {
	".'$'."controller = 'category';
	JRequest :: setVar('task', 'edit');
	JRequest :: setVar('view', 'category');
	".'$'."task = 'edit';
}
		";
	}
}

/**
 * Utility class for categories
 *
 * @static
 * @package 	Joomla.Framework
 * @subpackage	HTML
 * @since		1.5
 */
abstract class JHtmlJacc
{
	/**
	 * @var	array	Cached array of the category items.
	 */
	protected static $items = array();

	/**
	 * Returns an array of categories for the given extension.
	 *
	 * @param	string	The extension option.
	 * @param	array	An array of configuration options. By default, only published and unpulbished categories are returned.
	 *
	 * @return	array
	 */
	public static function categories($extension, $cat_id, $name="categories", $title="Select Category", $config = array('attributes'=>'class="inputbox"','filter.published' => array(0,1)))
	{

		$config	= (array) $config;
		$db		= $this->getDbo();

		jimport('joomla.database.query');
		$query	= $db->getQuery(true);

		$query->select('a.id, a.title, a.level');
		$query->from('#__jacc_categories AS a');
		$query->where('a.parent_id > 0');

		// Filter on extension.
		$query->where('extension = '.$db->quote($extension));
			
		$attributes = "";
			
		if (isset($config['attributes'])) {
			$attributes = $config['attributes'];
		}
			
		// Filter on the published state
		if (isset($config['filter.published'])) {
			if (is_numeric($config['filter.published'])) {
				$query->where('a.published = '.(int) $config['filter.published']);
			} else if (is_array($config['filter.published'])) {
				JArrayHelper::toInteger($config['filter.published']);
				$query->where('a.published IN ('.implode(',', $config['filter.published']).')');
			}
		}

		$query->order('a.lft');

		$db->setQuery($query);
		$items = $db->loadObjectList();
			
		// Assemble the list options.
		self::$items = array();
		self::$items[] = JHtml::_('select.option', '', JText::_($title));
		foreach ($items as &$item) {

			$item->title = str_repeat('- ', $item->level - 1).$item->title;
			self::$items[] = JHtml::_('select.option', $item->id, $item->title);
			
		}

		return  JHtml::_('select.genericlist', self::$items, $name, $attributes, 'value', 'text', $cat_id, $name);
		//return self::$items;
	}
}