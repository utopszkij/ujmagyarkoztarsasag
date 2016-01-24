<?php
/**
 * @version		$Id: category.php 125 2012-10-09 11:09:48Z michel $
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;



/**
 * Categories Component Category Model
 *
 * @package		Joomla.Administrator
 * @subpackage	com_ammvc_categories
 * @since 1.5
 */
class AmmvcModelCategory extends JModelLegacy
{
	/**
	 * Model context string.
	 *
	 * @var		string
	 */
	private $_context		= 'com_ammvc_categories';

	 
	/**
	 * An state object
	 *
	 * @var string
	 */
	public $_state;

	/**
	 * Indicates if the internal state has been set
	 *
	 * @var bool
	 * @since	1.6
	 */
	public $__state_set	= null;
	 
	/**
	 * Constructor
	 */
	public function __construct() 
	{
		parent::__construct();
		//Compatibility
		if (!isset($this->_state) and isset($this->state) ) $this->_state = &$this->state;
	}
	/**
	 * Returns a reference to the a Table object, always creating it
	 *
	 * @param	type 	$type 	 The table type to instantiate
	 * @param	string 	$prefix	 A prefix for the table class name. Optional.
	 * @param	array	$options Configuration array for model. Optional.
	 * @return	JTable	A database object
	*/
	public function &getTable($type = 'Category', $prefix = 'JTableAmmvc', $config = array())
	{
		$table = & JTable::getInstance($type, $prefix, $config);
		return $table ;
	}

	/**
	 * Method to set model state variables
	 *
	 * @param	string	The name of the property
	 * @param	mixed	The value of the property to set
	 * @return	mixed	The previous value of the property
	 */
	public function setState($property, $value=null)
	{
		return $this->_state->set($property, $value);
	}

	/**
	 * Method to get model state variables
	 *
	 * @param	string	Optional parameter name
	 * @param   mixed	Optional default value
	 * @return	object	The property where specified, the state object where omitted
	 */
	public function getState($property = null, $default = null)
	{
		if (!$this->__state_set) {
			// Private method to auto-populate the model state.
			$this->_populateState();

			// Set the model state set flat to true.
			$this->__state_set = true;
		}

		return $property === null ? $this->_state : $this->_state->get($property, $default);
	}	
	

	
	public function access($ids, $value)
	{
		// Initialize variables
	
	   foreach ($ids as $id) {
	   		$row = $this->getTable();
			$row->load( $id );
			$row->access = $value;
			if ( !$row->check() ) {
				$this->setError($row->getError());				
				return false;
			}
			if ( !$row->store() ) {
				$this->setError($row->getError());				
				return false;			
			}
	   }
	}	
	

	/**
	 * Auto-populate the model state.
	 *
	 * @return	void
	 */
	protected function _populateState()
	{
		$app = &JFactory::getApplication('administrator');

		// Load the User state.
		if (!($pk = (int) $app->getUserState('com_ammvc_categories.edit.category.id'))) {
			$pk = (int) JRequest::getInt('item_id');
		}
		$this->setState('category.id', $pk);

		if (!($parentId = $app->getUserState('com_ammvc_categories.edit.category.parent_id'))) {
			$parentId = JRequest::getInt('parent_id');
		}
		$this->setState('category.parent_id', $parentId);
		
		if (!($extension = $app->getUserState('com_ammvc_categories.filter.extension'))) {
			$extension = JRequest::getCmd('extension', 'com_ammvc.ammvc');
		}
		$this->setState('category.extension', $extension);
		
		JRequest::setVar('extension', $extension);

		// Load the parameters.
		$params	= &JComponentHelper::getParams('com_ammvc');
		$this->setState('params', $params);
	}

