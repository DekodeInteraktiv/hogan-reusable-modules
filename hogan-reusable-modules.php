<?php
/**
 * Plugin Name: Hogan Module: Reusable Modules
 * Plugin URI: https://github.com/dekodeinteraktiv/hogan-reusable-modules
 * GitHub Plugin URI: https://github.com/dekodeinteraktiv/hogan-reusable-modules
 * Description: Reusable Modules Module for Hogan
 * Version: 1.0.0
 * Author: Dekode
 * Author URI: https://dekode.no
 * License: GPL-3.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * Text Domain: hogan-reusable-modules
 * Domain Path: /languages/
 *
 * @package Hogan
 * @author Dekode
 */

declare( strict_types = 1 );

namespace Dekode\Hogan\Reusable_Modules;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'plugins_loaded', __NAMESPACE__ . '\\hogan_load_textdomain' );
add_action( 'hogan/include_modules', __NAMESPACE__ . '\\hogan_register_module', 10, 1 );
add_action( 'hogan/include_field_groups', __NAMESPACE__ . '\\hogan_register_field_group', 10, 1 );
add_action( 'init', __NAMESPACE__ . '\\hogan_register_post_type' );

/**
 * Register module text domain
 */
function hogan_load_textdomain() {
	\load_plugin_textdomain( 'hogan-reusable-modules', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

/**
 * Register custom post type for module
 *
 * @return void
 */
function hogan_register_post_type() {
	register_post_type( 'hogan_modules', [
		'labels'              => [
			'name'               => esc_html_x( 'Collections', 'post type general name', 'hogan-reusable-modules' ),
			'singular_name'      => esc_html_x( 'Reusable modules', 'post type singular name', 'hogan-reusable-modules' ),
			'menu_name'          => esc_html_x( 'Reusable modules', 'admin menu', 'hogan-reusable-modules' ),
			'name_admin_bar'     => esc_html_x( 'Reusable modules', 'add new on admin bar', 'hogan-reusable-modules' ),
			'add_new'            => esc_html__( 'Add new', 'hogan-reusable-modules' ),
			'add_new_item'       => esc_html__( 'Add', 'hogan-reusable-modules' ),
			'new_item'           => esc_html__( 'Add', 'hogan-reusable-modules' ),
			'edit_item'          => esc_html__( 'Edit', 'hogan-reusable-modules' ),
			'view_item'          => esc_html__( 'Show', 'hogan-reusable-modules' ),
			'all_items'          => esc_html__( 'Collections', 'hogan-reusable-modules' ),
			'search_items'       => esc_html__( 'Search', 'hogan-reusable-modules' ),
			'parent_item_colon'  => esc_html__( 'Parent:', 'hogan-reusable-modules' ),
			'not_found'          => esc_html__( 'Nothing found.', 'hogan-reusable-modules' ),
			'not_found_in_trash' => esc_html__( 'Nothing found in trashcan.', 'hogan-reusable-modules' ),
		],
		'public'              => false,
		'publicly_queryable'  => false,
		'exclude_from_search' => true,
		'show_in_nav_menus'   => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'has_archive'         => false,
		'rewrite'             => false,
		'capability_type'     => 'page',
		'hierarchical'        => false,
		'supports'            => [ 'title' ],
		'menu_icon'           => 'dashicons-portfolio',
	] );
}

/**
 * Register module in Hogan
 *
 * @param \Dekode\Hogan\Core $core Hogan Core instance.
 *
 * @return void
 */
function hogan_register_module( \Dekode\Hogan\Core $core ) {
	// Include class and register module class.
	require_once 'class-reusable-modules.php';
	$core->register_module( new \Dekode\Hogan\Reusable_Modules() );
}

/**
 * Register custom field group for Reusable modules post type
 *
 * @param \Dekode\Hogan\Core $core Hogan Core instance.
 *
 * @return void
 */
function hogan_register_field_group( \Dekode\Hogan\Core $core ) {
	$core->register_field_group( [
		'name'     => 'field_group_reusable_modules',
		'title'    => __( 'Modules', 'hogan-reusable-modules' ),
		'modules'  => apply_filters( 'hogan/module/reusable_modules/supported_modules', [] ),
		'location' => [
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'hogan_modules',
				],
			],
		],
	] );
}
