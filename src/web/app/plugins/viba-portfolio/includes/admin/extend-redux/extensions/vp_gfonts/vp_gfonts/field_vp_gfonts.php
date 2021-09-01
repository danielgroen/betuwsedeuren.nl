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
if( !class_exists( 'ReduxFramework_vp_gfonts' ) ) {

    /**
     * Main ReduxFramework_vp_gfonts class
     *
     * @since       1.0.0
     */
    class ReduxFramework_vp_gfonts extends ReduxFramework {
    
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

            echo '<fieldset id="' . $this->field['id'] . '" class="redux-dimensions-container" data-id="' . $this->field['id'] . '">';

                echo '<div class="input_wrapper viba-portfolio-gfont">';
                echo '<input type="text" class="regular-text" placeholder="' . __( 'i.e.:Open+Sans:400italic,600,700', 'viba-portfolio') . '" name="' . $this->field['name'] . '" value="'. $this->value .'">';
                echo '</div>';

                echo '<br>';
                printf( __( 'Add a single google font e.g.: %s', 'viba-portfolio' ), '<code>Open+Sans:400italic,600,700</code>' );
                echo '<br><br>';
                printf( __( 'Add multiple google fonts with subset e.g.: %s', 'viba-portfolio' ), '<code>Roboto:400,700,700italic,900|Oswald:400,700,300&subset=latin,latin-ext,greek</code>' );

            echo "</fieldset>";

        }      

    }
}
