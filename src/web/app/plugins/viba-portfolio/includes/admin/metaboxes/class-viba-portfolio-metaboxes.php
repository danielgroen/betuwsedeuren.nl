<?php
/**
 * Viba Portfolio Metaboxes.
 *
 * @package		Viba_Portfolio/Admin/Classes
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Viba_Portfolio_Metaboxes' ) ) :

class Viba_Portfolio_Metaboxes {

	public $meta_box;

	public function __construct( $meta_boxes ) {

		$this->meta_box = $meta_boxes;

		$post_type = apply_filters( 'viba_portfolio_post_type', 'viba_portfolio' );

		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes') );
		add_action( 'save_post', array( $this, 'save_meta_boxes' ) );

		add_action( 'transition_post_status', array( $this, 'setup_likes' ), 20, 3 );
	}

	/**
	 * On publish create meta box for likes.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	string $new_status
	 * @param 	string $old_status
	 * @param 	object $post Post object
	 */
	public function setup_likes( $new_status, $old_status, $post ) {
		
		if ( $post->post_type == viba_portfolio()->post_type && $old_status == 'draft' && $new_status == 'publish' ) {
			add_post_meta( $post->ID, '_viba_portfolio_likes', '0', true );	
		}

	}

	/**
	 * Add a custom meta noxes.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	array $meta_box Array with post meta data
	 */
	public function add_meta_boxes( $meta_box ) {
	    if ( in_array( $meta_box, $this->meta_box['pages'] ) ) {
			add_meta_box( $this->meta_box['id'], $this->meta_box['title'], array( &$this, 'show_meta_boxes' ),$meta_box, $this->meta_box['context'], $this->meta_box['priority'] );
		}
	}

	/**
	 * Get the meta box field type.
	 *
	 * Allows extending by other devs.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	public function get_meta_box_type( $field ) {
		global $post;

		if ( isset($field['type'] ) ) {

			$field_class = 'Viba_Portfolio_Meta_Boxes_Field_'.$field['type'];

			if ( ! class_exists( $field_class ) ) {
				$class_file = viba_portfolio()->admin_dir_path . '/metaboxes/field/' . $field['type'] . '.php';
			
				if ( file_exists( $class_file ) ) {
					require_once $class_file;
				}
			}

			if ( class_exists( $field_class ) ) {
				$value = '';

				if ( 'custom_text' != $field['type'] ) {
					$value = get_post_meta( $post->ID, '_'.$field['id'], true);
					$value = ( $value != '' ) ? $value : $field['default'];
					update_post_meta( $post->ID, '_'.$field['id'], $value );
				}
				
				$render = '';
				$render = new $field_class( $field, $value );
				$render->render();
			}
		}

	}

	/**
	 * Show Meta Boxes.
	 *
	 * @since 	1.0
	 * @access 	public
	 */
	public function show_meta_boxes() {

		// Use nonce for verification
		wp_nonce_field( viba_portfolio()->basename, 'viba_portfolio_meta_box_nonce' );

		foreach ( $this->meta_box['fields'] as $field ) {
			$this->get_meta_box_type( $field );
		}

	}

	/**
	 * Save Meta Boxes.
	 *
	 * @since 	1.0
	 * @access 	public
	 * @param 	int $post_id The post ID
	 */
	public function save_meta_boxes( $post_id ) {

		// check autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return;

		// verify nonce
		if ( ! isset( $_POST['viba_portfolio_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['viba_portfolio_meta_box_nonce'], viba_portfolio()->basename ) )
			return;

		if ( ! current_user_can( 'edit_page', $post_id ) ) 
			return;
		
		foreach ( $this->meta_box['fields'] as $field ) {
			
			// WordPress will not show custom fields which have keys starting with an "_" (underscore) in the custom fields
			$meta_key = '_'.$field['id'];

			if ( isset( $_POST[$meta_key] ) ) {

				$meta_value = $_POST[$meta_key];

				if ( isset( $field['validate'] ) ) {
					switch ( $field['validate'] ) {

						case 'text':
							$meta_value = sanitize_text_field( $meta_value );
							break;

						case 'url':
							$meta_value = filter_var( $meta_value, FILTER_VALIDATE_URL ) ? esc_url_raw( $meta_value ) : '';
							break;

						case 'link':
							if ( is_array( $meta_value ) ) {
								$meta_value['url'] = filter_var( $meta_value['url'], FILTER_VALIDATE_URL ) ? esc_url_raw( $meta_value['url'] ) : '';
							} else {
								$meta_value = filter_var( $meta_value, FILTER_VALIDATE_URL ) ? esc_url_raw( $meta_value ) : '';
							}
							break;

						case 'editor':
							$meta_value = wp_kses( 
								$meta_value, 
								apply_filters( 'viba_portfolio_editor_wp_kses',
									array(
										'a' 	=> array( 'href' => array(), 'title' => array() ), 
										'p' 	=> array(),
										'u'		=> array(),
										'ol' 	=> array(),
										'ul' 	=> array(),
										'li' 	=> array(),
										'br' 	=> array(), 
										'em' 	=> array(), 
										'del' 	=> array(),
										'span'	=> array( 'style' => array() ),
										'strong' => array()
									)
								)
							);
							break;

						case 'gallery':
							$meta_value = array_filter( explode( ',', $meta_value ) );
							$gallery = array();
							foreach ( $meta_value as $id ) {
								$gallery[] = $id;
							}
							$meta_value = $gallery;
							break;

						case 'upload':
							$upload = array( 'hosted' => array(), 'external' => array() );
							foreach ( $meta_value as $key => $value ) {
								if ( 'hosted' == $key ) {
									foreach ( $value as $sub_key => $id ) {
										if ( wp_get_attachment_url( $id ) ) {
											$upload[$key][] = $id;
										}
									}
								} 
								if ( 'external' == $key ) {
									foreach ( $value as $sub_key => $link ) {
										//check if its link
										$link = filter_var( $link, FILTER_VALIDATE_URL ) ? esc_url_raw( $link ) : '';
										$upload[$key][] = $link;
									}
								}
							}
							$upload['external'] = array_filter( $upload['external'] );
							$meta_value = $upload;
							break;

						case 'color':
							$test_color = '/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i'; // if user insert a HEX color with #
							
							if ( ! preg_match( $test_color, $meta_value['background'] ) ) {     
						        $meta_value['background'] = '#900';
						    }

						    if ( ! preg_match( $test_color, $meta_value['text'] ) ) {     
						        $meta_value['text'] = '#fff';
						    }

						    break;
						
						default:
							$meta_value = $meta_value;
							break;
					}
				}
				
				update_post_meta( $post_id, $meta_key, $meta_value );

			} 
			else {
				delete_post_meta( $post_id, $meta_key );
			}
		}

	}

}

endif;