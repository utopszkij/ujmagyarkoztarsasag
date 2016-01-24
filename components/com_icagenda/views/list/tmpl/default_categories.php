<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version		3.5.4 2015-04-21
 * @since       3.4.1
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

$catid_array = array();
$catinfos_array = array();

if ($this->data->items && $this->cat_description && count($this->getAllDates) > 0)
{
	foreach ($this->data->items AS $cat)
	{
		$cat_id		= $cat->cat_id;
		$cat_title	= $cat->cat_title;
		$cat_color	= $cat->cat_color;

		if ($cat->cat_desc)
		{
			$cat_desc = $cat->cat_desc;
		}
		else
		{
			$cat_desc = ' ';
		}

		$fontColor = $cat->fontColor;

		array_push($catid_array, $cat_id);

		$array				= array($cat_title, $cat_color, $cat_desc, $fontColor);
		$comma_separated	= implode("::", $array);

		if (!in_array($comma_separated, $catinfos_array))
		{
			array_push($catinfos_array, $comma_separated);
		}
	}
}

$cat_result = array_unique($catid_array);

if (count($catinfos_array))
{
	echo '<div class="ic-header-categories ic-clearfix">';
}

for ($i = 0; $i < count($catinfos_array); $i++)
{
	$cat_getinfos = explode('::', $catinfos_array[$i]);

	if (in_array('1', $this->cat_options))
	{
		echo '<div class="cat_header_title ' . $cat_getinfos['3'] . ' ic-clearfix"';
		echo ' style="background: ' . $cat_getinfos['1'] . ';">' . $cat_getinfos['0'];
		echo ' </div>';
	}
	if (in_array('2', $this->cat_options))
	{
		echo '<div class="cat_header_desc ic-clearfix">' . $cat_getinfos['2'] . '</div>';
	}
}

if (count($catinfos_array))
{
	echo '</div>';
}
