<?php
// no direct access
defined('_JEXEC') or die;

		
		$document = JFactory::getDocument();
		
		$js = "	
			function ##component##GetCategories(object) {
			var select_cat = $('catid');
			var array_selected = new Array();
			var array_selected_name = new Array();
			for (var i = 0; i < select_cat.options.length; i++) { 
            	if (select_cat.options[ i ].selected) { 
					array_selected.push(select_cat.options[ i ].value);  
					array_selected_name.push(select_cat.options[ i ].text)
				}	
            }
            window.parent.document.getElementById(object + '_id').value = array_selected.join(',');
			window.parent.document.getElementById(object + '_name').value = array_selected_name.join('\\n ');
			window.parent.document.getElementById('sbox-window').close();
			}
";
		JHTML::_('behavior.mootools');
		$document->addScriptDeclaration($js);
	
		$values = explode(',', JRequest::getVar('value'));
		
	?>	
		
		<form action="index.php?option=com_##component##&amp;task=category&amp;tmpl=component&amp;object=id" method="post" name="adminForm">
				<table class="adminlist table table-striped">
			<thead>
				<tr>
					<td><?php echo JText::_('Select Categories') ?></td>
					<td>
					<input type="button" name="submit" value="Speichern" onClick="##component##GetCategories('catid');"/>
					</td>
				</tr>
			</thead>
			<tbody>
				<tr>

					<td colspan="2">
					<?php echo JHtml::_('##component##.categories', 'com_##component##', $values, 'catid', ' - Select Category - ', array('attributes'=>'multiple="multiple" class="inputbox" style="width:100%" size="25"','filter.published' => 1)); ?>
				</tr>
			</tbody>

			</table>			
		</form>
