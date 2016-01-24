<?php
/**
* @file
* @brief    showplus slideshow module for Joomla
* @author   Levente Hunyadi
* @version  1.0.5
* @remarks  Copyright (C) 2011 Levente Hunyadi
* @remarks  Licensed under GNU/GPLv3, see http://www.gnu.org/licenses/gpl-3.0.html
* @see      http://hunyadi.info.hu/projects/showplus
*/

/*
* showplus slideshow module for Joomla
* Copyright 2009-2010 Levente Hunyadi
*
* showplus is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* showplus is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with showplus.  If not, see <http://www.gnu.org/licenses/>.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'utility.php';
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'exception.php';
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'params.php';

/**
* Client-side image data including image URL, image thumbnail URL and caption.
*/
class ShowPlusImageData {
	public $imageurl;
	public $thumburl;
	public $hyperlink;
	public $caption;

	public function __construct($imageurl, $thumburl, $hyperlink = null, $caption = null) {
		$this->imageurl = $imageurl;
		$this->thumburl = $thumburl;
		$this->hyperlink = $hyperlink;
		$this->caption = $caption;
	}
}

class ShowPlusImageLabel {
	public $imagefile;
	public $hyperlink;
	public $caption;

	public function __construct($imagefile, $hyperlink = null, $caption = null) {
		$this->imagefile = $imagefile;
		$this->hyperlink = $hyperlink;
		$this->caption = $caption;
	}
}

/**
* Animated slideshow.
*/
class ShowPlusSlideshow {
	/**
	* Status of debug mode as determined by first module loaded.
	* Inconsistent debug mode settings on the same page would case script conflicts between debug mode and release mode versions.
	*/
	private static $debug = null;

	public function __construct(ShowPlusParameters $params = null) {
		if (is_null($params)) {
			$this->params = new ShowPlusParameters();
		} else {
			$this->params = $params;
		}
		if (is_null(self::$debug)) {  // first module loaded sets debug mode
			self::$debug = $this->params->debug;
		}
	}

	//
	// Image slideshow HTML generation
	//

	/**
	* Generates image slideshow with thumbnails, alternate text, and target activation on mouse click.
	*/
	public function getSlideshowHtml() {
		$oblevel = ob_get_level();
		try {
			return $this->getImageSlideshowHtml();
		} catch (Exception $e) {  // local error
			for ($k = ob_get_level(); $k > $oblevel; $k--) {  // release output buffers
				ob_end_clean();
			}
			$app = JFactory::getApplication();
			$app->enqueueMessage($e->getMessage(), 'error');
			return $e->getMessage();
		}
	}

	private function getImageSlideshowHtml() {
		$path = JPATH_ROOT.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $this->params->folder);
		if (!file_exists($path)) {
			throw new ShowPlusImageFolderException($path);
		}

		// set slideshow identifier
		if ($this->params->id) {  // use user-supplied identifier
			$id = $this->params->id;
		} else {  // automatically generate identifier for slideshow
			$id = $this->params->folder;
			if ($this->params->moduleclass_sfx) {
				$id .= '_'.$this->params->moduleclass_sfx;
			}
			$id = 'showplus_'.preg_replace('/[^A-Za-z0-9_\-]/', '', str_replace('/', '_', $id));  // clear non-conformant special characters from name
		}
		$id = self::getUniqueId($id);

		// substitute proper left or right alignment depending on whether language is LTR or RTL
		$language = JFactory::getLanguage();
		$alignment = str_replace(array('before','after'), $language->isRTL() ? array('right','left') : array('left','right'), $this->params->alignment);

		// set image slideshow alignment on page (left, center or right)
		$style = array('showplus-noscript');  // will be removed when script launches
		switch ($alignment) {
			case 'left': case 'left-clear': case 'left-float': $style[] = 'showplus-left'; break;
			case 'center': $style[] = 'showplus-center'; break;
			case 'right': case 'right-clear': case 'right-float': $style[] = 'showplus-right'; break;
		}
		switch ($alignment) {
			case 'left': case 'left-float': case 'right': case 'right-float': $style[] = 'showplus-float'; break;
			case 'left-clear': case 'right-clear': $style[] = 'showplus-clear'; break;
		}
		if ($this->params->orientation !== false) {
			// set orientation
			if (strpos($this->params->orientation, 'horizontal') !== false) {
				$style[] = 'showplus-horizontal';
			} elseif (strpos($this->params->orientation, 'vertical') !== false) {
				$style[] = 'showplus-vertical';
			}
		}
		
