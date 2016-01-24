<?php
/**
 *------------------------------------------------------------------------------
 *  iC Library - Library by Jooml!C, for Joomla!
 *------------------------------------------------------------------------------
 * @package     iC Library
 * @subpackage  string
 * @copyright   Copyright (c)2014-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     1.2.4 2015-05-06
 * @since       1.0.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

// PHP mbstring and iconv local configuration

// Check if mbstring extension is loaded and attempt to load it if not present except for windows
//if (extension_loaded('mbstring'))
//{
	// Make sure to suppress the output in case ini_set is disabled
//	@ini_set('mbstring.internal_encoding', 'UTF-8');
//	@ini_set('mbstring.http_input', 'UTF-8');
//	@ini_set('mbstring.http_output', 'UTF-8');
//}

// Same for iconv
//if (function_exists('iconv'))
//{
	// These are settings that can be set inside code
//	iconv_set_encoding("internal_encoding", "UTF-8");
//	iconv_set_encoding("input_encoding", "UTF-8");
//	iconv_set_encoding("output_encoding", "UTF-8");
//}

/**
 * Include the utf8 package
 */
//jimport('phputf8.utf8');
//jimport('phputf8.strcasecmp');

/**
 * class iCString
 *
 * String handling class for utf-8 data
 * Wraps the phputf8 library
 * All functions assume the validity of utf-8 strings.
 */
abstract class iCString
{
	/**
	 * Increment styles.
	 *
	 * @var    array
	 * @since   1.0.0
	 */
	protected static $incrementStyles = array(
		'default' => array(
			array('#\((\d+)\)$#', '#\(\d+\)$#'),
			array(' ( %d)', '(%d)'),
		),
		'dash' => array(
			'#-(\d+)$#',
			'-%d'
		),
		'underscore' => array(
			'#_(\d+)$#',
			'_%d'
		),
	);

	/**
	 * Increments a trailing number in a string.
	 *
	 * Used to easily create distinct labels when copying objects. The method has the following styles:
	 *
	 * default:		"Label" becomes "Label (2)"
	 * dash:		"Label" becomes "Label-2"
	 * underscore:	"Label" becomes "Label_2"
	 *
	 * @param   string   $string  The source string.
	 * @param   string   $style   The style (default|dash|underscore).
	 * @param   integer  $n       If supplied, this number is used for the copy, otherwise it is the 'next' number.
	 *
	 * @return  string  The incremented string.
	 *
	 * @since   1.0.0
	 */
	public static function increment($string, $style = 'default', $n = 0)
	{
		$styleSpec = isset(self::$incrementStyles[$style]) ? self::$incrementStyles[$style] : self::$incrementStyles['default'];

		// Regular expression search and replace patterns.
		if (is_array($styleSpec[0]))
		{
			$rxSearch = $styleSpec[0][0];
			$rxReplace = $styleSpec[0][1];
		}
		else
		{
			$rxSearch = $rxReplace = $styleSpec[0];
		}

		// New and old (existing) sprintf formats.
		if (is_array($styleSpec[1]))
		{
			$newFormat = $styleSpec[1][0];
			$oldFormat = $styleSpec[1][1];
		}
		else
		{
			$newFormat = $oldFormat = $styleSpec[1];
		}

		// Check if we are incrementing an existing pattern, or appending a new one.
		if (preg_match($rxSearch, $string, $matches))
		{
			$n = empty($n) ? ($matches[1] + 1) : $n;
			$string = preg_replace($rxReplace, sprintf($oldFormat, $n), $string);
		}
		else
		{
			$n = empty($n) ? 2 : $n;
			$string .= sprintf($newFormat, $n);
		}

		return $string;
	}

	/**
	 * Tests whether a string is serialized before attempting to unserialize it
	 *
	 * Author : doorknob
	 *
	 * @since   1.0.0
	 */
	public static function isSerialized($str)
	{
		return ($str == serialize(false) || @unserialize($str) !== false);
	}

	/**
	 * Uppercase first letter of the first word of a string (utf-8)
	 *
	 * @since   1.2.4
	 */
	public static function mb_ucfirst($str)
	{
    	if (preg_match('/[a-z]/ui', $str[0]))
        	return ucfirst($str);

    	$first	= mb_strtoupper($str[0].$str[1], 'utf8');
    	$str[0]	= $first[0];
    	$str[1]	= $first[1];

    	return $str;
	}
}
