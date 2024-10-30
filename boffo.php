<?php
/**
 *
 * @link              https://yorkstreetlabs.com
 * @since             1.0.0
 * @package           Boffo
 *
 * @wordpress-plugin
 * Plugin Name:       Boffo
 * Plugin URI:        https://yorkstreetlabs.com/boffo
 * Description:       Boffo replaces your traditional contact form with an engaging experience that will delight your visitors.
 * Version:           1.0.1
 * Author:            York Street Labs LLC
 * Author URI:        https://yorkstreetlabs.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       boffo
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

define('BOFFO_PLUGIN_VERSION', '1.0.1');

function activate_boffo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/boffo-activator.php';
	Boffo_Activator::activate();
}

function deactivate_boffo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/boffo-deactivator.php';
	Boffo_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_boffo' );
register_deactivation_hook( __FILE__, 'deactivate_boffo' );

require plugin_dir_path( __FILE__ ) . 'includes/boffo.php';

define('BOFFO_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Begins execution of boffoe.
 *
 * @since    1.0.0
 */
function run_boffo() {

	$plugin = new Boffo();
	$plugin->run();

}
run_boffo();
