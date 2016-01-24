if(typeof(akeeba) == 'undefined') {
	var akeeba = {};
}
if(typeof(akeeba.jQuery) == 'undefined') {
	akeeba.jQuery = jQuery.noConflict();
}

window.addEvent('domready', function(){
	document.id('pr_id_categories').addEvent('change', function(){
		var self = this;
		new Request.JSON({
			url : 'index.php?option=com_tracktime&view=category&task=read&format=json',
			autoCancel : true,
			onSuccess : function(category){
				document.id('pr_price').value = category.cat_price;
			}
		}).get({'id' : self.value})
	});
})