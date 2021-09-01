<?php
/**
 * Viba Portfolio Redux Settings
 *
 * @package    Viba_Portfolio/Admin/Settings
 * @since      1.0
 * @author     apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'redux/options/viba_portfolio_options/saved', 'viba_portfolio_delete_options_transients', 5 ); // on save
add_action( 'redux/options/viba_portfolio_options/reset', 'viba_portfolio_delete_options_transients', 5 ); // on reset
add_action( 'redux/options/viba_portfolio_options/section/reset', 'viba_portfolio_delete_options_transients', 5 ); // on section reset

if ( ! class_exists( 'Viba_Portfolio_Setup_Redux' ) ) {

    class Viba_Portfolio_Setup_Redux {

        public $args = array();
        public $sections = array();
        public $ReduxFramework;

        public function __construct() {

            if ( ! class_exists( 'ReduxFramework' ) ) {
                return;
            }

            $this->regenerate_thumnails_url = esc_url( 'https://wordpress.org/plugins/force-regenerate-thumbnails/' );

            if ( class_exists( 'ForceRegenerateThumbnails' ) ) {
                $this->regenerate_thumnails_url = admin_url( 'tools.php?page=force-regenerate-thumbnails' );
            }

            add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
            
        }

        public function initSettings() {

            // Set the default arguments
            $this->setArguments();

            // Create the sections and fields
            $this->setSections();

            if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

            $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args ) ;
        }

         /**
         * Remove the demo link and the notice of integrated demo from the redux-framework plugin
         */
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks' ), null, 2);
                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices' ) );

            }
        }

        /**
         * All the possible arguments for Redux.
         *
         * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         */
        public function setArguments() {

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name' => 'viba_portfolio_options', // This is where your data is stored in the database and also becomes your global variable name.
                //'global_variable' => false, // dynamic css isn't generated without this

                'display_name' => _x( 'Viba Portfolio', 'Options page title', 'viba-portfolio' ), // Name that appears at the top of your panel
                'display_version' => viba_portfolio()->version, // Version that appears at the top of your panel
                'menu_type' => current_user_can( 'manage_viba_portfolio' ) ? 'submenu' : false, //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'menu_title' => _x( 'Portfolio Options', 'Options menu title', 'viba-portfolio' ),
                'page_parent' => 'edit.php?post_type=' . viba_portfolio()->post_type . '', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_slug' => 'viba_portfolio_options', // Page slug used to denote the panel
                'admin_bar' => false,
                'last_tab' => '0',

                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '', // Must be defined to add google fonts to the typography module

                'dev_mode' => viba_portfolio()->debug, // Show the time the page took to load, etc
                'system_info' => viba_portfolio()->debug,
                'disable_tracking' => true,
                'show_import_export' => true,
                'customizer' => false, // Enable basic customizer support

                'save_defaults' => true, // On load save the defaults to DB before user clicks save or not
                'default_show' => false,
                
                // CAREFUL -> These options are for advanced use only
                //'transient_time' => 60 * MINUTE_IN_SECONDS,
                'output' => false, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag' => false, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
            );

        }

        public function setSections() {

            $this->sections[] = array(
                'title' => __( 'General Settings ', 'viba-portfolio' ),
                'icon' => 'el-icon-cogs',
                'fields' => array(
                    array(
                        'id' => 'has-archive',
                        'type' => 'switch',
                        'title' => __( 'Enable Archives', 'viba-portfolio' ),
                        'subtitle' => __( 'Enable this if you want archive pages like main post type archive, category and tag archives to be available.', 'viba-portfolio' ),
                        'on' => __( 'Enabled', 'viba-portfolio' ),
                        'off' => __( 'Disabled', 'viba-portfolio' ),
                        'default' => 0,
                    ),
                    array(
                        'id' => 'archive-page',
                        'type' => 'select',
                        'data' => 'pages',
                        'required' => array( 'has-archive', '=', '1' ),
                        'title' => __( 'Select Main Archive Page', 'viba-portfolio' ),
                        'subtitle' => __( 'Default page to show your portfolio items. For example pages like "Projects, Portfolio, Work" etc.', 'viba-portfolio' )
                    ),
                    array(
                        'id' => 'category-base',
                        'type' => 'vp_base',
                        'required' => array( 'has-archive', '=', '1' ),
                        'title' => __( 'Category Base', 'viba-portfolio' ),
                        'subtitle' => __( 'Set your category base for category archives.', 'viba-portfolio' ),
                        'default' => 'portfolio-category'
                    ),

                    array(
                        'id' => 'tag-base',
                        'type' => 'vp_base',
                        'required' => array( 'has-archive', '=', '1' ),
                        'title' => __( 'Tag Base', 'viba-portfolio' ),
                        'subtitle' => __( 'Set your tag base for tag archives.', 'viba-portfolio' ),
                        'default' => 'portfolio-tag'
                    ),

                    array(
                        'id' => 'permalinks-base',
                        'type' => 'vp_permalinks',
                        'title' => __( 'Permalinks', 'viba-portfolio' ),
                        'subtitle' => __( 'Control the permalinks used for portfolios.', 'viba-portfolio' ),
                        'desc' => __( 'Enter any custom base to use.', 'viba-portfolio' ),
                        'default' => '',
                        'validate_callback' => 'viba_portfolio_redux_validate_permalinks',
                    ),
                    array(
                        'id' => 'base-info',
                        'type' => 'info',
                        'notice' => true,
                        'style' => 'info',
                        'title' => __( 'Please Note', 'viba-portfolio' ),
                        'desc' => sprintf( __( '<strong>Category, Tag and Permalinks Base</strong> settings only apply when <strong>NOT using "default" permalinks</strong> under %s.', 'viba-portfolio' ), '<a href="'.admin_url( 'options-permalink.php' ).'">Settings->Permalinks</a>' ),
                    ),
                    
                    array(
                        'id' => 'image-size-thumbnail',
                        'type' => 'vp_image_size',
                        'title' => __( 'Portfolio Thumbnail', 'viba-portfolio' ),
                        'subtitle' => __( 'These sizes are used for portfolio thumbnails.', 'viba-portfolio' ),
                        'validate_callback'  => 'viba_portfolio_redux_validate_image_sizes',
                        'default' => array( 'width' => 500, 'height' => 500, 'crop' => 1 )
                    ),
                    array(
                        'id' => 'image-size-single',
                        'type' => 'vp_image_size',
                        'title' => __( 'Portfolio Single', 'viba-portfolio' ),
                        'subtitle' => __( 'These sizes are used for portfolio single items.', 'viba-portfolio' ),
                        'validate_callback'  => 'viba_portfolio_redux_validate_image_sizes',
                        'default' => array( 'width' => 1080, 'height' => 0, 'crop' => 0 )
                    ),
                    array(
                        'id' => 'multi-sizes',
                        'type' => 'switch',
                        'title' => __( 'Portfolio Multi-Size', 'viba-portfolio' ),
                        'subtitle' => __( 'Enable this if you want additional image sizes that will be used for portrait, landscape and big items.', 'viba-portfolio' ),
                        'on' => __( 'Enabled', 'viba-portfolio' ),
                        'off' => __( 'Disabled', 'viba-portfolio' ),
                        'default' => 0,
                    ),
                    array(
                        'id' => 'image-size-big',
                        'type' => 'vp_image_size',
                        'required' => array( 'multi-sizes', '=', '1' ),
                        'title' => __( 'Portfolio Big', 'viba-portfolio' ),
                        'subtitle' => __( 'Make this twice the size of thumbnails.', 'viba-portfolio' ),
                        'validate_callback'  => 'viba_portfolio_redux_validate_image_sizes',
                        'default' => array( 'width' => 1000, 'height' => 1000, 'crop' => 1 )
                    ),
                    array(
                        'id' => 'image-size-landscape',
                        'type' => 'vp_image_size',
                        'required' => array( 'multi-sizes', '=', '1' ),
                        'title' => __( 'Portfolio Landscape', 'viba-portfolio' ),
                        'subtitle' => __( 'Make the width twice as thumbnail size. Height needs to remain the same.', 'viba-portfolio' ),
                        'validate_callback'  => 'viba_portfolio_redux_validate_image_sizes',
                        'default' => array( 'width' => 1000, 'height' => 500, 'crop' => 1 )
                    ),
                    array(
                        'id' => 'image-size-portrait',
                        'type' => 'vp_image_size',
                        'required' => array( 'multi-sizes', '=', '1' ),
                        'title' => __( 'Portfolio Portrait', 'viba-portfolio' ),
                        'subtitle' => __( 'Make the height twice as thumbnail size. Width needs to remain the same.', 'viba-portfolio' ),
                        'validate_callback'  => 'viba_portfolio_redux_validate_image_sizes',
                        'default' => array( 'width' => 500, 'height' => 1000, 'crop' => 1 )
                    ),
                    array(
                        'id' => 'thumbnails-info',
                        'type' => 'info',
                        'notice' => true,
                        'style' => 'info',
                        'title' => __( 'Please Note', 'viba-portfolio' ),
                        'desc' => sprintf( __( 'After changing these settings you may need to %s. Entering 0 as width or height, with hard crop disabled, will give you auto height or auto width images keeping the aspect ratio.', 'viba-portfolio' ), '<a href="' .$this->regenerate_thumnails_url.'" target="_blank">Regenerate Thumbnails</a>' )
                    )
                )
            );

            $this->sections[] = array(
                'title' => __( 'Portfolio Styles', 'viba-portfolio' ),
                'icon' => 'el-icon-picture',
                'fields' => array(
                    array(
                        'id' => 'portfolio-style',
                        'type' => 'vp_style',
                        'options' => array(
                            'selected-style' => 'default',
                            'styles' => array(
                                'default' => viba_portfolio_admin_default_style_options( _x( 'Default', 'Default Style Title', 'viba-portfolio' ) )
                            )
                        ),
                        'default' => array(
                            'selected-style' => 'default',
                            'styles' => array(
                                'default' => viba_portfolio_admin_default_style_options( _x( 'Default', 'Default Style Title', 'viba-portfolio' ) )
                            )
                        )
                    )
                )
            );


            $this->sections[] = array(
                'title' => __( 'Single Portfolio', 'viba-portfolio' ),
                'icon' => 'el-icon-file',
                'fields' => array(
                    array(
                       'id'=>'single-layout',
                       'type' => 'button_set',
                       'title' => __( 'Portfolio Layout', 'viba-portfolio' ), 
                       'subtitle' => __( 'Select layout for your portfolio items.', 'viba-portfolio' ),
                       'options' => array(
                          'vp-single-full-width' => __( 'Full Width', 'viba-portfolio' ),
                          'vp-single-right-sidebar vp-single-sidebars' => __( 'Right Sidebar', 'viba-portfolio' ),
                          'vp-single-left-sidebar vp-single-sidebars' => __( 'Left Sidebar', 'viba-portfolio' )
                       ),
                       'default' => 'vp-single-full-width'
                    ), 
                    array(
                        'id' => 'single-meta',
                        'type' => 'checkbox',
                        'title' => __( 'Portfolio Meta', 'viba-portfolio' ),
                        'subtitle' => __( 'Check what meta informations you want to show with portfolio items.', 'viba-portfolio' ),
                        'options' => array(
                            'date'          => __( 'Date', 'viba-portfolio' ), 
                            'client'        => __( 'Client', 'viba-portfolio' ),
                            'categories'    => __( 'Categories', 'viba-portfolio' ), 
                            'tags'          => __( 'Tags', 'viba-portfolio' ), 
                            'project-link'  => __( 'Project Link', 'viba-portfolio' ),
                            'likes'         => __( 'Likes', 'viba-portfolio' ),
                            'share'         => __( 'Share Icons', 'viba-portfolio' )
                        ),
                        'default' => array(
                            'date' => 1, 
                            'client' => 1,
                            'categories' => 1, 
                            'tags' => 1, 
                            'project-link' => 1,
                            'likes' => 1,
                            'share' => 1,
                        )
                    ),
                    array(
                        'id' => 'single-share',
                        'type'     => 'sortable',
                        'mode'     => 'checkbox',
                        'title' => __( 'Portfolio Share Icons', 'viba-portfolio' ),
                        'subtitle' => __( 'Check what share icons you want to enable.', 'viba-portfolio' ),
                        'options' => array(
                            'facebook'      => __( 'Facebook', 'viba-portfolio' ), 
                            'twitter'       => __( 'Twitter', 'viba-portfolio' ),
                            'google-plus'   => __( 'Google Plus', 'viba-portfolio' ), 
                            'pinterest'     => __( 'Pinterest', 'viba-portfolio' ), 
                            'tumblr'        => __( 'Tumblr', 'viba-portfolio' ), 
                            'reddit'        => __( 'Reddit', 'viba-portfolio' ), 
                            'linkedin'      => __( 'Linkedin', 'viba-portfolio' ), 
                            'vk'            => __( 'VK', 'viba-portfolio' ), 
                            'mail'          => __( 'Mail', 'viba-portfolio' ),
                        ),
                        'default' => array(
                            'facebook' => 1, 
                            'twitter' => 1,
                            'google-plus' => 0, 
                            'pinterest' => 0, 
                            'tumblr' => 0, 
                            'reddit' => 0, 
                            'linkedin' => 0, 
                            'vk' => 0, 
                            'mail' => 0
                        )
                    ),
                    array(
                       'id'=>'gallery-type',
                       'type' => 'button_set',
                       'title' => __( 'Gallery Type', 'viba-portfolio' ),
                       'subtitle' => __( 'Select gallery type for your single portfolio items.', 'viba-portfolio' ),
                       'options' => array(
                          'slider' => __( 'Slider', 'viba-portfolio' ),
                          'carousel' => __( 'Carousel', 'viba-portfolio' ),
                          'stacked' => __( 'Stacked', 'viba-portfolio' ),
                          'grid' => __( 'Grid', 'viba-portfolio' )
                       ),
                       'default' => 'slider'
                    ),
                    array(
                        'id' => 'audio-thumbnail',
                        'type' => 'switch',
                        'title' => __( 'Audio Thumbnail', 'viba-portfolio' ),
                        'subtitle' => __( 'Show thumbnail on audio format portfolio items.', 'viba-portfolio' ),
                        'on' => __( 'Enabled', 'viba-portfolio' ),
                        'off' => __( 'Disabled', 'viba-portfolio' ),
                        'default' => 1,
                    ),
                    array(
                        'id' => 'related-items',
                        'type' => 'switch',
                        'title' => __( 'Show Related Items', 'viba-portfolio' ),
                        'subtitle' => __( 'Enable this option to show related items.', 'viba-portfolio' ),
                        'on' => __( 'Enabled', 'viba-portfolio' ),
                        'off' => __( 'Disabled', 'viba-portfolio' ),
                        'default' => 1,
                    ),
                    array(
                        'id' => 'related-layout',
                        'type' => 'button_set',
                        'required' => array( 'related-items', '=', '1' ),
                        'title' => __( 'Portfolio Related Layout', 'viba-portfolio' ),
                        'subtitle' => __( 'If you want to use Multi-Size Layout you must first enable Multi-Size Images in General Setting Tab.', 'viba-portfolio' ),
                        'options' => array(
                            'vp-layout-grid' => __( 'Grid', 'viba-portfolio' ),
                            'vp-layout-multi-size-grid' => __( 'Multi-Size Grid', 'viba-portfolio' ),
                            'vp-layout-carousel' => __( 'Carousel', 'viba-portfolio' ),
                        ),
                        'default' => 'vp-layout-carousel'
                    ),
                    array(
                        'id' => 'related-number',
                        'type' => 'slider',
                        'required' => array( 'related-items', '=', '1' ),
                        'title' => __( 'Number of Related Portfolio Items', 'viba-portfolio' ),
                        'subtitle' => __( 'Select Number of your related portfolio items.', 'viba-portfolio' ),
                        'default' => '6',
                        'min' => '1',
                        'step' => '1',
                        'max' => '24',
                    ),
                    array(
                        'id' => 'related-columns',
                        'type' => 'vp_columns',
                        'required' => array( 'related-items', '=', '1' ),
                        'title' => __( 'Related Portfolio Columns', 'viba-portfolio' ),
                        'subtitle' => __( 'Select Number of Columns for your related portfolio items.', 'viba-portfolio' ),
                        'options' => array(
                            'desktop-large' => 4,
                            'desktop-small' => 4,
                            'tablet-landscape' => 3,
                            'tablet-portrait' => 3,
                            'mobile-landscape' => 2,
                            'mobile-portrait' => 1
                        ),
                        'default' => array(
                            'desktop-large' => 4,
                            'desktop-small' => 4,
                            'tablet-landscape' => 3,
                            'tablet-portrait' => 3,
                            'mobile-landscape' => 2,
                            'mobile-portrait' => 1
                        ),
                        'min' => '1',
                        'step' => '1',
                        'max' => '6',
                    ),
                
                )
            );
            
             $this->sections[] = array(
                'title' => __( 'Advanced Options', 'viba-portfolio' ),
                'icon' => 'el-icon-wrench',
                'fields' => array(
                    array(
                        'id' => 'delete-data',
                        'type' => 'switch',
                        'title' => __( 'Delete Data On Uninstall', 'viba-portfolio' ),
                        'subtitle' => __( 'If enabled it will delete all portfolio items, categories, tags, all relationships between the post type and taxonomies and all options and styles when uninstalling via Plugins > Delete.', 'viba-portfolio' ),
                        'desc' => __( 'Please note if you enable this option it will take more time to finish deleting the plugin. Please be patient.', 'viba-portfolio' ),
                        'on' => __( 'Enabled', 'viba-portfolio' ),
                        'off' => __( 'Disabled', 'viba-portfolio' ),
                        'default' => 0,
                    ),
                    array(
                        'id' => 'delete-data-on-deactivation',
                        'type' => 'switch',
                        'title' => __( 'Delete Data On Deactivation', 'viba-portfolio' ),
                        'subtitle' => __( 'When you are using a multisite, plugins can\'t delete their data on uninstall. If this option is enabled all data from this plugin (all portfolio items, categories, tags and all options and styles) will be deleted on plugin deactivation.', 'viba-portfolio' ),
                        'desc' => __( 'Only works on a multisite. You will need to go through all your sites and enable this option and then go to Plugins > Deactivate. It won\'t work if you are on Network Admin and using Network Deactivate. Please note if you enable this option it will take more time to finish deactivating the plugin. Please be patient.', 'viba-portfolio' ),
                        'on' => __( 'Enabled', 'viba-portfolio' ),
                        'off' => __( 'Disabled', 'viba-portfolio' ),
                        'default' => 0,
                    ),
                    array(
                       'id'=>'scripts-position',
                       'type' => 'button_set',
                       'title' => __( 'Scripts Position', 'viba-portfolio' ), 
                       'subtitle' => __( 'Load scripts in head or footer.', 'viba-portfolio' ),
                       'options' => array(
                          'head' => _x( 'Head', 'Scripts Position', 'viba-portfolio' ),
                          'footer' => _x( 'Footer', 'Scripts Position', 'viba-portfolio' ),
                       ),
                       'default' => 'footer'
                    ), 
                    array(
                        'id' => 'load-all-scripts',
                        'type' => 'switch',
                        'title' => __( 'Load All Scripts', 'viba-portfolio' ),
                        'subtitle' => __( 'Load all Viba Portfolio scripts and styles on all pages. This is useful if you have an AJAX theme. If this option is disabled Viba Portfolio will load scripts and styles only on pages that require them.', 'viba-portfolio' ),
                        'on' => __( 'Enabled', 'viba-portfolio' ),
                        'off' => __( 'Disabled', 'viba-portfolio' ),
                        'default' => 0,
                    ),
                    array(
                        'id' => 'ajax-fix',
                        'type' => 'switch',
                        'title' => __( 'AJAX Fix', 'viba-portfolio' ),
                        'subtitle' => __( 'Some themes and page builders that don\'t use the default WordPress content area might have problems with using AJAX.', 'viba-portfolio' ),
                        'on' => __( 'Enabled', 'viba-portfolio' ),
                        'off' => __( 'Disabled', 'viba-portfolio' ),
                        'default' => 0,
                    ),
                    array(
                        'id' => 'ajax-likes-count',
                        'type' => 'switch',
                        'title' => __( 'AJAX Likes Count', 'viba-portfolio' ),
                        'subtitle' => __( 'If you are using a cacheing plugin the likes count might be incorrect. To fix that you need to dynamically load the likes count via AJAX.', 'viba-portfolio' ),
                        'on' => __( 'Enabled', 'viba-portfolio' ),
                        'off' => __( 'Disabled', 'viba-portfolio' ),
                        'default' => 0,
                    ),
                     array(
                        'id' => 'gfonts',
                        'type' => 'vp_gfonts',
                        'title' => __( 'Google Fonts', 'viba-portfolio' ),
                        'subtitle' => sprintf( __( 'Copy the Google Font Family from %s', 'viba-portfolio' ), '<a href="http://www.google.com/fonts">http://www.google.com/fonts</a>' ),
                        'default' => 'Montserrat:700|Raleway',
                    )
                )
            );

            $this->sections[] = array(
                'title' => __( 'Translations', 'viba-portfolio' ),
                'icon' => 'el-icon-asterisk',
                'fields' => array(
                    array(
                        'id' => 'i18n',
                        'type' => 'switch',
                        'title' => __( 'Internationalization', 'viba-portfolio' ),
                        'subtitle' => __( 'If disabled use the options below to translate the text.', 'viba-portfolio' ),
                        'on' => __( 'Enabled', 'viba-portfolio' ),
                        'off' => __( 'Disabled', 'viba-portfolio' ),
                        'default' => 0,
                    ),
                    array(
                        'id' => 'i18n-info',
                        'type' => 'info',
                        'notice' => true,
                        'style' => 'info',
                        'title' => __( 'Please Note', 'viba-portfolio' ),
                        'desc' => __( 'If you want to have a multilingual site you need to enable the Internationalization and use the textdomain "viba-portfolio" to translate the text.', 'viba-portfolio' )
                    ),
                    array(
                        'id' => 'i18n-filter',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Filter Text', 'viba-portfolio' ),
                        'default' => 'Filter',
                    ),
                   array(
                        'id' => 'i18n-filter-all',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Filter All Text', 'viba-portfolio' ),
                        'default' => 'All',
                    ),
                   array(
                        'id' => 'i18n-pagination-prev',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Pagination Previous Text', 'viba-portfolio' ),
                        'default' => '&laquo; Previous',
                    ),
                   array(
                        'id' => 'i18n-pagination-next',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Pagination Next Text', 'viba-portfolio' ),
                        'default' => 'Next &raquo;',
                    ),
                   array(
                        'id' => 'i18n-pagination-pages',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Pagination Pages Text', 'viba-portfolio' ),
                        'default' => 'Page %1$d of %2$d',
                    ),
                   array(
                        'id' => 'i18n-load-more',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Load More Text', 'viba-portfolio' ),
                        'default' => 'Load more',
                    ),
                   array(
                        'id' => 'i18n-button-zoom',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Zoom Button Text', 'viba-portfolio' ),
                        'default' => 'Zoom',
                    ),
                   array(
                        'id' => 'i18n-button-link',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Link Button Text', 'viba-portfolio' ),
                        'default' => 'Case Study',
                    ),
                   array(
                        'id' => 'i18n-ajax-prev',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Ajax Button Prev', 'viba-portfolio' ),
                        'default' => 'Previous',
                    ),
                   array(
                        'id' => 'i18n-ajax-next',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Ajax Button Next', 'viba-portfolio' ),
                        'default' => 'Next',
                    ),
                   array(
                        'id' => 'i18n-ajax-close',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Ajax Button Close', 'viba-portfolio' ),
                        'default' => 'Close',
                    ),
                   array(
                        'id' => 'i18n-meta-date',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Meta Date Text', 'viba-portfolio' ),
                        'default' => 'Date',
                    ),
                   array(
                        'id' => 'i18n-meta-client',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Meta Client Text', 'viba-portfolio' ),
                        'default' => 'Client',
                    ),
                   array(
                        'id' => 'i18n-meta-categories',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Meta Categories Text', 'viba-portfolio' ),
                        'default' => 'Categories',
                    ),
                   array(
                        'id' => 'i18n-meta-tags',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Meta Tags Text', 'viba-portfolio' ),
                        'default' => 'Tags',
                    ),
                   array(
                        'id' => 'i18n-meta-project-link',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Meta Project Link Text', 'viba-portfolio' ),
                        'default' => 'View Project',
                    ),
                   array(
                        'id' => 'i18n-related',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Related Items Text', 'viba-portfolio' ),
                        'default' => 'Related Items',
                    ),
                   array(
                        'id' => 'i18n-searchform',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Searchform Text', 'viba-portfolio' ),
                        'default' => 'Search portfolios',
                    ),
                   array(
                        'id' => 'i18n-search',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Search Page Text', 'viba-portfolio' ),
                        'default' => 'Search Results: &ldquo;%s&rdquo;',
                    ),
                   array(
                        'id' => 'i18n-no-items',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'No Items Text', 'viba-portfolio' ),
                        'default' => 'No portfolio items were found.',
                    ),
                   array(
                        'id' => 'i18n-search-not-found',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Search Nothing Found Text', 'viba-portfolio' ),
                        'default' => 'Sorry, but nothing matched your search terms. Please try again with some different keywords.',
                    ),
                   array(
                        'id' => 'i18n-share',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Share Text', 'viba-portfolio' ),
                        'default' => 'Share',
                    ),
                    array(
                        'id' => 'i18n-share-facebook',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Share Facebook Text', 'viba-portfolio' ),
                        'default' => 'Facebook',
                    ),
                   array(
                        'id' => 'i18n-share-twitter',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Share Twitter Text', 'viba-portfolio' ),
                        'default' => 'Twitter',
                    ),
                   array(
                        'id' => 'i18n-share-gplus',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Share Google Plus Text', 'viba-portfolio' ),
                        'default' => 'Google Plus',
                    ),
                   array(
                        'id' => 'i18n-share-pinterest',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Share Pinterest Text', 'viba-portfolio' ),
                        'default' => 'Pinterest',
                    ),
                   array(
                        'id' => 'i18n-share-tumblr',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Share Tumblr Text', 'viba-portfolio' ),
                        'default' => 'Tumblr',
                    ),
                   array(
                        'id' => 'i18n-share-reddit',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Share Reddit Text', 'viba-portfolio' ),
                        'default' => 'Reddit',
                    ),
                   array(
                        'id' => 'i18n-share-linkedin',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Share Linkedin Text', 'viba-portfolio' ),
                        'default' => 'Linkedin',
                    ),
                   array(
                        'id' => 'i18n-share-vk',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Share VK Text', 'viba-portfolio' ),
                        'default' => 'VK',
                    ),
                   array(
                        'id' => 'i18n-share-mail',
                        'type' => 'text',
                        'required' => array( 'i18n', '=', '0' ),
                        'title' => __( 'Share Mail Text', 'viba-portfolio' ),
                        'default' => 'Mail',
                    ),
                    
                )
            );

            $this->sections[] = array(
                'type' => 'divide',
            );

            $this->sections[] = array(
                'title' => __( 'Support/Docs', 'viba-portfolio' ),
                'icon' => 'el-icon-group',
                'fields' => array(
                    array(
                        'id' => 'support',
                        'type' => 'info',
                        'notice' => true,
                        'style' => 'info',
                        'title' => __( 'Support', 'viba-portfolio' ),
                        'desc' => sprintf( __( 'Need a help with Viba Portfolio? Support is available at %s', 'viba-portfolio' ), '<a target="_blank" href="http://plugins.apalodi.com/viba-portfolio/support/">http://plugins.apalodi.com/viba-portfolio/support/</a>' )
                    ),
                    array(
                        'id' => 'docs',
                        'type' => 'info',
                        'notice' => true,
                        'style' => 'info',
                        'title' => __( 'Documentation', 'viba-portfolio' ),
                        'desc' => sprintf( __( 'Extensive documentation is available at %s', 'viba-portfolio' ), '<a target="_blank" href="http://plugins.apalodi.com/viba-portfolio/documentation/">http://plugins.apalodi.com/viba-portfolio/documentation/</a>' )
                    ),
                    array(
                        'id' => 'support-docs',
                        'type' => 'info',
                        'notice' => true,
                        'title' => __( 'Please Note', 'viba-portfolio' ),
                        'desc' =>  sprintf( __( "If your archive and single pages aren't displayed the way you want (breaking layout) there is a <a target='_blank' href='%s'>step by step solution</a>.", 'viba-portfolio' ), 'http://plugins.apalodi.com/viba-portfolio/blog/how-to-integrate-viba-portfolio-with-themes/' )
                    ),
                    array(
                        'id' => 'support-docs',
                        'type' => 'info',
                        'notice' => true,
                        'title' => __( 'Please Note', 'viba-portfolio' ),
                        'desc' =>  sprintf( __( 'If your theme is using Redux Framework there might be some incompatibility issues. To fix that you will need to install the %s plugin.', 'viba-portfolio' ), '<a target="_blank" href="https://wordpress.org/plugins/redux-framework/"> Redux Framework</a>' )
                    ),
                ),
            );

            $this->sections[] = array(
                'title' => __( 'Tools', 'viba-portfolio' ),
                'icon' => 'el-icon-cog',
                'fields' => array(
                    array(
                        'id' => 'tools',
                        'type' => 'vp_tools',
                        'full_width' => true,
                    )
                )
            );

        }

    }

    new Viba_Portfolio_Setup_Redux();
}

