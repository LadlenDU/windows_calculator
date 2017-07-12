<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class BMICalcWidget extends WP_Widget
{

  public function __construct()
  {
    parent::__construct(
        'bmi_calculator',
        'BMI Calculator'
    );
  }

  public function widget($args, $instance)
  {
    $title = apply_filters( 'widget_title', $instance['title'] );
        echo $args['before_widget'];
        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];

    
    echo BMICalculator::shortcode();
   
    echo $args['after_widget'];
  }

  public function form($instance)
  {
     if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'easy-bmi-calculator' );
        }
    ?>
      <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:' , 'easy-bmi-calculator'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
    <p>Click <a href="options-general.php?page=bmicalc">here</a> for BMI Calculator settings</p>
    <?php
  }

  public function update($new_instance, $old_instance)
  {  $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;      

  }

}
