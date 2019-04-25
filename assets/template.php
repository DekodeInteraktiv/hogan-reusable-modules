<?php
/**
 * Template for reusable modules module
 *
 * $this is an instance of the Reusable Modules object.
 *
 * Available properties:
 * $this->reusable_modules_post (\WP_Post) Reusable post with modules.
 *
 * @package Hogan
 */

declare( strict_types = 1 );

namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) ) {
	return; // Exit if accessed directly.
}

$modules = get_field( 'hogan_field_group_reusable_modules_modules_name', $this->reusable_modules_post->ID );
if ( ! empty( $modules ) ) :
	foreach ( $modules as $module ) {
		$layout = $module['acf_fc_layout'];
		\hogan_enqueue_module_assets( $layout );
		\hogan_module( $layout, $module );
	}
endif;