	/**
	 * Method to get a category.
	 *
	 * @param	integer	An optional id of the object to get, otherwise the id from the model state is used.
	 *
	 * @return	mixed	Category data object on success, false on failure.
	 */
	public function &getItem($pk = null)
	{
		
		
		// Initialize variables.
		$pk = (!empty($pk)) ? $pk : (int)$this->getState('category.id');

		// Get a level row instance.
		$table = &$this->getTable();

		// Attempt to load the row.
		$table->load($pk);

		// Check for a table object error.
		if ($error = $table->getError()) {
			$this->setError($error);
			$false = false;
			return $false;
		}

		// Prime required properties.
		if (empty($table->id)) {
			$table->parent_id	= $this->getState('category.parent_id');
			$table->extension	= $this->getState('category.extension');
		}

		// Convert the params field to an array.
		//$registry = new JRegistry();
		//$registry->loadJSON($table->params);
		//$table->params = $registry->toArray();

		$result = JArrayHelper::toObject($table->getProperties(1), 'JObject');

		return $result;
	}
	/**
	 * Method to get the row form.
	 *
	 * @return	mixed	JForm object on success, false on failure.
	 * @since	1.6
	 */
	public function getForm()
	{
		// Initialize variables.
		$app = &JFactory::getApplication();

		// Get the form.
	
		$form = $this->_getForm('category', 'com_ammvc_categories.category', array('control' => 'jform'));
		// Check for an error.
		if (JError::isError($form)) {
			$this->setError($form->getMessage());
			return false;
		}

		// Set the access control rules field compoennt value.
		//$form->setFieldAttribute('rules', 'component', $this->getState('category.extension'));

		// Check the session for previously entered form data.
		$data = $app->getUserState('com_ammvc_categories.edit.category.data', array());

		// Bind the form data if present.
		if (!empty($data)) {
			$form->bind($data);
		}
	
		return $form;
	}


	/**
	 * Method to get a form object.
	 *
	 * @param	string		$xml		The form data. Can be XML string if file flag is set to false.
	 * @param	array		$options	Optional array of parameters.
	 * @param	boolean		$clear		Optional argument to force load a new form.
	 * @return	mixed		JForm object on success, False on error.
	 */
	private function &_getForm($xml, $name = 'form', $options = array(), $clear = false)
	{
		
		global $alt_libdir;
			
		// Handle the optional arguments.
		
		$options['control']	= JArrayHelper::getValue($options, 'control', false);
		// Create a signature hash.
		$hash = md5($xml.serialize($options));

		// Check if we can use a previously loaded form.
		if (isset($this->_forms[$hash]) && !$clear) {
			return $this->_forms[$hash];
		}

		// Get the form.

		JLoader::import('joomla.form.form', $alt_libdir);

		JForm::addFormPath(JPATH_COMPONENT_ADMINISTRATOR.'/models/forms');
		JForm::addFieldPath(JPATH_COMPONENT_ADMINISTRATOR.'/models/fields');

		$form = JForm::getInstance($name, $xml, $options, false);
		// Check for an error.
		if (JError::isError($form)) {
			$this->setError($form->getMessage());
			$false = false;
			return $form;
		}


		// Store the form for later.
		$this->_forms[$hash] = $form;

		return $form;
	}	
	
	/**
	 * Method to save the form data.
	 *
	 * @param	array	The form data.
	 * @return	boolean	True on success.
	 * @since	1.6
	 */
	public function save($data)
	{
		$pk		= (!empty($data['id'])) ? $data['id'] : (int)$this->getState('category.id');
		if ($pk) $data['id'] = $pk;		
		$isNew	= true;

		// Get a row instance.
		$table = &$this->getTable();

		// Load the row if saving an existing category.
		if ($pk > 0) {
			$table->load($pk);
			$isNew = false;
			
		}

		// Set the new parent id if set.
		if ($table->parent_id != $data['parent_id']) {
			$table->setLocation($data['parent_id'], 'last-child');
		}

		// Bind the data.
		if (!$table->bind($data)) {
			$this->setError(JText::sprintf('JTable_Error_Bind_failed', $table->getError()));
			return false;
		}
		$jv = new JVersion(); 
        if($jv->RELEASE > 1.5) {
		    // Bind the rules.
		    if (isset($data['rules'])) {
			    $rules = new JRules($data['rules']);
			    $table->setRules($rules);
		    }
        }

		// Check the data.
		if (!$table->check()) {
			$this->setError($table->getError());
			return false;
		}

		// Store the data.
		if (!$table->store()) {
			$this->setError($table->getError());
			return false;
		}

		// Rebuild the tree path.
		if (!$table->rebuildPath($table->id)) {
			$this->setError($table->getError());
			return false;
		}

		$this->setState('category.id', $table->id);

		return true;
	}

