<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      doorknob
 * @link        http://www.joomlic.com
 *
 * @version     3.5.4 2015-04-02
 * @since       3.4.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * View class Admin - List of Features - iCagenda.
 */
class iCagendaViewFeatures extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 *
	 * @since	3.4.0
	 */
	public function display($tpl = null)
	{
		// Joomla 2.5
		if (version_compare(JVERSION, '3.0', 'lt'))
		{
			jimport( 'joomla.environment.request' );

			JHtml::stylesheet( 'com_icagenda/icagenda-back.j25.css', false, true );
		}

		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));

			return false;
		}

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal')
		{
			$this->addToolbar();

			if(version_compare(JVERSION, '3.0', 'ge'))
			{
				$this->sidebar = JHtmlSidebar::render();
			}
		}

		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	3.4.0
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.DS.'helpers'.DS.'icagenda.php';

		$state	= $this->get('State');
		$user		= JFactory::getUser();
		$userId		= $user->get('id');
		$canDo		= iCagendaHelper::getActions();

		// Set Title
		if(version_compare(JVERSION, '3.0', 'lt'))
		{
			JToolBarHelper::title('iCagenda - ' . JText::_('COM_ICAGENDA_TITLE_FEATURES'), 'features.png');
		}
		else
		{
			JToolBarHelper::title('iCagenda <span style="font-size:14px;">- ' . JText::_('COM_ICAGENDA_TITLE_FEATURES') . '</span>', 'folder');
		}

		$icTitle = JText::_('COM_ICAGENDA_TITLE_FEATURES');

		$document	= JFactory::getDocument();
		$app		= JFactory::getApplication();
		$sitename = $app->getCfg('sitename');
		$title = $app->getCfg('sitename') . ' - ' . JText::_('JADMINISTRATION') . ' - iCagenda: ' . $icTitle;
		$document->setTitle($title);

		//Check if the form exists before showing the add/edit buttons
		$formPath = JPATH_COMPONENT_ADMINISTRATOR.'/views/feature';

		if (file_exists($formPath))
		{
			if ($canDo->get('core.create'))
			{
				JToolBarHelper::addNew('feature.add','JTOOLBAR_NEW');
			}

			if ($canDo->get('core.edit'))
			{
				JToolBarHelper::editList('feature.edit','JTOOLBAR_EDIT');
			}
		}

		if ($canDo->get('core.edit.state'))
		{
			if (isset($this->items[0]->state))
			{
				JToolBarHelper::divider();
				JToolBarHelper::custom('features.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
				JToolBarHelper::custom('features.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
			}
			else
			{
				//If this component does not use state then show a direct delete button as we can not trash
				JToolBarHelper::deleteList('', 'features.delete','JTOOLBAR_DELETE');
			}

			if (isset($this->items[0]->state))
			{
				JToolBarHelper::divider();
				JToolBarHelper::archiveList('features.archive','JTOOLBAR_ARCHIVE');
			}

			if (isset($this->items[0]->checked_out))
			{
				JToolBarHelper::custom('features.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
			}
		}

		//Show trash and delete for components that uses the state field
		if (isset($this->items[0]->state))
		{
			if ($state->get('filter.state') == -2 && $canDo->get('core.delete'))
			{
				JToolBarHelper::deleteList('', 'features.delete','JTOOLBAR_EMPTY_TRASH');
				JToolBarHelper::divider();
			}
			elseif ($canDo->get('core.edit.state'))
			{
				JToolBarHelper::trash('features.trash','JTOOLBAR_TRASH');
				JToolBarHelper::divider();
			}
		}

		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::preferences('com_icagenda');
		}

		if(version_compare(JVERSION, '3.0', 'ge'))
		{
			JHtmlSidebar::setAction('index.php?option=com_icagenda&view=features');

			JHtmlSidebar::addFilter(
				JText::_('JOPTION_SELECT_PUBLISHED'),
				'filter_published',
				JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.state'), true)
			);
		}
	}
}
