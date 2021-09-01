<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Viba_Portfolio_Meta_Boxes_Field_color' ) ) :

class Viba_Portfolio_Meta_Boxes_Field_color {

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
        $default = isset( $this->value['default'] ) ? $this->value['default'] : 0;
        echo'
        <div class="viba-portfolio-section '.$this->field['id'].' viba-portfolio-type-' . $this->field['type'] . ' '. $this->field['class'] .'">
            <div class="viba-portfolio-section-info">
                <div class="viba-portfolio-section-title">' . $this->field['title'] . ':</div>
            </div>
            <div class="viba-portfolio-section-field">';    
            
            if (!empty($this->field['options'])) {

                echo '<div class="viba-portfolio-color-picker-wrapper">';

                    echo '<div class="viba-portfolio-color-picker" data-id="' . $this->field['id'] . '" data-type="color">';

                        echo '<strong>' . $this->field['options']['background'] . '</strong><input data-id="-' . $this->field['id'] . '" id="' . $this->field['id'] . '_background" name="_' . $this->field['id'] . '[background]" value="'.$this->value['background'].'" class="viba-portfolio-color-init"  type="text" data-default-color="' . esc_attr( $this->value['background'] ) . '" />';
                    
                    echo '</div>';

                    echo '<div class="viba-portfolio-color-picker" data-id="' . $this->field['id'] . '" data-type="color">';

                        echo '<strong>' . $this->field['options']['text'] . '</strong><input data-id="-' . $this->field['id'] . '" id="' . $this->field['id'] . '_text" name="_' . $this->field['id'] . '[text]" value="'.$this->value['text'].'" class="viba-portfolio-color-init"  type="text" data-default-color="' . esc_attr( $this->value['text'] ) . '" />';
                    
                    echo '</div>';


                echo '</div>';

                if ( isset( $this->field['desc'] ) ) {
                    echo '<div class="viba-portfolio-section-desc"><p class="howto">' . $this->field['desc'] . '</p></div>';
                }    
                
            }

            echo ' 
            </div>
        </div>';

      
    }
}

endif;