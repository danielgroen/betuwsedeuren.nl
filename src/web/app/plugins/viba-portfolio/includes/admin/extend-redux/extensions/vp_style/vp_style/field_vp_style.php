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
if( !class_exists( 'ReduxFramework_vp_style' ) ) {

    /**
     * Main ReduxFramework_vp_style class
     *
     * @since       1.0.0
     */
    class ReduxFramework_vp_style extends ReduxFramework {
    
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
            
            if ( ! is_array( $this->value ) && isset( $this->field['options'] ) ) {
                $this->value = $this->field['options'];
            }

            global $viba_portfolio_options;

            $styles = $viba_portfolio_options['portfolio-style']['styles'];

            echo '<div class="viba-portfolio-styles-desc">';
                _e('Default style is used for archives and single pages and can\'t be deleted.', 'viba-portfolio');
            echo '</div>';

            echo '<div class="viba-portfolio-add-style viba-portfolio-styles-actions">';
            echo '<span>' .__('Create new styles', 'viba-portfolio' ) . '</span>';
            echo '<input type="text" class="viba-portfolio-input-new-style" placeholder="'.__('Enter Style Name', 'viba-portfolio').'">';
            echo '<a href="#" class="button button-primary" data-nonce="'. wp_create_nonce( 'viba-portfolio-styles-nonce' ) . '">'.__('Create New Style', 'viba-portfolio').'</a>';
            echo '</div>';

            echo '<div class="viba-portfolio-duplicate-style viba-portfolio-styles-actions">';
            echo '<span>' .__('Duplicate styles', 'viba-portfolio' ) . '</span>';
            echo '<select class="viba-portfolio-duplicate-style-select">';
            foreach ( $styles as $key => $value ) {
                echo '<option value="'.esc_attr( $key ). '">' . esc_html( $value['title'] ). '</option>';
            }
            echo '</select>';
            echo '<input type="text" class="viba-portfolio-input-duplicate-style" placeholder="'.__('Enter Style Name', 'viba-portfolio').'">';
            echo '<a href="#" class="button button-primary" data-nonce="'. wp_create_nonce( 'viba-portfolio-styles-nonce' ) . '">'.__('Duplicate Style', 'viba-portfolio').'</a>';
            echo '</div>';

            echo '<div id="viba-portfolio-styles">';
        
            foreach ( $this->value['styles'] as $key => $value ) {
                viba_portfolio_admin_generate_style_options( $value['title'], $value );
            }
                
            echo '</div><!-- accordian closing content div -->';

        }    

        /**
         * Enqueue Function.
         *
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function enqueue() {

            $extension = ReduxFramework_Extension_vp_style::getInstance();

            wp_enqueue_style( 'wp-color-picker' );

            wp_enqueue_script(
                'redux-field-color-js',
                ReduxFramework::$_url . 'inc/fields/color/field_color' . Redux_Functions::isMin() . '.js',
                array( 'jquery', 'wp-color-picker', 'redux-js' ),
                time(),
                true
            );

            if ( ! wp_script_is( 'ace-editor-js' ) ) {
                Redux_CDN::enqueue_script(
                    'ace-editor-js',
                    '//cdn.jsdelivr.net/ace/1.1.9/min/ace.js',
                    array( 'jquery' ),
                    '1.1.9',
                    true
                );
            }

             wp_enqueue_style(
                'redux-field-ace-editor-css',
                ReduxFramework::$_url . 'inc/fields/ace_editor/field_ace_editor.css',
                time(),
                true
            );


            wp_enqueue_style(
                'redux-field-vp-style-css', 
                $this->extension_url . 'field_vp_style.css',
                time(),
                true
            );

            wp_enqueue_script('jquery-ui-accordion');
            wp_enqueue_script('jquery-ui-tabs');
            wp_enqueue_script(
                'redux-field-vp-style-js', 
                $this->extension_url . 'field_vp_style.js',
                time(),
                true
            );
        
        }   
        
    }
}
