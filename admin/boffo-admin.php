<?php
/**
 * @package    Boffo
 * @subpackage Boffo/admin
 * @author     York Street Labs LLC <bill.catlin@yorkstreetlabs.com>
 */
class Boffo_Admin {

	private $plugin_name;
	private $version;

	/**
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, BOFFO_PLUGIN_URL . 'assets/dist/admin.css', array(), $this->version, 'all' );

	}

	/**
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, BOFFO_PLUGIN_URL . 'assets/dist/admin.js', array('jquery'), $this->version, true );

	}

	/**
	 * @since    1.0.0
	 */
	public function add_items_meta_box() {

		add_meta_box( 'boffomessageitemsbox', __( 'Items', 'boffo' ), array($this, 'build_items_meta_box'), 'boffo_message', 'normal', 'default' );

	}

	/**
	 * @since    1.0.0
	 */
	public function build_items_meta_box($message) {

		$items = get_post_meta($message->ID, 'items', true);

		if(empty($items)) {
			echo "<em>No items found.</em>";
			return;
		}

		echo "<ul>";

		foreach($items as $item) {
			echo "<li>" . $item['value'] . "</li>";
		}

		echo "</ul>";
		
	}

	/**
	 * @since    1.0.0
	 */
	public function add_plugin_menu() {
		
		add_menu_page(
            'Boffo', 
            'Boffo', 
            'manage_options', 
            'boffo', 
			array($this, 'render_admin_page'),
			'dashicons-text',
			100
        );

		add_submenu_page(
			'boffo', 
			'Messages', 
			'Messages', 
			'manage_options', 
			'edit.php?post_type=boffo_message'
		);

	}

	/**
	 * @since    1.0.0
	 */
	public function render_admin_page() {
		require('partials/boffo-admin-display.php');
	}

	/**
	 * @since    1.0.0
	 */
	public function add_flow_custom_column($columns) {
		$columns['flow_title'] = 'Flow';
		$columns['url'] = 'Referring URL';

		return $columns;
	}

	/**
	 * @since    1.0.0
	 */
	public function add_flow_custom_column_data( $column, $post_id ) {
		switch ( $column ) {
			case 'flow_title' :
				echo get_post_meta( $post_id , 'flow_title' , true );
				break;
			case 'url' :
				echo get_post_meta( $post_id , 'url' , true );
				break;
		}
	}

}
