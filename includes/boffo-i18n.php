<?php
/**
 * @since      1.0.0
 * @package    Boffo
 * @subpackage Boffo/includes
 * @author     York Street Labs LLC <bill.catlin@yorkstreetlabs.com>
 */
class Boffo_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'boffo',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
