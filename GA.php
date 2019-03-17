<?php
/*
Plugin Name: ADD GA TAG
Author: Miren Cava */

// Hook the 'wp_head' action hook, add the function named 'setGA' to it
add_action("wp_head", "setGA");

// UA-136408159-1
function setGA()
{
  $options = get_option('ud_analytics_setup');
  error_log("Estamos en setGA ");
  error_log( $options['UA']);
  echo '<!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id='.$options['UA'].'"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag("js", new Date());
    gtag("config", "'.$options['UA'].'");
  </script>'; 

}


add_action('admin_menu', 'ud_analytics_init');

// añade el menu en el sidebar de la izquierda
function ud_analytics_init(){
	add_menu_page(
		"Google Analytics",
		"Google Analytics",
		'level_10',
		'ud-google-analytics',
		'ud_analytics_setup'
	);
}

function ud_analytics_setup(){
  $options = get_option('ud_analytics_setup');
  if(!is_array($options)){
    $options['UA'] = '';

  }


  if (isset($_POST['ud_analytics_setup_submitted']) && $_POST['ud_analytics_setup_submitted']) {
    $options['UA']   = isset($_POST['UA']) && !empty($_POST['UA']) ? $_POST['UA'] : '';
    //Guarda valores
    update_option('ud_analytics_setup', $options);
    error_log( $options['UA']);

    ?>
    <div id="setting-error-settings_updated" class="updated settings-error">
        <p><strong>Configuración guardada.</strong></p>
    </div>
    <?php
  }

  
	?>
  <div class="wrap">
    <div id="icon-options-general" class="icon32"><br /></div>


    <form action="?page=ud-google-analytics"  method="post">
         
          <h3>Configuración de Google Analytics</h3>
          <table class="form-table">
              <tr valign="top">
                  <th scope="row"><label for="UA">Código Analytics:</label></th>
                  <td><input placeholder="Código Analytics" name="UA" id="UA" value="<?php echo esc_attr(stripslashes($options['UA']));?>"></td>
              </tr>
              
          </table>


        
          <input type="hidden" name="ud_analytics_setup_submitted" value="1" />
            <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Guardar cambios"  /></p>
    </form>
  </div>
<?php

}

?>