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
 * @version 	3.5.7 2015-07-13
 * @since       1.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// Get Application
$app		= JFactory::getApplication();
$document	= JFactory::getDocument();

$icsetvar			= 'components/com_icagenda/add/elements/icsetvar.php';
$someObjectArr		= (array)$this->data->items;
$control			= !empty($someObjectArr) ? true : false;
$getpage			= JRequest::getVar('page', 1);
$number_per_page	= $this->number;
$all_dates_with_id	= $this->getAllDates;
$count_all			= count($all_dates_with_id);

// Header
?>
<div id="icagenda" class="ic-list-view<?php echo $this->pageclass_sfx; ?>">
	<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<h1 class="componentheading">
	<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
	<?php endif; ?>

	<?php
	$tpl_template_events	= JPATH_SITE . '/components/com_icagenda/themes/packs/'.$this->template.'/'.$this->template.'_events.php';
	$tpl_template_list		= JPATH_SITE . '/components/com_icagenda/themes/packs/'.$this->template.'/'.$this->template.'_list.php';
	$tpl_default_events		= JPATH_SITE . '/components/com_icagenda/themes/packs/'.$this->template.'/'.$this->template.'_events.php';
	$tpl_component_css		= JPATH_SITE . '/components/com_icagenda/themes/packs/'.$this->template.'/css/'.$this->template.'_component.css';

	// Setting component css file to load
	if ( file_exists($tpl_component_css) )
	{
		$css_component	= '/components/com_icagenda/themes/packs/'.$this->template.'/css/'.$this->template.'_component.css';
		$css_com_rtl	= '/components/com_icagenda/themes/packs/'.$this->template.'/css/'.$this->template.'_component-rtl.css';
	}
	else
	{
		$css_component	= '/components/com_icagenda/themes/packs/default/css/default_component.css';
		$css_com_rtl	= '/components/com_icagenda/themes/packs/default/css/default_component-rtl.css';
	}

	// New file to display all dates for each events
	if ( file_exists($tpl_template_events) )
	{
		$tpl_events		= $tpl_template_events;
	}
	elseif ( (!$this->template || $this->template != 'default')
		&& file_exists($tpl_template_list)
		&& $this->dates_display == 1 )
	{
		$msg = 'iCagenda ' . JText::_('PHPMAILER_FILE_ACCESS') . ' <strong>' . $this->template . '_events.php</strong>';
		$app->enqueueMessage($msg, 'warning');
		$tpl_events		= JPATH_SITE . '/components/com_icagenda/themes/packs/default/default_events.php';
		$css_component	= '/components/com_icagenda/themes/packs/default/css/default_component.css';
	}
	elseif ( (!$this->template || $this->template != 'default')
		&& $this->dates_display != 1 )
	{
		$tpl_events		= $tpl_template_events;
	}
	else
	{
		$msg = 'iCagenda ' . JText::_('PHPMAILER_FILE_OPEN') . ' <strong>' . $this->template . '_events.php</strong>';
		$app->enqueueMessage($msg, 'warning');

		return false;
	}

	// If theme pack is not having YOUR_THEME_events.php file, loading YOUR_THEME_list.php file to display list of events
	if ( file_exists($tpl_template_list)
		&& !file_exists($tpl_template_events) )
	{
		$tpl_list		= $tpl_template_list;
	}
	else
	{
		$tpl_list		= JPATH_SITE . '/components/com_icagenda/themes/packs/default/default_events.php';
	}

	// Add the media specific CSS to the document
	JLoader::register('iCagendaMediaCss', JPATH_ROOT . '/components/com_icagenda/helpers/media_css.class.php');
	iCagendaMediaCss::addMediaCss($this->template, 'component');

	// Start Header
	echo '<div class="ic-clearfix">';

	// Header - Title / Subtitle
	if ($this->params->get('headerList', 1) != '4')
	{
//		echo iCModeliChelper::iCheader($count_all, $getpage, $this->arrowtext, $number_per_page, $this->pagination);
		echo iCModeliChelper::iCheader($count_all, $this->arrowtext, $number_per_page, $this->pagination);
	}

	// Header - Categories Information
	echo $this->loadTemplate('categories');

	// End Header
	echo '</div>';
	?>

	<form id="icagenda-list" name="iclist" action="<?php echo JRoute::_('index.php?option=com_icagenda&view=list'); ?>" method="post">

	<?php //echo $this->loadTemplate('filters'); ?>

	<?php
	// Header - Pagination
	if ( in_array($this->navposition, array('0', '2')) )
	{
//		echo iCModeliChelper::pagination($count_all, $getpage, $this->arrowtext, $number_per_page, $this->pagination);
		echo iCModeliChelper::pagination($count_all, $this->arrowtext, $number_per_page, $this->pagination);
	}

	$mainframe = JFactory::getApplication();
	$isSef = $mainframe->getCfg( 'sef' );

	// To be checked
	$EVENT_NEXT = (isset($EVENT_NEXT)) ? $EVENT_NEXT : false;

	if ($control)
	{
		if (file_exists($tpl_events)
			&& count($all_dates_with_id) > 0
			)
		{
			echo "<!-- " . $this->template . " -->";

			// Set number of events to be displayed per page
			$index = $number_per_page * ($getpage - 1);
			$recordsToBeDisplayed = array_slice($all_dates_with_id, $index, $number_per_page, true);

			// Do for each dates to be displayed on this list of events, depending of menu and/or global options
			for ($i = 0; $i < count($all_dates_with_id); $i++)
			{
				// Get id and date for each date to be displayed
				$evt_date_id		= $all_dates_with_id[$i];
				$ex_alldates_array	= explode('_', $evt_date_id);
				$evt				= $ex_alldates_array['0'];
				$evt_id				= $ex_alldates_array['1'];

				if (in_array($evt_date_id, $recordsToBeDisplayed))
				{
					foreach ($this->data->items as $item)
					{
						if ($evt_id == $item->id)
						{
							// Load Events List/Event Details common Data variables
							require $icsetvar;

							// Load Template to display Event
							require $tpl_events;
						}
					}
				}
			}
		}
		// Only for Theme Packs not updated
		else
		{
			$stamp->items = $this->data->items;

			require $tpl_list;
		}

		// List Bottom
		echo '<div>';

		if (file_exists($tpl_events))
		{
			// AddThis buttons
			if ($this->atlist && isset($item->share))
			{
				echo '<div class="share">' . $item->share . '</div><div style="clear:both"></div>';
			}
		}

		// List Bottom - Navigation & pagination
		if ( $this->navposition == '1' || $this->navposition == '2' )
		{
//			echo iCModeliChelper::pagination($count_all, $getpage, $this->arrowtext, $number_per_page, $this->pagination);
			echo iCModeliChelper::pagination($count_all, $this->arrowtext, $number_per_page, $this->pagination);
		}

		echo '</div>';
		echo '<div style="clear:both">&nbsp;</div>';
	}

	$this->dispatcher->trigger('onListAfterDisplay', array('com_icagenda.list', &$this->data->items, &$this->params));
	?>
	</form>
</div>

<?php
// Theme pack component css
$document->addStyleSheet( JURI::base( true ) . $css_component );

// RTL css if site language is RTL
$lang = JFactory::getLanguage();

if ( $lang->isRTL()
	&& file_exists( JPATH_SITE . $css_com_rtl) )
{
	$document->addStyleSheet( JURI::base( true ) . $css_com_rtl );
}
