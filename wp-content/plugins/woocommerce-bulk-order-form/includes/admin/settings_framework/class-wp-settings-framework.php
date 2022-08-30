<?php
/**
 * Class for registering settings and sections and for display of the settings form(s).
 * For detailed instructions see: https://github.com/keesiemeijer/WP-Settings
 *
 * @link https://wordpress.org/plugins/woocommerce-role-based-price/
 * @package WooCommerce Role Based Price
 * @subpackage WooCommerce Role Based Price/WordPress/Settings
 * @since 3.0
 * @version 2.0
 * @author keesiemeijer
 */
if ( ! defined( 'WPINC' ) ) {
	die;
}

class WooCommerce_Bulk_Order_Form_Settings_Framework {
	public  $settings;
	private $page_hook = '';
	private $settings_page;
	private $settings_section;
	private $settings_fields;
	private $create_function;
	private $settings_key;
	private $settings_values;

	function __construct( $page_hook = '' ) {
		$this->settings_section = array();
		$this->settings_fields  = array();
		$this->create_function  = array();
		$this->add_settings_pages();
		//$this->get_settings();
		$this->add_settings_section();
		$this->create_callback_function();
		$this->page_hook = $page_hook;

		if ( empty( $page_hook ) ) {
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		}
		add_action( 'admin_init', array( $this, 'admin_init' ) );

		add_action( 'wc_bof_settings_tab_content', array( $this, 'display_settings' ) );
	}

	private function add_settings_pages() {
		$pages               = array();
		$pages               = apply_filters( 'wc_bof_settings_pages', $pages );
		$this->settings_page = $pages;
	}

	private function add_settings_section() {
		$section                = array();
		$section                = apply_filters( 'wc_bof_settings_section', $section );
		$this->settings_section = $section;
	}

	private function create_callback_function() {
		$sec = $this->settings_section;

		foreach ( $sec as $sk => $s ) {
			if ( is_array( $s ) ) {
				$c = count( $s );
				$a = 0;
				while ( $a < $c ) {
					if ( isset( $s[ $a ]['validate_callback'] ) ) {
						$this->create_function[]      = $s[ $a ]['id'];
						$s[ $a ]['validate_callback'] = '';
						$file                         = addslashes( WC_BOF_SETTINGS . 'validate-' . $s[ $a ]['id'] . '.php' );
						$s[ $a ]['validate_callback'] = create_function( '$fields', 'do_action("wc_bof_settings_validate",$fields); do_action("wc_bof_settings_validate_' . $s[ $a ]['id'] . '",$fields);' );
					}
					$a++;
				}
			}

			$this->settings_section[ $sk ] = $s;
		}
	}

	function admin_menu() {
		$this->page_hook = add_submenu_page( 'woocommerce', __( 'Bulk Order Form Settings', 'woocommerce-bulk-order-form' ), __( 'Bulk Order Form Settings', 'woocommerce-bulk-order-form' ), 'manage_woocommerce', WC_BOF_SLUG . '-settings', array(
			$this,
			'admin_page',
		) );
	}

	function admin_init() {
		$this->settings = new WooCommerce_Bulk_Order_Form_WP_Settings();
		$this->add_settings_fields();
		$this->settings->add_pages( $this->settings_page );
		$sections = $this->settings_section;

		foreach ( $sections as $page_id => $section_value ) {
			$pages = $this->settings->add_sections( $page_id, $section_value );
		}

		$fields = $this->settings_field;
		foreach ( $fields as $page_id => $section_fields ) {
			foreach ( $section_fields as $section_id => $sfields ) {
				if ( is_array( $sfields ) ) {
					foreach ( $sfields as $f ) {
						$pages = $this->settings->add_field( $page_id, $section_id, $f );
					}

				} else {
					$pages = $this->settings->add_field( $page_id, $section_id, $sfields );
				}

			}
		}

		$this->settings->init( $pages, WC_BOF_DB );
	}

	private function add_settings_fields() {
		global $fields;
		$fields               = array();
		$fields               = apply_filters( 'wc_bof_settings_fields', $fields );
		$this->settings_field = $fields;
	}

	public function admin_page() {
		$options = get_option( 'wc_bof_products_wc_bof' );
		print_r( $options );
		settings_errors();
		?>
		<div class="wrap">
			<div class="wc_bof_settings">
				<h2><?php _e( 'WooCommerce Bulk Order Form Settings', 'woocommerce-bulk-order-form' ); ?></h2>
				<!-- Main menu -->
				<?php do_action( 'wc_bof_before_settings_tabs', $this->settings->current_page ); ?>
				<?php $this->settings->render_header(); ?>
				<?php do_action( 'wc_bof_after_settings_tabs', $this->settings->current_page ); ?>
				<div class="wc_bof_settings_container">
					<?php do_action( 'wc_bof_before_settings_tab_content', $this->settings->current_page ); ?>
					<?php do_action_deprecated( 'wc_bof_settings_after_header', array( $this->settings->current_page ), '3.4.1', 'wc_bof_before_settings_tab_content' ); ?>
					<?php do_action( 'wc_bof_settings_tab_content', $this->settings->current_page ); ?>
					<?php do_action( 'wc_bof_after_settings_tab_content', $this->settings->current_page ); ?>
				</div>
			</div>
		</div>
		<?php
	}

	function display_settings( $current_page ) {
		?>
		<div class="wpo_wcol_settings_tab">
			<?php $this->settings->render_form(); ?>
		</div>
		<?php
		$this->settings->render_footer();
	}

	function get_option( $id = '' ) {
		if ( ! empty( $this->settings_values ) && ! empty( $id ) ) {
			if ( isset( $this->settings_values[ $id ] ) ) {
				return $this->settings_values[ $id ];
			}
		}
		return false;

	}

	function get_settings( $key = '' ) {
		$values = array();
		foreach ( $this->settings_page as $settings ) {
			$this->settings_key[] = WC_BOF_DB . $settings['slug'];
			$db_val               = get_option( WC_BOF_DB . $settings['slug'] );
			if ( is_array( $db_val ) ) {
				unset( $db_val['section_id'] );
				$values = array_merge( $db_val, $values );
			}
		}

		$this->settings_values = $values;
		return $values;
	}
}