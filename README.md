# Bands Tools
Contributors: magicoli69
Donate link: https://paypal.me/magicoli
Tags: comments, spam
Requires at least: 4.5
Tested up to: 5.6.2
Requires PHP: 5.6
Stable tag: 0.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

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

### 0.3.7
* updated readme
* updated readme

### 0.3.6
* added video post type
* added video widget
* added recommended plugins to settings page
* fix load WooCommerce fields only if WC is active
* fix force translations load before acf fields definition, otherwise some are lost
* fix textdomain in settings pages

### 0.3.5
* added clean titles option fo Categories, Archives, Taxonomies, Authors, Taxes
* added translation template and French localisation
* fix hardcoded menu icon directories

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

### 0.1.1
Initial, useless version
