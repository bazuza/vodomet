<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package electro
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php
	wp_body_open();
	?>
<div class="off-canvas-wrapper">
<div id="page" class="hfeed site">
	<?php
	/**
	 * @hooked electro_skip_links - 0
	 * @hooked electro_top_bar - 10
	 */
	$currency_rate = get_field('currency_rate', 'options');
	$currency_symbol = get_field('currency_symbol', 'options');
	$show_currency = get_field('show_currency_in_mini_cart', 'options');
	do_action( 'electro_before_header' ); ?>

	<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) : ?>

	<header <?php if( in_array('Yes', $show_currency)){echo 'data-currency-show';}  ?> data-symbol="<?php echo $currency_symbol ?>" data-rate="<?php echo $currency_rate ?>" id="masthead" class="site-header header-v3 stick-this">
		<div class="container <?php echo esc_attr( has_electro_mobile_header() ? electro_desktop_header_responsive_class() : '' );  ?>">
			<?php
			/**
			 * @hooked electro_row_wrap_start - 0
			 * @hooked electro_header_logo - 10
			 * @hooked electro_primary_menu - 20
			 * @hooked electro_header_support_info - 30
			 * @hooked electro_row_wrap_end - 40
			 */
			do_action( 'electro_header_v3' ); ?>

		</div>

		<?php
		/**
		 * @hooked electro_handheld_header - 10
		 */
		do_action( 'electro_after_header' ); ?>

	</header><!-- #masthead -->

	<?php endif; ?>

	<?php
	/**
	 * @hooked electro_navbar - 10
	 */
	do_action( 'electro_before_content' ); ?>

	<div id="content" class="site-content" tabindex="-1">
		<div class="container">
		<?php
		/**
		 * @hooked woocommerce_breadcrumb - 10
		 */
		do_action( 'electro_content_top' ); ?>
