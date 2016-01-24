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
 * @version     3.4.0 2014-12-21
 * @since       3.4.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');

class JFormFieldModal_ic_password extends JFormField
{
	protected $type='modal_ic_password';

	protected function getInput()
	{
		$_pass = str_replace('/', '.', $this->value);
		$pass_ex = explode('.', $_pass);

		if (isset($pass_ex[1]))
		{
			$value = base64_decode($pass_ex[1]);
		}
		else
		{
			$value = $this->value;
		}

		$html = '<input type="password" id="' . $this->id . '" name="' . $this->name . '" value="' . $value . '" />';

		return $html;
	}
}
