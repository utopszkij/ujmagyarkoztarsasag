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
 * @version 	3.5.13 2015-11-21
 * @since       1.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

// Get Application
$app = JFactory::getApplication();

// User Access Levels
$user = JFactory::getUser();
$userLevels = $user->getAuthorisedViewLevels();

// User Groups
$userGroups = $user->getAuthorisedGroups();

// Set Item Object
$this_item	= (array) $this->data->items;
$item		= array_shift($this_item);

// Event Access Control
$EventID = $app->input->getInt('id');

$eventAccess	= icagendaEvents::eventAccess($EventID);

$evtState		= $eventAccess->evtState;
$evtApproval	= $eventAccess->evtApproval;
$evtAccess		= $eventAccess->evtAccess;
$accessName		= $eventAccess->accessName;

// Redirect to login page if no access to registration form
$uri	= JFactory::getURI();
$return	= base64_encode($uri);
$rlink	= JRoute::_("index.php?option=com_users&view=login&return=$return", false);

// Add Error or Alert Page
if ($evtState == 1
	&& $evtApproval == 1
	&& $this->data->items == NULL)
{
	// Set Return Page
	$return = JURI::getInstance()->toString();

	// redirect after successful registration
	$app->enqueueMessage(JText::_('JGLOBAL_YOU_MUST_LOGIN_FIRST'), 'info');
	$app->redirect($rlink);
}
elseif ($evtApproval == 0
	&& ! in_array($evtAccess, $userLevels)
	&& ! in_array('8', $userGroups))
{
	if ($user->id)
	{
		$app->enqueueMessage(JText::_( 'JERROR_LOGIN_DENIED' ), 'warning');
		$app->redirect($rlink);
	}
	else
	{
		$app->enqueueMessage(JText::_( 'JGLOBAL_YOU_MUST_LOGIN_FIRST' ), 'info');
		$app->redirect($rlink);
	}
}
elseif ( ! $evtState)
{
		JError::raiseError('404', JText::_( 'COM_ICAGENDA_PAGE_NOT_FOUND' ));

		return false;
}
else
{
	$isSef = $app->getCfg('sef');

	// prepare Document
	$document	= JFactory::getDocument();
	$menus		= $app->getMenu();
	$pathway 	= $app->getPathway();
	$title 		= null;

	// Load Variables file
	$icsetvar = 'components/com_icagenda/add/elements/icsetvar.php';

	// Set Joomla Site Title (Page Header Title)
	$menu = $menus->getActive();

	if ($menu)
	{
		$this->params->def('page_heading', $this->params->get('page_title', $item->title));
	}
	else
	{
		$this->params->def('page_heading', JText::_('JGLOBAL_ARTICLES'));
	}

	$title = $item->title;

	if (empty($title))
	{
		$title = $app->getCfg('sitename');
	}
	elseif ($app->getCfg('sitename_pagetitles', 0) == 1)
	{
		$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
	}
	elseif ($app->getCfg('sitename_pagetitles', 0) == 2)
	{
		$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
	}

	// Open Graph Tags
	$eventTitle		= $item->metaTitle;
	$eventType		= 'article';
	$eventImage		= $item->image;
	$imgLink		= filter_var($eventImage, FILTER_VALIDATE_URL);
	$eventUrl		= JURI::getInstance()->toString();
	$sitename		= $app->getCfg('sitename');
	$og_desc		= $item->metaDesc;

	// Add to the breadcrumb
	$pathway->addItem($item->title);

	if (JRequest::getVar('tmpl') != 'component')
	{
		if ($eventTitle)
		{
			$document->setTitle($title);
			$document->addCustomTag('<meta property="og:title" content="' . $eventTitle . '" />');
		}
		if ($eventType)
		{
			$document->addCustomTag('<meta property="og:type" content="' . $eventType . '" />');
		}
		if ($eventImage)
		{
			if ($imgLink)
			{
				$document->addCustomTag('<meta property="og:image" content="' . $eventImage . '" />');
			}
			else
			{
				$document->addCustomTag('<meta property="og:image" content="' . JURI::base() . $eventImage . '" />');
			}
		}
		if ($eventUrl)
		{
			$document->addCustomTag('<meta property="og:url" content="' . $eventUrl . '" />');
		}
		if ($og_desc)
		{
			$document->setDescription($og_desc);
			$document->addCustomTag('<meta property="og:description" content="' . $og_desc . '" />');
		}
		if ($sitename)
		{
			$document->addCustomTag('<meta property="og:site_name" content="' . $sitename . '" />');
		}
	}

	$stamp = $this->data;

	$iCicons = new iCicons();

	$icu_approve	= JRequest::getVar('manageraction', '');
	$icu_layout		= JRequest::getVar('layout', '');

	if (version_compare(JVERSION, '3.0', 'lt')) {
		$approveIcon = '<span class="iCicon-16 approval"></span>';
	} else {
		$approveIcon = '<button class="btn btn-micro btn-warning btn-xs "><i class="icon-checkmark"></i></button>';
	}

	$approval_msg	= JText::sprintf('COM_ICAGENDA_APPROVE_AN_EVENT_NOTICE', $approveIcon);
	$approval_title	= JText::_( 'COM_ICAGENDA_APPROVE_AN_EVENT_LBL' );
	$approval_type	= 'notice';
	?>

	<div id="icagenda" class="ic-event-view<?php echo $this->pageclass_sfx; ?>">

	<?php // Back Arrow ?>
	<div class="ic-top-buttons">

		<?php
		if (JRequest::getVar('tmpl') != 'component')
		{
			$uri		= JUri::getInstance()->toString();
			$date_value	= JRequest::getVar('date', '');
			$evt_id		= JRequest::getVar('id', 0);
			$event_link	= JRoute::_('index.php?option=com_icagenda&view=list&layout=event&id='.$evt_id);

			$session	= JFactory::getSession();
			$session->set('date_value', $date_value);

			$print_url	= ($isSef == 1) ? $event_link.'?tmpl=component' : $event_link.'&tmpl=component';
			$ical_url	= ($isSef == 1) ? $uri.'?vcal=1' : $uri.'&vcal=1';
			$ical_url	= preg_replace('/\?date=[^\?]*/', '', $ical_url);
			$ical_url	= preg_replace('/&date=[^&]*/', '', $ical_url);

			echo '<div class="ic-back ic-clearfix">';
			echo $item->BackArrow;
			echo '</div>';

			echo '<div class="ic-buttons ic-clearfix">';

			if ($this->iconPrint_global == 2)
			{
				// Print icon
				echo '<div class="ic-icon">';
				echo $iCicons->showIcon('printpreview', $print_url);
				echo '</div>';
			}

			if ($this->iconAddToCal_global == 2)
			{
				// Add to Cal icon
				echo '<div class="ic-icon">';
				echo $iCicons->showIcon('vcal', $uri, $ical_url, $item->gcalendarUrl, $item->wlivecalendarUrl, $item->yahoocalendarUrl);
				echo '</div>';
			}

			// Manager Icons
			echo '<div class="ic-icon">';
			echo $item->ManagerIcons;

			if ($icu_approve != 'approve' && ($evtApproval == 1))
			{
				$app->enqueueMessage($approval_msg, $approval_title, $approval_type);
			}

			echo '</div>';
			echo '</div>';
		}
		else
		{
			echo '<div class="ic-printpopup-btn"><div>';
			echo $iCicons->showIcon('print');
			echo '</div></div>';
		}
		?>
	</div>
	<?php

	// load Theme and css
	if (file_exists( JPATH_SITE . '/components/com_icagenda/themes/packs/' . $this->template . '/' . $this->template . '_event.php' ))
	{
		$tpl_event		= JPATH_SITE . '/components/com_icagenda/themes/packs/' . $this->template . '/' . $this->template . '_event.php';
		$css_component	= '/components/com_icagenda/themes/packs/' . $this->template . '/css/' . $this->template . '_component.css';
		$css_com_rtl	= '/components/com_icagenda/themes/packs/' . $this->template . '/css/' . $this->template . '_component-rtl.css';
	}
	else
	{
		$tpl_event 		= JPATH_SITE . '/components/com_icagenda/themes/packs/default/default_event.php';
		$css_component	= '/components/com_icagenda/themes/packs/default/css/default_component.css';
		$css_com_rtl	= '/components/com_icagenda/themes/packs/default/css/default_component-rtl.css';
	}

	// Add the media specific CSS to the document
	JLoader::register('iCagendaMediaCss', JPATH_ROOT . '/components/com_icagenda/helpers/media_css.class.php');
	iCagendaMediaCss::addMediaCss($this->template, 'component');

	echo "<!-- " . $this->template . " -->";

	require_once $icsetvar;
	require_once $tpl_event;

	?>
	</div>
	<div>&nbsp;</div>
	<?php
}

$this->dispatcher->trigger('onEventAfterDisplay', array('com_icagenda.event', &$item, &$this->params));

// Theme pack component css
$document->addStyleSheet( JURI::base( true ) . $css_component );

// RTL css if site language is RTL
$lang = JFactory::getLanguage();

if ( $lang->isRTL()
	&& file_exists( JPATH_SITE . $css_com_rtl) )
{
	$document->addStyleSheet( JURI::base( true ) . $css_com_rtl );
}

// Google Maps api V3
if ( ! empty($item->lng)
	&& ! empty($item->lat)
	&& $item->lng != '0.0000000000000000'
	&& $item->lat != '0.0000000000000000'
	&& $this->GoogleMaps == 1)
{
	icagendaModelList::loadGMapScripts();
}

$iCAddToCal = array();

$iCAddToCal[] = '	jQuery(document).ready(function(){';
$iCAddToCal[] = '		jQuery(".ic-addtocal").tipTip({maxWidth: "200px", defaultPosition: "bottom", edgeOffset: 1, activation:"hover", keepAlive: true});';
$iCAddToCal[] = '	});';

// Add the script to the document head.
JFactory::getDocument()->addScriptDeclaration(implode("\n", $iCAddToCal));
