<?php
/**
 * Reusable modules module class
 *
 * @package Hogan
 */

declare( strict_types = 1 );

namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( '\\Dekode\\Hogan\\Reusable_Modules' ) && class_exists( '\\Dekode\\Hogan\\Module' ) ) {

	/**
	 * Reusable modules class.
	 *
	 * @extends Modules base class.
	 */
	class Reusable_Modules extends \Dekode\Hogan\Module {

		/**
		 * Reusable post with module(s) for use in template.
		 *
		 * @var \WP_Post $reusable_modules_post
		 */
		public $reusable_modules_post;

		/**
		 * Module constructor.
		 */
		public function __construct() {

			$this->label    = __( 'Reusable modules', 'hogan-reusable-modules' );
			$this->template = __DIR__ . '/assets/template.php';

			parent::__construct();
		}

		/**
		 * Field definitions for module.
		 *
		 * @return array $fields Fields for this module
		 */
		public function get_fields() : array {

			$fields = [
				[
					'type'          => 'post_object',
					'key'           => $this->field_key . 'modules',
					'name'          => 'modules',
					'label'         => __( 'Premade module(s)', 'hogan-reusable-modules' ),
					'post_type'     => [
						0 => 'hogan_modules',
					],
					'return_format' => 'object',
					'ui'            => 1,
				],
			];

			return $fields;
		}

		/**
		 * Map raw fields from acf to object variable.
		 *
		 * @param array $raw_content Content values.
		 * @param int   $counter Module location in page layout.
		 *
		 * @return void
		 */
		public function load_args_from_layout_content( array $raw_content, int $counter = 0 ) {

			$this->reusable_modules_post = $raw_content['modules'];
			// write_log($this->modules);
			parent::load_args_from_layout_content( $raw_content, $counter );

			add_filter( 'hogan/module/outer_wrapper_tag', [ $this, 'remove_wrappers' ], 10, 2 );
			add_filter( 'hogan/module/inner_wrapper_tag', [ $this, 'remove_wrappers' ], 10, 2 );
		}

		/**
		 * Remove outer and inner wrapper tags for this module
		 *
		 * @param $wrapper_tag
		 * @param $module
		 *
		 * @return null|string
		 */
		public function remove_wrappers( $wrapper_tag, $module ) {
			if ( $module->name === $this->name ) {
				return null;
			}

			return $wrapper_tag;
		}

		/**
		 * Validate module content before template is loaded.
		 *
		 * @return bool Whether validation of the module is successful / filled with content.
		 */
		public function validate_args() : bool {
			return true;
		}
	}
}
