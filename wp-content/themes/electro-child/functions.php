<?php
/**
 * Electro Child
 *
 * @package electro-child
 */

/**
 * Include all your custom code here
 */


function child_theme_enqueue_styles() {
    $parent_style = 'electro-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css', array( $parent_style ), wp_get_theme()->get('Version')
    );
    wp_enqueue_script('custom', get_stylesheet_directory_uri().'/script.js');
}
add_action( 'wp_enqueue_scripts', 'child_theme_enqueue_styles', 1000);


add_filter('gettext', 'translate_text');
add_filter('ngettext', 'translate_text');

function translate_text($translated) {
    $translated = str_ireplace('Onsale Products', 'Товары со скидкой', $translated);
    $translated = str_ireplace('Top Rated Products', 'Рейтинговые товары', $translated);
    $translated = str_ireplace('View cart', 'Просмотр корзины', $translated);
    $translated = str_ireplace('SHOPPING CART', 'Корзина покупок', $translated);
    $translated = str_ireplace('Cart', 'Корзина', $translated);
    $translated = str_ireplace('Checkout', 'Оформление заказа', $translated);
    $translated = str_ireplace('Product name', 'Название товара', $translated);
    $translated = str_ireplace('No products added to the wishlist', 'Вы еще не добавляли сюда товары', $translated);
    $translated = str_ireplace('Be the first to review &ldquo;%s&rdquo;', 'Будьте первым, кто оставил отзыв на &ldquo;%s&rdquo;', $translated);
    $translated = str_ireplace('Your Rating', 'Ваша оценка', $translated);
    $translated = str_ireplace('Your Review', 'Ваш отзыв', $translated);
    $translated = str_ireplace('Add Review', 'Добавить отзыв', $translated);
    $translated = str_ireplace('Compare', 'Сравнение', $translated);
    $translated = str_ireplace('Wishlist', 'Понравилось', $translated);
    $translated = str_ireplace('Your order', 'Ваш заказ', $translated);
    $translated = str_ireplace('%s Categories', 'Категории', $translated);
    $translated = str_ireplace('My Account', 'Кабинет', $translated);
    $translated = str_ireplace('Quantity', 'Количество', $translated);
    $translated = str_ireplace('Based on %s reviews', 'Основано на %s отзывах', $translated);
    $translated = str_ireplace('Based on %s review', 'Основано на %s отзыве', $translated);
    $translated = str_ireplace('There are no reviews yet.', 'У этого товара еще нет отзывов.', $translated);
    $translated = str_ireplace('%s overall', '%s всего', $translated);
    $translated = str_ireplace('Reviews', 'Отзывы', $translated);
    $translated = str_ireplace('Show All Categories', 'Показать все категории', $translated);
    $translated = str_ireplace('Best Sellers', 'Лидеры продаж', $translated);
    $translated = str_ireplace('Browse Categories', 'Обзор категорий', $translated);
    return $translated;
}
function wc_remove_checkout_fields( $fields ) {

    // Billing fields
    unset( $fields['billing']['billing_country'] );
    unset( $fields['billing']['billing_company'] );
    unset( $fields['billing']['billing_state'] );
    unset( $fields['billing']['billing_last_name'] );
    unset( $fields['billing']['billing_address_2'] );
    unset( $fields['billing']['billing_postcode'] );

    // Shipping fields
    unset( $fields['shipping']['shipping_country'] );
    unset( $fields['shipping']['shipping_company'] );
    unset( $fields['shipping']['shipping_last_name'] );
    unset( $fields['shipping']['shipping_address_2'] );
    unset( $fields['shipping']['shipping_postcode'] );

    return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'wc_remove_checkout_fields' );

add_filter( 'awooc_order_address_arg', 'awooc_added_addres_field', 10, 1 );
function awooc_added_addres_field( $addres ) {

    $addres['city'] = $_POST['awooc-city'] ? sanitize_text_field( $_POST['awooc-city'] ) : '';
    $addres['address_1'] = $_POST['awooc-delivery'] ? sanitize_text_field( $_POST['awooc-delivery'] ) : '';
    $addres['address_2'] = $_POST['awooc-number'] ? sanitize_text_field( $_POST['awooc-number'] ) : '';

    return $addres;
}

include_once 'inc/acf-options.php';
include_once 'inc/currency-additional.php';


