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
 * @version     1.0.4 2014-11-11
 * @since       1.0.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * class iCUrl
 */
class iCUrl
{
	/**
	 * Function to check if an url exists
	 *
	 * @access	public static
	 * @param	url to be tested
	 * @return	true or false
	 *
	 * @since   1.0.0
	 */
	static public function url_exists($url)
	{
		$a_url = parse_url($url);
		if (!isset($a_url['port'])) $a_url['port'] = 80;
		$errno = 0;
		$errstr = '';
		$timeout = 30;
		if(isset($a_url['host']) && $a_url['host']!=gethostbyname($a_url['host']))
		{
			$fid = fsockopen($a_url['host'], $a_url['port'], $errno, $errstr, $timeout);
			if (!$fid) return false;
			$page = isset($a_url['path']) ?$a_url['path']:'';
			$page .= isset($a_url['query'])?'?'.$a_url['query']:'';
			fputs($fid, 'HEAD '.$page.' HTTP/1.0'."\r\n".'Host: '.$a_url['host']."\r\n\r\n");
			$head = fread($fid, 4096);
			fclose($fid);
			return preg_match('#^HTTP/.*\s+[200|302]+\s#i', $head);
		}
		else
		{
			return false;
		}
	}

	/**
	 * Function to parse an url and apply control of component set
	 *
	 * @access	public static
	 * @param	$url: url to be parsed
	 			$component: component to be checked
	 * @return	validate url
	 *
	 * @since   1.0.0
	 */
	static public function urlParsed($url, $component = null)
	{
		$parsed = parse_url($url);

		// Add http:// if scheme missing
		if ($component == 'scheme' && empty($parsed['scheme']))
		{
			$link = 'http://' . ltrim($url, '/');
		}
		else
		{
			$link = ltrim($url, '/');
		}

		return $link;
	}
}
