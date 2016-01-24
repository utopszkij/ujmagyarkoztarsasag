/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     3.4.0 2014-12-19
 * @since       3.4.0
 *------------------------------------------------------------------------------
*/

(function($)
{
	$(document).ready(function()
	{
		$('*[rel=tooltip]').tooltip()

		// Turn radios into btn-group
		$('.ic-radio.ic-btn-group label').addClass('ic-btn');
		$(".ic-btn-group label:not(.active)").click(function()
		{
			var label = $(this);
			var input = $('#' + label.attr('for'));

			if (!input.prop('checked')) {
				label.closest('.ic-btn-group').find("label").removeClass('active ic-btn-success ic-btn-danger ic-btn-primary');
				if (input.val() == '') {
					label.addClass('active ic-btn-primary');
				} else if (input.val() == 0) {
					label.addClass('active ic-btn-danger');
				} else {
					label.addClass('active ic-btn-success');
				}
				input.prop('checked', true);
			}
		});
		$(".ic-btn-group input[checked=checked]").each(function()
		{
			if ($(this).val() == '') {
				$("label[for=" + $(this).attr('id') + "]").addClass('active ic-btn-primary');
			} else if ($(this).val() == 0) {
				$("label[for=" + $(this).attr('id') + "]").addClass('active ic-btn-danger');
			} else {
				$("label[for=" + $(this).attr('id') + "]").addClass('active ic-btn-success');
			}
		});
	})
})(jQuery);
