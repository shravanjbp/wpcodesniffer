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

/* Shortcode for upcoming and past retreats */

function retreats_func($type)
{
    extract(shortcode_atts(
        array(
            'type' => ''
        ),
        $type
    ));

    if ($type == 'upcoming') {
        $args = array(
            'post_type' => 'retreats',
            'post_status' => 'publish',
            'orderby' => 'meta_value',
            'order' => 'ASC',
            'posts_per_page' => 1,
            'meta_key' => 'retreats_time',
            'meta_value' => date('Y-m-d H:i:s'),
            'meta_compare' => '>',
        );
    } elseif ($type == 'older') {
        $args = array(
            'post_type' => 'retreats',
            'post_status' => 'publish',
            'orderby' => 'meta_value',
            'order' => 'DESC',
            'posts_per_page' => 6,
            'meta_key' => 'retreats_time',
            'meta_value' => date('Y-m-d H:i:s'),
            'meta_compare' => '<',
        );
    } else {
        $args = array(
            'post_type' => 'retreats',
            'post_status' => 'publish',
            'posts_per_page' => -1,
        );
    }

    $loop = new WP_Query($args);

    if ($loop->have_posts()) {

        // Open div wrapper around loop
        $output .= '<div>';

        // Loop through posts
        while ($loop->have_posts()) {

            // Sets up post data so you can use functions like get_the_title(), get_permalink(), etc
            $loop->the_post();

            $output .= '<section class="elementor-element elementor-element-c2951ca elementor-section-full_width elementor-section-height-default elementor-section-height-default elementor-section elementor-inner-section retreat-calendar">';
            $output .= '<div class="elementor-container elementor-column-gap-default">';
            $output .= '<div class="elementor-row">
				<div class="elementor-element elementor-element-2b761db elementor-column elementor-col-100 elementor-inner-column" data-id="2b761db" data-element_type="column">';
            $output .= '<div class="elementor-column-wrap  elementor-element-populated">
					<div class="elementor-widget-wrap">';
            $output .= '<div class="elementor-element elementor-element-6a7b766 elementor-widget elementor-widget-image" data-id="6a7b766" data-element_type="widget" data-widget_type="image.default">
				<div class="elementor-widget-container">
					<div class="elementor-image">';
            if (has_post_thumbnail($loop->ID)) {
                $output .= get_the_post_thumbnail($loop->ID, 'full', array('class' => 'img-thumbnail'));
            }
            $output .= '</div>
							</div>
				</div>';
            $output .= '<div class="elementor-element elementor-element-47ba016 elementor-widget elementor-widget-heading" data-id="47ba016" data-element_type="widget" data-widget_type="heading.default">
				<div class="elementor-widget-container">
			<h4 class="elementor-heading-title elementor-size-default">' . get_the_title() . ' </h4>';
            $output .= '<p>';
            if (!empty(get_field('retreats_time', $loop->ID))) {
                $output .= '<strong>Date : </strong>' . get_field('retreat_date', $loop->ID) . ' </p>';
            }
            $output .= '<p>';
            if (!empty(get_field('retreats_address', $loop->ID))) {
                $output .= '<strong>Place : </strong>' . get_field('retreats_address', $loop->ID);
            }
            $output .= '</p></div>
				</div>';
            $output .= '<div class="elementor-element elementor-element-ba3f7a7 elementor-widget elementor-widget-text-editor" data-id="ba3f7a7" data-element_type="widget" data-widget_type="text-editor.default">
				<div class="elementor-widget-container">';
            $output .= '<div class="elementor-text-editor elementor-clearfix">';
            if (!empty(get_field('retreats_address', $loop->ID))) {
                $output .= '<p>' . get_field('retreats_short_description', $loop->ID) . '</p>';
            }

            $output .= '</div>';
            $output .= '</div>
				</div>
				<div class="elementor-element elementor-element-e90903d elementor-widget elementor-widget-button retreat_btn" data-id="e90903d" data-element_type="widget" data-widget_type="button.default">
				<div class="elementor-widget-container">
					<div class="elementor-button-wrapper">
			<a href="' . get_the_permalink($loop->ID) . '" class="black-btn elementor-button-link elementor-button elementor-size-sm" role="button">
						<span class="elementor-button-content-wrapper">
						<span class="elementor-button-text">Read More</span>';
            $output .= '</span>
					</a>
		</div>
				</div>
				</div>
						</div>
			</div>
		</div>
						</div>
			</div>
		</section>';
        }

        // Close div wrapper around loop
        $output .= '</div>';

        // Restore data
        wp_reset_postdata();
    } else {
        $output .= '<div class="notevent"> Not Found </div>';
    }

    // Return your shortcode output
    return $output;
}

add_shortcode('retreats', 'retreats_func');

/* Shortcode for upcoming and past retreats */

function retreats_details_func($type)
{

    global $post;

    // Run code only for Single post page
    if (is_single() && 'retreats' == get_post_type()) {

        $output .= '<section class="elementor-element elementor-element-c2951ca elementor-section-full_width elementor-section-height-default elementor-section-height-default elementor-section elementor-inner-section retreat-calendar">';
        $output .= '<div class="elementor-container elementor-column-gap-default">';
        $output .= '<div class="elementor-row">
		<div class="elementor-element elementor-element-2b761db elementor-column elementor-col-100 elementor-inner-column" data-id="2b761db" data-element_type="column">';
        $output .= '<div class="elementor-column-wrap  elementor-element-populated">
			<div class="elementor-widget-wrap">';
        $output .= '<div class="elementor-element elementor-element-6a7b766 elementor-widget elementor-widget-image" data-id="6a7b766" data-element_type="widget" data-widget_type="image.default">
		<div class="elementor-widget-container">
			<div class="elementor-image">';
        if (has_post_thumbnail($post->ID)) {
            $output .= get_the_post_thumbnail($post->ID, 'full');
        }
        $output .= '</div>
					</div>
		</div>';
        $output .= '<div class="elementor-element elementor-element-47ba016 elementor-widget elementor-widget-heading" data-id="47ba016" data-element_type="widget" data-widget_type="heading.default">
		<div class="elementor-widget-container">';
        $output .= '<p>';
        if (!empty(get_field('retreats_time', $post->ID))) {
            $output .= '<strong>Date : </strong>' . get_field('retreat_date', $post->ID) . ' </p>';
        }
        $output .= '<p>';
        if (!empty(get_field('retreats_address', $post->ID))) {
            $output .= '<strong>Place : </strong>' . get_field('retreats_address', $post->ID);
        }
        $output .= '</p></div>
		</div>';
        $output .= '<div class="elementor-element elementor-element-ba3f7a7 elementor-widget elementor-widget-text-editor" data-id="ba3f7a7" data-element_type="widget" data-widget_type="text-editor.default">
		<div class="elementor-widget-container">';
        $output .= '<div class="elementor-text-editor elementor-clearfix">';
        if (!empty(get_field('retreats_address', $post->ID))) {
            $output .= '<p>' . get_field('retreats_short_description', $post->ID) . '</p>';
        }

        $output .= '</div>';
        $output .= '</div>
		</div>
				</div>
	</div>
</div>
				</div>
	</div>
</section>';
    }
    // Return your shortcode output
    return $output;
}

add_shortcode('retreats_details', 'retreats_details_func');

/* Filter for add form in event details page */

function add_content_on_single_post($content)
{
    if (is_single() && 'ai1ec_event' == get_post_type()) {
        $content .= '<div class="ctaevent">[contact-form-7 id="6051" title="Event Details page"]</div>';
    }
    return $content;
}

add_filter('the_content', 'add_content_on_single_post');

// function be_arrows_in_menus( $item_output, $item, $depth, $args ) {
// if ( has_nav_menu( 'primary' ) &&  wp_is_mobile()) {
// 	echo 'asdad';
// 	if( in_array( 'menu-item-has-children', $item->classes ) ) {
// 		$arrow = 0 == $depth ? '<span><i aria-hidden="true" class="fas fa-angle-down"></i></span>' : '<i aria-hidden="true" class="fas fa-angle-right"></i>';
// 		$item_output = str_replace( '</a>','</a>'. $arrow, $item_output );
// 	}
// }
// 	return $item_output;
// }
// add_filter( 'walker_nav_menu_start_el', 'be_arrows_in_menus', 10, 4 );
// function defer_parsing_of_js ( $url ) {
// if ( FALSE === strpos( $url, '.js' ) ) return $url;
// if ( strpos( $url, 'jquery.js' ) ) return $url;
// return "$url' defer ";
// }
// add_filter( 'clean_url', 'defer_parsing_of_js', 11, 1 );
// function defer_parsing_of_js($url)
// {
// //Specify which files to EXCLUDE from defer method. Always add jquery.js
//     $files = array('jquery.js');
// //let's not break back-end
//     if (!is_admin()) {
//         if (false === strpos($url, '.js')) {
//             return $url;
//         }
//         foreach ($files as $file) {
//             if (strpos($url, $file)) {
//                 return $url;
//             }
//         }
//     } else {
//         return $url;
//     }
//     return "$url' async='async";
// }
// add_filter('clean_url', 'defer_parsing_of_js', 11, 1);

if (!function_exists('wppopups_handle_jquery')) {

    function wppopups_handle_jquery()
    {
        return 'jquery-ext';
    }

    add_filter('wppopups_handle_jquery', 'wppopups_handle_jquery');
}

// /* Filter for add  rewrite rules for change url of perls of wisdom post type */
// add_filter('generate_rewrite_rules', 'resources_cpt_generating_rule');
// function resources_cpt_generating_rule($wp_rewrite) {
//     $rules = array();
//     $terms = get_terms( array(
//         'taxonomy' => 'pearls_of_wisdom_category',
//         'hide_empty' => false,
//     ) );
//     $post_type = 'pearls_of_wisdom';
//     foreach ($terms as $term) {    
//         $rules['pearls_of_wisdom/' . $term->slug . '/([^/]*)$'] = 'index.php?post_type=' . $post_type. '&pearls_of_wisdom=$matches[1]&name=$matches[1]';
//     }
//     // merge with global rules
//     $wp_rewrite->rules = $rules + $wp_rewrite->rules;
// }
//  Filter for change permalink of perls of wisdom post type 
// add_filter('post_type_link', 'pow_type_permalink', 10, 4);
// function pow_type_permalink($post_link, $post, $leavename, $sample) {
//     //If is custom post type "product"
//     if (get_post_type() == 'pearls_of_wisdom') {
//         // Get current post object
//         // Get current value from custom taxonomy "product-type"
//         $terms = get_the_terms($post->id, 'pearls_of_wisdom_category');
//         // Define category from "slug" of taxonomy object
//         $term = $terms[0]->slug;
//         // Re-structure permalink with string replace to include taxonomy value and post name
//         if(isset($term) && !empty($term)) {
//         $permalink = str_replace('pearls_of_wisdom/', 'pearls_of_wisdom/' . $term . '/', $post_link);
//         }
//     }
//     return $permalink;
// }


