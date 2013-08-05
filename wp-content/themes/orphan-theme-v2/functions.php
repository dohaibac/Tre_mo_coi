<?php
/**
Author: Evizi Team
URL: htp://evizi.com

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images, 
sidebars, comments, ect.

YOU NEED TO COMMENT AND GROUP THEM IN AN AREA CLEARLY.
*/



/**
 ************ CALL GLOBAL FUNCTIONS DIRECTLY ************
 */
show_admin_bar( false );	

/*allow redirection, even if my theme starts to send output to the browser
Cannot modify header information */
if ( !is_admin() ){
	add_action('init', 'orphan_do_output_buffer');
	function orphan_do_output_buffer() {
			ob_start();
	}
}
/**
 ~~~~~~~~~~~~ CALL GLOBAL FUNCTIONS DIRECTLY ~~~~~~~~~~~~
 */



/**
 ************ REQUIRE GLOBAL CLASSES ************
 */
require_once('includes/libs/bootstrap_walker.php');
include('includes/theme-option.php');
/**
 ~~~~~~~~~~~~ REQUIRE GLOBAL CLASSES ~~~~~~~~~~~~
 */



/**
 ************ INCLUDE AJAX PROCESSING FILES ************
 */
include('includes/custom_post_type.php');
include('includes/post_type_nhan_con_nuoi.php');
include('includes/insert_tre_mo_coi.php');
include('includes/post_type_tim_nguoi_than.php');
include('includes/post_type_vuon_uoc_mo.php');
include('includes/post_type_hinh_anh.php');
include('includes/action-becomeparents.php');
include('includes/action-profile.php');
/**
 ~~~~~~~~~~~~ INCLUDE AJAX PROCESSING FILES ~~~~~~~~~~~~
 */


/**
 ************ INCLUDE WIDGET ************
 */
 include('includes/widget-index-page.php');
 

/**
 ************ ADD ACTION HOOKS ************
 */
remove_all_actions( 'do_feed_rss2' );
add_action( 'do_feed_rss2', 'orphan_product_feed_rss2', 10, 1 );

function orphan_product_feed_rss2( $for_comments ) {
    $rss_template = get_template_directory() . '/templates/page-rss.php';
    if( get_query_var( 'post_type' ) == 'post' and file_exists( $rss_template ) )
        load_template( $rss_template );
    else
        do_feed_rss2( $for_comments ); // Call default function
}
/**
 ~~~~~~~~~~~~ ADD ACTION HOOKS ~~~~~~~~~~~~
 */



/**
 ************ THEME COMMON FUNCTIONS ************
 */
// Adding WP 3+ Functions & Theme Support
function custom_theme_support() {
	add_theme_support('post-thumbnails');      // wp thumbnails (sizes handled in functions.php)
	//set_post_thumbnail_size(125, 125, true);   // default thumb size
	add_theme_support( 'custom-background' );  // wp custom background
	add_theme_support('automatic-feed-links'); // rss thingy
	// to add header image support go here: http://themble.com/support/adding-header-background-image-support/
	// adding post format support
	/*add_theme_support( 'post-formats',      // post formats
		array( 
			'aside',   // title less blurb
			'gallery', // gallery of images
			'link',    // quick link to other site
			'image',   // an image
			'quote',   // a quick quote
			'status',  // a Facebook like status update
			'video',   // video 
			'audio',   // audio
			'chat'     // chat transcript 
		)
	);	*/
	add_theme_support( 'menus' );            // wp menus
	register_nav_menus(                      // wp3+ menus
		array( 
			'main_nav' => 'The Main Menu',   // main nav in header
			'footer_links' => 'Footer Links' // secondary nav in footer
		)
	);

	if(function_exists('register_sidebar')){
		 register_sidebar(array(
		  'name' => 'sidebar_main',
		  'description' => 'Sidebar cho tin tức',
		  'before_widget'  => '<div id="id_%1$s" class="row sidebar-box shadow-box">',
		  'after_widget'  => '</div></div>',
		  'before_title'  => '<h2>',
		  'after_title'   => '</h2><div class="box-content list-2">'
		 ));
		 
		 register_sidebar(array(
		  'name' => 'footer_gallery',
		  'description' => 'Footer gallery',
		  'before_widget'  => '<div class="row shadow-box box-large hide-for-small">',
		  'after_widget'  => '</div></div>',
		  'before_title'  => '<h2>',
		  'after_title'   => '</h2><div class="box-content album">'
		 ));
		  register_sidebar(array(
		  'name' => 'sidebar_bottom',
		  'description' => 'Sidebar cho tin tức',
		  'before_widget'  => '<div id="id_%1$s" class="row sidebar-box shadow-box">',
		  'after_widget'  => '</div></div>',
		  'before_title'  => '<h2>',
		  'after_title'   => '</h2><div class="box-content list-2">'
		 ));
	}
}

