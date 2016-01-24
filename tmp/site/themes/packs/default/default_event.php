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
 * @themepack	default
 * @template	event_details
 * @version 	3.5.13 2015-11-10
 * @since       1.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die(); ?>

<!-- Event details -->

<?php // Event Details Template ?>
<div class="ic-clearfix">

	<?php // Header ?>
	<h2>
		<?php // Feature icons ?>
		<?php if (!empty($FEATURES_ICONSIZE_EVENT)) : ?>
		<div class="ic-features-container">
			<?php foreach ($FEATURES_ICONS as $icon) : ?>
			<div class="ic-feature-icon">
				<img class="iCtip" src="<?php echo $FEATURES_ICONROOT_EVENT . $icon['icon'] ?>" alt="<?php echo $icon['icon_alt'] ?>" title="<?php echo $SHOW_ICON_TITLE == '1' ? $icon['icon_alt'] : '' ?>">
			</div>
			<?php endforeach ?>
		</div>
		<?php endif ?>

		<?php // Title of the event ?>
		<?php echo $EVENT_TITLE; ?>
	</h2>

	<?php // Sharing and Registration ?>
	<div class="ic-event-buttons ic-clearfix">

		<?php // AddThis Social Sharing ?>
		<div class="ic-event-addthis ic-float-left">
			<?php echo $EVENT_SHARING; ?>
		</div>

		<?php // Registration button ?>
		<div class="ic-event-registration ic-float-right">
			<?php echo $EVENT_REGISTRATION; ?>
		</div>

	</div>

	<?php // Event Display ?>
	<div class="ic-info">

		<?php // Show Image of the event ?>
		<?php if ($EVENT_IMAGE): ?>
			<div class="ic-image ic-align-center">
				<?php echo $EVENT_IMAGE_TAG; ?>
			</div>
		<?php endif; ?>

		<?php // Details of the event ?>
		<div class="ic-details ic-align-left">

			<div class="ic-divTable ic-align-left ic-clearfix">

				<?php // Category ?>
				<div class="ic-divRow">
					<div class="ic-divCell ic-label"><?php echo JTEXT::_('COM_ICAGENDA_EVENT_CAT');  ?></div>
					<div class="ic-divCell ic-value"><?php echo $CATEGORY_TITLE; ?></div>
				</div>

				<?php // Next Date ('next' 'today' or 'last date' if no next date) ?>
				<div class="ic-divRow">
					<div class="ic-divCell ic-label"><?php echo $EVENT_VIEW_DATE_TEXT; ?></div>
					<div class="ic-divCell ic-value"><?php echo $EVENT_VIEW_DATE; ?></div>
				</div>

				<?php // Venue name and/or address (different display, depending on the fields filled) ?>
				<?php if ($EVENT_VENUE OR $EVENT_ADDRESS): ?>
					<div class="ic-divRow">
						<div class="ic-divCell ic-label"><?php echo JTEXT::_('COM_ICAGENDA_EVENT_PLACE'); ?></div>
						<div class="ic-divCell ic-value">
							<?php if (($EVENT_VENUE) and (!$EVENT_ADDRESS)): ?>
								<?php echo $EVENT_VENUE; ?><?php if ($EVENT_CITY): ?> - <?php echo $EVENT_CITY;?><?php endif; ?>
							<?php endif; ?>
							<?php if ((!$EVENT_VENUE) and ($EVENT_ADDRESS)): ?>
								<?php echo $EVENT_ADDRESS; ?>
							<?php endif; ?>
							<?php if (($EVENT_VENUE) and ($EVENT_ADDRESS)): ?>
								<?php echo $EVENT_VENUE; ?> - <?php echo $EVENT_ADDRESS;?>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>

				<?php // Information ?>
				<?php if ($EVENT_INFOS): ?>

					<?php // Max. Nb of seats ?>
					<?php if ($MAX_NB_OF_SEATS): ?>
						<div class="ic-divRow">
							<div class="ic-divCell ic-label"><?php echo JTEXT::_('COM_ICAGENDA_REGISTRATION_NUMBER_PLACES'); ?></div>
							<div class="ic-divCell ic-value"><?php echo $MAX_NB_OF_SEATS; ?></div>
						</div>
					<?php endif; ?>

					<?php // Nb of seats available ?>
					<?php if ($SEATS_AVAILABLE): ?>
						<div class="ic-divRow">
							<div class="ic-divCell ic-label"><?php echo JTEXT::_('COM_ICAGENDA_REGISTRATION_PLACES_LEFT'); ?></div>
							<div class="ic-divCell ic-value"><?php echo $SEATS_AVAILABLE; ?></div>
						</div>
					<?php endif; ?>

					<?php // Phone ?>
					<?php if ($EVENT_PHONE): ?>
						<div class="ic-divRow">
							<div class="ic-divCell ic-label"><?php echo JTEXT::_('COM_ICAGENDA_EVENT_PHONE'); ?></div>
							<div class="ic-divCell ic-value"><?php echo $EVENT_PHONE; ?></div>
						</div>
					<?php endif; ?>

					<?php // Email ?>
					<?php if ($EVENT_EMAIL): ?>
						<div class="ic-divRow">
							<div class="ic-divCell ic-label"><?php echo JTEXT::_('COM_ICAGENDA_EVENT_MAIL'); ?></div>
							<div class="ic-divCell ic-value"><?php echo $EVENT_EMAIL_CLOAKING; ?></div>
						</div>
					<?php endif; ?>

					<?php // Website ?>
					<?php if ($EVENT_WEBSITE): ?>
						<div class="ic-divRow">
							<div class="ic-divCell ic-label"><?php echo JTEXT::_('COM_ICAGENDA_EVENT_WEBSITE'); ?></div>
							<div class="ic-divCell ic-value"><?php echo $EVENT_WEBSITE_LINK; ?></div>
						</div>
					<?php endif; ?>

					<?php // Custom Fields ?>
					<?php if ($CUSTOM_FIELDS): ?>
						<?php foreach ($CUSTOM_FIELDS AS $FIELD): ?>
							<?php if ($FIELD->title && $FIELD->value) : ?>
								<div class="ic-divRow">
									<div class="ic-divCell ic-label"><?php echo $FIELD->title; ?></div>
									<div class="ic-divCell ic-value"><?php echo $FIELD->value; ?></div>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>

					<?php // File attached ?>
					<?php if ($EVENT_ATTACHEMENTS): ?>
						<div class="ic-divRow">
							<div class="ic-divCell ic-label"><?php echo JTEXT::_('COM_ICAGENDA_EVENT_FILE'); ?></div>
							<div class="ic-divCell ic-value"><?php echo $EVENT_ATTACHEMENTS_TAG; ?></div>
						</div>
					<?php endif; ?>

				<?php endif; ?>

			</div>

		</div><?php // end div.details ?>


	<?php // description text ?>
	<?php if ($EVENT_DESC): ?>
		<div class="ic-short-description">
			<?php echo $EVENT_SHORTDESC; ?>
		</div>
		<div class="ic-full-description">
			<?php echo $EVENT_DESCRIPTION; ?>
		</div>
	<?php endif; ?>

	<div>&nbsp;</div>

	<?php // Google Maps ?>
	<?php if ($GOOGLEMAPS_COORDINATES): ?>
		<div id="ic-detail-map">
			<div class="icagenda_map">
				<?php echo $EVENT_MAP; ?>
			</div>
		</div>
	<?php endif; ?>

	<div>&nbsp;</div>

	<?php // List of all dates (multi-dates and/or period from to) ?>
	<?php if ($EVENT_SINGLE_DATES OR $EVENT_PERIOD): ?>
		<div id="ic-list-of-dates" class="ic-all-dates">
			<h3>
				<?php echo JTEXT::_('COM_ICAGENDA_EVENT_DATES'); ?>
			</h3>
			<div class="ic-dates-list">

				<?php // Period from X to X ?>
				<?php echo $EVENT_PERIOD; ?>

				<?php // Individual dates ?>
				<?php echo $EVENT_SINGLE_DATES; ?>

			</div>
		</div>
	<?php endif; ?>

	</div><?php // end div.info ?>

	<?php // List of Participants ?>
	<?php if ($PARTICIPANTS_DISPLAY == 1 && $EVENT_PARTICIPANTS) : ?>
		<div id="ic-list-of-participants" class="ic-participants">
			<?php // Display header title 'List of Participants' if slide effect is disabled ?>
			<?php if ($PARTICIPANTS_HEADER) : ?>
				<h3>
					<?php echo $PARTICIPANTS_HEADER; ?>
				</h3>
			<?php endif; ?>
			<?php echo $EVENT_PARTICIPANTS; ?>
		</div>
	<?php endif; ?>


</div><?php // end div Event-details ?>
