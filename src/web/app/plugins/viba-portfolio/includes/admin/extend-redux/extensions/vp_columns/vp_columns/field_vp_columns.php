<?php
/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
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
if( !class_exists( 'ReduxFramework_vp_columns' ) ) {

    /**
     * Main ReduxFramework_vp_columns class
     *
     * @since       1.0.0
     */
    class ReduxFramework_vp_columns extends ReduxFramework {
    
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
        public function render() {

            echo '<div class="redux-field-container">';
            
            foreach ( $this->value as $key => $value ) : 

            echo '<fieldset id="viba_portfolio_options-' . $this->field['id'].'-'.$key . '" class="redux-field-container redux-field redux-field-init redux-container-slider" data-id="' . $this->field['id'].'-'.$key . '"  data-type="slider">';
                
                echo '<div class="viba-portfolio-columns-name">' . $key . '</div>';
                echo '<input type="text" name="' . $this->field['name'].'['.$key.']" class="redux-slider-input redux-slider-input-one-' . $this->field['id'].'-'.$key . '" value="' . $value . '"/>';
                    echo '<div class="redux-slider-container"  id="' . $this->field['id'].'-'.$key . '"  data-id="' . $this->field['id'].'-'.$key . '" data-min="' . $this->field['min'] . '" data-max="' . $this->field['max'] . '" data-step="' . $this->field['step'] . '" data-handles="1" data-display="2" data-rtl="" data-float-mark="." data-resolution="1" data-default-one="' . $value . '"></div>';

            echo '</fieldset>';

            endforeach;

            echo "</div>"; 

        }      
        
    }
}
