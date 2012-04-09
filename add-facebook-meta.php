<?php
/*
Plugin Name: Add Facebook Meta
Plugin URI: https://github.com/amberkayle/add-facebook-meta
Description: Adds FB Opengraph meta tags to the header
Version: 1.0
Author: Kayle
Author URI: amberkaylearmstrong.com
Author Email: amber.kayle.armstrong@gmail.com
License:

  Copyright 2012 (amberkaylearmstrong@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/

class AddFacebookMeta {
	
	/*--------------------------------------------*
	 * Constants
	 *--------------------------------------------*/
	const name = 'Add Facebook Meta';
	
	const slug = 'add-facebook-meta';
	
	const default_image_url = 'http://profile.ak.fbcdn.net/hprofile-ak-snc4/174702_287169654690106_136942782_s.jpg';
	
	 
	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/
	
	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {
	
	    // Define constants used throughout the plugin
	    $this->init_plugin_constants();
			
	    add_action( 'wp_head', array( $this, 'add_facebook_meta' ), 1 );

	} // end constructor
	
	/*--------------------------------------------*
	 * Core Functions
	 *---------------------------------------------*/
	
	/**
	 *
	 */
	function add_facebook_meta( ) {
	
		$meta_title = $this->get_meta_title() ;
		$meta_url = $this->get_meta_permalink() ;
		$meta_image = $this->get_meta_image() ;
		$meta_type = $this->get_meta_type();
		$meta_sitename = $this->get_meta_sitename();
		$meta_description = $this->get_meta_description();
	
		$tag_title = "<meta property=\"og:title\" content=\"$meta_title\"/>\n";
		$tag_permalink = "<meta property=\"og:url\" content=\"$meta_url\"/>\n";
		$tag_image = "<meta property=\"og:image\" content=\"$meta_image\"/>\n";
		$tag_type = "<meta property=\"og:type\" content=\"$meta_type\"/>\n";
		$tag_sitename = "<meta property=\"og:site_name\" content=\"$meta_sitename\"/>\n";
		$tag_description = "<meta property=\"og:description\" content=\"$meta_description\"/>\n";
	
		echo "\n<!--Facebook OpenGraph Meta Tags -->\n";
		echo $tag_title;
		echo $tag_permalink;
		echo $tag_image;
		echo $tag_type;
		echo $tag_sitename;
		echo $tag_description;
		echo "<!--End of Facebook OpenGraph Meta Tags-->";

	} // add_metatags_facebook
	
	

	
	
	
	/*--------------------------------------------*
	 * Private Functions
	 *---------------------------------------------*/
	 
	private function get_meta_title(){
		return get_the_title();
	}	 
	 
	private function get_meta_permalink(){
		return get_permalink();
	}

	private function get_meta_image() {
		global $post;
		$image_url = null;

		// Post or page
		if( is_single() || is_page () ){
		
			// Try to get a thumbnail - Featured image
			if( has_post_thumbnail( $post->ID ) ){
				$image_url = get_the_post_thumbnail( $post->ID, 'large' );
				
			// Scrape from post - Did use attachments, but what you attach isn't always what you end up using!
			// Source: http://www.wprecipes.com/how-to-get-the-first-image-from-the-post-and-display-it
			} else {
                                $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
                                $image_url = $matches [1] [0];
			}
		}
		// Either home or didn't get anything to use as an image - use default
		if( ! $image_url ){
			$image_url = self::default_image_url;
		}
		return $image_url;

	}
   	
	private function get_meta_type(){
		if( is_single() || is_page() ){
			return "article";
		} else {
			return "website";
		}
	}
	
	private function get_meta_sitename(){
		return get_bloginfo( 'name' );
	}	

	private function get_meta_description(){
		global $post;
		if (is_home() || is_front_page() ){
			$description = get_bloginfo('description');
		} else {
			$description = $post->post_excerpt;
		}
		
		return $description;

	}



	
	/**
	 * Initializes constants used for convenience throughout 
	 * the plugin.
	 */
	private function init_plugin_constants() {
		
		/* 
		 * Define this as the name of your plugin. This is what shows
		 * in the Widgets area of WordPress.
		 */
		if ( !defined( 'Add Facebook Meta' ) ) {
		  define( 'Add Facebook Meta', self::name );
		} // end if
		
		/* 
		 * this is the slug of your plugin used in initializing it with
		 * the WordPress API.
		 */
		if ( !defined( 'add-facebook-meta' ) ) {
		  define( 'add-facebook-meta', self::slug );
		} // end if
	
	} // end init_plugin_constants
	
	

	
	

  
} // end AddFacebookMeta

new AddFacebookMeta();
?>