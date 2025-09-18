=== Relay ===
Author: Verdant Studio
Author URI: https://www.verdant.studio
Contributors: verdantstudio
Donate link: https://www.buymeacoffee.com/verdantstudio
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 6.6
Requires PHP: 7.4
Stable tag: 1.4.0
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
* Directory sizes
* Multisite and subsite information
* WP-CLI command to activate plugin and generate an API key

== Documentation ==

You can find the [documentation](https://docs.verdant.studio/relay/) on our site.

== Installation ==

1. Upload `relay` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. You can find the api endpoints at `/wp-json/relay/v1/`.
4. For more detailed guidance, refer to the [documentation](https://docs.verdant.studio/relay/).

== Screenshots ==

== Frequently Asked Questions ==

== Changelog ==

= 1.4.0: Sep 18, 2025 =

* Add: apply 1 hour caching to directory sizes call
* Add: a WP-CLI command to activate the plugin and generate an api key
* Change: use the default WP transient for getting updates status
* Change: remove debug info attribute from directory sizes call

= 1.3.1: Jun 10, 2025 =

* Fix: use the correct option key on multisite installations

= 1.3.0: Jun 10, 2025 =

* Add: a settings page for inserting or generating an api key
* Change: rely on the custom api key instead of WordPress capabilities for api access
* Change: only allow plugin to be activated on the network of a multisite installation

= 1.2.0: Jun 5, 2025 =

* Add: info about directory sizes to the api
* Change: code improvements

= 1.1.0: May 11, 2025 =

* Add: support for multisite and subsite information

= 1.0.0: May 9, 2025 =

* Initial release
