<?php defined('_JEXEC') or die('Restricted access'); 
$format = '%Y-%m-%d';
$datesize = 10;
?>
<<?php echo '?'?>xml version="1.0" encoding="utf-8"##codeend##
<form>
	<fields>
<?php foreach ($this->formfield as $field) {
						
						
			     		if ($field->get('additional')) continue;
			     		if ($field->get('key') == 'params') continue;
			     		$required = $field->get('required') ? $field->get('required') : 'false';
			     		$size= $field->get('size') ? $field->get('size') : '40';
			     		$label= $field->get('label') ? $field->get('label') : ucfirst($field->get('key'));  
			     		switch($field->get('key')) {
							case 'catid': 
							case 'category_id':
								if($this->uses_categories):								
								?>
			     									
		<field 
			id="name"
			name="<?php echo $field->get('key') ?>"
			type="##component##category"
			label="Category"
			required="true"
			extension="com_##component##.##name##"
			description="<?php echo $field->get('key') ?>_Desc"
			class="inputbox"
			size="1"/>
				<?php
					 			endif;
								break;
						case $this->primary: ?>

		<field
			name="<?php echo $this->primary ?>"
			type="hidden"
			default="0"
			required="true"
			readonly="true"/>							
							<?php 	
							break;		
						default:
						switch (strtolower($field->get('formfield'))) {
							case 'list': ?>
		
		<field
			id="<?php echo $field->get('key') ?>"
			name="<?php echo $field->get('key') ?>"
			type="list"
			class="inputbox"
			default="1"
			required="<?php echo $required ?>"
			size="1"
			label="<?php echo $label ?>"
			description="<?php echo $field->get('key') ?>_Desc">
			<option
				value="0">
				Option None</option>
			<option
				value="1">
				First Option</option>
			<option
				value="2">
				Second Option</option>
			<option
				value="3">
				And so on</option>
		</field>										
<?php							
								break;
			     			case 'published': ?>

		<field
			id="published"
			name="published"
			type="list"
			class="inputbox"
			default="1"
			size="1"
			label="JField_Published_Label"
			description="JField_Published_Desc">
			<option
				value="1">
				JOption_Published</option>
			<option
				value="0">
				JOption_UnPublished</option>
			<option
				value="-1">
				JOption_Archived</option>
			<option
				value="-2">
				JOption_Trashed</option>
		</field>
                          <?php 										
								break;
								
							case 'editor':
?>

		<field
			id="<?php echo $field->get('key') ?>"
			name="<?php echo $field->get('key') ?>"
			type="editor"
			label="<?php echo $label ?>"
			description="<?php echo $field->get('key') ?>_Desc"
			class="inputbox"
			buttons="readmore,pagebreak"/>
							<?php 		  	
						  		break;		
							case 'calendar':
								if ($field->get('fieldtype') == 'datetime') {
									$format = '%Y-%m-%d %H-%M-%S'; 
									$datesize = 16;
								}
?>

		<field
			id="<?php echo $field->get('key') ?>"
			name="<?php echo $field->get('key') ?>"
			type="calendar"
			required="<?php echo $required ?>"
			label="<?php echo $label ?>"
			description="<?php echo $field->get('key') ?>_Desc"
			class="inputbox"
			size="<?php echo $datesize ?>"
			format="<?php echo $format ?>"/>			
							
							<?php							
								break;
							case 'text': 
?>
								
		<field
			id="<?php echo $field->get('key') ?>"
			name="<?php echo $field->get('key') ?>"
			type="text"
			required="<?php echo $required ?>"
			label="<?php echo $label ?>"
			description="<?php echo $field->get('key') ?>_Desc"
			class="inputbox"
			size="40"/>						
								
						<?php 		  	
						  		break;																		
							case 'null':					
?>

		<field
			name="<?php echo $field->get('key') ?>"
			type="hidden"
			filter="unset"/>						  
							<?php 		
								break;		  	
							 default:														
							?>
												
		<field
			id="<?php echo $field->get('key') ?>"
			name="<?php echo $field->get('key') ?>"
			required="<?php echo $required ?>"
			type="<?php echo $field->get('formfield') ?>"
			label="<?php echo $label ?>"
			description="<?php echo $field->get('key') ?>_Desc"
			class="inputbox"
			size="<?php echo $size ?>"/>						
						<?php
						} 		 	
						}
			     		
}
 ?>
		
	</fields>	
	<?php if (isset($this->formfield['params'])): ?>
	
	<fields name="params">
		<fieldset
			name="basic">		
			<field
				name="example_param"
				type="list"
				default=""
				label="Params_Example_Label"
				description="Params_Example_Desc">
				<option
					value="0">No</option>
				<option
					value="1">Yes</option>
			</field>
		</fieldset>
	</fields>
	<?php endif; ?>	
</form>	