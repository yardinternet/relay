=== Relay ===
Author: Verdant Studio
Author URI: https://www.verdant.studio
Contributors: verdantstudio
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 6.6
Requires PHP: 7.4
Stable tag: 1.1.0
Tags: monitor, monitoring, api
Tested up to: 6.8

A bridge between your WordPress site’s internals and your monitoring tools.

== Description ==

This general-purpose plugin provides safe, structured access to internal data, making it compatible with [Hub](https://www.verdant.studio/applications/hub/) and other monitoring solutions.

== Features ==

* Site name
* Site URL
* WordPress version
* Health rating
* Updates available
* Multisite and subsite information

== Documentation ==

You can find the [documentation](https://docs.verdant.studio/relay/) on our site.

== Installation ==

1. Upload `relay` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. You can find the api endpoints at `/wp-json/relay/v1/`.

== Screenshots ==

== Frequently Asked Questions ==

== Changelog ==

= 1.1.0: May 11, 2025 =

* Add: support for multisite and subsite information

= 1.0.0: May 9, 2025 =

* Initial release
