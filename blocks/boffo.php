<?php
/**
 * Functions to register client-side assets (scripts and stylesheets) for the
 * Boffo block.
 *
 * @package boffo
 */
function boffo_block_init() {
	// Skip block registration if Gutenberg is not enabled/merged.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	$dir = dirname( __FILE__ );

	$index_js = 'boffo/index.js';
	wp_register_script(
		'boffo-block-editor',
		plugins_url( $index_js, __FILE__ ),
		array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
			'wp-editor',
			'wp-components'
		),
		filemtime( "$dir/$index_js" )
	);

	$editor_css = 'boffo/editor.css';
	wp_register_style(
		'boffo-block-editor',
		plugins_url( $editor_css, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = 'boffo/style.css';
	wp_register_style(
		'boffo-block',
		plugins_url( $style_css, __FILE__ ),
		array(),
		filemtime( "$dir/$style_css" )
	);

	register_block_type( 'boffo/boffo', array(
		'editor_script' => 'boffo-block-editor',
		'editor_style'  => 'boffo-block-editor',
		'style'         => 'boffo-block',
		'attributes'    => array(
			'boffo_id' => array('type' => 'string')
		),
		'render_callback' =>  array('Boffo_Flow', 'renderBlock')
	) );
}
add_action( 'init', 'boffo_block_init' );
