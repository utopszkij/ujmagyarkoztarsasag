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
 * @version 	3.5.0 2015-02-05
 * @since       3.5.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();
?>
<form
	action="<?php echo JRoute::_('index.php?option=com_icagenda&task=registrations.display&format=raw'); ?>"
	method="post"
	name="adminForm"
	id="download-form"
	class="form-validate">
	<fieldset class="adminform">
		<legend><?php echo JText::_('COM_ICAGENDA_REGISTRATIONS_DOWNLOAD'); ?></legend>
		<?php foreach ($this->form->getFieldset() as $field) : ?>
		<div class="control-group">
			<?php if (!$field->hidden) : ?>
			<div class="control-label">
				<?php echo $field->label; ?>
			</div>
			<?php endif; ?>
			<div class="controls">
				<?php echo $field->input; ?>
			</div>
		</div>
		<?php endforeach; ?>
		<div class="clr"></div>
		<button type="button" class="btn" onclick="this.form.submit();window.top.setTimeout('window.parent.jModalClose()', 700);"><?php echo JText::_('COM_ICAGENDA_REGISTRATIONS_EXPORT'); ?></button>
		<!--button type="button" class="btn" onclick="window.parent.jModalClose()"><?php echo JText::_('COM_ICAGENDA_CANCEL'); ?></button-->
	</fieldset>
</form>
