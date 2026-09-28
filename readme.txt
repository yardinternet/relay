=== Relay ===
Author: Verdant Studio
Author URI: https://www.verdant.studio
Contributors: verdantstudio
Donate link: https://www.buymeacoffee.com/verdantstudio
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 6.6
Requires PHP: 7.4
Stable tag: 1.5.1
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
* Installed plugins (version, activation and update state)
* Directory sizes
* Multisite and subsite information
* WP-CLI support
* Consumer-supplied extra data (via filter or `wp option`)

== Documentation ==

You can find the [documentation](https://www.verdant.studio/plugins/relay/) on our site.

== Installation ==

1. Upload `relay` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. You can find the api endpoints at `/wp-json/relay/v1/`.
4. For more detailed guidance, refer to the [documentation](https://www.verdant.studio/plugins/relay/).

== Screenshots ==

== Frequently Asked Questions ==

= Where can I find the documentation? =

You can find the documentation at: [verdant.studio/plugins/relay](https://www.verdant.studio/plugins/relay/ "Relay Documentation")

== Changelog ==

= 1.5.1: Sep 18, 2025 =

* Change: remove WP-CLI command to activate (can use wp plugin activate instead)
* Fix: WP-cli take multisite options into account
* Fix: return warning if the api key is not present

= 1.5.0: Sep 18, 2025 =

* Add: WP-cli command to get the current api key

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
