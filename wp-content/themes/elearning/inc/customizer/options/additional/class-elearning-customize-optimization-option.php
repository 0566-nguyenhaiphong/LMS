<?php
/**
 * Load google fonts locally option.
 *
 * @package    ThemeGrill
 * @subpackage eLearning
 * @since @todo.
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'eLearning_Customize_Base_Option' ) ) {
	return;
}

/*============================ ADDITIONAL > OPTIMIZATION  ============================*/

if ( ! class_exists( 'eLearning_Customize_Optimization_Option' ) ) :

	/**
	 * Optimization option.
	 */
	class eLearning_Customize_Optimization_Option extends eLearning_Customize_Base_Option {

		/**
		 * Include customize options.
		 *
		 * @param array                 $options      Customize options provided via the theme.
		 * @param \WP_Customize_Manager $wp_customize Theme Customizer object.
		 *
		 * @return mixed|void Customizer options for registering panels, sections as well as controls.
		 */
		public function register_options( $options, $wp_customize ) {

			$configs = array(

				array(
					'name'     => 'elearning_load_google_fonts_locally_heading',
					'type'     => 'control',
					'control'  => 'elearning-title',
					'label'    => esc_html__( 'Load Google fonts locally', 'elearning' ),
					'section'  => 'elearning_optimization',
					'priority' => 5,
				),

				array(
					'name'     => 'elearning_load_google_fonts_locally',
					'default'  => 0,
					'type'     => 'control',
					'control'  => 'elearning-toggle',
					'label'    => esc_html__( 'Enable', 'elearning' ),
					'section'  => 'elearning_optimization',
					'priority' => 10,
				),

			);

			$options = array_merge( $options, $configs );

			return $options;
		}

	}

	new eLearning_Customize_Optimization_Option();

endif;
