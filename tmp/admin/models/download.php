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
 * @version     3.5.0 2015-02-05
 * @since       3.5.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

// Joomla 2.5 import
jimport('joomla.application.component.modelform');

/**
 * Download model.
 *
 * @since	3.5.0
 */
class icagendaModelDownload extends JModelForm
{
	protected $_context = 'com_icagenda.registrations';

	/**
	 * Auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return  void
	 *
	 * @since   3.5.0
	 */
	protected function populateState()
	{
		// Joomla 3
		if (version_compare(JVERSION, '3.0', 'ge'))
		{
			$input = JFactory::getApplication()->input;

			$basename = $input->cookie->getString(JApplicationHelper::getHash($this->_context . '.basename'), '__SITE__');
			$this->setState('basename', $basename);

			$compressed = $input->cookie->getInt(JApplicationHelper::getHash($this->_context . '.compressed'), 1);
			$this->setState('compressed', $compressed);
		}

		// Joomla 2.5
		else
		{
			$basename = JRequest::getString(JApplication::getHash($this->_context.'.basename'), '__SITE__', 'cookie');
			$this->setState('basename', $basename);

			$compressed = JRequest::getInt(JApplication::getHash($this->_context.'.compressed'), 1, 'cookie');
			$this->setState('compressed', $compressed);
		}
	}

	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  mixed  A JForm object on success, false on failure
	 *
	 * @since   3.5.0
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_icagenda.download', 'download', array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 *
	 * @since   3.5.0
	 */
	protected function loadFormData()
	{
		$data = array(
			'basename'		=> $this->getState('basename'),
			'compressed'	=> $this->getState('compressed')
		);

		// Joomla 3
		if (version_compare(JVERSION, '3.0', 'ge'))
		{
			$this->preprocessData('com_icagenda.download', $data);
		}

		return $data;
	}
}
