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
 * @version     3.5.6 2015-06-10
 * @since       3.3.3
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * View class Admin - Registration Edit - iCagenda
 */
class iCagendaViewRegistration extends JViewLegacy
{
	protected $state;
	protected $item;
	protected $form;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		// Initialiase variables.
		$this->state	= $this->get('State');
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();

		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 */
	protected function addToolbar()
	{
		JRequest::setVar('hidemainmenu', true);

		$user		= JFactory::getUser();
		$isNew		= ($this->item->id == 0);

        if (isset($this->item->checked_out))
        {
		    $checkedOut	= ! ($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
        }
        else
        {
            $checkedOut = false;
        }

		$canDo		= iCagendaHelper::getActions();

		//JToolBarHelper::title(JText::_('COM_ICAGENDA_TITLE_CATEGORY'), 'category.png');
		// Set Title
		if (version_compare(JVERSION, '3.0', 'lt'))
		{
			JToolBarHelper::title($isNew ? 'iCagenda - ' . JText::_('COM_ICAGENDA_LEGEND_NEW_REGISTRATION') : 'iCagenda - ' . JText::_('COM_ICAGENDA_LEGEND_EDIT_REGISTRATION'), 'registration.png');
		}
		else
		{
			JToolBarHelper::title($isNew ? 'iCagenda <span style="font-size:14px;">- ' . JText::_('COM_ICAGENDA_LEGEND_NEW_REGISTRATION') . '</span>'  : 'iCagenda <span style="font-size:14px;">- ' . JText::_('COM_ICAGENDA_LEGEND_EDIT_REGISTRATION') . '</span>' , $isNew ? 'new' : 'pencil-2');
		}

		$icTitle	= $isNew ? JText::_('COM_ICAGENDA_LEGEND_NEW_REGISTRATION') : JText::_('COM_ICAGENDA_LEGEND_EDIT_REGISTRATION');

		$document	= JFactory::getDocument();
		$app		= JFactory::getApplication();
		$sitename	= $app->getCfg('sitename');
		$title		= $app->getCfg('sitename') . ' - ' . JText::_('JADMINISTRATION') . ' - iCagenda: ' . $icTitle;

		$document->setTitle($title);

		// If not checked out, can save the item.
		if ( ! $checkedOut && ($canDo->get('core.edit') || $canDo->get('core.edit.own') || $canDo->get('core.create')))
		{
			JToolBarHelper::apply('registration.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('registration.save', 'JTOOLBAR_SAVE');
		}

		if ( ! $checkedOut && ($canDo->get('core.create')))
		{
			JToolBarHelper::custom('registration.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
		}

		// If an existing item, can save to a copy.
		if ( ! $isNew && $canDo->get('core.create'))
		{
			JToolBarHelper::custom('registration.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
		}

		if (empty($this->item->id))
		{
			JToolBarHelper::cancel('registration.cancel', 'JTOOLBAR_CANCEL');
		}
		else
		{
			JToolBarHelper::cancel('registration.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}
