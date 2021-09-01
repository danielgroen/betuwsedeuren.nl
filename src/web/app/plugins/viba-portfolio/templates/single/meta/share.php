<?php
/**
 * Viba Portfolio Meta Share.
 *
 * @package 	Viba_Portfolio/Templates/Single
 * @since 		1.0
 * @author 		apalodi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! is_viba_portfolio_share() || ! is_viba_portfolio_meta( 'share' ) ) return; 
	
global $viba_portfolio_options;

$share_buttons = $viba_portfolio_options['single-share'];
	
$default_onclick = "javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;";
$onclick = array(
	'facebook'		=> "javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600'); return false;",
	'twitter' 		=> "javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=420,width=550'); return false;",
	'google-plus' 	=> "javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=740,width=570'); return false;",
	'pinterest'		=> $default_onclick,
	'tumblr'		=> $default_onclick,
	'linkedin'		=> $default_onclick,
	'reddit'		=> $default_onclick,
	'vk'		 	=> $default_onclick,
	'mail'		 	=> ""
);

$share_text = array(
	'facebook' 		=> viba_portfolio_translate( 'i18n-share-facebook', __( 'Facebook', 'lumino' ) ),
	'twitter' 		=> viba_portfolio_translate( 'i18n-share-twitter', __( 'Twitter', 'lumino' ) ),
	'google-plus' 	=> viba_portfolio_translate( 'i18n-share-gplus', __( 'Google Plus', 'lumino' ) ),
	'pinterest' 	=> viba_portfolio_translate( 'i18n-share-pinterest', __( 'Pinterest', 'lumino' ) ),
	'tumblr' 		=> viba_portfolio_translate( 'i18n-share-tumblr', __( 'Tumblr', 'lumino' ) ),
	'linkedin' 		=> viba_portfolio_translate( 'i18n-share-linkedin', __( 'Linkedin', 'lumino' ) ),
	'reddit' 		=> viba_portfolio_translate( 'i18n-share-reddit', __( 'Reddit', 'lumino' ) ),
	'vk' 			=> viba_portfolio_translate( 'i18n-share-vk', __( 'VK', 'lumino' ) ),
	'mail' 			=> viba_portfolio_translate( 'i18n-share-mail', __( 'Mail', 'lumino' ) )
);

?>

<div class="viba-portfolio-share-icons">
	
	<span class="vp-share"><?php viba_portfolio_translate( 'i18n-share', __( 'Share', 'viba-portfolio' ), true ); ?></span>

	<ul>
		<?php foreach ( $share_buttons as $key => $value ) {
			if ( '1' == $value ) {
				$donclick = $onclick[$key] != '' ? ' onclick="'. $onclick[$key] .'"' : '';
				echo '<li>';
				echo '<a href="'. viba_portfolio_share_link( $key, false ) .'" class="viba-portfolio-share vp-share-'. $key .'"'. $donclick .'>'. $share_text[$key] .'</a>';
				echo '</li>';
			}
		} ?>
	</ul>

</div>