	/**
	 * Method to delete rows.
	 *
	 * @param	array	An array of item ids.
	 *
	 * @return	boolean	Returns true on success, false on failure.
	 */
	public function delete($pks)
	{
		$pks = (array) $pks;

		// Get a row instance.
		$table = &$this->getTable();
		
		// Iterate the items to delete each one.
		foreach ($pks as $pk) {
			
			if (!$table->delete((int) $pk)) {
				
				$this->setError($table->getError());
				return false;
			}
		}

		return true;
	}

	/**
	 * Method to publish categories.
	 *
	 * @param	array	The ids of the items to publish.
	 * @param	int		The value of the published state
	 *
	 * @return	boolean	True on success.
	 */
	public function publish($pks, $value = 1)
	{
		$pks = (array) $pks;

		// Get the current user object.
		$user = &JFactory::getUser();

		// Get an instance of the table row.
		$table = &$this->getTable();

		// Attempt to publish the items.
		if (!$table->publish($pks, $value, $user->get('id'))) {
			$this->setError($table->getError());
			return false;
		}

		return true;
	}

	/**
	 * Method to adjust the ordering of a row.
	 *
	 * @param	int		The numeric id of the row to move.
	 * @param	integer	Increment, usually +1 or -1
	 * @return	boolean	False on failure or error, true otherwise.
	 */
	public function ordering($pk, $direction = 0)
	{
		// Sanitize the id and adjustment.
		$pk	= (!empty($pk)) ? $pk : (int) $this->getState('category.id');

		// If the ordering direction is 0 then we aren't moving anything.
		if ($direction == 0) {
			return true;
		}

		// Get a row instance.
		$table = &$this->getTable();

		// Move the row down in the ordering.
		if ($direction > 0) {
			if (!$table->orderDown($pk)) {
				$this->setError($table->getError());
				return false;
			}
		} else {
			if (!$table->orderUp($pk)) {
				$this->setError($table->getError());
				return false;
			}
		}

		return true;
	}

	/**
	 * Method rebuild the entire nested set tree.
	 *
	 * @return	boolean	False on failure or error, true otherwise.
	 */
	public function rebuild()
	{
		// Get an instance of the table obejct.
		$table = &$this->getTable();

		if (!$table->rebuild()) {
			$this->setError($table->getError());
			return false;
		}

		return true;
	}

	/**
	 * Method to perform batch operations on a category or a set of categories.
	 *
	 * @param	array	An array of commands to perform.
	 * @param	array	An array of category ids.
	 *
	 * @return	boolean	Returns true on success, false on failure.
	 */
	function batch($commands, $pks)
	{
		// Sanitize user ids.
		$pks = array_unique($pks);
		JArrayHelper::toInteger($pks);

		// Remove any values of zero.
		if (array_search(0, $pks, true)) {
			unset($pks[array_search(0, $pks, true)]);
		}

		if (empty($pks)) {
			$this->setError(JText::_('JError_No_items_selected'));
			return false;
		}

		$done = false;

		if (!empty($commands['assetgroup_id'])) {
			if (!$this->_batchAccess($commands['assetgroup_id'], $pks)) {
				return false;
			}
			$done = true;
		}

		if (!empty($commands['category_id'])) {
			$cmd = JArrayHelper::getValue($commands, 'move_copy', 'c');

			if ($cmd == 'c' && !$this->_batchCopy($commands['category_id'], $pks)) {
				return false;
			} else if ($cmd == 'm' && !$this->_batchMove($commands['category_id'], $pks)) {
				return false;
			}
			$done = true;
		}

		if (!$done) {
			$this->setError('Categories_Error_Insufficient_batch_information');
			return false;
		}

		return true;
	}

