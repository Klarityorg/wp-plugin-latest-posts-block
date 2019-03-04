<?php
/**
 * Plugin Name: Klarity latest posts block
 * Plugin URI: https://github.com/Klarityorg/wp-plugin-latest-posts
 * Description: Klarity latest posts block
 * Author: Klarity
 * Author URI: https://github.com/Klarityorg
 * Version: 1.0.2
 * License: MIT
 *
 * @package Klarity
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Block Initializer.
 */
require_once plugin_dir_path( __FILE__ ) . 'src/init.php';
