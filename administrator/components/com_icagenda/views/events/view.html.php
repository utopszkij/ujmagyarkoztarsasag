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
 * @version     3.5.6 2015-06-22
 * @since       1.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * View class Admin - List of Events - iCagenda.
 */
class iCagendaViewEvents extends JViewLegacy
{
	protected $params;
	protected $state;
	protected $items;
	protected $pagination;
	protected $categories;
	protected $upcoming;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$app = JFactory::getApplication();

		// Joomla 2.5
		if (version_compare(JVERSION, '3.0', 'lt'))
		{
			jimport( 'joomla.environment.request' );

			JHtml::stylesheet( 'com_icagenda/icagenda-back.j25.css', false, true );
		}

		$this->params		= JComponentHelper::getParams('com_icagenda');
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');

		$this->categories	= $this->get('Categories');
		$this->upcoming		= $this->get('Upcoming');
		$this->itemids		= $this->get('MenuItemID');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$icagenda_categories = class_exists('icagendaCategories') ? icagendaCategories::getList('1') : false;

		if ( ! $icagenda_categories)
		{
			$app->enqueueMessage( JText::_('COM_ICAGENDA_ALERT_NO_CATEGORY_PUBLISHED')
								. '<br /><br /><a class="btn btn-success" href="index.php?option=com_icagenda&view=category&layout=edit" >'
								. JText::_('COM_ICAGENDA_LEGEND_NEW_CATEGORY') . '</a>'
								. ' <a class="btn btn-inverse btn-mini" href="index.php?option=com_icagenda&view=categories" >'
								. JText::_('ICCATEGORIES')
								. '</a>', 'warning' );
		}

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal')
		{
			$this->addToolbar();

			if (version_compare(JVERSION, '3.0', 'ge'))
			{
				$this->sidebar = JHtmlSidebar::render();
			}
		}

		$canDo = iCagendaHelper::getActions();

		if (defined('IC_LIBRARY')
			&& $canDo->get('icagenda.access.events'))
		{
			parent::display($tpl);
		}
		else
		{
			if (defined('IC_LIBRARY')) $app->enqueueMessage(JText::_('JERROR_ALERTNOAUTHOR'), 'warning');
			$app->redirect(htmlspecialchars_decode('index.php?option=com_icagenda&view=icagenda'));
		}
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT . '/helpers/icagenda.php';

		$state					= $this->get('State');
		$user					= JFactory::getUser();
		$userId					= $user->get('id');
		$canDo					= iCagendaHelper::getActions();
		$icagenda_categories	= class_exists('icagendaCategories') ? icagendaCategories::getList() : false;

		// Set Title
		if (version_compare(JVERSION, '3.0', 'lt'))
		{
			JToolBarHelper::title('iCagenda - ' . JText::_('COM_ICAGENDA_TITLE_EVENTS'), 'events.png');
		}
		else
		{
			JToolBarHelper::title('iCagenda <span style="font-size:14px;">- ' . JText::_('COM_ICAGENDA_TITLE_EVENTS') . '</span>', 'calendar');
		}

		$icTitle = JText::_('COM_ICAGENDA_TITLE_EVENTS');

		$document		= JFactory::getDocument();
		$app			= JFactory::getApplication();
		$sitename		= $app->getCfg('sitename');
		$title			= $app->getCfg('sitename') . ' - ' . JText::_('JADMINISTRATION') . ' - iCagenda: ' . $icTitle;

		$document->setTitle($title);

		//Check if the form exists before showing the add/edit buttons
		$formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/event';

		if (file_exists($formPath)
			&& $icagenda_categories
			)
		{
			if ($canDo->get('core.create'))
			{
				JToolBarHelper::addNew('event.add','JTOOLBAR_NEW');
			}

			if ($canDo->get('core.edit') || $canDo->get('core.edit.own'))
			{
				JToolBarHelper::editList('event.edit');
			}

		}

		if ($canDo->get('core.edit.state')
			&& $icagenda_categories
			)
		{
			if (isset($this->items[0]->state))
			{
				JToolBarHelper::divider();
				JToolBarHelper::custom('events.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
				JToolBarHelper::custom('events.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
			}
			else
			{
				// If this component does not use state then show a direct delete button as we can not trash
				JToolBarHelper::deleteList('', 'events.delete','JTOOLBAR_DELETE');
			}

			if (isset($this->items[0]->state))
			{
				JToolBarHelper::divider();
				JToolBarHelper::archiveList('events.archive','JTOOLBAR_ARCHIVE');
			}

			if (isset($this->items[0]->checked_out))
			{
				JToolBarHelper::custom('events.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
			}
		}

		// Show trash and delete for components that uses the state field
		if (isset($this->items[0]->state)
			&& $icagenda_categories
			)
		{
			if ($state->get('filter.state') == -2 && $canDo->get('core.delete'))
			{
				JToolBarHelper::deleteList('', 'events.delete','JTOOLBAR_EMPTY_TRASH');
				JToolBarHelper::divider();
			}
			elseif ($canDo->get('core.edit.state'))
			{
				JToolBarHelper::trash('events.trash','JTOOLBAR_TRASH');
				JToolBarHelper::divider();
			}
		}

		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::preferences('com_icagenda');
		}

		if (version_compare(JVERSION, '3.0', 'ge'))
		{
			JHtmlSidebar::setAction('index.php?option=com_icagenda&view=events');

			JHtmlSidebar::addFilter(
				JText::_('COM_ICAGENDA_SELECT_STATE'),
				'filter_published',
				JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.state'), true)
			);
			JHtmlSidebar::addFilter(
				JText::_('COM_ICAGENDA_SELECT_CATEGORY'),
				'filter_category',
				JHtml::_('select.options', $this->get('Categories'), 'value', 'text', $this->state->get('filter.category'), true)
			);
			JHtmlSidebar::addFilter(
				JText::_('COM_ICAGENDA_SELECT_DATES'),
				'filter_upcoming',
				JHtml::_('select.options', $this->get('Upcoming'), 'value', 'text', $this->state->get('filter.upcoming'), true)
			);
			JHtmlSidebar::addFilter(
				JText::_('COM_ICAGENDA_SELECT_SITE_ITEMID'),
				'filter_site_itemid',
				JHtml::_('select.options', $this->get('MenuItemID'), 'value', 'text', $this->state->get('filter.site_itemid'), true)
			);
		}
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
		$input	= JFactory::getApplication()->input;
		$pks	= $input->post->get('cid', array(), 'array');
		$order	= $input->post->get('order', array(), 'array');

		// Sanitize the input
		JArrayHelper::toInteger($pks);
		JArrayHelper::toInteger($order);

		// Get the model
		$model	= $this->getModel();

		// Save the ordering
		$return	= $model->saveorder($pks, $order);

		if ($return)
		{
			echo "1";
		}

		// Close the application
		JFactory::getApplication()->close();
	}
}
