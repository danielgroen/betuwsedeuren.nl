<?php
/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it un¸r the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     ReduxFramework
 * @author      Dovy Paukstys
 * @version     3.1.5
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'ReduxFramework_vp_base' ) ) {

    /**
     * Main ReduxFramework_vp_base class
     *
     * @since       1.0.0
     */
    class ReduxFramework_vp_base extends ReduxFramework {
    
        /**
         * Field Constructor.
         *
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        function __construct( $field = array(), $value ='', $parent ) {
        
            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;

        }

        /**
         * Field Render Function.
         *
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
            function render() {
                if ( ! empty( $this->field['data'] ) && empty( $this->field['options'] ) ) {
                    if ( empty( $this->field['args'] ) ) {
                        $this->field['args'] = array();
                    }

                    $this->field['options'] = $this->parent->get_wordpress_data( $this->field['data'], $this->field['args'] );
                    $this->field['class'] .= " hasOptions ";
                }

                if ( empty( $this->value ) && ! empty( $this->field['data'] ) && ! empty( $this->field['options'] ) ) {
                    $this->value = $this->field['options'];
                }

                //if (isset($this->field['text_hint']) && is_array($this->field['text_hint'])) {
                $qtip_title = isset( $this->field['text_hint']['title'] ) ? 'qtip-title="' . $this->field['text_hint']['title'] . '" ' : '';
                $qtip_text  = isset( $this->field['text_hint']['content'] ) ? 'qtip-content="' . $this->field['text_hint']['content'] . '" ' : '';
                //}

                $readonly = isset( $this->field['readonly'] ) ? ' readonly="readonly"' : '';

                if ( isset( $this->field['options'] ) && ! empty( $this->field['options'] ) ) {
                    
                    $placeholder = '';
                    if ( isset( $this->field['placeholder'] ) ) {
                        $placeholder = $this->field['placeholder'];
                    }                    
                    
                    foreach ( $this->field['options'] as $k => $v ) {
                        if ( ! empty( $placeholder ) ) {
                            $placeholder = ( is_array( $this->field['placeholder'] ) && isset( $this->field['placeholder'][ $k ] ) ) ? ' placeholder="' . esc_attr( $this->field['placeholder'][ $k ] ) . '" ' : '';
                        }
                        
                        echo '<div class="input_wrapper">';
                        echo '<label for="' . $this->field['id'] . '-text-' . $k . '">' . $v . '</label> ';
                        echo '<input ' . $qtip_title . $qtip_text . 'type="text" id="' . $this->field['id'] . '-text-' . $k . '" name="' . $this->field['name'] . '[' . $k . ']' . $this->field['name_suffix'] . '" ' . $placeholder . 'value="' . esc_attr( $this->value[ $k ] ) . '" class="regular-text ' . $this->field['class'] . '"' . $readonly . ' /><br />';
                        echo '</div>';
                    }
                    //foreach
                } else {
                    $placeholder = ( isset( $this->field['placeholder'] ) && ! is_array( $this->field['placeholder'] ) ) ? ' placeholder="' . esc_attr( $this->field['placeholder'] ) . '" ' : '';
                    echo '<input ' . $qtip_title . $qtip_text . 'type="text" id="' . $this->field['id'] . '-text" name="' . $this->field['name'] . $this->field['name_suffix'] . '" ' . $placeholder . 'value="' . esc_attr( $this->value ) . '" class="regular-text ' . $this->field['class'] . '"' . $readonly . ' />';
                }
   
                echo '<div class="description field-desc">';
                    printf( __('Archives will look something like this e.g. %1$s/<code>%2$s</code>/music/', 'viba-portfolio'), home_url(), esc_attr( $this->value ) );
                echo '</div>';
            }

            /**
             * Enqueue Function.
             * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
             *
             * @since ReduxFramework 3.0.0
             */
            function enqueue() {

                wp_enqueue_style(
                    'redux-field-text-css',
                    ReduxFramework::$_url . 'inc/fields/text/field_text.css',
                    time(),
                    true
                );
            }
        
    }
}
