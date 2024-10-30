=== Plugin Name ===
Contributors: yorkstreetlabs
Donate link: https://yorkstreetlabs.com
Tags: form, contact form, connect
Requires at least: 4.1.32
Tested up to: 5.7.0
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Boffo is a twist on your traditional contact form.  It reveals subsequent steps as the visitor progresses through.  Boffo's goal is to make
your form more conversational, engaging and better converting.

== Description ==

Boffo is a free form plugin that allows you to replace standard from experiences with "flows" that help drive better converting engagements with your visitors.

= Full control =

Within the Wordpress administration portal you have full control to create as many flows as you need.  Once created, you can easily embed them within post, pages,
or custom post types using shortcodes or Gutenberg editor blocks.  All responses are captured under Boffo > Messages and a notification email is triggered to the
site administration email.

= Flow experience =

Boffo's unique form experience is based on steps.  Visitors are shown the initial question and configurable field with visual cues indicating the next step.  Once the visitor
completes all the steps in the flow they can then submit it.  After the flow is successfully saved a customizable message is shown to the visitor.

== Installation ==

This section describes how to install Boffo and get it working.

1. Upload `boffo.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Navigate to the Boffo menu item and then click "Add Flow" to get started
1. Complete your flow's settings and then add one to many steps
1. Once you save your flow, add into your page either by using a shortcode or by a Gutenberg editor block

== Frequently Asked Questions ==

= Are there any limits on how many flows I can make? =

There are no limits, feel free to build as many flows as you need.

= Do all steps require an answer? =

Yes, at the moment, the visitor must complete each step to submit the interaction.

= Where are confirmation messages sent? =

The admin email registered with your Wordpress installation will receive confirmation of each successful interaction.  We plan on making that 
a manageable field in the next release.

== Screenshots ==

1. This is a built flow available for public interaction
2. This is the list of flows in the Wordpress admin
3. This is the admin flow editor

== Changelog ==

= 1.0.1 =
* Fixes duplicate bug on initial flow save
* Fixes location of toast notification

= 1.0.0 =
* First release