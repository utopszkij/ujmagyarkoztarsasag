<?php
/**
 * @version		$Id: category.php 127 2012-10-16 14:19:02Z michel $
 * @package		##Component##
 * @subpackage	models
 * @copyright	Copyright (C) ##year## Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;


jimport('joomla.application.component.modellist');
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_##component##/tables');

require_once(JPATH_COMPONENT_ADMINISTRATOR.'/helpers/##component##.php'); 

/**
 * Category model for the ##Component## component.
 *
 * @package		##Component##
 * @subpackage	models
 */
class ##Component##ModelCategory extends JModelList
{

	public function __construct($config = array())
	{		
	
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
            /**
				'id', 'a.id',
				'name', 'a.name',
				'ordering', 'a.ordering',
			**/			
			);
		}
	    parent::__construct($config);		
		
		
	}
	
	protected function populateState($ordering = null, $direction = null)
	{
			parent::populateState();
			$db = JFactory::getDBO();

			$app = JFactory::getApplication();
			$id = JRequest::getVar('id', 0, '', 'int');
			$params	= JComponentHelper::getParams('com_##component##');
			$query = $this->_db->getQuery(true);
			$query->select('extension');
			$query->from('#__##component##_categories');			
			$query->where('id='.$id);
			$db->setQuery($query);			
			
			$ext = $db->loadResult();
			$extensions = ##Component##Helper::getExtensions();

			foreach ($extensions as $extension) {
				if ($ext ==  'com_##component##.'.(string) $extension->name) {
					$this->setState('filter.extensiontable',(string) $extension->table);
					$this->setState('filter.extensionfield',(string) $extension->field);
					$this->setState('filter.itemfield',(string) $extension->display);
					$this->setState('filter.view',(string) $extension->name);
					$this->setState('filter.primary',(string) $extension->primary);
				}
			}			

		    // List state information
		    $format = JRequest::getWord('format');
		    if ($format=='feed') {
			    $limit = $app->getCfg('feed_limit');
		    }
		    else {
			    $limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'));
		    }
		    $this->setState('list.limit', $limit);

		    $orderCol	= JRequest::getCmd('filter_order', 'ordering');
		    if (!in_array($orderCol, $this->filter_fields)) {
			    $orderCol = 'ordering';
		    }
		    $this->setState('list.ordering', $orderCol);
			    
		    // Load the parameters.
		    $this->setState('params', $params);

		    $user = JFactory::getUser();
		    if ((!$user->authorise('core.edit.state', 'com_##component##')) &&  (!$user->authorise('core.edit', 'com_##component##'))){
			    // limit to published for people who can't edit or edit.state.
				$this->setState('filter.published', 1);
		    }
		    
		    $this->setState('filter.language',$app->getLanguageFilter());
		    
			$this->setState('filter.extension', $ext ); 
			$this->setState('category.id', $id);
						
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('category.id');

		return parent::getStoreId($id);
	}	
	
	/**
	 * Method to get a JDatabaseQuery object for retrieving the data set from a database.
	 *
	 * @return	object	A JDatabaseQuery object to retrieve the data set.
	 * @since	1.6
	 */
	protected function getListQuery()
	{
        
	    $db = JFactory::getDbo();
	         
	    $table_name = str_replace('#__',$db->getPrefix(),$this->getState('filter.extensiontable'));	         
	    $fields = version_compare(JVERSION,'3.0','lt') ?  $db->getTableFields($table_name, false) :  array($table_name => $db->getTableColumns($table_name, false));	    
        $table = $fields[$table_name];
	    	       
	    $query = $this->_db->getQuery(true);
		$query->select('a.*');
		$query->select('a.'.$this->getState('filter.itemfield').' as title');
		$query->from($this->getState('filter.extensiontable').' as a');
		$query->select('CONCAT("index.php?view=","'.$this->getState('filter.view').'","&id=",a.'.$this->getState('filter.primary').') as link');
		if(isset($table['alias'])) {		    
		    $query->select('CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT(\':\', a.alias) ELSE a.'.$this->getState('filter.primary').' END as slug');
		}
		$query->select('CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(\':\', c.id, c.alias) ELSE c.id END AS catslug');

		$query->join('LEFT', '#__##component##_categories AS c ON c.id = a.'.$this->getState('filter.extensionfield'));

		// Filter by category.
		if ($categoryId = $this->getState('category.id')) {
			$query->where('a.'.$this->getState('filter.extensionfield').' = '.(int) $categoryId);		
		}
		if(isset($table['published'])) {
		    // Filter by state
		    $state = $this->getState('filter.published');
		    
		    if (is_numeric($state)) {
			    $query->where('a.published = '.(int) $state);
		    }
		}

		if(isset($table['publish_up']) && isset($table['publish_down'])) {
		    // Filter by start and end dates.
		    $nullDate = $db->Quote($db->getNullDate());
		    $nowDate = $db->Quote(JFactory::getDate()->toMySQL());

		    if ($this->getState('filter.publish_date')){
			    $query->where('(a.publish_up = ' . $nullDate . ' OR a.publish_up <= ' . $nowDate . ')');
			    $query->where('(a.publish_down = ' . $nullDate . ' OR a.publish_down >= ' . $nowDate . ')');
		    }
		}
		if(isset($table['language'])) {
		    // Filter by language
		    if ($this->getState('filter.language')) {
			    $query->where('a.language in (' . $db->Quote(JFactory::getLanguage()->getTag()) . ',' . $db->Quote('*') . ')');
		    }
		}
		if(isset($table['ordering'])) {		
		// Add the list ordering clause.
			$query->order($db->quoteName($this->getState('list.ordering', 'a.ordering')).' '.$this->getState('list.direction', 'ASC'));

		}

		return $query;	    		
	}
}