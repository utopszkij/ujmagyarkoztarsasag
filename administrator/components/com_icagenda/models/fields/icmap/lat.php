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
 * @version     3.5.0 2015-02-15
 * @since       1.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');

/**
 * Returns Latitude from Google Maps address auto-complete field.
 */
class JFormFieldiCmap_lat extends JFormField
{
	protected $type='icmap_lat';

	protected function getInput()
	{
		// Check if coords set (deprecated)
		$id = JRequest::getVar('id');

		$class = isset($this->class) ? ' class="' . $this->class . '"' : '';

		if (isset($id))
		{
			$db	= JFactory::getDBO();
			$db->setQuery(
				'SELECT a.coordinate' .
				' FROM #__icagenda_events AS a' .
				' WHERE a.id = '.(int) $id
			);

			$coords = $db->loadResult();
		}
		else
		{
			$coords = NULL;
		}

		$session = JFactory::getSession();
		$ic_submit_lat = $session->get('ic_submit_lat', '');

		$lat_value = $ic_submit_lat ? $ic_submit_lat : $this->value;

		if ($coords != NULL
			&& $lat_value == '0.0000000000000000')
		{
			$ex			= explode(', ', $coords);
			$lat_value	= $ex[0];
		}
		elseif ($lat_value != '0.0000000000000000')
		{
			$lat_value	= $lat_value;
		}
		else
		{
			$lat_value	= NULL;
		}

		$html= '<div class="clr"></div>';
		$html.= '<label class="icmap-label">' . JText::_('COM_ICAGENDA_GOOGLE_MAPS_LATITUDE_LBL') . '</label> <input name="' . $this->name . '" id="lat" type="text"' . $class . ' value="' . $lat_value . '"/>';

		// clear the data so we don't process it again
		$session->clear('ic_submit_lat');

		return $html;
	}
}

