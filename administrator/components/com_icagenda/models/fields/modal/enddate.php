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
 * @version     3.5.10 2015-08-13
 * @since       2.0.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');

/**
 * Form Field to load a enddate datetime picker input
 *
 * @since	2.0.0
 */
class JFormFieldModal_enddate extends JFormField
{
	protected $type = 'modal_enddate';

	protected function getInput()
	{
		$class = ! empty($this->class) ? ' class="' . $this->class . '"' : '';

		$lang = JFactory::getLanguage();

		if ($lang->getTag() == 'fa-IR')
		{
			// Including fallback code for HTML5 non supported browsers.
			JHtml::_('jquery.framework');
			JHtml::_('script', 'system/html5fallback.js', false, true);

			$attributes = '';

			$html = JHtml::_('calendar', $this->value, $this->name, 'enddate_jalali', '%Y-%m-%d %H:%M:%S', $attributes);
		}
		else
		{
			$html ='<input type="text" id="enddate"' . $class . ' name="' . $this->name . '" value="' . $this->value . '"/>';
		}

		return $html;
	}
}
