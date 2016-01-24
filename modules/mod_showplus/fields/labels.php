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
* Renders a control that shows whether labels are defined for a gallery.
* This class implements a user-defined control in the administration back-end.
*/
class JFormFieldLabels extends JFormField {
	protected $type = 'Labels';

	public function getInput() {
		$class = ( isset($this->element['class']) ? (string)$this->element['class'] : 'inputbox' );
		$ctrlid = str_replace(array('[',']'), '', $this->name);

		// add script declaration to header to hide control on folder change
		$folderctrl = $this->form->getField('folder','params');
		$labelsctrl = $this->form->getField('labels','params');
		$document =& JFactory::getDocument();
		$document->addScriptDeclaration('window.addEvent("domready", function () {
		$$("input[name=\''.$folderctrl->name.'\'], input[name=\''.$labelsctrl->name.'\']").addEvent("change", function () { document.id("'.$ctrlid.'").setStyle("display","none"); }); });');

		// test whether labels file exists
		$labelsfile = $this->getLabelsFilename();
		
		// add control to configuration page
		if ($labelsfile !== false) {
			$checked = ' checked="checked"';
		} else {
			$checked = '';
		}
		return '<input type="checkbox" class="'. $class .'" id="'. $ctrlid .'" disabled="disabled"'. $checked .' />';
	}

	/**
	* Returns the language-specific labels filename.
	* @return File system path to the language file to use, or false if no labels file exists.
	*/
	private function getLabelsFilename() {
		// get value of parameters "folder" and "labels"
		$folder = $this->form->getValue('folder','params');
		$labels = $this->form->getValue('labels','params');
		$labels_multilingual = (bool) $this->form->getValue('labels_multilingual','params');

		if ($labels_multilingual) {  // check for language-specific labels file
			$lang = JFactory::getLanguage();
			$labelsfile = JPATH_ROOT.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $folder).DIRECTORY_SEPARATOR.$labels.'.'.$lang->getTag().'.txt';
			if (is_file($labelsfile)) {
				return $labelsfile;
			}
		}
		// default to language-neutral labels file
		$labelsfile = JPATH_ROOT.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $folder).DIRECTORY_SEPARATOR.$labels.'.txt';  // filesystem path to labels file
		if (is_file($labelsfile)) {
			return $labelsfile;
		}
		return false;
	}
}
