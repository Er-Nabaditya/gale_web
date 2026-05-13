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
		get_stylesheet_directory_uri() . '/css/header.css',
		array('gale-style'),
		'1.0.0'
	);
	wp_enqueue_style(
		'gale-home-css',
		get_stylesheet_directory_uri() . '/css/home.css',
		array('gale-style'),
		'1.0.0'
	);
	wp_enqueue_style(
		'gale-product-css',
		get_stylesheet_directory_uri() . '/css/product.css',
		array('gale-style'),
		'1.0.0'
	);
	wp_enqueue_style(
		'gale-footer-css',
		get_stylesheet_directory_uri() . '/css/footer.css',
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


remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 ); // removes "added to cart" notices
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count',       20 ); // removes "Showing all 4 results"
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering',   30 ); // removes "Default sorting" dropdown
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
remove_action( 'woocommerce_shop_loop_header', 'woocommerce_product_taxonomy_archive_header', 10 );


add_action(
    'add_meta_boxes',
    'custom_product_features_metabox'
);

function custom_product_features_metabox() {

    add_meta_box(
        'custom_product_features',
        'Product Features',
        'custom_product_features_callback',
        'product',
        'normal',
        'high'
    );

}


/*
|--------------------------------------------------------------------------
| ENQUEUE MEDIA UPLOADER
|--------------------------------------------------------------------------
*/

add_action(
    'admin_enqueue_scripts',
    'custom_product_features_admin_scripts'
);

function custom_product_features_admin_scripts() {

    wp_enqueue_media();

}


/*
|--------------------------------------------------------------------------
| METABOX HTML
|--------------------------------------------------------------------------
*/

