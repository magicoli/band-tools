# Band Tools
* Contributors: magicoli69
* Donate link: https://paypal.me/magicoli
* Tags: comments, spam
* Requires at least: 4.5
* Tested up to: 5.6.2
* Requires PHP: 5.6
Stable tag: 0.1.0
* License: GPLv2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html

Basic post types and tools for a simple band website.

## Description

A basic post types and tools for bands. Allow publishing of albums with songs
list. Easy enough for a single band. Complete enough for several ones.

### Goals

I am a singer, and a web designer. There are many plugins and themes for bands
out there, but I found none suiting my needs. Either way too complicate, either
lacking essential features for me.

I want something:

* very simple. Let's talk about bands, albums and songs and link them together
* opened to my other needs: sell my albums
* theme-agnostic
* e-commerce agnostic (although I focus first on WooCommerce integration)

### Features

* Linked post types for bands, albums, themes and videos
* Links to WooCommerce products
* Widget to show related items. On a song page, it display the band, the albums
  it appears on, related videos. On the band page it displays the albums and the
  songs. Etc.
* The album pages also display link to shop product page
* Post types available for navigation menus

### Next moves

* Better widgets: cleaner and more complete display (thumbnails for albums and bands, direct buy or link, player...)
* Video player
* Guttenberg Blocks
* Shortcodes for integration anywhere
* Specific post-types templates
* Extended WooCommerce integration (add to cart buttons)

### Future plans

* Audio playlists for albums and songs, uploaded locally
* Video playlists for songs from YouTube, Vimeo etc.
* Crowdfunding based on WC sales (might be in a separate plugin)

## Installation

1. Unzip `band-tools.zip` into the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Head to "Band Tools" admin menu and check settings
4. Create at least one Band, then songs and albums at will
5. Enjoy

## Frequently Asked Questions

### Who are you?

I'm a singer, I'm a grinner, I'm a joker, I'm a midnight coder.

## Screenshot

1. This is not an actual screenshot, I'll add one when there is something cool
to show

## Changelog

### 0.5.3
* added hide action link for license key in Plugins list, hidden if
* changed Plugin Name to "Band Tools", instead of "Bands Tools", to match slug

### 0.5.2
* fix add_option fired too early and causing crash

### 0.5.1
* added license key support
* fixed "Recommended plugins" title shown when no recommendations

### 0.5
* new shortcode to display related objects
* new catch-all widget with all relations
* new function to build shortcode and widget content
* added songs per album view

### 0.4.4
* fix missing install link for recommended plugins

### 0.4.3
* added "Custom sidebars" to recommended plugins
* added page-attributes support
* added widget area (currently depends on theme customizaton or external plugin)
* disabled templates until they're ready

### 0.4.2
* added redirection for archives containing a single post

### 0.4.1
* added videos to singular/plural names

### 0.4
* new settings custom post naming
* new automatic singular or plural post names for archives and menus

### 0.3.9
* added band, album, song, video categories
* added standard tags to all types without custom tags
* added post-formats support

### 0.3.6
* added video post type
* added video widget
* added recommended plugins to settings page
* udpate load WooCommerce fields only if WC is active
* fix settings pages translations: load textdomain before acf fields definition

### 0.3.5
* added clean titles option fo Categories, Archives, Taxonomies, Authors, Taxes
* added translation template and French localisation

### 0.2.4
* added: dependency check
* fix: flush permalinks on activate
* updated: widget titles in singular or plural form
* cleanup custom types, objects and functions names

### 0.2.0
Basicly functional
* Band, Album and Song post types
* Relations between Bands, Albums and songs
* Widgets with links to related objects