		// style for control button set, corresponds to a set of rules in "slideshow.css"
		if ($this->params->buttons) {
			$style[] = 'showplus-'.$this->params->buttons;
		}

		// fetch image labels
		switch ($this->params->labels) {
			case 'filename':
				$labels = $this->getLabelsFromFilenames(); break;
			default:
				if (empty($this->params->labels_captions)) {
					$labels = $this->getLabelsFromExternalFile();  // labels file may override default caption and hyperlink set in back-end
				} else {
					$labels = $this->getLabelsFromString($this->params->labels_captions);
				}
		}
		$sort_order = $this->params->sort_order == SHOWPLUS_SORT_DESCENDING ? SHOWPLUS_DESCENDING : SHOWPLUS_ASCENDING;
		switch ($this->params->sort_criterion) {
			case SHOWPLUS_SORT_LABELS_OR_FILENAME:
				if (empty($labels)) {  // there is no labels file to use
					$files = ShowPlusUtility::scandirsorted($path, SHOWPLUS_FILENAME, $sort_order);
					$data = $this->getUnlabeledImageSlideshow($files, $id);
				} else {
					$data = $this->getUserDefinedImageSlideshow($labels, $id);
				}
				break;
			case SHOWPLUS_SORT_LABELS_OR_MTIME:
				if (empty($labels)) {
					$files = ShowPlusUtility::scandirsorted($path, SHOWPLUS_MTIME, $sort_order);
					$data = $this->getUnlabeledImageSlideshow($files, $id);
				} else {
					$data = $this->getUserDefinedImageSlideshow($labels, $id);
				}
				break;
			case SHOWPLUS_SORT_MTIME:
				$files = ShowPlusUtility::scandirsorted($path, SHOWPLUS_MTIME, $sort_order);
				$data = $this->getLabeledImageSlideshow($files, $labels, $id);
				break;
			case SHOWPLUS_SORT_RANDOM:
				$files = @scandir($path);
				// if (!empty($files)) { shuffle($files); }
				$data = $this->getLabeledImageSlideshow($files, $labels, $id);
				break;
			case SHOWPLUS_SORT_RANDOMLABELS:
				if (empty($labels)) {  // there is no labels file to use
					$files = @scandir($path);
					// if (!empty($files)) { shuffle($files); }
					$data = $this->getUnlabeledImageSlideshow($files, $id);
				} else {
					// shuffle($labels);
					$data = $this->getUserDefinedImageSlideshow($labels, $id);
				}
				break;
			default:  // case SHOWPLUS_SORT_FILENAME:
				$files = ShowPlusUtility::scandirsorted($path, SHOWPLUS_FILENAME, $sort_order);
				$data = $this->getLabeledImageSlideshow($files, $labels, $id);
				break;
		}

		if (empty($data)) {
			$html = JText::_('SHOWPLUS_EMPTY');
		} else {
			// add navigation links below slideshow
			if ($this->params->links) {
				$navigationlinks = '<div class="showplus-navigation"><a class="showplus-previous" href="#">'.JText::_('SHOWPLUS_PREVIOUS').'</a> &#x25C1; | &#x25B7; <a class="showplus-next" href="#">'.JText::_('SHOWPLUS_NEXT').'</a></div>';
			} else {
				$navigationlinks = '';
			}

			// generate HTML for main images
			$imagehtml = '';
			foreach ($data as $imagedata) {
				$imagehtml .= '<li>';
				if ($imagedata->hyperlink) {
					$imagehtml .= '<a href="'.$imagedata->hyperlink.'">';
				}
				$imagehtml .= '<img src="'.$imagedata->imageurl.'" alt="'.htmlspecialchars($imagedata->caption ? $imagedata->caption : $this->params->defcaption).'" />';
				if ($imagedata->hyperlink) {
					$imagehtml .= '</a>';
				}
				$imagehtml .= '</li>';
			}

			// generate HTML for thumbnails
			//$thumbhtml = '';
			//foreach ($data as $imagedata) { $thumbhtml .= '<li><a href="'.$imagedata->imageurl.'"><img src="'.$imagedata->thumburl.'" alt="" /></a></li>'; }

			// check if per-image initialization is needed
			if (!($needsInitialization = $this->params->thumb_cache)) {
				foreach ($data as $imagedata) {
					if ($imagedata->hyperlink) {
						$needsInitialization = true;
						break;
					}
				}
			}

			// produce HTML
			$html =
				'<div id="'.$id.'" class="'.implode(' ',$style).'">'.
					'<div class="showplus">'.
						'<ul class="showplus-images">'.$imagehtml.'</ul>'.
						//'<ul class="showplus-thumbnails">'.$thumbhtml.'</ul>'.
					'</div>'.
					$navigationlinks.
				'</div>';
		}

