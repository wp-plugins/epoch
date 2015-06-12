<?php
/**
 * @package   Epoch
 * @author    Postmatic
 * @license   GPL-2.0+
 * @link      
 * Copyright 2015 Transitive, Inc.
 *
 * @wordpress-plugin
 *
 * Plugin Name: Epoch
 * Version: 0.3.1
 * Plugin URI:  http://gopostmatic.com/epoch
 * Description: Native commenting made realtime, mobile, CDN and Cache friendly, and full of SEO mojo as well. Commenting perfected.
 * Author:      Postmatic
 * Author URI:  https://gopostmatic.com/
 * Text Domain: epoch
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('EPOCH_PATH',  plugin_dir_path( __FILE__ ) );
define('EPOCH_URL',  plugin_dir_url( __FILE__ ) );
define( 'EPOCH_VER', '0.3.1' );



// Load instance
add_action( 'plugins_loaded', 'epoch_bootstrap' );
function epoch_bootstrap(){
	$message_class_file    = EPOCH_PATH . 'vendor/calderawp/dismissible-notice/src/Caldera_Warnings_Dismissible_Notice.php';
	if ( ! version_compare( PHP_VERSION, '5.3.0', '>=' ) ) {
		if ( is_admin() ) {
			//BIG nope nope nope!
			include_once $message_class_file;

			$message = __( sprintf( 'Epoch requires PHP version %1s or later. We strongly recommend PHP 5.4 or later for security and performance reasons. Current version is %2s.', '5.3.0', PHP_VERSION ), 'epoch' );
			echo Caldera_Warnings_Dismissible_Notice::notice( $message, true, 'activate_plugins' );
		}

	}else{
		//bootstrap plugin
		require_once( EPOCH_PATH . 'bootstrap.php' );

	}

}
