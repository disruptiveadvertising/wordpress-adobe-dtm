=== Search Discovery's Adobe DTM for Wordpress ===
Contributors: adamlytics
Tags: adobe dynamic tag manager, adobe dtm, dtm, tag manager, google analytics, analytics, web analytics
Requires at least: 3.0.1
Tested up to: 4.1
Stable tag: 1.1
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html

The Adobe DTM for WordPress plugin is the first WordPress plugin dedicated to setting up and configuring Adobe DTM on WordPress.

== Description ==

Adobe DTM is Adobe's tool for deploying it's Marketing Cloud tools or any other tags to a website.  The Adobe DTM for WordPress plugin is the first WordPress plugin dedicated to setting up and configuring Adobe DTM on WordPress.  This plugin will install the necessary DTM code on your WordPress site, with the option to have a customizable JSON data layer automatically built from your site's page and post data.

= Data Layer =

Adobe DTM for Wordpress can build a JSON data layer variable for you to enhance data collection.  The items that this plugin can insert into the data layer on the WordPress pages are:

* Post/Page Type
* Post/Page Sub Type
* Post/Page ID
* Post/Page Category Names
* Post/Page Tag Names
* Post/Page Author Names
* Post/Page Date
* Post/Page Title
* Post/Page Custom Fields
* Post/Page Count
* Search Term
* Number of Search Results
* Search Origin Page
* Logged-in Status
* Logged-in User Role
* Comment Count

The plugin will also allow you to rename the JavaScript variable for the data layer, as well as each sub object in the data layer.

== Installation ==

1. Upload the zip file via the 'Plugins' interface in WordPress
1. Activate the plugin
1. Go to Settings > Adobe DTM to configure the plugin

== Frequently Asked Questions ==

There are currently no frequently asked questions.

== Changelog ==

= 1.3 =
Updated code for servers with very strict PHP settings to prevent errors.  Also added a meta tag with name "adobe-dtm-wordpress" to easily identify if the plugin is installed successfully.

= 1.1 =
Code enhancements.

= 1.0 =
Out of beta with some additional features: Control over the data layer sub object names; new items in the data layer: page/post ID, page/post custom fields; split up grouped data layer items into their own configuration; ability to specify that DTM is already installed on the site, which will only include the data layer; ability to disable DTM for different user types, or even for guests.

= 0.1 =
First public beta.

== Upgrade Notice ==

= 1.1 =
Code enhancements.

= 1.0 =
New features for added customization and control.
1. Control over the data layer sub object names.
1. New items in the data layer: page/post ID, page/post custom fields.
1. Split up grouped data layer items into their own configuration.
1. Ability to specify that DTM is already installed on the site, which will only include the data layer.
1. Ability to disable DTM for different user types, or even for guests.

== Screenshots ==

1. This is the one configuration page for the Adobe DTM plugin.  It shows the options for entering the code file reference, as well as what can be automatically built into the data layer.

= 0.1 =
This is the first public beta, no upgrade is needed.