if ( ! function_exists( 'viba_portfolio_redux_ajax_save' ) ) {
    /**
     * Custom redux ajax save that has not a limit for max_input_vars
     * because we aren't using the parse_str functions. We are using custom viba_portfolio_parse_str function.
     *
     * @since   1.7.0
     * @access  public
     * @return  array $return_array
     */
    function viba_portfolio_redux_ajax_save() {

        if ( ! wp_verify_nonce( $_REQUEST['nonce'], "redux_ajax_nonceviba_portfolio_options" ) ) {
            echo json_encode( array(
                'status' => __( 'Invalid security credential.  Please reload the page and try again.', 'viba-portfolio' ),
                'action' => ''
            ) );
            
            die();
        }
        
        if ( ! current_user_can( 'manage_viba_portfolio' ) ) {
            echo json_encode( array(
                'status' => __( 'Invalid user capability.  Please reload the page and try again.', 'viba-portfolio' ),
                'action' => ''
            ) );
            
            die();
        }
        
        $redux = ReduxFrameworkInstances::get_instance( 'viba_portfolio_options' );
        $dir = $redux::$_dir;

        if ( ! empty( $_POST['data'] ) ) {

            $values = array();

            $_POST['data'] = stripslashes( $_POST['data'] );
            //parse_str( $_POST['data'], $values );
            $values = viba_portfolio_parse_str( $_POST['data'] );
            $values = $values['viba_portfolio_options'];

            if ( function_exists( 'get_magic_quotes_gpc' ) && get_magic_quotes_gpc() ) {
                $values = array_map( 'stripslashes_deep', $values );
            }

            if ( ! empty ( $values ) ) {

                try {
                    if ( isset( $redux->validation_ran ) ) {
                        unset( $redux->validation_ran );
                    }
                    $redux->set_options( $redux->_validate_options( $values ) );

                    $do_reload = false;
                    if ( isset( $redux->reload_fields ) && ! empty( $redux->reload_fields ) ) {
                        if ( ! empty( $redux->transients['changed_values'] ) ) {
                            foreach ( $redux->reload_fields as $idx => $val ) {
                                if ( array_key_exists( $val, $redux->transients['changed_values'] ) ) {
                                    $do_reload = true;
                                }
                            }
                        }
                    }
                    
                    if ( $do_reload || ( isset ( $values['defaults'] ) && ! empty ( $values['defaults'] ) ) || ( isset ( $values['defaults-section'] ) && ! empty ( $values['defaults-section'] ) )) {
                        echo json_encode( array( 'status' => 'success', 'action' => 'reload' ) );
                        die ();
                    }

                    require_once $dir . 'core/enqueue.php';
                    $enqueue = new reduxCoreEnqueue( $redux );
                    $enqueue->get_warnings_and_errors_array();

                    $return_array = array(
                        'status'   => 'success',
                        'options'  => $redux->options,
                        'errors'   => isset ( $redux->localize_data['errors'] ) ? $redux->localize_data['errors'] : null,
                        'warnings' => isset ( $redux->localize_data['warnings'] ) ? $redux->localize_data['warnings'] : null,
                    );

                } catch ( Exception $e ) {
                    $return_array = array( 'status' => $e->getMessage() );
                }
            } else {
                echo json_encode( array( 'status' => __( 'Your panel has no fields. Nothing to save.', 'viba-portfolio' ) ) );
            }
        }

        if ( isset( $return_array ) ) {
            if ( $return_array['status'] == "success" ) {
                require_once $dir . 'core/panel.php';
                $panel = new reduxCorePanel( $redux );
                ob_start();
                $panel->notification_bar();
                $notification_bar = ob_get_contents();
                ob_end_clean();
                $return_array['notification_bar'] = $notification_bar;
            }

            echo json_encode( apply_filters( "redux/options/viba_portfolio_options/ajax_save/response", $return_array ) );
        }

        die ();

    }
}
remove_action( 'wp_ajax_viba_portfolio_options_ajax_save', array( 'ReduxFramework', 'ajax_save' ) );
add_action( 'wp_ajax_viba_portfolio_options_ajax_save', 'viba_portfolio_redux_ajax_save' );

