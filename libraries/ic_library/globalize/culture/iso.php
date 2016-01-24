<?php
/**
 *------------------------------------------------------------------------------
 *	iCagenda Globalization - International Date Formats
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     3.3.6 2014-05-03
 * @since       2.1.7
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

		// International Date Format (ISO)
		$iso = 'Y - m - d';

		// DMY Little-endian (day, month, year), e.g. 30.04.93 or 30/04/93
		$dmy_1 = 'd * m * Y';
		$dmy_2 = 'd * m * y';
		$dmy_3 = 'd * m';
		$dmy_4 = 'm * y';
		$dmy_5 = 'd * F * Y';
		$dmy_6 = 'd * M * Y';

		// MDY Middle-endian (month, day, year), e.g. 04/30/93
		$mdy_1 = 'm * d * Y';
		$mdy_2 = 'm * d * y';
		$mdy_3 = 'm * d';
		$mdy_4 = 'm * y';
		$mdy_5 = 'F * d * Y';
		$mdy_6 = 'M * d * Y';

		// YMD Big-endian (year, month, day), e.g. 1993-04-30
		$ymd_1 = 'Y * m * d';
		$ymd_2 = 'y * m * d';
		$ymd_3 = 'm * d';
		$ymd_4 = 'y * m';
		$ymd_5 = 'Y * F * d';
		$ymd_6 = 'Y * M * d';
