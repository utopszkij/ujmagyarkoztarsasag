<?php
/**
 * @version		$Id: edit_metadata.php 96 2011-08-11 06:59:32Z michel $
 * @package		Joomla.Administrator
 * @subpackage	com_menus
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>


<?php echo $this->form->getLabel('metadesc'); ?>
<?php echo $this->form->getInput('metadesc'); ?>

<?php echo $this->form->getLabel('metakey'); ?>
<?php echo $this->form->getInput('metakey'); ?>
<table>
<?php  $fieldSets = $this->form->getFieldsets('metadata');
			foreach($fieldSets  as $name =>$fieldset): 				
				foreach ($this->form->getFieldset($name) as $field) : ?>
					<?php if ($field->hidden):  ?>
						<?php echo $field->input;  ?>
					<?php else:  ?>
					<tr>
						<td class="paramlist_key" width="40%">
							<?php echo $field->label;  ?>
						</td>
						<td class="paramlist_value">
							<?php echo $field->input;  ?>
						</td>
					</tr>
				<?php endif;  
				endforeach;  
			endforeach;  ?>
</table>			
