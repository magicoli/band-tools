=== Band Tools ===
Contributors: magicoli69
Donate link: https://paypal.me/magicoli
Tags: music, bands, singers, albums, records, songs
Requires at least: 4.5
Tested up to: 6.2.2
Requires PHP: 5.6
Stable tag: 0.13.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Post types and tools for bands websites.

== Description ==

Post types and tools for bands. Allow publishing of records with songs list. Easy enough for a single band. Complete enough for several ones.

Although you can get this plugin for free, buying it will fund development and help providing future features.

= Goals =

I am a singer, and a web designer. There are many plugins and themes for bands out there, but I found none suiting my needs. Either way too complicate, either lacking features that seem essential to me.

I wanted something:

* very simple. Let's talk about bands, records and songs and link them together
* opened to my other needs: sell my records
* theme-agnostic
* e-commerce agnostic (although I focus first on WooCommerce integration, Easy Digital Downloads might follow)

= Features =

* "band", "record" and "song" post types, with relationships
* Bands, Records and Songs available for navigation menus
* Bands, Records and Songs can be used as home page (bands are allowed by default, others are activable in settings)
* Widgets, shortcodes and WPBakery blocks to display
  - album list with songs, buy link, player
  - related items (songs in displayed album, albums of displayed band...)
* Audio player for albums
  - Playlist for albums
  - Play button for each song in album
* Customizable layouts for bands, records and songs
* WooCommerce integration
  - Links to products or external shop page
  - Buy link, per album or per song

= Artists using this plugin =

