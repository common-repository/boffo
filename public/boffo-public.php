<?php
/**
 * @package    Boffo
 * @subpackage Boffo/public
 * @author     York Street Labs LLC <bill.catlin@yorkstreetlabs.com>
 */
class Boffo_Public {

	private $plugin_name;
	private $version;

	/**
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
		add_shortcode('boffo_flow', array('Boffo_Flow', 'renderShortCode'));
	}

	/**
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, BOFFO_PLUGIN_URL . 'assets/dist/public.css', array(), $this->version, 'all' );

	}

	/**
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, BOFFO_PLUGIN_URL . 'assets/dist/public.js', array('jquery'), $this->version, true );

		wp_localize_script($this->plugin_name, 'ajax', array(
        	'url' => admin_url('admin-ajax.php')
    	));

	}

	/**
	 * @since    1.0.0
	 */
	public function register_post_types() {
		$labels = array(
			'name'               => _x( 'Messages', 'post type general name', 'boffo' ),
			'singular_name'      => _x( 'Message', 'post type singular name', 'boffo' ),
			'menu_name'          => _x( 'Messages', 'admin menu', 'boffo' ),
			'name_admin_bar'     => _x( 'Message', 'add new on admin bar', 'boffo' ),
			'add_new'            => _x( 'Add New', 'Message', 'boffo' ),
			'add_new_item'       => __( 'Add New Message', 'boffo' ),
			'new_item'           => __( 'New Message', 'boffo' ),
			'edit_item'          => __( 'Edit Message', 'boffo' ),
			'view_item'          => __( 'View Message', 'boffo' ),
			'all_items'          => __( 'All Messages', 'boffo' ),
			'search_items'       => __( 'Search Messages', 'boffo' ),
			'parent_item_colon'  => __( 'Parent Messages:', 'boffo' ),
			'not_found'          => __( 'No messages found.', 'boffo' ),
			'not_found_in_trash' => __( 'No messages found in Trash.', 'boffo' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'boffo' ),
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'boffo-message' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'          => 'dashicons-email-alt',
			'supports'           => array( 'title')
		);

		register_post_type( 'boffo_message', $args );
	}

}
