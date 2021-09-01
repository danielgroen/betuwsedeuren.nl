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
if( !class_exists( 'ReduxFramework_vp_tools' ) ) {

    /**
     * Main ReduxFramework_vp_tools class
     *
     * @since       1.0.0
     */
    class ReduxFramework_vp_tools extends ReduxFramework {
    
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

            //export_wp();
            $export = new Viba_Portfolio_Export();

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

            $export_url = esc_url( add_query_arg( 
                array(
                    'action' => 'viba_portfolio_export',
                    'nonce' => wp_create_nonce( 'viba-portfolio-export-nonce' )
                ),
                viba_portfolio()->ajax_url
            ) );
            $ajax_url = viba_portfolio()->ajax_url;
            $nonce = wp_create_nonce( 'viba-portfolio-export-nonce' );

            ?>
            
            <div class="viba-portfolio-tool">
                <div class="vp-tool-title">
                    <?php _e( 'Export your portfolio items', 'viba-portfolio' ); ?>
                </div>
                <div class="vp-tool-action">
                    <a class="button" href="<?php echo $export_url; ?>"><?php _e( 'Download Export File', 'viba-portfolio' ); ?></a>
                </div>
            </div>
            
        <?php 
        }     
        
    }
}
