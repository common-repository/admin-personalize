<?php
/**
 * Plugin Name:        Admin Personalize
 * Plugin URI:         http://www.ranosys.com/
 * Description:        Allows you to configure WordPress logo on login and register page and WordPress icon on WordPress dashboard, Remove WordPress setup version number, Hide WordPress Admin Bar and configure the default email address and name used for emails sent by WordPress
 * Version:            1.1
 * Author:             Deepak Soni (Ranosys Technologies Pte. Ltd.)
 * Author URI:         https://github.com/Deepak40/
 * Text Domain:        admin-personalize
 * License:            GPL-2.0+
 * License URI:        http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:        /languages
 * GitHub Plugin URI:  https://github.com/Deepak40/Admin-Personalize
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Require public files
 */
require_once( plugin_dir_path(__FILE__) . 'public/class-admin-personalize.php' );

/**
 * Register hooks that are fired when the plugin is activated.
 */
register_activation_hook(__FILE__, array('Admin_Personalize', 'activate'));

/**
 * Init.
 */
add_action('plugins_loaded', array('Admin_Personalize', 'get_instance'));

/**
 * Only load admin functionality in admin.
 */
if (is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX )) {
    require_once( plugin_dir_path(__FILE__) . 'admin/class-admin-personalize-admin.php' );
    add_action('plugins_loaded', array('Admin_Personalize_Admin', 'get_instance'));
}