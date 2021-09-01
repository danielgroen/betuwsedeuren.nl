<?php
/**
 * Viba Portfolio Helper Functions.
 *
 * General helper functions available on both the front-end and admin.
 *
 * @package 	Viba_Portfolio/Functions/Helpers
 * @since       1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Used to temporary override values from options page.
 *
 * @since   1.0
 * @access  public
 * @param   string $option Option id
 * @param   string $value Custom value to override the options default value
 */
function viba_portfolio_override_value( $option, $value ) {
    global $viba_portfolio_options;
    $viba_portfolio_options[$option] = $value;

    return $viba_portfolio_options;
}

/**
 * Parses the string into variables without the max_input_vars limitation.
 *
 * @since   1.7.0
 * @access  public
 * @param   string $string
 * @return  array $result
 */
function viba_portfolio_parse_str( $string ) {

    if ( '' == $string ) {
        return false;
    }

    $result = array();
    $pairs = explode( '&', $string );

    foreach( $pairs as $key => $pair ) {

        // use the original parse_str() on each element
        parse_str( $pair, $params );

        $k = key( $params );

        if( ! isset( $result[$k] ) ) {
            $result+=$params;
        } else {
            $result[$k] = viba_portfolio_array_merge_recursive( $result[$k], $params[$k] );
        }

    }

    return $result;
}

/**
 * Merge arrays without converting values with duplicate keys to arrays as array_merge_recursive does.
 *
 * As seen here http://php.net/manual/en/function.array-merge-recursive.php#92195
 *
 * @since   1.7.0
 * @access  public
 * @param   array $array1
 * @param   array $array2
 * @return  array $merged
 */
function viba_portfolio_array_merge_recursive( array $array1, array $array2 ) {
    $merged = $array1;

    foreach( $array2 as $key => $value ) {

        if ( is_array( $value ) && isset( $merged[$key] ) && is_array( $merged[$key] ) ) {
            $merged[$key] = viba_portfolio_array_merge_recursive( $merged[$key], $value );
        } else if ( is_numeric( $key ) && isset( $merged[$key] ) ) {
            $merged[] = $value;
        } else {
            $merged[$key] = $value;
        }
    }

    return $merged;
}

/**
 * Get opacity in valid format.
 *
 * @since   1.0
 * @access  public
 * @param   string $number Number between 0 and 100
 * @return  string $opacity
 */
function viba_portfolio_number_to_opacity( $number ) {
    
    if ( $number == '100' ) {
    	$opacity = '1';
    }
    elseif ( $number == '0' ) {
    	$opacity = '0';
    }
    else {
    	$opacity = '0.'.$number;
    }
    return $opacity;
}

/**
 * Implode array keys with desired value.
 *
 * @since   1.0
 * @access  public
 * @param   array $array
 * @param   string $value
 * @param   string|array $remove Array key or keys to remove before implode
 * @return  array $tags
 */
function viba_portfolio_implode_array_keys( $array, $value, $remove = false ) {
    
    if ( is_array( $remove ) ) {
        foreach ( $remove as $key ) {
            unset( $array[$key] );
        }
    } elseif ( $remove ) {
        unset( $array[$remove] );
    }

    $new_array = array();
    
    foreach ( $array as $key => $item ) {
    	if ( $array[$key] == $value ) {
    		$new_array[$key] = $item;
    	}
  
    }

    return implode( ' ', array_keys( $new_array ) );
}

/**
 * Tranfer array values into array keys with value 1 ( 1 - active ).
 *
 * @since   1.0
 * @access  public
 * @param   array $array
 * @return  array $array
 */
function viba_portfolio_array_value_into_keys( $array ) {
    foreach ( $array as $key => $item ) {
    	unset( $array[$key] );
    	$array[$item] = '1';
    }
    return $array;
}