<?php
/**
* @file
* @brief    showplus slideshow module for Joomla
* @author   Levente Hunyadi
* @version  1.0.5
* @remarks  Copyright (C) 2011 Levente Hunyadi
* @remarks  Licensed under GNU/GPLv3, see http://www.gnu.org/licenses/gpl-3.0.html
* @see      http://hunyadi.info.hu/projects/showplus
*/

/*
* showplus slideshow module for Joomla
* Copyright 2009-2010 Levente Hunyadi
*
* showplus is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* showplus is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with showplus.  If not, see <http://www.gnu.org/licenses/>.
*/

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

jimport('joomla.form.formfield');

/**
* A control for choosing CSS border color.
* This class implements a user-defined control in the administration back-end.
*/
class JFormFieldColor extends JFormField {
	protected $type = 'Color';

	public function getInput() {
		$class = ( isset($this->element['class']) ? (string)$this->element['class'] : 'inputbox' );

		// add script declaration to header
		$document = JFactory::getDocument();
		$document->addScript(JURI::root(true).'/modules/mod_showplus/fields/jscolor/jscolor.js');

		// add control to page
		$ctrlid = str_replace(array('[',']'), '', $this->name);
		return '<input type="text" class="'. $class .' color" name="'. $this->name .'" id="'. $ctrlid .'" value="'. $this->value .'" />';
	}
}

