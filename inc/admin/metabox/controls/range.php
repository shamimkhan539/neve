<?php
/**
 * Metabox range control.
 *
 * @package Neve\Admin\Metabox\Controls
 */

namespace Neve\Admin\Metabox\Controls;

/**
 * Class Range
 *
 * @package Neve\Admin\Metabox\Controls
 */
class Range extends Control_Base {
	/**
	 * Render control.
	 *
	 * @return void
	 */
	public function render_content( $post_id ) {
		$value  = $this->get_value( $post_id );
		$markup = '';

		$markup .= '<p class="neve-range-input" style="display: flex; align-items: center; justify-content: space-between;">';
		$markup .= '<input type="range" 
		value="' . esc_attr( $value ) . '" 
		id="' . esc_attr( $this->id ) . '-range' . '"
		class="nv-range" 
		name="' . esc_attr( $this->id ) . '" 
		min="' . $this->settings['min'] . '" 
		max="' . $this->settings['max'] . '" >';
		$markup .= '<input type="number" 
		value="' . esc_attr( $value ) . '" 
		id="' . esc_attr( $this->id ) . '" 
		class="nv-number" 
		name="' . esc_attr( $this->id ) . '" 
		min="' . $this->settings['min'] . '" 
		max="' . $this->settings['max'] . '" >';
		$markup .= '</p>';

		echo $markup;
	}


}
