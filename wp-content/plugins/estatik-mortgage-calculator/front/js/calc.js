/**
 * Calc
 *
 * @package Estatik Calculator
 * @subpackage JavaScript
 */

( function($) {
	$(document).ready(function() {
		var 
			decimals = $('#es_calc_decimals').val(),
			decimalpoint = $('#es_calc_decimalpoint').val(),
			separator = $('#es_calc_separator').val();

		if ( $(window).width() < 736 )  {
			$('.layout_horizontal').removeClass('layout_horizontal');
		}
		$('.layout_horizontal .es_calc_currency').each(function() {
			$(this).text(', ' + $(this).text() + ': ');		
		});

		$('.layout_horizontal .es_calc_option_info_icon').each(function() {
			var self = $(this);

			self.prependTo(self.closest('.es_calc_option'));
		});

	    $('.es_calc_option').each(function() {
	    	var
	    		self = $(this),
	    		input = self.find('.es_calc_input'),
	    		input_id = input.attr('id'),
	    		slider = self.find('.es_calc_rangeslider'),
	    		max = self.find('.es_calc_rangeslider_max').val(),
	    		from = self.find('.es_calc_rangeslider_default').val();

		    slider.ionRangeSlider({
				min: 0,
			    max: max,
			    from: from,
				onChange: function (data) {
					var value = data.from;

				    input.val( es_calc_number_format(value, decimals, decimalpoint, separator) );
		    		self.find('.es_calc_error_info').hide();
		    		self.find('.irs-line').removeClass('error');

		    		if ( input_id == 'es_calc_purchase_price' || input_id == 'es_calc_down_payment' ) {
		    			if ( change_down_payment_percent() === false ) {
				    		self.find('.irs-line').addClass('error');
		    			}
		    		}
				}
		    });
	    });

	    $('.es_calc_input').focus(function() {
	    	$(this).val('');
		});

	    $('.es_calc_input').blur(function() {
	    	var self = $(this);
		    self.val( es_calc_number_format(self.val(), decimals, decimalpoint, separator) );
	    });

	    $('#es_calc_down_payment, #es_calc_purchase_price').blur(function() {
	    	change_down_payment_percent();
	    });

	    $('.es_calc_submit').click(function() {
	    	var error = false;

		    $('.es_calc_option').each(function() {
		    	var 
		    		self = $(this),
	    			input = self.find('.es_calc_input');

		    	if ( input.val() == 0 ) {
		    		self.find('.es_calc_error_info').show();
		    		self.find('.irs-line').addClass('error');
		    		error = true;
		    	}

		    });

		    if ( toNumber($('#es_calc_down_payment').val()) > toNumber($('#es_calc_purchase_price').val()) ) {
	    		error = true;
		    }

	    	if ( error == false ) {
	    		$('.es_calc_submit').addClass('active');
		    	$('.es_calc_overlay').show();

				es_calc_mortgage();
	    	}
	    });

	    $('.es_calc_popup_close').click(function() {
	    	$('.es_calc_overlay').hide();
			$('.es_calc_submit').removeClass('active');
	    });
		
		function es_calc_mortgage() {
			var 
				// home_price_title = $('#es_calc_home_price_container .es_calc_result_title').text(),
				home_insurance_title = $('#es_calc_home_insurance_container .es_calc_result_title').text(),
				property_tax_title = $('#es_calc_property_tax_container .es_calc_result_title').text(),
				interest_title = $('#es_calc_interest_container .es_calc_result_title').text(),
				pmi_title = $('#es_calc_pmi_container .es_calc_result_title').text(),
				currency = $('.es_calc_currency:first').text(),

				purchase_price = toNumber($('#es_calc_purchase_price').val()), 
				down_payment_percent = $('#es_calc_down_payment_percent span'),
				down_payment = toNumber($('#es_calc_down_payment').val()),
				term_in_years = parseInt($('#es_calc_term').val()), 
				interest_rate = toNumber($('#es_calc_interest_rate').val()), 
				property_tax = get_condition_value($('#es_calc_property_tax')), 
				home_insurance = get_condition_value($('#es_calc_home_insurance')),
				pmi = get_condition_value($('#es_calc_pmi')),
				loan_amount, interest_in_absolute, payment, payment_total, all_payments;

	//			if ( down_payment_percent.closest('.es_calc_option').hasClass('es_calc_hidden_option') ) {
	//				down_payment = 0;
	//			} else {
	//				down_payment = parseFloat($('#es_calc_down_payment_percent span').text());
	//			}
	       
	        loan_amount = purchase_price - down_payment;

	        interest_in_absolute = loan_amount * interest_rate / 100;

	        var qty_payments = term_in_years * 12;
	        var rate = interest_rate / 100 / 12;
	        
	        var pvif = Math.pow(1 + rate, qty_payments);
		var pmt = Math.round(rate / (pvif - 1) * -(loan_amount * pvif));
	                
	        //var payment = Math.round(loan_amount * rate / (1 - Math.pow((1 + rate), (-qty_payments))) * 100) /100;
	        var interest_in_absolute = -pmt;
	        home_insurance = Math.round(home_insurance / 12 * 100) / 100;
	        property_tax = Math.round(property_tax / 12 * 100) / 100;
	        var payment_total = interest_in_absolute + property_tax + home_insurance + pmi;
	        var all_payments = payment_total * qty_payments;


			// $('#es_calc_home_price').text( es_calc_number_format(payment_total) );
			$('#es_calc_interest_result').text(es_calc_number_format(interest_in_absolute));
			$('#es_calc_pmi_result').text(es_calc_number_format(pmi));
			$('#es_calc_home_insurance_result').text(es_calc_number_format(home_insurance));
			$('#es_calc_property_tax_result').text(es_calc_number_format(property_tax));

			$('#es_calc_total').text( es_calc_number_format(payment_total) );


			var 
				series = [0, home_insurance, property_tax, interest_in_absolute, pmi],
				// labels = ['test1', 'test2', 'test3', 'test4', 'test5'],
				chart = new Chartist.Pie('.es_calc_chart', 
					{
					  	series: series
					  	// labels: labels
					}, {
					  	donut: true,
					  	showLabel: false
					});

			chart.on('draw', function(data) {
			  if(data.type === 'slice') {
			    // Get the total path length in order to use for dash array animation
			    var pathLength = data.element._node.getTotalLength();

			    // Set a dasharray that matches the path length as prerequisite to animate dashoffset
			    data.element.attr({
			      'stroke-dasharray': pathLength + 'px ' + pathLength + 'px'
			    });

			    // Create animation definition while also assigning an ID to the animation for later sync usage
			    var animationDefinition = {
			      'stroke-dashoffset': {
			        id: 'anim' + data.index,
			        dur: 100,
			        from: -pathLength + 'px',
			        to:  '0px',
			        easing: Chartist.Svg.Easing.easeOutQuint,
			        // We need to use `fill: 'freeze'` otherwise our animation will fall back to initial (not visible)
			        fill: 'freeze'
			      }
			    };

			    // If this was not the first slice, we need to time the animation so that it uses the end sync event of the previous animation
			    if(data.index !== 0) {
			      animationDefinition['stroke-dashoffset'].begin = 'anim' + (data.index - 1) + '.end';
			    }

			    // We need to set an initial value before the animation starts as we are not in guided mode which would do that for us
			    data.element.attr({
			      'stroke-dashoffset': -pathLength + 'px'
			    });

			    // We can't use guided mode as the animations need to rely on setting begin manually
			    // See http://gionkunz.github.io/chartist-js/api-documentation.html#chartistsvg-function-animate
			    data.element.animate(animationDefinition, false);
			  }
			});

		}

		function format_int(number) {
			return (number + '').replace(/(\d)(?=(\d{3})+$)/g, '$1,');
		}

		function toNumber(value) {
			if ( decimalpoint == '.' ) {
				return parseFloat(value.replace(/[\s,]+/g , ''));			
			} else {
				return parseFloat(value.replace(/[\s.]+/g , '').replace(/[,]+/g , '.'));			
			}
		}

		function get_condition_value(input_element) {
			if ( input_element.closest('.es_calc_option').hasClass('es_calc_hidden_option') ) {
				return 0;
			} else {
				return toNumber(input_element.val());			
			}
		}

		function change_down_payment_percent() {
			var 
				purchase_price,
				down_payment,
				down_payment_percent;

			purchase_price = toNumber($('#es_calc_purchase_price').val());
			down_payment = toNumber($('#es_calc_down_payment').val());

			if ( purchase_price > down_payment ) {
				down_payment_percent = down_payment / purchase_price * 100;
		    	$('#es_calc_down_payment_percent').text( 
		    		es_calc_number_format(down_payment_percent, decimals, decimalpoint, separator) 
	    		);
	    		return true; 				
			}
			return false;
		}
	});

	function es_calc_number_format (number, decimals, dec_point, thousands_sep) {
	    // Strip all characters but numerical ones.
	    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
	    var n = !isFinite(+number) ? 0 : +number,
	        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
	        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
	        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
	        s = '',
	        toFixedFix = function (n, prec) {
	            var k = Math.pow(10, prec);
	            return '' + Math.round(n * k) / k;
	        };
	    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
	    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
	    if (s[0].length > 3) {
	        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	    }
	    if ((s[1] || '').length < prec) {
	        s[1] = s[1] || '';
	        s[1] += new Array(prec - s[1].length + 1).join('0');
	    }
	    return s.join(dec);
	}

	$(window).load(function() {
		if ( $(window).width() < 736 )  {
			$('.layout_horizontal').removeClass('layout_horizontal');
		}
	});

} )( jQuery );
