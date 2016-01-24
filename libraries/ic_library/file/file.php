<?php
/**
 *------------------------------------------------------------------------------
 *  iC Library - Library by Jooml!C, for Joomla!
 *------------------------------------------------------------------------------
 * @package     iC Library
 * @subpackage  url
 * @copyright   Copyright (c)2014-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     1.0.1 2014-07-13
 * @since       1.0.1
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * class iCUrl
 */
class iCFile
{
	/**
	 * Function to check if a string is defined inside a file.
	 *
	 * @param	$string			string to be checked
	 * 			$file_location	path or url to the file to be tested
	 * @return	true/false.
	 *
	 * @since	1.0.1
	 */
	static public function hasString($string, $file_location)
	{
		if (ini_get('allow_url_fopen') && is_file($file_location))
		{
			$file_to_test = file_get_contents($file_location);

			$has_string = strpos($file_to_test, $string) ? true : false;

			return $has_string;
		}
	}
}
