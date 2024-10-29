<?php

/**
 * Admin Personalize Admin Class
 *
 * This class is used to work with the
 * administrative side of the WordPress site.
 */
class Admin_Personalize_Admin {

    /**
     * Instance of this class.
     *
     * @since  1.0
     *
     * @var    object
     */
    protected static $instance = null;

    /**
     * Slug of the plugin screen.
     *
     * @since  1.0
     *
     * @var    string
     */
    protected $plugin_screen_hook_suffix = null;

    /**
     * Initialize the plugin by loading admin scripts & styles and adding a
     * settings page and menu.
     *
     * @since  1.0
     */
    private function __construct() {

	// Get plugin slug
	$plugin = Admin_Personalize::get_instance();
	$this->plugin_slug = $plugin->get_plugin_slug();

	// Setup default options
	add_action('admin_init', array($this, 'setup_default_options'));

	// Add the options page and menu item.
	add_action('admin_menu', array($this, 'add_plugin_admin_menu'));

	// Register settings fields
	add_action('admin_init', array($this, 'settings'));

	// Add an action link pointing to the settings page.
	$this->plugin_basename = plugin_basename(plugin_dir_path(__DIR__) . $this->plugin_slug . '.php');
	add_filter('plugin_action_links_' . $this->plugin_basename, array($this, 'add_action_links'));
	add_filter('plugin_row_meta', array($this, 'plugin_row_meta'), 10, 4);
    }

    /**
     * Setup default options.
     *
     * @since  1.0
     */
    public function setup_default_options() {
	add_option('admin_personalize_override_default', 1);
	add_option('admin_personalize_override_admin', 1);
    }

    /**
     * Return an instance of this class.
     *
     * @since   1.0
     *
     * @return  object  A single instance of this class.
     */
    public static function get_instance() {

	// If the single instance hasn't been set, set it now.
	if (null == self::$instance) {
	    self::$instance = new self;
	}

	return self::$instance;
    }

    /**
     * Register administration menus.
     *
     * @since  1.0
     */
    public function add_plugin_admin_menu() {

	// Add a settings page to the Settings menu
	$this->plugin_screen_hook_suffix = add_options_page(
		__('Admin Personalize', 'admin-personalize'), __('Admin Personalize', 'admin-personalize'), 'manage_options', $this->plugin_slug, array($this, 'display_plugin_admin_page')
	);
    }

    /**
     * Render the settings page.
     *
     * @since  1.0
     */
    public function display_plugin_admin_page() {
	include_once( 'views/admin.php' );
    }

    /**
     * Settings API.
     *
     * @since  1.0
     * 
     * updated on version 1.1
     */
    public function settings() {
	add_settings_section(
		'admin_personalize', '', array($this, 'settings_section'), 'admin_personalize'
	);
	add_settings_field(
		'admin_personalize_name', __('From Name', 'admin_personalize'), array($this, 'admin_personalize_name_field'), 'admin_personalize', 'admin_personalize'
	);
	add_settings_field(
		'admin_personalize_email', __('From Email Address', 'admin_personalize'), array($this, 'admin_personalize_email_field'), 'admin_personalize', 'admin_personalize'
	);
	add_settings_field(
		'admin_personalize_override', __('Override Emails From', 'admin_personalize'), array($this, 'admin_personalize_override_fields'), 'admin_personalize', 'admin_personalize'
	);

	add_settings_field(
		'admin_personalize_remove_wp_version', __('Remove WordPress Version', 'admin_personalize'), array($this, 'admin_personalize_remove_wp_version_field'), 'admin_personalize', 'admin_personalize'
	);

	add_settings_field(
		'admin_personalize_hide_admin_bar', __('Hide WordPress Admin Bar', 'admin_personalize'), array($this, 'admin_personalize_hide_admin_bar_field'), 'admin_personalize', 'admin_personalize'
	);

	add_settings_field(
		'admin_personalize_configure_wp_logo', __('Configure WordPress Logo', 'admin_personalize'), array($this, 'admin_personalize_configure_wp_logo_field'), 'admin_personalize', 'admin_personalize'
	);

	add_settings_field(
		'admin_personalize_custom_css_for_wp_logo', __('WordPress Logo\'s Width', 'admin_personalize'), array($this, 'admin_personalize_custom_css_for_wp_logo_field'), 'admin_personalize', 'admin_personalize'
	);

	add_settings_field(
		'admin_personalize_configure_wp_icon', __('Configure WordPress Icon', 'admin_personalize'), array($this, 'admin_personalize_configure_wp_icon_field'), 'admin_personalize', 'admin_personalize'
	);

	register_setting('admin_personalize', 'admin_personalize_name', array($this, 'sanitize_admin_personalize_name'));
	register_setting('admin_personalize', 'admin_personalize_email', 'is_email');
	register_setting('admin_personalize', 'admin_personalize_override_default', 'absint');
	register_setting('admin_personalize', 'admin_personalize_override_admin', 'absint');

	register_setting('admin_personalize', 'admin_personalize_remove_wp_version', 'absint');

	register_setting('admin_personalize', 'admin_personalize_hide_admin_bar', 'absint');

	register_setting('admin_personalize', 'admin_personalize_configure_wp_logo', 'image');

	register_setting('admin_personalize', 'admin_personalize_custom_css_for_wp_logo', 'text');

	register_setting('admin_personalize', 'admin_personalize_configure_wp_icon', 'image');
    }

