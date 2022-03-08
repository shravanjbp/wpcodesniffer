<?php
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if (!function_exists('chld_thm_cfg_locale_css')) :

    function chld_thm_cfg_locale_css($uri)
    {
        if (empty($uri) && is_rtl() && file_exists(get_template_directory() . '/rtl.css'))
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }

endif;
add_filter('locale_stylesheet_uri', 'chld_thm_cfg_locale_css');

// if ( !function_exists( 'child_theme_configurator_css' ) ):
//     function child_theme_configurator_css() {
//         wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'yogasana-basic-style','yogasana-editor-style','yogasana-base-style','yogasana-nivo-style','yogasana-font-awesome-style','yogasana-testimonialslider-style','yogasana-responsive-style','yogasana-owl-style','yogasana-mixitup-style','yogasana-fancybox-style','yogasana-wow-style','yogasana-flexiselcss' ) );
//     }
// endif;
// add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );
// END ENQUEUE PARENT ACTION

/**
 * Proper way to enqueue scripts and styles.
 */
function yogasana_script()
{
    wp_deregister_script('yogasana-customscripts');
    wp_dequeue_script('yogasana-customscripts');
    wp_deregister_script('yogasana-owljs');
    wp_dequeue_script('yogasana-owljs');
    wp_enqueue_script('yogasana-custom-js', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery'));
    wp_enqueue_script('custom-js', get_stylesheet_directory_uri() . '/custom/js/custom.js', array(), '1.0.0', true);
}

add_action('wp_enqueue_scripts', 'yogasana_script', 100);

/**
 * extra-functions file    
 */
if (file_exists(get_stylesheet_directory() . '/extra-functions.php')) {
    require_once(get_stylesheet_directory() . '/extra-functions.php');
}

