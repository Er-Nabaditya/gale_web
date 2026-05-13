<?php

defined('ABSPATH') || exit;
// require '/wp-content/themes/understrap-child-1.2.0/inc/woocommerce_products.php';

function understrap_remove_scripts()
{
    wp_dequeue_style('understrap-styles');
    wp_deregister_style('understrap-styles');
    wp_dequeue_script('understrap-scripts');
    wp_deregister_script('understrap-scripts');
}
add_action('wp_enqueue_scripts', 'understrap_remove_scripts', 20);

function gale_enqueue_styles()
{
    $ver = wp_get_theme()->get('Version');

    wp_enqueue_style(
        'understrap-parent',
        get_template_directory_uri() . '/css/child-theme.min.css',
        array(),
        $ver
    );
    wp_enqueue_style(
        'gale-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('understrap-parent'),
        $ver
    );
    wp_enqueue_style(
        'gale-header-css',
        get_stylesheet_directory_uri() . '/assets/css/header.css',
        array('gale-style'),
        '1.0.0'
    );
    wp_enqueue_style(
        'gale-home-css',
        get_stylesheet_directory_uri() . '/assets/css/home.css',
        array('gale-style'),
        '1.0.0'
    );
    wp_enqueue_style(
        'gale-product-css',
        get_stylesheet_directory_uri() . '/assets/css/product.css',
        array('gale-style'),
        '1.0.0'
    );
    wp_enqueue_style(
        'gale-footer-css',
        get_stylesheet_directory_uri() . '/assets/css/footer.css',
        array('gale-style'),
        '1.0.0'
    );

    wp_enqueue_style(
        'gale-google-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap',
        array(),
        null
    );

    wp_enqueue_script('jquery');
    wp_enqueue_script(
        'gale-js',
        get_stylesheet_directory_uri() . '/js/gale-custom.js',
        array('jquery'),
        '1.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'gale_enqueue_styles');

function understrap_default_bootstrap_version()
{
    return 'bootstrap5';
}
add_filter('theme_mod_understrap_bootstrap_version', 'understrap_default_bootstrap_version', 20);

function gale_theme_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    register_nav_menus(array(
        'primary' => 'Primary Menu',
        'footer'  => 'Footer Menu',
    ));
}
add_action('after_setup_theme', 'gale_theme_setup');

function add_child_theme_textdomain()
{
    load_child_theme_textdomain(
        'gale-livelihood-child',
        get_stylesheet_directory() . '/languages'
    );
}
add_action('after_setup_theme', 'add_child_theme_textdomain');

add_filter('woocommerce_enqueue_styles', '__return_empty_array');


remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10); // removes "added to cart" notices
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count',       20); // removes "Showing all 4 results"
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering',   30); // removes "Default sorting" dropdown
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
remove_action('woocommerce_shop_loop_header', 'woocommerce_product_taxonomy_archive_header', 10);
