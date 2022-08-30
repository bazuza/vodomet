<?php
/**
 * Plugin's Admin code
 *
 * @link https://wordpress.org/plugins/woocommerce-bulk-order-form/
 * @package WooCommerce Bulk Order Form
 * @subpackage WooCommerce Bulk Order Form/Admin
 * @since 3.0
 */
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class WooCommerce_Bulk_Order_Form_Admin
 *
 * @author Varun Sridharan <varunsridharan23@gmail.com>
 * @since 1.0
 */
class WooCommerce_Bulk_Order_Form_Admin {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since      0.1
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ), 99 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		//add_action( 'admin_init', array( $this, 'admin_init' ));
		add_filter( 'plugin_row_meta', array( $this, 'plugin_row_links' ), 10, 2 );
		add_filter( 'plugin_action_links_' . WC_BOF_FILE, array( $this, 'plugin_action_links' ), 10, 10 );
		add_filter( 'woocommerce_screen_ids', array( $this, 'set_wc_screen_ids' ), 99 );
	}

	/**
	 * Inits Admin Sttings
	 */
	public function admin_init() {
	}

	/**
	 * @param $screens
	 *
	 * @return array
	 */
	public function set_wc_screen_ids( $screens ) {
		$screen   = $screens;
		$screen[] = 'woocommerce_page_woocommerce-bulk-order-form-settings';
		return $screen;
	}

	/**
	 * Register the stylesheets for the admin area.
	 */
	public function enqueue_styles() {
		wp_register_style( WC_BOF_SLUG . '_backend_style', WC_BOF_CSS . 'backend.css', array(), WC_BOF_V );
		wp_enqueue_style( WC_BOF_SLUG . '_backend_style' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 */
	public function enqueue_scripts() {
		wp_register_script( WC_BOF_SLUG . '_backend_script', WC_BOF_JS . 'backend.js', array( 'jquery' ), WC_BOF_V, false );
		wp_enqueue_script( WC_BOF_SLUG . '_backend_script' );

		wp_localize_script(
			WC_BOF_SLUG . '_backend_script',
			'wc_bof_admin',
			array(
				/* translators: <a> tags */
				'pro_feature' => sprintf(
					__( 'This feature is only available in %1$sWooCommerce Bulk Order Form Pro%2$s', 'woocommerce-bulk-order-form' ),
					'<a href="https://wpovernight.com/downloads/woocommerce-bulk-order-form">',
					'</a>'
				),
			)
		);
	}

	/**
	 * Adds Some Plugin Options
	 *
	 * @param  array  $plugin_meta
	 * @param  string $plugin_file
	 *
	 * @since 0.11
	 * @return array
	 */
	public function plugin_action_links( $action, $file, $plugin_meta, $status ) {
		$settings_url = admin_url( 'admin.php?page=' . WC_BOF_SLUG . '-settings' );
		$actions[]    = sprintf( '<a href="%s">%s</a>', $settings_url, __( 'Settings', 'woocommerce-bulk-order-form' ) );
		$action       = array_merge( $actions, $action );
		return $action;
	}

	/**
	 * Adds Some Plugin Options
	 *
	 * @param  array  $plugin_meta
	 * @param  string $plugin_file
	 *
	 * @since 0.11
	 * @return array
	 */
	public function plugin_row_links( $plugin_meta, $plugin_file ) {
		if ( WC_BOF_FILE == $plugin_file ) {
			$plugin_meta[] = sprintf( '<a href="%s">%s</a>', 'https://docs.wpovernight.com/category/bulk-order-form/', __( 'FAQ', 'woocommerce-bulk-order-form' ) );
			$plugin_meta[] = sprintf( '<a href="%s">%s</a>', 'https://wpovernight.com/contact/', __( 'Support', 'woocommerce-bulk-order-form' ) );
		}
		return $plugin_meta;
	}
}
