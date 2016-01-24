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
 * @version     3.5.13 2015-12-02
 * @since       3.5.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * Registrations list controller class.
 *
 * @since	3.5.0
 */
class icagendaControllerRegistrations extends JControllerLegacy
{
	/**
	 * @var    string  The context for persistent state.
	 *
	 * @since  3.5.0
	 */
	protected $context = 'com_icagenda.registrations';

	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    The name of the model.
	 * @param   string  $prefix  The prefix for the model class name.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JModel
	 *
	 * @since   3.5.0
	 */
	public function getModel($name = 'Registrations', $prefix = 'iCagendaModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}

	/**
	 * Display method for the raw track data.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   array    $urlparams  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  JController  This object to support chaining.
	 *
	 * @since   3.5.0
	 * @todo    This should be done as a view, not here!
	 */
	public function display($cachable = false, $urlparams = false)
	{
		// Get the document object.
		$document	= JFactory::getDocument();
		$vName		= 'registrations';
		$vFormat	= 'raw';

		// Get and render the view.
		if ($view = $this->getView($vName, $vFormat))
		{
			// Get the model for the view.
			$model = $this->getModel($vName);

			// Load the filter state.
			$app = JFactory::getApplication();

			$search = $app->getUserState($this->context . '.filter.search');
			$model->setState('filter.search', $search);

			$published = $app->getUserState($this->context . '.filter.state');
			$model->setState('filter.state', $published);

			$categoryId = $app->getUserState($this->context . '.filter.categories');
			$model->setState('filter.categories', $categoryId);

			$eventId = $app->getUserState($this->context . '.filter.events');
			$model->setState('filter.events', $eventId);

			$date = $app->getUserState($this->context . '.filter.dates');
			$model->setState('filter.dates', $date);

			$model->setState('list.limit', 0);
			$model->setState('list.start', 0);

			$input = JFactory::getApplication()->input;
			$form  = $input->get('jform', array(), 'array');

			$model->setState('event_title', $form['event_title']);
			$model->setState('date', $form['date']);
			$model->setState('tickets', $form['tickets']);
			$model->setState('name', $form['name']);
			$model->setState('email', $form['email']);
			$model->setState('phone', $form['phone']);
			$model->setState('customfields', $form['customfields']);
			$model->setState('notes', $form['notes']);
			$model->setState('status', $form['status']);
			$model->setState('created', $form['created']);

			$model->setState('basename', $form['basename']);
			$model->setState('separator', $form['separator']);
			$model->setState('compressed', $form['compressed']);

			$config = JFactory::getConfig();
			$cookie_domain = $config->get('cookie_domain', '');
			$cookie_path = $config->get('cookie_path', '/');

			// Joomla 3
			if (version_compare(JVERSION, '3.0', 'ge'))
			{
				setcookie(JApplicationHelper::getHash($this->context . '.event_title'), $form['event_title'], time() + 365 * 86400, $cookie_path, $cookie_domain);
				setcookie(JApplicationHelper::getHash($this->context . '.date'), $form['date'], time() + 365 * 86400, $cookie_path, $cookie_domain);
				setcookie(JApplicationHelper::getHash($this->context . '.tickets'), $form['tickets'], time() + 365 * 86400, $cookie_path, $cookie_domain);
				setcookie(JApplicationHelper::getHash($this->context . '.name'), $form['name'], time() + 365 * 86400, $cookie_path, $cookie_domain);
				setcookie(JApplicationHelper::getHash($this->context . '.email'), $form['email'], time() + 365 * 86400, $cookie_path, $cookie_domain);
				setcookie(JApplicationHelper::getHash($this->context . '.phone'), $form['phone'], time() + 365 * 86400, $cookie_path, $cookie_domain);
				setcookie(JApplicationHelper::getHash($this->context . '.customfields'), $form['customfields'], time() + 365 * 86400, $cookie_path, $cookie_domain);
				setcookie(JApplicationHelper::getHash($this->context . '.notes'), $form['notes'], time() + 365 * 86400, $cookie_path, $cookie_domain);
				setcookie(JApplicationHelper::getHash($this->context . '.status'), $form['status'], time() + 365 * 86400, $cookie_path, $cookie_domain);
				setcookie(JApplicationHelper::getHash($this->context . '.created'), $form['created'], time() + 365 * 86400, $cookie_path, $cookie_domain);

				setcookie(JApplicationHelper::getHash($this->context . '.basename'), $form['basename'], time() + 365 * 86400, $cookie_path, $cookie_domain);
				setcookie(JApplicationHelper::getHash($this->context . '.separator'), $form['separator'], time() + 365 * 86400, $cookie_path, $cookie_domain);
				setcookie(JApplicationHelper::getHash($this->context . '.compressed'), $form['compressed'], time() + 365 * 86400, $cookie_path, $cookie_domain);
			}
			// Joomla 2.5
			else
			{
				setcookie(JApplication::getHash($this->context.'.basename'), $form['basename'], time() + 365 * 86400, $cookie_path, $cookie_domain);
				setcookie(JApplication::getHash($this->context.'.separator'), $form['separator'], time() + 365 * 86400, $cookie_path, $cookie_domain);
				setcookie(JApplication::getHash($this->context.'.compressed'), $form['compressed'], time() + 365 * 86400, $cookie_path, $cookie_domain);
			}

			// Push the model into the view (as default).
			$view->setModel($model, true);

			// Push document object into the view.
			$view->document = $document;

			$view->display();
		}
	}
}
