<?php
/*
Plugin Name: Newsportal Core
Plugin URI: 
Description: Companion Plugin for newsportal Theme
Version: 1.0.0
Author: Enamul Haque
Author URI: http://www.enamul.me/
Text Domain: newsportal
Domain Path: /languages/
*/

function newsportal_load_text_domain(){
	load_plugin_textdomain('newsportal', false, dirname(__FILE__)."/languages");
}
add_action( 'plugins_loaded', 'newsportal_load_text_domain' );


/**
 * 	WIDGETS AREA
 */
//include_once( 'widgets/author-bio.php' );
// include_once( 'widgets/popular-posts.php' );
include_once( 'widgets/social-profiles.php' );
// include_once( 'widgets/recent-post.php' );
include_once( 'widgets/authors.php' );
include_once( 'widgets/categories.php' );
include_once( 'widgets/post-grid.php' );

/**
*  Custom Posts
*/
//include_once( 'custom-posts/portfolio.php' );

/**
*	External Plugins
*/
// if(file_exists(ABSPATH . PLUGINDIR . '/kirki/kirki.php')){
// 	require_once ABSPATH . PLUGINDIR . '/kirki/kirki.php';
// }

//require_once( 'libs/one-click-demo-import/one-click-demo-import.php' );
 
?>