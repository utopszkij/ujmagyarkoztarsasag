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
 * @version 	3.5.12 2015-09-25
 * @since       3.2.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport('joomla.application.component.helper');

/**
 * View class Site - Add an Event - iCagenda
 */
class iCagendaViewSubmit extends JViewLegacy
{
	// TODO: check and remove
	protected $return_page;

	protected $state;
	protected $item;
	protected $form;

	protected $params;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		// Initialiase variables.
		$this->state	= $this->get('State');
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');

		if (JRequest::get( 'POST' )) $this->get('data');

		// loading params
		$app = JFactory::getApplication();
		$params = $app->getParams();

		$this->template = $params->get('template');
		$this->title = $params->get('title');
		$this->format = $params->get('format');
		$this->copy = $params->get('copy');
		$this->submit = "media/com_icagenda/js/jsevt.js";
		$this->submit_imageDisplay			= $params->get('submit_imageDisplay', 1);
		$this->submit_periodDisplay			= $params->get('submit_periodDisplay', 1);
		$this->submit_weekdaysDisplay		= $params->get('submit_weekdaysDisplay', 1);
		$this->submit_datesDisplay			= $params->get('submit_datesDisplay', 1);
		$this->submit_displaytimeDisplay	= $params->get('submit_displaytimeDisplay', 0);
		$this->submit_shortdescDisplay		= $params->get('submit_shortdescDisplay', 1);
		$this->submit_descDisplay			= $params->get('submit_descDisplay', 1);
		$this->submit_metadescDisplay		= $params->get('submit_metadescDisplay', 0);
		$this->submit_venueDisplay			= $params->get('submit_venueDisplay', 1);
		$this->submit_emailDisplay			= $params->get('submit_emailDisplay', 1);
		$this->submit_phoneDisplay			= $params->get('submit_phoneDisplay', 1);
		$this->submit_websiteDisplay		= $params->get('submit_websiteDisplay', 1);
		$this->submit_customfieldsDisplay	= $params->get('submit_customfieldsDisplay', 1);
		$this->submit_fileDisplay			= $params->get('submit_fileDisplay', 1);
		$this->submit_gmapDisplay			= $params->get('submit_gmapDisplay', 1);
		$this->submit_regoptionsDisplay		= $params->get('submit_regoptionsDisplay', 1);
		$this->statutReg					= $params->get('statutReg', 0);
		$this->ShortDescLimit				= $params->get('ShortDescLimit', '160');
		$this->submit_imageMaxSize			= $params->get('submit_imageMaxSize', '800');
		$this->submit_captcha				= $params->get('submit_captcha', 0);
		$this->submit_form_validation		= $params->get('submit_form_validation', '');

		$this->pageclass_sfx	= htmlspecialchars($params->get('pageclass_sfx'));

		$this->params = $this->state->get('params');
		$this->iCparams = $this->params;

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// ASSIGN (deprecated)
//		$this->assignRef('params', $iCparams);

		$this->_prepareDocument();

		icagendaInfo::commentVersion();

		parent::display($tpl);

		icagendaEvents::isListOfEvents();
		icagendaForm::loadDateTimePickerJSLanguage();

		$jlayout		= JRequest::getCmd('layout', '');
		$layouts_array	= array('event', 'registration');
		$layout			= in_array($jlayout, $layouts_array) ? $jlayout : '';

		if ( ! $layout || $layout == 'submit')
		{
			JHtml::stylesheet( 'com_icagenda/icagenda.css', false, true );
			JHtml::stylesheet( 'com_icagenda/jquery-ui-1.8.17.custom.css', false, true );
		}
	}


	protected function _prepareDocument()
	{
		$app		= JFactory::getApplication();
		$menus		= $app->getMenu();
		$pathway 	= $app->getPathway();
		$title 		= null;

		$menu = $menus->getActive();

		if ($menu)
		{
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		}
		else
		{
			$this->params->def('page_heading', JText::_('JGLOBAL_ARTICLES'));
		}

		$title = $this->params->get('page_title', '');

		if (empty($title))
		{
			$title = $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 1)
		{
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2)
		{
			$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
		}

		$this->document->setTitle($title);

		if ($this->params->get('menu-meta_description', ''))
		{
			$this->document->setDescription($this->params->get('menu-meta_description', ''));
		}

		if ($this->params->get('menu-meta_keywords', ''))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords', ''));
		}

		if ($app->getCfg('MetaTitle') == '1'
			&& $this->params->get('menupage_title', ''))
		{
			$this->document->setMetaData('title', $this->params->get('page_title', ''));
		}
	}
}
