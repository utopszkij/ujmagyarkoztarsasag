<?php
/**
 *------------------------------------------------------------------------------
 *  iC Library - Library by Jooml!C, for Joomla!
 *------------------------------------------------------------------------------
 * @package     iC Library
 * @subpackage  filter
 * @copyright   Copyright (c)2014-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     1.0.0 2014-06-13
 * @since       1.0.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * class iCUrl
 */
class iCFilterOutput
{
	/**
	 * Process a string in a JOOMLA_TRANSLATION_STRING standard.
	 * This method processes a string and replaces all accented UTF-8 characters by unaccented
	 * ASCII-7 "equivalents" and the string is uppercase. Spaces replaced by underscore.
	 *
	 * @param   string  $string  String to process
	 *
	 * @return  string  Processed string
	 *
	 * @since   1.0.0
	 */
	public static function stringToJText($string)
	{
		// Remove any '_' from the string since they will be used as concatenaters
		$str = str_replace('_', ' ', $string);

		$lang = JFactory::getLanguage();
		$str = $lang->transliterate($str);

		// Trim white spaces at beginning and end of translation string and make uppercase
		$str = trim(JString::strtoupper($str));

		// Remove any duplicate whitespace, and ensure all characters are alphanumeric
		$str = preg_replace('/(\s|[^A-Za-z0-9\-])+/', '_', $str);

		// Trim underscores at beginning and end of translation string
		$str = trim($str, '_');

		return $str;
	}

	/**
	 * Process a string in slug format.
	 * This method processes a string and replaces all accented UTF-8 characters by unaccented
	 * ASCII-7 "equivalents" and the string is lowercase. Spaces replaced by underscore.
	 *
	 * @param   string  $string  String to process
	 *
	 * @return  string  Processed string
	 *
	 * @since   1.0.0
	 */
	public static function stringToSlug($string)
	{
		// Remove any '_' from the string since they will be used as concatenaters
		$replace = array('-', '_');
		$str = str_replace($replace, ' ', $string);

		//replaces all accented UTF-8 characters by unaccented ASCII-7 "equivalents"
		$lang = JFactory::getLanguage();
		$str = $lang->transliterate($str);

		// Trim white spaces at beginning and end of translation string and make uppercase
		$str = trim(JString::strtolower($str));

		// Remove any duplicate whitespace, and ensure all characters are alphanumeric
		$str = preg_replace('/(\s|[^A-Za-z0-9\-])+/', '_', $str);

		// Trim underscores at beginning and end of translation string
		$str = trim($str, '_');

		return $str;
	}

	/**
	 * Convert a HTML string in a text single line.
	 * This method processes a string, cleans all HTML tags and converts special characters to HTML entities.
	 * The string is lowercase. Spaces replaced by underscore.
	 *
	 * @param   string  $string  String to process
	 *
	 * @return  string  Processed string
	 *
	 * @since   1.0.0
	 */
	static public function fullCleanHTML($string)
	{
		// Clean text of all formatting and scripting code
		$str = preg_replace("'<script[^>]*>.*?</script>'si", '', $string);
		$str = preg_replace('/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is', '\2 (\1)', $str);
		$str = preg_replace('/<!--.+?-->/', '', $str);
		$str = preg_replace('/{.+?}/', '', $str);

		// Strip HTML and PHP tags
		$str	= strip_tags($str);

		// Replace all sequences of two or more spaces, tabs, and/or line breaks with a single space
		$str	= preg_replace('/[\p{Z}\s]{2,}/u', ' ', $str);

		// Convert special characters to HTML entities
		$str = htmlspecialchars($str, ENT_QUOTES, 'UTF-8');

		// Trim spaces at beginning and end of translation string
		$str	= trim($str);

		return $str;
	}
}
