<div class="wrap">
  <h2>BMI Calculator Settings</h2>
  <form action="options-general.php?page=bmicalc" method="post">
    <table class="form-table">
      <tbody>
        <tr>
          <th scope="row">Color Skin</strong></th>
          <td>
            <?php foreach(BMICalc_start()->skins as $slug => $skindata): ?>
            <div style="float: left; width: 250px;">
              <span style="display:inline-block;width:50px;height:50px;background-color:#<?php echo $skindata[0]; ?>;padding-right:25px;">&nbsp;</span>
              <label style="display:inline-block;padding-top:20px;">
                <input type="radio" name="bmicalc_skin" value="<?php echo $slug; ?>"<?php echo (BMICalc_start()->skin == $slug) ? ' checked': ''; ?>/>&nbsp;<?php echo $skindata[1]; ?>
              </label>
            </div>
  
            <?php endforeach; ?>
          </td>
        </tr>
      </tbody>
    </table>
    <p><input type="submit" name="bmicalc_submit" value="Save Settings" class="button-primary"/></p>
  </form>
</div>