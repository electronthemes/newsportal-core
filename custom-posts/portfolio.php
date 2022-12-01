<?php

function newsportal_portfolio_posts(){

	register_post_type( 'newsportal-portfolio', array(
		'labels' 		=> array(
			'name'          => __( 'Portfolio', 'newsportal' ),
	        'singular_name' => __( 'Portfolio', 'newsportal' ),
	        'add_new_item'  => __( 'Add New Portfolio', 'newsportal' ),
	        'edit_item'     => __( 'Edit Portfolio', 'newsportal' ),
	        'new_item'      => __( 'New Portfolio', 'newsportal' ),
	        'view_item'     => __( 'View Portfolio', 'newsportal' ),
	        'view_items'    => __( 'View Portfolios', 'newsportal' ),
	        'search_items'  => __( 'Search Portfolios', 'newsportal' ),
	        'all_items'     => __( 'All Portfolios', 'newsportal' ),		
		),
		'public' 		=> true,
		'show_ui'		=> true,
		'menu_position'	=> 10,
		'menu_icon'	=> 'dashicons-schedule',
		'hierarchical'  => true,
		'show_in_rest'	=> true,
		'has_archive'	=> true,
		'supports'		=> array('title', 'editor', 'thumbnail', 'author', 'comments', 'page-attributes'),
	) );

	register_taxonomy('portfolio-skills', 'newsportal-portfolio', array(
		'labels'		=> array(
			'name'				=> __('Skills', 'newsportal'),
			'singular_name'		=> __('Skill', 'newsportal'),
			'all_items'         => __( 'All Skill', 'newsportal' ),
	        'parent_item'       => __( 'Parent Skill', 'newsportal' ),
	        'parent_item_colon' => __( 'Parent Skill:', 'newsportal' ),
	        'edit_item'         => __( 'Edit Skill', 'newsportal' ),
	        'update_item'       => __( 'Update Skill', 'newsportal' ),
	        'add_new_item'      => __( 'Add New Skill', 'newsportal' ),
	        'new_item_name'     => __( 'New Skill Name', 'newsportal' ),
	        'menu_name'         => __( 'Skills', 'newsportal' ),
		),
		'show_ui'		=> true,
		'show_in_rest'	=> true,
		'hierarchical'	=> true,
		'rewrite'       => array( 'slug' => 'skill' ),
	));
	
}
add_action( 'init', 'newsportal_portfolio_posts' );








?>