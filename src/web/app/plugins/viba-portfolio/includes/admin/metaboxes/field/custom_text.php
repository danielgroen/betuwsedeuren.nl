<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Viba_Portfolio_Meta_Boxes_Field_custom_text' ) ) :

class Viba_Portfolio_Meta_Boxes_Field_custom_text {

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

        echo '
        <div class="viba-portfolio-section '.$this->field['id'].' viba-portfolio-type-' . $this->field['type'] . ' '. $this->field['class'] .'">
            <p>' . __( 'Select other <strong>Formats</strong> for more options ( <em>they are below "Publish" button</em> ).', 'viba-portfolio' ) . '</p>
        </div>'; 
    }
}

endif;