<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php if ($this->field->get('formfield', 'text') =='editor'): ?>

				<div class="clr"></div>
					
<?php endif; ?>
					
				##codestart## echo $this->form->getLabel('<?php echo $this->field->get('key') ?>'); ##codeend##
				
<?php if ($this->field->get('formfield', 'text') =='editor'): 
?>					
				<div class="clr"></div>
					
<?php endif; 
?>
				##codestart## echo $this->form->getInput('<?php echo $this->field->get('key') ?>');  ##codeend##