    /**
     * Sanitize Mail From Name.
     *
     * Strips out all HTML, scripts, etc...
     *
     * @since   1.0
     *
     * @param   string  $val  Name.
     * @return  string        Sanitized name.
     */
    public function sanitize_admin_personalize_name($val) {
	return wp_kses($val, array());
    }

    /**
     * Admin Personalize Settings Section.
     *
     * @since  1.0
     */
    public function settings_section() {
	echo '<h4>' . __('By using following  settings you can configure WordPress\'s default Form Name, Form Email, WP logo, Wp Icon, Remove WP Version, Hide Admin Bar etc.', 'admin-personalize') . '</h4>';
    }

    /**
     * Mail From Name Field.
     *
     * @since  1.0
     */
    public function admin_personalize_name_field() {
	echo '<input name="admin_personalize_name" type="text" id="admin_personalize_name" value="' . esc_attr(get_option('admin_personalize_name', '')) . '" class="regular-text" />';
    }

    /**
     * Mail From Email Field.
     *
     * @since  1.0
     */
    public function admin_personalize_email_field() {
	echo '<input name="admin_personalize_email" type="text" id="admin_personalize_email" value="' . esc_attr(get_option('admin_personalize_email', '')) . '" class="regular-text" />';
    }

    /**
     * Mail From Override Fields.
     *
     * @since  1.0
     */
    public function admin_personalize_override_fields() {
	$wp_mailfrom = Admin_Personalize::get_instance();
	$email = $wp_mailfrom->get_default_from();
	echo '<label><input name="admin_personalize_override_default" type="checkbox" id="admin_personalize_override_default" value="1"' . checked(1, get_option('admin_personalize_override_default', 0), false) . ' /> ' . esc_html__('Default WordPress Email', 'admin-personalize') . ' <span class="description">(' . esc_html($email) . ')</span></label><br />';
	echo '<label><input name="admin_personalize_override_admin" type="checkbox" id="admin_personalize_override_admin" value="1"' . checked(1, get_option('admin_personalize_override_admin', 0), false) . ' /> ' . esc_html__('Admin Email', 'admin-personalize') . ' <span class="description">(' . esc_html(get_option('admin_email')) . ')</span></label><br /><br />';
	echo '<p>' . __('If set, these two options will override the default name and email address in the &quot;From&quot; header on emails sent by WordPress.', 'admin-personalize') . '</p>';
	echo '<span style="padding:20px 0px 40px 0px;"><hr></span>';
    }

    /**
     * Remove WP Version Field.
     *
     * @since  1.0
     */
    public function admin_personalize_remove_wp_version_field() {
	echo '<label><input name="admin_personalize_remove_wp_version" type="checkbox" id="admin_personalize_remove_wp_version" value="1"' . checked(1, get_option('admin_personalize_remove_wp_version', 0), false) . ' /> ' . esc_html__('Hide WordPress Version', 'admin-personalize') . '</label><br /><br />';
	echo '<p>' . __('If set, this option will remove WordPress version.', 'admin-personalize') . '</p>';
	echo '<span style="padding:20px 0px 40px 0px;"><hr></span>';
    }

    /**
     * Hide WP Admin Bar Field.
     *
     * @since  1.0
     */
    public function admin_personalize_hide_admin_bar_field() {
	echo '<label><input name="admin_personalize_hide_admin_bar" type="checkbox" id="admin_personalize_hide_admin_bar" value="1"' . checked(1, get_option('admin_personalize_hide_admin_bar', 0), false) . ' /> ' . esc_html__('Hide WordPress Admin Bar', 'admin-personalize') . '</label><br /><br />';
	echo '<p>' . __('If set, this option will hide WordPress &quot;Admin Bar&quot; from frontend.', 'admin-personalize') . '</p>';
	echo '<span style="padding:20px 0px 40px 0px;"><hr></span>';
    }

