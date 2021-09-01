<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Viba_Portfolio_Meta_Boxes_Field_upload' ) ) :

class Viba_Portfolio_Meta_Boxes_Field_upload {

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
        $this->field['library'] = isset( $this->field['library'] ) ? $this->field['library'] : '';

        echo'
        <div class="viba-portfolio-section '.$this->field['id'].' viba-portfolio-type-' . $this->field['type'] . ' '. $this->field['class'] .'">

            <div class="viba-portfolio-section-info">
                <div class="viba-portfolio-section-title"><label for="' . $this->field['id'] . '">' . $this->field['title'] . ':</label></div>
            </div>
            
            <div class="viba-portfolio-section-field viba-portfolio-upload-tabs">
                
                <ul class="vp-upload-tabs">
                    <li><a href="#vp-' . $this->field['id'] . '-tab-1">'.__( 'Hosted', 'viba-portfolio' ).'</a></li>
                    <li><a href="#vp-' . $this->field['id'] . '-tab-2">'.__( 'External', 'viba-portfolio' ).'</a></li>
                </ul>

                <div id="vp-' . $this->field['id'] . '-tab-1" class="vp-upload-tab">';

                    if ( isset( $this->value['hosted'] ) && ! empty( $this->value['hosted'] ) ) {
                        foreach ( $this->value['hosted'] as $id ) {
                            $url = wp_get_attachment_url( $id );
                            echo '
                            <div class="viba-portfolio-upload-field viba-portfolio-hosted-field vp-active">
                                <input data-title="'. $this->field['title'] . '" data-library="' . $this->field['library'] . '" type="button" class="viba-portfolio-upload-button button" value="'. __( 'Add File', 'viba-portfolio' ) .'" />
                                <input type="hidden" class="viba-portfolio-hosted-upload" name="_' . $this->field['id'] . '[hosted][]" value="'.$id.'" />
                                <input readonly type="text" class="viba-portfolio-hosted-upload-url" value="'.$url.'" />
                                <button class="viba-portfolio-remove-button button">x</button>
                                <button class="viba-portfolio-empty-button button">x</button>
                            </div>';
                        }
                    } else {
                        echo '
                        <div class="viba-portfolio-upload-field viba-portfolio-hosted-field">
                            <input data-title="'. $this->field['title'] . '" data-library="' . $this->field['library'] . '" type="button" class="viba-portfolio-upload-button button" value="'. __( 'Add File', 'viba-portfolio' ) .'" />
                            <input type="hidden" class="viba-portfolio-hosted-upload" name="_' . $this->field['id'] . '[hosted][]" value="" />
                            <input readonly type="text" class="viba-portfolio-hosted-upload-url" />
                            <button class="viba-portfolio-remove-button button">x</button>
                            <button class="viba-portfolio-empty-button button">x</button>
                        </div>';
                    }

                    echo '
                    <input type="button" class="viba-portfolio-add-button button" value="'. __( 'Add New', 'viba-portfolio' ) .'" />';
                    
                    if ( isset( $this->field['desc-hosted'] ) ) {
                        echo '<div class="viba-portfolio-section-desc"><p class="howto">' . $this->field['desc-hosted'] . '</p></div>';
                    } 

                echo '
                </div>

                <div id="vp-' . $this->field['id'] . '-tab-2" class="vp-upload-tab">';
                    
                    if ( isset( $this->value['external'] ) && ! empty( $this->value['external'] ) ) {
                        foreach ( $this->value['external'] as $key => $value ) {
                            echo '
                            <div class="viba-portfolio-upload-field viba-portfolio-external-field vp-active">
                                <input type="text" class="viba-portfolio-ext-upload" name="_' . $this->field['id'] . '[external][]" value="' . esc_attr( $value ) . '" />
                                <button class="viba-portfolio-remove-button button">x</button>
                                <button class="viba-portfolio-empty-button button">x</button>
                            </div>';
                        }
                    } else {
                        echo '
                        <div class="viba-portfolio-upload-field viba-portfolio-external-field">
                            <input type="text" class="viba-portfolio-ext-upload" name="_' . $this->field['id'] . '[external][]" value="" />
                            <button class="viba-portfolio-remove-button button">x</button>
                            <button class="viba-portfolio-empty-button button">x</button>
                        </div>';
                    }

                    echo '
                    <input type="button" class="viba-portfolio-add-button button" value="'. __( 'Add New', 'viba-portfolio' ) .'" />';
                    
                    if ( isset( $this->field['desc-external'] ) ) {
                        echo '<div class="viba-portfolio-section-desc"><p class="howto">' . $this->field['desc-external'] . '</p></div>';
                    } 

                echo '

                </div>
            </div>
        </div>';

      
    }
}

endif;