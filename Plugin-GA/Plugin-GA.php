<?php
/*
Plugin Name: Google Analytics-UD
Description: Inserción código Google Analytics
Version: 1.0
Author: Miren Cava */

add_action("wp_head", "setGA");

function setGA()
{
  $options = get_option('ud_analytics_setup');
  if(isset( $options['UA']) && !empty( $options['UA'])){
    echo '<!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id='.$options['UA'].'"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag("js", new Date());
      gtag("config", "'.$options['UA'].'");
    </script>';
  }
   

}

add_action('admin_menu', 'ud_analytics_init');

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


  // $_POST tenemos el control de manejar los datos que llegan del formulario
  if (isset($_POST['ud_analytics_setup_submitted']) && $_POST['ud_analytics_setup_submitted']) {
    $options['UA']   = isset($_POST['UA']) && !empty($_POST['UA']) ? $_POST['UA'] : '';

    if( preg_match("/^UA-[0-9]*-[0-9]{1}/" ,$options['UA'] )>0){
      update_option('ud_analytics_setup', $options);
  
      ?>
      <div id="setting-error-settings_updated" class="updated settings-error">
      
          <button onclick="borrarBanner()" >Cerrar</button>
          <p><strong>Configuración guardada.</strong></p>
      </div>
      <script type="text/javascript">
            function borrarBanner() {
              document.getElementById("setting-error-settings_updated").remove();
            }
      </script> 
  
  
      <?php

    }else {

      $options['UA'] = '';
      ?>
      <div id="setting-error-settings_updated" class="updated settings-error">
      
          <button onclick="esconderBanner()" >Cerrar</button>
          <p><strong>EL formato del código no es correcto tiene que ser: UA-XXXXXX-X</strong></p>
      </div>
      <script type="text/javascript">
            function esconderBanner() {
              document.getElementById("setting-error-settings_updated").remove();
            }
      </script> 
  
  
      <?php
      
    }

   
  }

	?>
  <div class="wrap">
    <div id="icon-options-general" class="icon32"><br /></div>

  
    <form action="?page=ud-google-analytics"  method="post">
         
          <h3>Configuración de Google Analytics</h3>
          <table class="form-table">
              <tr valign="top">
                  <th scope="row"><label for="UA">Código Analytics:</label></th>
                  <td><input placeholder="Código Analytics" name="UA" id="UA" value="<?php echo esc_attr(stripslashes($options['UA']));?>" required></td>
              </tr>
        
          </table>
          <input type="hidden" name="ud_analytics_setup_submitted" value="1" />
            <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Guardar cambios"  /></p>
    </form>
  </div>
<?php

}

?>