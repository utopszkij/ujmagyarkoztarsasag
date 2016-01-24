<?php
/**
 * @version		$Id: categories.php 125 2012-10-09 11:09:48Z michel $
 * @copyright	 Copyright (C) ##year## Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

jimport('joomla.application.component.model');
require_once JPATH_COMPONENT.'/helpers/category.php';


/**
 * This models supports retrieving lists of article categories.
 *
 * @package		##Component##
 * @subpackage	models
 */
class ##Component##ModelCategories extends JModelLegacy
{
	/**
	 * Model context string.
	 *
	 * @var		string
	 */
	private $_context = 'com_##component##.categories';

	/**
	 * The category context (allows other extensions to derived from this model).
	 *
	 * @var		string
	 */
	protected $_extension = 'com_##component##';

	private $_parent = null;

	private $_items = null;
		
	protected $__state_set = null;	

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication();
		
		$ext = $app->getUserStateFromRequest('filter.extension', 'extension', $this->_extension);
		$this->setState('filter.extension', $ext);
		

		// Get the parent id if defined.
		$parentId = JRequest::getInt('id');
		$this->setState('filter.parentId', $parentId);
		
		//Get the data for the Categories tree
		
		$extensions = BookshopHelper::getExtensions();

		foreach ($extensions as $extension) {

		    if (((string) $extension->name) == $ext) {

				$this->setState('filter.extensiontable', (string) $extension->table);
				$this->setState('filter.extensionfield', (string) $extension->field);
				$this->setState('filter.itemfield', (string) $extension->display);
				$this->setState('filter.view', (string) $extension->name);
				$this->setState('filter.primary', (string) $extension->primary);
			}
		}					
		
		//Get the params
		$app_params = $app->getParams();

		if (is_a($app_params, 'JParameter')) {
			$params = $app_params;
		} else { 
		   $params = new JObject();
			$tmp_params = json_decode($app_params);										
			$params ->setProperties(JArrayHelper::fromObject($tmp_params));
		}			
		$this->setState('params', $params);

		$this->setState('filter.published', 1);
		$this->setState('filter.access', true);
	}

/**
	 * Method to get model state variables
	 *
	 * @param	string	Optional parameter name
	 * @param	mixed	Optional default value
	 * @return	object	The property where specified, the state object where omitted
	 */
	public function getState($property = null, $default = null)
	{
		if (!$this->__state_set) {
			// Private method to auto-populate the model state.
			$this->populateState();

			// Set the model state set flat to true.
			$this->__state_set = true;
		}
		return parent::getState($property, $default );
		//return $property === null ? $this->state : $this->state->get($property, $default);
	}
	
	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param	string		$id	A prefix for the store id.
	 *
	 * @return	string		A store id.
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('filter.extension');
		$id	.= ':'.$this->getState('filter.published');
		$id	.= ':'.$this->getState('filter.access');
		$id	.= ':'.$this->getState('filter.parentId');

		return parent::getStoreId($id);
	}

	/**
	 * redefine the function an add some properties to make the styling more easy
	 *
	 * @return mixed An array of data items on success, false on failure.
	 */
	public function getItems()
	{
		if (!count($this->_items)) {
			
			$app = JFactory::getApplication();
			$menu = $app->getMenu();
			$active = $menu->getActive();			
			$params = new JObject();			
			if ($active) {
					$tmp_params = json_decode($active->params);										
					$params ->setProperties(JArrayHelper::fromObject($tmp_params));				
				//$params->loadJSON($active->params);
			}
			
			$options = array();
			$options['countItems'] = $params->get('show_cat_num_links', 1) || !$params->get('show_empty_categories_cat', 0);
			$options['extension']  = 'com_##component##.'.$this->getState('filter.extension');
			
			$options['table'] = $this->getState('filter.extensiontable');
			
			$categories = ##Component##Categories::getInstance('##Component##', $options);
			$this->_parent = $categories->get($this->getState('filter.parentId', 'root'));
			if (is_object($this->_parent)) {
				$this->_items = $this->_parent->getChildren();
			} else {
				$this->_items = false;
			}
		}

		return $this->_items;
	}

	public function getParent()
	{
		if (!is_object($this->_parent)) {
			$this->getItems();
		}
		return $this->_parent;
	}
}