    /**
     * Configure WP logo Field.
     *
     * @since  1.0
     */
    public function admin_personalize_configure_wp_logo_field() {
	?>
	<label for="admin-personalize-configure-wp-logo"></label>
	<?php
	if (!empty(get_option('admin_personalize_configure_wp_logo'))) {
	    ?>
	    <img class="custom_media_image" src="<?php echo get_option('admin_personalize_configure_wp_logo'); ?>" 
	         style="margin:0;padding:10px 0;max-width:100px;display:block" />
	     <?php } ?>

	<input type="text" class="img" name="admin_personalize_configure_wp_logo" id="admin-personalize-configure-wp-logo" value="<?php
	if (!empty(get_option('admin_personalize_configure_wp_logo'))) {
	    echo get_option('admin_personalize_configure_wp_logo');
	}
	?>">

	<input type="button" value="<?php _e('Upload Image', 'admin-personalize'); ?>" class="button select-img"  /><br/><br/>

	<?php
	echo '<p>' . __('If set, this option will override the default WordPress logo on &quot;Login Panel&quot;.', 'admin-personalize') . '</p>';
    }

    /**
     * Configure WP logo's width Field.
     *
     * @since  1.1
     */
    public function admin_personalize_custom_css_for_wp_logo_field() {
	?>
	<label for="admin-personalize-configure-wp-logo-width"></label>

	<input type="number" name="admin_personalize_custom_css_for_wp_logo" id="admin-personalize-configure-wp-logo-width" value="<?php
	       if (!empty(get_option('admin_personalize_custom_css_for_wp_logo'))) {
		   echo get_option('admin_personalize_custom_css_for_wp_logo');
	       }
	       ?>"> <span> px </span>
	<?php
	echo '<p>' . __('If set, this option will override the default WordPress logo\'s width on &quot;Login Panel&quot;.<br> If you remain empty, then it will take 84px width, same as WordPress Logo.', 'admin-personalize') . '</p>';
	echo '<span style="padding:20px 0px 40px 0px;"><hr></span>';
    }

    /**
     * Configure WP icon Field.
     *
     * @since  1.0
     */
    public function admin_personalize_configure_wp_icon_field() {
	?>
	<label for="admin-personalize-configure-wp-icon"></label>
	<?php
	if (!empty(get_option('admin_personalize_configure_wp_icon'))) {
	    ?>
	    <img class="custom_media_image" src="<?php echo get_option('admin_personalize_configure_wp_icon'); ?>" 
	         style="margin:0;padding:10px 0;max-width:100px;display:block" />
	     <?php } ?>

	<input type="text" class="img" name="admin_personalize_configure_wp_icon" id="admin-personalize-configure-wp-icon" value="<?php
	     if (!empty(get_option('admin_personalize_configure_wp_icon'))) {
		 echo get_option('admin_personalize_configure_wp_icon');
	     }
	     ?>">
	<input type="button" value="<?php _e('Upload Image', 'admin-personalize'); ?>" class="button select-img"  /><br/><br/>

	<?php
	echo '<p>' . __('If set, this option will override the default WordPress icon on &quot;Dashboard&quot;.', 'admin-personalize') . '</p>';
	echo '<span style="padding:20px 0px 40px 0px;"><hr></span>';
    }

    /**
     * Add settings action link to the plugins page.
     *
     * @since  1.0
     */
    public function add_action_links($links) {
	return array_merge(
		array(
	    'settings' => '<a href="' . admin_url('options-general.php?page=' . $this->plugin_slug) . '">' . esc_html__('Settings', 'admin-personalize') . '</a>'
		), $links
	);
    }

    /**
     * Plugin Row Meta
     *
     * Adds documentation, support and issue links below the plugin description on the plugins page.
     *
     * @since   1.0
     *
     * @param   array   $plugin_meta  Plugin meta display array.
     * @param   string  $plugin_file  Plugin reference.
     * @param   array   $plugin_data  Plugin data.
     * @param   string  $status       Plugin status.
     * @return  array                 Plugin meta array.
     */
    public function plugin_row_meta($plugin_meta, $plugin_file, $plugin_data, $status) {
	if ($this->plugin_basename == $plugin_file) {
	    $plugin_meta[] = sprintf('<a href="%s">%s</a>', 'https://github.com/Deepak40/Admin-Personalize', esc_html__('GitHub', 'admin-personalize'));
	    $plugin_meta[] = sprintf('<a href="%s">%s</a>', esc_url(__('http://wordpress.org/support/plugin/admin-personalize', 'admin-personalize')), esc_html__('Support', 'admin-personalize'));
	}
	return $plugin_meta;
    }

}
