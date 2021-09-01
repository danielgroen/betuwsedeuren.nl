<?php get_header(); ?>
<?php
	if ( is_front_page() ) {

		get_template_part('templates/customrows-home');

	} elseif(is_page('projecten')) {

		get_template_part('templates/customrows-projecten');

	} else {

		get_template_part('templates/customrows-page');

	}
	?>
<?php get_footer(); ?>
