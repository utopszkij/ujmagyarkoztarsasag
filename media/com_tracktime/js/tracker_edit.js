if(typeof(akeeba) == 'undefined') {
	var akeeba = {};
}
if(typeof(akeeba.jQuery) == 'undefined') {
	akeeba.jQuery = jQuery.noConflict();
}

window.addEvent('domready', function(){
	var COUNTER = 0;
	var timer;
	var minutes = document.id('counter');

	function tick()
	{
		COUNTER += 15;
		minutes.set('html', (COUNTER / 60).round(2));
		timer = setTimeout(tick, 15000);
	}

	document.id('start').addEvent('click', function(){
		if(this.value == 'Start')
		{
			timer = setTimeout(tick, 15000);
			this.value = 'Pause';
			document.id('bar').setStyle('display', 'inline');
			window.addEvent('beforeunload', function(){
				return confirm("Your're recording an activity, do you really want to exit?");
			});
		}
		else
		{
			this.value = 'Start';
			clearTimeout(timer);
			document.id('bar').setStyle('display', 'none');
		}
	})

	document.id('stop').addEvent('click', function(){
		window.removeEvents('beforeunload');
		document.id('bar').setStyle('display', 'none');
		document.id('start').value = 'Start';
		clearTimeout(timer);

		var end = new Date();
		var start = end.clone().decrement('second', COUNTER);

		document.id('tr_start').value = start.format("%Y-%m-%d %H:%M");
		document.id('tr_stop').value  = end.format("%Y-%m-%d %H:%M");
		document.id('tr_hours').value = (COUNTER / 3600).round(2);

		COUNTER = 0;
	});

	var max_height = 0;
	$$('fieldset.sameHeight').each(function(item){
		if(item.getStyle('height').toInt() > max_height){
			max_height = item.getStyle('height').toInt();
		}
	});

	$$('fieldset.sameHeight').setStyle('height', max_height);
});