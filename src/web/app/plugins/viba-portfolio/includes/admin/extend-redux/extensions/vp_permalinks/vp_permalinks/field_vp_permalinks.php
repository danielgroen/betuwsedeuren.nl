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
if( !class_exists( 'ReduxFramework_vp_permalinks' ) ) {

    /**
     * Main ReduxFramework_vp_permalinks class
     *
     * @since       1.0.0
     */
    class ReduxFramework_vp_permalinks extends ReduxFramework {
    
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

            // Set default args for this field to avoid bad indexes. Change this to anything you use.
            $defaults = array(
                'options'           => array()
            );
            $this->field = wp_parse_args( $this->field, $defaults );            
        
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
        public function render() { ?>

            <table class="viba-portfolio-form-table">
                <tbody>
                    <tr>
                        <th><label><input type="radio" name="viba_portfolio_permalink" value="" class="viba_portfolio_permalink"  checked='checked' /><?php _e( 'Default', 'viba-portfolio'); ?> </label></th>
                        <td>
                        <p class="howto"><?php _e( 'When the archive page is selected that page name will be the default base.', 'viba-portfolio' ); ?></p>
                        <code><?php printf( __( 'E.g. %s/archive-page/sample-project','viba-portfolio'), home_url() );?></code> 
                        <br><br>
                        <p class="howto"><?php _e( "When the archive page isn't selected.", "viba-portfolio" ); ?></p>
                        <code><?php printf( __( 'E.g. %s=sample-project','viba-portfolio'), home_url().'/?'.viba_portfolio()->post_type );?></code> <br><br></td>
                    </tr>
                    <tr>
                        <th><label><input type="radio" name="viba_portfolio_permalink" value="/projects/" class="viba_portfolio_permalink"  /> <?php _e( 'Custom base', 'viba-portfolio'); ?></label></th>
                        <td><code><?php printf( __( 'E.g. %s/projects/sample-project','viba-portfolio'), home_url() );?></code></td>
                    </tr>
                    <tr>
                        <th><label><input type="radio" name="viba_portfolio_permalink" value="/projects/%<?php echo viba_portfolio()->category_taxonomy; ?>%/" class="viba_portfolio_permalink"  /> <?php _e( 'Custom base with category', 'viba-portfolio'); ?></label></th>
                        <td><code><?php printf( __( 'E.g. %s/projects/photography/sample-project/','viba-portfolio'), home_url() );?></code></td>
                    </tr>
                    <tr>
                        <th><label><input type="radio" name="viba_portfolio_permalink" value="/custom/" class="viba_portfolio_permalink_custom"  /> <?php _e( 'Custom', 'viba-portfolio'); ?></label></th>
                    </tr>
                    
                </tbody>
            </table>
            <br>
        
            <?php if (empty($this->value) && !empty( $this->field['data'] ) && !empty( $this->field['options'] )) {
                $this->value = $this->field['options'];
            }

            $placeholder = (isset($this->field['placeholder']) && !is_array($this->field['placeholder'])) ? ' placeholder="' . esc_attr($this->field['placeholder']) . '" ' : '';

            if ( isset( $this->field['options'] ) && !empty( $this->field['options'] ) ) {
                $placeholder = (isset($this->field['placeholder']) && !is_array($this->field['placeholder'])) ? ' placeholder="' . esc_attr($this->field['placeholder']) . '" ' : '';
                foreach($this->field['options'] as $k => $v){
                    if (!empty($placeholder)) {
                        $placeholder = (is_array($this->field['placeholder']) && isset($this->field['placeholder'][$k])) ?  ' placeholder="' . esc_attr($this->field['placeholder'][$k]) . '" ' : '';
                    }
                    echo '<label for="' . $this->field['id'] . '-text-'.$k.'"><strong>'.$v.'</strong></label> ';
                    echo '<input type="text" id="' . $this->field['id'] . '-text-' . $k . '" name="' . $this->field['name'] . '['.$k.']' . $this->field['name_suffix'] . '" ' . $placeholder . 'value="' . esc_attr($this->value[$k]) . '" class="regular-text ' . $this->field['class'] . '" /><br />';
                    
                }//foreach
                
            } else {
                
                echo '<input type="text" id="' . $this->field['id'] . '-text" name="' . $this->field['name'] . $this->field['name_suffix'] . '" ' . $placeholder . 'value="' . esc_attr($this->value) . '" class="regular-text ' . $this->field['class'] . '" />';
            }

        }     
        
    }
}