function my_exclude_ipad_and_tablets($is_mobile)
{

    if (is_front_page() || is_home()) {

        if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') || false !== strpos($_SERVER['HTTP_USER_AGENT'], 'tablet')) {
            return false;
        }
        return $is_mobile;
    }
}

add_filter('wp_is_mobile', 'my_exclude_ipad_and_tablets');

/*
 * Add Email Header
 */

add_action('woocommerce_email_header', 'email_header_before', 1, 2);

function email_header_before($email_heading, $email)
{
    $GLOBALS['wc_email'] = $email;
}

/*
 *  ADD Checkout PAN Card Number
 */

function PanCheckoutField($checkout)
{

    foreach (WC()->cart->get_cart() as $item) {
        // Get the product ID
        $proid = $item['product_id'];
    }
    if (isset($proid) && $proid == '13627') {

        $cart_amount = WC()->cart->total;

        $current_user = wp_get_current_user();
        $saved_license_no = $current_user->license_no;

        if ($cart_amount >= 10000) {
            woocommerce_form_field('pan_no', array(
                'type' => 'text',
                'class' => array('form-row-wide'),
                'label' => 'PAN Number',
                'placeholder' => 'PAN Number',
                'required' => true,
            ), $checkout->get_value('pan_no'));
        } else {
            woocommerce_form_field('pan_no', array(
                'type' => 'text',
                'class' => array('form-row-wide'),
                'label' => 'PAN Number',
                'placeholder' => 'PAN Number',
            ), $checkout->get_value('pan_no'));
        }
    }
}

add_action('woocommerce_after_checkout_billing_form', 'PanCheckoutField');

function PanValidateCheckoutField()
{
    $oproduct_ids = array(); // product id array
    // Loop through order items
    foreach (WC()->cart->get_cart() as $item) {
        // Get the product ID
        $proid = $item['product_id'];
    }
    if (isset($proid) && $proid == '13627') {
        $cart_amount = WC()->cart->total;
        if (!$_POST['pan_no'] && $cart_amount >= 10000) {
            wc_add_notice('Please enter your PAN Number', 'error');
        }
    }
}

add_action('woocommerce_checkout_process', 'PanValidateCheckoutField');

function PanSaveCheckoutFieldMeta($order_id)
{
    if ($_POST['pan_no']) {
        update_post_meta($order_id, '_pan_no', esc_attr($_POST['pan_no']));
    }
}

add_action('woocommerce_checkout_update_order_meta', 'PanSaveCheckoutFieldMeta');

function PanShowGSTField($order)
{
    $order_id = $order->get_id();
    if (get_post_meta($order_id, '_pan_no', true)) {
        echo '<p><strong>PAN Number:</strong> ' . get_post_meta($order_id, '_pan_no', true) . '</p>';
    }
}

add_action('woocommerce_admin_order_data_after_billing_address', 'PanShowGSTField', 99, 1);

function PanSaveCheckoutFieldMetaOnEmail($order, $sent_to_admin, $plain_text, $email)
{
    if (get_post_meta($order->get_id(), '_pan_no', true)) {
        echo '<p><strong>PAN Number:</strong> ' . get_post_meta($order->get_id(), '_pan_no', true) . '</p>';
    }
}

add_action('woocommerce_email_after_order_table', 'PanSaveCheckoutFieldMetaOnEmail', 99, 4);

/*
  Change Place Order button text on checkout page in woocommerce
 */
/*
  add_filter('woocommerce_order_button_text', 'ypv_custom_order_button_text', 1);

  function ypv_custom_order_button_text($order_button_text) {

  $order_button_text = 'Make Payment';

  return $order_button_text;
  }
 * 
 */

/*
 * Change Woocommerce email subject admin new order
 */

add_filter('woocommerce_email_subject_new_order', 'ypv_custom_admin_email_subject', 1, 2);

function ypv_custom_admin_email_subject($subject, $order)
{

    // Loop through order items
    if (!empty($order->get_items())) {
        foreach ($order->get_items() as $item_id => $item) {
            // Get the product ID
            $proid = $item->get_product_id();
        }
    }

    if (isset($proid) && $proid == '13627') {
        $subject = 'New Donation';
    }
    /*    else
      {
      $subject = 'New Registration';
      } */
    return $subject;
}

/*
 * Change Woocommerce email subject customer completed order 
 */

add_filter('woocommerce_email_subject_customer_completed_order', 'ypv_email_subject_customer_completed_order', 1, 2);

function ypv_email_subject_customer_completed_order($subject, $order)
{

    // Loop through order items
    if (!empty($order->get_items())) {
        foreach ($order->get_items() as $item_id => $item) {
            // Get the product ID
            $proid = $item->get_product_id();
        }
    }

    if (isset($proid) && $proid == '13627') {
        $subject = 'Your Donation Complete';
    } elseif(isset($proid) && has_term( array('material-request'), 'product_cat', $proid )) {
        $subject = 'Your Order has been Completed';
    } else {
        $subject = 'Your Registration Complete';
    }
    return $subject;
}

/*
 * Add filter to change invoice file name to receipt
 */

function wpo_wcpdf_custom_filename($filename, $template_type, $order_ids, $context)
{

    $current_year = substr(date("Y"), -2);
    $next_year = substr(date('Y', strtotime('+1 year')), -2);
    $session_year = $current_year . "-" . $next_year;

    $update_new_filename = "receipt-SRT-" . $session_year . "-E000" . $filename;

    $update_new_filename = str_replace("invoice-", "", $update_new_filename);

    return $update_new_filename;
}

add_filter('wpo_wcpdf_filename', 'wpo_wcpdf_custom_filename', 10, 4);

/*
 *  Overwrite donation plugin placeholder  
 */
add_filter('wc_donation_other_amount_placeholder', 'ypv_update_amount_placeholder_text');

function ypv_update_amount_placeholder_text($msg)
{
    $msg = 'Please enter donation amount';
    return $msg;
}

/* Override theme default specification for product # per row 
 * 
 */

function ypv_loop_columns()
{
    return 4; // 4 products per row
}

add_filter('loop_shop_columns', 'ypv_loop_columns', 999);

/**
 *
 * Code used to change the price order in WooCommerce
 *
 * */
function ypv_woocommerce_price_html($price, $product)
{
    return preg_replace('@(<del>.*?</del>).*?(<ins>.*?</ins>)@misx', '$2 $1', $price);
}

add_filter('woocommerce_get_price_html', 'ypv_woocommerce_price_html', 100, 2);

/*
 * Woocommerce Add custom registration fields  
 */

