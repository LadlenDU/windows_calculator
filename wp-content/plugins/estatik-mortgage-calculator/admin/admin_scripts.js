( function($) {	$(document).ready(function(){			    $('.show_on_pages').each(function () {	      es_show_page_list($(this));	    });	  	    $('.show_on_pages').change(function(){	      es_show_page_list($(this));	    });		$('.es_calc_tab').click(function() {			var tab_id = $(this).attr('href');			$('.es_calc_tab.active, .es_calc_options.active').removeClass('active');			$(this).add(tab_id).addClass('active');			return false;		});				$('.es_calc_switch input').change(function() {			var self = $(this);			if ( self.prop('checked') ) {				self.closest('.es_calc_option').next().removeClass('es_calc_hidden_option');			} else {				self.closest('.es_calc_option').next().addClass('es_calc_hidden_option');			}		});				$('.my-color-field').wpColorPicker();				$('.es_calc_input').focus(function() {			$(this).val('');		});				$('.es_calc_input').focusout(function() {			if ( $(this).val().length == 0 ) {				$(this).val($(this).attr('placeholder'));			}		});		$('.es_calc_options_submit').click(function() {			var is_ok = true;			function es_calc_error(problem) {				$('.es_calc_error').removeClass('es_calc_error');				problem.addClass('es_calc_error');				problem_tab = problem.closest('.es_calc_options').attr('id');				$('.es_calc_tab[href=#' + problem_tab + ']').click();				is_ok = false;			}			$('input').each(function() {				var 					max = 0,					self = $(this)					self_val = parseInt(self.val().replace(/,/g , ''));				if ( is_ok === false ) {					return;				} 				if ( self_val.length == 0 || self_val <= 0 ) {					es_calc_error(self);					return;				}				if ( self.hasClass('percent') && self_val > 100 ) {					es_calc_error(self);					return;				}				if ( self.hasClass('es_calc_has_max') ) {					max = parseInt(self.closest('.es_calc_pair').find('.es_calc_max_value').val().replace(/,/g , ''));					if ( self_val > max ) {						es_calc_error(self);						return;					}				}				if ( self.attr('name') == 'default_down_payment' ) {					max = parseInt($('input[name=max_purchase_price]').val().replace(/,/g , ''));					if ( self_val > max ) {						es_calc_error(self);						return;					}				}			});			return is_ok;		});	});	function es_show_page_list(select) {		if ( select.val() == 'all_pages' ) {		  	select.closest('.widget-content').find('.select_pages').hide('middle');		} else {		  	select.closest('.widget-content').find('.select_pages').show('middle');		}	}} )( jQuery );