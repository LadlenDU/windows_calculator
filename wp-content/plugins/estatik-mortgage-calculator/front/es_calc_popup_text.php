<div class="es_calc_overlay">	<div class="es_calc_popup es_calc_popup_text">	    <div class="es_calc_popup_close" title="<?php _e('Close', 'es-calc') ?>"></div>		<h1><?php _e('Your total monthly payment', 'es-calc') ?></h1>		<h2><?php echo $settings->currency ?><span id="es_calc_total"></span></h2>		<hr />		<!-- <div class="es_calc_result_container">			<span class="es_calc_result_title"><?php _e('Home price', 'es-calc') ?>: </span>			<span class="es_calc_result_value">				<?php echo $settings->currency ?>				<span id="es_calc_home_price"></span>			</span>		</div> -->		<div class="es_calc_result_container">			<span class="es_calc_result_title"><?php _e('Principal & Interest', 'es-calc') ?>: </span>			<span class="es_calc_result_value">				<?php echo $settings->currency ?>				<span id="es_calc_interest_result"></span>			</span>		</div>		<?php if ( $settings->property_tax == 'on' ) { ?>			<div class="es_calc_result_container">				<span class="es_calc_result_title"><?php _e('Home insurance', 'es-calc') ?>: </span>				<span class="es_calc_result_value">					<?php echo $settings->currency ?>					<span class="es_calc_result" id="es_calc_home_insurance_result"></span>				</span>			</div>		<?php } ?>		<?php if ( $settings->home_insurance == 'on' ) { ?>			<div class="es_calc_result_container">				<span class="es_calc_result_title"><?php _e('Property taxes', 'es-calc') ?>: </span>				<span class="es_calc_result_value">					<?php echo $settings->currency ?>					<span class="es_calc_result" id="es_calc_property_tax_result"></span>				</span>			</div>		<?php } ?>		<?php if ( $settings->pmi == 'on' ) { ?>			<div class="es_calc_result_container">				<span class="es_calc_result_title"><?php _e('PMI', 'es-calc') ?>: </span>				<span class="es_calc_result_value">					<?php echo $settings->currency ?>					<span id="es_calc_pmi_result"></span>				</span>			</div>		<?php } ?>	</div></div>