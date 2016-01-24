<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

// Set toolbar items for the page
$edit		= JRequest::getVar('edit', true);
$text = !$edit ? JText::_( 'New' ) : JText::_( 'Edit' );
JToolBarHelper::title(   JText::_( 'Kepviselojeloltek' ).': <small><small>[ ' . $text.' ]</small></small>' );
JToolBarHelper::apply();
JToolBarHelper::save();
if (!$edit) {
	JToolBarHelper::cancel();
} else {
	// for existing items the button is renamed `close`
	JToolBarHelper::cancel( 'cancel', 'Close' );
}
?>

<script language="javascript" type="text/javascript">


Joomla.submitbutton = function(task)
{
	if (task == 'cancel' || document.formvalidator.isValid(document.id('adminForm'))) {
		Joomla.submitform(task, document.getElementById('adminForm'));
	}
}

</script>

	 	<form method="post" action="index.php" id="adminForm" name="adminForm">
	 	<div class="col <?php if(version_compare(JVERSION,'3.0','lt')):  ?>width-60  <?php endif; ?>span8 form-horizontal fltlft">
		  <fieldset class="adminform">
			<legend><?php echo JText::_( 'Details' ); ?></legend>
							
				<?php echo $this->form->getLabel('id'); ?>
				
				<?php echo $this->form->getInput('id');  ?>
					
				<?php echo $this->form->getLabel('user_id'); ?>
				
				<?php echo $this->form->getInput('user_id');  ?>
					
				<?php echo $this->form->getLabel('temakor_id'); ?>
				
				<?php echo $this->form->getInput('temakor_id');  ?>
					
				<?php echo $this->form->getLabel('szavazas_id'); ?>
				
				<?php echo $this->form->getInput('szavazas_id');  ?>

				<div class="clr"></div>
					
					
				<?php echo $this->form->getLabel('leiras'); ?>
				
					
				<div class="clr"></div>
					
				<?php echo $this->form->getInput('leiras');  ?>
					
					
			
						
          </fieldset>                      
        </div>
        <div class="col <?php if(version_compare(JVERSION,'3.0','lt')):  ?>width-30  <?php endif; ?>span2 fltrgt">
			        

        </div>                   
		<input type="hidden" name="option" value="com_kepviselojeloltek" />
	    <input type="hidden" name="cid[]" value="<?php echo $this->item->id ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="view" value="kepviselojeloltek" />
		<?php echo JHTML::_( 'form.token' ); ?>
	</form>