function ypv_wooc_extra_register_fields()
{

    global $woocommerce;
    $countries_obj = new WC_Countries();
    $countries = $countries_obj->__get('countries');
    $default_country = $countries_obj->get_base_country();
    $default_county_states = $countries_obj->get_states($default_country);
?>

    <p class="form-row form-row-first regs_ypv_repeat_pass">
        <label for="reg_password2"><?php _e('Confirm Password', 'woocommerce'); ?> <span class="required">*</span></label>
        <input type="password" class="input-text" name="password2" id="reg_password2" value="<?php if (!empty($_POST['password2'])) echo esc_attr($_POST['password2']); ?>" />
    </p>
    <div class="clear"></div>
    <p class="form-row form-row-first regs_ypv_fname">
        <label for="reg_billing_first_name"><?php _e('First Name', 'woocommerce'); ?><span class="required">*</span></label>
        <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if (!empty($_POST['billing_first_name'])) esc_attr_e($_POST['billing_first_name']); ?>" />
    </p>

    <p class="form-row form-row-last regs_ypv_lname">
        <label for="reg_billing_last_name"><?php _e('Last Name', 'woocommerce'); ?><span class="required">*</span></label>
        <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if (!empty($_POST['billing_last_name'])) esc_attr_e($_POST['billing_last_name']); ?>" />
    </p>

    <p class="form-row form-row-wide regs_ypv_phone">
        <label for="reg_billing_phone"><?php _e('Phone Number', 'woocommerce'); ?><span class="required">*</span></label>
        <input type="number" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php esc_attr_e($_POST['billing_phone']); ?>" />
    </p>

    <p class="form-row form-row-wide regs_ypv_whatssapp">
        <label for="reg_whats_app_phone"><?php _e('Whats App Number', 'woocommerce'); ?></label>
        <input type="number" class="input-text" name="whats_app_phone" id="whats_app_phone" value="<?php esc_attr_e($_POST['whats_app_phone']); ?>" />
    </p>

    <div class="clear"></div>

    <p class="form-row form-row-wide regs_ypv_select">
        <label for=""><?php _e('I AM', 'woocommerce'); ?> <span class="required">*</span></label>
        <select name="ypv_iam" id="ypv_iam" />
        <option value=""> Select an option </option>
        <option value="ypv_healer" <?php if ($_POST['ypv_iam'] == "ypv_healer") echo 'selected="selected" '; ?>>YPV Healer</option>
        <option value="arhat_yogi" <?php if ($_POST['ypv_iam'] == "arhat_yogi") echo 'selected="selected" '; ?>>Arhat Yogi</option>
        <option value="not_ypv_healer" <?php if ($_POST['ypv_iam'] == "not_ypv_healer") echo 'selected="selected" '; ?>>Not a Healer Yet</option>
        </select>
    </p>

    <p class="form-row form-row-wide ypv_trainer_name" <?php if (isset($_POST['ypv_iam']) && $_POST['ypv_iam'] == "ypv_healer") { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?>>
        <label for="reg_address"><?php _e('Trainer Name', 'woocommerce'); ?><span class="required">*</span></label>
        <input type="text" class="input-text" name="ypv_trainer_name" id="ypv_trainer_name" value="<?php esc_attr_e($_POST['ypv_trainer_name']); ?>" />
    </p>

    <p class="form-row form-row-wide arhat_trainer_name" <?php if (isset($_POST['ypv_iam']) && $_POST['ypv_iam'] == "arhat_yogi") { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?>>
        <label for="reg_address"><?php _e('Arhat Trainer Name', 'woocommerce'); ?><span class="required">*</span></label>
        <?php /*     <input type="text" class="input-text" name="arhat_trainer_name" id="arhat_trainer_name" value="<?php esc_attr_e($_POST['arhat_trainer_name']); ?>" />  */ ?>
        <select name="arhat_trainer_name" id="arhat_trainer_name" />
        <option value=""> Select an option </option>

        <option value="Arun Kumar" <?php if ($_POST['arhat_trainer_name'] == "Arun Kumar") echo 'selected="selected" '; ?>>Arun Kumar</option>

        <option value="Dhaval Dholakia" <?php if ($_POST['arhat_trainer_name'] == "Dhaval Dholakia") echo 'selected="selected" '; ?>>Dhaval Dholakia</option>

        <option value="Janani N" <?php if ($_POST['arhat_trainer_name'] == "Janani N") echo 'selected="selected" '; ?>>Janani N</option>

        <option value="J V Subramanian" <?php if ($_POST['arhat_trainer_name'] == "J V Subramanian") echo 'selected="selected" '; ?>>J V Subramanian</option>

        <option value="Jyothi Reddy" <?php if ($_POST['arhat_trainer_name'] == "Jyothi Reddy") echo 'selected="selected" '; ?>>Jyothi Reddy</option>

        <option value="K T Subash & Rekha Subash" <?php if ($_POST['arhat_trainer_name'] == "K T Subash & Rekha Subash") echo 'selected="selected" '; ?>>K T Subash & Rekha Subash</option>

        <option value="Lakshmi Dhevi" <?php if ($_POST['arhat_trainer_name'] == "Lakshmi Dhevi") echo 'selected="selected" '; ?>>Lakshmi Dhevi</option>

        <option value="Madhu Sudhir" <?php if ($_POST['arhat_trainer_name'] == "Madhu Sudhir") echo 'selected="selected" '; ?>>Madhu Sudhir</option>

        <option value="Radha Ganesh" <?php if ($_POST['arhat_trainer_name'] == "Radha Ganesh") echo 'selected="selected" '; ?>>Radha Ganesh</option>

        <option value="Raghu N" <?php if ($_POST['arhat_trainer_name'] == "Raghu N") echo 'selected="selected" '; ?>>Raghu N</option>

        <option value="S K Singh" <?php if ($_POST['arhat_trainer_name'] == "S K Singh") echo 'selected="selected" '; ?>>S K Singh</option>

        <option value="Sunita Ganeriwal" <?php if ($_POST['arhat_trainer_name'] == "Sunita Ganeriwal") echo 'selected="selected" '; ?>>Sunita Ganeriwal</option>

        <option value="Vishakha Karnani" <?php if ($_POST['arhat_trainer_name'] == "Vishakha Karnani") echo 'selected="selected" '; ?>>Vishakha Karnani</option>

        </select>
    </p>

    <div class="clear"></div>

    <p class="form-row form-row-wide regs_ypv_address">
        <label for="reg_address"><?php _e('Address', 'woocommerce'); ?><span class="required">*</span></label>
        <textarea class="input-text" id="tresc_area" name="billing_address_1" cols="60" rows="5" placeholder="House number and street name"><?php esc_attr_e($_POST['billing_address_1']); ?></textarea>
    </p>
    <div class="clear"></div>
    <p class="form-row form-row-wide regs_ypv_address">
        <textarea class="input-text" id="tresc_area2" name="billing_address_2" cols="60" rows="5" placeholder="Apartment, suite, unit, etc. (optional)"><?php esc_attr_e($_POST['billing_address_2']); ?></textarea>
    </p>
    <div class="clear"></div>

    <p class="form-row form-row-wide regs_ypv_billing_city">
        <label for="billing_country"><?php _e('Country / Region', 'woocommerce'); ?></label>
        <select class="country_select" name="billing_country" id="reg_billing_country">
            <option value=""><?php _e('Select Country'); ?></option>
            <?php foreach ($countries as $key => $value) : ?>
                <option value="<?php echo $key ?>"><?php echo $value ?></option>
            <?php endforeach; ?>
        </select>
    </p>

    <div class="ypv_load_state"></div>

    <div class="clear"></div>

    <p class="form-row form-row-wide regs_ypv_billing_city">
        <label for="billing_city"><?php _e('Town / City', 'woocommerce'); ?></label>
        <input type="text" class="input-text" name="billing_city" id="billing_city" value="<?php esc_attr_e($_POST['billing_city']); ?>" />
    </p>

    <p class="form-row form-row-wide regs_ypv_state">
        <label for="billing_postcode"><?php _e('Pin Code', 'woocommerce'); ?></label>
        <input type="text" class="input-text" name="billing_postcode" id="billing_postcode" value="<?php esc_attr_e($_POST['billing_postcode']); ?>" />
    </p>

    <div class="clear"></div>

<?php
}

add_action('woocommerce_register_form', 'ypv_wooc_extra_register_fields');

/**
 * Woocommerce register fields Validating.
 */
function ypv_wooc_validate_extra_register_fields($username, $email, $validation_errors)
{


    if (isset($_POST['billing_first_name']) && empty($_POST['billing_first_name'])) {
        $validation_errors->add('billing_first_name_error', __('First name is required!', 'woocommerce'));
    }

    if (isset($_POST['billing_last_name']) && empty($_POST['billing_last_name'])) {
        $validation_errors->add('billing_last_name_error', __('Last name is required!', 'woocommerce'));
    }

    if (isset($_POST['billing_phone']) && empty($_POST['billing_phone'])) {
        $validation_errors->add('billing_last_name_error', __('Phone Number is required!', 'woocommerce'));
    }

    if (isset($_POST['ypv_iam']) && empty($_POST['ypv_iam'])) {
        $validation_errors->add('ypv_iam_error', __('Please select I AM option is required!', 'woocommerce'));
    }

    if (empty($_POST['ypv_trainer_name']) && $_POST['ypv_iam'] == "ypv_healer") {
        $validation_errors->add('ypv_iam_error', __('Trainer Name is required!', 'woocommerce'));
    }

    if (empty($_POST['arhat_trainer_name']) && $_POST['ypv_iam'] == "arhat_yogi") {
        $validation_errors->add('ypv_iam_error', __('Please select Arhat Trainer Name is required!', 'woocommerce'));
    }


    if (isset($_POST['billing_address_1']) && empty($_POST['billing_address_1'])) {
        $validation_errors->add('billing_address_1_error', __('Please Enter Address is required!', 'woocommerce'));
    }

    return $validation_errors;
}

add_action('woocommerce_register_post', 'ypv_wooc_validate_extra_register_fields', 10, 3);

/**
 * Woocommerce code save extra fields.
 */
function ypv_wooc_save_extra_register_fields($customer_id)
{

    if (isset($_POST['billing_first_name'])) {
        //First name field which is by default
        update_user_meta($customer_id, 'first_name', sanitize_text_field($_POST['billing_first_name']));
        // First name field which is used in WooCommerce
        update_user_meta($customer_id, 'billing_first_name', sanitize_text_field($_POST['billing_first_name']));
    }
    if (isset($_POST['billing_last_name'])) {
        // Last name field which is by default
        update_user_meta($customer_id, 'last_name', sanitize_text_field($_POST['billing_last_name']));
        // Last name field which is used in WooCommerce
        update_user_meta($customer_id, 'billing_last_name', sanitize_text_field($_POST['billing_last_name']));
    }
    if (isset($_POST['billing_phone'])) {
        // Phone input filed which is used in WooCommerce
        update_user_meta($customer_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']));
    }
    if (isset($_POST['whats_app_phone'])) {
        // Whats app Phone input filed which is used in WooCommerce
        update_user_meta($customer_id, 'whats_app_phone', sanitize_text_field($_POST['whats_app_phone']));
    }
    if (isset($_POST['billing_address_1'])) {
        // Address filed1 which is used in WooCommerce
        update_user_meta($customer_id, 'billing_address_1', sanitize_text_field($_POST['billing_address_1']));
    }
    if (isset($_POST['billing_address_2'])) {
        // Address filed2 which is used in WooCommerce
        update_user_meta($customer_id, 'billing_address_2', sanitize_text_field($_POST['billing_address_2']));
    }
    if (isset($_POST['billing_country'])) {
        // Address billing_country which is used in WooCommerce  
        update_user_meta($customer_id, 'billing_country', sanitize_text_field($_POST['billing_country']));
    }
    if (isset($_POST['billing_state'])) {
        // Address billing_state which is used in WooCommerce
        update_user_meta($customer_id, 'billing_state', sanitize_text_field($_POST['billing_state']));
    }
    if (isset($_POST['billing_city'])) {
        // Address billing_city which is used in WooCommerce
        update_user_meta($customer_id, 'billing_city', sanitize_text_field($_POST['billing_city']));
    }
    if (isset($_POST['billing_postcode'])) {
        // Address billing_postcode which is used in WooCommerce
        update_user_meta($customer_id, 'billing_postcode', sanitize_text_field($_POST['billing_postcode']));
    }
    if (isset($_POST['ypv_iam'])) {
        // YPV I Am input filed which is used in WooCommerce
        update_user_meta($customer_id, 'ypv_iam', sanitize_text_field($_POST['ypv_iam']));
    }
    if (isset($_POST['ypv_trainer_name'])) {
        // YPV Trainer Name I Am input filed which is used in WooCommerce
        update_user_meta($customer_id, 'ypv_trainer_name', sanitize_text_field($_POST['ypv_trainer_name']));
    }
    if (isset($_POST['arhat_trainer_name'])) {
        // YPV Arhat Trainer Name I Am input filed which is used in WooCommerce
        update_user_meta($customer_id, 'arhat_trainer_name', sanitize_text_field($_POST['arhat_trainer_name']));
    }


    /*
     * Set user custom Status if select arhat_yogi
     */
    if (isset($_POST['ypv_iam']) && $_POST['ypv_iam'] == 'arhat_yogi') {
        // YPV I Am input filed which is used in WooCommerce
        update_user_meta($customer_id, 'ypv_user_status', '0');
    } else {
        update_user_meta($customer_id, 'ypv_user_status', '1');
    }
    // add meta key force login
    update_user_meta($customer_id, 'changed_password', 0);

    /*
     * Set approved user status table wp_arhat_users_email users 
     */

    global $wpdb;
    $tblname = $wpdb->prefix . "arhat_users_email";
    $user_email = $_POST['email'];
    $sqlQuery = "SELECT COUNT(*) FROM $tblname WHERE emailid = '" . $user_email . "'";
    $check_user_count = $wpdb->get_var($sqlQuery);
    if (!empty($check_user_count)) {
        // echo "user checked"; 
        update_user_meta($customer_id, 'ypv_user_status', '1');
    }
}

add_action('woocommerce_created_customer', 'ypv_wooc_save_extra_register_fields');

/*
 * WooCommerce set Registration form minimum password strength
 */

function ypv_reduce_min_strength_password_requirement($strength)
{
    // 3 => Strong (default) | 2 => Medium | 1 => Weak | 0 => Very Weak (anything).
    return 0;
}

add_filter('woocommerce_min_password_strength', 'ypv_reduce_min_strength_password_requirement');

function ypv_remove_password_strength()
{
    wp_dequeue_script('wc-password-strength-meter');
}

add_action('wp_print_scripts', 'ypv_remove_password_strength', 10);

/**
 * @snippet WooCommerce User Login Shortcode
 */
add_shortcode('ypv_login_form', 'ypv_separate_login_form');

function ypv_separate_login_form()
{
    if (is_admin())
        return;
    if (is_user_logged_in())
        return;
    ob_start();
    do_action('woocommerce_before_customer_login_form');
?>

    <?php do_action('woocommerce_login_form_start'); ?>

    <?php do_action('woocommerce_login_form'); ?>

    <?php
    do_action('woocommerce_login_form_end');
    //   woocommerce_login_form(array('redirect' => wp_get_referer()));
    woocommerce_login_form(array('redirect' => "/my-account/"));
    ?>

    <p class="bottom_signup_link">
        Not registered? <a href="/register/"> Signup here </a>
    </p>

<?php
    return ob_get_clean();
}

/**
 * @snippet WooCommerce User Registration Shortcode
 */
add_shortcode('ypv_reg_form', 'ypv_separate_registration_form');

function ypv_separate_registration_form()
{
    if (is_admin())
        return;
    if (is_user_logged_in())
        return;
    ob_start();

    do_action('woocommerce_before_customer_login_form');
?>
    <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action('woocommerce_register_form_tag'); ?>>

        <?php do_action('woocommerce_register_form_start'); ?>

        <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide regs_ypv_user">
                <label for="reg_username"><?php esc_html_e('Username', 'woocommerce'); ?> <span class="required">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine                                
                                                                                                                                                                                                                                                                ?>
            </p>

        <?php endif; ?>

        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide regs_ypv_email">
            <label for="reg_email"><?php esc_html_e('Email address', 'woocommerce'); ?> <span class="required">*</span></label>
            <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine                                
                                                                                                                                                                                                                                                ?>
        </p>

        <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide regs_ypv_pass">
                <label for="reg_password"><?php esc_html_e('Password', 'woocommerce'); ?> <span class="required">*</span></label>
                <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
            </p>

        <?php else : ?>

            <p><?php esc_html_e('A password will be sent to your email address.', 'woocommerce'); ?></p>

        <?php endif; ?>

        <?php do_action('woocommerce_register_form'); ?>

        <p class="woocommerce-FormRow form-row">
            <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
            <button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e('Register', 'woocommerce'); ?>"><?php esc_html_e('Register', 'woocommerce'); ?></button>
        </p>

        <?php do_action('woocommerce_register_form_end'); ?>

    </form>

    <p class="bottom_signup_link">
        Already registered? <a href="/login/"> Login here </a>
    </p>

    <?php
    return ob_get_clean();
}

/*
 * Add custom login/logout shortcode 
 */

add_shortcode('ypv_login_logout', 'ypv_login_logout_check');

function ypv_login_logout_check()
{
    ob_start();
    if (is_user_logged_in()) {
        $items .= '<a href="' . wp_logout_url(home_url()) . '" class="logregister">Logout</a> ';
        $items .= '<a href="/my-account/" class="logregister">My Account</a> ';
    } else {
        $items .= '<a href="/login/" class="logregister">Login</a>';
        $items .= '<a href="/register/" class="logregister">Register</a>';
    }
    return $items;
    return ob_get_clean();
}

/*
 *  After registration user redirect to account page
 */

function ypv_custom_registration_redirect()
{
    // wp_logout();
    return home_url('/my-account/');
    // wp_get_referer();        
}

add_action('woocommerce_registration_redirect', 'ypv_custom_registration_redirect', 2);

function ypv_custom_pre_get_posts_query($q)
{

    $tax_query = (array) $q->get('tax_query');

    $tax_query[] = array(
        'taxonomy' => 'product_cat',
        'field' => 'slug',
        'terms' => array('events'), // Don't display products in the clothing category on the shop page.
        'operator' => 'IN'
    );

    $q->set('tax_query', $tax_query);
}

add_action('woocommerce_product_query', 'ypv_custom_pre_get_posts_query');

/*
 * account_display_name not required
 */

add_filter('woocommerce_save_account_details_required_fields', 'ypv_wc_save_account_details_required_fields');

function ypv_wc_save_account_details_required_fields($required_fields)
{
    unset($required_fields['account_display_name']);
    return $required_fields;
}

/*
 *  ADD Checkout page Want to join fields
 */

function want_join_withCheckoutField($checkout)
{
    // Loop through order items
    foreach (WC()->cart->get_cart() as $item) {
        // Get the product ID
        $oproduct_ids[] = $item['product_id'];
    }
    if (has_term('events', 'product_cat', $item['product_id'])) {
        $current_user = wp_get_current_user();
        $saved_license_no = $current_user->license_no;
        /*    woocommerce_form_field('want_join_with', array(
          'type' => 'radio',
          'class' => array('form-row-wide radio-checkout'),
          'label' => 'Want to join with:',
          'options' => array(
          //  '' => 'Please select',
          'click-meeting' => 'Click Meeting',
          'zoom' => 'Zoom',
          ),
          //  'default' => 'Click Meeting',
          'required' => true,
          ), $checkout->get_value('want_join_with'));
         */
        /*
          woocommerce_form_field('transaction_amount', array(
          'type' => 'text',
          'class' => array('form-row-wide'),
          'label' => 'Transaction Amount',
          'required' => true,
          ), $checkout->get_value('transaction_amount'));

          woocommerce_form_field('transaction_date', array(
          'type' => 'date',
          'class' => array('form-row-wide'),
          'label' => 'Transaction Date',
          'required' => true,
          ), $checkout->get_value('transaction_date'));

          woocommerce_form_field('transaction_details', array(
          'type' => 'text',
          'class' => array('form-row-wide'),
          'label' => 'Transaction details(UTR/RRN/UPI)',
          'required' => true,
          ), $checkout->get_value('transaction_details'));
         */
        //   }
    }
}

add_action('woocommerce_after_checkout_billing_form', 'want_join_withCheckoutField');

/*
 *  ADD Checkout page fields Validate
 */

function want_join_with_ValidateCheckoutField()
{
    // Loop through order items
    foreach (WC()->cart->get_cart() as $item) {
        // Get the product ID
        $oproduct_ids[] = $item['product_id'];
    }
    if (has_term('events', 'product_cat', $item['product_id'])) {
        if (!$_POST['want_join_with']) {
            wc_add_notice('Please select option want to join with:', 'error');
        }

        /*   if (!$_POST['transaction_amount']) {
          wc_add_notice('Transaction amount is a required field.', 'error');
          }

          if (!$_POST['transaction_date']) {
          wc_add_notice('Transaction date is a required field.', 'error');
          }

          if (!$_POST['transaction_details']) {
          wc_add_notice('Transaction details are a required field.', 'error');
          } */
    }
}

add_action('woocommerce_checkout_process', 'want_join_with_ValidateCheckoutField');

/*
 *  Save Checkout page fields  
 */

function want_join_withSaveCheckoutFieldMeta($order_id)
{
    if ($_POST['want_join_with']) {
        update_post_meta($order_id, 'want_join_with', esc_attr($_POST['want_join_with']));
    }
    if ($_POST['transaction_amount']) {
        update_post_meta($order_id, 'transaction_amount', esc_attr($_POST['transaction_amount']));
    }
    if ($_POST['transaction_date']) {
        update_post_meta($order_id, 'transaction_date', esc_attr($_POST['transaction_date']));
    }
    if ($_POST['transaction_details']) {
        update_post_meta($order_id, 'transaction_details', esc_attr($_POST['transaction_details']));
    }
}

add_action('woocommerce_checkout_update_order_meta', 'want_join_withSaveCheckoutFieldMeta');

/**
 * Display field value on the order edit page
 */
function ypv_custom_checkout_field_display_admin_order_meta($order)
{
    $transaction_amount = get_post_meta($order->get_id(), 'transaction_amount', true);
    $transaction_date = get_post_meta($order->get_id(), 'transaction_date', true);
    $transaction_details = get_post_meta($order->get_id(), 'transaction_details', true);

    if (!empty($transaction_amount)) {
        echo '<p><strong>' . __('Transaction amount') . ':</strong> <br/>' . $transaction_amount . '</p>';
    }
    if (!empty($transaction_date)) {
        echo '<p><strong>' . __('Transaction date') . ':</strong> <br/>' . $transaction_date . '</p>';
    }
    if (!empty($transaction_details)) {
        echo '<p><strong>' . __('Transaction details') . ':</strong> <br/>' . $transaction_details . '</p>';
    }
}

add_action('woocommerce_admin_order_data_after_billing_address', 'ypv_custom_checkout_field_display_admin_order_meta', 10, 1);

/*
 * Redirect user shop page if not logged in

  function ypv_shop_page_redirect() {
  $current_url = $_SERVER['REQUEST_URI'];
  if (!is_user_logged_in() && $current_url == '/shop/') {
  // feel free to customize the following line to suit your needs
  wp_redirect('/login/');
  exit;
  }
  }

  add_action('template_redirect', 'ypv_shop_page_redirect');
 */

/*
 * Woocommerce My account menus Items Update
 */
/*
  function ypv_remove_my_account_links($menu_links) {

  unset($menu_links['edit-address']); // Addresses
  //unset( $menu_links['dashboard'] ); // Remove Dashboard
  //unset( $menu_links['payment-methods'] ); // Remove Payment Methods
  //unset( $menu_links['orders'] ); // Remove Orders
  //unset( $menu_links['downloads'] ); // Disable Downloads
  //unset( $menu_links['edit-account'] ); // Remove Account details tab
  unset($menu_links['customer-logout']); // Remove Logout link
  // Add New Link
  //   $new = array('zoom_meeting' => 'Zoom Meeting / Webinar');

  $new = array('zoom_meeting' => 'Zoom Meeting / Webinar', 'billing_shipping' => 'Billing & Shipping', 'premium-support' => 'Premium Support');

  // Or in case you need 2 links
  // $new = array( 'link1' => 'Link 1', 'link2' => 'Link 2' );
  // array_slice() is good when you want to add an element between the other ones
  // $menu_links = array_slice($menu_links, 0, 1, true) + $new + array_slice($menu_links, 1, NULL, true);

  $menu_links = array(
  'dashboard' => __('Dashboard', 'woocommerce'),
  'orders' => __('Orders', 'woocommerce'),
  'subscriptions' => __('Subscriptions', 'woocommerce'),
  'billing_shipping' => __('Billing & Shipping', 'woocommerce'),
  'downloads' => __('Downloads', 'woocommerce'),
  'zoom-webinar' => __('Zoom Meeting/Webinar', 'woocommerce'),
  'edit-account' => __('Your Profile', 'woocommerce'),
  );


  return $menu_links;
  }

  add_filter('woocommerce_account_menu_items', 'ypv_remove_my_account_links');

  function ypv_hook_endpoint($url, $endpoint, $value, $permalink) {
  if ($endpoint === 'zoom_meeting') {
  // Here is the place for your custom URL, it could be external
  $url = site_url() . "/my-account/zoom-meeting-webinar/";
  }
  if ($endpoint === 'billing_shipping') {
  // Here is the place for your custom URL, it could be external
  $url = site_url() . "/my-account/edit-address/billing/";
  }
  return $url;
  }

  add_filter('woocommerce_get_endpoint_url', 'ypv_hook_endpoint', 10, 4);
 */

/*
 * Add Ajax for state dropdown fields
 */

function ypv_get_states_by_ajax_callback()
{
    global $woocommerce;
    $country_code = $_POST['countryid'];

    $countries_obj = new WC_Countries();
    $countries = $countries_obj->__get('countries');
    $default_country = $countries_obj->get_base_country();
    $county_states = $countries_obj->get_states($country_code);
    if ($county_states) {
        sort($county_states);
    ?>
        <p class="form-row form-row-wide regs_ypv_state">
            <label for="reg_billing_state"><?php _e('State', 'woocommerce'); ?></label>
            <select class="country_state" name="billing_state" id="billing_state">
                <?php foreach ($county_states as $key => $value) : ?>
                    <option value="<?php echo $key ?>"><?php echo $value ?></option>
                <?php endforeach; ?>
                ?>
            </select>
        </p>
    <?php
    } else {
    ?>
        <p class="form-row form-row-wide regs_ypv_state">
            <label for="reg_billing_state"><?php _e('State', 'woocommerce'); ?></label>
            <input type="text" class="input-text" name="billing_state" id="billing_state" value="<?php esc_attr_e($_POST['billing_state']); ?>" />
        </p>
    <?php
    }
    wp_die();
}

add_action('wp_ajax_ypv_get_states_by_ajax_callback', 'ypv_get_states_by_ajax_callback');
add_action('wp_ajax_nopriv_ypv_get_states_by_ajax_callback', 'ypv_get_states_by_ajax_callback');

/*
 * Redirecting a User thank you page after They've Reset Their Password  
 */

function ypv_new_pass_redirect($user)
{
    wp_redirect('/password-reset/?send=1', 301);
    exit;
}

add_action('woocommerce_customer_reset_password', 'ypv_new_pass_redirect');

/** Add user approve field */
add_action('user_new_form', 'ypv_add_user_fields');
add_action('edit_user_profile', 'ypv_add_user_fields');
add_action('show_user_profile', 'ypv_add_user_fields');

function ypv_add_user_fields($user)
{
    if (!current_user_can('manage_options')) {
        return;
    }
    $ypv_iam = get_user_meta($user->ID, 'ypv_iam', true);
    $ypv_user_status = get_user_meta($user->ID, 'ypv_user_status', true);
    $ypv_trainer_name = get_user_meta($user->ID, 'ypv_trainer_name', true);
    $ypv_trainer_name = get_user_meta($user->ID, 'ypv_trainer_name', true);
    $arhat_trainer_name = get_user_meta($user->ID, 'arhat_trainer_name', true);

    // if (isset($ypv_iam) && ($ypv_iam == 'arhat_yogi' || $ypv_iam == 'Arhat Yogi')) {
    ?>
    <h2 class="user_prmission"><?php _e('User Information', 'YPV'); ?></h3>
        <table class="form-table">
            <tr class="user-approve_status-wrap">
                <th><label for="dropdown"><?php _e('Status', 'YPV'); ?></label></th>
                <td>
                    <select name="ypv_user_status" id="ypv_user_status_admin">
                        <option value="">Please Select</option>
                        <option value="1" <?php
                                            if (isset($ypv_user_status) && $ypv_user_status == '1') {
                                                echo 'selected';
                                            }
                                            ?>>Approved</option>
                        <option value="0" <?php
                                            if (isset($ypv_user_status) && $ypv_user_status == '0') {
                                                echo 'selected';
                                            }
                                            ?>>Pending</option>
                    </select>
                </td>
            </tr>

            <tr class="user-approve_status-wrap">
                <th><label for="dropdown"><?php _e('I AM', 'YPV'); ?></label></th>
                <td>
                    <select name="ypv_iam" id="ypv_iam" />
                    <option value=""> Select an option </option>
                    <option value="ypv_healer" <?php if ($ypv_iam == "ypv_healer") echo 'selected="selected" '; ?>>YPV Healer</option>
                    <option value="arhat_yogi" <?php if ($ypv_iam == 'arhat_yogi' || $ypv_iam == 'Arhat Yogi') echo 'selected="selected" '; ?>>Arhat Yogi</option>
                    <option value="not_ypv_healer" <?php if ($ypv_iam == "not_ypv_healer") echo 'selected="selected" '; ?>>Not a Healer Yet</option>
                    </select>
                </td>
            </tr>

            <tr class="user-approve_status-wrap">
                <th><label for="YPV Trainer Name"><?php _e('Trainer Name', 'YPV'); ?></label></th>
                <td>
                    <input type="text" class="input-text" name="ypv_trainer_name" id="ypv_trainer_name" value="<?php esc_attr_e($ypv_trainer_name); ?>" />
                </td>
            </tr>

            <tr class="user-approve_status-wrap">
                <th><label for="YPV Trainer Name"><?php _e('Arhat Trainer Name', 'YPV'); ?></label></th>
                <td>
                    <?php /*
                  <input type="text" class="input-text" name="arhat_trainer_name" id="arhat_trainer_name" value="<?php esc_attr_e($arhat_trainer_name); ?>" /> */ ?>
                    <select name="arhat_trainer_name" id="arhat_trainer_name" />
                    <option value=""> Select an option </option>

                    <option value="Arun Kumar" <?php if ($arhat_trainer_name == "Arun Kumar") echo 'selected="selected" '; ?>>Arun Kumar</option>

                    <option value="Dhaval Dholakia" <?php if ($arhat_trainer_name == "Dhaval Dholakia") echo 'selected="selected" '; ?>>Dhaval Dholakia</option>

                    <option value="Janani N" <?php if ($arhat_trainer_name == "Janani N") echo 'selected="selected" '; ?>>Janani N</option>

                    <option value="J V Subramanian" <?php if ($arhat_trainer_name == "J V Subramanian") echo 'selected="selected" '; ?>>J V Subramanian</option>

                    <option value="Jyothi Reddy" <?php if ($arhat_trainer_name == "Jyothi Reddy") echo 'selected="selected" '; ?>>Jyothi Reddy</option>

                    <option value="K T Subash & Rekha Subash" <?php if ($arhat_trainer_name == "K T Subash & Rekha Subash") echo 'selected="selected" '; ?>>K T Subash & Rekha Subash</option>

                    <option value="Lakshmi Dhevi" <?php if ($arhat_trainer_name == "Lakshmi Dhevi") echo 'selected="selected" '; ?>>Lakshmi Dhevi</option>

                    <option value="Madhu Sudhir" <?php if ($arhat_trainer_name == "Madhu Sudhir") echo 'selected="selected" '; ?>>Madhu Sudhir</option>

                    <option value="Radha Ganesh" <?php if ($arhat_trainer_name == "Radha Ganesh") echo 'selected="selected" '; ?>>Radha Ganesh</option>

                    <option value="Raghu N" <?php if ($arhat_trainer_name == "Raghu N") echo 'selected="selected" '; ?>>Raghu N</option>

                    <option value="S K Singh" <?php if ($arhat_trainer_name == "S K Singh") echo 'selected="selected" '; ?>>S K Singh</option>

                    <option value="Sunita Ganeriwal" <?php if ($arhat_trainer_name == "Sunita Ganeriwal") echo 'selected="selected" '; ?>>Sunita Ganeriwal</option>

                    <option value="Vishakha Karnani" <?php if ($arhat_trainer_name == "Vishakha Karnani") echo 'selected="selected" '; ?>>Vishakha Karnani</option>

                    </select>
                </td>
            </tr>

            <tr class="user-approve_status-wrap">
                <th><label for="Location Lead"><?php _e('Location Lead', 'YPV'); ?></label></th>
                <td>
                    <input type="text" class="input-text" name="ypv_location_lead" id="ypv_location_lead" value="<?php esc_attr_e($ypv_location_lead); ?>" />
                </td>
            </tr>


        </table>
    <?php
    //  }
}

/* Update selected option * */
add_action('user_register', 'ypv_save_user_fields');
add_action('personal_options_update', 'ypv_save_user_fields');
add_action('edit_user_profile_update', 'ypv_save_user_fields');

function ypv_save_user_fields($user_id)
{

    if (!current_user_can('edit_user', $user_id))
        return false;

    $ypv_user_status = $_POST['ypv_user_status'];
    $update_ypv_iam = $_POST['ypv_iam'];
    $update_ypv_trainer_name = $_POST['ypv_trainer_name'];
    $update_arhat_trainer_name = $_POST['arhat_trainer_name'];
    $update_ypv_location_lead = $_POST['ypv_location_lead'];

    update_user_meta($user_id, 'ypv_user_status', $ypv_user_status);

    if (!empty($update_ypv_iam)) {
        update_user_meta($user_id, 'ypv_iam', $update_ypv_iam);
    }
    if (!empty($update_ypv_trainer_name)) {
        update_user_meta($user_id, 'ypv_trainer_name', $update_ypv_trainer_name);
    }
    if (!empty($update_arhat_trainer_name)) {
        update_user_meta($user_id, 'arhat_trainer_name', $update_arhat_trainer_name);
    }
    if (!empty($update_ypv_location_lead)) {
        update_user_meta($user_id, 'ypv_location_lead', $update_ypv_location_lead);
    }
}

/*
 * Check User status Add to cart
 */

function ypv_cart_user_validation($passed, $product_id)
{

    $cart_items_count = WC()->cart->get_cart_contents_count();
    $user = wp_get_current_user();
    $ypv_user_status = get_user_meta($user->ID, 'ypv_user_status', true);

    $can_purchase = get_field("can_purchase", $product_id);
    $ypv_iam = get_user_meta($user->ID, 'ypv_iam', true);

    if (is_user_logged_in()) {

        if ($can_purchase == 'Arhat Yogi' && $ypv_iam == 'arhat_yogi' && $ypv_user_status == '1') {
            $passed = true;
            //  echo "1";    
        } else if ($can_purchase == 'Anyone') {
            $passed = true;
            //  echo "2";  
        } else {

            if (!empty($cart_items_count)) {
                wc_add_notice(__('Your registration request is waiting approval. Please contact your trainer or Location Lead to approve your registration <a href="/cart/"><strong>view cart</strong></a>.', 'woocommerce'), 'error');
            } else {
                wc_add_notice(__('Your registration request is waiting approval. Please contact your trainer or Location Lead to approve your registration.', 'woocommerce'), 'error');
            }
            $passed = false;
            //   echo "3";  
        }
    } else {
        wc_add_notice(__('Please <a href="/login/">login</a> before registering for an event.', 'woocommerce'), 'error');
        $passed = false;
        // echo "4";     
    }
    //  die;        
    return $passed;
}

add_filter('woocommerce_add_to_cart_validation', 'ypv_cart_user_validation', 10, 5);

/*
 * Add custom column to Users admin panel
 * 
 */

function ypv_user_display_column($column_headers)
{
    $column_headers['trainer_name'] = __('Trainer Name');
    $column_headers['arhat_trainer_name'] = __('Arhat Trainer Name');
    $column_headers['location_lead'] = __('Location Lead');
    $column_headers['user_status'] = __('User Status');

    unset($column_headers['posts']);
    unset($column_headers['wfls_last_login']);
    unset($column_headers['wfls_2fa_status']);

    return $column_headers;
}

add_action('manage_users_columns', 'ypv_user_display_column');

function ypv_user_column_sortable($columns)
{
    $columns['user_status'] = 'User Status';
    $columns['trainer_name'] = 'Trainer Name';
    $columns['arhat_trainer_name'] = 'Arhat Name';
    $columns['location_lead'] = 'Location Lead';

    return $columns;
}

add_filter('manage_users_sortable_columns', 'ypv_user_column_sortable');

function ypv_add_user_column_value($value, $column_name, $user_id)
{
    $ypv_iam = get_user_meta($user_id, 'ypv_iam', true);
    $ypv_user_status = get_user_meta($user_id, 'ypv_user_status', true);
    $ypv_trainer_name = get_user_meta($user_id, 'ypv_trainer_name', true);
    $arhat_trainer_name = get_user_meta($user_id, 'arhat_trainer_name', true);
    $ypv_location_lead = get_user_meta($user_id, 'ypv_location_lead', true);

    //   if (isset($ypv_iam) && ($ypv_iam == 'arhat_yogi' || $ypv_iam == 'Arhat Yogi')) {

    if ('user_status' == $column_name) {
        if (!empty($ypv_user_status) && $ypv_user_status == 1) {
            $value = '<span style="color:green;font-weight:bold;">Approved</span>';
        } else if ($ypv_user_status == 0) {
            $value = '<span class="na" style="color:grey;"><em>Pending</em></span>';
        } else {
            $value = '<span style="color:green;font-weight:bold;">Approved</span>';
        }
    }

    if (!empty($ypv_location_lead) && 'location_lead' == $column_name) {
        $value = '<span class="na" style="color:grey;">' . $ypv_location_lead . '</span>';
    }

    if (!empty($ypv_trainer_name) && 'trainer_name' == $column_name) {
        $value = '<span class="na" style="color:grey;">' . $ypv_trainer_name . '</span>';
    }
    if (!empty($arhat_trainer_name) && 'arhat_trainer_name' == $column_name) {
        $value = '<span class="na" style="color:grey;">' . $arhat_trainer_name . '</span>';
    }
    //   }

    return $value;
}

add_filter('manage_users_custom_column', 'ypv_add_user_column_value', 10, 3);

/*
 * WooCommerce add loader Image  
 */

function ypv_custom_ajax_spinner()
{
    ?>
        <style>
            p#msg-razorpay-success {
                /*  display: block !important;  */
                height: 3em;
                width: 100%;
                -webkit-animation: none;
                -moz-animation: none;
                animation: none;
                background-image: url('<?php echo get_stylesheet_directory_uri() . "/custom/icons/loader.svg"; ?>') !important;
                background-position: center center;
                line-height: 1;
                background-repeat: no-repeat;
            }
        </style>
    <?php
}

add_action('wp_head', 'ypv_custom_ajax_spinner', 1000);

/*
 * Checking and validating when products are added to cart

  function ypv_check_product_added_to_cart( $passed, $product_id, $quantity) {
  foreach (WC()->cart->get_cart() as $cart_key => $cart_item ){
  // if products are already in cart:
  $cartid = $cart_item['data']->get_id();

  if( $cartid == $product_id ) {
  // Set the verification variable to "not passed" (false)
  $passed = true;
  // (Optionally) Displays a notice if product(s) are already in cart
  wc_add_notice( '<strong>' . $btn['label'] . '</strong> ' . __( 'This product is already in your cart <a href="/cart/"><strong>view cart</strong></a>.', 'woocommerce' ), 'error' );
  // Stop the function returning "false", so the products will not be added again
  return $passed;
  }
  }
  return $passed;
  }
  add_action( 'woocommerce_add_to_cart_validation', 'ypv_check_product_added_to_cart', 10, 3 );
 */

/*
 * Added already registered user link login
 */
add_filter('woocommerce_registration_error_email_exists', function ($html) {
    $html = 'An account is already registered with your email address <a href="/login/"><strong>Please log in.</strong></a>';
    return $html;
});

/*
 * Checking and validating when products are added to cart
 */

function ypv_items_allowed_add_to_cart($passed, $product_id, $quantity)
{

    $cart_items_count = WC()->cart->get_cart_contents_count();
    $product = wc_get_product($product_id);
    if($product->get_parent_id() != 0 ) {
        $product = wc_get_product($product->get_parent_id());
    }
    $has_term = false;

    if(has_term( array('material-request'), 'product_cat', $product->get_id() )) {
       //$passed = true;
        $has_term = true;
    }

    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item ){

        // Check if the product category of the current product don't match with a cart item
        if( ! has_term( array('material-request'), 'product_cat', $cart_item['product_id'] ) ){

            $has_term = false;
           
        }
    }

    $total_count = $cart_items_count + $quantity;
    if ( ($cart_items_count > 1 || $total_count > 1) && !$has_term) {
        // Set to false
        $passed = false;
        // Display a message
        wc_add_notice('<strong>' . $btn['label'] . '</strong> ' . __('You can not register for more than one event at a time. Please complete/cancel your registration process from <a href="/checkout/">here</a>. ', 'woocommerce'), 'error');
    }
    return $passed;
}

add_filter('woocommerce_add_to_cart_validation', 'ypv_items_allowed_add_to_cart', 10, 3);

/*
 * Set input field max for variable product in woocommerce
 */

/*function ypv_quantity_input_max($max)
{
    $max = 1;
    return $max;
}

add_filter('woocommerce_quantity_input_max', 'ypv_quantity_input_max');*/

/*
 * Removed WooCommerce Checkout fields company
 */

function ypv_remove_company_name($fields)
{
    unset($fields['billing']['billing_company']);
    return $fields;
}

add_filter('woocommerce_checkout_fields', 'ypv_remove_company_name');

// Add a second password field to the checkout page in WC 3.x.
add_filter('woocommerce_checkout_fields', 'wc_add_confirm_password_checkout', 10, 1);

function wc_add_confirm_password_checkout($checkout_fields)
{
    if (get_option('woocommerce_registration_generate_password') == 'no') {
        $checkout_fields['account']['account_password2'] = array(
            'type' => 'password',
            'label' => __('Confirm password', 'woocommerce'),
            'required' => true,
            'placeholder' => _x('Confirm Password', 'placeholder', 'woocommerce')
        );
    }

    return $checkout_fields;
}

// Check the password and confirm password fields match before allow checkout to proceed.
add_action('woocommerce_after_checkout_validation', 'wc_check_confirm_password_matches_checkout', 10, 2);

function wc_check_confirm_password_matches_checkout($posted)
{
    $checkout = WC()->checkout;
    if (!is_user_logged_in() && ($checkout->must_create_account || !empty($posted['createaccount']))) {
        if (strcmp($posted['account_password'], $posted['account_password2']) !== 0) {
            wc_add_notice(__('Passwords do not match.', 'woocommerce'), 'error');
        }
    }
}

/*
 *  Add confirm password field on the register form  
 */

function ypv_registration_errors_validation($reg_errors, $sanitized_user_login, $user_email)
{
    global $woocommerce;
    extract($_POST);
    if (strcmp($password, $password2) !== 0) {
        return new WP_Error('registration-error', __('Passwords do not match.', 'woocommerce'));
    }
    return $reg_errors;
}

add_filter('woocommerce_registration_errors', 'ypv_registration_errors_validation', 10, 3);

/*
 * Add to cart redirect to checkout page
 */

function ypv_redirect_to_checkout()
{
    global $woocommerce;
    $checkout_url = $woocommerce->cart->get_checkout_url();
    return $checkout_url;
}

add_filter('add_to_cart_redirect', 'ypv_redirect_to_checkout');

/*
 * Woocommerce Add fields to my account profile  
 */

function ypv_edit_account_form()
{

    global $woocommerce;
    $countries_obj = new WC_Countries();
    $countries = $countries_obj->__get('countries');
    $default_country = $countries_obj->get_base_country();
    $default_county_states = $countries_obj->get_states($default_country);

    $current_user = wp_get_current_user();
    $whats_app_phone = get_user_meta($current_user->ID, 'whats_app_phone', true);

    $ypv_iam = get_user_meta($current_user->ID, 'ypv_iam', true);
    $ypv_trainer_name = get_user_meta($current_user->ID, 'ypv_trainer_name', true);
    $arhat_trainer_name = get_user_meta($current_user->ID, 'arhat_trainer_name', true);

    $billing_address1 = get_user_meta($current_user->ID, 'billing_address_1', true);
    $billing_address2 = get_user_meta($current_user->ID, 'billing_address_2', true);

    $billing_country = get_user_meta($current_user->ID, 'billing_country', true);
    $billing_state = get_user_meta($current_user->ID, 'billing_state', true);
    $billing_city = get_user_meta($current_user->ID, 'billing_city', true);
    $billing_postcode = get_user_meta($current_user->ID, 'billing_postcode', true);

    $ru_ypv_trainer = get_user_meta($current_user->ID, 'ru_ypv_trainer', true);
    $ypv_level_course = get_user_meta($current_user->ID, 'ypv_level_course', true);
    ?>

        <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first form-row form-row-wide regs_ypv_whatssapp">
            <label for="reg_whats_app_phone"><?php _e('Whats app number', 'woocommerce'); ?></label>
            <input type="number" class="input-text" name="whats_app_phone" id="whats_app_phone" value="<?php esc_attr_e($whats_app_phone); ?>" />
        </p>


        <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last regs_ypv_select">
            <label for=""><?php _e('I AM', 'woocommerce'); ?> <span class="required">*</span></label>
            <select name="ypv_iam" id="ypv_iam" />
            <option value=""> Select an option </option>
            <option value="ypv_healer" <?php if ($ypv_iam == "ypv_healer") echo 'selected="selected" '; ?>>YPV Healer</option>
            <option value="arhat_yogi" <?php if ($ypv_iam == "arhat_yogi") echo 'selected="selected" '; ?>>Arhat Yogi</option>
            <option value="not_ypv_healer" <?php if ($ypv_iam == "not_ypv_healer") echo 'selected="selected" '; ?>>Not a Healer Yet</option>
            </select>
        </p>

        <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first ypv_trainer_name" <?php if ($ypv_iam == "ypv_healer") { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?>>
            <label for="reg_address"><?php _e('Trainer Name', 'woocommerce'); ?><span class="required">*</span></label>
            <input type="text" class="input-text" name="ypv_trainer_name" id="ypv_trainer_name" value="<?php esc_attr_e($ypv_trainer_name); ?>" />
        </p>

        <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first arhat_trainer_name" <?php if ($ypv_iam == "arhat_yogi") { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?>>
            <label for="reg_address"><?php _e('Arhat Trainer Name', 'woocommerce'); ?><span class="required">*</span></label>
            <?php /*
          <input type="text" class="input-text" name="arhat_trainer_name" id="arhat_trainer_name" value="<?php esc_attr_e($arhat_trainer_name); ?>" />
         */ ?>
            <select name="arhat_trainer_name" id="arhat_trainer_name" />
            <option value=""> Select an option </option>

            <option value="Arun Kumar" <?php if ($arhat_trainer_name == "Arun Kumar") echo 'selected="selected" '; ?>>Arun Kumar</option>

            <option value="Dhaval Dholakia" <?php if ($arhat_trainer_name == "Dhaval Dholakia") echo 'selected="selected" '; ?>>Dhaval Dholakia</option>

            <option value="Janani N" <?php if ($arhat_trainer_name == "Janani N") echo 'selected="selected" '; ?>>Janani N</option>

            <option value="J V Subramanian" <?php if ($arhat_trainer_name == "J V Subramanian") echo 'selected="selected" '; ?>>J V Subramanian</option>

            <option value="Jyothi Reddy" <?php if ($arhat_trainer_name == "Jyothi Reddy") echo 'selected="selected" '; ?>>Jyothi Reddy</option>

            <option value="K T Subash & Rekha Subash" <?php if ($arhat_trainer_name == "K T Subash & Rekha Subash") echo 'selected="selected" '; ?>>K T Subash & Rekha Subash</option>

            <option value="Lakshmi Dhevi" <?php if ($arhat_trainer_name == "Lakshmi Dhevi") echo 'selected="selected" '; ?>>Lakshmi Dhevi</option>

            <option value="Madhu Sudhir" <?php if ($arhat_trainer_name == "Madhu Sudhir") echo 'selected="selected" '; ?>>Madhu Sudhir</option>

            <option value="Radha Ganesh" <?php if ($arhat_trainer_name == "Radha Ganesh") echo 'selected="selected" '; ?>>Radha Ganesh</option>

            <option value="Raghu N" <?php if ($arhat_trainer_name == "Raghu N") echo 'selected="selected" '; ?>>Raghu N</option>

            <option value="S K Singh" <?php if ($arhat_trainer_name == "S K Singh") echo 'selected="selected" '; ?>>S K Singh</option>

            <option value="Sunita Ganeriwal" <?php if ($arhat_trainer_name == "Sunita Ganeriwal") echo 'selected="selected" '; ?>>Sunita Ganeriwal</option>

            <option value="Vishakha Karnani" <?php if ($arhat_trainer_name == "Vishakha Karnani") echo 'selected="selected" '; ?>>Vishakha Karnani</option>

            </select>
        </p>


        <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first regs_ypv_address">
            <label for="reg_address"><?php _e('Address', 'woocommerce'); ?><span class="required">*</span></label>
            <textarea class="input-text" id="tresc_area" name="billing_address_1" cols="60" rows="5" placeholder="House number and street name"><?php esc_attr_e($billing_address1); ?></textarea>
        </p>

        <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first regs_ypv_address">
            <textarea class="input-text" id="tresc_area2" name="billing_address_2" cols="60" rows="5" placeholder="Apartment, suite, unit, etc. (optional)"><?php esc_attr_e($billing_address2); ?></textarea>
        </p>


        <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first regs_ypv_billing_city">
            <label for="billing_country"><?php _e('Country / Region', 'woocommerce'); ?></label>
            <select class="country_select" name="billing_country" id="reg_billing_country">
                <option value=""><?php _e('Select Country'); ?></option>
                <?php foreach ($countries as $key => $value) : ?>
                    <option value="<?php echo $key ?>" <?php if ($billing_country == $key) echo 'selected="selected" '; ?>><?php echo $value ?></option>
                <?php endforeach; ?>
            </select>
        </p>


        <?php if (isset($billing_state) && !empty($billing_state)) {
        ?>
            <p class="form-row form-row-wide regs_ypv_state ypv_state_default">
                <label for="billing_state"><?php _e('State', 'woocommerce'); ?></label>
                <input type="text" class="input-text" name="billing_state" id="billing_state" value="<?php esc_attr_e($billing_state); ?>">
            </p>
        <?php } ?>

        <div class="ypv_load_state"> </div>

        <div class="clear"></div>

        <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first regs_ypv_billing_city">
            <label for="billing_city"><?php _e('Town / City', 'woocommerce'); ?></label>
            <input type="text" class="input-text" name="billing_city" id="billing_city" value="<?php esc_attr_e($billing_city); ?>" />
        </p>

        <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last regs_ypv_state">
            <label for="billing_postcode"><?php _e('Pin Code', 'woocommerce'); ?></label>
            <input type="text" class="input-text" name="billing_postcode" id="billing_postcode" value="<?php esc_attr_e($billing_postcode); ?>" />
        </p>

        <div class="clear"></div>

        <!-- add new field Are you a YPV Trainer -->

        <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first ru_ypv_trainer">
            <label for="ru_ypv_trainer"><?php _e('Are you a YPV Trainer', 'woocommerce'); ?></label>
            <span>
                <input type="radio" class="input-radio ru_ypv_trainer_input" value="yes" name="ru_ypv_trainer" id="ru_ypv_trainer" <?php if ($ru_ypv_trainer == "yes") echo 'checked="checked" '; ?>>
                <label for="ru_ypv_trainer_yes" class="radio "><?php esc_attr_e("Yes"); ?></label>
            </span>
            <span>
                <input type="radio" class="input-radio ru_ypv_trainer_input" value="no" name="ru_ypv_trainer" id="ru_ypv_trainer" <?php if ($ru_ypv_trainer == "no") echo 'checked="checked" '; ?>>
                <label for="ru_ypv_trainer_no" class="radio "><?php esc_attr_e("No"); ?></label>
            </span>
        </p>


        <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last ypv_level_course" <?php if ($ru_ypv_trainer == "yes") { ?> style=" display:block;" <?php } else { ?> style="display:none;" <?php } ?>>
            <label for=""><?php _e('Highest level of YPV course you conduct', 'woocommerce'); ?></label>
            <select name="ypv_level_course" id="ypv_level_course" />
            <option value=""> Select an option </option>
            <option value="ypv_level_1" <?php if ($ypv_level_course == "ypv_level_1") echo 'selected="selected" '; ?>>YPV Level 1</option>
            <option value="ypv_level_2" <?php if ($ypv_level_course == "ypv_level_2") echo 'selected="selected" '; ?>>YPV Level 2/Level 3</option>
            <option value="ypv_level_crystal" <?php if ($ypv_level_course == "ypv_level_crystal") echo 'selected="selected" '; ?>>YPV with Crystal/PSP</option>
            <option value="ypv_auwa" <?php if ($ypv_level_course == "ypv_auwa") echo 'selected="selected" '; ?>>AUWA</option>
            <option value="ypv_arhat_yoga" <?php if ($ypv_level_course == "ypv_arhat_yoga") echo 'selected="selected" '; ?>>Arhat Yoga</option>
            </select>
        </p>

        <div class="clear"></div>

    <?php
}

add_action('woocommerce_edit_account_form', 'ypv_edit_account_form');

function ypv_save_account_details($user_id)
{

    if (isset($_POST['whats_app_phone'])) {
        update_user_meta($user_id, 'whats_app_phone', sanitize_text_field($_POST['whats_app_phone']));
    }
    if (isset($_POST['billing_address_1'])) {
        update_user_meta($user_id, 'billing_address_1', sanitize_text_field($_POST['billing_address_1']));
    }
    if (isset($_POST['billing_address_2'])) {
        update_user_meta($user_id, 'billing_address_2', sanitize_text_field($_POST['billing_address_2']));
    }
    if (isset($_POST['billing_country'])) {
        update_user_meta($user_id, 'billing_country', sanitize_text_field($_POST['billing_country']));
    }
    if (isset($_POST['billing_state'])) {
        update_user_meta($user_id, 'billing_state', sanitize_text_field($_POST['billing_state']));
    }
    if (isset($_POST['billing_city'])) {
        update_user_meta($user_id, 'billing_city', sanitize_text_field($_POST['billing_city']));
    }
    if (isset($_POST['billing_postcode'])) {
        update_user_meta($user_id, 'billing_postcode', sanitize_text_field($_POST['billing_postcode']));
    }
    if (isset($_POST['ypv_iam'])) {
        update_user_meta($user_id, 'ypv_iam', sanitize_text_field($_POST['ypv_iam']));
    }
    if (isset($_POST['ypv_trainer_name'])) {
        update_user_meta($user_id, 'ypv_trainer_name', sanitize_text_field($_POST['ypv_trainer_name']));
    }
    if (isset($_POST['arhat_trainer_name'])) {
        update_user_meta($user_id, 'arhat_trainer_name', sanitize_text_field($_POST['arhat_trainer_name']));
    }

    if (isset($_POST['ru_ypv_trainer'])) {
        update_user_meta($user_id, 'ru_ypv_trainer', sanitize_text_field($_POST['ru_ypv_trainer']));
    }

    if (isset($_POST['ru_ypv_trainer'])) {
        update_user_meta($user_id, 'ypv_level_course', sanitize_text_field($_POST['ypv_level_course']));
    }

    /*   if (!empty($_POST['password_current']) && $_POST['password_2'] == $_POST['password_1']) {
      $wp_hasher = new PasswordHash(8, TRUE);
      global $current_user;
      $current_user = wp_get_current_user();
      $password_hashed = $current_user->user_pass;
      $_POST['password_current'];
      wp_hash_password($_POST['password_current']);
      // die;
      if ($wp_hasher->CheckPassword($_POST['password_current'], $password_hashed)) {
      update_user_meta($current_user->ID, 'changed_password', 1);
      echo $current_user->ID;
      echo "YES, Matched";
      } else {
      echo "No, Wrong Password";
      }
      die;
      } */
}

add_action('woocommerce_save_account_details', 'ypv_save_account_details', 12, 1);

/*
 * validation account details page 
 */

function ypv_account_validate_custom_field($args)
{

    if (isset($_POST['ypv_iam']) && empty($_POST['ypv_iam'])) {
        $args->add('error', __('Please select I AM option is required!', 'woocommerce'), '');
    }


    if (empty($_POST['ypv_trainer_name']) && $_POST['ypv_iam'] == "ypv_healer") {
        $args->add('error', __('Trainer Name is required!', 'woocommerce'), '');
    }

    if (empty($_POST['arhat_trainer_name']) && $_POST['ypv_iam'] == "arhat_yogi") {
        $args->add('error', __('Please select Arhat Trainer Name is required!', 'woocommerce'), '');
    }

    if (isset($_POST['billing_address_1']) && empty($_POST['billing_address_1'])) {
        $args->add('error', __('Please Enter Address is required!', 'woocommerce'), '');
    }
}

add_action('woocommerce_save_account_details_errors', 'ypv_account_validate_custom_field', 10, 1);

/*
 * Add checkout notice 


  function ypv_checkout_notice() {
  $cart_items_count = WC()->cart->get_cart_contents_count();
  if ($cart_items_count > 1) {
  // Set to false
  $passed = false;
  // Display a message
  wc_add_notice('<strong>' . $btn['label'] . '</strong> ' . __('You can not add more than 1 item to the cart <a href="/cart/"><strong>view cart</strong></a>.', 'woocommerce'), 'error');
  }
  }

  add_action('woocommerce_before_checkout_form', 'ypv_checkout_notice', 10);
 */

//
//// define the woocommerce_customer_reset_password callback 
//function ypv_action_woocommerce_customer_reset_password( $customer_get_id ) { 
//   if( isset($customer_get_id) ) {
//       update_user_meta($customer_get_id, 'changed_password', 1);               
//    }
//}; 
//         
//// add the action 
//add_action( 'woocommerce_update_customer', 'ypv_action_woocommerce_customer_reset_password', 99);    



/*
  function overwite_generate_razorpay_form($orderId) {
  $order = wc_get_order($orderId);

  try {
  $params = $this->getRazorpayPaymentParams($orderId);
  } catch (Exception $e) {
  return $e->getMessage();
  }

  $checkoutArgs = $this->getCheckoutArguments($order, $params);

  $html = '<p>' . __('Thank222 you for your order, please click the button below to pay with Razorpay.', $this->id) . '</p>';

  $html .= $this->generateOrderForm($checkoutArgs);

  return $html;
  }

  add_filter('generate_razorpay_form', 'overwite_generate_razorpay_form', $priority = 10, $args = 1);
 */

/*
 * Change add to cart button text
 */

// To change add to cart text on single product page

function ypv_custom_single_add_to_cart_text()
{
    global $product;       
    if ( has_term( array('material-request'), 'product_cat', $product->ID ) ) {       
        return __('Material Request', 'woocommerce');
    } else {
        return __('Donate', 'woocommerce');
    }
}

add_filter('woocommerce_product_single_add_to_cart_text', 'ypv_custom_single_add_to_cart_text');

// To change add to cart text on product archives page
function ypv_custom_product_add_to_cart_text()
{
    global $product;       
    if ( has_term( array('material-request'), 'product_cat', $product->ID ) ) {       
        return __('Material Request', 'woocommerce');
    } else {
        return __('Donate', 'woocommerce');
    }
}

add_filter('woocommerce_product_add_to_cart_text', 'ypv_custom_product_add_to_cart_text');

/*
 * Add Cancel order button  
 */

function ypv_checkout_reset_button()
{
    echo '<p class="checkout-order-back">
    <a class="button-order-back" style="text-align:center;" href="?cancel=1">' . __("Cancel & Return", "woocommerce") . '</a>';
    echo "</p>";
    if (!is_admin() && isset($_GET['cancel'])) {
        WC()->cart->empty_cart();
        wp_redirect("/my-account/");
        exit();
    }
}

add_action('woocommerce_review_order_after_submit', 'ypv_checkout_reset_button', 10);

/*
 * Change Woocommerce email subject customer on hold order 
 */

function ypv_woo_email_subject_customer_on_hold_order($subject, $order)
{

    // Loop through order items
    if (!empty($order->get_items())) {
        foreach ($order->get_items() as $item_id => $item) {
            // Get the product ID
            $proid = $item->get_product_id();
        }
    }

    if (isset($proid) && $proid == '13627') {
        $subject = 'Your Yoga Prana Donation has been received!';
    } else {
        $subject = 'Your Yoga Prana Registration has been received!';
    }
    return $subject;
}

add_filter('woocommerce_email_subject_customer_on_hold_order', 'ypv_woo_email_subject_customer_on_hold_order', 1, 2);

/*
 * Login redirect page


  function ypv_account_page() {
  return '/my-account/';
  }

  add_filter('login_redirect', 'ypv_account_page');
 */


/*
 *  Check first login user redirect to profile page     
 */

function ypv_redirect_passwort_login_redirect($redirect, $user)
{

    if (isset($user->ID)) {
        $changed_password = get_user_meta($user->ID, "changed_password", true);

        if ($changed_password == 0 && !in_array('locationlead', (array) $user->roles)) {
            update_user_meta($user->ID, 'changed_password', 1);
            return get_bloginfo('url') . "/my-account/edit-account/";
        } else if (in_array('locationlead', (array) $user->roles)) {
            return get_bloginfo('url') . "/wp-admin/";
        } else {
            return $redirect;
        }
    }
}

add_filter('woocommerce_login_redirect', 'ypv_redirect_passwort_login_redirect', 10, 2);

/*
  function ypv_woocommerce_new_pass_set($user) {
  //password has been reset to a random one. so the changed_password meta data should be reset as well
  if (isset($user->ID)) {
  update_user_meta($user->ID, 'changed_password', 1);
  }
  }

  add_action('password_reset', 'ypv_woocommerce_new_pass_set');
 */

/*
 * Set Invoice Paper size format 
 */

function ypv_wcpdf_a5_packing_slips($paper_format, $template_type)
{
    $paper_format = "a5";
}

add_filter('wpo_wcpdf_paper_format', 'ypv_wcpdf_a5_packing_slips', 10, 2);

/*
  function ypv_wcpdf_landscape($paper_orientation, $template_type) {
  // use $template type ( 'invoice' or 'packing-slip') to set paper oriention for only one document type.
  $paper_orientation = 'landscape';
  return $paper_orientation;
  }

  add_filter('wpo_wcpdf_paper_orientation', 'ypv_wcpdf_landscape', 10, 2);
 */


/*
 *  Get all arhat_trainer_name order List
 */

function ypv_arhattrainer_orderitem($query)
{
    $current_user = wp_get_current_user();
    $current_user_id = $current_user->ID;
    $user = new WP_User($current_user_id);

    if (!current_user_can('administrator') && is_admin() && in_array('locationlead', (array) $user->roles) && $_GET['post_type'] == 'shop_order') {

        $arhat_trainer_name = get_user_meta($current_user_id, 'arhat_trainer_name', true);
        if (!empty($arhat_trainer_name)) {
            global $wpdb;

            // Users query
            $args = array(
                'number' => -1,
                'fields' => 'ID',
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key' => 'arhat_trainer_name',
                        'value' => $arhat_trainer_name,
                        'compare' => 'LIKE'
                    ),
                )
            );

            $user_ids = get_users($args);

            $query->set('meta_query', array(
                array(
                    'key' => '_customer_user',
                    'value' => $user_ids,
                    'compare' => 'IN'
                )
            ));
            return $query;
        }
    }
}

