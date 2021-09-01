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
if( !class_exists( 'ReduxFramework_vp_image_size' ) ) {

    /**
     * Main ReduxFramework_vp_image_size class
     *
     * @since       1.0.0
     */
    class ReduxFramework_vp_image_size extends ReduxFramework {
    
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

            if ( empty( $this->extension_dir ) ) {
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
                $this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '/', $this->extension_dir ) );
            }    

            // No errors please
            $defaults = array(
                'width' => true,
                'height' => true,
                'crop' => true,
            );

            $this->field = wp_parse_args($this->field, $defaults);

            $defaults = array(
                'width' => '',
                'height' => '',
                'crop' => ''
            );

            $this->value = wp_parse_args($this->value, $defaults);     
        
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
            
            /**
              Width
             * */
            if ($this->field['width'] === true):
                echo '<div class="field-dimensions-input input-prepend">';
                echo '<span class="add-on"><i class="el el-resize-horizontal icon-large"></i></span>';
                echo '<input type="text" class="redux-dimensions-input redux-dimensions-width mini' . $this->field['class'] . '" placeholder="' . __( 'Width', 'viba-portfolio' ) . '" rel="' . $this->field['id'] . '-width" name="' . $this->field['name'] . '[width]' . $this->field['name_suffix'] . '" value="' . $this->value['width']. '">';
                echo '</div>';
            endif;

            /**
              Height
             * */
            if ($this->field['height'] === true):
                echo '<div class="field-dimensions-input input-prepend">';
                echo '<span class="add-on"><i class="el el-resize-vertical icon-large"></i></span>';
                echo '<input type="text" class="redux-dimensions-input redux-dimensions-height mini' . $this->field['class'] . '" placeholder="' . __( 'Height', 'viba-portfolio' ) . '" rel="' . $this->field['id'] . '-height" name="' . $this->field['name'] . '[height]' . $this->field['name_suffix'] . '" value="' . $this->value['height'] . '">';
                echo '</div>';
            endif;

            /**
              Crop
             * */
            if ($this->field['crop'] === true):

                echo '<label for="' . $this->field['id'] . '-crop">';
                    echo '<input type="checkbox" class="checkbox ' . $this->field['class'] . '" id="' . $this->field['id'] . '-crop" name="' . $this->field['name'] . '[crop]' . $this->field['name_suffix'] . '" value="1" ' . checked( $this->value['crop'], '1', false ) . '/>';
                    echo 'Hard Crop?</label>';

            endif;

            echo "</fieldset>";

        }      
        
    }
}
