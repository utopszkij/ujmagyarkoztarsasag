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
 * @version     1.3.4 2015-11-03
 * @since       1.0.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * iC Library image class
 */
class iCThumbGet
{
	/**
	 * Return the link to the thumbnail of an image
	 *
	 * @since   1.0.0
	 */
	static public function thumbnail($image, $thumbsPath, $subFolder,
		$width, $height, $quality, $crop = null, $prefix = null, $type = null, $checksize = null, $name = null)
	{
		$app = JFactory::getApplication();

		$file_local		= JPATH_ROOT . '/' . $image;
		$file_distant	= $image;

		$linkToImage	= filter_var($image, FILTER_VALIDATE_URL) ? $file_distant : $file_local;
		$original_exist	= file_exists($linkToImage) ? true : false;

		// Set memory_limit if possible to 512mo, and check needed memory to generate thumbnails
		ini_set('memory_limit','512M');

		// Check if fopen is allowed
		$fopen = true;
		$result = ini_get('allow_url_fopen');

		if (empty($result))
		{
			$fopen = false;
		}

		// Initialize Vars
		$Image_Link 			= '';
		$Thumb_Link 			= '';
		$Display_Thumb 			= false;
		$MimeTypeOK 			= true;
		$MimeTypeERROR			= false;
		$Invalid_Link 			= false;
		$Invalid_Img_Format		= false;
		$fopen_bmp_error_msg	= false;

		$Invalid_LinkMsg		= '<i class="icon-warning"></i><br /><span style="color:red;"><strong>' . JText::_('ICLIB_INVALID_PICTURE_LINK') . '</strong></span>';
		$Wrong_img_format		= '<i class="icon-warning"></i><br/><span style="color:red;"><strong>' . JText::_('ICLIB_NOT_AUTHORIZED_IMAGE_TYPE') . '</strong><br/>' . JText::_('ICLIB_NOT_AUTHORIZED_IMAGE_TYPE_INFO') . '</span>';
		$fopen_bmp_error		= '<i class="icon-warning"></i><br/><span style="color:red;"><strong>' . JText::_('ICLIB_PHP_ERROR_FOPEN_COPY_BMP') . '</strong><br/>' . JText::_('ICLIB_PHP_ERROR_FOPEN_COPY_BMP_INFO') . '</span>';
		$error_icthumb			= '<i class="icon-warning"></i><br/><span style="color:red;"><strong>' . JText::_('ICLIB_ERROR_ICTHUMB') . '</strong><br/>' . JText::_('ICLIB_ERROR_ICTHUMB_INFO') . '</span>';

		// Mime-Type pre-settings
		$errorMimeTypeMsg 		= '<i class="icon-warning"></i><br /><span style="color:red;"><strong>' . JText::_('ICLIB_ERROR_MIME_TYPE') . '</strong><br/>' . JText::_('ICLIB_ERROR_MIME_TYPE_NO_THUMBNAIL');

		// Folder for copy of distant images, and jpg created from bmp
		$copyPath	 			= $thumbsPath . '/copy';

		$cropped = $crop ? 'c' : '';

		// Thumb Destination
		if ($name)
		{
			$thumb_name				= '';
		}
		elseif ($prefix)
		{
			$thumb_name				= $prefix.'_w'.$width.'h'.$height.'q'.$quality.$cropped.'_';
		}
		else
		{
			$thumb_name				= 'w'.$width.'h'.$height.'q'.$quality.$cropped.'_';
		}
		$thumb_destination		= $subFolder . '/' . $thumb_name;

		// Get Image File Infos
//		$url = $image;
//		$decomposition = explode( '/' , $url );
		// in each parent
//		$i = 0;
//		while ( isset($decomposition[$i]) )
//			$i++;
//		$i--;
//		$imgname = $decomposition[$i];
//		$fichier = explode( '.', $decomposition[$i] );
//		$imgtitle = $fichier[0];
//		$imgextension = strtolower($fichier[1]); // fixed 3.1.10

		$image_info		= pathinfo($image);
		$imgtitle		= $image_info['filename'];
		$imgextension	= strtolower($image_info['extension']); // To be checked if error with uppercase extension type

		// Clean file name
		jimport( 'joomla.filter.output' );
		$cleanFileName	= JFilterOutput::stringURLSafe($imgtitle) . '.' . $imgextension;
		$cleanTitle		= JFilterOutput::stringURLSafe($imgtitle);

		// Image pre-settings
		$imageValue 			= $image;
		$Image_Link 			= $image;

		// url to thumbnails already created
		$Thumb_Link 			= $thumbsPath . '/' . $thumb_destination . $cleanFileName;
		$Thumb_aftercopy_Link 	= $thumbsPath . '/' . $thumb_destination . $cleanTitle . '.jpg';

		// url to copy original jpg created
		$MAX_aftercopy_Link 	= $copyPath . '/' . $cleanTitle . '.jpg';

		$file_copy		= JPATH_ROOT . '/' . $MAX_aftercopy_Link;

		// Fix for previous version, if original image is too small (ic_large image only, used in event details view)
		$original_too_small = false;

		if ($prefix == 'ic_large')
		{
			if ($original_exist)
			{
				$file_to_check	= filter_var($image, FILTER_VALIDATE_URL) ? $file_copy : $file_local;
				list($w, $h)	= getimagesize($file_to_check);

				if ($w < $width or $h < $height)
				{
					$max_image_size		= filter_var($image, FILTER_VALIDATE_URL) ? $MAX_aftercopy_Link : $image;
					$original_too_small	= true;
				}
			}
		}

		// Check if thumbnails already created
		if (file_exists(JPATH_ROOT . '/' . $Thumb_Link)
			|| $original_too_small)
		{
			$Thumb_Link = $original_too_small ? $max_image_size : $Thumb_Link;
			$Display_Thumb = true;
		}
		elseif (file_exists(JPATH_ROOT . '/' . $Thumb_aftercopy_Link)
			|| $original_too_small)
		{
			$Thumb_Link = $original_too_small ? $max_image_size : $Thumb_aftercopy_Link;
			$Display_Thumb = true;
		}
		// if thumbnails not already created, create thumbnails
		elseif ($original_exist)
		{
			$memory_limit = ini_get('memory_limit');

			if (preg_match('/^(\d+)(.)$/', $memory_limit, $matches))
			{
				if ($matches[2] == 'M')
				{
					$memory_limit = $matches[1] * 1024 * 1024; // nnnM -> nnn MB
				}
				elseif ($matches[2] == 'K')
				{
					$memory_limit = $matches[1] * 1024; // nnnK -> nnn KB
				}
			}

			list($w, $h)	= getimagesize($linkToImage);

			$rgba_factor = 4;
			$security_factor = 1.8;

			if (function_exists('memory_get_usage')
				&& ( (($w * $h * $rgba_factor * $security_factor) + memory_get_usage()) > $memory_limit )
				)
			{
				if ( $app->isAdmin() )
				{
					$alert_message = JText::sprintf('ICLIB_ERROR_ALERT_IMAGE_TOO_LARGE', $image);
					// Get the message queue
					$messages = $app->getMessageQueue();

					$display_alert_message = false;

					// If we have messages
					if (is_array($messages) && count($messages))
					{
						// Check each message for the one we want
						foreach ($messages as $key => $value)
						{
							if ($value['message'] == $alert_message)
							{
								$display_alert_message = true;
							}
						}
					}

					if (!$display_alert_message)
					{
						$app->enqueueMessage($alert_message, 'Warning');
					}

					return JText::_('ICLIB_ERROR_IMAGE_TOO_LARGE');
				}
				else
				{
					return false;
				}
			}


			if (file_exists($linkToImage))
			{
				// Test Mime-Type
				$fileinfos = getimagesize($linkToImage);
				$mimeType = $fileinfos['mime'];
				$extensionType = 'image/' . $imgextension;

				// SETTINGS ICTHUMB
				$errorMimeTypeInfo = '<span style="color:black;"><br/>' . JText::sprintf('ICLIB_ERROR_MIME_TYPE_INFO', $imgextension, $mimeType);

				// Error message if Mime-Type is not the same as extension
				if (($imgextension == 'jpeg') OR ($imgextension == 'jpg'))
				{
					if (($mimeType != 'image/jpeg') AND ($mimeType != 'image/jpg'))
					{
						$MimeTypeOK 	= false;
						$MimeTypeERROR 	= true;
					}
				}
				elseif ($imgextension == 'bmp')
				{
					if (($mimeType != 'image/bmp') AND ($mimeType != 'image/x-ms-bmp'))
					{
						$MimeTypeOK 	= false;
						$MimeTypeERROR 	= true;
					}
				}
				elseif ($mimeType != $extensionType)
				{
					$MimeTypeOK 	= false;
					$MimeTypeERROR 	= true;
				}
			}

			// If Error mime-type, no thumbnail creation
			if ($MimeTypeOK)
			{
				// Call function and create image thumbnail for events list in admin

				// If Image JPG, JPEG, PNG or GIF
				if (($imgextension == "jpg") OR ($imgextension == "jpeg") OR ($imgextension == "png") OR ($imgextension == "gif"))
				{
					$Thumb_Link = $Thumb_Link;

					if (!file_exists(JPATH_ROOT . '/' . $Thumb_Link))
					{
						if (filter_var($imageValue, FILTER_VALIDATE_URL))
						{
							if ((iCUrl::url_exists($imageValue)) AND ($fopen))
							{
								$testFile = JPATH_ROOT . '/' . $copyPath . '/' . $cleanFileName;

								if (!file_exists($testFile))
								{
									//Get the file
									$content = file_get_contents($imageValue);

									//Store in the filesystem.
									$fp = fopen(JPATH_ROOT . '/' . $copyPath . '/' . $cleanFileName, "w");
									fwrite($fp, $content);
									fclose($fp);
								}

								$linkToImage = JPATH_ROOT . '/' . $copyPath . '/' . $cleanFileName;
								$imageValue = $copyPath . '/' . $cleanFileName;
							}
							else
							{
								$linkToImage = $imageValue;
							}
						}
						else
						{
							$linkToImage = JPATH_ROOT . '/' . $imageValue;
						}

						if ((iCUrl::url_exists($linkToImage)) OR (file_exists($linkToImage)))
						{
							iCThumbCreate::createThumb($linkToImage, JPATH_ROOT . '/' . $Thumb_Link, $width, $height, $quality, $crop, $prefix, $checksize);
						}
						else
						{
							$Invalid_Link = true;
						}
					}
				}

				// If Image BMP
				elseif ($imgextension == "bmp")
				{
					$Image_Link = $copyPath . '/' . $cleanTitle . '.jpg';
					$Thumb_Link = $Thumb_aftercopy_Link;

					if (!file_exists(JPATH_ROOT . '/' . $Thumb_Link))
					{
						if (filter_var($imageValue, FILTER_VALIDATE_URL))
						{
							if ((iCUrl::url_exists($imageValue)) AND ($fopen))
							{
								$testFile = JPATH_ROOT . '/' . $copyPath . '/' . $cleanTitle . '.jpg';
								if (!file_exists($testFile))
								{
									// Get the file
									$content = file_get_contents($imageValue);

									// Store in the filesystem.
									$fp = fopen(JPATH_ROOT . '/' . $copyPath . '/' . $cleanFileName, "w");
									fwrite($fp, $content);
									fclose($fp);
									$imageNewValue = JPATH_ROOT . '/' . $copyPath . '/' . $cleanFileName;
									imagejpeg(iCThumbImage::createFromBMP($imageNewValue), JPATH_ROOT . '/' . $copyPath . '/' . $cleanTitle . '.jpg', 100);
									unlink($imageNewValue);
								}
							}
							else
							{
								$linkToImage = $imageValue;
							}
						}
						else
						{
							imagejpeg(iCThumbImage::createFromBMP(JPATH_ROOT . '/' . $imageValue), JPATH_ROOT . '/' . $copyPath . '/' . $cleanTitle . '.jpg', 100);
						}

						$imageValue = $copyPath . '/' . $cleanTitle . '.jpg';
						$linkToImage = JPATH_ROOT . '/' . $imageValue;

						if (!$fopen)
						{
							$fopen_bmp_error_msg = true;
						}
						elseif ((iCUrl::url_exists($linkToImage)) OR (file_exists($linkToImage)))
						{
							iCThumbCreate::createThumb($linkToImage, JPATH_ROOT . '/' . $Thumb_Link, $width, $height, $quality, $crop, $prefix, $checksize);
						}
						else
						{
							$Invalid_Link = true;
						}
					}
				}

				// If Not authorized Image Format
				else
				{
					if ((iCUrl::url_exists($linkToImage)) OR (file_exists($linkToImage)))
					{
						$Invalid_Img_Format = true;
					}
					else
					{
						$Invalid_Link = true;
					}
				}

				if (!$Invalid_Link)
				{
					$Display_Thumb = true;
				}
			}
			// If error Mime-Type
			else
			{
				if (($imgextension == "jpg")
					OR ($imgextension == "jpeg")
					OR ($imgextension == "png")
					OR ($imgextension == "gif")
					OR ($imgextension == "bmp"))
				{
					$MimeTypeERROR = true;
				}
				else
				{
					$Invalid_Img_Format = true;
					$MimeTypeERROR = false;
				}
			}
		}

		if ($type == 'imgTag'
			||  $type == 'imgTagLinkModal')
		{
			// Display Thumbnail Image tag
			$thumbnailImgTag = '';
			if ($Invalid_Img_Format)
			{
				$thumbnailImgTag.= $app->isAdmin() ? $Wrong_img_format : '';
			}

			if ($Invalid_Link)
			{
				$thumbnailImgTag.= $app->isAdmin() ? $Invalid_LinkMsg : '';
			}

			if ($MimeTypeERROR)
			{
				$thumbnailImgTag.= $app->isAdmin() ? $errorMimeTypeMsg : '';
				$thumbnailImgTag.= $app->isAdmin() ? $errorMimeTypeInfo : '';
			}

			if ($fopen_bmp_error_msg)
			{
				$thumbnailImgTag.= $app->isAdmin() ? $fopen_bmp_error : '';
			}

			if ($Display_Thumb)
			{
				if ($imgextension == "bmp")
				{
					if ($type == 'imgTagLinkModal')
					{
						$thumbnailImgTag.= '<a href="' . JURI::root( true ) . '/' . $MAX_aftercopy_Link.'" class="modal">';
					}

					$thumbnailImgTag.= '<img src="' . JURI::root( true ) . '/' . $Thumb_aftercopy_Link.'" alt="" />';

					if ($type == 'imgTagLinkModal')
					{
						$thumbnailImgTag.= '</a>';
					}
				}
				else
				{
					if ($type == 'imgTagLinkModal')
					{
						if (filter_var($Image_Link, FILTER_VALIDATE_URL))
						{
							$thumbnailImgTag.= '<a href="'.$Image_Link.'" class="modal">';
						}
						else
						{
							$thumbnailImgTag.= '<a href="' . JURI::root( true ) . '/' . $Image_Link.'" class="modal">';
						}
					}

					$thumbnailImgTag.= '<img src="' . JURI::root( true ) . '/' . $Thumb_Link.'" alt="" />';

					if ($type == 'imgTagLinkModal')
					{
						$thumbnailImgTag.= '</a>';
					}
				}
			}

			if ((!file_exists(JPATH_ROOT . '/' . $Thumb_Link)) && ($image) && (!$fopen))
			{
				$thumbnailImgTag.=  $app->isAdmin() ? $error_icthumb : '';
			}

			return $thumbnailImgTag;
		}
		else
		{
			// Display Thumbnail Image tag
			$thumb_img = '';

			// Set Thumbnail
			$default_thumbnail = 'media/com_icagenda/images/nophoto.jpg';

			if ( $Invalid_Img_Format
				|| $Invalid_Link
				|| $MimeTypeERROR
				|| $fopen_bmp_error_msg
				|| ((!file_exists(JPATH_ROOT . '/' . $Thumb_Link)) && ($image)) )
			{
				$thumb_img = $default_thumbnail;
			}
			elseif ($Display_Thumb)
			{
				$thumb_img = $Thumb_Link;
			}

			return $thumb_img;
		}
	}

	/**
	 * Return the thumbnail from an image, embed inside html tags
	 *
	 * @since   1.0.0
	 */
	static public function thumbnailImgTag($image, $thumbsPath, $subFolder,
		$width, $height, $quality, $crop = null, $prefix = null)
	{
		$thumbnailImgTag = iCThumbGet::thumbnail($image, $thumbsPath, $subFolder, $width, $height, $quality, $crop, $prefix, 'imgTag');

		return $thumbnailImgTag;
	}

	/**
	 * Return the thumbnail from an image, embed inside html tags
	 * Link on thumbnail opens original image in modal
	 *
	 * @since   1.0.0
	 */
	static public function thumbnailImgTagLinkModal($image, $thumbsPath, $subFolder,
		$width, $height, $quality, $crop = null, $prefix = null)
	{
		$thumbnailImgTag = iCThumbGet::thumbnail($image, $thumbsPath, $subFolder, $width, $height, $quality, $crop, $prefix, 'imgTagLinkModal');

		return $thumbnailImgTag;
	}
}
