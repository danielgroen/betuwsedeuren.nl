<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Viba_Portfolio_Meta_Boxes_Field_gallery' ) ) :

class Viba_Portfolio_Meta_Boxes_Field_gallery {

    /**
     * Field Constructor.
     *
     * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
     *
     **/
    function __construct( $field = array(), $value = '' ) {
        $this->field = $field;
        $this->value = $value;
    }

    /**
     * Field Render Function.
     * 
     * Takes the vars and outputs the HTML for the field in the settings
     * 
    **/
    function render() {

        $this->field['class'] = isset( $this->field['class'] ) ? $this->field['class'] : '';

        $gallery_ids = '';
        if ( is_array( $this->value ) ) {
            $gallery_ids = implode( ',', $this->value );
        }
        
        echo'
        <div class="viba-portfolio-section '.$this->field['id'].' viba-portfolio-type-' . $this->field['type'] . ' '. $this->field['class'] .'">

            <div class="viba-portfolio-section-info">
                <div class="viba-portfolio-section-title">' . $this->field['title'] . ':</div>
            </div>
            
            <div class="viba-portfolio-section-field">
                
                <input type="hidden" class="viba-portfolio-gallery-images-ids" name="_' . $this->field['id'] . '" id="' . $this->field['id'] . '" value="'. esc_attr( $gallery_ids ) . '" />
                <input type="button" class="button" name="' . $this->field['id'] . '-button" id="' . $this->field['id'] . '-button" value="'. __( 'Add To Gallery', 'viba-portfolio' ) .'" />';

                if ( isset( $this->field['desc'] ) ) {
                    echo '<div class="viba-portfolio-section-desc"><p class="howto">' . $this->field['desc'] . '</p></div>';
                } 
                echo'
                <ul class="viba-portfolio-gallery-thumbs">';

                    if( $this->value ) {
                        $gallery_output = '';
                        foreach( $this->value as $id  ) {
                            $post = get_post( $id );
                            if ( $post && wp_get_attachment_image( $id ) ) {
                                $image_caption = $post->post_excerpt != '' ? '<span class="viba-portfolio-caption">'. esc_attr( $post->post_excerpt ) .'</span>' : '';
                                $gallery_output .= '
                                <li data-attachment-id="'.$id.'">
                                    ' . wp_get_attachment_image( $id ) . '
                                    <a href="'. get_edit_post_link( $id ) . '" class="viba-portfolio-actions edit" title="' . __( 'Edit Image', 'viba-portfolio' ) . '"></a>
                                    <span class="viba-portfolio-actions delete" title="'. __( 'Delete Image', 'viba-portfolio' ) .'"></span>
                                    '. $image_caption .'
                                </li>';
                            }
                        }
                        echo $gallery_output;
                    }

                echo'
                </ul>
            </div>
        </div>';

      
    }
}

endif;