	/**
	 * Batch access level changes for a group of rows.
	 *
	 * @param	int		The new value matching an Asset Group ID.
	 * @param	array	An array of row IDs.
	 *
	 * @return	booelan	True if successful, false otherwise and internal error is set.
	 */
	protected function _batchAccess($value, $pks)
	{
		$table = &$this->getTable();
		foreach ($pks as $pk) {
			$table->reset();
			$table->load($pk);
			$table->access = (int) $value;
			if (!$table->store()) {
				$this->setError($table->getError());
				return false;
			}
		}

		return true;
	}

	/**
	 * Batch move categories to a new parent.
	 *
	 * @param	int		The new category or sub-category.
	 * @param	array	An array of row IDs.
	 *
	 * @return	booelan	True if successful, false otherwise and internal error is set.
	 */
	protected function _batchMove($value, $pks)
	{
	}

	/**
	 * Batch copy categories to a new parent.
	 *
	 * @param	int		The new category or sub-category.
	 * @param	array	An array of row IDs.
	 *
	 * @return	booelan	True if successful, false otherwise and internal error is set.
	 */
	protected function _batchCopy($value, $pks)
	{
	}

	/**
	 * Method to check-out a row for editing.
	 *
	 * @param	int		$pk	The numeric id of the primary key.
	 *
	 * @return	boolean	False on failure or error, true otherwise.
	 */
	public function checkout($pk = null)
	{
		// Only attempt to check the row in if it exists.
		if ($pk) {
			// Get a row instance.
			$table = &$this->getTable();

			// Get the current user object.
			$user = &JFactory::getUser();

			// Attempt to check the row out.
			if (!$table->checkout($user->get('id'), $pk)) {
				$this->setError($table->getError());
				return false;
			}
		}

		return true;
	}

	/**
	 * Method to checkin a row.
	 *
	 * @param	integer	$pk The numeric id of the primary key.
	 *
	 * @return	boolean	False on failure or error, true otherwise.
	 */
	public function checkin($pk = null)
	{
		// Only attempt to check the row in if it exists.
		
		if ($pk) {
			$user = JFactory::getUser();


			// Get an instance of the row to checkin.
			$table = $this->getTable();
			if (!$table->load($pk)) {
				$this->setError($table->getError());
				return false;
			}

			// Check if this is the user having previously checked out the row.
			if ($table->checked_out > 0 && $table->checked_out != $user->get('id')) {
				
				$this->setError(JText::_('JError_Checkin_user_mismatch'));
				return false;
				
			}

			// Attempt to check the row in.
			if (!$table->checkin($pk)) {
				$this->setError($table->getError());
				return false;
			}
		}

		return true;
	}	
	
	/**
	 * Method to validate the form data.
	 *
	 * @param	object		$form		The form to validate against.
	 * @param	array		$data		The data to validate.
	 * @return	mixed		Array of filtered data if valid, false otherwise.
	 * @since	1.1
	 */
	public function validate($form, $data)
	{
		// Filter and validate the form data.
		$data	= $form->filter($data);
		$return	= $form->validate($data);

		// Check for an error.
		if (JError::isError($return)) {
			$this->setError($return->getMessage());
			return false;
		}

		// Check the validation results.
		if ($return === false) {
			// Get the validation messages from the form.
			foreach ($form->getErrors() as $message) {
				$this->setError($message);
			}

			return false;
		}

		return $data;
	}	
}
