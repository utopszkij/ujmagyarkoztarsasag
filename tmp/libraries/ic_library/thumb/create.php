<?php
/**
 *------------------------------------------------------------------------------
 *  iC Library - Library by Jooml!C, for Joomla!
 *------------------------------------------------------------------------------
 * @package     iC Library
 * @subpackage  thumb
 * @copyright   Copyright (c)2014-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     1.2.1 2015-02-19
 * @since       1.0.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * iC Library thumb class
 */
class iCThumbCreate
{
	/**
	 * Create thumbnail image by php using the GD Library
	 *
	 * @since   1.0.0
	 */
	static public function createThumb($source_image, $destination_image_url, $width, $height, $quality, $crop = null, $prefix = null, $checksize = null)
	{
		//Set image ratio
		list($w, $h) = getimagesize($source_image);

		// resize
		if ($crop === true)
		{
			if ($checksize
				&& ($w < $width or $h < $height)
				)
			{
				$width	= $w+1;
				$height	= $h+1;
				$x		= 0;
			}
			else
			{
				$ratio	= max($width/$w, $height/$h);
				$h		= $height / $ratio;
				$x		= ($w - $width / $ratio) / 2;
				$w		= $width / $ratio;
			}
		}
		else
		{
			if ($checksize
				&& ($w < $width or $h < $height)
				)
			{
				$width	= $w;
				$height	= $h;
				$x		= 0;
			}
			else
			{
				$ratio	= min($width/$w, $height/$h);
				$width	= $w * $ratio;
				$height	= $h * $ratio;
				$x		= 0;
			}
		}

		if (preg_match("/.jpg/i","$source_image") OR preg_match("/.jpeg/i","$source_image"))
		{
			//JPEG type thumbnail
			$destImage = imagecreatetruecolor($width, $height);
			$sourceImage = imagecreatefromjpeg($source_image);
			imagecopyresampled($destImage, $sourceImage, 0, 0, $x, 0, $width, $height, $w, $h);
			imagejpeg($destImage, $destination_image_url, $quality);
			imagedestroy($destImage);
		}
		elseif (preg_match("/.png/i", "$source_image"))
		{
			//PNG type thumbnail
			$destImage = imagecreatetruecolor ($width, $height);
			$sourceImage = imagecreatefrompng($source_image);
			imagealphablending($destImage, false);
			imagecopyresampled($destImage, $sourceImage, 0, 0, $x, 0, $width, $height, $w, $h);
			imagesavealpha($destImage, true);
			imagepng($destImage, $destination_image_url);
		}
		elseif (preg_match("/.gif/i", "$source_image"))
		{
			//GIF type thumbnail
			$destImage = imagecreatetruecolor($width, $height);
			$sourceImage = imagecreatefromgif($source_image);
			$bgc = imagecolorallocate ($destImage, 255, 255, 255);
			imagefilledrectangle ($destImage, 0, 0, $width, $height, $bgc);
			imagecopyresampled($destImage, $sourceImage, 0, 0, $x, 0, $width, $height, $w, $h);

			if(function_exists('imagegif'))
			{
				// Pour GIF
				header('Content-Type: image/gif');

				imagegif($destImage, $destination_image_url, $quality);
			}

			imagedestroy($destImage);
		}
		else
		{
			echo 'unable to load image source';
		}
	}
}
