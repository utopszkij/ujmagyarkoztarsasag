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
 * @version     3.5.6 2015-06-27
 * @since       1.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.path' );

// Access check.
if (JFactory::getUser()->authorise('core.admin', 'com_icagenda'))
{
	JToolBarHelper::preferences('com_icagenda');
}

/**
 * View class for a list of iCagenda.
 */
class iCagendaViewicagenda extends JViewLegacy
{
	/**
	 * Display the view
	 * @since	1.0
	 */
	public function display($tpl = null)
	{
		$document = JFactory::getDocument();

		// Joomla 2.5
		if (version_compare(JVERSION, '3.0', 'lt'))
		{
			JHtml::stylesheet('com_icagenda/template.j25.css', false, true);
			JHtml::stylesheet('com_icagenda/icagenda-back.j25.css', false, true);

			JHTML::_('behavior.tooltip');
			JHTML::_('behavior.modal');
			$document->addScript( JURI::root( true ) . '/media/com_icagenda/js/template.js' );
			jimport( 'joomla.filesystem.path' );
		}
		// Joomla 3
		else
		{
 			JHtml::_('behavior.modal');
		}

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
	 *
	 * @since	1.0
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT . '/helpers/icagenda.php';

		$document	= JFactory::getDocument();
		$app		= JFactory::getApplication();

		$state	= $this->get('State');
		$canDo	= iCagendaHelper::getActions($state->get('filter.category_id'));

		//JToolBarHelper::title(JText::_('COM_ICAGENDA_TITLE_ICAGENDA_IMAGE'));
		// Set Title
		if (version_compare(JVERSION, '3.0', 'lt'))
		{
			JToolBarHelper::title(JText::_('COM_ICAGENDA_TITLE_ICAGENDA_IMAGE'));
		}
		else
		{
			$logo_icagenda_url = '../media/com_icagenda/images/iconicagenda36.png';

			if (file_exists($logo_icagenda_url))
			{
				$logo_icagenda = '<img src="' . $logo_icagenda_url . '" height="36px" alt="iCagenda" />';
			}
			else
			{
				$logo_icagenda = 'iCagenda :: ' . JText::_('COM_ICAGENDA_TITLE_ICAGENDA') . '';
			}

			JToolBarHelper::title($logo_icagenda, 'icagenda');
		}

		$icTitle = JText::_('COM_ICAGENDA_TITLE_ICAGENDA');

		$sitename = $app->getCfg('sitename');
		$title = $app->getCfg('sitename') . ' - ' . JText::_('JADMINISTRATION') . ' - iCagenda: ' . $icTitle;
		$document->setTitle($title);
	}

	/**
	 * Save iCagenda Params
	 *
	 * Update Database
	 *
	 * @since   3.3.8
	 */
	public function saveDefault($var, $name, $value)
	{
		if ($var)
		{
			$params[$name] = $value;

			$this->updateParams( $params );
		}
	}

	/**
	 * Update iCagenda Params
	 *
	 * Update Database
	 *
	 * @since   3.3.8
	 */
	protected function updateParams($params_array)
	{
		// read the existing component value(s)
		$db = JFactory::getDbo();
		$db->setQuery('SELECT params FROM #__icagenda WHERE id = "3"');
		$params = json_decode( $db->loadResult(), true );

		// add the new variable(s) to the existing one(s)
		foreach ( $params_array as $name => $value )
		{
			$params[ (string) $name ] = $value;
		}

		// store the combined new and existing values back as a JSON string
		$paramsString = json_encode( $params );
		$db->setQuery('UPDATE #__icagenda SET params = ' .
		$db->quote( $paramsString ) . ' WHERE id = "3"' );
		$db->query();
	}
}
