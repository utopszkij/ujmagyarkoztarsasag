if(typeof(akeeba) == 'undefined') {
	var akeeba = {};
}
if(typeof(akeeba.jQuery) == 'undefined') {
	akeeba.jQuery = jQuery.noConflict();
}

Request.implement({
	options : {target : ''}
});

function buildSelect(select, options)
{
    select.empty();
    var base_array = [{"value":'', 'text' : ' - Select - '}];
    base_array.combine(options);

    base_array.each(function(item) {

        var option = new Element('option', {
            value: item.value.toString()
        });
        option.set('html', item.text.toString());
        option.inject(select);
    });
}

var JSON_ajax = new Request.JSON({
	url : 'index.php?option=com_tracktime&format=json&layout=ajax',
	autoCancel : true,
	onRequest : function(){
		this.options.target.empty().addClass('waitingBG');
	},
	onSuccess : function(responseJSON){
			buildSelect(this.options.target, responseJSON)
			this.options.target.removeClass('waitingBG');
	}
});