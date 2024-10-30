<?php
/**
 * @since      1.0.0
 * @package    Boffo
 * @subpackage Boffo/includes
 * @author     York Street Labs LLC <bill.catlin@yorkstreetlabs.com>
 */
class Boffo {

	protected $loader;
	protected $plugin_name;
	protected $version;

	/**
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'BOFFO_PLUGIN_VERSION' ) ) {
			$this->version = BOFFO_PLUGIN_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'boffo';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/boffo-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/boffo-i18n.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/boffo-flow.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/boffo-admin-ajax.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/boffo-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/boffo-public-ajax.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/boffo-public.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'blocks/boffo.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/integrations/boffo-email.php';

		$this->loader = new Boffo_Loader();

	}

	/**
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Boffo_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Boffo_Admin( $this->get_plugin_name(), $this->get_version() );
		$plugin_admin_ajax = new Boffo_Admin_Ajax();

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'add_items_meta_box' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_menu' );
		$this->loader->add_action( 'wp_ajax_get_boffo_admin_forms', $plugin_admin_ajax, 'get_forms');
		$this->loader->add_action( 'wp_ajax_post_boffo_admin_form', $plugin_admin_ajax, 'post_form');
		$this->loader->add_action( 'wp_ajax_delete_boffo_admin_form', $plugin_admin_ajax, 'delete_form');
		$this->loader->add_action( 'manage_boffo_message_posts_columns', $plugin_admin, 'add_flow_custom_column' );
		$this->loader->add_action( 'manage_boffo_message_posts_custom_column' , $plugin_admin, 'add_flow_custom_column_data', 10, 2 );

	}

	/**
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Boffo_Public( $this->get_plugin_name(), $this->get_version() );
		$plugin_public_ajax = new Boffo_Public_Ajax();

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_public, 'register_post_types' );
		$this->loader->add_action( 'wp_ajax_post_boffo_message', $plugin_public_ajax, 'post');
        $this->loader->add_action( 'wp_ajax_nopriv_post_boffo_message', $plugin_public_ajax, 'post');

	}

	/**
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * @since     1.0.0
	 * @return    Boffo_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
