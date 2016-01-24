<?php
/**
 * @version		$Id: category.php 125 2012-10-09 11:09:48Z michel $
 * @package		##Component##
 * @subpackage	Helpers
 * @copyright	Copyright (C) ##year## Open Source Matters, Inc. All rights reserved.
 * @license		##license##
 */

// no direct access
defined('_JEXEC') or die;

// Component Helper
jimport('joomla.application.component.helper');

jimport('joomla.application.categories');

require_once(JPATH_COMPONENT_ADMINISTRATOR.'/helpers/##component##.php');  
/**
 * ##Component## Component Category Tree
 *
 * @static
 * @package		##Component##
 * @subpackage	Helpers
 */

class ##Component##Categories extends JCategories
{

	public function __construct($options = array())
	{

		$extensions = ##Component##Helper::getExtensions();

		foreach ($extensions as $extension) {
			if ($options['extension'] ==  'com_##component##.'.$extension->name) {
				$options['table'] = $extension->table;
				$options['field'] = $extension->field;						
			}
		}		
		parent::__construct($options);
	}

	protected function _load($id)
	{
		$db	= JFactory::getDbo();
		$app = JFactory::getApplication();
		$user = JFactory::getUser();
		$extension = $this->_extension;

		$query = $db->getQuery(true);

		// right join with c for category
		$query->select('c.*');
		$query->select('CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(":", c.id, c.alias) ELSE c.id END as slug');
		$query->from('#__##component##_categories  as c');
		$query->where('(c.extension='.$db->Quote($extension).' OR c.extension='.$db->Quote('system').')');
		if ($this->_options['access']) {		
			$query->where('c.access IN ('.implode(',', $user->getAuthorisedViewLevels()).')');		    
		}
		
		if ($this->_options['published'] == 1) {
			
			$query->where('c.published = 1');
		}
		$query->order('c.lft');


		// s for selected id
		if ($id!='root') {
			
			// Get the selected category
			$query->leftJoin('#__##component##_categories  AS s ON (s.lft <= c.lft AND s.rgt >= c.rgt) OR (s.lft > c.lft AND s.rgt < c.rgt)');
			$query->where('s.id='.(int)$id);
		}

		// i for item
		if (isset($this->_options['countItems']) && $this->_options['countItems'] == 1) {
			if ($this->_options['published'] == 1) {
				$query->leftJoin($db->nameQuote($this->_table).' AS i ON i.'.$db->nameQuote($this->_field).' = c.id AND i.published = 1');
			} else {
				$query->leftJoin($db->nameQuote($this->_table).' AS i ON i.'.$db->nameQuote($this->_field).' = c.id');
			}
			$query->select('COUNT(i.'.$db->nameQuote($this->_key).') AS numitems');
		}

		// Group by
		$query->group('c.id');


		
		// Get the results
		$db->setQuery($query->__toString());
		$results = $db->loadObjectList('id');
		$childrenLoaded = false;
		if (count($results)) {
			
			// foreach categories
			foreach ($results as $result) {
				
				// Deal with root category
				if ($result->id == 1) {
					
					$result->id = 'root';
				}
				// Deal with parent_id
				if ($result->parent_id == 1) {
					
					$result->parent_id = 'root';
				}
				// Create the node
				if (!isset($this->_nodes[$result->id])) {
					
					// Create the JCategoryNode
					$this->_nodes[$result->id] = new JCategoryNode($result, $this);
					if ($result->id != 'root' && (isset($this->_nodes[$result->parent_id]) || $result->parent_id == 0)) {
						
						// Compute relationship between node and its parent
						$this->_nodes[$result->id]->setParent($this->_nodes[$result->parent_id]);
					}
					if (!(isset($this->_nodes[$result->parent_id]) || $result->parent_id == 0)) {
						
						unset($this->_nodes[$result->id]);
						continue;
					}

					if ($result->id == $id || $childrenLoaded) {
						
						$this->_nodes[$result->id]->setAllLoaded();
						$childrenLoaded = true;
					}
				} elseif ($result->id == $id || $childrenLoaded) {
					// Create the JCategoryNode
					$this->_nodes[$result->id] = new JCategoryNode($result, $this);
					if ($result->id != 'root' && (isset($this->_nodes[$result->parent_id]) || $result->parent_id)) {
						
						// Compute relationship between node and its parent
						$this->_nodes[$result->id]->setParent($this->_nodes[$result->parent_id]);
					}
					if (!isset($this->_nodes[$result->parent_id])) {
						
						unset($this->_nodes[$result->id]);
						continue;
					}
					if ($result->id == $id || $childrenLoaded) {
						
						$this->_nodes[$result->id]->setAllLoaded();
						$childrenLoaded = true;
					}

				}
			}
		} else {
			$this->_nodes[$id] = null;
		}
	}	
}