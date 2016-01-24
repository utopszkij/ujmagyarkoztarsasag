<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

// Set toolbar items for the page
$edit		= JRequest::getVar('edit', true);
$text = !$edit ? JText::_( 'New' ) : JText::_( 'Edit' );
JToolBarHelper::title(   JText::_( 'Temakorok' ).': <small><small>[ ' . $text.' ]</small></small>' );
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
			<div style="float:left; width:600px">	
        <?php echo $this->form->getLabel('megnevezes'); ?>
				<?php echo $this->form->getInput('megnevezes');  ?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('leiras'); ?>
				<div class="clr"></div>
				<?php echo $this->form->getInput('leiras');  ?>
				<div class="clr"></div>
      </div>
			<div style="float:left; width:400px">	
				<?php echo $this->form->getLabel('szulo'); ?>
				<?php echo $this->form->getInput('szulo');  ?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('lathatosag'); ?>
				<?php echo $this->form->getInput('lathatosag');  ?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('szavazok'); ?>
				<?php echo $this->form->getInput('szavazok');  ?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('szavazasinditok'); ?>
				<?php echo $this->form->getInput('szavazasinditok');  ?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('allapot'); ?>
				<?php echo $this->form->getInput('allapot');  ?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('letrehozo'); ?>
				<?php echo $this->form->getInput('letrehozo');  ?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('letrehozva'); ?>
				<?php echo $this->form->getInput('letrehozva');  ?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('lezaro'); ?>
				<?php echo $this->form->getInput('lezaro');  ?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('lezarva'); ?>
				<?php echo $this->form->getInput('lezarva');  ?>
      </div>
			<div class="clr"></div>
      </fieldset>                      
     </div>
     <div class="col <?php if(version_compare(JVERSION,'3.0','lt')):  ?>width-30  <?php endif; ?>span2 fltrgt">
     </div>                   
  	 <input type="hidden" name="option" value="com_temakorok" />
	   <input type="hidden" name="cid[]" value="<?php echo $this->item->id ?>" />
		 <input type="hidden" name="task" value="" />
		 <input type="hidden" name="view" value="temakorok" />
		 <?php echo JHTML::_( 'form.token' ); ?>
	</form>