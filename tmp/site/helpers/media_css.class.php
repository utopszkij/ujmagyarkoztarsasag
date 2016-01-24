<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      doorknob
 * @link        http://www.joomlic.com
 *
 * @version     3.4.0 2014-12-20
 * @since       3.3.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die;

/**
 * CSS @media class for iCagenda
 *
 * @since  3.3.0
 */
class iCagendaMediaCss
{
	/**
	 * Builds the CSS to be bracketed by @media statements and then inserts it into the document header
	 *
	 * @param   string  $template  The name of the theme
	 * @param   string  $type      The source of the CSS to be added:
	 *                             'component' - add the component part of the CSS
	 *                             'module' - add the module part of the CSS
	 *
	 * @return void
	 */
	public static function addMediaCss($template='default', $type='component')
	{
		// Prepare the CSS
		$css = self::getMediaCss($template, $type);
		self::writeMediaCss($css);
	}

	/**
	 * Builds the CSS to be bracketed by @media statements from separate files
	 *
	 * @param   string  &$template  The name of the theme
	 * @param   string  &$type      The source of the CSS to be added:
	 *                              'component' - add the component part of the CSS
	 *                              'module' - add the module part of the CSS
	 *
	 * @return  string CSS to be added to the page
	 */
	public static function getMediaCss(&$template, &$type)
	{
		/*
		 * Load the Theme Pack supplements for screen size variants
		 * This is based on the four screen sized defined by Bootstrap 3 (i.e. large, medium, small and extra small)
		 * The threshold values are defined in the component parameter set so that the component and any modules can
		 * use consistent values.
		 */
		jimport('joomla.application.component.helper');
		$com_params = JComponentHelper::getParams('com_icagenda');
		$media_css = '';
		$max_threshold = 0;
		$largethreshold = (int) $com_params->get('largewidththreshold', 0);
		$mbString     = extension_loaded('mbstring');

		if ($largethreshold > 0)
		{
			$css_contents = @file_get_contents(
				JPATH_ROOT . "/components/com_icagenda/themes/packs/$template/css/{$template}_{$type}_large.css");

			$css = preg_replace('!/\*.*?\*/!s', '', $css_contents);
			$size_css = $mbString ? mb_strlen($css) : strlen($css);

//			if (is_string($css) && !empty($css) && ($size_css > 10))
//			{
				$media_css .= "\n@media screen and (min-width:{$largethreshold}px){\n{$css}\n}\n";
				$max_threshold = $largethreshold - 1;
//			}
		}

		$mediumthreshold = (int) $com_params->get('mediumwidththreshold', 0);

		if ($mediumthreshold > 0)
		{
			$css_contents = @file_get_contents(
				JPATH_ROOT . "/components/com_icagenda/themes/packs/$template/css/{$template}_{$type}_medium.css");

			$css = preg_replace('!/\*.*?\*/!s', '', $css_contents);
			$size_css = $mbString ? mb_strlen($css) : strlen($css);

//			if (is_string($css) && !empty($css) && ($size_css > 10))
//			{
				$upper_limit = $max_threshold > 0 ? " and (max-width:{$max_threshold}px)" : '';
				$media_css .= "\n@media screen and (min-width:{$mediumthreshold}px)$upper_limit{\n{$css}\n}\n";
				$max_threshold = $mediumthreshold - 1;
//			}
		}

		$smallthreshold = (int) $com_params->get('smallwidththreshold', 0);

		if ($smallthreshold > 0)
		{
			$css_contents = @file_get_contents(
				JPATH_ROOT . "/components/com_icagenda/themes/packs/$template/css/{$template}_{$type}_small.css");

			$css = preg_replace('!/\*.*?\*/!s', '', $css_contents);
			$size_css = $mbString ? mb_strlen($css) : strlen($css);

//			if (is_string($css) && !empty($css) && ($size_css > 10))
//			{
				$upper_limit = $max_threshold > 0 ? " and (max-width:{$max_threshold}px)" : '';
				$media_css .= "\n@media screen and (min-width:{$smallthreshold}px)$upper_limit{\n{$css}\n}\n";
				$max_threshold = $smallthreshold - 1;
//			}

			$css_contents = @file_get_contents(
				JPATH_ROOT . "/components/com_icagenda/themes/packs/$template/css/{$template}_{$type}_xsmall.css");

			$css = preg_replace('!/\*.*?\*/!s', '', $css_contents);
			$size_css = $mbString ? mb_strlen($css) : strlen($css);

//			if (is_string($css) && !empty($css) && ($size_css > 10))
//			{
				$smallthreshold--;
				$media_css .= "\n@media screen and (max-width:{$smallthreshold}px){\n{$css}\n}\n";
//			}
		}

		return $media_css;
	}

	/**
	 * Write the CSS to the document header
	 *
	 * @param   string  &$css  The CSS to be written to the document
	 *
	 * @return void
	 */
	public static function writeMediaCss(&$css)
	{
		if (!empty($css))
		{
			$document = JFactory::getDocument();
			$document->addStyleDeclaration($css);
		}
	}
}
