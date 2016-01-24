<?php
/**
 * @version	 $Id: edit.php 124 2012-10-08 15:08:17Z michel $
 * @package		Joomla.Administrator
 * @subpackage	com_categories
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');

// Load the tooltip behavior.
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>


<script type="text/javascript">

	function submitbutton(task)
	{
         var form = document.adminForm;
	    if (task == 'cancel' || document.formvalidator.isValid(form)) {
			submitform(task);
		}
	}

</script>

<form action="<?php echo JRoute::_('index.php?option=com_##component##&view=category'); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">

	<div class="<?php if(version_compare(JVERSION,'3.0','lt')): ?>width-40  <?php endif;?>fltrt span4">
		<fieldset class="adminform">
			<legend><?php echo JText::_('Categories_Fieldset_Metadata'); ?></legend>
			<?php echo $this->loadTemplate('metadata'); ?>
		</fieldset>
	</div>

	<div class="<?php if(version_compare(JVERSION,'3.0','lt')): ?>width-60  <?php endif;?>span8 form-horizontal fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_('Categories_Fieldset_Details');?></legend>

					<?php echo $this->form->getLabel('title'); ?>
					<?php echo $this->form->getInput('title'); ?>

					<?php echo $this->form->getLabel('alias'); ?>
					<?php echo $this->form->getInput('alias'); ?>

					<?php echo $this->form->getLabel('extension'); ?>
					<?php echo $this->form->getInput('extension'); ?>
					
					<?php echo $this->form->getLabel('parent_id'); ?>
					<?php echo $this->form->getInput('parent_id'); ?>
					
					<?php echo $this->form->getLabel('published'); ?>
					<?php echo $this->form->getInput('published'); ?>

					<?php echo $this->form->getLabel('access'); ?>
					<?php echo $this->form->getInput('access'); ?>
					
					<?php echo $this->loadTemplate('options'); ?>
					
					<div class="clr"></div>
					<?php echo $this->form->getLabel('description'); ?>
					<div class="clr"></div>
					<?php echo $this->form->getInput('description'); ?>
		</fieldset>
	</div>
<?php $jv = new JVersion(); 
      if($jv->RELEASE > 1.5):
?>	
	<div class="clr"></div>
		<div  class="<?php if(version_compare(JVERSION,'3.0','lt')): ?>width-100  <?php endif;?>span10 fltlft">

			<?php echo JHtml::_('sliders.start','permissions-sliders-'.$this->item->id, array('useCookie'=>1)); ?>
	
			<?php echo JHtml::_('sliders.panel',JText::_('COM_CATEGORIES_FIELDSET_RULES'), 'access-rules'); ?>	
				<fieldset class="panelform">
					<?php echo $this->form->getLabel('rules'); ?>
					<?php echo $this->form->getInput('rules'); ?>
				</fieldset>
			
			<?php echo JHtml::_('sliders.end'); ?>
		</div>
<?php endif;?>		
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
<div class="clr"></div>
