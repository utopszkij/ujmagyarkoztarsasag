<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     3.5.7 2015-07-16
 * @since       3.3.3
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport('joomla.application.component.modeladmin');


/**
 * iCagenda model.
 */
class iCagendaModelregistration extends JModelAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	3.3.3
	 */
	protected $text_prefix = 'COM_ICAGENDA';

	/**
	 * Method to test whether a record can be deleted.
	 *
	 * @param   object  $record  A record object.
	 *
	 * @return  boolean  True if allowed to delete the record. Defaults to the permission set in the component.
	 *
	 * @since   3.5.6
	 */
	protected function canDelete($record)
	{
		if ( ! empty($record->id))
		{
			if ($record->state != -2)
			{
				return false;
			}

			$user = JFactory::getUser();

			if ($user->authorise('core.delete'))
			{
				icagendaCustomfields::deleteData($record->id, 1);
				icagendaCustomfields::cleanData(1);

				return true;
			}
		}

		return false;
	}

	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	3.3.3
	 */
	public function getTable($type = 'Registration', $prefix = 'iCagendaTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		An optional array of data for the form to interogate.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	JForm	A JForm object on success, false on failure
	 * @since	3.3.3
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_icagenda.registration', 'registration',
								array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	3.3.3
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data_array = JFactory::getApplication()->getUserState('com_icagenda.edit.registration.data', array());

		if (empty($data_array))
		{
			$data = $this->getItem();
		}
		else
		{
			$data = new JObject;
			$data->setProperties($data_array);
		}

		return $data;
	}

	/**
	 * Method to save the form data.
	 *
	 * @param   array  $data  The form data.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since	3.5.6
	 */
	public function save($data)
	{
		$app	= JFactory::getApplication();
		$input	= $app->input;
		$date	= JFactory::getDate();
		$user	= JFactory::getUser();

//		if (empty($data['created'])) // not to be used, to leave created empty if before update to 3.5.7
//		{
//			$data['created'] = ( ! empty($data['modified'])) ? $data['modified'] : $date->toSql();
//		}

		// Set registration creator
		if (empty($data['created_by']))
		{
			$data['created_by'] = (int) $data['userid'];
		}

		// Set Params
		if (isset($data['params']) && is_array($data['params']))
		{
			// Convert the params field to a string.
			$parameter = new JRegistry;
			$parameter->loadArray($data['params']);
			$data['params'] = (string)$parameter;
		}

		if ($input->get('task') == 'delete')
		{
			icagendaCustomfields::deleteData($data['custom_fields'], $data['id'], 1);
			$app->enqueueMessage('Test', 'warning');
		}

		// Get Registration ID from the result back to the Table after saving.
		$table = $this->getTable();

		if ($table->save($data) === true)
		{
			$data['id'] = $table->id;
		}
		else
		{
			$data['id'] = null;
		}

		if (parent::save($data))
		{
			// Save Custom Fields to database
			if (isset($data['custom_fields']) && is_array($data['custom_fields']))
			{
				icagendaCustomfields::saveToData($data['custom_fields'], $data['id'], 1);
			}

			return true;
		}

		return false;
	}

	/**
	 * Method to get a single record.
	 *
	 * @param	integer	The id of the primary key.
	 *
	 * @return	mixed	Object on success, false on failure.
	 * @since	3.3.3
	 */
	public function getItem($pk = null)
	{
		if ($item = parent::getItem($pk))
		{
			// Do any procesing on fields here if needed
		}

		return $item;
	}

	/**
	 * Prepare and sanitise the table prior to saving.
	 *
	 * @since	3.3.3
	 */

	protected function prepareTable($table)
	{
		$date = JFactory::getDate();
		$user = JFactory::getUser();

		$table->name = htmlspecialchars_decode($table->name, ENT_QUOTES);

		if (empty($table->id))
		{
			// Set the values
			$table->created		= $date->toSql();
			$table->created_by	= $user->get('id');

			// Set ordering to the last item if not set
			if (empty($table->ordering))
			{
				$db = JFactory::getDbo();
				$query = $db->getQuery(true)
					->select('MAX(ordering)')
					->from($db->quoteName('#__icagenda_registration'));
				$db->setQuery($query);
				$max = $db->loadResult();

				$table->ordering = $max + 1;
			}
		}
		else
		{
			// Set the values
			$table->modified	= $date->toSql();
			$table->modified_by	= $user->get('id');
		}
	}
}
