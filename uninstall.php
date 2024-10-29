<?php

/**
 * Fired when the plugin is uninstalled.
 */

// If uninstall not called from WordPress, then exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Delete options
delete_option('admin_personalize_name');
delete_option('admin_personalize_email');
delete_option('admin_personalize_override_default');
delete_option('admin_personalize_override_admin');
delete_option('admin_personalize_remove_wp_version');
delete_option('admin_personalize_hide_admin_bar');
delete_option('admin_personalize_configure_wp_logo');
delete_option('admin_personalize_configure_wp_icon');
delete_option('admin_personalize_custom_css_for_wp_logo');

