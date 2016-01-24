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
 * @template	calendar info-tip
 * @version 	3.5.13 2015-10-29
 * @since       1.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die(); ?>

<!-- Day info-tip -->

<?php // Day with event ?>
<?php if ($stamp->events) : ?>

	<?php // Main Background of a day ?>

	<div class="icevent <?php echo $multi_events; ?>" style="background:<?php echo $bg_day; ?> !important; z-index:1000;">

		<?php // Color of date text depending of the category color ?>
		<a>
		<div class="<?php echo $stamp->ifToday; ?> <?php echo $bgcolor; ?>" style="color: #fff !important" data-cal-date="<?php echo $stamp->this_day; ?>">
			<?php echo $stamp->Days; ?>
		</div>
		</a>

		<?php // Start of the Tip ?>
		<div class="spanEv">

			<?php foreach($events as $e) : ?>

				<div class="ictip-event">
					<?php echo '<a href="' . $e['url'] . '" rel="nofollow">'; ?>

					<div class="linkTo">

						<?php // Show image if exist ?>
						<div class="ictip-img">
						<?php
						echo '<span style="background: ' . $e['cat_color'] . ';" class="img">';

						if ($e['image'])
						{
							echo '<img src="' . $e['image'] . '" alt="" />';
						}
						else
						{
							echo '<span class="noimg ' . $bgcolor . '">' . $e['cat_title'] . '</span>';
						}

						echo '</span>';
						?>
						</div>

						<?php // Display Title (with link to event) and other infos if set (city, country) ?>
						<div class="ictip-event-title titletip">
							<?php //echo '&rsaquo; ' . $e['title']; ?>
							<?php echo $e['title']; ?>
						</div>

						<?php // Display feature icons, if required ?>
						<?php if (!empty($e['features_icon_size'])) : ?>
						<div class="ic-features-container">
							<?php foreach ($e['features'] as $icon) : ?>
								<div class="ic-feature-icon">
									<img src="<?php echo $e['features_icon_root'] . $icon['icon'] ?>" alt="<?php echo $icon['icon_alt'] ?>" title="<?php echo $e['show_icon_title'] == '1' ? $icon['icon_alt'] : '' ?>">
								</div>
							<?php endforeach ?>
						</div>
						<?php endif; ?>

						<?php // INFO ?>
						<div class="ictip-info ic-clearfix">

							<?php // Display Time (start) for each date ?>
							<?php if ($e['displaytime']) : ?>
								<div class="ictip-time">
									<?php echo $e['time']; ?>
								</div>
							<?php endif; ?>

							<?php // Display Venue Name, City and/or Country for each date ?>
							<?php if ($e['place'] OR $e['city'] OR $e['country']) : ?>
								<div class="ictip-location">
									<?php // Display Venue Name ?>
									<?php if ($e['place'] AND ($e['city'] OR $e['country']) ) : ?>
										<?php echo $e['place'].', '; ?>
									<?php else : ?>
										<?php echo $e['place']; ?>
									<?php endif; ?>
									<?php // Display City and/or Country for each date ?>
									<?php if ($e['city']) : ?>
										<?php echo $e['city']; ?>
									<?php endif; ?>
									<?php if (($e['country']) && ($e['city'])) : ?>
										<?php echo ', '.$e['country']; ?>
									<?php endif; ?>
									<?php if (($e['country']) AND (!$e['city'])) : ?>
										<?php echo $e['country']; ?>
									<?php endif; ?>
								</div>
							<?php endif; ?>

							<?php // Display Short Description ?>
							<?php if ($e['descShort']) : ?>
								<div class="ictip-desc">
									<?php echo $e['descShort']; ?>
								</div>
							<?php endif; ?>

						</div>

						<?php // Display Registration Information ?>
						<div style="clear:both"></div>

						<?php if ($e['registrations']) : ?>
						<div class="regButtons ic-reg-buttons">

							<?php if (!$e['date_sold_out']) : ?>
								<?php if ($e['maxTickets']) : ?>
									<span class="iCreg available">
										<?php echo JText::_( 'MOD_ICCALENDAR_SEATS_NUMBER' ) . ': ' . $e['maxTickets']; ?>
									</span>
								<?php endif; ?>
								<?php if ($e['TicketsLeft'] && $e['maxTickets']) : ?>
									<span class="iCreg ticketsleft">
										<?php echo JText::_( 'MOD_ICCALENDAR_SEATS_AVAILABLE' ) . ': ' . $e['TicketsLeft']; ?>
									</span>
								<?php endif; ?>
								<?php if ($e['registered']) : ?>
									<span class="iCreg registered">
										<?php echo JText::_( 'MOD_ICCALENDAR_ALREADY_REGISTERED' ) . ': ' . $e['registered']; ?>
									</span>
								<?php endif; ?>
							<?php else : ?>
								<span class="iCreg closed">
									<?php echo $e['date_sold_out']; ?>
								</span>
							<?php endif; ?>

						</div>
						<?php endif; ?>
					</div>
					<?php echo '</a>'; ?>
				</div>
			<?php endforeach; ?>
		</div>

		<?php // Display Date at the top of the info-tip ?>
		<div class="date ictip-date">
			<span class="ictip-date-lbl">
				<?php echo JTEXT::_('JDATE');  ?> :
			</span>
			<span class="ictip-date-format">
				<?php echo $stamp->dateTitle; ?>
			</span>
		</div>

	</div><?php // end of the day ?>

<?php // Day with no event ?>
<?php else : ?>
	<div class="no-event <?php echo $stamp->ifToday; ?>" data-cal-date="<?php echo $stamp->this_day; ?>">
		<?php echo $stamp->Days; ?>
	</div>
<?php endif; ?>
