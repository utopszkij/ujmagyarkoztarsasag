<?php
/**
 * @version		$Id:image.php 1 ##date##Z ##author## $
 * @author	   	##author##
 * @package     ##Component##
 * @subpackage  Controllers
 * @copyright	Copyright (C) ##year##, ##author##. All rights reserved.
 * @license ###license##
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * ##Component## Image Controller
 *
 * @package ##Component## 
 * @subpackage Controllers
 */
 
class ##Component##ControllerImageup extends ##Component##Controller
{
	/**
	 * Constructor
	 */
	 
	public function __construct($config = array ()) 
	{
		parent :: __construct($config);

	}

	public function upload()
	{
		$app = JFactory::getApplication();
		
		// Check for request forgeries
		JRequest::checkToken( 'request' ) or jexit( 'Invalid Token' );

		$file 		= JRequest::getVar( 'image', '', 'files', 'array' );

		$folder		= JRequest::getVar( 'folder', 'com_##component##', '', 'path' );
        
		$config 	=& JComponentHelper::getParams( 'com_##component##' );
		// Set FTP credentials, if given
		jimport('joomla.client.helper');
		JClientHelper::setCredentialsFromRequest('ftp');

		// Make the filename safe
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		$file['name']	= strtolower(JFile::makeSafe($file['name']));
		
		//create the folder, if not exists 
		$folder_path = JPath::clean(JPATH_ROOT.'/images/'.$folder);
		if (!JFolder::exists($folder_path)) JFolder::create($folder_path); 

		if (isset($file['name'])) {
			$filepath = JPath::clean(JPATH_ROOT.'/images/'.$folder.'/'.strtolower($file['name']));
			
			$imageTypes = 'gif|jpg|png|jpeg';
			$isImage = preg_match("/$imageTypes/i",$file['name']);
			if(!$isImage) {
	            print 'noimage';
	            exit;
			}
			if (!JFile::upload($file['tmp_name'], $filepath)) {
				print 'error';
	            exit;
			} else {
	
					$post = JRequest :: get('post');
					$post['filename'] = $file['name'];

					$extension = JFile::getExt($file['name']);
					
					$basename = JFile::stripExt($file['name']);
					
					$imgwidth1 = $config->get('imgwidth1',280);
					$imgheight1 = $config->get('imgheight1',320);						
					
					$thumb = $folder_path.'/'.$basename."_thumb.".$extension;		
					$thumbm = $folder_path.'/'.$basename."_thumbm.".$extension;
					$thumbs = $folder_path.'/'.$basename."_thumbs.".$extension;
					$uri =  str_replace(JPATH_ROOT,'',$folder_path).'/'.$basename.".".$extension;
					$urithumb = str_replace(JPATH_ROOT,'',$folder_path).'/'.$basename."_thumb.".$extension;							
					$urithumbm = str_replace(JPATH_ROOT,'',$folder_path).'/'.$basename."_thumbm.".$extension;
					$urithumbs = str_replace(JPATH_ROOT,'',$folder_path).'/'.$basename."_thumbs.".$extension; 
					//TODO: In die Preferences
	
					self::_resize($imgwidth1, $imgheight1, $filepath, $thumb);
					self::_resize($config->get('imgwidth2',120), $config->get('imgheight2',160),$filepath, $thumbm);
					self::_resize($config->get('imgwidth3',60), $config->get('imgheight3',80), $filepath, $thumbs);
	                $array = array('full' =>
	                            array('uri'=>$uri, 'name'=>$basename.".".$extension),
	                            'thumb' =>
	                            array('uri'=>$urithumb, 'name'=>$basename."_thumb.".$extension),
	                            'thumbm' =>
	                            array('uri'=>$urithumbm, 'name'=>$basename."_thumbm.".$extension),
	                            'thumbs' =>
	                            array('uri'=>$urithumbs, 'name'=>$basename."_thumbs.".$extension)
	                            );         
                    ob_clean();	                            
					print json_encode($array);
					exit;

			}
		} else {
			print 'nofile';
			exit;
		}
	}
	
	static function _resize($forcedwidth, $forcedheight, $sourcefile, $destfile) {
		jimport('joomla.filesystem.file');
		$fw = $forcedwidth;
		$fh = $forcedheight;
		$is = getimagesize($sourcefile);
		if ($is[0] < $is[1]) {
			$fw = $forcedheight;
			$fh = $forcedwidth;
		}
		if ($is[0] > $fw || $is[1] > $fh) {
			if (($is[0] - $fw) >= ($is[1] - $fh)) {
				$iw = $fw;
				$ih = floor(($fw / $is[0]) * $is[1]);
			} else {
				$ih = $fh;
				$iw = floor(($ih / $is[1]) * $is[0]);
			}
			$t = 1;
		} else {
			$iw = $is[0];
			$ih = $is[1];
			$t = 2;
		}
		if ($t == 1) {
			$ext  = strtolower(JFile::getExt($sourcefile));
			$func1 = 'imagecreatefrom' . ($ext == 'jpg' ? 'jpeg' : $ext);
			$func2 = 'image' . ($ext == 'jpg' ? 'jpeg' : $ext);
			$img_src = $func1($sourcefile);
			$img_dst = imagecreatetruecolor($iw, $ih);
			imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $iw, $ih, $is[0], $is[1]);
			switch($ext) {
				case 'gif':
					if (imageistruecolor($img_dst)) {
						imagetruecolortopalette($img_dst, false, 255);
					}
				case 'png':
					$saved = $func2($img_dst, $destfile);
					break;
				case 'jpg':
					$saved = $func2($img_dst,  $destfile, 90);
					 
					break;
			}

			if (!$saved ) {

				exit ();
			}
		} else
		if ($t == 2) {

			JFile::copy($sourcefile, $destfile);
		}
	}
	
}