<?php
/*--------------------------------------------------------------------------------------*\
| REQUIRES
\*--------------------------------------------------------------------------------------*/
require 'php/blocks.php';
require 'php/helperfunctions.php';
require 'php/meta-boxes.php';

/*--------------------------------------------------------------------------------------*\
| CSS
\*--------------------------------------------------------------------------------------*/
function my_theme_enqueue_styles2() {
	wp_enqueue_style( 'structural-style', get_stylesheet_directory_uri() . '/css/structural.css', array(), filemtime(get_stylesheet_directory() .'/css/structural.css')  );
    wp_enqueue_style( 'content-style', get_stylesheet_directory_uri() . '/css/content.css' , array(), filemtime(get_stylesheet_directory() .'/css/content.css')  );
    wp_enqueue_style( 'header-footer-style', get_stylesheet_directory_uri() . '/css/header-footer.css' , array(), filemtime(get_stylesheet_directory() .'/css/header-footer.css')  );
    wp_enqueue_style( 'variables-style' , get_stylesheet_directory_uri() . '/css/variables.css', array(), filemtime(get_stylesheet_directory() .'/css/variables.css')  );
	wp_enqueue_style( 'fonts-style' , get_stylesheet_directory_uri() . '/css/fonts.css', array(), filemtime(get_stylesheet_directory() .'/css/fonts.css')  );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles2' );


/*--------------------------------------------------------------------------------------*\
| SCRIPTS
\*--------------------------------------------------------------------------------------*/
function my_theme_enqueue_scripts() {
    wp_enqueue_script( 'lightbox', get_stylesheet_directory_uri() . '/js/lightbox.js', filemtime(get_stylesheet_directory() . '/js/lightbox.js'), true);
	wp_enqueue_script( 'mobile-menu', get_stylesheet_directory_uri() . '/js/mobile-menu.js', filemtime(get_stylesheet_directory() . '/js/mobile-menu.js'), true);
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_scripts' );


/*--------------------------------------------------------------------------------------*\
| CUSTOM THEME
\*--------------------------------------------------------------------------------------*/
function custom_theme_setup() {

	$grijs = '#c3c3c3';
	$wit = '#FFFEFD';
	$zwart = '#000033';

	/*
	|| TODO: Get all color trough optionspage, for each color => array(...);
	*/

	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'align-wide' );
    add_theme_support( 'custom-logo' );
	add_theme_support( 'editor-color-palette', array(
		array(
			'name'  => 'Zwart',
			'slug'  => 'zwart',
			'color' => $zwart,
		),
		array(
			'name'  => 'Wit',
			'slug'  => 'wit',
			'color' => $wit,
		),
		array(
			'name'  => 'Grijs',
			'slug'  => 'grijs',
			'color' => $grijs,
		)
	) );
}
add_action( 'after_setup_theme', 'custom_theme_setup' );


/*--------------------------------------------------------------------------------------*\
| EDITOR STYLES CSS
\*--------------------------------------------------------------------------------------*/
function misha_gutenberg_css()
{
	add_theme_support('editor-styles');
	add_editor_style('/css/editor.css');
}
add_action('after_setup_theme', 'misha_gutenberg_css');


/*--------------------------------------------------------------------------------------*\
| DEFAULT WIDE
\*--------------------------------------------------------------------------------------*/
function my_editor_assets() {
    wp_enqueue_script( 'my-editor', get_stylesheet_directory_uri() . '/js/wide.js', [ 'lodash','wp-blocks', 'wp-dom' ] , '', true );
    wp_enqueue_script( 'be-editor', get_stylesheet_directory_uri() . '/js/editor.js', array('wp-blocks', 'wp-dom'), filemtime(get_stylesheet_directory() . '/js/editor.js'), true );
}
add_action( 'enqueue_block_editor_assets', 'my_editor_assets', 10 );


/*-------------------------------------------------------------------------------------*\
| ADD REUSABLE BLOCKS TO ADMIN BAR
\*--------------------------------------------------------------------------------------*/
//add_action('admin_menu', 'reusable_blocks_link_wp_admin');
function reusable_blocks_link_wp_admin() {
	add_menu_page('linked_url', 'Reusable Blocks', 'read', 'edit.php?post_type=wp_block', '', 'dashicons-editor-table', 22);
}


/*--------------------------------------------------------------------------------------*\
| ADD AND REMOVE BLOCK PATTERN CATEGORIES
\*--------------------------------------------------------------------------------------*/
function removeCorePatterns() {
	unregister_block_pattern_category('buttons');
	unregister_block_pattern_category('columns');
	unregister_block_pattern_category('gallery');
	unregister_block_pattern_category('header');
	unregister_block_pattern_category('text');
	unregister_block_pattern_category('featured');
    unregister_block_pattern_category('posts');
	unregister_block_pattern_category('call-to-action');
	unregister_block_pattern_category('banner');
	unregister_block_pattern_category('footer');
    unregister_block_pattern_category('testimonials');
}
add_action('init', 'removeCorePatterns');


/*--------------------------------------------------------------------------------------*\
|   DISABLE GUTENBERG STYLE classic-theme-styles-inline-css
\*--------------------------------------------------------------------------------------*/
function wps_deregister_styles() {
    wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'classic-theme' );
	wp_dequeue_style( 'classic-theme-styles-inline' );
	wp_dequeue_style( 'classic-theme-styles-inline-css' );
	wp_dequeue_style( 'wp-block-library-theme' );
}
add_action( 'wp_enqueue_scripts', 'wps_deregister_styles', 100 );

