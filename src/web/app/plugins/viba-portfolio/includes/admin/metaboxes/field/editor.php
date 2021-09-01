<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Viba_Portfolio_Meta_Boxes_Field_editor' ) ) :

class Viba_Portfolio_Meta_Boxes_Field_editor {

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

                if ( !isset( $this->field['editor_args'] ) ) {
                    $this->field['editor_args'] = array();
                }

                // Setup up default args
                $defaults = array(
                    'textarea_name' => '_' . $this->field['id'],
                    'textarea_rows' => 2,
                    'media_buttons' => false,
                    'teeny' => true,
                    'quicktags' => false
                );

                $this->field['editor_args'] = wp_parse_args( $this->field['editor_args'], $defaults );
                
                wp_editor( wpautop( $this->value ), $this->field['id'], $this->field['editor_args'] );
            
                if ( isset( $this->field['desc'] ) ) {
                    echo '<div class="viba-portfolio-section-desc"><p class="howto">' . $this->field['desc'] . '</p></div>';
                }    
                
            echo ' 
            </div>
        </div>';

      
    }
}

endif;