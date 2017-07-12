<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$BMICalc_notice;

add_action('init', 'BMICalc_init');
add_action('widgets_init', 'BMICalc_widgets');
add_action('admin_menu', 'BMICalc_settings_menu');
add_action('admin_init', 'BMICalc_save_settings');
add_action('admin_notices', 'BMICalc_admin_notices');
add_action('wp_enqueue_scripts', 'BMICalc_stylesheet');

function BMICalc_init()
{
  add_shortcode('bmi_calculator', array('BMICalculator', 'shortcode'));
}

function BMICalc_widgets()
{
  register_widget('BMICalcWidget');
}

function BMICalc_settings_menu()
{
  add_options_page('BMI Calculator', 'BMI Calculator', 'manage_options', 'bmicalc', 'BMICalc_settings_page');
}

function BMICalc_settings_page()
{
  include BMICALC_PATH . 'settings.php';
}

function BMICalc_save_settings()
{
  global $BMICalc_notice;
  if (isset($_POST['bmicalc_submit'])) {

    if (isset($_POST['bmicalc_skin'])) {
      $skin = strval($_POST['bmicalc_skin']);
      $skin = sanitize_text_field($skin);

      if ( in_array( $skin, array_keys(BMICalc_start()->skins) ) ) {
        update_option('bmicalc_skin', $skin);
      } else {
        $BMICalc_notice = array("error", "Invalid skin seting value provided.");
      }

    }

    if (isset($_POST['bmicalc_title'])) {
      $title = strval($_POST['bmicalc_title']);
      $title = sanitize_text_field($title);

      update_option('bmicalc_title', $title);
    }

    $BMICalc_notice = array("updated", "Settings Saved");
    BMICalc_start()->flush();

  }
}

function BMICalc_admin_notices()
{
  global $BMICalc_notice;
  if (is_array($BMICalc_notice) && count($BMICalc_notice) >= 2) {
    ?>
    <div class="<?php echo $BMICalc_notice[0]; ?>">
      <p><?php echo $BMICalc_notice[1]; ?></p>
    </div>
    <?php
  }
}

function BMICalc_stylesheet()
{
  wp_enqueue_style('bmicalc_style', BMICALC_URL . '/template.css');
  wp_enqueue_script('bmicalc_script', BMICALC_URL . '/bmi-calculator.min.js', array('jquery'));
}

function register_session(){
    if( !session_id() )
        session_start();
}

function myEndSession() {
    session_destroy ();
}
add_action('init','register_session');
add_action('wp_logout', 'myEndSession');
add_action('wp_login', 'myEndSession');