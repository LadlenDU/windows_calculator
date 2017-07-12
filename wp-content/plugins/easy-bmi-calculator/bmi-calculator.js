(function($){
  $(document).ready(function(){

    $(".bmi-calculator-button").on('click', function(){
      var $root = $(this).parent().parent();
      var $system = $($root.find("input[type=\"radio\"]:checked")[0]);
      var system = $system.val();

      if (system == 'imperial') {
        var selects = $root.find(".bmi-calculator-dimensions-imperial select");
        var feet = parseFloat($(selects[0]).val());
        var inches = parseFloat($(selects[1]).val());
        var weight = parseFloat($($root.find(".bmi-calculator-dimensions-imperial input[type=\"text\"]")[0]).val());
        var bmi = $.calculateBMI($.FtInToIn(feet, inches), weight, system);
      } else {
        var dimensions = $root.find(".bmi-calculator-dimensions-metric input[type=\"text\"]");
        var height = parseFloat($(dimensions[0]).val());
        var weight = parseFloat($(dimensions[1]).val());
        var bmi = $.calculateBMI(height / 100, weight, system);
      }

      if (isNaN(bmi) || bmi == 0) {
        var results = $($root.find(".bmi-calculator-results")[0]);
        results.removeClass('none');
        results.removeClass('healthy');
        results.removeClass('caution');
        results.removeClass('unhealthy');
        results.addClass('none');
        return;
      }

      var results = $($root.find(".bmi-calculator-results")[0]);
      results.removeClass('none');
      results.removeClass('healthy');
      results.removeClass('caution');
      results.removeClass('unhealthy');
      results.addClass($.getAlertStatus(bmi));
      results.html("BMI: " + bmi + "<br/>" + $.getWHOclassification(bmi));
    });

    $(".bmi-calculator-system-radio").on('click', function(){
      var $root = $(this).parent().parent().parent();

      var selects = $root.find(".bmi-calculator-dimensions-imperial select");
      $(selects[0]).val(1);
      $(selects[1]).val(0);
      $($root.find(".bmi-calculator-dimensions-imperial input[type=\"text\"]")[0]).val(0);
      var dimensions = $root.find(".bmi-calculator-dimensions-metric input[type=\"text\"]");
      $(dimensions[0]).val(0);
      $(dimensions[1]).val(0);

      var results = $($root.find(".bmi-calculator-results")[0]);
      results.removeClass('none');
      results.removeClass('healthy');
      results.removeClass('caution');
      results.removeClass('unhealthy');
      results.addClass('none');

      var systems = $root.find("input[type=\"radio\"]");
      systems.each(function(){
        $(this).prop('checked', false);
      });

      $(this).prop('checked', true);
      var system = $(this).val();

      if (system == 'imperial') {
        $($root.find(".bmi-calculator-dimensions-imperial")[0]).css("display", "block");
        $($root.find(".bmi-calculator-dimensions-metric")[0]).css("display", "none");
      } else {
        $($root.find(".bmi-calculator-dimensions-imperial")[0]).css("display", "none");
        $($root.find(".bmi-calculator-dimensions-metric")[0]).css("display", "block");
      }

    });

    $.calculateBMI = function(height, weight, system) {
      var BMI = 0.0;

      if (system == 'imperial') {
        BMI = (weight * 703) / Math.pow(height, 2);
      } else {
        BMI = weight / Math.pow(height, 2);
      }

      return Math.round(BMI * 100) / 100;
    };

    $.FtInToIn = function(feet, inches) {
      return (feet * 12) + inches;
    };

    $.getAlertStatus = function(BMI) {

      if (BMI < 16 || BMI >= 40) {
        return 'unhealthy';
      } else if (BMI < 18.5 || BMI >= 25) {
        return 'caution';
      } else {
        return 'healthy';
      }

    };

    $.getWHOclassification = function(BMI) {

      if (BMI < 16) {
        return 'Severe Thinness';
      } else if (BMI < 17) {
        return 'Moderate Thinness';
      } else if (BMI < 18.5) {
        return 'Mild Thinness';
      } else if (BMI < 25) {
        return 'Normal Range';
      } else if (BMI < 30) {
        return 'Pre-obese';
      } else if (BMI < 35) {
        return 'Obese Class I';
      } else if (BMI < 40) {
        return 'Obese Class II';
      } else {
        return 'Obese Class III';
      }

    };

  });
})(jQuery);