/**
* Check if the first or last character is /, if not add it
*
**/
function viba_portfolio_redux_validate_permalinks( $field, $value, $existing_value ) {

    if ( $value[0] != '/' ) {
        $value = '/'.$value;
    }

    if ( substr( $value, -1 ) != '/' ) {
        $value = $value.'/';
    }

    $return['value'] = $value;

    return $return;
}

/**
* Check if the first or last character is /, if not add it
*
**/
function viba_portfolio_redux_validate_image_sizes( $field, $value, $existing_value ) {

    $msg = '';
    $error = false;

    if ( '0' == $value['width'] ) {

        $value['width'] = 0;

    } elseif ( ! is_numeric( $value['width'] ) ) {

        $error = true;
        $msg = _x( 'width', 'Admin panel error when entering non numeric value for height or width.', 'viba-portfolio' );
        $value['width'] = $existing_value['width'];

    }

    if ( '0' == $value['height'] ) {

        $value['height'] = 0;

    } elseif ( ! is_numeric( $value['height'] ) ) {

        $error = true;
        $msg .= ' '._x( 'height', 'Admin Panel error when entering non numeric value for height or width.', 'viba-portfolio' );
        $value['height'] = $existing_value['height'];

    }

    $return['value'] = $value;
    $field['msg'] = sprintf( _x( 'You must provide a numerical value for %s.', 'Admin panel error when entering non numeric value for height or width.', 'viba-portfolio' ), $msg );

    if ( $error == true ) {
        $return['error'] = $field;
    }

    return $return;

}