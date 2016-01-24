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
 * @version     3.4.0 2014-07-02
 * @since       3.4.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

// iCagenda Class control (Joomla 2.5/3.x)
if (!class_exists('iCJView')) {
	if (version_compare(JVERSION,'3.0.0','ge')) {
		class iCJView extends JViewLegacy {};
	} else {
		jimport('joomla.application.component.view');
		class iCJView extends JView {};
	}
}

/**
 * View class Admin - Edit a Custom Field - iCagenda
 */
class iCagendaViewCustomfield extends iCJView
{
	protected $state;
	protected $item;
	protected $form;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
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
		    $checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
        }
        else
        {
            $checkedOut = false;
        }

		$canDo		= iCagendaHelper::getActions();

		// Set Title
		if(version_compare(JVERSION, '3.0', 'lt'))
		{
			JToolBarHelper::title($isNew ? 'iCagenda - ' . JText::_('COM_ICAGENDA_CUSTOMFIELD_LEGEND_NEW') : 'iCagenda - ' . JText::_('COM_ICAGENDA_CUSTOMFIELD_LEGEND_EDIT'), 'category.png');
		}
		else
		{
			JToolBarHelper::title($isNew ? 'iCagenda <span style="font-size:14px;">- ' . JText::_('COM_ICAGENDA_CUSTOMFIELD_LEGEND_NEW') . '</span>'  : 'iCagenda <span style="font-size:14px;">- ' . JText::_('COM_ICAGENDA_CUSTOMFIELD_LEGEND_EDIT') . '</span>' , $isNew ? 'new' : 'pencil-2');
		}

		$icTitle = $isNew ? JText::_('COM_ICAGENDA_CUSTOMFIELD_LEGEND_NEW') : JText::_('COM_ICAGENDA_CUSTOMFIELD_LEGEND_EDIT');

		$document	= JFactory::getDocument();
		$app		= JFactory::getApplication();
		$sitename	= $app->getCfg('sitename');
		$title		= $app->getCfg('sitename') . ' - ' . JText::_('JADMINISTRATION') . ' - iCagenda: ' . $icTitle;
		$document->setTitle($title);

		// If not checked out, can save the item.
		if (!$checkedOut && ($canDo->get('core.edit')||($canDo->get('core.create'))))
		{
			JToolBarHelper::apply('customfield.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('customfield.save', 'JTOOLBAR_SAVE');
		}

		if (!$checkedOut && ($canDo->get('core.create')))
		{
			JToolBarHelper::custom('customfield.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
		}

		// If an existing item, can save to a copy.
		if (!$isNew && $canDo->get('core.create'))
		{
			JToolBarHelper::custom('customfield.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
		}

		if (empty($this->item->id))
		{
			JToolBarHelper::cancel('customfield.cancel', 'JTOOLBAR_CANCEL');
		}
		else
		{
			JToolBarHelper::cancel('customfield.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}
