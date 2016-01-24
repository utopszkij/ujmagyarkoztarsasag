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

require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'librarian.php';

// sort order for file system functions
define('SHOWPLUS_SORT_ASCENDING', 0);
define('SHOWPLUS_SORT_DESCENDING', 1);

// sort criterion override modes
define('SHOWPLUS_SORT_LABELS_OR_FILENAME', 0);  // sort based on labels file with fallback to file name
define('SHOWPLUS_SORT_LABELS_OR_MTIME', 1);     // sort based on labels file with fallback to last modified time
define('SHOWPLUS_SORT_FILENAME', 2);            // sort based on file name ignoring order in labels file
define('SHOWPLUS_SORT_MTIME', 3);               // sort based on last modified time ignoring order in labels file
define('SHOWPLUS_SORT_RANDOM', 4);              // random order
define('SHOWPLUS_SORT_RANDOMLABELS', 5);        // random order restricting images to those listed in labels file

class ShowPlusColors {
	/** Maps color names to color codes. */
	private static $colors;

	public static function translate($value) {
		if (!isset(self::$colors)) {
			$colors = array(
				'AliceBlue'=>0xF0F8FF,
				'AntiqueWhite'=>0xFAEBD7,
				'Aqua'=>0x00FFFF,
				'Aquamarine'=>0x7FFFD4,
				'Azure'=>0xF0FFFF,
				'Beige'=>0xF5F5DC,
				'Bisque'=>0xFFE4C4,
				'Black'=>0x000000,
				'BlanchedAlmond'=>0xFFEBCD,
				'Blue'=>0x0000FF,
				'BlueViolet'=>0x8A2BE2,
				'Brown'=>0xA52A2A,
				'BurlyWood'=>0xDEB887,
				'CadetBlue'=>0x5F9EA0,
				'Chartreuse'=>0x7FFF00,
				'Chocolate'=>0xD2691E,
				'Coral'=>0xFF7F50,
				'CornflowerBlue'=>0x6495ED,
				'Cornsilk'=>0xFFF8DC,
				'Crimson'=>0xDC143C,
				'Cyan'=>0x00FFFF,
				'DarkBlue'=>0x00008B,
				'DarkCyan'=>0x008B8B,
				'DarkGoldenRod'=>0xB8860B,
				'DarkGray'=>0xA9A9A9,
				'DarkGrey'=>0xA9A9A9,
				'DarkGreen'=>0x006400,
				'DarkKhaki'=>0xBDB76B,
				'DarkMagenta'=>0x8B008B,
				'DarkOliveGreen'=>0x556B2F,
				'Darkorange'=>0xFF8C00,
				'DarkOrchid'=>0x9932CC,
				'DarkRed'=>0x8B0000,
				'DarkSalmon'=>0xE9967A,
				'DarkSeaGreen'=>0x8FBC8F,
				'DarkSlateBlue'=>0x483D8B,
				'DarkSlateGray'=>0x2F4F4F,
				'DarkSlateGrey'=>0x2F4F4F,
				'DarkTurquoise'=>0x00CED1,
				'DarkViolet'=>0x9400D3,
				'DeepPink'=>0xFF1493,
				'DeepSkyBlue'=>0x00BFFF,
				'DimGray'=>0x696969,
				'DimGrey'=>0x696969,
				'DodgerBlue'=>0x1E90FF,
				'FireBrick'=>0xB22222,
				'FloralWhite'=>0xFFFAF0,
				'ForestGreen'=>0x228B22,
				'Fuchsia'=>0xFF00FF,
				'Gainsboro'=>0xDCDCDC,
				'GhostWhite'=>0xF8F8FF,
				'Gold'=>0xFFD700,
				'GoldenRod'=>0xDAA520,
				'Gray'=>0x808080,
				'Grey'=>0x808080,
				'Green'=>0x008000,
				'GreenYellow'=>0xADFF2F,
				'HoneyDew'=>0xF0FFF0,
				'HotPink'=>0xFF69B4,
				'IndianRed'=>0xCD5C5C,
				'Indigo'=>0x4B0082,
				'Ivory'=>0xFFFFF0,
				'Khaki'=>0xF0E68C,
				'Lavender'=>0xE6E6FA,
				'LavenderBlush'=>0xFFF0F5,
				'LawnGreen'=>0x7CFC00,
				'LemonChiffon'=>0xFFFACD,
				'LightBlue'=>0xADD8E6,
				'LightCoral'=>0xF08080,
				'LightCyan'=>0xE0FFFF,
				'LightGoldenRodYellow'=>0xFAFAD2,
				'LightGray'=>0xD3D3D3,
				'LightGrey'=>0xD3D3D3,
				'LightGreen'=>0x90EE90,
				'LightPink'=>0xFFB6C1,
				'LightSalmon'=>0xFFA07A,
				'LightSeaGreen'=>0x20B2AA,
				'LightSkyBlue'=>0x87CEFA,
				'LightSlateGray'=>0x778899,
				'LightSlateGrey'=>0x778899,
				'LightSteelBlue'=>0xB0C4DE,
				'LightYellow'=>0xFFFFE0,
				'Lime'=>0x00FF00,
				'LimeGreen'=>0x32CD32,
				'Linen'=>0xFAF0E6,
				'Magenta'=>0xFF00FF,
				'Maroon'=>0x800000,
				'MediumAquaMarine'=>0x66CDAA,
				'MediumBlue'=>0x0000CD,
				'MediumOrchid'=>0xBA55D3,
				'MediumPurple'=>0x9370D8,
				'MediumSeaGreen'=>0x3CB371,
				'MediumSlateBlue'=>0x7B68EE,
				'MediumSpringGreen'=>0x00FA9A,
				'MediumTurquoise'=>0x48D1CC,
				'MediumVioletRed'=>0xC71585,
				'MidnightBlue'=>0x191970,
				'MintCream'=>0xF5FFFA,
				'MistyRose'=>0xFFE4E1,
				'Moccasin'=>0xFFE4B5,
				'NavajoWhite'=>0xFFDEAD,
				'Navy'=>0x000080,
				'OldLace'=>0xFDF5E6,
				'Olive'=>0x808000,
				'OliveDrab'=>0x6B8E23,
				'Orange'=>0xFFA500,
				'OrangeRed'=>0xFF4500,
				'Orchid'=>0xDA70D6,
				'PaleGoldenRod'=>0xEEE8AA,
				'PaleGreen'=>0x98FB98,
				'PaleTurquoise'=>0xAFEEEE,
				'PaleVioletRed'=>0xD87093,
				'PapayaWhip'=>0xFFEFD5,
				'PeachPuff'=>0xFFDAB9,
				'Peru'=>0xCD853F,
				'Pink'=>0xFFC0CB,
				'Plum'=>0xDDA0DD,
				'PowderBlue'=>0xB0E0E6,
				'Purple'=>0x800080,
				'Red'=>0xFF0000,
				'RosyBrown'=>0xBC8F8F,
				'RoyalBlue'=>0x4169E1,
				'SaddleBrown'=>0x8B4513,
				'Salmon'=>0xFA8072,
				'SandyBrown'=>0xF4A460,
				'SeaGreen'=>0x2E8B57,
				'SeaShell'=>0xFFF5EE,
				'Sienna'=>0xA0522D,
				'Silver'=>0xC0C0C0,
				'SkyBlue'=>0x87CEEB,
				'SlateBlue'=>0x6A5ACD,
				'SlateGray'=>0x708090,
				'SlateGrey'=>0x708090,
				'Snow'=>0xFFFAFA,
				'SpringGreen'=>0x00FF7F,
				'SteelBlue'=>0x4682B4,
				'Tan'=>0xD2B48C,
				'Teal'=>0x008080,
				'Thistle'=>0xD8BFD8,
				'Tomato'=>0xFF6347,
				'Turquoise'=>0x40E0D0,
				'Violet'=>0xEE82EE,
				'Wheat'=>0xF5DEB3,
				'White'=>0xFFFFFF,
				'WhiteSmoke'=>0xF5F5F5,
				'Yellow'=>0xFFFF00,
				'YellowGreen'=>0x9ACD32
			);
			self::$colors = array_merge($colors, array_combine(array_map('strtolower', array_keys($colors)), array_values($colors)));
		}

		if (isset(self::$colors[$value])) {
			return sprintf('%06x', self::$colors[$value]);  // translate color name to color code
		} else {
			return false;
		}
	}
}

