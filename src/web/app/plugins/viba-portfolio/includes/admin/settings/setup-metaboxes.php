<?php
/**
 * Viba Portfolio Metaboxes Settings.
 *
 * @package    Viba_Portfolio/Admin/Settings
 * @since      1.0
 * @author     apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

new Viba_Portfolio_Metaboxes( 
   array(
      'id' => 'viba-portfolio-metaboxes',
      'title' =>  _x( 'Viba Portfolio Options', 'Metaboxes Title', 'viba-portfolio' ),
      'pages' => array( 'viba_portfolio' ),  
      'context' => 'normal',
      'priority' => 'high',
      'fields' => array(

            array(
               'id'=>'viba_portfolio_excerpt',
               'type' => 'editor',
               'validate' => 'editor',
               'title' => __( 'Short Description', 'viba-portfolio' ), 
               'default' => ''
            ),

            array(
               'id'=>'viba_portfolio_image_size',
               'type' => 'radio',
               'title' => __( 'Image size', 'viba-portfolio' ), 
               'desc' => sprintf( __( 'If you want to use these image sizes you must enable them in <a href="%1$s">Portfolio Options</a>. These image sizes are used only for grid items, not the single pages.', 'viba-portfolio' ), admin_url( 'edit.php?post_type=viba_portfolio&page=viba_portfolio_options' ) ),
               'options' => array(
                  'viba_portfolio_thumbnail' => 'Default',
                  'viba_portfolio_big' => 'Big',
                  'viba_portfolio_landscape' => 'Landscape',
                  'viba_portfolio_portrait' => 'Portrait'
               ),
               'default' => 'viba_portfolio_thumbnail'
            ), 

            array(
               'id'=>'viba_portfolio_project_url',
               'type' => 'text',
               'validate' => 'url',
               'title' => __( 'Project URL', 'viba-portfolio' ), 
               'desc' => __( 'The live project URL ( e.g., http://www.project.com ).', 'viba-portfolio' ),
               'default' => ''
            ),

            array(
               'id'=>'viba_portfolio_client',
               'type' => 'text',
               'validate' => 'text',
               'title' => __( 'Client', 'viba-portfolio' ), 
               'desc' => __( 'The project client ( e.g., Client Inc. ).', 'viba-portfolio' ),
               'default' => ''
            ),

            array(
               'id'=>'viba_portfolio_client_url',
               'type' => 'text',
               'validate' => 'url',
               'title' => __( 'Client URL', 'viba-portfolio' ), 
               'desc' => __( 'The client URL ( e.g., http://www.client.com ).', 'viba-portfolio' ),
               'default' => ''
            ),


            array(
               'id'=>'viba_portfolio_layout',
               'type' => 'radio',
               'title' => __( 'Layout', 'viba-portfolio' ), 
               'desc' => __( 'Select layout for this portfolio item.', 'viba-portfolio' ),
               'options' => array(
                  'default' => 'Default',
                  'vp-single-full-width' => 'Full Width',
                  'vp-single-right-sidebar vp-single-sidebars' => 'Right Sidebar',
                  'vp-single-left-sidebar vp-single-sidebars' => 'Left Sidebar'
               ),
               'default' => 'default'
            ), 

            array(
               'id'=>'viba_portfolio_color',
               'type' => 'color',
               'validate' => 'color',
               'title' => __( 'Custom Color', 'viba-portfolio' ),
                'desc' => sprintf( __( 'To use these colors you must enable multi-color option in <a href="%1$s">Portfolio Options</a> for your custom style.', 'viba-portfolio' ), admin_url( 'edit.php?post_type=viba_portfolio&page=viba_portfolio_options' ) ), 
               'options' => array(
                  'background' => 'Background',
                  'text' => 'Text'
               ),
               'default' => array(
                  'background' => '#fff',
                  'text' => '#444'
               ),
            ), 

            array(
               'id'=>'viba_portfolio_post_formats_text',
               'type' => 'custom_text',
               'class' => 'full-width'
            ),

            array(
               'id'=>'viba_portfolio_gallery_type',
               'type' => 'radio',
               'class' => 'full-width',
               'title' => __( 'Gallery Type', 'viba-portfolio' ),
               'options' => array(
                  'default' => 'Default',
                  'slider' => 'Slider',
                  'carousel' => 'Carousel',
                  'stacked' => 'Stacked',
                  'grid' => 'Grid'
               ),
               'default' => 'default'
            ),

            array(
               'id'=>'viba_portfolio_gallery',
               'type' => 'gallery',
               'validate' => 'gallery',
               'class' => 'full-width',
               'title' => __( 'Gallery Images', 'viba-portfolio' ), 
               'desc' => __( 'Hold down "Ctrl" (Win) or "Command" (Mac) to select multiple images.', 'viba-portfolio' ),
               'default' => ''
            ),

            array(
               'id'=>'viba_portfolio_video',
               'type' => 'upload',
               'validate' => 'upload',
               'library' => 'video',
               'class' => 'full-width',
               'title' => __( 'Video', 'viba-portfolio' ), 
               'desc-hosted' => __( 'Upload or select video file (supports mp4, m4v, webm, ogv, wmv, flv).', 'viba-portfolio' ),
               'desc-external' => __( 'Just insert youtube or vimeo link (e.g. http://vimeo.com/67621971 or https://www.youtube.com/watch?v=Ip2ZGND1I9Q)', 'viba-portfolio' ),
               'default' => ''
            ),

            array(
               'id'=>'viba_portfolio_audio',
               'type' => 'upload',
               'validate' => 'upload',
               'library' => 'audio',
               'class' => 'full-width',
               'title' => __( 'Audio', 'viba-portfolio' ), 
               'desc-hosted' => __( 'Upload or select audio file (supports mp3, ogg, wma, m4a, wav).', 'viba-portfolio' ),
               'desc-external' => __( 'Just insert soundcloud link (e.g. https://soundcloud.com/samsmithworld/samsmithasaprocky)', 'viba-portfolio' ),
               'default' => ''
            ),

            array(
               'id'=>'viba_portfolio_link',
               'type' => 'link',
               'validate' => 'link',
               'class' => 'full-width',
               'title' => __( 'External URL', 'viba-portfolio' ), 
               'desc' => __( 'Link your project thumbnail to a custom URL ( e.g., http://www.example.com ). This will override the default URL for single project.', 'viba-portfolio' ),
               'default' => ''
            ),

      )
   )
);