<?php 
defined('_JEXEC') or die('Restricted access'); 


JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

// Set toolbar items for the page
$edit		= JRequest::getVar('edit', true);
$text = !$edit ? JText::_( 'New' ) : JText::_( 'Edit' );
JToolBarHelper::title(   JText::_( '##Name##' ).': <small><small>[ ' . $text.' ]</small></small>' );
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
	 	<div class="col <?php if(version_compare(JVERSION,'3.0','lt')): ?>width-60  <?php endif;?>span8 form-horizontal fltlft">
		  <fieldset class="adminform">
			<legend><?php  echo JText::_( 'Details' );?></legend>
					Sample Data 						
          </fieldset>                      
        </div>
        <div class="col <?php if(version_compare(JVERSION,'3.0','lt')): ?>width-40  <?php endif;?>span2  fltrt">    
			<fieldset class="adminform">
				<legend><?php  echo JText::_( 'Parameters' ); ?></legend>
						Your Code
			</fieldset>
        </div>                   
		<input type="hidden" name="option" value="##com_component##" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="view" value="##name##" />
		<?php echo JHTML::_( 'form.token' ); ?> 
	</form>