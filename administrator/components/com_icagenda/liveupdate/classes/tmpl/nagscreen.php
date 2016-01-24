<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 *
 * @package LiveUpdate 2.1.5 - 2.2.1
 * @copyright Copyright (c)2010-2013 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU LGPLv3 or later <http://www.gnu.org/copyleft/lesser.html>
 *
 * @version     3.4.0 2014-12-21
 * @since       1.2.6
 */
/**
 * Specific strings iCagenda
 */

defined('_JEXEC') or die();

$stability = JText::_('LIVEUPDATE_STABILITY_'.$this->updateInfo->stability);
?>

<div class="liveupdate">

	<div id="nagscreen">
		<h2><?php echo JText::_('LIVEUPDATE_NAGSCREEN_HEAD_ICAGENDA') ?></h2>

		<p class="nagversioninfo">
			<?php echo JText::sprintf('LIVEUPDATE_NAGSCREEN_VERSION_ICAGENDA', $this->updateInfo->version, $stability) ?>
		</p>
		<?php if (JText::_('LIVEUPDATE_NAGSCREEN_BODY_ICAGENDA') != 'LIVEUPDATE_NAGSCREEN_BODY_ICAGENDA') : ?>
			<p class="nagtext">
				<?php echo JText::_('LIVEUPDATE_NAGSCREEN_BODY_ICAGENDA') ?>
			</p>
		<?php else : ?>
			<p class="nagtext">
				<?php echo JText::_('LIVEUPDATE_NAGSCREEN_BODY_PRE_RELEASES_ALERT_TOP') ?>
			</p>
			<p class="nagstability alert alert-danger">
				<strong><?php echo JText::_('LIVEUPDATE_NAGSCREEN_BODY_PRE_RELEASES_ICAGENDA_ALPHA') ?></strong>:
				<?php echo JText::_('LIVEUPDATE_NAGSCREEN_BODY_PRE_RELEASES_ALERT_ALPHA') ?>
			</p>
			<p class="nagstability alert alert-warning">
				<strong><?php echo JText::_('LIVEUPDATE_NAGSCREEN_BODY_PRE_RELEASES_ICAGENDA_BETA') ?></strong>:
				<?php echo JText::_('LIVEUPDATE_NAGSCREEN_BODY_PRE_RELEASES_ALERT_BETA') ?>
			</p>
			<p class="nagstability alert alert-info">
				<strong><?php echo JText::_('LIVEUPDATE_NAGSCREEN_BODY_PRE_RELEASES_ICAGENDA_RC') ?></strong>:
				<?php echo JText::_('LIVEUPDATE_NAGSCREEN_BODY_PRE_RELEASES_ALERT_RC') ?>
			</p>
			<p class="nagtext">
				<?php echo JText::_('LIVEUPDATE_NAGSCREEN_BODY_PRE_RELEASES_ALERT_BOTTOM') ?>
			</p>
		<?php endif; ?>
		<!--p>
			<small><?php echo JText::_('LIVEUPDATE_NAGSCREEN_FOOTER_ICAGENDA') ?>
			<a href="http://www.joomlic.com" target="_blank">www.joomlic.com</a></small>
		</p-->
	</div>
	<p class="liveupdate-buttons">
		<button class="btn btn-danger btn-large" onclick="window.location='<?php echo $this->runUpdateURL ?>'" ><?php echo JText::_('LIVEUPDATE_NAGSCREEN_BUTTON') ?></button>
	</p>

	<p class="liveupdate-poweredby">
		Powered by <a href="https://www.akeebabackup.com/software/akeeba-live-update.html">Akeeba Live Update</a>
	</p>

</div>
