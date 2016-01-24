<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @themepack	ic_rounded
 * @template	events
 * @version 	3.5.10 2015-08-22
 * @since       3.2.8
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();
?>

<!-- Event -->

<?php // List of Events Template ?>

	<?php // START Event ?>
	<div class="event ic-event ic-clearfix">

		<?php // START Date Box with Event Image as background ?>
		<?php if ($EVENT_NEXT): ?>

		<?php // Link to Event ?>
		<a href="<?php echo $EVENT_URL; ?>" title="<?php echo $EVENT_TITLE; ?>">

		<?php // If no Event Image set ?>
		<?php if (!$EVENT_IMAGE) : ?>
		<div class="ic-box-date">
		<?php // In case of Event Image ?>
		<?php else : ?>
		<div class="ic-box-date" style="background-image:url(<?php echo $IMAGE_MEDIUM; ?>); border-color: <?php echo $CATEGORY_COLOR; ?>">
		<?php endif; ?>
			<div class="ic-date">

				<?php // Day ?>
				<div class="ic-day">
					<?php echo $EVENT_DAY; ?>
				</div>

				<?php // Month ?>
				<div class="ic-month">
					<?php echo $EVENT_MONTHSHORT; ?>
				</div>

				<?php // Year ?>
				<div class="ic-year">
					<?php echo $EVENT_YEAR; ?>
				</div>

				<?php // Time ?>
				<div class="ic-time">
					<?php echo $EVENT_TIME; ?>
				</div>

			</div>
		</div>

		</a>
		<?php endif; ?><?php // END Date Box ?>

		<?php // START Right Content ?>
		<div class="ic-content">

			<?php // Header (Title/Category) of the event ?>
			<div class="eventtitle ic-event-title ic-clearfix">

				<?php // Title of the event ?>
				<div class="title-header ic-title-header ic-float-left">
					<h2>
						<a href="<?php echo $EVENT_URL; ?>" title="<?php echo $EVENT_TITLE; ?>">
							<?php echo $EVENT_TITLEBAR; ?>
						</a>
					</h2>
				</div>

				<?php // Category ?>
				<div class="title-cat ic-title-cat ic-float-right <?php if ($CATEGORY_FONTCOLOR == 'fontColor') : ?>ic-text-border<?php endif; ?>"
					style="color: <?php echo $CATEGORY_COLOR; ?>;">
					<?php echo $CATEGORY_TITLE; ?>
				</div>
				<!--div class="title-cat">
					<i class="icTip icon-folder-3 caticon <?php echo $CATEGORY_FONTCOLOR; ?>" style="background:<?php echo $CATEGORY_COLOR; ?>" title="<?php echo $CATEGORY_TITLE; ?>"></i> <?php echo $CATEGORY_TITLE; ?>
				</div-->

			</div>

			<?php // Feature icons ?>
			<?php if (!empty($FEATURES_ICONSIZE_LIST)) : ?>
			<div class="ic-features-container">
				<?php foreach ($FEATURES_ICONS as $icon) : ?>
				<div class="ic-feature-icon">
					<img class="iCtip" src="<?php echo $FEATURES_ICONROOT_LIST . $icon['icon'] ?>" alt="<?php echo $icon['icon_alt'] ?>" title="<?php echo $SHOW_ICON_TITLE == '1' ? $icon['icon_alt'] : '' ?>">
				</div>
				<?php endforeach ?>
			</div>
			<?php endif ?>

			<?php // Next Date ('next' 'today' or 'last date' if no next date) ?>
			<?php if ($EVENT_DATE): ?>
			<div class="nextdate ic-next-date ic-clearfix">
				<strong><?php echo $EVENT_DATE; ?></strong>
			</div>
			<?php endif; ?>

			<?php // Location (different display, depending on the fields filled) ?>
			<?php if ($EVENT_VENUE OR $EVENT_CITY): ?>
			<div class="place ic-place">

				<?php // Place name ?>
				<?php if ($EVENT_VENUE): ?><?php echo $EVENT_VENUE;?><?php endif; ?>

				<?php // If Place Name exists and city set (Google Maps). Displays Country if set. ?>
				<?php if ($EVENT_CITY AND $EVENT_VENUE): ?>
					<span> - </span>
					<?php echo $EVENT_CITY;?><?php if ($EVENT_COUNTRY): ?>, <?php echo $EVENT_COUNTRY;?><?php endif; ?>
				<?php endif; ?>

				<?php // If Place Name doesn't exist and city set (Google Maps). Displays Country if set. ?>
				<?php if ($EVENT_CITY AND !$EVENT_VENUE): ?>
					<?php echo $EVENT_CITY;?><?php if ($EVENT_COUNTRY): ?>, <?php echo $EVENT_COUNTRY;?><?php endif; ?>
				<?php endif; ?>

			</div>
			<?php endif; ?>

			<?php // Short Description ?>
			<?php if ($EVENT_DESC): ?>
			<div class="descshort ic-descshort">
				<?php echo $EVENT_INTRO_TEXT ; ?><?php echo $READ_MORE ; ?>
			</div>
			<?php endif; ?>

			<?php // Addons Plugins (JComments, ...) - onListAddEventInfo ?>
			<?php if ($IC_LIST_ADD_EVENT_INFO): ?>
				<?php echo $IC_LIST_ADD_EVENT_INFO; ?>
			<?php endif; ?>

			<?php // + infos Text ?>
			<div class="moreinfos ic-more-info">
			 	<a href="<?php echo $EVENT_URL; ?>" title="<?php echo $EVENT_TITLE; ?>">
			 		<?php echo JTEXT::_('COM_ICAGENDA_EVENTS_MORE_INFO'); ?>
			 	</a>
			</div>

		</div><?php // END Right Content ?>

	</div>

<?php // END Event ?>