* [Olivier van Helden](https://van-helden.net/)
* [Cendryn](https://cendryn.fr/)
* [Thierry Hodiamont](https://thierryhodiamont.be/)
* [Thierry Hercod](https://thierryhercod.com/)

== Roadmap ==

= Next moves =

* Better widgets: cleaner and more complete display (thumbnails for bands, direct buy or link, ...)
* Video player
* External product links (to specific online store and common distribution platforms)
* Guttenberg Blocks
* Automatic submenus for bands, records and songs

= Future plans =

* Video playlists for songs from YouTube, Vimeo etc.
* Crowdfunding based on WC sales (might be in a separate plugin)
* Links between different Band Tools enabled websites
* Events
* Network / Multisite integration

== Installation ==

1. Get latest stable release from [magiiic.com](https://magiiic.com/updates/?action=download&slug=band-tools)
   or install from command-line `wp plugin install 'https://magiiic.com/updates/?action=download&slug=band-tools'`
2. Head to "Band Tools" admin menu and check settings
3. Create at least one Band, then records and then songs at will
4. Enjoy

== Frequently Asked Questions ==

= Where can I find support/help? =

You can submit bugs, feature requests, questions and suggestions in the "Issues" section of [GitHub repository](https://github.com/magicoli/band-tools).

= Who are you? =

I'm a singer, I'm a grinner, I'm a joker, I'm a midnight coder.

== Screenshots ==

1. My mic, not a screenshot but the origin of all these needs.

== Changelog ==

= 0.13.2 =
* fix undefined variable $prefix warning

= 0.13.1 =
* added examples to readme

= 0.13 =
* added settings to toggle record list elements
* added thumbnail to record list
* added support link to readme (fix issue #41)
* fix song page: when band is not set, the song title is displayed instead
* fix song list duplicated instead of showing record title + list

= 0.12 =
* new details action link in lists
* new option to show player in tracks list
* use ajax to stay in page on add to cart
* fix: don't show buy link if woocommerce is not active
* fix errors in previous merge
* fix #89 add to cart cancelled if track product is same as record product (for singles)
* fix #86 update tracks buy link when their record is added to cart with ajax
* fix #65 remove songs already in cart when their album is added
* fix #74 regression: next song in playlist not played
* fix #64: disallow buy song if album already in cart

= 0.11 =
* add play link in list when an audio sample is available
* add buy link to record if a product is linked
* add buy links in lists if a product is linked
* added player in songs lists and play link for each song
* show player for each record
* fix get_cart() crash when saving song
* regression: revert dev changes breaking functionalties

= 0.9.9 =
* new wpbakery blocs
* added customizer panel (fix #47)
* added audio sample field
* added shorcode "id" attribute to display info of a specific item
* added "buy" link to songs and records lists
* added 'Buy' link in songs lists (fix #59)
* added song-product relationship
* changed icons colors
* changed "Cart" to "View cart" for already purchased items
* allow edit records relations in products
* tested up to wp 5.8
* fixed #68 disable buy link if already in cart
* fix wc notices not displayed on standard pages
* fix #67 add to cart short code not rendered
* fix missing song info metaboxes
* fix #50 video shown as url instead of embed (content was not processed)
* fix #8 flex causing mess in edit pages

= 0.8.5 =
* added update process
* added band official website and official store (implements #29)
* added record release type
* added song authors
* added options to show official links or not
* fix authors list not displayed
* fix Fatal error introduced in a04e95512275b4007a43d3d159d6bed46a45faf0
* change: 'album' post type is changed to 'record'
  Existing menus or customizations might require a manual update

= 0.7.14 =
* added product relationship (fix issue #9)
* added settings to toggle info under content
* added options to display info under title
* fix issue #5 title suffix added to breadcrumbs
* fix meta-box license notice
* fix singular form not detected before post type creation
* fix meta-box license notice
* fix multiple option returned as true when all of them are disabled
* fix flex blocks only in band tools edit or settings pages

= 0.7.13 =
* fix permalinks and css refresh on activation, update and deactivation
* fix show subtitle only under main page title
* added styling to infobox prefixes and suffixes

= 0.7.12 =
* fix numbered list type

= 0.7.10 =
* added prefix and suffix for bndtls_get_meta and bndtls_get_relations
* renamed build_relationships to bndtls_get_relations

= 0.7.9 =
* added genre under title for bands, records, songs
* added band under title for records and songs
* added band info fields
* show infoboxes as grid on frontend
* show custom fields blocks as grid

= 0.7.8 =
* fix oops, I disabled autoload when I removed afragen...
* removed afragen libraries, including own deps (previously it was just disabled)

= 0.7.7 =
* fix chatty error log when no bands, records or songs exist yet
* removed afragen dependency installer, too resource hungry

= 0.7.6 =
* updated shortcodes for mb framework
* updated 'all' widget for mb framework (not all, only the one called 'all'). Other ones are updated but not functional yet
* added style hierarchy to nested infobox
* added shorcodes memo to dashboard
* added option to disable plugin templates

= 0.7.5 =
* fix function remove_meta_box_menu redeclared

= 0.7.4 =
* fix debug code left on output

= 0.7.3 =
* added single/plural form to relationships
* improved get title from relationship instead of post type
* fix wrong result when asking a sub option and none set
* fix front page display for custom types
* fix plural in translations
* don't show title in nested infoboxes

= 0.7.2 =
* added front page settings
* added template for band when selected as home page
* fix current page display in infoboxes
* fix regression singular/plural bands, records, groups
* fix regression: preferences not read for clean titles, single-archive redirect, widget area
* fix Dashboard submenu name

= 0.7 =
* new custom content template: show parent and child related items band/records, band/songs, records/songs
* new plugin templates: single-[slug].php content-single-[slug].php content-archive-[slug].php ([slug] is bands, records or songs)
* added mb-custom-post-type and mb-relationships libraries
* added relations in list view
* enhancement css refresh after update (use plugin version for css enqueue)
* disable metabox menu if only bundled (when actual plugin is not active)
* fix special characters display in custom post strings translations (removed esc_html filter)
* fix PHP warning (remove_menu_page invoked with admin_init instead of admin_menu)
* fix bad location for includes/woocommerce.php

= 0.6 =
* intermediate version: partially migrated to meta-box, but acf is still needed for some stuff
* new allow to select group as home page
* added meta-box, meta-box-group and mb-settings-page libraries
* added afragen/wp-dependency-installer library
* migrated dependencies check to afragen library
* spring cleaning

= 0.5.14 =
* tested up to WP 5.7
* new shortcode to display related objects
* new catch-all widget with all relations
* new function to build shortcode and widget content
* changed Plugin Name to "Band Tools", instead of "Bands Tools", to match slug
* added license key support
* added widget styling
* exclude development and source files from .zip release
* lighter assets
* fix dependencies check conflict with other plugins
* fix unset array php warning
* fix widget duplicate ids
* fix widget nested id
* fix wppus-hide-licence-warnings.js conflict with other plugins using it
* fix installRow and licenseRow inversion
* fix add_option fired too early and causing crash
* constants for common values
* added songs per record view

= 0.4.4 =
* new automatic singular or plural post names for archives and menus
* new settings custom post naming
* added redirection for archives containing a single post
* added "Custom sidebars" to recommended plugins
* added page-attributes support
* added widget area (currently depends on theme customizaton or external plugin)
* fix missing install link for recommended plugins
* added videos to singular/plural names

= 0.3 - 0.3.9 =
* added band, record, song, video categories
* added standard tags to all types without custom tags
* added post-formats support
* added video post type
* added video widget
* added recommended plugins to settings page
* added clean titles option fo Categories, Archives, Taxonomies, Authors, Taxes
* added translation template and French localisation
* udpate load WooCommerce fields only if WC is active
* fix settings pages translations: load textdomain before acf fields definition

= 0.2.4 =
* added: dependency check
* fix: flush permalinks on activate
* updated: widget titles in singular or plural form
* cleanup custom types, objects and functions names

= 0.2.0 =
Basicly functional
* Band, Record and Song post types
* Relations between Bands, Records and songs
* Widgets with links to related objects