add_filter('pre_get_posts', 'ypv_arhattrainer_orderitem');

/*
 * Hide order status count
 */

function ypv_admin_css()
{
    $current_user = wp_get_current_user();
    $current_user_id = $current_user->ID;
    $user = new WP_User($current_user_id);
    if (!current_user_can('administrator') && is_admin() && in_array('locationlead', (array) $user->roles) && $_GET['post_type'] == 'shop_order') {
        echo '<style type="text/css">
  .post-type-shop_order ul.subsubsub {
    display: none;
}
</style>';
    }
}

add_action('admin_head', 'ypv_admin_css');

// ACF Display Custom Fields
add_filter('acf/settings/remove_wp_meta_box', '__return_false');


function ypv_add_courier_fee() {
    
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    $quantity = 0;
    $has_term = false;

    foreach ( WC()->cart->get_cart() as $cart_item ) {
        $product = $cart_item['data'];

        if($product->get_parent_id() != 0 ) {
            $product = wc_get_product($product->get_parent_id());
        }

        if(has_term( array('material-request'), 'product_cat', $product->get_id() )) {
            $quantity += $cart_item['quantity'];
            $has_term = true;
        }
    }
    if($has_term && $quantity <= 10) {
        WC()->cart->add_fee(__('Courier fee', 'ypv'), 200);
    }

}
add_action('woocommerce_cart_calculate_fees', 'ypv_add_courier_fee', 11);

