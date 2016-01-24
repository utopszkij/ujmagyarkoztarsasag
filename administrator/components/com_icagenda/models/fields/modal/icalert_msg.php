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
 * @version     3.3.3 2014-04-12
 * @since       3.2.8
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');

class JFormFieldModal_icalert_msg extends JFormField
{
	protected $type='modal_icalert_msg';

	protected function getLabel()
	{
		return ' ';
	}

	protected function getInput()
	{
		$replace = array("jform", "params", "[", "]");
		$name_input = str_replace($replace, "", $this->name);
		$get_error = explode('_', $name_input);
		$error = $get_error['1'];
		$name = $get_error['0'];

		$url=JPATH_SITE.'/components/com_icagenda/themes/packs';

		// Set Function to condition to be checked
		$events_php=$this->getList($url);
		$cal_date=$this->getCalDate($url);

		if ($name == 'eventsfile')
		{
			$list = $events_php;
			$doc_url = 'http://www.icagenda.com/theme-pack-upgrade/3-2-8-new-option-all-dates';
			$parent_field = 'datesDisplay';
			$action_value = '1';
		}
		elseif ($name == 'caldate')
		{
			$list = $cal_date;
			$doc_url = 'http://www.icagenda.com/theme-pack-upgrade/3-3-3-change-cal-date-to-data-cal-date';
			$parent_field = 'setTodayTimezone';
			$action_value = '';
		}

		$span_style	= 'input-xlarge';

		if (version_compare(JVERSION, '3.0', 'lt')) {
			$listP		= implode('<br /> - ', $list);
			$setlist	= ' - '.$listP.' ';
		} else {
			$listP		= implode('</li><li>', $list);
			$setlist	= '<ul><li>'.$listP.'</li></ul>';
//			$span_style	= 'span8';
		}

		$html	= array();

		if (count($list) >= 1)
		{
			$html[]	= '<div id="icalert_'.$this->id.'" class="'.$span_style.' alert alert-error" style="clear:both">';
			$html[]	=  '<b>'.JText::_( $this->title ).'</b>';
			$html[]	= '<p>';
			$html[]	=  JText::_( $this->description ) . ' <a class="modal" rel="{size: {x: 700, y: 500}, handler:\'iframe\'}" href="'.$doc_url.'">' .JText::_( 'IC_MORE_INFORMATION' ). '</a>';
			$html[]	= '</p>';

			if ($this->id == 'jform_params_'.$name.'_error')
			{
				$html[]	= '<p>';
				$html[]	= '<b><i>'.JText::_( 'COM_ICAGENDA_EVENTS_PHPFILE_MISSING_PACKS_LIST' ).'</i></b><br />';
				$html[]	= $setlist;
				$html[]	= '</p>';
			}
			$html[]	= '</div>';

			$html[] = '<script type="text/javascript">';
			$html[]	= '		var icdisplay = document.getElementById("jform_params_'.$parent_field.'").value;';
			$html[] = '		document.getElementById("icalert_'.$this->id.'").style.display = "none";';
			$html[] = '		if (icdisplay == "'.$action_value.'") {';
			$html[] = '			document.getElementById("icalert_'.$this->id.'").style.display = "block";';
			$html[] = '		}';
			$html[]	= '	function icalert()';
			$html[]	= '	{';
			$html[]	= '		var icdisplay = document.getElementById("jform_params_'.$parent_field.'").value;';
			$html[] = '		document.getElementById("icalert_'.$this->id.'").style.display = "none";';
			$html[] = '		if (icdisplay == "'.$action_value.'") {';
			$html[] = '			document.getElementById("icalert_'.$this->id.'").style.display = "block";';
			$html[] = '		}';
			$html[]	= '	}';
			$html[] = '</script>';
		}

		return implode("\n", $html);
	}

	/**
	 * Function to check if the file 'THEME_events.php' exists in each Theme Pack
	 */
	function getList($dirname)
	{
		$arrayfiles = Array();

		if(file_exists($dirname))
		{
			$handle = opendir($dirname);

			while (false !== ($file = readdir($handle)))
			{
				if ( !is_file($dirname.$file)
					&& $file!= '.'
					&& $file!='..'
					&& $file!='index.php'
					&& $file!='index.html'
					&& $file!='.DS_Store'
					&& $file!='.thumbs' )
				{
					if (!file_exists($dirname.'/'.$file.'/'.$file.'_events.php'))
					{
						array_push($arrayfiles,$file);
					}
				}
			}
			$handle = closedir($handle);
		}
		sort($arrayfiles);

		return $arrayfiles;
	}

	/**
	 * Function to check if 'data-cal-date' is defined inside the file 'THEME_day.php' for each Theme Pack.
	 * Returns an alert if deprecated 'cal_date' found.
	 */
	function getCalDate($dirname)
	{
		$arrayfiles = Array();

		if (ini_get('allow_url_fopen'))
		{
			if (file_exists($dirname))
			{
				$handle = opendir($dirname);

				while (false !== ($file = readdir($handle)))
				{
					if ( !is_file($dirname.$file)
						&& $file!= '.'
						&& $file!='..'
						&& $file!='index.php'
						&& $file!='index.html'
						&& $file!='.DS_Store'
						&& $file!='.thumbs' )
					{
						$t_day = $dirname.'/'.$file.'/'.$file.'_day.php';
						$file_t_day = file_get_contents($t_day);

						if (!strpos($file_t_day, "cal_date")
							&& !strpos($file_t_day, "data-cal-date"))
						{
							array_push($arrayfiles,$file);
						}
						elseif (strpos($file_t_day, "cal_date"))
						{
							array_push($arrayfiles,$file);
						}
					}
				}
			}
			$handle = closedir($handle);
		}
		sort($arrayfiles);

		return $arrayfiles;
	}

}
