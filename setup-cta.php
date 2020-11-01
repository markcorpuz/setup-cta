<?php
/**
 * Plugin Name: Setup Call-to-Action
 * Description: Use custom Guttenburg block to show CTAs
 * Version: 1.0.0
 * Author: Jake Almeda & Mark Corpuz
 * Author URI: https://smarterwebpackages.com/
 * Network: true
 * License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


add_action( 'genesis_setup', 'setup_cta_acf_fn', 15 );
function setup_cta_acf_fn() {
	include_once( plugin_dir_path( __FILE__ ).'setup-cta-acf.php' );
}


function setup_cta_this_dir() {
	return plugin_dir_url( __FILE__ );
}