/**
* Parameter values for images galleries.
* Global values are defined in the administration back-end, which are overridden in-place with local parameter values.
*/
class ShowPlusParameters {
	/** Folder w.r.t. Joomla root the slideshow draws images from. */
	public $folder = 'images';
	/** Unique identifier to use for the slideshow. */
	public $id = false;
	/** Width of slideshow [px]. */
	public $width = 600;
	/** Height of slideshow [px]. */
	public $height = 400;
	/** Width of thumbnail images [px]. */
	public $thumb_width = 60;
	/** Height of thumbnail images [px]. */
	public $thumb_height = 40;

	/** Alignment of image slideshow on page. */
	public $alignment = 'before';
	/** Orientation of image slideshow thumbnails used for fast navigation, or false to disable thumbnail navigation bar. */
	public $orientation = false;
	/** Auto-hide thumbnails when mouse cursor leaves thumbnail navigation bar boundary. */
	public $autohide = false;
	/** Style of navigation control button set overlaying slideshow. */
	public $buttons = false;
	/** Show captions overlaying slideshow. */
	public $captions = true;
	/** Default text to assign to images that have no explicit caption set. */
	public $defcaption = false;
	/** Default hyperlink to assign to images as target. */
	public $deflink = false;
	/** Target for main image anchors. */
	public $target = false;

