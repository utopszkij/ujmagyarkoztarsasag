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
 * @version     3.4.1 2014-12-24
 * @since       3.2.9
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();


class iCicons
{
	// --------------------------------------------------------------------------------
	// Buttons and Icons
	// --------------------------------------------------------------------------------

	/**
	 * Shows the button corresponding to the action.
	 *
	 * @param $type of action
	 * @param $link to be handled
	 * @return $html string
	 */
	public static function showIcon($type, $link = '', $vcal = '', $gcal = '', $wcal = '', $ycal = '')
	{
		// loading Global Options
		$iC_global = JComponentHelper::getParams('com_icagenda');

		// Component Options
		$iconAddToCal_options = $iC_global->get('iconAddToCal_options', '');
		$iconAddToCal_size = $iC_global->get('iconAddToCal_size', '16');

		$html = array();

		switch ( strtolower($type) )
		{
			case 'printpreview':

				$html[]= '<a class="iCtip" href="' . $link . '" onclick="window.open(this.href,\'win2\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no\'); return false;" title="' . JText::_('JGLOBAL_PRINT') . '" rel="nofollow">';

				// Joomla 3.x / 2.5 SWITCH
				if (version_compare(JVERSION, '3.0', 'ge'))
				{
					$html[]= '<span class="iCicon iCicon-print"></span>';
				}
				else
				{
					$html[]= JHtml::_('image', 'system/printButton.png', JText::_('JGLOBAL_PRINT'), null, true);
				}

				$html[]= '</a>';

				break;

			case 'print':

				$html[]= '<a href="#" onclick="window.print();return false;" title="' . JText::_('JGLOBAL_PRINT') . '" rel="nofollow">';

				// Joomla 3.x / 2.5 SWITCH
				if (version_compare(JVERSION, '3.0', 'ge'))
				{
					$html[]= '<span class="iCicon iCicon-print"></span>&#160;' . JText::_('JGLOBAL_PRINT') . '&#160;';
				}
				else
				{
					$html[]= JHtml::_('image', 'system/printButton.png', JText::_('JGLOBAL_PRINT'), null, true).'&#160;' . JText::_('JGLOBAL_PRINT') . '&#160;';
				}

				$html[]= '</a>';

				break;

			case 'vcal':

				if (is_array($iconAddToCal_options))
				{
					$addtocal = '';
					$addtocal.= '<div class="ic-tip-title">' . JText::_('COM_ICAGENDA_ADD_TO_CALL_LABEL') . '</div>';

					// Google Calendar - link
					if (in_array('1', $iconAddToCal_options))
					{
						$addtocal.= '<div class="ic-tip-link">';
						$addtocal.= '<a href="' . $gcal . '" class="ic-title-cal-tip" rel="nofollow" target="_blank">';
						$addtocal.= JHtml::_('image', 'media/com_icagenda/images/cal/google_cal-'.$iconAddToCal_size.'.png', JText::_('COM_ICAGENDA_GCALENDAR_LABEL'), array());
						$addtocal.= '&#160;' . JText::_('COM_ICAGENDA_GCALENDAR_LABEL') . '&#160;';
						$addtocal.= '</a>';
						$addtocal.= '</div>';
					}

					// iCal Calendar - ics
					if (in_array('2', $iconAddToCal_options))
					{
						$addtocal.= '<div class="ic-tip-link">';
						$addtocal.= '<a href="' . $vcal . '" class="ic-title-cal-tip" rel="nofollow" target="_blank">';
						$addtocal.= JHtml::_('image', 'media/com_icagenda/images/cal/apple_ical-'.$iconAddToCal_size.'.png', JText::_('COM_ICAGENDA_VCAL_ICAL_LABEL'), array());
						$addtocal.= '&#160;' . JText::_('COM_ICAGENDA_VCAL_ICAL_LABEL') . '&#160;';
						$addtocal.= '</a>';
						$addtocal.= '</div>';
					}

					// Outlook Calendar - ics
					if (in_array('3', $iconAddToCal_options))
					{
						$addtocal.= '<div class="ic-tip-link">';
						$addtocal.= '<a href="' . $vcal . '" class="ic-title-cal-tip" rel="nofollow" target="_blank">';
						$addtocal.= JHtml::_('image', 'media/com_icagenda/images/cal/outlook_cal-'.$iconAddToCal_size.'.png', JText::_('COM_ICAGENDA_OUTLOOK_LABEL'), array());
						$addtocal.= '&#160;' . JText::_('COM_ICAGENDA_OUTLOOK_LABEL') . '&#160;';
						$addtocal.= '</a>';
						$addtocal.= '</div>';
					}

					// Windows Live Calendar - link
					if (in_array('4', $iconAddToCal_options))
					{
						$addtocal.= '<div class="ic-tip-link">';
						$addtocal.= '<a href="' . $wcal . '" class="ic-title-cal-tip" rel="nofollow" target="_blank">';
						$addtocal.= JHtml::_('image', 'media/com_icagenda/images/cal/windows-live_cal-'.$iconAddToCal_size.'.png', JText::_('COM_ICAGENDA_LIVE_CALENDAR_LABEL'), array());
						$addtocal.= '&#160;' . JText::_('COM_ICAGENDA_LIVE_CALENDAR_LABEL') . '&#160;';
						$addtocal.= '</a>';
						$addtocal.= '</div>';
					}

					// Yahoo Calendar - link
					if (in_array('5', $iconAddToCal_options))
					{
						$addtocal.= '<div class="ic-tip-link">';
						$addtocal.= '<a href="' . $ycal . '" class="ic-title-cal-tip" rel="nofollow" target="_blank">';
						$addtocal.= JHtml::_('image', 'media/com_icagenda/images/cal/yahoo_cal-'.$iconAddToCal_size.'.png', JText::_('COM_ICAGENDA_YAHOO_CALENDAR_LABEL'), array());
						$addtocal.= '&#160;' . JText::_('COM_ICAGENDA_YAHOO_CALENDAR_LABEL') . '&#160;';
						$addtocal.= '</a>';
						$addtocal.= '</div>';
					}

					$return_atc = htmlspecialchars($addtocal);

					$html[]= '<a class="ic-addtocal" href="#" title="'.$return_atc.'" rel="nofollow">';

					// Joomla 3.x / 2.5 SWITCH
					if(version_compare(JVERSION, '3.0', 'ge'))
					{
						$html[]= '<span class="iCicon iCicon-calendar"></span>';
					}
					else
					{
						$html[]= JHtml::_('image', 'system/calendar.png', JText::_('COM_ICAGENDA_ADD_TO_CALL_LABEL'), null, true);
					}

					$html[]= '</a>';

					break;
				}

			default:
		}

		return implode("\n", $html);
	}

	/**
	 * Removes variable from URL
	 * @param $url to change
	 * @param $varname to remove from string
	 */
	public static function removeqsvar($url, $varname)
	{
		return preg_replace('/([?&])'.$varname.'=[^&]+(&|$)/','$1',$url);
	}
}
