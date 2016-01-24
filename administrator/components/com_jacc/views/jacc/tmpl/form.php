<?php

// no direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

// Set toolbar items for the page
$edit		= JRequest::getVar('edit', true);
$text = !$edit ? JText::_( 'New' ) : JText::_( 'Edit' );
JToolBarHelper::title(   JText::_('Component').': <small><small>[ ' . $text.' ]</small></small>' );
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

var numcvpairs = <?php echo $this->numcvpairs ?>;

window.addEvent('domready', function() {

	 document.formvalidator.setHandler('component',
            function (value) {
                    regex=/com_.*/;
                    if(regex.test(value) == false) {
						return alert('<?php echo JText::_('Component starts with com_'); ?>');
                    }
                    return true;
    });
});	

window.addEvent('domready', function() {
    document.formvalidator.setHandler('tables',
            function (value) {
				if(value == '') return alert('<?php echo JText::_('Please select table(s)') ?>');
        		return true;
    });
});	

function vremove(file) {
	$('vremove').value = file;
	submitbutton('vremove');
}


Joomla.submitbutton = function(task)
{
	if (task == 'cancel' || document.formvalidator.isValid(document.id('adminForm'))) {
		Joomla.submitform(task, document.getElementById('adminForm'));
	}
}

</script>
<div class="row-fluid">
	<form method="post" action="index.php" id="adminForm" name="adminForm">
		<div
			class="col <?php if(version_compare(JVERSION,'3.0','lt')): ?>width-60  <?php endif;?>span8 form-horizontal fltlft">
			<fieldset class="adminform">

				<legend>
					<?php echo JText::_( 'Details' ); ?>
				</legend>

				<div class="control-group">
					<?php echo $this->form->getLabel('name'); ?>					
					<?php echo $this->form->getInput('name');  ?>					
					<span style="line-height: 20px">(com_xxx)</span>
				</div>
				<div class="control-group">
					<?php echo $this->form->getLabel('version'); ?>
					<?php echo $this->form->getInput('version');  ?>					
				</div>
				<div class="control-group">
				<?php echo $this->form->getLabel('use'); ?>
				<?php echo $this->form->getInput('use');  ?>
				</div>
				<div class="control-group">
				<?php echo $this->form->getLabel('tables'); ?>

				<?php echo $this->form->getInput('tables');  ?>
				</div>
				<div class="control-group">
				<?php echo $this->form->getLabel('created'); ?>

				<?php echo $this->form->getInput('created');  ?>
				</div>
				<div class="control-group">
				<?php echo $this->form->getLabel('published'); ?>

				<?php echo $this->form->getInput('published');  ?>
				</div
	
		</fieldset>
	</div>

<div
	class="col <?php if(version_compare(JVERSION,'3.0','lt')): ?>width-40  <?php endif;?>fltrt span4">
	<?php if(version_compare(JVERSION,'3.0','lt')): ?>
	<div style="margin-top: 10px;"></div>
	<?php endif;?>
	<fieldset class="panelform">
		<legend>
			<?php echo JText::_( 'Description' ); ?>
		</legend>
		<div class="clr"></div>
		<?php echo $this->form->getInput('description');  ?>
	</fieldset>
	<fieldset class="panelform">
		<legend>
			<?php echo JText::_( 'Parameters' ); ?>
		</legend>
		<table>

			<?php foreach ($this->form->getFieldset('basic') as $field) : ?>
			<?php if ($field->hidden):  ?>
			<?php echo $field->input;  ?>
			<?php else:  ?>
			<tr>
				<td class="paramlist_key" width="40%"><?php echo $field->label;  ?>
				</td>
				<td class="paramlist_value"><?php echo $field->input;  ?>
				</td>
			</tr>
			<?php endif;  ?>
			<?php endforeach;  ?>
		</table>
	</fieldset>
	<fieldset class="panelform">
		<legend>
			<?php echo JText::_( 'Versions' ); ?>
		</legend>
		<div style="padding-left: 50px;">
			<?php 

			if ($count= count($this->item->files)):

			?>
			<ul>
				<?php foreach($this->item->files as $file):				 					 	
				$isRecent = stristr($file, '-'.$this->item->version.'.');
				?>
				<li style="border-bottom: 1px dotted #c0c0c0; height: 24px;"><a
					href="<?php echo JURI::base() ?>components/com_jacc/archives/<?php echo $file?>"><?php echo $file ?>
				</a> <?php if (!$isRecent ): ?> <a
					href="Javascript:vremove('<?php echo $file?>')" class="listicon"><img
						class="hasTip"
						src="<?php echo JURI::base() ?>components/com_jacc/assets/delete.png"
						title="Delete::Delete This Version"\ > </a> <?php endif; ?>
				</li>
				<?php
				$count--;
				 				endforeach; ?>
			</ul>

			<?php endif;?>
		</div>
	</fieldset>
</div>
<div
	class="col <?php if(version_compare(JVERSION,'3.0','lt')): ?>width-60  <?php endif;?>fltlft span10 form-horizontal">
	<fieldset class="adminform">
		<legend>View/Controller</legend>
		<div
			class="fltrt col <?php if(version_compare(JVERSION,'3.0','lt')): ?>width-20<?php endif;?>">
			<?php echo JText::_('AddViewControllerHelp')?>
		</div>
		<div id="vcpairs-container"
			class="fltlft col <?php if(version_compare(JVERSION,'3.0','lt')): ?>width-80<?php endif;?>">
			<?php foreach ($this->form->getFieldset('views') as $field) : ?>
			<?php echo $field->input;  ?>
			<?php endforeach;  ?>
		</div>
	</fieldset>
</div>
<input
	type="hidden" name="option" value="com_jacc" />
<input
	type="hidden" id="vremove" name="vremove" value="" />
<input
	type="hidden" name="cid[]" value="<?php echo $this->item->id ?>" />
<input type="hidden" name="task"
	value="" />
<input type="hidden" name="view"
	value="jacc" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>
<div class="clr"></div>
<div style="text-align: center; font-weight: bold; padding: 10px;">
	Jacc Version
	<?php print JaccHelper::getVersion() ?>
</div>