	/** Time each image is shown before a transition effect morphs one image into another [ms]. */
	public $delay = 2000;
	/** Time taken for a transition effect to morph one image into another [ms]. */
	public $duration = 800;
	/** Transition effect. */
	public $transition = 'fade';
	/** Transition easing function. */
	public $transition_easing = 'linear';
	/** Pan factor. */
	public $transition_pan = 100;
	/** Zoom factor. */
	public $transition_zoom = 50;
	/** Scroll speed factor. */
	public $scroll_speed = 50;

	/** Margin [px], or false for default (inherit from slideshow.css). */
	public $margin = false;
	/** Border width [px], or false for default (inherit from slideshow.css). */
	public $border_width = false;
	/** Border style, or false for default (inherit from slideshow.css). */
	public $border_style = false;
	/** Border color as a hexadecimal value in between 000000 or ffffff inclusive, or false for default. */
	public $border_color = false;
	/** Padding [px], or false for default (inherit from slideshow.css). */
	public $padding = false;
	/** Background color as a hexadecimal value in between 000000 or ffffff inclusive, or false for default. */
	public $background_color = false;

	/** Whether to display navigation links below the slideshow. */
	public $links = false;

	/** Overlay position. */
	public $overlay_position = false;
	/** Overlay source. */
	public $overlay_source = false;
	/** Overlay text. */
	public $overlay_text = false;

	/** Whether to use Joomla cache for storing thumbnails. */
	public $thumb_cache = true;
	/** Folder to store image thumbnails. */
	public $thumb_folder = 'showplus';
	/** Color around thumbnail when being shown in slideshow. */
	public $thumb_color_active = false;
	/** Color around thumbnail when mouse pointer is over the image. */
	public $thumb_color_hover = false;
	/** JPEG quality. */
	public $thumb_quality = 85;

	/** Labels file name. */
	public $labels = 'labels';
	/** Whether to use multilingual labeling. */
	public $labels_multilingual = false;
	/** Whether a labels file is updated when new images are added to the image folder. */
	public $labels_update = true;
	/** Labels file contents. */
	public $labels_captions = false;

	/** Sort criterion. */
	public $sort_criterion = SHOWPLUS_SORT_LABELS_OR_FILENAME;
	/** Sort order, ascending or descending. */
	public $sort_order = SHOWPLUS_SORT_ASCENDING;

