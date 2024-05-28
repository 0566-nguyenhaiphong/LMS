<?php
/**
 * Extend WP_Customize_Control to add the gradient control.
 *
 * Class eLearning_Gradient_Control
 *
 * @package    ThemeGrill
 * @subpackage eLearning
 * @since      eLearning 3.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class to extend WP_Customize_Control to add the gradient customize control.
 *
 * Class eLearning_Gradient_Control
 */
class eLearning_Gradient_Control extends eLearning_Customize_Base_Additional_Control {

	/**
	 * Control's Type.
	 *
	 * @var string
	 */
	public $type = 'elearning-gradient';

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {

		parent::enqueue();

	}

	/**
	 * Suffix for slider.
	 *
	 * @var string
	 */
	public $suffix = '';


	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 */
	public function to_json() {

		parent::to_json();

		$this->json['default'] = $this->setting->default;
		if ( isset( $this->default ) ) {
			$this->json['default'] = $this->default;
		}
		$this->json['value'] = $this->value();

		$this->json['link']        = $this->get_link();
		$this->json['id']          = $this->id;
		$this->json['label']       = esc_html( $this->label );
		$this->json['description'] = $this->description;

		$this->json['suffix']      = $this->suffix;
		$this->json['input_attrs'] = $this->input_attrs;

	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see    WP_Customize_Control::print_template()
	 *
	 */
	protected function content_template() {
		?>

		<div class="customizer-text">
			<# if ( data.label ) { #>
			<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>

			<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</div>

		<div class="customize-control-content">

			<div class="color">
				<span class="customize-control-title"><?php esc_html_e( 'Color', 'elearning' ); ?></span>
				<input data-name="{{ data.name }}"
					   type="text"
					   data-default-color="{{ data.default['color'] }}"
					   data-alpha-enabled="true"
					   value="{{ data.value['color'] }}"
					   class="elearning-color-picker-alpha color-picker-hex"
				/>
			</div>

			<div class="color-stop">
				<span class="customize-control-title"><?php esc_html_e( 'Location', 'elearning' ); ?></span>
				<div class="slider-wrapper <# if ( data.description ) { #>slider-description<# } #>">
					<input <# if ( data.input_attrs && data.input_attrs['color-stop'] ) { #>
								<# if ( data.input_attrs['color-stop']['min'] ) { #>
									min="{{ data.input_attrs['color-stop']['min'] }}"
								<# } else { #>
									min="0"
								<# } #>
								<# if ( data.input_attrs['color-stop']['max'] ) { #>
									max="{{ data.input_attrs['color-stop']['max'] }}"
								<# } else { #>
									max="100"
								<# } #>
								<# if ( data.input_attrs['color-stop']['max'] ) { #>
									step="{{ data.input_attrs['color-stop']['step'] }}"
								<# } else { #>
									step="1"
								<# } #>
								<# if ( data.input_attrs['color-stop']['max'] ) { #>
									suffix="{{ data.input_attrs['color-stop']['suffix'] }}"
								<# } else { #>
									suffix="%"
								<# } #>
							<# } #>
						type="range"
						value="{{ data.value['color-stop'] }}" />
					<div class="elearning-range-value">
						<input type="number"
							   data-name="{{ data.name }}"
							   class="value elearning-range-input"
							   value="{{ data.value['color-stop'] }}" >
						<# if ( data.suffix ) { #>
						<span class="elearning-range-unit">{{ data.suffix }}</span>
						<# } #>
					</div>
				</div>
			</div>


			<div class="color-2">
				<span class="customize-control-title"><?php esc_html_e( 'Secondary Color', 'elearning' ); ?></span>
				<input data-name="{{ data.name }}"
					   type="text"
					   data-default-color="{{ data.default['color-2'] }}"
					   data-alpha-enabled="true"
					   value="{{ data.value['color-2'] }}"
					   class="elearning-color-picker-alpha color-picker-hex"
				/>
			</div>

			<div class="color-stop-2">
				<span class="customize-control-title"><?php esc_html_e( 'Location', 'elearning' ); ?></span>
				<div class="slider-wrapper <# if ( data.description ) { #>slider-description<# } #>">
					<input <# if ( data.input_attrs && data.input_attrs['color-stop-2'] ) { #>
								<# if ( data.input_attrs['color-stop-2']['min'] ) { #>
									min="{{ data.input_attrs['color-stop-2']['min'] }}"
								<# } else { #>
									min="0"
								<# } #>
								<# if ( data.input_attrs['color-stop-2']['max'] ) { #>
									max="{{ data.input_attrs['color-stop-2']['max'] }}"
								<# } else { #>
									max="100"
								<# } #>
								<# if ( data.input_attrs['color-stop-2']['max'] ) { #>
									step="{{ data.input_attrs['color-stop-2']['step'] }}"
								<# } else { #>
									step="1"
								<# } #>
								<# if ( data.input_attrs['color-stop-2']['max'] ) { #>
									suffix="{{ data.input_attrs['color-stop-2']['suffix'] }}"
								<# } else { #>
								   suffix="%"
								<# } #>
							<# } #>
					type="range"
					value="{{ data.value['color-stop-2'] }}" />
					<div class="elearning-range-value">
						<input type="number"
							   data-name="{{ data.name }}"
							   class="value elearning-range-input"
							   value="{{ data.value['color-stop-2'] }}" />
						<# if ( data.suffix ) { #>
						<span class="elearning-range-unit">{{ data.suffix }}</span>
						<# } #>
					</div>
				</div>
			</div>

			<div class="type">
				<div class="types">
					<div class="customizer-text">
						<# if ( data.label['gradient-type'] ) { #>
						<span class="customize-control-title">{{{ data.label['gradient-type'] }}}</span>
						<# } else { #>
						<span class="customize-control-title">Type</span>
						<# } #>
					</div>
					<select data-name="{{ data.name }}" {{{ data.inputAttrs }}}>
						<option value="linear"
						<# if ( 'linear' === data.value['gradient-type'] ) { #> selected <# } #>><?php esc_html_e( 'Linear', 'elearning' ); ?>
						</option>
						<option value="radial"
						<# if ( 'radial' === data.value['gradient-type'] ) { #> selected <# } #>><?php esc_html_e( 'Radial', 'elearning' ); ?>
						</option>
					</select>
				</div>
				<hr>

				<div class="type-linear">
					<div class="customizer-text">
						<span class="customize-control-title">Angle</span>
					</div>

					<div class="slider-wrapper <# if ( data.description ) { #>slider-description<# } #>">
						<input <# if ( data.input_attrs && data.input_attrs['gradient-angle'] ) { #>
									<# if ( data.input_attrs['gradient-angle']['min'] ) { #>
										min="{{ data.input_attrs['gradient-angle']['min'] }}"
									<# } else { #>
										min="0"
									<# } #>
									<# if ( data.input_attrs['gradient-angle']['max'] ) { #>
										max="{{ data.input_attrs['gradient-angle']['max'] }}"
									<# } else { #>
										max="100"
									<# } #>
									<# if ( data.input_attrs['gradient-angle']['max'] ) { #>
										step="{{ data.input_attrs['gradient-angle']['step'] }}"
									<# } else { #>
										step="1"
									<# } #>
									<# if ( data.input_attrs['gradient-angle']['max'] ) { #>
										suffix="{{ data.input_attrs['gradient-angle']['suffix'] }}"
									<# } else { #>
										suffix="%"
									<# } #>
								<# } #>
							   type="range"
							   value="{{ data.value['gradient-angle'] }}"/>
						<div class="elearning-range-value">
							<input type="number"
								   data-name="{{ data.name }}"
								   class="value elearning-range-input"
								   value="{{ data.value['gradient-angle'] }}" />
							<# if ( data.suffix ) { #>
							<span class="elearning-range-unit">{{ data.suffix }}</span>
							<# } #>
						</div>
					</div>
				</div>

				<div class="type-radial">
					<div class="customizer-text">
						<# if ( data.label['gradient-position'] ) { #>
						<span class="customize-control-title">{{{ data.label['gradient-position'] }}}</span>
						<# } else { #>
						<span class="customize-control-title">Position</span>
						<# } #>
					</div>
					<select data-name="{{ data.name }}" {{{ data.inputAttrs }}}>
						<option value="center center"
						<# if ( 'center center' === data.value['gradient-position'] ) { #> selected <# }
						#>><?php esc_html_e( 'Center Center', 'elearning' ); ?></option>
						<option value="center left"
						<# if ( 'center left' === data.value['gradient-position'] ) { #> selected <# }
						#>><?php esc_html_e( 'Center Left', 'elearning' ); ?></option>
						<option value="center right"
						<# if ( 'center right' === data.value['gradient-position'] ) { #> selected <# }
						#>><?php esc_html_e( 'Center Right', 'elearning' ); ?></option>
						<option value="top center"
						<# if ( 'top center' === data.value['gradient-position'] ) { #> selected <# }
						#>><?php esc_html_e( 'Top Center', 'elearning' ); ?></option>
						<option value="top left"
						<# if ( 'top left' === data.value['gradient-position'] ) { #> selected <# }
						#>><?php esc_html_e( 'Top Left', 'elearning' ); ?></option>
						<option value="top right"
						<# if ( 'top right' === data.value['gradient-position'] ) { #> selected <# }
						#>><?php esc_html_e( 'Top Right', 'elearning' ); ?></option>
						<option value="bottom center"
						<# if ( 'bottom center' === data.value['gradient-position'] ) { #> selected <# }
						#>><?php esc_html_e( 'Bottom Center', 'elearning' ); ?></option>
						<option value="bottom left"
						<# if ( 'bottom left' === data.value['gradient-position'] ) { #> selected <# }
						#>><?php esc_html_e( 'Bottom Left', 'elearning' ); ?></option>
						<option value="bottom right"
						<# if ( 'bottom right' === data.value['gradient-position'] ) { #> selected <# }
						#>><?php esc_html_e( 'Bottom Right', 'elearning' ); ?></option>
					</select>
				</div>

			</div>

		</div>



		<input class="gradient-hidden-value" value="{{ JSON.stringify( data.value ) }}" data-name="{{ data.name }}" type="hidden" {{{ data.link }}}>

		<?php
	}

	/**
	 * Don't render the control content from PHP, as it's rendered via JS on load.
	 */
	public function render_content() {
	}

}
