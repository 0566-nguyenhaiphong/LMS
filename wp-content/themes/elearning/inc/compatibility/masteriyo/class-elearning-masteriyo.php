<?php
/**
 * Masteriyo Compatibility.
 *
 * @package eLearning
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'eLearning_Masteriyo' ) ) :

	class eLearning_Masteriyo {
		/**
		 * @var $instance
		 */
		private static $instance;

		/**
		 * Initiator.
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * eLearning_Masteriyo constructor.
		 */
		private function __construct() {
			if ( get_theme_mod( 'elearning_enable_page_title', true ) && 'page-header' === get_theme_mod( 'elearning_page_title', 'page-header' ) ) {
				add_filter( 'masteriyo_show_page_title', array($this, '__return_false') );
				remove_action( 'masteriyo_single_course_content', 'masteriyo_single_course_title', 30 );
			}
		}

		public function __return_false() {
			return false;
		}
	}

	eLearning_Masteriyo::get_instance();

endif;
