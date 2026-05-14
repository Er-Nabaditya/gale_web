<?php


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
        get_stylesheet_directory_uri() . '/assets/js/gale-custom.js',
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

function custom_cart_styles() {

    if ( is_cart() ) {

        wp_enqueue_style(
            'custom-cart',
            get_template_directory_uri() . '/assets/css/cart.css',
            array(),
            '1.0'
        );

    }

}

add_action(
    'wp_enqueue_scripts',
    'custom_cart_styles'
);

add_action(
    'add_meta_boxes',
    'custom_product_features_metabox'
);

function custom_product_features_metabox()
{

    add_meta_box(
        'custom_product_features',
        'Product Features',
        'custom_product_features_callback',
        'product',
        'normal',
        'high'
    );
}
add_action(
    'post_edit_form_tag',
    'custom_product_features_form_tag'
);

function custom_product_features_form_tag()
{

    echo ' enctype="multipart/form-data"';
}

function custom_product_features_callback($post)
{

    wp_nonce_field(
        'save_custom_product_features',
        'custom_product_features_nonce'
    );

    $features = get_post_meta(
        $post->ID,
        '_product_features',
        true
    );

    if (
        empty($features) ||
        ! is_array($features)
    ) {
        $features = array();
    }

?>

    <div id="features-wrapper">

        <?php foreach ($features as $index => $feature) : ?>

            <div class="feature-item">

                <!-- TITLE -->
                <p>

                    <label>
                        Feature Title
                    </label>

                    <input
                        type="text"
                        name="product_features[<?php echo $index; ?>][title]"
                        value="<?php echo esc_attr($feature['title'] ?? ''); ?>"
                        placeholder="Feature Title"
                        class="widefat">

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
                        rows="4"><?php echo esc_textarea($feature['content'] ?? ''); ?></textarea>

                </p>


                <!-- OLD IMAGE -->
                <input
                    type="hidden"
                    name="product_features[<?php echo $index; ?>][old_icon]"
                    value="<?php echo esc_url($feature['icon'] ?? ''); ?>">


                <!-- IMAGE UPLOAD -->
                <p>

                    <label>
                        Feature Image
                    </label>

                    <input
                        type="file"
                        name="product_feature_icon_<?php echo $index; ?>"
                        class="widefat">

                </p>

                <button
                    type="button"
                    class="button remove-feature">
                    Remove
                </button>

                <hr>

            </div>

        <?php endforeach; ?>

    </div>

    <button
        type="button"
        class="button button-primary"
        id="add-feature">
        Add Feature
    </button>


    <script>
        jQuery(document).ready(function($) {

            let index = <?php echo count($features); ?>;

            $('#add-feature').on('click', function() {

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

                    <input
                        type="hidden"
                        name="product_features[\${index}][old_icon]"
                        value=""
                    >

                    <p>

                        <label>
                            Feature Image
                        </label>

                        <input
                            type="file"
                            name="product_feature_icon_\${index}"
                            class="widefat"
                        >

                    </p>

                    <button
                        type="button"
                        class="button remove-feature"
                    >
                        Remove
                    </button>

                    <hr>

                </div>

            `;

                $('#features-wrapper').append(html);

                index++;

            });

            $(document).on(
                'click',
                '.remove-feature',
                function() {

                    $(this)
                        .closest('.feature-item')
                        .remove();

                }
            );

        });
    </script>


    <style>
        .feature-item {
            background: #f8f8f8;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .feature-item input,
        .feature-item textarea {
            margin-top: 8px;
        }
    </style>

<?php
}

add_action(
    'save_post_product',
    'save_custom_product_features'
);

function save_custom_product_features($post_id)
{

    if (
        ! isset($_POST['custom_product_features_nonce'])
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
        defined('DOING_AUTOSAVE') &&
        DOING_AUTOSAVE
    ) {
        return;
    }


    if (isset($_POST['product_features'])) {

        $saved_features = array();

        foreach ($_POST['product_features'] as $index => $feature) {

            $image_url = '';

            /*
            |--------------------------------------------------------------------------
            | FILE UPLOAD
            |--------------------------------------------------------------------------
            */

            if (
                isset(
                    $_FILES['product_feature_icon_' . $index]
                ) &&
                ! empty($_FILES['product_feature_icon_' . $index]['name'])
            ) {

                require_once ABSPATH .
                    'wp-admin/includes/file.php';

                $uploadedfile =
                    $_FILES['product_feature_icon_' . $index];

                $upload_overrides = array(
                    'test_form' => false,
                );

                $movefile = wp_handle_upload(
                    $uploadedfile,
                    $upload_overrides
                );

                if (
                    $movefile &&
                    ! isset($movefile['error'])
                ) {

                    $image_url = $movefile['url'];
                }
            } else {

                /*
                |--------------------------------------------------------------------------
                | KEEP OLD IMAGE
                |--------------------------------------------------------------------------
                */

                $image_url =
                    $feature['old_icon'] ?? '';
            }


            /*
            |--------------------------------------------------------------------------
            | SAVE FEATURE
            |--------------------------------------------------------------------------
            */

            $saved_features[] = array(

                'title' => sanitize_text_field(
                    $feature['title']
                ),

                'content' => sanitize_textarea_field(
                    $feature['content']
                ),

                'icon' => esc_url_raw(
                    $image_url
                ),

            );
        }


        update_post_meta(
            $post_id,
            '_product_features',
            $saved_features
        );
    }
}
