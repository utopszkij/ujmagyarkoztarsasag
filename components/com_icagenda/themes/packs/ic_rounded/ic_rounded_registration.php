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
 * @template	event_registration
 * @version 	3.5.10 2015-08-05
 * @since       2.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die(); ?>

<!-- Event registration -->

<?php // Header of Registration page ?>
<?php // Show event ?>
<div class="ic-reg-event ic-clearfix">
	<div class="ic-reg-box">
		<?php if ($EVENT_NEXT): ?>
		<div class="ic-reg-icon ic-float-left">
		</div>
		<?php endif; ?>
		<div class="ic-reg-content">

			<?php // Category ?>
			<div class="ic-reg-cat">
				<?php echo $CATEGORY_TITLE; ?>
			</div>

			<?php // Event Title with link to event ?>
			<div class="ic-reg-event-title">
				<a href="<?php echo $EVENT_URL; ?>" title="<?php echo $EVENT_TITLE; ?>"><?php echo $EVENT_TITLE; ?></a>
			</div>
		</div>
	</div>
</div>
<?php // END Header ?>