function ypv_unset_gateway_by_category( $available_gateways ) {
    if ( is_admin() ) return $available_gateways;
    if ( ! is_checkout() ) return $available_gateways;
    $unset = false;
    
    foreach ( WC()->cart->get_cart_contents() as $key => $values ) {
        $terms = get_the_terms( $values['product_id'], 'product_cat' );    
        foreach ( $terms as $term ) {   
          
            if ( $term->slug == 'material-request' ) {
                $unset = true; // CATEGORY IS IN THE CART
                break;
            }
        }
    }
    if ( $unset == true ) {
        unset( $available_gateways['razorpay'] );
    }else{
        unset($available_gateways['cashfree']);
    }

    return $available_gateways;
}

add_filter( 'woocommerce_available_payment_gateways', 'ypv_unset_gateway_by_category' );


function ypv_cart_item_quantity($quantity, $key, $item) {

    $product = $item['data'];
    if($product->get_parent_id() != 0 ) {
        $product = wc_get_product($product->get_parent_id());
    }
    if(has_term( array('material-request'), 'product_cat', $product->get_id() )) {
        return $quantity;
    }
    return 1;
}
add_filter('woocommerce_cart_item_quantity', 'ypv_cart_item_quantity', 99, 3);

function ypv_quantity_input_max_1($max) {

    if(is_product()) {
        global $product; 

        if ( has_term( array('material-request'), 'product_cat', $product->get_id() ) ) {       
            return $max;
        } else {
            return 1;
        }
    }
    return $max;
}
add_filter('woocommerce_quantity_input_max', 'ypv_quantity_input_max_1');
//if you want to enable this goto line no 1598 and comment 