// launching this stuff after theme setup
add_action('after_setup_theme','custom_theme_support');	


/* custom menu */
function custom_main_nav($theme_location = 'main_nav', $container = false ) {
	// display the wp3 menu if available
    wp_nav_menu( 
    	array( 
    		'menu' => 'main_nav', /* menu name */
    		'menu_class' => 'nav',
    		'theme_location' => $theme_location, /* where in the theme it's assigned */
    		'container' => $container, /* container class */
    		'fallback_cb' => 'bones_main_nav_fallback', /* menu fallback */
    		'depth' => '3', /* suppress lower levels for now */
    		'walker' => new Bootstrap_Walker()
    	)
    );
}
// Menu output mods

	

// Add Twitter Bootstrap's standard 'active' class name to the active nav link item
add_filter('nav_menu_css_class', 'add_active_class', 10, 2 );

function add_active_class($classes, $item) {
	if( $item->menu_item_parent == 0 && in_array('current-menu-item', $classes) ) {
    $classes[] = "active";
	}
  
  return $classes;
}

/**
* Function name:	tmc_widgets_init
* Description : 	register a site bar
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 06, 2013		Phi Ho			register a site bar
*/
function tmc_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'mainsitebar' ),
		'id' => 'sidebar-m',
		'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'mainsitebar' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'tmc_widgets_init' );
/**
 ~~~~~~~~~~~~ THEME COMMON FUNCTIONS ~~~~~~~~~~~~
 */



/**
 ************ UTIL COMMON FUNCTIONS ************
 */
/**
* Function name:	orphan_utf162utf8
* Description : 	Convert unf-8
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 5, 2013		Vinh.le			Convert unf-8
*/
function orphan_utf162utf8($utf16){
	// Check for mb extension otherwise do by hand.
	if( function_exists('mb_convert_encoding') ) {
		return mb_convert_encoding($utf16, 'UTF-8', 'UTF-16');
	}

	$bytes = (ord($utf16{0}) << 8) | ord($utf16{1});

	switch (true) {
		case ((0x7F & $bytes) == $bytes):
			// this case should never be reached, because we are in ASCII range
			// see: http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8
			return chr(0x7F & $bytes);

		case (0x07FF & $bytes) == $bytes:
			// return a 2-byte UTF-8 character
			// see: http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8
			return chr(0xC0 | (($bytes >> 6) & 0x1F))
				 . chr(0x80 | ($bytes & 0x3F));

		case (0xFFFF & $bytes) == $bytes:
			// return a 3-byte UTF-8 character
			// see: http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8
			return chr(0xE0 | (($bytes >> 12) & 0x0F))
				 . chr(0x80 | (($bytes >> 6) & 0x3F))
				 . chr(0x80 | ($bytes & 0x3F));
	}

	// ignoring UTF-32 for now, sorry
	return '';
}

