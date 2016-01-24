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
 * @version     3.1.10 2013-09-12
 * @since       1.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport('joomla.application.component.controlleradmin');

/**
 * Events list controller class.
 */
class iCagendaControllerEvents extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'event', $prefix = 'iCagendaModel', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}

	/**
     * Method to save the submitted ordering values for records via AJAX.
     *
     * @return    void
     *
     * @since   3.0
     */

    public function saveOrderAjax()
    {
        // Get the input
        $input = JFactory::getApplication()->input;
        $pks = $input->post->get('cid', array(), 'array');
		$order = $input->post->get('order', array(), 'array');

        // Sanitize the input
		JArrayHelper::toInteger($pks);
        JArrayHelper::toInteger($order);

        // Get the model
		$model = $this->getModel();

        // Save the ordering
        $return = $model->saveorder($pks, $order);

        if ($return)
        {
            echo "1";
        }

        // Close the application
        JFactory::getApplication()->close();
	}

	public function __construct($config = array())
	{
		parent::__construct($config);

		$this->registerTask('unapprove', 'approve');
    }

	/**
	 * Method to approve an event.
	 *
	 * @return  void
	 *
	 * @since   3.2
	 */
	public function approve()
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $input = JFactory::getApplication()->input;
		$ids = $input->post->get('cid', array(), 'array');

		if (empty($ids))
		{
			JError::raiseWarning(500, JText::_('JERROR_NO_ITEMS_SELECTED'));
		}
		else
		{
			// Get the model.
			$model = $this->getModel();

			// Change the state of the records.
			if (!$model->approve($ids))
			{
				JError::raiseWarning(500, $model->getError());
			}
			else
			{
				$this->setMessage(JText::plural('COM_ICAGENDA_N_EVENTS_APPROVED', count($ids)));
			}
		}

		$this->setRedirect('index.php?option=com_icagenda&view=events');
	}
}