	/** Image processing library to use. */
	public $library = 'default';
	/** Whether to use minified CSS and javascript files. */
	public $debug = false;

	public $moduleclass_sfx;

	private static function as_optional_string($value) {
		return $value !== false ? (string) $value : false;
	}

	/** Casts a value to a nonnegative integer. */
	private static function as_nonnegative_integer($value, $default = 0) {
		if (is_null($value) || $value === '') {
			return false;
		} elseif ($value !== false) {
			$value = (int) $value;
			if ($value < 0) {
				$value = $default;
			}
		}
		return $value;
	}

	private static function as_positive_integer($value, $default) {
		if (is_null($value) || $value === false || $value === '') {
			return $default;
		} else {
			$value = (int) $value;
			if ($value <= 0) {
				$value = $default;
			}
			return $value;
		}
	}

	private static function as_percentage($value) {
		$value = (int) $value;
		if ($value < 0) {
			$value = 0;
		}
		if ($value > 100) {
			$value = 100;
		}
		return $value;
	}

	private static function as_color($value) {
		if (empty($value)) {
			return false;
		} elseif (preg_match('/^[0-9A-Fa-f]{6}$/', $value)) {  // a hexadecimal color code
			return $value;
		} else {  //  a color name
			return ShowPlusColors::translate($value);
		}
	}

