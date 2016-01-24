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
 * @version     3.4.1 2015-01-30
 * @since       1.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');

class JFormFieldModal_Template extends JFormField
{
	protected $type = 'modal_template';

	protected function getInput()
	{
		$url	= JPATH_SITE.'/components/com_icagenda/themes/packs';
		$list	= $this->getList($url);
		$class 	= !empty($this->class) ? ' class="' . $this->class . '"' : '';
		$html	= '<select id="' . $this->id . '_id"' . $class . ' name="' . $this->name . '">';

		foreach ($list as $l)
		{
			$html.= '<option value="' . $l . '"';

			if ($this->value == $l)
			{
				$html.= ' selected="selected"';
			}

			$html.= '>' . $l . '</option>';
		}

		$html.= '</select>';

		return $html;
	}

	function getList($dirname)
	{
		$arrayfiles = Array();

		if (file_exists($dirname))
		{
			$handle = opendir($dirname);

			while (false !== ($file = readdir($handle)))
			{
				if (!is_file($dirname.$file)
					&& $file != '.'
					&& $file != '..'
					&& $file != '.DS_Store'
					&& $file != '.htaccess'
					&& $file != '.thumbs'
					&& $file != 'index.php'
					&& $file != 'index.html'
					&& $file != 'php.ini'
					)
				{
					array_push($arrayfiles, $file);
				}
			}

			$handle = closedir($handle);
		}

		sort($arrayfiles);

		return $arrayfiles;
	}
}
