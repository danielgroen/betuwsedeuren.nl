<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Viba_Portfolio_Meta_Boxes_Field_radio' ) ) :

class Viba_Portfolio_Meta_Boxes_Field_radio {

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
                <div class="viba-portfolio-section-title">' . $this->field['title'] . ':</div>
            </div>
            <div class="viba-portfolio-section-field">';    
            
            if (!empty($this->field['options'])) {

                echo '<ul>';
                
                foreach($this->field['options'] as $k => $v) {
                    
                    echo '<li>';
                    echo '<label for="'.$this->field['id'].'_'.array_search($k,array_keys($this->field['options'])).'">';
                    echo '<input type="radio" class="radio" id="'.$this->field['id'].'_'.array_search($k,array_keys($this->field['options'])).'" name="_'.$this->field['id'].'" value="'.$k.'" '.checked($this->value, $k, false).'/>';
                    echo ' <span>'.$v.'</span>';
                    echo '</label>';
                    echo '</li>';
                    
                }//foreach
                    
                echo '</ul>';

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