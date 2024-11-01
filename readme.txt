=== User Role Management ===
Contributors: luigimuzy, yurisa
Donate link:
Tags: user, user role, management, user management.
Requires at least: 5.2.2
Tested up to: 5.4.2
Stable tag: 2.0.1
Requires PHP: 7.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

This plugin allows you to manage allowed content for users, so as to access only allowed content.

User Role Management was developed to be used in virtual products, linking a created post referring to the content of the product sold.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/user-role-management` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->Plugin Name screen to configure the plugin
4. Below are instructions and information on how the plugin works in detail:

  When installed, the plugin automatically creates all user roles by reference to the Woocommerce product id
  (Ex: subscriber-4032, where 4032 is the id of a virtual product and the "subscriber" is the characteristic of the user).

  From this moment on, the plugin is waiting for the default time that users will have to access the purchased content.
  This setting occurs after reading this guide.

  Once completed, the plugin will be ready to take over.
  It checks for orders where the access limit has  been exceeded
  (takes into account the date the order was paid) and removes user access (roles).

  Also checks for orders where the access limit has not been exceeded.
  If so, verify that the user corresponding to the purchase has the appropriate permissions (roles).
  If so, the request is ignored. If not, the plugin adds as permissions (roles).

5. You will need set the default time  (in days) that users will have access to purchased content in plugin seetings (will be created a new menu icon called User Role Manegement)

== Frequently Asked Questions ==

= Do I need another plugin to help User Role Management to control user roles? =

It depends on what you want.
If you want private posts to be read by all customers who purchase any virtual products, the plugin will serve without the help of another plugin.
However if you want the plugin to show only the private post that corresponds to the product purchased by the customer another plugin will be needed. In our tests, the easiest to deal with is the MEMBERS plugin that allows you to configure directly from posts which roles can see the post.

Like you know, this plugin make exclusive the posts to users that bougth it (subscriber-**** roles).
If you have more than 1 virtual product in more than 1 post, all users that have a subscriber role will can see the private posts.

= I wish give post read permission only to users who purchase that product. How do I do? =

If you wish to give permission only to users who purchase their product so that other users cannot access the private posts, we recommend installing the Members
plugin which enables the desired configuration. Just indicate who can access private posts (the roles) while they are being created.

== Screenshots ==

1. New menu icon created
2. Plugin configuration accessed by menu icon created

== Changelog ==

= 1.0.1 =
*Release Date - 09 December 2019*

* Tested in WordPress version 5.3 .

= 1.0 =
* create roles for virtual products.

== Upgrade Notice ==

= 1.0.1 =
Updated for WP5.3.

= 1.0 =
Simple but necessary upgrade.
