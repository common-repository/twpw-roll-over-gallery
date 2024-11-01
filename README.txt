=== TWPW Roll Over Gallery ===
Contributors: CharlyLeetham MorganLeetham
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9PSTVRWZYUKHY
Tags: comments, spam, remote comment spam
Requires at least: 3.3
Tested up to: 3.4.2
Stable tag: 1.0
License: GPLv2

Create a Roll Over Image gallery to display text

== Description ==

Creates an Image Gallery to display specific text when the image is clicked.  Uses Custom Post Types and a shortcode to create the "gallery".

== Installation ==

This section describes how to install the plugin and get it working.
1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

To add a Roll Over Gallery item to your site navigate to Roll Over Gallery -> Add new Roll Over Gallery.

Multiple Galleries may be displayed by using 'categories' to separate the entries. 

The four parts of a Roll Over Gallery are
 - The Title
 - The Content
 - The Featured Image
 - Category
 
The Title should be the name of the Roll Over Gallery, this will be displayed as the "title" attribute on the image in the gallery.

The content is the information to be displayed in the text panel.  It can be formatted as you like and you can include images in the box. 

The Featured Image is the image that will be displayed in the gallery. 
To set the featured image click the "Set featured image" link in the right hand sidebar of the edit panel. 
In the window that appears click "Select Files" and navigate to where the image you want as the image is located on your computer. 
Choose the file and click open. Once the image is uploaded click the "Set as featured image" link in the bottom of the popup.

Add / Select a Category that this image and content appears in.


To display a Gallery on a post or page use the shortcode [twpw_show_rog]. The shortcode takes the following attribute:
'categories' - a comma separated list of the category names that you want to display in this gallery
'exclude' - a comma separated list of category names that you wish to display in this gallery

Both are optional.

Example usage:

[twpw_show_rog categories="Category 1, Category 2"]
will display all entries in the Categories: Category 1 and Category 2

[twpw_show_rog exclude="Category 5"]
will display all entries EXCEPT those in Category 5

The styles that can be modified in this plugin are:

div#tabs - The wrapping div of the slider. This element contains all the text and image content.
div.twpw_rog_wrap - This div wraps the content of the Gallery
div.twpw_rog_wrap .rogTitle - This is the style of the title.
div.twpw_rog_wrap p - This is the style of the content.
ul.twpw_rog_images - This ul contains all the images of the Gallery.
ul.twpw_rog_images li a img - The Images themselves.

== Frequently Asked Questions ==

= A question that someone might have =

== Changelog ==

= 1.0 =
* Initial release`