function ypv_send_completed_email_to_trainer($recipient, $object) {

    $user_id = $object->get_user_id();
    $trainer_name = get_user_meta($user_id, 'arhat_trainer_name', true);
    $data = [ 
        'Arun Kumar' => 'shravankumar.sharma@galaxyweblinks.in', //'78arun@gmail.com',
        'Dhaval Dholakia' => 'shravankumar.sharma@galaxyweblinks.in', //'',
        'Janani N' => 'shravankumar.sharma@galaxyweblinks.in', //'n_janani_reddy@yahoo.com',
        'J V Subramanian' => 'shravankumar.sharma@galaxyweblinks.in', //'',
        'Jyothi Reddy' => 'shravankumar.sharma@galaxyweblinks.in', //'',
        'K T Subash & Rekha Subash' => 'shravankumar.sharma@galaxyweblinks.in', //'k_tsubash@hotmail.com',
        'Lakshmi Dhevi' => 'shravankumar.sharma@galaxyweblinks.in', //'',
        'Madhu Sudhir' => 'shravankumar.sharma@galaxyweblinks.in', //'',
        'Radha Ganesh' => 'shravankumar.sharma@galaxyweblinks.in', //'radhapranic@gmail.com',
        'Raghu N' => 'shravankumar.sharma@galaxyweblinks.in', //'raghuheal@yahoo.co.in',
        'S K Singh' => 'shravankumar.sharma@galaxyweblinks.in', //'drsksingh05@gmail.com',
        'Sunita Ganeriwal' => 'shravankumar.sharma@galaxyweblinks.in', //'sunitaganeriwal@hotmail.com',
        'Vishakha Karnani' => 'shravankumar.sharma@galaxyweblinks.in', //'vishakhakarnani@yahoo.co.in'
    ];
    $trainer_email = isset($data[$trainer_name]) ? $data[$trainer_name] : '';
    if(is_email($trainer_email)) {
        $recipient = $recipient . ', '.$trainer_email;    
    }
    
    return $recipient;
}
add_filter( 'woocommerce_email_recipient_customer_completed_order', 'ypv_send_completed_email_to_trainer', 10, 2);