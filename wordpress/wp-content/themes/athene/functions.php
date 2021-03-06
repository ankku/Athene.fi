<?php
/**
 * @package WordPress
 * @subpackage Athene
 */

/**
 * Make theme available for translation
 * Translations can be filed in the /languages/ directory
 * If you're building a theme based on toolbox, use a find and replace
 * to change 'toolbox' to the name of your theme in all the template files
 */
load_theme_textdomain( 'toolbox', TEMPLATEPATH . '/languages' );

$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
if ( is_readable( $locale_file ) )
	require_once( $locale_file );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

/**
 * This theme uses wp_nav_menu() in one location.
 */
register_nav_menus( array(
	'primary' => __( 'Primary Menu', 'toolbox' ),
) );

/**
 * Add default posts and comments RSS feed links to head
 */
add_theme_support( 'automatic-feed-links' );

/**
 * Add support for the Aside and Gallery Post Formats
 */
add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function toolbox_page_menu_args($args) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'toolbox_page_menu_args' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function toolbox_widgets_init() {
	register_sidebar( array (
		'name' => __( 'Sidebar 1', 'toolbox' ),
		'id' => 'sidebar-1',
		'description' => 'Näytetään tavallisilla sivuilla, jos kommentit eivät ole käytössä',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );

	register_sidebar( array (
		'name' => __( 'Sidebar 2', 'toolbox' ),
		'id' => 'sidebar-2',
		'description' => 'Näytetään tavallisilla sivuilla, jos kommentit eivät ole käytössä',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );	
	
	register_sidebar( array (
		'name' => __( 'Etusivun leveä paikka ', 'toolbox' ),
		'id' => 'index-widget-wide',
		'description' => __( 'Etusivun leveä paikka ', 'toolbox' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
	
	for($i=1; $i<13;$i++) {
  	register_sidebar( array (
  		'name' => __( 'Etusivun paikka '.$i, 'toolbox' ),
  		'id' => 'index-widget-'.$i,
  		'description' => __( 'Etusivun paikka '.$i, 'toolbox' ),
  		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  		'after_widget' => "</aside>",
  		'before_title' => '<h2 class="widget-title">',
  		'after_title' => '</h2>',
  	) );
  }
}
add_action( 'init', 'toolbox_widgets_init' );

function cycle(/* $values ... */) {
    $values = func_get_args();
    return function() use(&$values) {
        $next = array_shift($values);
        $values[] = $next;
        if (is_callable($next)) {
            return $next();
        }
        return $next;
    };
}
