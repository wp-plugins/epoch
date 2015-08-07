<?php
/**
 * Functions for this plugin
 *
 * @package   Epoch
 * @author    Postmatic
 * @license   GPL-2.0+
 * @link
 * Copyright 2015 Transitive, Inc.
 */


add_action( 'epoch_iframe_footer', 'epoch_iframe_footer_print_scripts' );
function epoch_iframe_footer_print_scripts() {
	global $wp_scripts;

	/**
	 * Use this filter to add or remove scripts from the Epoch iFrame filter
	 *
	 * Add handles of scripts, already registered with wp_register script here.
	 *
	 * jQuery and Epoch scripts are added after this filter runs
	 *
	 * @since 1.0.0
	 *
	 * @param array $scripts An array of registered script handles
	 */
	$scripts = apply_filters( 'epoch_iframe_scripts', array() );
	$scripts[] = 'epoch-handlebars';
	$scripts[] = 'epoch-handlebars-helpers';
	$scripts[] = 'jquery-core';
	$scripts[] = 'jquery-migrate';
	$scripts[] = 'epoch';
	$scripts[] = 'visibility';
	$scripts[] = 'comment-reply';

	if ( ! did_action( 'wp_enqueue_scripts' ) ) {
		do_action( 'wp_enqueue_scripts' );
	}

	if ( is_array( $scripts ) && ! empty( $scripts ) ) {
		$scripts = array_unique( $scripts );
		$wp_scripts->reset();
		if ( true == $wp_scripts->do_concat ) {
			$wp_scripts->do_concat = false;
		}
		foreach( $scripts as $handle ) {
			if( !empty( $wp_scripts->registered[ $handle ] ) ){
				$wp_scripts->do_item( $handle );
			}
		}

	}
}

/**
 * Add third-party scripts we want iFrame to play nice with to the iFrame.
 *
 * @since 1.0.1
 *
 * @param array $handles
 *
 * @return array
 */
add_filter( 'epoch_iframe_scripts', 'epoch_add_thirdparty_scripts_in_footer' );
function epoch_add_thirdparty_scripts_in_footer( $handles ) {
	if ( class_exists( 'ZeroSpam_Scripts' ) ) {
		$handles[] = 'zerospam';
	}

	return $handles;
	
}


/**
 * One rewrite flush and rebuild to rule them all and in the darkness bind them.
 *
 * Ash nazg durbatulûk, ash nazg gimbatul, ash nazg thrakatulûk, agh burzum-ishi krimpatul.
 *
 * @since 1.0.1
 */
function epoch_fix_rewrites() {
	$endpoints = new \postmatic\epoch\front\end_points();
	$endpoints->add_endpoints();
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
	update_option( 'epoch_ver', EPOCH_VER );
}