add_action('wp_footer', function () {
	wp_dequeue_style('core-block-supports');
});



/*--------------------------------------------------------------------------------------*\
|  ADMIN BAR: OPTIONSPAGE + REUSABLE BLOCKS
\*--------------------------------------------------------------------------------------*/
function custom_options_page_link() {
    global $wp_admin_bar;
    $wp_admin_bar->add_menu(array(
        'id'    => 'website-beheren',
        'title' => 'Website Beheren',
        'href'  => admin_url('admin.php?page=website-beheren'),
    ));
	$wp_admin_bar->add_menu(array(
        'id'    => 'Reusable blocks',
        'title' => 'Reusable blocks',
        'href'  => admin_url('edit.php?post_type=wp_block'),
    ));
}
add_action('admin_bar_menu', 'custom_options_page_link', 999);


/*--------------------------------------------------------------------------------------*\
|  ADMIN BAR: REMOVE COMMENTS + UPDATES
\*--------------------------------------------------------------------------------------*/
function remove_comments(){
        global $wp_admin_bar;
		$wp_admin_bar->remove_node('updates');
        $wp_admin_bar->remove_menu('comments');
}
add_action( 'wp_before_admin_bar_render', 'remove_comments' );


/*--------------------------------------------------------------------------------------*\
|  ADMIN BAR: REMOVE COMMENTS + UPDATES
\*--------------------------------------------------------------------------------------*/
function remove_wp_nodes()
{
    global $wp_admin_bar;
    $wp_admin_bar->remove_node( 'new-link' );
	$wp_admin_bar->remove_node( 'new-user' );
    $wp_admin_bar->remove_node( 'new-media' );
}
add_action( 'admin_bar_menu', 'remove_wp_nodes', 999 );


/*-----------------------------------------------------=--------------------------------*\
|  SET CUSTOM LOGO
\*--------------------------------------------------------------------------------------*/
function custom_theme_logo() {
    $custom_logo = '<img class="logo" src="' . esc_url(get_template_directory_uri() . '/assets/images/logo.svg') . '" alt="' . esc_attr(get_bloginfo('name')) . '" />';
    return $custom_logo;
}
add_filter('get_custom_logo', 'custom_theme_logo');


/*--------------------------------------------------------------------------------------*\
|  CUSTOM LOGO
\*--------------------------------------------------------------------------------------*/
function my_custom_login_logo() {
echo '<style type="text/css">
h1 a {
	background-image: url('. esc_url(get_template_directory_uri() . '/assets/images/logo.svg') .') !important;
    height: auto !important;
    width: 100% !important;
    aspect-ratio: 109/75;
    background-size: cover !important;
	margin-bottom: 3rem !important;
}
.language-switcher{
	display:none;
}
</style>';
}
add_action('login_head', 'my_custom_login_logo');



/*--------------------------------------------------------------------------------------*\
|  REGISTERED / ALLOWED BLOCKS
\*--------------------------------------------------------------------------------------*/
add_filter( 'allowed_block_types', 'my_function' );
function my_function( $allowed_block_types ) {
    return array(
		'core/paragraph',
		'core/heading',
		'core/list',
		'core/list-item',
		'acf/faq',
		'core/image',
		'core/gallery',
		'core/video',
		'core/buttons',
		'core/button',
		'core/columns',
		'core/column',
		'core/shortcode',
		'core/social-links',
		'core/social-link',
		'core/site-logo',
		'core/loginout',
		'core/html',
	    	'core/cover'
    );
}




/*--------------------------------------------------------------------------------------*\
|  CREATE HOMEPAGE
\*--------------------------------------------------------------------------------------*/
function create_home_page() {
    $home_page = get_page_by_title('Home');
    if (!$home_page) {
        $home_page_id = wp_insert_post(array(
            'post_title'     => 'Home',
            'post_type'      => 'page',
            'post_status'    => 'publish',
            'comment_status' => 'closed',
            'ping_status'    => 'closed',
			'post_content'   => '<div class="wp-block-columns alignwide">
									<div class="wp-block-column">
										<h1>This is a short intro or header for your homepage.</h1>
										<p>Customize this content as needed.</p>
										</div>
								</div>',
        ));
        update_option('page_on_front', $home_page_id);
        update_option('show_on_front', 'page');
    }
}
add_action('after_switch_theme', 'create_home_page');




// *** TODO ***
// block cover background customizable
// README schrijven
// Groups testen op layout/css fouten
// eigen query loop maken met styling opties, cpt opties met foreach get_post_types() en tax opties
