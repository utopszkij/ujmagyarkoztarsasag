<?php
/**
 *	iCagenda Globalization :: fa-IR - Persian (Iran)
 *----------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright	Copyright (C)2012-2015 JOOMLIC - All rights reserved.

 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Jooml!C - http://www.joomlic.com
 *
 * @update		2015-04-24
 * @version		3.5.4
 *----------------------------------------------------------------------------
*/

// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

// TODO : Remove Short month (not available in Persian, and could return errors
			// Reference Date : 30 April 1993, the birth of the web

			$dateglobalize_1 = '1372/02/10';
			$datevalue_1 = 'Y / m / d';

			$dateglobalize_2 = JText::_('FEBRUARY') . ' 10, 1372';
			$datevalue_2 = 'F _ d , _ Y';

			$dateglobalize_4 = JText::_('FEBRUARY') . ' 10';
			$datevalue_4 = 'F _ d';

			$dateglobalize_6 = JText::_('FEBRUARY') . ' 1372';
			$datevalue_6 = 'F _ Y';

			$dateglobalize_7 = JText::_('FRIDAY') . ' , _ ' . JText::_('FEBRUARY'). ' 10, 1372';
			$datevalue_7 = 'l , _ F _ d , _ Y';

			$dateglobalize_8 = JText::_('FRIDAY') . ' , _ ' . JText::_('FEBRUARY'). ' 10';
			$datevalue_8 = 'l , _ F _ d';


			$dmy_text_5 = '10␣' . JText::_('FEBRUARY') . '␣1372';
			$dmy_text_6 = '10␣' . JText::_('FEBRUARY_SHORT') . '␣1372';

			$mdy_text_5 = JText::_('FEBRUARY') . '␣10␣1372';
			$mdy_text_6 = JText::_('FEBRUARY_SHORT') . '␣10␣1372';

			$ymd_text_5 = '1372␣' . JText::_('FEBRUARY') . '␣10';
			$ymd_text_6 = '1372␣' . JText::_('FEBRUARY_SHORT') . '␣10';
