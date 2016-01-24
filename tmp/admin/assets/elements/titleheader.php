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
 * @version     3.5.4 2015-04-13
 * @since       3.5.4
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');


class JFormFieldTitleHeader extends JFormField
{
	protected $type = 'TitleHeader';

	protected function getInput()
	{
		return ' ';
	}

	protected function getLabel()
	{
    	$label = $this->element['label'];
		$label = $this->translateLabel ? JText::_($label) : $label;

    	$html = '<h3>' . $label . '</h3>';

    	return $html;
	}
}
