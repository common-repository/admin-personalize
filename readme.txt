=== Admin Personalize ===
Contributors: deepak040
Donate link: http://www.ranosys.com/
Tags: mail from, from email, email from, from address, mail, email, smtp, from address, email address, from header, wordpress icon, wordpress logo, backend icon, backend logo, register form logo, login form logo
Requires at least: 3.5
Tested up to: 4.8
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

* Allows you to configure the default email address and sender name used for emails sent by WordPress.

* Allows you to configure the Wordpress logo on login and register page and wordpress icon on WordPress Dashboard.

* Allows you to hide wordpress version number and prevent online tools to detect your website is a Wordpress site.

* Allows you to hide wordpress admin bar from frontend.

== Description ==

1. This plugin allows you to set the email address and name used on email sent by WordPress by setting the *From:* header.

It is an updated and fully re-worked version of the [WP Mail From](http://wordpress.org/extend/plugins/wp-mailfrom/) plugin by Tristan Aston and now works with the latest versions of WordPress.

2. This plugin allows you to configure the Wordpress logo on login and register page by setting the *Wordpress Logo:* header.

3. This plugin allows you to configure the Wordpress icon on Dashbord by setting the *Wordpress icon:* header.

4. This plugin allows you to remove version no of WordPress by setting the *Remove Wordpress setup Information:* header.

5. This Plugin allows you to hide Admin Bar from wordpress frontend.

6. This plugin allows you to change width of WordPress custom logo on login panel.

* Adds a "Admin Personalize" section in the "Settings" menu.
* The plugin uses the filter hooks `admin_personalize_from` and `admin_personalize_from_name`.
* The priority for the hooks is set to 1 to allow for other plugins that may hook these with the default priority of 10 to override this plugin.

== Installation ==

Either install via the WordPress admin plugin installer or...

1. Unzip `admin-personalize.zip` in the `/wp-content/plugins/` directory, making sure the folder is called `admin-personalize`.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Visit the admin settings page `Settings > Admin Personalize` and save your preferred name and email address.


= Upgrading from the old WP Mail From plugin =

This version is pretty much a complete re-write, fixes loads of bugs and works with the most recent versions of WordPress.

If upgrading from the [WP Mail From](http://wordpress.org/extend/plugins/wp-mailfrom/) plugin your current name an email settings should be copied across but please check.
To upgrade simply activate this plugin then deactivate the old WP Mail From plugin.

You should now use:

`get_option( 'admin_personalize_name' );
get_option( 'admin_personalize_email' );`


== Frequently Asked Questions ==

= Why does the From address still show as the default or show up as 'sent on behalf of' the default address? =

Possibly your mail server has added a *Sender:* header or is configured to always set the *envelope sender* to the user calling it.

= Why are emails not being sent? =

Some hosts may refuse to relay mail from an unknown domain. See [http://trac.wordpress.org/ticket/5007](http://trac.wordpress.org/ticket/5007) for more details.

== Screenshots ==

1. ScreenShot I
2. ScreenShot II

== Changelog ==

= 1.1 =

* Add options to change width of Wordpress logo on login panel.

= 1.0 =

* Add options to override default WordPress email address and admin email address.
* Add option to configure the Wordpress logo on login and register page and wordpress icon on WordPress Dashboard.
* Add option to hide wordpress version number and prevent online tools to detect your website is a Wordpress site.
* Add option to hide wordpress admin bar from frontend.

* Added 'admin_personalize_default_from' filter so you can add compatibility if the pluggable wp_mail() function is altered to use a different default email address.
* Delete plugin options when uninstalled.
* Reworked as a singleton class.
* Remove filter support for original WP MailFrom plugin.

* Only set email address and name if overwriting the default WordPress values.

* Pretty much re-coded from scratch - now based around a core Admin Personalize class.
* Uses the [WordPress Settings API](http://codex.wordpress.org/Settings_API).
* Stores name and email as `admin_personalize_name` and `admin_personalize_email` options. Upgrade support provided for old options.

== Upgrade Notice ==

= 1.1 =

* Added options to change width of Wordpress logo on login panel.

= 1.0 =

Added options to override default WordPress email addresses and added 'admin_personalize_default_from' filter.
Added option to configure the Wordpress logo on login and register page and wordpress icon on WordPress Dashboard.
Added option to hide wordpress version number and prevent online tools to detect your website is a Wordpress site.
Added option to hide wordpress admin bar from frontend.

This version is pretty much a complete re-write, fixes loads of bugs and works with the most recent versions of WordPress.
If upgrading from the [WP Mail From](http://wordpress.org/extend/plugins/wp-mailfrom/) plugin your current name an email settings should be copied across but please check.
