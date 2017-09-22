<?php 
/**
 * Plugin Name: Trimple Super JS Tables
 * Plugin URI: https://www.trimple.eu/services/worpdress-plugin/trimple-js-table
 * Description: This plugin  Add Some JS Component in Your HTMl Table
 * Version: 1.0.0
 * Author: Vasilis Karabalis
 * Author URI: https://www.trimple.eu/about
 * License: GPL2
 */

add_action( 'wp_enqueue_scripts', 'my_enqueued_assets' );
function my_enqueued_assets() {
	wp_enqueue_script( 'my-script', plugin_dir_url( __FILE__ ) . '/js/app.js', array( 'jquery' ), '2.1', true );
}
add_action( 'wp_enqueue_scripts', function() {

    // Get the current data
    if ( empty ( $table_id =  get_option('table_id', 'Table Id') ) ) {
        $table_id = 'No Table ID';
    }
    if ( empty ( $table_limits =  get_option('table_limits', 'Table Limits') ) ) {
        $table_limits = 'No Table Limits';
    }

    // Localize script with data to `twitter_settings` object
    wp_localize_script( 'my-script', 'my_script', array( 
    	'table_id' 		=> 	$table_id ,
    	'table_limits'	=>	$table_limits

    ) );

    // Enqueued script with localized data.
    wp_enqueue_script( 'my-script' );
} );

add_action('admin_menu', 'my_plugin_menu');

function my_plugin_menu() {
	add_menu_page('Super JS Table', 'Super JS Table', 'administrator', 'my-plugin-settings', 'my_plugin_settings_page', 'dashicons-admin-generic');
}

function my_plugin_settings_page() { ?>
<div class="wrap">
<img width="200px"  src="<?php echo plugin_dir_url( __FILE__ ) ; ?>img/trimple_logo.png">
<h2>Super JS Table Settings</h2>
<p>Για να χρησιμοπήσετε το Plugin Πρέπει να κάνετε τα παρακάτω βήματα :</p>
<ul>
    <li>Φτιάξτε έναν πίνακα και ορίστε ένα μοναδικό ID π.χ.('id="table1"')</li>
    <li>Στο Πεδίο Table ID συμπληρώστε το ID που έχετε ορίσει στον πίνακα που δημιουρήσατε π.χ.(table1) </li>
    <li> Στη συνέχει στο πεδίο Table Limits το όριο το γραμμών που θέλετε να εμφανίζεται κάθε φορά π.χ.(Αν θέλετε να εμφανίζονται ανα  5,10,15 κλπ.)</li>
    <li>Στα πεδία More Button Name/Class & Less Button Name/class  ορίζουμε το όνομα και την κλάση του κάθε κουμπιού  για να αλλάξουμε γραμμές</li>
    <li>Για να εμφανιστούν τα κουμπιά θα πρέπει κάτω απο τον κάθε πίνακα να βάλετε το shortcode [js_button].
     Αν θέλετε να τα εμφανίσετε ξεχωριστά [less_js_button] &  [more_js_button]. </li>
    <li>Η Έκδοση Αυτή είναι Δωρεάν και υποστηρίζει έναν μόνο id πίνακα.</li>
    <li>Η Pro Έκδοση υποστηρίζει απεριόριστο αριθμό πινάκων καθώς και επιπλέον style στα κουμπιά.</li   >
</ul>
<form method="post" action="options.php">
    <?php settings_fields( 'my-plugin-settings-group' ); ?>
    <?php do_settings_sections( 'my-plugin-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Table ID</th>
        <td><input type="text" name="table_id" value="<?php echo esc_attr( get_option('table_id') ); ?>" /></td>
        </tr>
        <tr valign="top">
        <th scope="row">Table Limits</th>
        <td><input type="text" name="table_limits"  value="<?php echo esc_attr( get_option('table_limits') ); ?>" /></td>
        </tr>
       
        <tr valign="top">
        <th scope="row">More Button Name/Class</th>
        <td>
        	<input type="text" name="more_button_name" placeholder="More" value="<?php echo esc_attr( get_option('more_button_name') ); ?>" />
        	<input type="text" name="more_button_class" placeholder="Class name" value="<?php echo esc_attr( get_option('more_button_class') ); ?>" />
        </td>
        </tr>
        <tr valign="top">
        <th scope="row">Less Button Name/class</th>
        <td><input type="text" name="less_button_name" placeholder="Less" value="<?php echo esc_attr( get_option('less_button_name') ); ?>" /><input type="text" name="less_button_class" placeholder=" class name" value="<?php echo esc_attr( get_option('less_button_class') ); ?>" /></td>
        </tr>
        <!--<tr valign="top">
        <th scope="row">Enable Sort Columns</th>
        <td><input type="checkbox" name="sort_columns"  value="1"<?php //  checked( 1, get_option('sort_columns'), true ) ;?> /></td>
        </tr>-->
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<?php  }
add_action( 'admin_init', 'my_plugin_settings' );

function my_plugin_settings() {
	register_setting( 'my-plugin-settings-group', 'table_id' );
	register_setting( 'my-plugin-settings-group', 'more_button_name' );
	register_setting( 'my-plugin-settings-group', 'less_button_name' );
	register_setting( 'my-plugin-settings-group', 'less_button_class' );
	register_setting( 'my-plugin-settings-group', 'more_button_class' );
	register_setting( 'my-plugin-settings-group', 'table_limits' );
    register_setting( 'my-plugin-settings-group', 'sort_columns' );
}

function buttons_super_js_table() {
      $more ="<input type='button' class='".get_option('more_button_class', 'Table More button Class')."' id='seeMoreRecords' value='".get_option('more_button_name', 'Table More button Name')."'>";
	  $less ="<input type='button' class='".get_option('less_button_class', 'Table More button Class')."' id='seeLessRecords' value='".get_option('less_button_name', 'Table More button Name')."'>";
	  	
	  return $more.$less;
 }
add_shortcode( 'js_button', 'buttons_super_js_table' );
function more_button_super_js_table() {
      $more ="<input type='button' class='".get_option('more_button_class', 'Table More button Class')."' id='seeMoreRecords' value='".get_option('more_button_name', 'Table More button Name')."'>";
	  return $more;
 }
add_shortcode( 'more_js_button', 'more_button_super_js_table' );

function less_button_super_js_table() {
      $less ="<input type='button' class='".get_option('less_button_class', 'Table More button Class')."' id='seeLessRecords' value='".get_option('less_button_name', 'Table More button Name')."'>";
	  	
	  return $less;
 }
add_shortcode( 'less_js_button', 'less_button_super_js_table' );

/*
"<input type="button" id="seeMoreRecords" class=" get_option('more_button_class', 'Table More button Class')' value="<?php echo  get_option('more_button_name', 'Table More button Name')  ?>">
	<input type="button" id="seeLessRecords"  class=" <?php echo get_option('less_button_class', 'Table Less button Class')  ?>" value="<?php echo  get_option('less_button_name', 'Table Less button Name')  ?>">";
	*/
