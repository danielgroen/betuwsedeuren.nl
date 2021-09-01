<?php

function my_login_logo() { ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_site_url(); ?>/wp-content/themes/ArieAtlasTemplate/images/custom-login-logo.png);/**Vul de link naar de afbeelding in**/
			background-size: 320px 25px; /**Vul de breedte+hoogte in**/
			width: 320px; /**Vul de breedte in**/
			height: 25px; /**Vul de hoogte in**/
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

// Register Custom Navigation Walker
require_once('wp_bootstrap_navwalker.php');

register_nav_menus( array(
    'primary' => __( 'Primary Menu', 'ArieAtlasTemplate' ),
		'secondary' => __( 'Secondary Menu', 'ArieAtlasTemplate' ),
) );

if ( function_exists('register_sidebar') ) {
  register_sidebar(array(
  'before_widget' => '<li id="%1$s" class="widget %2$s">',
  'after_widget' => '</li>',
  'before_title' => '<h2 class="widgettitle">',
  'after_title' => '</h2>',
  ));
}

if ( function_exists('register_sidebar') ) {
	register_sidebar( array(
	'name' => 'Footer Sidebar 1',
	'id' => 'footer-sidebar-1',
	'description' => 'Appears in the footer area',
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
	) );
	register_sidebar( array(
	'name' => 'Footer Sidebar 2',
	'id' => 'footer-sidebar-2',
	'description' => 'Appears in the footer area',
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
	) );
	register_sidebar( array(
	'name' => 'Footer Sidebar 3',
	'id' => 'footer-sidebar-3',
	'description' => 'Appears in the footer area',
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
	) );
	register_sidebar( array(
	'name' => 'Footer Sidebar 4',
	'id' => 'footer-sidebar-4',
	'description' => 'Appears in the footer area',
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
	) );
  register_sidebar( array(
	'name' => 'Footer Sidebar 5',
	'id' => 'footer-sidebar-5',
	'description' => 'Appears in the footer area',
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
	) );
  register_sidebar( array(
	'name' => 'Header Sidebar',
	'id' => 'header-sidebar',
	'description' => 'Appears in the header area',
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '',
	'after_title' => '',
	) );
  register_sidebar( array(
  'name' => 'Product Sidebar',
  'id' => 'product-sidebar',
  'description' => 'Appears in the products area',
  'before_widget' => '',
  'after_widget' => '',
  'before_title' => '<h4 class="widget-title">',
  'after_title' => '</h4>',
  ) );
  register_sidebar( array(
  'name' => 'Filter Product Sidebar',
  'id' => 'filterproduct-sidebar',
  'description' => 'Appears in the products area',
  'before_widget' => '',
  'after_widget' => '',
  'before_title' => '',
  'after_title' => '',
  ) );
}

####################################################
####																						####
####						Afbeeldingen afsnijden 					####
####							naar juiste formaat						####
####																						####
####################################################

add_action( 'after_setup_theme', 'ja_theme_setup' );
function ja_theme_setup() {
    add_theme_support( 'post-thumbnails');
		add_image_size( 'header-big', 1920, 550, true ); //header big
		add_image_size( 'header-small', 1920, 250, true ); // header small
		add_image_size( 'referenties', 610, 350, true ); // referenties
		add_image_size( 'onze-acties', 320, 240, true ); // onze acties
		add_image_size( 'beeld-klein', 310, 180, true ); // beeld klein
		add_image_size( 'machines', 320, 200, true ); // machines
		add_image_size( 'footer-beeld', 160, 110, true ); // footer beeld
    add_image_size( 'merken-beeld', 425, 175, true ); // merken
}

add_action( 'after_setup_theme', 'yourtheme_setup' );

function mytheme_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

function yourtheme_setup() {
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}

add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );

function new_loop_shop_per_page( $cols ) {
  // $cols contains the current number of products per page based on the value stored on Options -> Reading
  // Return the number of products you wanna show per page.
  $cols = 50;
  return $cols;
}

add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {

	$tabs['description']['title'] = __( 'Uitvoering' );		// Rename the description tab
	$tabs['reviews']['title'] = __( 'Ratings' );				// Rename the reviews tab
	$tabs['additional_information']['title'] = __( 'Specificaties' );	// Rename the additional information tab

	return $tabs;

}

add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {

    unset( $tabs['reviews'] ); 			// Remove the reviews tab


    return $tabs;

}

add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );
function woo_new_product_tab( $tabs ) {

	// Adds the new tab

	$tabs['test_tab'] = array(
		'title' 	=> __( 'Leverbaar met', 'woocommerce' ),
		'priority' 	=> 50,
		'callback' 	=> 'woo_new_product_tab_content'
	);

	return $tabs;

}
function woo_new_product_tab_content() {

	// The new tab content

	echo '
  <div class="col-md-8 gray-background">';

  echo get_field('leverbaar_met');
  echo '</div>';

}

// Remove category slug from shop

add_action( 'pre_get_posts', 'remove_cat_from_shop_loop' );

function remove_cat_from_shop_loop( $q ) {

    if ( ! $q->is_main_query() ) return;
    if ( ! $q->is_post_type_archive() ) return;

    if ( ! is_admin() && is_shop() ) {

        $q->set( 'tax_query', array(array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => array( 'referenties' ), // Change it to the slug you want to hide
            'operator' => 'NOT IN'
        )));

    }

    remove_action( 'pre_get_posts', 'remove_cat_from_shop_loop' );

}

add_filter( 'woocommerce_product_add_to_cart_text', 'woo_archive_custom_cart_button_text' );    // 2.1 +

function woo_archive_custom_cart_button_text() {

        return __( 'Bekijk deze machine', 'woocommerce' );

}

/* Redirect naar product pagina als er maar 1 product in category is */
add_action( 'template_redirect', 'dean_redirect_als_er_maar_1_product_in_categorie_is', 10 );

function dean_redirect_als_er_maar_1_product_in_categorie_is ($wp_query) {
    global $wp_query;

    if (is_product_category()) {

        if ($wp_query->post_count==1) {

            $product = new WC_Product($wp_query->post->ID);

            if ($product->is_visible()) wp_safe_redirect( get_permalink($product->id), 302 );

            exit;
        }

    }

}

?>