	private function validate() {
		$this->folder = str_replace("\\", '/', trim($this->folder, " /\\\n\r\t"));

		// dimensions
		$this->width = self::as_positive_integer($this->width, 600);
		$this->height = self::as_positive_integer($this->height, 400);
		$this->thumb_width = self::as_positive_integer($this->thumb_width, 60);
		$this->thumb_height = self::as_positive_integer($this->thumb_height, 40);

		// slideshow alignment and thumbnail bar orientation
		$language = JFactory::getLanguage();
		switch ($this->alignment) {
			case 'left': case 'left-clear': case 'left-float':
			case 'right': case 'right-clear': case 'right-float':
				str_replace(array('left','right'), $language->isRTL() ? array('after','before') : array('before','after'), $this->alignment); break;
			case 'before': case 'center': case 'right':
			case 'before-clear': case 'after-clear':
			case 'before-float': case 'after-float':
				break;
			default:
				$this->alignment = 'center';
		}
		if ($this->orientation !== false) {
			switch ($this->orientation) {
				case 'horizontal':  // horizontal bottom
				case 'horizontal-bottom': case 'horizontal-top':
				case 'vertical':  // vertical right
				case 'vertical-right': case 'vertical-left':
					break;
				case 'disabled': default:
					$this->orientation = false;
			}
		}
		$this->autohide = (bool) $this->autohide;

		// overlay buttons and captions
		if ($this->buttons) {
			switch ($this->buttons) {
				case 'full': case 'minimalistic': break;
				default: $this->buttons = 'full';
			}
		} else {
			$this->buttons = false;
		}
		$this->captions = (bool) $this->captions;
		$this->defcaption = self::as_optional_string($this->defcaption);
		$this->deflink = self::as_optional_string($this->deflink);
		$this->target = self::as_optional_string($this->target);

		// delay times [ms]
		$this->delay = self::as_nonnegative_integer($this->delay);
		$this->duration = self::as_nonnegative_integer($this->duration);
		switch ($this->transition) {
			case 'fade': case 'flash': case 'fold': case 'kenburns': case 'push': break;
			default: $this->transition = 'fade';
		}
		switch ($this->transition_easing) {
			case 'linear': case 'quad': case 'cubic': case 'quart': case 'quint':
			case 'expo': case 'circ': case 'sine': case 'back': case 'bounce': case 'elastic': break;
			default: $this->transition_easing = 'linear';
		}
		$this->transition_pan = self::as_percentage($this->transition_pan);
		$this->transition_zoom = self::as_percentage($this->transition_zoom);
		$this->scroll_speed = self::as_percentage($this->scroll_speed);

		// style
		$this->margin = self::as_nonnegative_integer($this->margin);
		$this->border_width = self::as_nonnegative_integer($this->border_width);
		switch ($this->border_style) {
			case 'none': case 'dotted': case 'dashed': case 'solid': case 'double': case 'groove': case 'ridge': case 'inset': case 'outset': break;
			default: $this->border_style = false;
		}
		$this->border_color = self::as_color($this->border_color);
		$this->padding = self::as_nonnegative_integer($this->padding);
		$this->background_color = self::as_color($this->background_color);

		// navigation links
		$this->links = (bool) $this->links;

		// overlay image
		switch ($this->overlay_position) {
			case 'left-top': case 'left-center': case 'left-bottom':
			case 'center-top': case 'center-center': case 'center-bottom':
			case 'right-top': case 'right-center': case 'right-bottom':
				break;
			case 'none':
			default:
				$this->overlay_position = false;
		}

		// thumbnail image generation
		$this->thumb_cache = (bool) $this->thumb_cache;
		$this->thumb_color_active = self::as_color($this->thumb_color_active);
		$this->thumb_color_hover = self::as_color($this->thumb_color_hover);
		$this->thumb_quality = self::as_percentage($this->thumb_quality);

		// image labels
		$this->labels = preg_replace('/[^A-Za-z0-9_\-]/', '', str_replace('.', '_', $this->labels));
		$this->labels_multilingual = (bool) $this->labels_multilingual;
		$this->labels_update = (bool) $this->labels_update;

		// sort criterion and sort order
		if (is_numeric($this->sort_criterion)) {
			$this->sort_criterion = (int) $this->sort_criterion;
		} else {
			switch ($this->sort_criterion) {
				case 'labels':
				case 'labels-filename':
				case 'labels-fname':
					$this->sort_criterion = SHOWPLUS_SORT_LABELS_OR_FILENAME; break;
				case 'labels-mtime':
					$this->sort_criterion = SHOWPLUS_SORT_LABELS_OR_MTIME; break;
				case 'filename':
				case 'fname':
					$this->sort_criterion = SHOWPLUS_SORT_FILENAME; break;
				case 'mtime':
					$this->sort_criterion = SHOWPLUS_SORT_MTIME; break;
				case 'random':
					$this->sort_criterion = SHOWPLUS_SORT_RANDOM; break;
				case 'randomlabels':
					$this->sort_criterion = SHOWPLUS_SORT_RANDOMLABELS; break;
				default:
					$this->sort_criterion = SHOWPLUS_SORT_LABELS_OR_FILENAME;
			}
		}
		if (is_numeric($this->sort_order)) {
			$this->sort_order = (int) $this->sort_order;
		} else {
			switch ($this->sort_order) {
				case 'asc':  case 'ascending':  $this->sort_order = SHOWPLUS_SORT_ASCENDING;  break;
				case 'desc': case 'descending': $this->sort_order = SHOWPLUS_SORT_DESCENDING; break;
				default:           $this->sort_order = SHOWPLUS_SORT_ASCENDING;
			}
		}

		// image library
		switch ($this->library) {
			case 'gd':
				if (!ShowPlusLibrarian::is_gd_supported()) {
					$this->library = 'default';
				}
				break;
			case 'imagick':
				if (!ShowPlusLibrarian::is_imagick_supported()) {
					$this->library = 'default';
				}
				break;
			default:
				$this->library = 'default';
		}
		switch ($this->library) {
			case 'default':
				if (ShowPlusLibrarian::is_imagick_supported()) {
					$this->library = 'imagick';
				} elseif (ShowPlusLibrarian::is_gd_supported()) {
					$this->library = 'gd';
				} else {
					$this->library = 'none';
				}
				break;
			default:
		}

		$this->debug = (bool) $this->debug;
	}

	/**
	* Hash value for the parameter object.
	*/
	public function hash() {
		return md5(serialize($this));
	}

	/**
	* Set parameters based on Joomla parameter object.
	*/
	public function setParameters(JRegistry $params) {
		foreach (get_class_vars(__CLASS__) as $name => $value) {
			$this->$name = $params->get($name, $value);
		}
		$this->validate();
	}
}