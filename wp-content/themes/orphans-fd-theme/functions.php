<?php
/*
Author: Evizi Team
URL: htp://evizi.com

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images, 
sidebars, comments, ect.
*/
//show_admin_bar( false );	
include('includes/custom_post_type.php');
include('includes/post_type_nhan_con_nuoi.php');
include('includes/insert_tre_mo_coi.php');
// Adding WP 3+ Functions & Theme Support
function custom_theme_support() {
	add_theme_support('post-thumbnails');      // wp thumbnails (sizes handled in functions.php)
	set_post_thumbnail_size(125, 125, true);   // default thumb size
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
/* Bootstrap_Walker for Wordpress 
     * Author: George Huger, Illuminati Karate, Inc 
     * More Info: http://illuminatikarate.com/blog/bootstrap-walker-for-wordpress 
     * 
     * Formats a Wordpress menu to be used as a Bootstrap dropdown menu (http://getbootstrap.com). 
     * 
     * Specifically, it makes these changes to the normal Wordpress menu output to support Bootstrap: 
     * 
     *        - adds a 'dropdown' class to level-0 <li>'s which contain a dropdown 
     *         - adds a 'dropdown-submenu' class to level-1 <li>'s which contain a dropdown 
     *         - adds the 'dropdown-menu' class to level-1 and level-2 <ul>'s 
     * 
     * Supports menus up to 3 levels deep. 
     *  
     */ 
    class Bootstrap_Walker extends Walker_Nav_Menu 
    {     
 
        /* Start of the <ul> 
         * 
         * Note on $depth: Counterintuitively, $depth here means the "depth right before we start this menu".  
         *                   So basically add one to what you'd expect it to be 
         */         
        function start_lvl(&$output, $depth) 
        {
            $tabs = str_repeat("\t", $depth); 
            // If we are about to start the first submenu, we need to give it a dropdown-menu class 
            if ($depth == 0 || $depth == 1) { //really, level-1 or level-2, because $depth is misleading here (see note above) 
                $output .= "\n{$tabs}<ul class=\"dropdown\">\n"; 
            } else { 
                $output .= "\n{$tabs}<ul>\n"; 
            } 
            return;
        } 
 
        /* End of the <ul> 
         * 
         * Note on $depth: Counterintuitively, $depth here means the "depth right before we start this menu".  
         *                   So basically add one to what you'd expect it to be 
         */         
        function end_lvl(&$output, $depth)  
        {
            if ($depth == 0) { // This is actually the end of the level-1 submenu ($depth is misleading here too!) 
 
                // we don't have anything special for Bootstrap, so we'll just leave an HTML comment for now 
                $output .= '<!--.dropdown-->'; 
            } 
            $tabs = str_repeat("\t", $depth); 
            $output .= "\n{$tabs}</ul>\n"; 
            return; 
        }
 
        /* Output the <li> and the containing <a> 
         * Note: $depth is "correct" at this level 
         */         
        function start_el(&$output, $item, $depth, $args)  
        {    
            global $wp_query; 
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : ''; 
            $class_names = $value = ''; 
            $classes = empty( $item->classes ) ? array() : (array) $item->classes; 
 
            /* If this item has a dropdown menu, add the 'dropdown' class for Bootstrap */ 
            if ($item->hasChildren) { 
                $classes[] = 'has-dropdown'; 
                // level-1 menus also need the 'dropdown-submenu' class 
                if($depth == 1) { 
                    $classes[] = 'dropdown-submenu'; 
                } 
            } 
 
            /* This is the stock Wordpress code that builds the <li> with all of its attributes */ 
            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ); 
            $class_names = ' class="' . esc_attr( $class_names ) . '"'; 
            $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';             
            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : ''; 
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : ''; 
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : ''; 
            $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : ''; 
            $item_output = $args->before; 
 
            /* If this item has a dropdown menu, make clicking on this link toggle it */ 
            if ($item->hasChildren && $depth == 0) { 
                $item_output .= '<a'. $attributes .' class="dropdown-toggle" data-toggle="dropdown">'; 
            } else { 
                $item_output .= '<a'. $attributes .'>'; 
            } 
 
            $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after; 
 
            /* Output the actual caret for the user to click on to toggle the menu */             
            if ($item->hasChildren && $depth == 0) { 
                $item_output .= '<b class="caret"></b></a>'; 
            } else { 
                $item_output .= '</a>'; 
            } 
 
            $item_output .= $args->after; 
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args ); 
            return; 
        }
 
        /* Close the <li> 
         * Note: the <a> is already closed 
         * Note 2: $depth is "correct" at this level 
         */         
        function end_el (&$output, $item, $depth, $args)
        {
            $output .= '</li>'; 
            return;
        } 
 
        /* Add a 'hasChildren' property to the item 
         * Code from: http://wordpress.org/support/topic/how-do-i-know-if-a-menu-item-has-children-or-is-a-leaf#post-3139633  
         */ 
        function display_element ($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) 
        { 
            // check whether this item has children, and set $item->hasChildren accordingly 
            $element->hasChildren = isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID]); 
 
            // continue with normal behavior 
            return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output); 
        }         
    } 
	

// Add Twitter Bootstrap's standard 'active' class name to the active nav link item
add_filter('nav_menu_css_class', 'add_active_class', 10, 2 );

function add_active_class($classes, $item) {
	if( $item->menu_item_parent == 0 && in_array('current-menu-item', $classes) ) {
    $classes[] = "active";
	}
  
  return $classes;
}


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
?>
