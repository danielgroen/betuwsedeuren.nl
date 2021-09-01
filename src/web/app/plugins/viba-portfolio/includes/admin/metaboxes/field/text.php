<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Viba_Portfolio_Meta_Boxes_Field_text' ) ) :

class Viba_Portfolio_Meta_Boxes_Field_text {

    /**
     * Field Constructor.
     *
     * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
     *
     **/
    function __construct( $field = array(), $value ='' ) {
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

        echo'
        <div class="viba-portfolio-section '.$this->field['id'].' viba-portfolio-type-' . $this->field['type'] . ' '. $this->field['class'] .'">

            <div class="viba-portfolio-section-info">
                <div class="viba-portfolio-section-title"><label for="' . $this->field['id'] . '">' . $this->field['title'] . ':</label></div>
            </div>
            
            <div class="viba-portfolio-section-field">';    
                
                echo '<input type="text" class="text" id="'.$this->field['id'].'" name="_'.$this->field['id'].'" value="' . esc_attr( sanitize_text_field( $this->value ) ) . '" />';

                if ( isset( $this->field['desc'] ) ) {
                    echo '<div class="viba-portfolio-section-desc"><p class="howto">' . $this->field['desc'] . '</p></div>';
                }    
                
            echo ' 
            </div>
        </div>';

      
    }
}

endif;