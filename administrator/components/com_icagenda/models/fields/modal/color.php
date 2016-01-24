<?php
/** 
 *	iCagenda
 *----------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright	Copyright (C) 2012 JOOMLIC - All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Jooml!C - http://www.joomlic.com
 * 
 * @update		2.0.4
 *----------------------------------------------------------------------------
*/

// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');


class JFormFieldModal_color extends JFormField
{
	protected $type='modal_color';
	
	protected function getInput()
	{
		$html= '
		<div class="color">
			<div class="form-item">
				<input type="text" id="'.$this->id.'" name="'.$this->name.'" value="'.$this->value.'" />
			</div>
			<div id="picker"></div>
			<div class="clr"></div>
		</div>
		<div class="clr"></div>
		';

		return $html;
	}
}