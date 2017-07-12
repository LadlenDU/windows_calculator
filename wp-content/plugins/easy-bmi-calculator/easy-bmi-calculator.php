<?php
/**
 * Plugin Name: Easy BMI Calculator
 * Plugin URI: http://www.fancybmi.com/
 * Description: A free and easy to use BMI calculator plugin that provides a shortcode and a widget. It comes with custom skins so you can choose the design depending on your theme and style. Use the widget or insert the shortcode [bmi_calculator] on any post or page. Change the skin under  “Settings”.
 * Version: 2.1
 * Author: Twoultall
 * Author URI: http://www.fancybmi.com/
 */


// This file may not be executed directly
if (!defined('ABSPATH')) {
  exit();
}

if (!class_exists('BMICalculator')):

  final class BMICalculator
  {
    public $skin;
    public $title;
    public $skins = array(
      'blueair' => array('9DC3D4', 'Blue Air'),
      'caribbeansea' => array('00ABC0', 'Caribbean Sea'),
      'greenglass' => array('7ACCB8', 'Green Glass'),
      'nightskyblue' => array('0F4C81', 'Night Sky Blue'),
      'redhouse' => array('964F4C', 'Red House'),
      'lavender' => array('B18EAA', 'Lavender'),
      'titaniumgrey' => array('807D7F', 'Titanium Grey'),
      'glaciergrey' => array('C5C6C7', 'Glacier Grey'),
      'yellowcustard' => array('E5D68E', 'Yellow Custard'),
      'sandstone' => array('C48A69', 'Sandstone')
    );

    private static $instance;

    public static function instantiate()
    {
  		if (!isset(self::$instance) && !self::$instance instanceof BMICalculator) {
  			self::$instance = new BMICalculator;
  			self::$instance->includes();
  		}
  		return self::$instance;
    }

    public function includes()
    {
      $this->flush();

      if (!defined('BMICALC_PATH')) {
			  define('BMICALC_PATH', plugin_dir_path( __FILE__ ));
		  }

      if (!defined('BMICALC_URL')) {
        define('BMICALC_URL', plugins_url('', __FILE__));
      }

      require_once BMICALC_PATH . 'BMICalcWidget.php';
      require_once BMICALC_PATH . 'hooks.php';
    }

    public function flush()
    {
      $this->skin  = get_option('bmicalc_skin', 'blueair');
      $this->title = stripslashes(get_option('bmicalc_title', 'BMI Calculator'));
    }

    public static function shortcode()
    {
      ob_start();
      include BMICALC_PATH . 'template.php';
      $content = ob_get_contents();
      ob_end_clean();
      return $content;
    }

  }

  function BMICalc_start()
  {
    return BMICalculator::instantiate();
  }

  BMICalc_start();

endif;

?>