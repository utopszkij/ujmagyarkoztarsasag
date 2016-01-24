(function ($) {

	$.fn.highlightToday = function(option) {
		var d = new Date(),
			day = '0' + d.getDate(),
			month = '0' + (d.getMonth() + 1),
			year = d.getFullYear(),
			client_date = year + '-' + month.slice(-2) + '-' + day.slice(-2),
			$today = $('.style_Today', this),
			cal_date = $today.attr('data-cal-date');//cal_date='2014-01-07'; // Test data
		if (typeof cal_date === 'undefined' || client_date !== cal_date) {
			// Calendar date not in the displayed month - or client date is different
			$today.removeClass('style_Today').addClass('style_Day');
			$('.style_Day[data-cal-date="' + client_date + '"]', this).addClass('style_Today').removeClass('style_Day');
			// Check whether the correct month is loaded if today is required to be shown
			if (option === 'show_today') {
				if ($('.style_Today', this).length === 0) {
					// The current date is not shown (because of offset between server and client date)
					if (client_date > cal_date) {
						// Load next month
						$('.nextic', this).click();
					} else {
						// Load previous month
						$('.backic', this).click();
					}
				}
			}
		}
		// Support chaining
		return this;
	};

}(jQuery));
