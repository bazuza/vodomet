<?php
if (!function_exists('store_options_init')) {

    function store_options_init()
    {

        if (function_exists('acf_add_options_page')) {

            acf_add_options_page(array(
                'page_title' => __('Store Settings'),
                'menu_title' => __('Store Settings'),
                'menu_slug' => 'store-settings',
                'capability' => 'edit_posts',
                'redirect' => false,
                'icon_url' => 'dashicons-admin-settings',
                'position' => '79.1',
            ));

        }

    }

    add_action('acf/init', 'store_options_init');

}