function custom_product_features_callback( $post ) {

    wp_nonce_field(
        'save_custom_product_features',
        'custom_product_features_nonce'
    );

    $features = get_post_meta(
        $post->ID,
        '_product_features',
        true
    );

    if ( empty( $features ) || ! is_array( $features ) ) {
        $features = array();
    }

    ?>

    <div id="features-wrapper">

        <?php foreach ( $features as $index => $feature ) : ?>

            <div class="feature-item">

                <!-- TITLE -->
                <p>

                    <label>
                        Feature Title
                    </label>

                    <input
                        type="text"
                        name="product_features[<?php echo $index; ?>][title]"
                        value="<?php echo esc_attr( $feature['title'] ?? '' ); ?>"
                        placeholder="Feature Title"
                        class="widefat"
                    >

                </p>

                <!-- CONTENT -->
                <p>

                    <label>
                        Feature Content
                    </label>

                    <textarea
                        name="product_features[<?php echo $index; ?>][content]"
                        placeholder="Feature Content"
                        class="widefat"
                        rows="4"
                    ><?php echo esc_textarea( $feature['content'] ?? '' ); ?></textarea>

                </p>

                <!-- IMAGE -->
                <p>

                    <label>
                        Feature Icon
                    </label>

                </p>

                <div class="feature-image-wrap">

                    <input
                        type="hidden"
                        name="product_features[<?php echo $index; ?>][icon]"
                        value="<?php echo esc_attr( $feature['icon'] ?? '' ); ?>"
                        class="feature-image-input"
                    >

                    <div class="feature-image-preview">

                        <?php if ( ! empty( $feature['icon'] ) ) : ?>

                            <img
                                src="<?php echo esc_url( $feature['icon'] ); ?>"
                                style="max-width:80px;"
                            >

                        <?php endif; ?>

                    </div>

                    <button
                        type="button"
                        class="button upload-feature-image"
                    >
                        Upload Image
                    </button>

                </div>

                <!-- REMOVE BUTTON -->
                <p style="margin-top:15px;">

                    <button
                        type="button"
                        class="button remove-feature"
                    >
                        Remove Feature
                    </button>

                </p>

                <hr>

            </div>

        <?php endforeach; ?>

    </div>

    <!-- ADD BUTTON -->
    <button
        type="button"
        class="button button-primary"
        id="add-feature"
    >
        Add Feature
    </button>


    <script>

    jQuery(document).ready(function($){

        let index = <?php echo count( $features ); ?>;


        /*
        |--------------------------------------------------------------------------
        | ADD FEATURE
        |--------------------------------------------------------------------------
        */

        $('#add-feature').on('click', function(){

            let html = `

                <div class="feature-item">

                    <p>

                        <label>
                            Feature Title
                        </label>

                        <input
                            type="text"
                            name="product_features[\${index}][title]"
                            placeholder="Feature Title"
                            class="widefat"
                        >

                    </p>

                    <p>

                        <label>
                            Feature Content
                        </label>

                        <textarea
                            name="product_features[\${index}][content]"
                            placeholder="Feature Content"
                            class="widefat"
                            rows="4"
                        ></textarea>

                    </p>

                    <p>

                        <label>
                            Feature Icon
                        </label>

                    </p>

                    <div class="feature-image-wrap">

                        <input
                            type="hidden"
                            name="product_features[\${index}][icon]"
                            class="feature-image-input"
                        >

                        <div class="feature-image-preview"></div>

                        <button
                            type="button"
                            class="button upload-feature-image"
                        >
                            Upload Image
                        </button>

                    </div>

                    <p style="margin-top:15px;">

                        <button
                            type="button"
                            class="button remove-feature"
                        >
                            Remove Feature
                        </button>

                    </p>

                    <hr>

                </div>

            `;

            $('#features-wrapper').append(html);

            index++;

        });


        /*
        |--------------------------------------------------------------------------
        | REMOVE FEATURE
        |--------------------------------------------------------------------------
        */

        $(document).on('click', '.remove-feature', function(){

            $(this).closest('.feature-item').remove();

        });


        /*
        |--------------------------------------------------------------------------
        | IMAGE UPLOAD
        |--------------------------------------------------------------------------
        */

        $(document).on(
            'click',
            '.upload-feature-image',
            function(e){

                e.preventDefault();

                let button = $(this);

                let uploader = wp.media({

                    title: 'Select Feature Image',

                    button: {
                        text: 'Use Image'
                    },

                    multiple: false

                });

                uploader.on('select', function(){

                    let attachment = uploader
                        .state()
                        .get('selection')
                        .first()
                        .toJSON();

                    button
                        .siblings('.feature-image-input')
                        .val(attachment.url);

                    button
                        .siblings('.feature-image-preview')
                        .html(
                            '<img src="' +
                            attachment.url +
                            '" style="max-width:80px;">'
                        );

                });

                uploader.open();

            }
        );

    });

    </script>


    <style>

    .feature-item {
        background: #f8f8f8;
        border: 1px solid #ddd;
        padding: 20px;
        margin-bottom: 20px;
    }

    .feature-image-preview img {
        display: block;
        margin-bottom: 10px;
        border-radius: 6px;
    }

    </style>

    <?php
}


/*
|--------------------------------------------------------------------------
| SAVE DATA
|--------------------------------------------------------------------------
*/

add_action(
    'save_post_product',
    'save_custom_product_features'
);

function save_custom_product_features( $post_id ) {

    /*
    |--------------------------------------------------------------------------
    | SECURITY CHECK
    |--------------------------------------------------------------------------
    */

    if (
        ! isset( $_POST['custom_product_features_nonce'] )
    ) {
        return;
    }

    if (
        ! wp_verify_nonce(
            $_POST['custom_product_features_nonce'],
            'save_custom_product_features'
        )
    ) {
        return;
    }

    if (
        defined( 'DOING_AUTOSAVE' ) &&
        DOING_AUTOSAVE
    ) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | SAVE FEATURES
    |--------------------------------------------------------------------------
    */

    if ( isset( $_POST['product_features'] ) ) {

        $sanitized_features = array();

        foreach ( $_POST['product_features'] as $feature ) {

            $sanitized_features[] = array(

                'title' => sanitize_text_field(
                    $feature['title']
                ),

                'content' => sanitize_textarea_field(
                    $feature['content']
                ),

                'icon' => esc_url_raw(
                    $feature['icon']
                ),

            );

        }

        update_post_meta(
            $post_id,
            '_product_features',
            $sanitized_features
        );

    } else {

        delete_post_meta(
            $post_id,
            '_product_features'
        );

    }

}