/**
* Function name:	orphan_utf162utf8
* Description : 	Decode Unicode String
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 5, 2013		Vinh.le			Decode Unicode String
*/
function orphan_decodeUnicodeString($chrs)
{
	$delim       = substr($chrs, 0, 1);
	$utf8        = '';
	$strlen_chrs = strlen($chrs);

	for($i = 0; $i < $strlen_chrs; $i++) {

		$substr_chrs_c_2 = substr($chrs, $i, 2);
		$ord_chrs_c = ord($chrs[$i]);

		switch (true) {
			case preg_match('/\\\u[0-9A-F]{4}/i', substr($chrs, $i, 6)):
				// single, escaped unicode character
				$utf16 = chr(hexdec(substr($chrs, ($i + 2), 2)))
					   . chr(hexdec(substr($chrs, ($i + 4), 2)));
				$utf8 .= orphan_utf162utf8($utf16);
				$i += 5;
				break;
			case ($ord_chrs_c >= 0x20) && ($ord_chrs_c <= 0x7F):
				$utf8 .= $chrs{$i};
				break;
			case ($ord_chrs_c & 0xE0) == 0xC0:
				// characters U-00000080 - U-000007FF, mask 110XXXXX
				//see http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8
				$utf8 .= substr($chrs, $i, 2);
				++$i;
				break;
			case ($ord_chrs_c & 0xF0) == 0xE0:
				// characters U-00000800 - U-0000FFFF, mask 1110XXXX
				// see http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8
				$utf8 .= substr($chrs, $i, 3);
				$i += 2;
				break;
			case ($ord_chrs_c & 0xF8) == 0xF0:
				// characters U-00010000 - U-001FFFFF, mask 11110XXX
				// see http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8
				$utf8 .= substr($chrs, $i, 4);
				$i += 3;
				break;
			case ($ord_chrs_c & 0xFC) == 0xF8:
				// characters U-00200000 - U-03FFFFFF, mask 111110XX
				// see http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8
				$utf8 .= substr($chrs, $i, 5);
				$i += 4;
				break;
			case ($ord_chrs_c & 0xFE) == 0xFC:
				// characters U-04000000 - U-7FFFFFFF, mask 1111110X
				// see http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8
				$utf8 .= substr($chrs, $i, 6);
				$i += 5;
				break;
		}
	}

	return str_replace("\/","/",$utf8); 
}

/**
* Function name:	orphan_get_json
* Description : 	get json with unf-8
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 5, 2013		Vinh.le			get json with unf-8
*/
function orphan_get_json($data = null){
		$json = json_encode($data); 
		return orphan_decodeUnicodeString($json);
}


function orphan_get_post_thumbnai($thumbnail = 'thumbnail'){
	global $post;
	$src_img = '';
	if (has_post_thumbnail()){ 
		$image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $thumbnail);
		if(isset($image[0])){
			$src_img = $image[0];
		} else {
			$src_img = get_thumbnail_by_post_content();
		}
	} else{
		$src_img = get_thumbnail_by_post_content();
	}
	return $src_img;
}

function get_thumbnail_by_post_content(){
	global $post;
	$src_img = '';
	ob_start();
	ob_end_clean();
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	if(isset($matches [1] [0]))
	$src_img = $matches [1] [0];

	if(empty($src_img)){ //Defines a default image
		$src_img = get_bloginfo('template_directory')."/images/no_image.png";
	}
	return $src_img;
}


/**
* Function name:	get_finished_date
* Description : 	get finished date of one become parent demand.
* Params:			int $email_duration
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 15, 2013		Ha.Nguyen		Created
*/
function get_finished_date($email_duration)
{
	if(is_int($email_duration) && $email_duration > 0)
	{		
		$gmdate = get_now_in_option_gmt_offset();

		$d = new DateTime($gmdate);
		$d->modify( "+".$email_duration." month" );
		$d->modify( "-1 day" );
		return $d->format( 'Y-m-d H:i:s' );
	}
	
	return null;
}


/**
* Function name:	get_now_in_option_gmt_offset
* Description : 	get current time in offset table wp-option.gmt
* Params:			
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 15, 2013		Ha.Nguyen		Created
*/
function get_now_in_option_gmt_offset()
{
	$h = get_option('gmt_offset'); // Hour for time zone goes here e.g. +7 or -4, just remove the + or -
	$hm = $h * 60; 
	$ms = $hm * 60;
	$gmdate = gmdate("Y-m-d H:i:s", time()+($ms)); // the "-" can be switched to a plus if that's what your time zone is.
	
	return $gmdate;
}

function short_the_title($title, $chars = 30){
	if(strlen($title) > $chars){
		$title = $title." ";
		$title = substr($title,0,$chars);
		$title = substr($title,0,strrpos($title,' '));
		$title = $title."...";
	}
	return $title;
}
/**
 ~~~~~~~~~~~~ UTIL COMMON FUNCTIONS ~~~~~~~~~~~~
 */
?>