		$this->addHeadDeclarations($id, $needsInitialization ? $data : null);

		return $html;
	}

	/**
	* Ensures that an identifier is unique across the page.
	* An identifier is specified by the user or generated from the relative image source path. Other extensions,
	* however, may duplicate article content on the page (e.g. show a short article extract as part of a blog layout),
	* making an identifier no longer unique. This function adds an ordinal to prevent conflicts when the same content
	* would occur multiple times on the page, causing scripts not to function properly.
	*/
	private static function getUniqueId($id) {
		static $ids = array();

		if (in_array($id, $ids)) {  // look for identifier in script-lifetime container
			$counter = 1000;
			do {
				$counter++;
				$gid = $id.'_'.$counter;
			} while (in_array($gid, $ids));
			$id = $gid;
		}
		$ids[] = $id;
		return $id;
	}

	/**
	* Generates an image slideshow entirely defined with a list of filenames or a list of label objects.
	* @param list An array of filenames and/or label objects.
	*/
	private function getUserDefinedImageSlideshow(array $list, $id) {
		$this->createThumbnailImages($list);

		$data = array();
		foreach ($list as $index => $listitem) {
			if (is_string($listitem)) {
				$data[] = $this->getImageData($id, $index, $listitem);
			} else {
				$data[] = $this->getImageData($id, $index, $listitem->imagefile, $listitem);
			}
		}
		return $data;
	}

	/**
	* Generates an image slideshow where some files have labels.
	*/
	private function getLabeledImageSlideshow(array $files, array $labels, $id) {
		if (empty($files)) {
			return false;
		}
		$labelmap = array();
		foreach ($labels as $label) {  // enumerate images listed in labels.txt
			$labelmap[$label->imagefile] = $label;
		}
		$files = array_values(array_filter($files, array('ShowPlusUtility', 'is_image_file')));
		$this->createThumbnailImages($files);

		$data = array();
		foreach ($files as $index => $file) {
			$data[] = $this->getImageData($id, $index, $file, isset($labelmap[$file]) ? $labelmap[$file] : null);
		}
		return $data;
	}

	/**
	* Generates an image slideshow where files have no labels.
	*/
	private function getUnlabeledImageSlideshow(array $files, $id) {
		return $this->getLabeledImageSlideshow($files, array(), $id);
	}

	/**
	* Returns HTML code for an image in a gallery list.
	*/
	private function getImageData($id, $index, $imagefile, $label = null) {
		// get thumbnail image URL
		if ($this->params->thumb_cache) {
			$thumbbase = 'cache';
			$imagepath = JPATH_ROOT.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $this->params->folder.'/'.$imagefile);
			$thumbfile = md5('showplus:'.$this->params->thumb_width.'x'.$this->params->thumb_height.':'.$this->params->thumb_quality.':'.$imagepath).'.'.pathinfo($imagefile, PATHINFO_EXTENSION);
		} else {
			$thumbbase = $this->params->folder;
			$thumbfile = $imagefile;
		}
		$thumburl = JURI::base(true).'/'.$thumbbase.'/'.$this->params->thumb_folder.'/'.$thumbfile;

		// get original image URL
		$imageurl = JURI::base(true).'/'.$this->params->folder.'/'.$imagefile;

		// get image caption
		$imagecaption = $this->params->defcaption;
		$hyperlink = $this->params->deflink ? str_replace('{$index}', $index, $this->params->deflink) : false;
		if ($label) {
			if ($label instanceof ShowPlusImageLabel) {
				if ($label->caption) {
					$imagecaption = $label->caption;
				}
				if ($label->hyperlink) {
					$hyperlink = $label->hyperlink;
				}
			} elseif (is_string($label)) {
				$imagecaption =  $label;
			}
		}

		// return data
		return new ShowPlusImageData($imageurl, $thumburl, $hyperlink, $imagecaption);
	}

	/**
	* Adds style and script declarations for an image slideshow.
	*/
	private function addHeadDeclarations($id, $data = null) {
		$document = JFactory::getDocument();

		// add style imports
		$document->addStyleSheet(JURI::base(true).'/modules/mod_showplus/css/slideshow'.(self::$debug ? '' : '.min').'.css');
		if ($document->getType() == 'html') {  // custom tags are supported by HTML document type only
			$document->addCustomTag('<!--[if lt IE 8]><link rel="stylesheet" href="'.JURI::base(true).'/modules/mod_showplus/css/slideshow.ie7.css" type="text/css" /><![endif]-->');
		}

		// compile list of scripts to import
		$scripts = array('slideshow');
		switch ($this->params->transition) {
			case 'flash': case 'fold': case 'kenburns': case 'push':
				$scripts[] = 'ext/slideshow.'.$this->params->transition;
				break;
			case 'fade':
			default:
		}

		// add script imports
		JHTML::_('behavior.framework', true);  // include MooTools Core and MooTools More
		foreach ($scripts as $script) {
			$document->addScript(JURI::base(true).'/modules/mod_showplus/js/'.$script.(self::$debug ? '' : '.min').'.js');
		}
		//if ($this->params->thumb_cache) { $document->addScript(JURI::base(true).'/modules/mod_showplus/js/md5'.(self::$debug ? '' : '.min').'.js'); }

		// add inline style declarations based on back-end settings
		$rules = array();
		if ($this->params->margin !== false) {
			$rules['margin-top'] = $this->params->margin.'px !important';
			$rules['margin-bottom'] = $this->params->margin.'px !important';
			$language = JFactory::getLanguage();
			$alignment = str_replace(array('before','after'), $language->isRTL() ? array('right','left') : array('left','right'), $this->params->alignment);
			switch ($alignment) {
				case 'left-float':
					$rules['margin-right'] = $this->params->margin.'px !important'; break;
				case 'right-float':
					$rules['margin-left'] = $this->params->margin.'px !important'; break;
			}
		}
		if ($this->params->border_width !== false && $this->params->border_style !== false && $this->params->border_color !== false) {
			$rules['border'] = $this->params->border_width.'px '.$this->params->border_style.' #'.$this->params->border_color;
		} else {
			if ($this->params->border_width !== false) {
				$rules['border-width'] = $this->params->border_width.'px';
			}
			if ($this->params->border_style !== false) {
				$rules['border-style'] = $this->params->border_style;
			}
			if ($this->params->border_color !== false) {
				$rules['border-color'] = '#'.$this->params->border_color;
			}
		}
		if ($this->params->padding !== false) {
			$rules['padding'] = $this->params->padding.'px';
		}

		if ($this->params->orientation !== false) {  // enable thumbnails if horizontal or vertical orientation is set
			// determine orientation
			if (strpos($this->params->orientation, 'horizontal') !== false) {
				$orientation = 'horizontal';

				// determine placement
				if (strpos($this->params->orientation, 'bottom') !== false) {
					$placement = 'bottom';
				} elseif (strpos($this->params->orientation, 'top') !== false) {
					$placement = 'top';
				} else {
					$placement = 'bottom';  // default placement for horizontally oriented navigation bar
				}
			} elseif (strpos($this->params->orientation, 'vertical') !== false) {
				$orientation = 'vertical';

				// determine placement
				if (strpos($this->params->orientation, 'right') !== false) {
					$placement = 'right';
				} elseif (strpos($this->params->orientation, 'left') !== false) {
					$placement = 'left';
				} else {
					$placement = 'right';  // default placement for vertically oriented navigation bar
				}
			} else {
				$orientation = 'disabled';
				$placement = 'disabled';
			}
		} else {
			$orientation = 'disabled';
			$placement = 'disabled';
		}

		$spacing = 20;  // space reserved between slideshow main image and thumbnail navigation bar
		$thumb_margin = 20;  // space reserved in thumbnail navigation bar height/width for thumbnail margin and padding in excess of thumbnail image size
		switch ($orientation) {
			case 'disabled':
				$rules['height'] = $this->params->height.'px';
				$rules['width'] =  $this->params->width.'px';
				$selectors = array();
				break;
			case 'vertical':
				$width_extension = $this->params->autohide ? 0 : $spacing + $this->params->thumb_width;
				$rules['height'] = $this->params->height.'px';
				$rules['width'] =  ($this->params->width + $width_extension).'px';
				$selectors = array(
					'#'.$id.' .showplus' => array(
						'margin-'.$placement => $width_extension.'px'  // do not reserve space for auto-hide
					),
					'#'.$id.' .showplus-thumbnails' => array(
						'height' => $this->params->height.'px',
						'left' => 'auto',  // may be overwritten by key $placement
						'right' => 'auto',  // may be overwritten by key $placement
						$placement => -$width_extension.'px',  // align with exact left/right for auto-hide
						'top' => '0',
						'width' => ($thumb_margin + $this->params->thumb_width).'px'
					),
					'#'.$id.' .showplus-thumbnails ul' => array(
						'height' => '10000px',
						'width' => $this->params->thumb_width.'px'
					)
				);
				break;
			case 'horizontal':
				$height_extension = $this->params->autohide ? 0 : $spacing + $this->params->thumb_height;
				$rules['height'] = ($this->params->height + $height_extension).'px';
				$rules['width'] =  $this->params->width.'px';
				$selectors = array(
					'#'.$id.' .showplus' => array(
						'margin-'.$placement => $height_extension.'px'  // do not reserve space for auto-hide
					),
					'#'.$id.' .showplus-thumbnails' => array(
						'height' => ($thumb_margin + $this->params->thumb_height).'px',
						$placement => -$height_extension.'px'  // align with exact top/bottom for auto-hide
					),
					'#'.$id.' .showplus-thumbnails ul' => array(
						'height' => $this->params->thumb_height.'px',
						'width' => '10000px'
					)
				);
				break;
			default:
		}
		$selectors['#'.$id] = $rules;
		$selectors['#'.$id.' .showplus, .showplus-images'] = array(
			'height' => $this->params->height.'px',
			'width' => $this->params->width.'px'
		);

		// background color for preview images smaller than main image area
		if ($this->params->background_color !== false) {
			$selectors['#'.$id.' .showplus-images span'] = array(
				'background-color' => '#'.$this->params->background_color
			);
		}

		// thumbnail colors
		if ($this->params->thumb_color_active !== false) {
			$selectors['#'.$id.' .showplus-thumbnails-active'] = array(
				'background-color' => '#'.$this->params->thumb_color_active.' !important'
			);
		}
		if ($this->params->thumb_color_hover !== false) {
			$selectors['#'.$id.' .showplus-thumbnails a:hover'] = array(
				'background-color' => '#'.$this->params->thumb_color_hover.' !important'
			);
		}

		// overlay image
		if ($this->params->overlay_position !== false) {
			$overlayrules = array(
				'background-position' => str_replace('-', ' ', $this->params->overlay_position).' !important'
			);
			if ($this->params->overlay_source) {
				$overlayrules['background-image'] = 'url("'.JURI::base(true).'/'.str_replace(DIRECTORY_SEPARATOR, '/', $this->params->overlay_source).'") !important';
			}
			$selectors['#'.$id.' .showplus-overlay'] = $overlayrules;
		}

		$css = '';
		foreach ($selectors as $selector => $rules) {
			if (!empty($rules)) {
				$css .= $selector." { ";
				foreach ($rules as $name => $value) {
					$css .= $name.':'.$value.'; ';
				}
				$css .= "}\n";
			}
		}
		$document->addStyleDeclaration($css);

		// add inline script declarations
		if (empty($data)) {
			$array = null;
		} else {
			$array = array();
			foreach ($data as $imagedata) {
				$arrayparams = array(
					'caption' => $imagedata->caption ? $imagedata->caption : $this->params->defcaption,
					'href' => $imagedata->hyperlink ? $imagedata->hyperlink : 'javascript:void(0);'
				);
				if (isset($imagedata->thumb_width) && isset($imagedata->thumb_height)) {  // settings specific to a single thumbnail, typically not used
					$arrayparams['thumbsize'] = array($imagedata->thumbwidth, $imagedata->thumbheight);
				}
				if ($this->params->orientation !== false && $this->params->thumb_cache) {
					$arrayparams['thumbnail'] = $imagedata->thumburl;
				}
				if ($imagedata->hyperlink) {
					$arrayparams['target'] = $this->params->target;
				}
				$array[$imagedata->imageurl] = $arrayparams;
			}
		}
		$options = array(
			'width' => $this->params->width,
			'height' => $this->params->height,
			'thumbsize' => array($this->params->thumb_width,$this->params->thumb_height),
			'captions' => $this->params->captions,
			'controller' => (bool)$this->params->buttons,  // show controller if button set style is specified
			'delay' => $this->params->delay,
			'duration' => $this->params->duration,
			'overlay' => $this->params->overlay_position !== false ? $this->params->overlay_text : false,
			'transition' => $this->params->transition_easing
		);
		
		switch ($orientation) {
			case 'horizontal':
				$options['thumbnails'] = array('scroll' => 'x'); break;
			case 'vertical':
				$options['thumbnails'] = array('scroll' => 'y'); break;
		}
		if (isset($options['thumbnails'])) {
			$options['thumbnails']['speed'] = $this->params->scroll_speed;
			$options['thumbnails']['autohide'] = $this->params->autohide ? $placement : false;
		}

		if (file_exists(JPATH_ROOT.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'mod_showplus'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'loader.png')) {
			$options['loader'] = true;
		}

		switch ($this->params->sort_criterion) {
			case SHOWPLUS_SORT_RANDOM:
			case SHOWPLUS_SORT_RANDOMLABELS:
				$options['random'] = true;
		}
		switch ($this->params->transition) {
			case 'fade':
				$class = 'Slideshow';
				break;
			case 'flash':
				$class = 'Slideshow.Flash';
				break;
			case 'fold':
				$class = 'Slideshow.Fold';
				break;
			case 'kenburns':
				$class = 'Slideshow.KenBurns';
				$options['pan'] = $this->params->transition_pan;
				$options['zoom'] = $this->params->transition_zoom;
				break;
			case 'push':
				$class = 'Slideshow.Push';
				break;
		}
		$args = array(
			'classes:["showplus"]',
			'replace:[/\/([^\/]+)$/, "/'.$this->params->thumb_folder.'/$1"]'
		);

		// add initialization script
		$node = 'document.id("'.$id.'")';
		$instance = 'new '.$class.'('.$node.'.removeClass("showplus-noscript").getElement("div"), '.json_encode($array).', Object.append('.json_encode($options).', {'.implode(',',$args).'}));';
		if ($this->params->links) {
			$initialization = 'var slideshow = '.$instance.  // assign slideshow instance to variable for future referencing
				' '.$node.'.getElement("a.showplus-previous").addEvent("click", function () { slideshow.prev(); return false; });'.
				' '.$node.'.getElement("a.showplus-next").addEvent("click", function () { slideshow.next(); return false; });';
		} else {
			$initialization = $instance;
		}
		$document->addScriptDeclaration('window.addEvent("load", function () { '.$initialization.' });');
	}

	//
	// Thumbnail image generation
	//

	/**
	* Pre-generates a set of thumbnail images.
	* @param list A list of original image filenames, or a list of ShowPlusImageLabel instances.
	*/
	private function createThumbnailImages(array $list) {
		if ($this->params->orientation !== false) {  // navigation bar with image thumbnails is enabled
			if ($this->params->thumb_cache) {
				$imagedirectory = JPATH_CACHE.DIRECTORY_SEPARATOR.$this->params->thumb_folder;
			} else {
				$imagedirectory = JPATH_ROOT.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $this->params->folder).DIRECTORY_SEPARATOR.$this->params->thumb_folder;
			}
			ShowPlusUtility::make_directory($imagedirectory);  // create thumbnail image folder if necessary

			foreach ($list as $listitem) {
				$this->createThumbnailImage($imagedirectory, is_string($listitem) ? $listitem : $listitem->imagefile);
			}
		}
	}

	/**
	* Creates a thumbnail image for an original.
	* Images are generated only if they do not already exist.
	*/
	private function createThumbnailImage($imagedirectory, $imagefile) {
		$imagepath = JPATH_ROOT.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $this->params->folder.'/'.$imagefile);

		require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'thumbs.php';
		$imagelibrary = ShowPlusImageLibrary::instantiate($this->params->library);

		// create thumbnail image
		if ($this->params->thumb_cache) {
			$imagehashedname = md5('showplus:'.$this->params->thumb_width.'x'.$this->params->thumb_height.':'.$this->params->thumb_quality.':'.$imagepath).'.'.pathinfo($imagefile, PATHINFO_EXTENSION);
			$previewpath = $imagedirectory.DIRECTORY_SEPARATOR.$imagehashedname;
		} else {
			$previewpath = $imagedirectory.DIRECTORY_SEPARATOR.$imagefile;
		}
		if (!is_file($previewpath)) {  // create image on-the-fly if not exists
			$result = $imagelibrary->createThumbnail($imagepath, $previewpath, $this->params->thumb_width, $this->params->thumb_height, true, $this->params->thumb_quality);
		}
	}

	//
	// Image labels
	//

	/**
	* Generates labels from image filenames.
	* @return A (possibly empty) array of ShowPlusImageLabel instances.
	*/
	private function getLabelsFromFilenames() {
		$files = @scandir(JPATH_ROOT.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $this->params->folder));
		if ($files === false) {
			return array();
		}
		$files = array_filter($files, array('ShowPlusUtility', 'is_regular_file'));  // list files inside the specified path but omit hidden files
		$files = array_filter($files, array('ShowPlusUtility', 'is_image_file'));
		$labels = array();
		foreach ($files as $file) {
			$labels[] = new ShowPlusImageLabel($file, null, pathinfo($file, PATHINFO_FILENAME));
		}
		return $labels;
	}

	/**
	* Returns the language-specific labels filename.
	* @return File system path to the language file to use, or false if no labels file exists.
	*/
	private function getLabelsFilename() {
		if ($this->params->labels_multilingual) {  // check for language-specific labels file
			$lang = JFactory::getLanguage();
			$labelsfile = JPATH_ROOT.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $this->params->folder).DIRECTORY_SEPARATOR.$this->params->labels.'.'.$lang->getTag().'.txt';
			if (is_file($labelsfile)) {
				return $labelsfile;
			}
		}
		// default to language-neutral labels file
		$labelsfile = JPATH_ROOT.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $this->params->folder).DIRECTORY_SEPARATOR.$this->params->labels.'.txt';  // filesystem path to labels file
		if (is_file($labelsfile)) {
			return $labelsfile;
		}
		return false;
	}

	/**
	* Short captions attached to images with a "labels.txt" file.
	* @return An array of ShowPlusImageLabel instances, or an empty array of no "labels.txt" file is found.
	*/
	private function getLabelsFromExternalFile() {
		$labelsfile = $this->getLabelsFilename();
		if ($labelsfile === false) {
			return array();
		}
		$labels = array();
		$contents = file_get_contents($labelsfile);
		if (!strcmp("\xEF\xBB\xBF", substr($contents,0,3))) {  // file starts with UTF-8 BOM
			$contents = substr($contents, 3);  // remove UTF-8 BOM
		}
		return $this->getLabelsFromString($contents);
	}

	/**
	* Short captions attached to images where the labels source is a string.
	* @return An array of ShowPlusImageLabel instances, or an empty array.
	*/
	private function getLabelsFromString($contents) {
		$contents = str_replace("\r", "\n", $contents);  // normalize line endings
		$matches = array();
		preg_match_all('/^([^|\r\n]+)(?:[|]([^|\r\n]*)(?:[|]([^\r\n]*))?)?$/mu', $contents, $matches, PREG_SET_ORDER);
		switch (preg_last_error()) {
			case PREG_BAD_UTF8_ERROR:
				throw new ShowPlusEncodingException($labelsfile);
		}
		foreach ($matches as $match) {
			$imagefile = $match[1];
			$hyperlink = false;
			$caption = false;
			switch (count($match) - 1) {
				case 3:
					$hyperlink = $match[2];
					$caption = html_entity_decode($match[3], ENT_QUOTES, 'UTF-8');
					break;
				case 2:
					if (preg_match('/^(?:https?|ftps?|javascript):/', $match[2])) {  // looks like a URL
						$hyperlink = $match[2];
					} else {
						$caption = html_entity_decode($match[2], ENT_QUOTES, 'UTF-8');
					}
					break;
			}

			if ($imagefile == '*') {  // set default label
				if ($hyperlink) {
					$this->params->deflink = $hyperlink;
				}
				if ($caption) {
					$this->params->defcaption = $caption;
				}
			} else {
				if (ShowPlusUtility::is_remote_path($imagefile)) {  // a URL to a remote image
					$imagefile = ShowPlusUtility::safeurlencode($imagefile);
				} else {  // a local image
					$imagefile = ShowPlusUtility::file_exists_lenient($this->params->folder.DIRECTORY_SEPARATOR.$imagefile);
					if ($imagefile === false) {  // check that image file truly exists
						continue;
					}
				}
				$labels[] = new ShowPlusImageLabel($imagefile, $hyperlink, $caption);
			}
		}
		return $labels;
	}
}