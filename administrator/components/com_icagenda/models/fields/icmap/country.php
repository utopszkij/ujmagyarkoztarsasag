<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril RezŽ, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril RezŽ (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     3.5.0 2015-02-25
 * @since       1.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');

/**
 * Returns Country from Google Maps address auto-complete field.
 */
class JFormFieldiCmap_country extends JFormField
{
	protected $type='icmap_country';

	protected function getInput()
	{
		$session = JFactory::getSession();
		$ic_submit_country = $session->get('ic_submit_country', '');

		$country_value = $ic_submit_country ? $ic_submit_country : $this->value;

		$class = isset($this->class) ? ' class="' . $this->class . '"' : '';

		$html = '<div class="clr"></div>';
		$html.= '<label class="icmap-label">' . JText::_('COM_ICAGENDA_FORM_LBL_EVENT_COUNTRY') . '</label> <input name="' . $this->name . '" id="country" type="text"' . $class . ' value="' . $country_value . '" />';

		// clear the data so we don't process it again
		$session->clear('ic_submit_country');

		return $html;
	}
}
