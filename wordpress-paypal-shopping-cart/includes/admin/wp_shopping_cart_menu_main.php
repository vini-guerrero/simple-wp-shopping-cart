<?php

//Handle the admin dashboard main menu
add_action('admin_menu', 'wp_cart_options_page');

// Handle the options page display
function wp_cart_options_page() {

    add_options_page(__("WP Paypal Shopping Cart", "wordpress-simple-paypal-shopping-cart"), __("WP Shopping Cart", "wordpress-simple-paypal-shopping-cart"), WP_CART_MANAGEMENT_PERMISSION, 'wordpress-paypal-shopping-cart', 'wp_cart_options');

    //Main menu - Complete this when the dashboard menu is ready
    //$menu_icon_url = '';//TODO - use 
    //add_menu_page(__('Simple Cart', 'wordpress-simple-paypal-shopping-cart'), __('Simple Cart', 'wordpress-simple-paypal-shopping-cart'), WP_CART_MANAGEMENT_PERMISSION, WP_CART_MAIN_MENU_SLUG , 'wp_cart_options', $menu_icon_url);
    //add_submenu_page(WP_CART_MAIN_MENU_SLUG, __('Settings', 'wordpress-simple-paypal-shopping-cart'),  __('Settings', 'wordpress-simple-paypal-shopping-cart') , WP_CART_MANAGEMENT_PERMISSION, WP_CART_MAIN_MENU_SLUG, 'wp_cart_options');
    //add_submenu_page(WP_CART_MAIN_MENU_SLUG, __('Bla', 'wordpress-simple-paypal-shopping-cart'),  __('Bla', 'wordpress-simple-paypal-shopping-cart') , WP_CART_MANAGEMENT_PERMISSION, 'wspsc-bla', 'wp_cart_options');
}

/*
 * Main settings menu (it links to all other settings menu tabs). 
 * Only admin user with "manage_options" permission can access this menu page.
 */

function wp_cart_options() {
    if (!current_user_can('manage_options')) {
        wp_die('You do not have permission to access this settings page.');
    }

    $wpspc_plugin_tabs = array(
        'wordpress-paypal-shopping-cart' => __('General Settings', 'wordpress-simple-paypal-shopping-cart'),
        'wordpress-paypal-shopping-cart&action=email-settings' => __('Email Settings', 'wordpress-simple-paypal-shopping-cart'),
        'wordpress-paypal-shopping-cart&action=discount-settings' => __('Coupon/Discount', 'wordpress-simple-paypal-shopping-cart'),
        'wordpress-paypal-shopping-cart&action=tools' => __('Tools', 'wordpress-simple-paypal-shopping-cart')
    );
    echo '<div class="wrap">';
    echo '<h1>' . (__("WP Paypal Shopping Cart Options", "wordpress-simple-paypal-shopping-cart")) . '</h1>';

    $current = "";
    if (isset($_GET['page'])) {
        $current = sanitize_text_field($_GET['page']);
        if (isset($_GET['action'])) {
            $current .= "&action=" . sanitize_text_field($_GET['action']);
        }
    }
    $content = '';
    $content .= '<h2 class="nav-tab-wrapper">';
    foreach ($wpspc_plugin_tabs as $location => $tabname) {
        if ($current == $location) {
            $class = ' nav-tab-active';
        } else {
            $class = '';
        }
        $content .= '<a class="nav-tab' . $class . '" href="?page=' . $location . '">' . $tabname . '</a>';
    }
    $content .= '</h2>';
    echo $content;
    echo '<div id="poststuff"><div id="post-body">';
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'email-settings':
                include_once (WP_CART_PATH . 'includes/admin/wp_shopping_cart_menu_email_settings.php');
                show_wp_cart_email_settings_page();
                break;
            case 'discount-settings':
                include_once (WP_CART_PATH . 'includes/admin/wp_shopping_cart_menu_discounts.php');
                show_wp_cart_coupon_discount_settings_page();
                break;
            case 'tools':
                include_once (WP_CART_PATH . 'includes/admin/wp_shopping_cart_menu_tools.php');
                show_wp_cart_tools_menu_page();
                break;
        }
    } else {
        include_once (WP_CART_PATH . 'includes/admin/wp_shopping_cart_menu_general_settings.php');
        show_wp_cart_options_page();
    }
    echo '</div></div>';
    echo '</div>';
}

