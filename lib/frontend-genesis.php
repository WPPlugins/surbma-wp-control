<?php

// Customizes breadcrumb
add_filter( 'genesis_breadcrumb_args', 'surbma_wp_control_genesis_custom_breadcrumb' );
function surbma_wp_control_genesis_custom_breadcrumb( $args ) {
	$args['home'] = get_bloginfo( 'name' );
	$args['sep'] = ' &raquo; ';
	$args['labels']['prefix'] = '';
	return $args;
}

// Add custom footer creds text
add_action( 'genesis_footer', 'surbma_wp_control_custom_footer' );
function surbma_wp_control_custom_footer() {
	if ( genesis_html5() ) {
		add_filter( 'genesis_footer_output', 'surbma_wp_control_footer', 999 );
	}
	else {
		add_filter( 'genesis_footer_creds_text', 'surbma_wp_control_footer_creds', 25 );
	}
}

function surbma_wp_control_footer( $output ) {
	$output = '<p>' . surbma_wp_control_footer_creds() . '</p>';
	return $output;
}

// Remove the edit link
add_filter( 'genesis_edit_post_link' , '__return_false' );

// Remove post info and post meta from attachement pages
add_action( 'genesis_loop', 'surbma_wp_control_genesis_modifications' );
function surbma_wp_control_genesis_modifications() {
	if( is_attachment() ) {
		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
	}
}

// Attachement pages are forced to full width
add_filter( 'genesis_pre_get_option_site_layout', 'surbma_wp_control_media_force_layout' );
function surbma_wp_control_media_force_layout( $layout ) {
	if ( is_attachment() ) {
		$layout = 'full-width-content';
		return $layout;
	}
	return $layout;
}

// Override default Genesis favicon
add_filter( 'genesis_pre_load_favicon', 'surbma_wp_control_custom_favicon' );
function surbma_wp_control_custom_favicon( $favicon_url ) {
	if ( file_exists( ABSPATH . 'favicon.ico' ) )
		$favicon_url = get_site_url() . '/favicon.ico';
	elseif ( file_exists( ABSPATH . 'favicon.gif' ) )
		$favicon_url = get_site_url() . '/favicon.gif';
	elseif ( file_exists( ABSPATH . 'favicon.png' ) )
		$favicon_url = get_site_url() . '/favicon.png';
	elseif ( file_exists( ABSPATH . 'favicon.jpg' ) )
		$favicon_url = get_site_url() . '/favicon.jpg';
	return $favicon_url;
}
