<?php
/**
 *------------------------------------------------------------------------------
 *  iC Library - Library by Jooml!C, for Joomla!
 *------------------------------------------------------------------------------
 * @package     iC Library
 * @subpackage  color
 * @copyright   Copyright (c)2014-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     1.0.0 2014-05-10
 * @since       1.0.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * class iCColor
 */
class iCColor
{
	/**
	 * Function to convert color : hexadecimal to RGB
	 *
	 * @access	public static
	 * @param	color to be converted in hexadecimal ('#xxxxxx')
	 * @return	converted color in RGB ('xxx,xxx,xxx')
	 *
	 * @since   1.0.0
	 */
	static public function hex_to_rgb($color)
	{
		if (!is_array($color)
			&& preg_match("/^[#]([0-9a-fA-F]{6})$/",$color))
		{
			$hex_R = substr($color,1,2);
			$hex_G = substr($color,3,2);
			$hex_B = substr($color,5,2);
			$RGB = hexdec($hex_R).",".hexdec($hex_G).",".hexdec($hex_B);

			return $RGB;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Function to convert color : RGB to hexadecimal
	 *
	 * @access	public static
	 * @param	color to be converted in RGB ('xxx,xxx,xxx' or 'array(xxx,xxx,xxx)')
	 * @return	converted color in hexadecimal ('#xxxxxx')
	 *
	 * @since   1.0.0
	 */
	static public function rgb_to_hex($color)
	{
		if (!is_array($color))
		{
			$color_array = explode(",", $color);
		}

		if (is_array($color_array) and count($color_array) === 3)
		{
			$hex_RGB = "";

			foreach ($color_array as $value)
			{
				$hex_value = dechex($value);

				if (strlen($hex_value) < 2)
				{
					$hex_value = "0".$hex_value;
				}

				$hex_RGB.=$hex_value;
			}

			return "#".$hex_RGB;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Function to get brightness of hexadecimal color
	 *
	 * @access	public static
	 * @param	color in hexadecimal ('#xxxxxx')
	 * @return	string ('dark' or 'bright')
	 *
	 * @since   1.0.0
	 */
	static public function getBrightness($color)
	{
		if (!is_array($color)
			&& preg_match("/^[#]([0-9a-fA-F]{6})$/",$color)
			&& strlen($color) == 7)
		{
			$get_RGB = iCColor::hex_to_rgb($color);

			$RGB = explode(",",$get_RGB);
			$RGBa = $RGB[0];
			$RGBb = $RGB[1];
			$RGBc = $RGB[2];

			$sum = ($RGBa + $RGBb + $RGBc);

			if ($sum > '384') // Color is bright
			{
				$brightness = 'bright';
			}
			else // Color is dark
			{
				$brightness = 'dark';
			}

			return $brightness;
		}
		else
		{
			return false;
		}
	}
}
