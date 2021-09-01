<?php

function viba_portfolio_admin_default_style_options( $title ) {

	return array(
		'title' => $title,
		'size' => 'vp-size-default',
		'layout' => 'vp-layout-grid',
		'padding' => array(
			'desktop-large' => '0',
			'desktop-small' => '0',
			'tablet-landscape' => '0',
			'tablet-portrait' => '0',
			'mobile-landscape' => '0',
			'mobile-portrait' => '0'
		),
		'number' => 8,
		'columns' => array(
			'desktop-large' => 4,
			'desktop-small' => 4,
			'tablet-landscape' => 3,
			'tablet-portrait' => 3,
			'mobile-landscape' => 2,
			'mobile-portrait' => 1
		),
		'margins' => array(
			'desktop-large' => 10,
			'desktop-small' => 10,
			'tablet-landscape' => 10,
			'tablet-portrait' => 10,
			'mobile-landscape' => 10,
			'mobile-portrait' => 10
		),
		'hover-effect' => array(
			'overlay' => array(
				'vp-overlay' => 1,
				'vp-slide-overlay' => 0
			),
			'image' => 'none'
		),
		'animation' => 'none',
		'overlay-opacity' => '90',
		'overlay-visibility' => 'vp-overlay-on-hover',
		'informations' => array(
			'zoom-button' => 1,
			'link-button' => 0,
			'title' => 1,
			'categories' => 1,
			'likes' => 1,
			'description' => 0,
		),
		'horizontal-align' => 'vp-horizontal-align-left',
		'cover-horizontal-align' => 'vp-cover-horizontal-align-center',
		'vertical-align' => 'vp-vertical-align-middle',
		'arrow-indicator' => '0',
		'filter' => '0',
		'filter-data' => 'category',
		'filter-type' => 'vp-filter-default',
		'pagination' => '1',
		'pagination-type' => 'vp-pagination-numbers',
		'load-more-number' => '3',
		'load-more-count' => '1',
		'ajax' => '0',
		'ajax-type' => 'vp-ajax-modal',
		'ajax-width' => '1140',
		'ajax-offset' => '110',
		'multi-color' => '0',
		'overlay-color' => array(
			'background' => '#265e6e',
			'text' => '#fff'
		),
		'informations-color' => array(
			'background' => '#fff',
			'text' => '#555'
		),
		'spinner' => '1',
		'spinner-color' => array(
			'background' => '#265e6e',
			'text' => '#fff'
		),
		'filter-color' => array(
			'background' => '#265e6e',
			'text' => '#fff'
		),
		'pagination-color' => array(
			'background' => '#265e6e',
			'text' => '#fff'
		),
		'typography' => array(
			'title' => array(
				'family' => "'Montserrat'",
				'font-size' => '18px',
				'font-weight' => '700',
				'line-height' => '26px',
				'text-transform' => 'none',
				'default' => false,
				'italic' => false
			),
			'buttons' => array(
				'family' => "'Raleway'",
				'font-size' => '18px',
				'font-weight' => '400',
				'line-height' => '24px',
				'text-transform' => 'none',
				'default' => false,
				'italic' => false
			),
			'likes' => array(
				'family' => "'Raleway'",
				'font-size' => '14px',
				'font-weight' => '400',
				'line-height' => '24px',
				'text-transform' => 'none',
				'default' => false,
				'italic' => false
			),
			'categories' => array(
				'family' => "'Raleway'",
				'font-size' => '14px',
				'font-weight' => '400',
				'line-height' => '24px',
				'text-transform' => 'none',
				'default' => false,
				'italic' => false
			),
			'desc' => array(
				'family' => "'Raleway'",
				'font-size' => '16px',
				'font-weight' => '400',
				'line-height' => '30px',
				'text-transform' => 'none',
				'default' => false,
				'italic' => false
			),
			'filter' => array(
				'family' => "'Montserrat'",
				'font-size' => '12px',
				'font-weight' => '400',
				'line-height' => '24px',
				'text-transform' => 'uppercase',
				'default' => false,
				'italic' => false
			),
			'pagination' => array(
				'family' => "'Montserrat'",
				'font-size' => '12px',
				'font-weight' => '700',
				'line-height' => '24px',
				'text-transform' => 'uppercase',
				'default' => false,
				'italic' => false
			),
		),
		'custom-css' => '',
		'item-animation' => 'vp-items-scale',
		'ajax-modal-animation' => 'vp-modal-scale',
		'item-animation-duration' => '800',
		'query' => array(
			'order' => 'desc',
                'orderby' => 'date',
                'relation' => 'AND'
		),
		'skin' => array(
			'type' => 'vp-always-visible',
			'style' => 'vp-hydrogen'
		)
	);
}

function viba_portfolio_admin_generate_style_options( $title, $value = false  ) { 

	$slug = sanitize_title( $title );
	$plugin_dir_url = viba_portfolio()->plugin_dir_url;
	$template_styles = viba_portfolio_get_template_styles();

	if ( $value == false ) {
		$value = viba_portfolio_admin_default_style_options( $title );
	}
	
	$shortcode = '[viba_portfolio]';
	$delete = '';

	if ( $slug != 'default' ) {
		$shortcode = '[viba_portfolio slug="' .$slug .'"]';
		$delete = '<a href="#" class="button button-primary viba-portfolio-delete-style" title="' . __( 'Delete', 'viba-portfolio' ) . '">' . __( 'Delete', 'viba-portfolio' ) . '</a>';
	}

	$type_selected = $value['skin']['type'];
	$style_selected = $value['skin']['style'];


	?>
	
	<h3><?php echo $title; ?><?php echo $delete; ?></h3>
	<div class="viba-portfolio-accordion-content">
	<span class="viba-portfolio-shortcode"><?php echo $shortcode; ?></span>
	<input type="hidden" name="viba_portfolio_options[portfolio-style][selected-style]" value="default"/>
	<input type="hidden" name="viba_portfolio_options[portfolio-style][styles][<?php echo $slug; ?>][title]"id="portfolio-title"value="<?php echo $title; ?>"/>

		<div class="viba-portfolio-tabs viba-portfolio-option-tabs">
			<ul>
				<li><a href="#options-tabs-1"><?php _e( 'General', 'viba-portfolio' ); ?></a></li>
				<li><a href="#options-tabs-2"><?php _e( 'Informations', 'viba-portfolio' ); ?></a></li>
				<li><a href="#options-tabs-3"><?php _e( 'Additional', 'viba-portfolio' ); ?></a></li>
				<li><a href="#options-tabs-4"><?php _e( 'Ajax', 'viba-portfolio' ); ?></a></li>
				<li><a href="#options-tabs-5"><?php _e( 'Styling', 'viba-portfolio' ); ?></a></li>
				<li><a href="#options-tabs-6"><?php _e( 'Animations', 'viba-portfolio' ); ?></a></li>
				<li><a href="#options-tabs-7"><?php _e( 'Query', 'viba-portfolio' ); ?></a></li>
				<li><a href="#options-tabs-8"><?php _e( 'Skin', 'viba-portfolio' ); ?></a></li>
			</ul>

			<div class="viba-portfolio-tab" id="options-tabs-1">
				
				<?php 
					viba_portfolio_admin_option_radio(
						array(
							'id' => 'size',
							'title' => __( 'Portfolio Size', 'viba-portfolio' ),
							'desc' => __( 'Default uses the theme default containers. Fullwidth will expand to fill the width of the window.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['size'],
							'options' => array(
								'vp-size-default' => __( 'Default', 'viba-portfolio' ),
								'vp-size-fullwidth' => __( 'Fullwidth', 'viba-portfolio' )
							)
						)
					);
					viba_portfolio_admin_option_radio(
						array(
							'id' => 'layout',
							'title' => __( 'Portfolio Layout', 'viba-portfolio' ),
							'desc' => __( 'If you want to use Multi-Size Layout you must <code>first enable Multi-Size</code> Images in General Setting Tab.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['layout'],
							'options' => array(
								'vp-layout-grid' => __( 'Grid', 'viba-portfolio' ),
								'vp-layout-multi-size-grid' => __( 'Multi-Size Grid', 'viba-portfolio' ),
								'vp-layout-carousel' => __( 'Carousel', 'viba-portfolio' ),
							)
						)
					);
					viba_portfolio_admin_option_number_slider( 
						array( 
							'id' => 'number',
							'title' => __( 'Number of Portfolio Items', 'viba-portfolio' ),
							'desc' => __( 'Number of portfolio items on one page.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['number'],
                        	"min" => "1",
                        	"step" => "1",
                        	"max" => "84",
                        ) 
					);
					viba_portfolio_admin_option_padding( 
						array( 
							'id' => 'padding',
							'title' => __( 'Portfolio Wrapper Padding', 'viba-portfolio' ),
							'desc' => sprintf( __( 'Useful if you want to add spacing from other content. Add multiple padding options like this e.g. %s., 10px is top padding, 30px is right padding, 100px is bottom padding, 0 is left padding', 'viba-portfolio' ), '<code>10px 30px 100px 0</code>' ),
							'slug' => $slug,
							'default' => $value['padding'],
                        ) 
					);
					viba_portfolio_admin_option_number_slider( 
						array( 
							'id' => 'columns',
							'title' => __( 'Portfolio Columns', 'viba-portfolio' ),
							'desc' => __( 'Select Number of Columns for your portfolio.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['columns'],
                        	"min" => "1",
                        	"step" => "1",
                        	"max" => "6",
                        ) 
					);
					viba_portfolio_admin_option_number_slider(
						array(
							'id' => 'margins',
							'title' => __( 'Portfolio Margins', 'viba-portfolio' ),
							'desc' => __( 'Margins are used to add space between portfolio items.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['margins'],
							"min" => "0",
                        	"step" => "2",
                        	"max" => "40",
						)
					);
				?>		

			</div>

			<div class="viba-portfolio-tab" id="options-tabs-2">
				<?php 

					viba_portfolio_admin_option_checkboxes(
						array(
							'id' => 'informations',
							'title' => __( 'Portfolio Informations', 'viba-portfolio' ),
							'desc' => __( 'Check what data you want to show with portfolio items.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['informations'],
							'options' => array(
								'zoom-button' => __( 'Zoom Button' , 'viba-portfolio' ),
								'link-button' => __( 'Link Button' , 'viba-portfolio' ),
								'title' => __('Title', 'viba-portfolio'), 
								'categories' => __('Categories', 'viba-portfolio'), 
								'likes' => __('Likes', 'viba-portfolio'),
								'description' => __('Short Description', 'viba-portfolio'),
                        	)
						)
					);
					viba_portfolio_admin_option_radio(
						array(
							'id' => 'horizontal-align',
							'title' => __( 'Portfolio Informations Horizontal Align', 'viba-portfolio' ),
							'desc' => __( 'Aligns text for bottom informations.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['horizontal-align'],
							'options' => array(
								'vp-horizontal-align-left' => __( 'Left', 'viba-portfolio' ),
								'vp-horizontal-align-center' => __( 'Center', 'viba-portfolio' ),
								'vp-horizontal-align-right' => __( 'Right', 'viba-portfolio' )
							)
						)
					);
					viba_portfolio_admin_option_radio(
						array(
							'id' => 'cover-horizontal-align',
							'title' => __( 'Portfolio Cover Horizontal Align', 'viba-portfolio' ),
							'desc' => __( 'Align text for informations above image (absolute positioned).', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['cover-horizontal-align'],
							'options' => array(
								'vp-cover-horizontal-align-left' => __( 'Left', 'viba-portfolio' ),
								'vp-cover-horizontal-align-center' => __( 'Center', 'viba-portfolio' ),
								'vp-cover-horizontal-align-right' => __( 'Right', 'viba-portfolio' )
							)
						)
					);
					viba_portfolio_admin_option_radio(
						array(
							'id' => 'vertical-align',
							'title' => __( 'Portfolio Informations Vertical Align', 'viba-portfolio' ),
							'desc' => __( 'These settings take effect only for styles with informations above image (absolute positioned).', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['vertical-align'],
							'options' => array(
								'vp-vertical-align-top' => __( 'Top', 'viba-portfolio' ),
								'vp-vertical-align-middle' => __( 'Middle', 'viba-portfolio' ),
								'vp-vertical-align-bottom' => __( 'Bottom', 'viba-portfolio' )
							)
						)
					);
					
					viba_portfolio_admin_option_radio(
						array(
							'id' => 'arrow-indicator',
							'title' => __( 'Portfolio Arrow', 'viba-portfolio' ),
							'desc' => __( 'Add a little arrow to indicate what image belongs to portfolio informations. Arrow isn\'t available for all styles.' , 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['arrow-indicator'],
							'options' => array(
								'1' => __( 'Yes', 'viba-portfolio' ),
								'0' => __( 'No', 'viba-portfolio' )
							)
						)
					);
					

					?>

			</div>

			<div class="viba-portfolio-tab" id="options-tabs-3">
				<?php
					viba_portfolio_admin_option_radio(
						array(
							'id' => 'filter',
							'title' => __( 'Portfolio Filter', 'viba-portfolio' ),
							'desc' => __( 'Filter option is available only for grid layouts.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['filter'],
							'options' => array(
								'1' => __( 'Yes', 'viba-portfolio' ),
								'0' => __( 'No', 'viba-portfolio' )
							)
						)
					);
					viba_portfolio_admin_option_radio(
						array(
							'id' => 'filter-data',
							'title' => __( 'Portfolio Filter Data', 'viba-portfolio' ),
							'desc' => __( 'Filter your items by categories or tags.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['filter-data'],
							'options' => array(
								'category' => __( 'Categories', 'viba-portfolio' ),
                            	'tag' => __( 'Tags', 'viba-portfolio' )
							)
						)
					);
					viba_portfolio_admin_option_radio(
						array(
							'id' => 'filter-type',
							'title' => __( 'Portfolio Filter Type', 'viba-portfolio' ),
							'desc' => __( 'Select your filter type.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['filter-type'],
							'options' => array(
								'vp-filter-default' => __( 'Default', 'viba-portfolio' ),
								'vp-filter-slide-in' => __( 'Slide In', 'viba-portfolio' ),
								'vp-filter-dropdown' => __( 'Dropdown', 'viba-portfolio' )
							)
						)
					);
					viba_portfolio_admin_option_radio(
						array(
							'id' => 'pagination',
							'title' => __( 'Portfolio Pagination', 'viba-portfolio' ),
							'desc' => __( 'Enable pagination option.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['pagination'],
							'options' => array(
								'1' => __( 'Yes', 'viba-portfolio' ),
								'0' => __( 'No', 'viba-portfolio' )
							)
						)
					);
					viba_portfolio_admin_option_radio(
						array(
							'id' => 'pagination-type',
							'title' => __( 'Portfolio Pagination Type', 'viba-portfolio' ),
							'desc' => __( 'Select your pagination type.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['pagination-type'],
							'options' => array(
								'vp-pagination-numbers' => __( 'Numbers', 'viba-portfolio' ),
								'vp-pagination-arrows' => __( 'Arrows', 'viba-portfolio' ),
								'vp-pagination-load-more' => __( 'Load More', 'viba-portfolio' )
							)
						)
					);
					viba_portfolio_admin_option_number_slider( 
						array( 
							'id' => 'load-more-number',
							'title' => __( 'Load More Number of Portfolio Items', 'viba-portfolio' ),
							'desc' => __( 'Number of portfolio items that will be loaded.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['load-more-number'],
                        	"min" => "1",
                        	"step" => "1",
                        	"max" => "84",
                        ) 
					);
					viba_portfolio_admin_option_radio(
						array(
							'id' => 'load-more-count',
							'title' => __( 'Portfolio Load More Count', 'viba-portfolio' ),
							'desc' => __( 'Add a number of available items that could be loaded.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['load-more-count'],
							'options' => array(
								'1' => __( 'Yes', 'viba-portfolio' ),
								'0' => __( 'No', 'viba-portfolio' )
							)
						)
					);

				?>
			</div>

			<div class="viba-portfolio-tab" id="options-tabs-4">
				<?php
					viba_portfolio_admin_option_radio(
						array(
							'id' => 'ajax',
							'title' => __( 'Portfolio Ajax', 'viba-portfolio' ),
							'desc' => __( 'Use ajax to open items.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['ajax'],
							'options' => array(
								'1' => __( 'Yes', 'viba-portfolio' ),
								'0' => __( 'No', 'viba-portfolio' )
							)
						)
					);
					viba_portfolio_admin_option_radio(
						array(
							'id' => 'ajax-type',
							'title' => __( 'Portfolio Ajax Type', 'viba-portfolio' ),
							'desc' => __( 'Select how do you want to open items with ajax.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['ajax-type'],
							'options' => array(
								'vp-ajax-modal' => __( 'Modal', 'viba-portfolio' ),
								'vp-ajax-above' => __( 'Above', 'viba-portfolio' ),
								'vp-ajax-below' => __( 'Below', 'viba-portfolio' ),
							)
						)
					);
					viba_portfolio_admin_option_text(
						array(
							'id' => 'ajax-width',
							'title' => __( 'Portfolio Ajax Width', 'viba-portfolio' ),
							'desc' => __( 'Set the max width for ajax content. If you want the ajax content to be full width just enter 0.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['ajax-width']
						)
					);
					viba_portfolio_admin_option_text(
						array(
							'id' => 'ajax-offset',
							'title' => __( 'Portfolio Ajax Offset', 'viba-portfolio' ),
							'desc' => __( 'Set the offset from top of the window for above and below ajax types. If you don\'t want to animate to top of the ajax content just enter 0.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['ajax-offset']
						)
					);
				?>
			</div>

			<div class="viba-portfolio-tab" id="options-tabs-5">
				<?php
					viba_portfolio_admin_option_radio(
						array(
							'id' => 'multi-color',
							'title' => __( 'Portfolio Multi-Color', 'viba-portfolio' ),
							'desc' => __( 'Enable different color for each item. These colors are set in single item pages.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['multi-color'],
							'options' => array(
								'1' => __( 'Yes', 'viba-portfolio' ),
								'0' => __( 'No', 'viba-portfolio' )
							)
						)
					);
					viba_portfolio_admin_option_color(
						array(
							'id' => 'overlay-color',
							'title' => __( 'Portfolio Overlay Color', 'viba-portfolio' ),
							'desc' => __( 'Set your color for overlay background and text.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['overlay-color']
						)
					);
					viba_portfolio_admin_option_color(
						array(
							'id' => 'informations-color',
							'title' => __( 'Portfolio Informations Color', 'viba-portfolio' ),
							'desc' => __( 'Set your color for informations background and text.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['informations-color']
						)
					);
					viba_portfolio_admin_option_color(
						array(
							'id' => 'filter-color',
							'title' => __( 'Portfolio Filter Color', 'viba-portfolio' ),
							'desc' => __( 'Set your color for filter background and text.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['filter-color']
						)
					);
					viba_portfolio_admin_option_color(
						array(
							'id' => 'pagination-color',
							'title' => __( 'Portfolio Pagination Color', 'viba-portfolio' ),
							'desc' => __( 'Set your color for pagination background and text.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['pagination-color']
						)
					);
					viba_portfolio_admin_option_color(
						array(
							'id' => 'spinner-color',
							'title' => __( 'Portfolio Spinner Color', 'viba-portfolio' ),
							'desc' => __( 'Set your color for spinner background and text. Some spinners use the background color, some use the text, some use both.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['spinner-color']
						)
					);
					viba_portfolio_admin_option_number_slider( 
						array( 
							'id' => 'overlay-opacity',
							'title' => __( 'Portfolio Color Overlay Opacity', 'viba-portfolio' ),
							'desc' => __( 'Set your image overlay opacity.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['overlay-opacity'],
                        	"min" => "0",
                        	"step" => "1",
                        	"max" => "100",
                        ) 
					);
					viba_portfolio_admin_option_radio(
						array(
							'id' => 'overlay-visibility',
							'title' => __( 'Portfolio Overlay Visibility', 'viba-portfolio' ),
							'desc' => __( 'Select how do you want your overlay visibility.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['overlay-visibility'],
							'options' => array(
								'vp-overlay-on-hover' => __( 'Show on Hover', 'viba-portfolio' ),
								'vp-overlay-off-hover' => __( 'Hide on Hover', 'viba-portfolio' ),
								'vp-overlay-visible' => __( 'Always Visible', 'viba-portfolio' ),
							)
						)
					);
					viba_portfolio_admin_option_typography(
						array(
							'id' => 'typography',
							'title' => __( 'Portfolio Typography', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['typography']
						)
					);
					viba_portfolio_admin_option_ace_editor(
						array(
							'id' => 'custom-css',
							'title' => __( 'Portfolio Custom CSS', 'viba-portfolio' ),
							'desc' => __( 'Input your custom CSS', 'viba-portfolio' ),
							'slug' => $slug,
							'mode' => 'css',
							'theme' => 'chrome',
							'default' => $value['custom-css']
						)
					);
				?>
			</div>

			<div class="viba-portfolio-tab" id="options-tabs-6">
				<?php
					viba_portfolio_admin_option_hover_effects(
						array(
							'id' => 'hover-effect',
							'title' => __( 'Portfolio Hover Effect', 'viba-portfolio' ),
							'desc' => __( 'Set your hover overlay effect.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => isset( $value['hover-effect'] ) ? $value['hover-effect'] : false,
							'options' => array(
								'overlay' => array(
									'vp-overlay' => __( 'Color Overlay' , 'viba-portfolio' ),
									'vp-slide-overlay' => __( 'Slide Overlay', 'viba-portfolio' ),
								),
								'image' => array(
									'none' => __( 'None' , 'viba-portfolio' ),
									'vp-zoom-in-image' => __( 'Zoom In' , 'viba-portfolio' ),
									'vp-zoom-out-image' => __( 'Zoom Out' , 'viba-portfolio' ),
									'vp-slide-image' => __( 'Slide', 'viba-portfolio' )
								)
                        	)
						)
					);
					viba_portfolio_admin_option_radio(
						array(
							'id' => 'animation',
							'title' => __( 'Portfolio Hover Animations', 'viba-portfolio' ),
							'desc' => __( 'Set portfolio animations. For Overlay Animations you must enable "Slide Overlay".', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['animation'],
							'options' => array(
								'none' => __( 'None' , 'viba-portfolio' ),
								'vp-direction-aware' => __( 'Direction Aware', 'viba-portfolio' ),
								'vp-zoom-in' => __( 'Zoom In', 'viba-portfolio' ),
								'vp-zoom-out' => __( 'Zoom Out', 'viba-portfolio' ),
								'vp-animate-from-top' => __( 'From Top', 'viba-portfolio' ),
								'vp-animate-from-right' => __( 'From Right', 'viba-portfolio' ),
								'vp-animate-from-left' => __( 'From Left', 'viba-portfolio' ),
								'vp-animate-from-bottom' => __( 'From Bottom', 'viba-portfolio' ),
								'vp-animate-from-center-horizontal' => __( 'From Center Horizontal', 'viba-portfolio' ),
								'vp-animate-from-center-vertical' => __( 'From Center Vertical', 'viba-portfolio' )
							)
						)
					);
					viba_portfolio_admin_option_radio(
						array(
							'id' => 'ajax-modal-animation',
							'title' => __( 'Ajax Modal Animation', 'viba-portfolio' ),
							'desc' => __( 'Set your ajax modal animations.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['ajax-modal-animation'],
							'options' => array(
								'vp-modal-fade' => __( 'Fade', 'viba-portfolio' ),
								'vp-modal-scale' => __( 'Scale', 'viba-portfolio' ),
								'vp-modal-slide-in-top' => __( 'Slide In Top', 'viba-portfolio' ),
								'vp-modal-slide-in-right' => __( 'Slide In Right', 'viba-portfolio' ),
								'vp-modal-slide-in-bottom' => __( 'Slide In Bottom', 'viba-portfolio' ),
								'vp-modal-slide-in-left' => __( 'Slide In Left', 'viba-portfolio' ),
								'vp-modal-newspaper' => __( 'Newspaper', 'viba-portfolio' ),
								'vp-modal-horizontal-flip' => __( 'Horizontal Flip', 'viba-portfolio' ),
								'vp-modal-vertical-flip' => __( 'Vertical Flip', 'viba-portfolio' )
							)
						)
					);
					viba_portfolio_admin_option_radio(
						array(
							'id' => 'item-animation',
							'title' => __( 'Loading, Filtering and Carousel Animations', 'viba-portfolio' ),
							'desc' => __( 'Set your loading, filtering and carousel animations.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['item-animation'],
							'options' => array(
								'vp-items-fade' => __( 'Fade', 'viba-portfolio' ),
								'vp-items-scale' => __( 'Scale', 'viba-portfolio' ),
								'vp-items-rotate' => __( 'Rotate', 'viba-portfolio' ),
								'vp-items-rotate-down-left' => __( 'Rotate Down Left', 'viba-portfolio' ),
								'vp-items-rotate-down-right' => __( 'Rotate Down Right', 'viba-portfolio' ),
								'vp-items-rotate-up-left' => __( 'Rotate Up Left', 'viba-portfolio' ),
								'vp-items-rotate-up-right' => __( 'Rotate Up Right', 'viba-portfolio' ),
								'vp-items-slide-top' => __( 'Slide Top', 'viba-portfolio' ),
								'vp-items-slide-right' => __( 'Slide Right', 'viba-portfolio' ),
								'vp-items-slide-bottom' => __( 'Slide Bottom', 'viba-portfolio' ),
								'vp-items-slide-left' => __( 'Slide Left', 'viba-portfolio' ),
								'vp-items-horizontal-flip' => __( 'Horizontal Flip', 'viba-portfolio' ),
								'vp-items-vertical-flip' => __( 'Vertical Flip', 'viba-portfolio' ),
								'vp-items-horizontal-flipbook' => __( 'Horizontal Flipbook', 'viba-portfolio' ),
								'vp-items-vertical-flipbook' => __( 'Vertical Flipbook', 'viba-portfolio' ),
							)
						)
					);
					viba_portfolio_admin_option_number_slider( 
						array( 
							'id' => 'item-animation-duration',
							'title' => __( 'Animation Duration', 'viba-portfolio' ),
							'desc' => __( 'How long does it take to animate loading, filtering and carousel animations. The value is in <code>ms(milliseconds)</code>. 1000ms is 1 second.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['item-animation-duration'],
                        	"min" => "0",
                        	"step" => "100",
                        	"max" => "6000",
                        ) 
					);
					viba_portfolio_admin_option_radio(
						array(
							'id' => 'spinner',
							'title' => __( 'Portfolio Spinner', 'viba-portfolio' ),
							'desc' => __( 'Select portfolio spinner.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['spinner'],
							'options' => array(
								'1' => '1',
								'2' => '2',
								'3' => '3',
								'4' => '4',
								'5' => '5',
								'6' => '6',
								'7' => '7',
								'8' => '8',
								'9' => '9',
								'10' => '10',
								'11' => '11',
								'12' => '12',
							)
						)
					);
				?>
			</div>

			<div class="viba-portfolio-tab" id="options-tabs-7">
				<?php
					viba_portfolio_admin_option_query(
						array(
							'id' => 'query',
							'title' => __( 'Portfolio Query', 'viba-portfolio' ),
							'desc' => __( 'Query your portfolio items.', 'viba-portfolio' ),
							'slug' => $slug,
							'default' => $value['query']
						)
					);
				?>

			</div>

			<div class="viba-portfolio-tab viba-portfolio-skin-tabs" id="options-tabs-8">
				<div class="viba-portfolio-type-tabs" data-active="<?php echo $type_selected; ?>">
					<input type="hidden" class="portfolio-type" name="viba_portfolio_options[portfolio-style][styles][<?php echo $slug; ?>][skin][type]" value="<?php echo $value['skin']['type']; ?>"/>
					<input type="hidden" class="portfolio-style" name="viba_portfolio_options[portfolio-style][styles][<?php echo $slug; ?>][skin][style]" value="<?php echo $value['skin']['style']; ?>"/>
					
					<ul>
					<?php 
						foreach ( $template_styles as $key => $style ) {
							echo '<li><a class="viba-portfolio-type-link" href="#'.$slug.'-styles-tab-'. $key .'" data-key="'. $key .'">' . $style['title'] . '</a></li>';
						}
					?>
					</ul>
					
					<?php
						foreach ( $template_styles as $key => $style ) {

							echo '<div class="viba-portfolio-tab viba-portfolio-tabs viba-portfolio-style-tabs" id="'. $slug .'-styles-tab-'. $key .'" data-active="'.$style_selected.'">';
								
								echo '<ul>';
								foreach ( $style['styles'] as $sub_key => $value ) {
									echo '<li><a class="viba-portfolio-style-link" href="#'.$slug.'-styles-tab-'.$key. '-'. $value['id'] .'" data-key="'. $value['id'] .'">' . $value['title'] . '</a></li>';
								}
								echo '</ul>';

								foreach ( $style['styles'] as $sub_key => $value ) {
									echo '<div class="viba-portfolio-tab viba-portfolio-style-tab" id="'. $slug .'-styles-tab-'. $key .'-'. $value['id'] .'">';
									echo '<img src="'.$value['img'].'" />';
									echo '</div>';
								}
							echo '</div>';
						}
						echo '<div class="vp-skin-desc">'.__( 'This is only the default preview. The final outcome can be a lot different when you tweak the options.', 'viba-portfolio' ) .'</div>';
					?>
		
				</div>
			</div>

		</div>

	</div><!-- accordian closing content div -->
<?php 

}

function viba_portfolio_admin_get_fonts( $fonts ) {

	$std_fonts = array(
		"Arial, Helvetica, sans-serif"                         => "Arial, Helvetica, sans-serif",
		"'Arial Black', Gadget, sans-serif"                    => "'Arial Black', Gadget, sans-serif",
		"'Bookman Old Style', serif"                           => "'Bookman Old Style', serif",
		"'Comic Sans MS', cursive"                             => "'Comic Sans MS', cursive",
		"Courier, monospace"                                   => "Courier, monospace",
		"Garamond, serif"                                      => "Garamond, serif",
		"Georgia, serif"                                       => "Georgia, serif",
		"Impact, Charcoal, sans-serif"                         => "Impact, Charcoal, sans-serif",
		"'Lucida Console', Monaco, monospace"                  => "'Lucida Console', Monaco, monospace",
		"'Lucida Sans Unicode', 'Lucida Grande', sans-serif"   => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
		"'MS Sans Serif', Geneva, sans-serif"                  => "'MS Sans Serif', Geneva, sans-serif",
		"'MS Serif', 'New York', sans-serif"                   => "'MS Serif', 'New York', sans-serif",
		"'Palatino Linotype', 'Book Antiqua', Palatino, serif" => "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
		"Tahoma,Geneva, sans-serif"                            => "Tahoma, Geneva, sans-serif",
		"'Times New Roman', Times,serif"                       => "'Times New Roman', Times, serif",
		"'Trebuchet MS', Helvetica, sans-serif"                => "'Trebuchet MS', Helvetica, sans-serif",
		"Verdana, Geneva, sans-serif"                          => "Verdana, Geneva, sans-serif",
	);

	$new_fonts = explode( '|', $fonts );
	$gfont = array();
	foreach ( $new_fonts as $key => $font ) {
		$font = preg_replace( array( '!([^&:]+).*$!','!\+!' ), array( '$1', ' ' ), $font );
		$gfont[ "'". $font ."'" ] = $font;
	}

	$fonts = wp_parse_args( $std_fonts, $gfont );

	return $fonts;
}

function viba_portfolio_admin_option_typography( $data ) { 
	global $viba_portfolio_options; 

	$fonts = viba_portfolio_admin_get_fonts( $viba_portfolio_options['gfonts'] );

	$options = array(
		'title' => array(
			'name' => 'Title',
			'desc' => __( 'If checked use the default theme font for H3.', 'viba-portfolio' ),
		),
		'buttons' => array(
			'name' => 'Buttons',
			'desc' => __( 'If checked use the default theme font for body.', 'viba-portfolio' ),
		),
		'likes' => array(
			'name' => 'Likes',
			'desc' => __( 'If checked use the default theme font for body.', 'viba-portfolio' ),
		),
		'categories' => array(
			'name' => 'Categories',
			'desc' => __( 'If checked use the default theme font for body.', 'viba-portfolio' ),
		),
		'desc' => array(
			'name' => 'Description',
			'desc' => __( 'If checked use the default theme font for paragraph.', 'viba-portfolio' ),
		),
		'filter' => array(
			'name' => 'Filter',
			'desc' => __( 'If checked use the default theme font for body.', 'viba-portfolio' ),
		),
		'pagination' => array(
			'name' => 'Pagination',
			'desc' => __( 'If checked use the default theme font for body.', 'viba-portfolio' ),
		),
	);

	$weight = array(
		'100' => '100',
		'200' => '200',
		'300' => '300',
		'400' => '400',
		'500' => '500',
		'600' => '600',
		'700' => '700',
		'800' => '800',
		'900' => '900',
	);

	$transform = array(
		'none' => __( 'None', 'viba-portfolio' ),
		'capitalize' => __( 'Capitalize', 'viba-portfolio' ),
		'uppercase' => __( 'Uppercase', 'viba-portfolio' ),
		'lowercase' => __( 'Lowercase', 'viba-portfolio' ),
	);

	?>

	<div class="viba-portfolio-option vp-typography-value">
		<div class="viba-portfolio-option-info">
			<?php echo $data['title']; ?>
		</div>
		<div class="viba-portfolio-option-value">
			
			<?php 
			foreach ( $options as $option => $value ) { ?>
				
				<div class="vp-typography-field">
					<h3 class="vp-typography-name"><?php echo $value['name']; ?></h3>
					<?php $checked = isset( $data['default'][$option]['default'] ) ? checked( $data['default'][$option]['default'], '1', false) : ''; ?>
					<label><input type="checkbox" class="checkbox" name="viba_portfolio_options[portfolio-style][styles][<?php echo $data['slug'] ?>][typography][<?php echo $option; ?>][default]"  value="1" <?php echo $checked ?>/> <?php echo $value['desc'] ?></label>
					<br>
					<div class="vp-typo-field vp-typo-font-family">
						<select id="vp_typo_<?php echo $data['slug'] . '_' . $option; ?>" name="viba_portfolio_options[portfolio-style][styles][<?php echo $data['slug'] ?>][typography][<?php echo $option; ?>][family]" class="redux-select-item" style="width:100%" rows="6">
							<?php foreach ( $fonts as $key => $font ) {
								echo $data['default'][$option]['family'];
								$selected = ( $key == $data['default'][$option]['family'] ) ? 'selected="selected"' : '';
								echo '<option value="' . $key . '" '.$selected.'>' . $font . '</option>';
							}?>
						</select>
					</div>

					<div class="vp-typo-field vp-typo-font-weight">
						<select id="vp_typo_<?php echo $data['slug'] . '_' . $option; ?>" name="viba_portfolio_options[portfolio-style][styles][<?php echo $data['slug'] ?>][typography][<?php echo $option; ?>][font-weight]" class="redux-select-item" style="width:100%" rows="6">
							<?php foreach ( $weight as $key => $value ) {
								$selected = ( $key == $data['default'][$option]['font-weight'] ) ? 'selected="selected"' : '';
								echo '<option value="' . $key . '" '.$selected.'>' . $value . '</option>';
							}?>
						</select>
					</div>

					<div class="vp-typo-field vp-typo-italic">
						<?php $checked = isset( $data['default'][$option]['italic'] ) ? checked( $data['default'][$option]['italic'], '1', false) : ''; ?>
						<label><input type="checkbox" class="checkbox" name="viba_portfolio_options[portfolio-style][styles][<?php echo $data['slug'] ?>][typography][<?php echo $option; ?>][italic]"  value="1" <?php echo $checked ?>/> <?php _e( 'Italic', 'viba-portfolio' ); ?></label>
					</div>
					
					<div class="vp-typo-field vp-typo-font-size">
						<?php _e( 'Font Size:', 'viba-portfolio' ); ?>
						<input type="text" id="vp_typo_<?php echo $data['slug'] . '_' . $option; ?>" name="viba_portfolio_options[portfolio-style][styles][<?php echo $data['slug'] ?>][typography][<?php echo $option; ?>][font-size]" value="<?php echo $data['default'][$option]['font-size'] ?>">
					</div>

					<div class="vp-typo-field vp-typo-line-height">
						<?php _e( 'Line Height:', 'viba-portfolio' ); ?>
						<input type="text" id="vp_typo_<?php echo $data['slug'] . '_' . $option; ?>" name="viba_portfolio_options[portfolio-style][styles][<?php echo $data['slug'] ?>][typography][<?php echo $option; ?>][line-height]" value="<?php echo $data['default'][$option]['line-height'] ?>">
					</div>

					<div class="vp-typo-field vp-typo-text-transform">
						<select id="vp_typo_<?php echo $data['slug'] . '_' . $option; ?>" name="viba_portfolio_options[portfolio-style][styles][<?php echo $data['slug'] ?>][typography][<?php echo $option; ?>][text-transform]" class="redux-select-item" style="width:100%" rows="6">
							<?php foreach ( $transform as $key => $value ) {
								$selected = ( $key == $data['default'][$option]['text-transform'] ) ? 'selected="selected"' : '';
								echo '<option value="' . $key . '" '.$selected.'>' . $value . '</option>';
							}?>
						</select>
					</div>

					

				</div>	
			<?php } ?>
		</div>
	</div>
<?php }

function viba_portfolio_admin_option_query( $data ) { ?>
	<div class="viba-portfolio-option vp-query-value">
		<span class="vp-query-desc"><?php _e( 'On archive pages you can use only the Order query. If you are using the Default style as a shortcode then you can use all the query options.', 'viba-portfolio' );?></span>
		<div class="viba-portfolio-option-value">
		<?php 
			$categories = viba_portfolio_get_terms( viba_portfolio()->category_taxonomy, array(), 'term_id', 'name' ); 
			$tags = viba_portfolio_get_terms( viba_portfolio()->tag_taxonomy, array(), 'term_id', 'name' ); 
			$order = array(
				'asc' => __( 'ASC', 'viba-portfolio' ),
				'desc' => __( 'DESC', 'viba-portfolio' )
			);
			$orderby = array(
				'date' => __( 'Order by date', 'viba-portfolio' ),
				'title' => __( 'Order by title', 'viba-portfolio' ),
				'modified' => __( 'Order by last modified date', 'viba-portfolio' ),
				'rand' => __( 'Random order', 'viba-portfolio' ),
				'menu_order' => __( 'Order by Page Order', 'viba-portfolio' ),
				'meta_value_num' => __( 'Order by likes', 'viba-portfolio' )
			);
			$authors = get_users( array( 'who' => 'authors' ) );
			$post_formats = array( 
				'post-format-standard' => __( 'Standard', 'viba-portfolio'), 
				'post-format-gallery' => __( 'Gallery', 'viba-portfolio'), 
				'post-format-video' => __( 'Video', 'viba-portfolio'), 
				'post-format-audio' => __( 'Audio', 'viba-portfolio'), 
				'post-format-link' => __( 'Link', 'viba-portfolio') 
			);
			$years = viba_portfolio_get_all_years();
			$months = array(
				'1' => __( 'January', 'viba-portfolio' ),
				'2' => __( 'February', 'viba-portfolio' ),
				'3' => __( 'March', 'viba-portfolio' ),
				'4' => __( 'April', 'viba-portfolio' ),
				'5' => __( 'May', 'viba-portfolio' ),
				'6' => __( 'June', 'viba-portfolio' ),
				'7' => __( 'July', 'viba-portfolio' ),
				'8' => __( 'August', 'viba-portfolio' ),
				'9' => __( 'September', 'viba-portfolio' ),
				'10' => __( 'October', 'viba-portfolio' ),
				'11' => __( 'November', 'viba-portfolio' ),
				'12' => __( 'December', 'viba-portfolio' )
			);
			$relations = array(
				'AND' => __( 'AND', 'viba-portfolio' ),
				'OR' => __( 'OR', 'viba-portfolio' )
			);
		?>

		<div class="viba-portfolio-query-field">
			<div class="viba-portfolio-option-info">
				<?php _e( 'Categories', 'viba-portfolio' ); ?>
				<span class="description"><?php _e( 'If empty, all categories will be used.', 'viba-portfolio' );?></span>
			</div>
			<select id="vp_query_<?php echo $data['slug']; ?>_cat" multiple="multiple" data-placeholder="<?php echo __( 'Select categories', 'viba-portfolio' ); ?>" name="viba_portfolio_options[portfolio-style][styles][<?php echo $data['slug'] ?>][query][category][]" class="redux-select-item" style="width:100%" rows="6">
				<?php foreach ( $categories as $id => $cat ) {
					$selected = isset( $data['default']['category'] ) ? in_array( $id, $data['default']['category'] ) ? 'selected="selected"' : '' : '';
					echo '<option value="' . $id . '" '.$selected.'>' . $cat . '</option>';
				}?>
			</select>
			
			<?php $checked = isset( $data['default']['exclude-sub-category'] ) ? checked( $data['default']['exclude-sub-category'], '1', false) : ''; ?>
			<label><input type="checkbox" class="checkbox" name="viba_portfolio_options[portfolio-style][styles][<?php echo $data['slug'] ?>][query][exclude-sub-category]"  value="1" <?php echo $checked ?>/> <?php _e( 'Exclude sub-categories', 'viba-portfolio' ); ?></label>

		</div>

		<div class="viba-portfolio-query-field">
			<div class="viba-portfolio-option-info">
				<?php _e( 'Tags', 'viba-portfolio' ); ?>
				<span class="description"><?php _e( 'If empty, all tags will be used', 'viba-portfolio' );?></span>
			</div>
			<select id="vp_query_<?php echo $data['slug']; ?>_tag" multiple="multiple" data-placeholder="<?php echo __( 'Select tags', 'viba-portfolio' ); ?>" name="viba_portfolio_options[portfolio-style][styles][<?php echo $data['slug'] ?>][query][tag][]" class="redux-select-item" style="width:100%" rows="6">
				<?php foreach ( $tags as $id => $cat ) {
					$selected = isset( $data['default']['tag'] ) ? in_array( $id, $data['default']['tag'] ) ? 'selected="selected"' : '' : '';
					echo '<option value="' . $id . '" '.$selected.'>' . $cat . '</option>';
				}?>
			</select>

		</div>

		<div class="viba-portfolio-query-field">
			<div class="viba-portfolio-option-info">
				<?php _e( 'Order', 'viba-portfolio' ); ?>
			</div>
			<?php foreach ( $order as $key => $value ) {
				$selected = checked( $data['default']['order'], $key, false );
				echo '<label><input type="radio" name="viba_portfolio_options[portfolio-style][styles]['.$data['slug'] .'][query][order]" '.$selected.' value="'.$key.'">'.$value.'</label>';
			} ?>
			<select id="vp_query_<?php echo $data['slug']; ?>_order" name="viba_portfolio_options[portfolio-style][styles][<?php echo $data['slug'] ?>][query][orderby]" class="redux-select-item" style="width:100%" rows="6">
				<?php foreach ( $orderby as $key => $order ) {
					$selected = ( $key == $data['default']['orderby'] ) ? 'selected="selected"' : '';
					echo '<option value="' . $key . '" '.$selected.'>' . $order . '</option>';
				}?>
			</select>

		</div>

		<div class="viba-portfolio-query-field">
			<div class="viba-portfolio-option-info">
				<?php _e( 'Author', 'viba-portfolio' ); ?>
				<span class="description"><?php _e( 'If empty, portfolios created by all authors will be used.', 'viba-portfolio' );?></span>
			</div>
			<select id="vp_query_<?php echo $data['slug']; ?>_author" multiple="multiple" data-placeholder="<?php echo __( 'Select authors', 'viba-portfolio' ); ?>" name="viba_portfolio_options[portfolio-style][styles][<?php echo $data['slug'] ?>][query][author][]" class="redux-select-item" style="width:100%" rows="6">
				<?php foreach ( $authors as $author ) {
					$selected = isset( $data['default']['author'] ) ? in_array( $author->ID, $data['default']['author'] ) ? 'selected="selected"' : '' : '';
					echo '<option value="' . $author->ID . '" '.$selected.'>' . $author->data->display_name . '</option>';
				}?>
			</select>

		</div>

		<div class="viba-portfolio-query-field">
			<div class="viba-portfolio-option-info">
				<?php _e( 'Post Format', 'viba-portfolio' ); ?>
				<span class="description"><?php _e( 'If empty, all formats will be used.', 'viba-portfolio' );?></span>
			</div>
			<select id="vp_query_<?php echo $data['slug']; ?>_format" multiple="multiple" data-placeholder="<?php echo __( 'Select post formats', 'viba-portfolio' ); ?>" name="viba_portfolio_options[portfolio-style][styles][<?php echo $data['slug'] ?>][query][format][]" class="redux-select-item" style="width:100%" rows="6">
				<?php foreach ( $post_formats as $key => $format ) {
					$selected = isset( $data['default']['format'] ) ? in_array( $key, $data['default']['format'] ) ? 'selected="selected"' : '' : '';
					echo '<option value="' . $key . '" '.$selected.'>' . $format . '</option>';
				}?>
			</select>

		</div>

		<div class="viba-portfolio-query-field">
			<div class="viba-portfolio-option-info">
				<?php _e( 'Year and month', 'viba-portfolio' ); ?>
			</div>
			<select id="vp_query_<?php echo $data['slug']; ?>_year" data-placeholder="<?php echo __( 'Select a year', 'viba-portfolio' ); ?>" name="viba_portfolio_options[portfolio-style][styles][<?php echo $data['slug'] ?>][query][year]" class="redux-select-item" style="width:100%" rows="6">
				<option></option>
				<?php foreach ( $years as $year ) {
					$selected = isset( $data['default']['year'] ) ? ( $year == $data['default']['year'] ) ? 'selected="selected"' : '' : '';
					echo '<option value="' . $year . '" '.$selected.'>' . $year . '</option>';
				}?>
			</select>
			<br><br>
			<select id="vp_query_<?php echo $data['slug']; ?>_month" multiple="multiple" data-placeholder="<?php echo __( 'Select months', 'viba-portfolio' ); ?>" name="viba_portfolio_options[portfolio-style][styles][<?php echo $data['slug'] ?>][query][monthnum][]" class="redux-select-item" style="width:100%" rows="6">
				<?php foreach ( $months as $key => $month ) {
					$selected = isset( $data['default']['monthnum'] ) ? in_array( $key, $data['default']['monthnum'] ) ? 'selected="selected"' : '' : '';
					echo '<option value="' . $key . '" '.$selected.'>' . $month . '</option>';
				}?>
			</select>

		</div>

		<div class="viba-portfolio-query-field">
			<div class="viba-portfolio-option-info">
				<?php _e( 'Relation', 'viba-portfolio' ); ?>
				<span class="description"><?php _e( 'AND: values from category, tag and format must all be satisfied. OR: values from category, tag or format must be satisfied.', 'viba-portfolio' );?></span>
			</div>
			<?php foreach ( $relations as $key => $relation ) {
				$selected = checked( $data['default']['relation'], $key, false );
				echo '<label><input type="radio" name="viba_portfolio_options[portfolio-style][styles]['.$data['slug'] .'][query][relation]" '.$selected.' value="'.$key.'">'.$relation.'</label>';
			} ?>
		</div>

		</div>
	</div>
<?php }

function viba_portfolio_admin_option_number_slider( $data ) { ?>
	<div class="viba-portfolio-option">
		<div class="viba-portfolio-option-info">
			<?php echo $data['title']; ?>
			<span class="description"><?php echo $data['desc']; ?></span>
		</div>
		<div class="viba-portfolio-option-value vp-multiple-sliders <?php echo $data['id']; ?>">
		<?php if ( is_array( $data['default'] ) ) {
			foreach ($data['default'] as $key => $value) { ?>
				<fieldset id="viba_portfolio_options-<?php echo $data['id'].'-'.$key; ?>" class="redux-field-container redux-field redux-field-init redux-container-slider " data-id="<?php echo $data['id'].'-'.$key; ?>"  data-type="slider">
				<div class="viba-portfolio-multiple-sliders-name"><?php echo $key; ?></div>
				<input type="text" name="viba_portfolio_options[portfolio-style][styles][<?php echo $data['slug']; ?>][<?php echo $data['id']; ?>][<?php echo $key; ?>]"id="<?php echo $data['id'].'-'.$key; ?>" class="redux-slider-input redux-slider-input-one-<?php echo $data['id'].'-'.$key; ?>" value="<?php echo $data['default'][$key]; ?>"/>
					<div class="redux-slider-container"  id="<?php echo $data['id'].'-'.$key; ?>"  data-id="<?php echo $data['id'].'-'.$key; ?>" data-min="<?php echo $data['min']; ?>" data-max="<?php echo $data['max']; ?>" data-step="<?php echo $data['step']; ?>" data-handles="1" data-display="2" data-rtl="" data-float-mark="." data-resolution="1" data-default-one="<?php echo $data['default'][$key]; ?>"></div>
			</fieldset>
			<?php }

		} else { ?>
			<fieldset id="viba_portfolio_options-<?php echo $data['id']; ?>" class="redux-field-container redux-field redux-field-init redux-container-slider " data-id="<?php echo $data['id']; ?>"  data-type="slider">
				<input type="text" name="viba_portfolio_options[portfolio-style][styles][<?php echo $data['slug']; ?>][<?php echo $data['id']; ?>]"id="<?php echo $data['id']; ?>" class="redux-slider-input redux-slider-input-one-<?php echo $data['id']; ?>" value="<?php echo $data['default']; ?>"/>
					<div class="redux-slider-container"  id="<?php echo $data['id']; ?>"  data-id="<?php echo $data['id']; ?>" data-min="<?php echo $data['min']; ?>" data-max="<?php echo $data['max']; ?>" data-step="<?php echo $data['step']; ?>" data-handles="1" data-display="2" data-rtl="" data-float-mark="." data-resolution="1" data-default-one="<?php echo $data['default']; ?>"></div>
			</fieldset>
		<?php } ?>
		</div>
	</div>
<?php }

function viba_portfolio_admin_option_padding( $data ) { ?>
	<div class="viba-portfolio-option">
		<div class="viba-portfolio-option-info">
			<?php echo $data['title']; ?>
			<span class="description"><?php echo $data['desc']; ?></span>
		</div>
		<div class="viba-portfolio-option-value vp-padding-container">                        
        
        <?php 
        foreach ( $data['default'] as $key => $value ) {
        	echo '<div class="vp-padding-item-wrapper">';
			    echo '<div class="vp-padding-item">';
			    	echo '<label for="viba_portfolio_options_portfolio-style_styles_' . $data['slug'] . '_' . $data['id'] . '-'.$key.'">' . $key . ':</label>';
			    	echo '<input type="text" id="viba_portfolio_options_portfolio-style_styles_' . $data['slug'] . '_' . $data['id'] . '-'.$key.'" name="viba_portfolio_options[portfolio-style][styles][' . $data['slug'] . '][' . $data['id'] . ']['.$key.']" class="vp-padding-item-text" value="' . $data['default'][$key] . '"/>';
	            echo '</div>';
			echo '</div>';
		} ?>

		</div>
	</div>
<?php }

function viba_portfolio_admin_option_radio( $data ) { ?>
	<div class="viba-portfolio-option">
		<div class="viba-portfolio-option-info">
			<?php echo $data['title']; ?>
			<span class="description"><?php echo $data['desc']; ?></span>
		</div>
		<div class="viba-portfolio-option-value">
			<fieldset class="redux-field-container redux-field redux-field-init redux-container-button_set"  data-id="<?php echo $data['slug'] . '_' . $data['id']; ?>" data-type="button_set" id="viba_portfolio_options-<?php echo $data['slug'] . '_' . $data['id']; ?>">
                    <div class="buttonset ui-buttonset">
                        
                        <?php 
                        foreach ($data['options'] as $key => $value) { 
		                    $selected = checked( $data['default'], $key, false );
		                    
		                    echo '<input data-id="viba_portfolio_options_portfolio-style_styles_' . $data['slug'] . '_' . $data['id'] . '" type="radio" id="viba_portfolio_options_portfolio-style_styles_' . $data['slug'] . '_' . $data['id'] . '-buttonset'.$key.'" name="viba_portfolio_options[portfolio-style][styles][' . $data['slug'] . '][' . $data['id'] . ']" class="buttonset-item" value="' . $key . '" ' . $selected . '/>';
                			echo '<label for="viba_portfolio_options_portfolio-style_styles_' . $data['slug'] . '_' . $data['id'] . '-buttonset'.$key.'">' . $value . '</label>';
		 				} ?>

                    </div>
                </fieldset>
		</div>
	</div>
<?php }

function viba_portfolio_admin_option_checkboxes( $data ) { ?>
	<div class="viba-portfolio-option">
		<div class="viba-portfolio-option-info">
			<?php echo $data['title']; ?>
			<span class="description"><?php echo $data['desc']; ?></span>
		</div>
		<div class="viba-portfolio-option-value">
			<?php

			echo '<fieldset class="redux-field-container redux-field redux-field-init redux-container-checkbox" data-id="viba_portfolio_options_portfolio-style_styles_' . $data['slug'] . '_' . $data['id'] . '" data-type="checkbox">';
			echo '<ul>';

			if ( ! empty( $data['options'] ) && ( is_array( $data['options'] ) || is_array( $data['default'] ) ) ) {

                if ( ! isset( $data['default'] ) ) {
                     $data['default'] = array();
                }
                if ( ! is_array( $data['default'])) {
                     $data['default'] = array();
                }

                foreach ($data['options'] as $key => $value ) {

                    if (empty( $data['default'][$key])) {
                         $data['default'][$key] = "";
                    }

                    echo '<li>';
                    echo '<label for="viba_portfolio_options_portfolio-style_styles_' . $data['slug'] . '_' . $data['id'] . '_' . $key . '">';

                    echo '<input type="hidden" class="checkbox-check" data-val="1" name="viba_portfolio_options[portfolio-style][styles][' . $data['slug'] . '][' . $data['id'] . '][' . $key . ']" value="' . $data['default'][$key] . '" ' . '/>';
                    
                    echo '<input type="checkbox" class="checkbox" id="viba_portfolio_options_portfolio-style_styles_' . $data['slug'] . '_' . $data['id'] . '_' . $key . '"  value="1" ' . checked( $data['default'][$key], '1', false) . '/>';
                    echo $value . '</label>';
                    echo '</li>';
                }
            } elseif ( empty( $data['data'] ) ) {

                // Got the "Checked" status as "0" or "1" then insert it as the "value" option
                //$ch_value = 1; // checked($this->value, '1', false) == "" ? "0" : "1";
                echo '<input type="hidden" class="checkbox-check" data-val="1" name="viba_portfolio_options[portfolio-style][styles][' . $data['slug'] . '][' . $data['id'] . ']" value="' . $data['default'] . '"/>';
                echo '<input type="checkbox" id="viba_portfolio_options_portfolio-style_styles_' . $data['slug'] . '_' . $data['id'] . '" value="1" class="checkbox" ' . checked( $data['default'], '1', false ) . '/>';

            }

            echo '</ul>';
            echo '</fieldset>' ?>
		</div>
	</div>
<?php }

function viba_portfolio_admin_option_text( $data ) { ?>
	<div class="viba-portfolio-option">
		<div class="viba-portfolio-option-info">
			<?php echo $data['title']; ?>
			<span class="description"><?php echo $data['desc']; ?></span>
		</div>
		<div class="viba-portfolio-option-value">
			<?php
			echo '<input type="text" id="viba_portfolio_options_portfolio-style_styles_' . $data['slug'] . '_' . $data['id'] . ']-text" name="viba_portfolio_options[portfolio-style][styles][' . $data['slug'] . '][' . $data['id'] . ']" value="' . esc_attr( $data['default'] ) . '" class="regular-text" /><br />';?>
		</div>
	</div>
<?php }

function viba_portfolio_admin_option_color( $data ) { ?>
	<div class="viba-portfolio-option">
		<div class="viba-portfolio-option-info">
			<?php echo $data['title']; ?>
			<span class="description"><?php echo $data['desc']; ?></span>
		</div>
		<div class="viba-portfolio-option-value">
			<div class="viba-portfolio-color-picker-wrapper">
			<?php
			echo '<div class="viba-portfolio-color-picker redux-field redux-field-init redux-field-container redux-container-color" data-id="' . $data['slug'] . '-' . $data['id'] . '" data-type="color">';
			echo '<strong>' . __( 'Background:', 'viba-portfolio' ) . '</strong><input data-id="' . $data['slug'] . '-' . $data['id'] . '" id="viba_portfolio_options_portfolio-style_styles_' . $data['slug'] . '_' . $data['id'] . '-background" name="viba_portfolio_options[portfolio-style][styles][' . $data['slug'] . '][' . $data['id'] . '][background]" value="'.$data['default']['background'].'" class="redux-color redux-color-init"  type="text" data-default-color="' . $data['default']['background'] . '" />';
			echo '</div>';
			echo '<div class="viba-portfolio-color-picker redux-field redux-field-init redux-field-container redux-container-color" data-id="' . $data['slug'] . '-' . $data['id'] . '" data-type="color">';
			echo '<strong>' . __( 'Text:', 'viba-portfolio' ) . '</strong><input data-id="' . $data['slug'] . '-' . $data['id'] . '" id="viba_portfolio_options_portfolio-style_styles_' . $data['slug'] . '_' . $data['id'] . '-text" name="viba_portfolio_options[portfolio-style][styles][' . $data['slug'] . '][' . $data['id'] . '][text]" value="'.$data['default']['text'].'" class="redux-color redux-color-init"  type="text" data-default-color="' . $data['default']['text'] . '" />';
			echo '</div>';
			?>
			</div>
		</div>
	</div>
<?php }

function viba_portfolio_admin_option_ace_editor( $data ) { ?>
	<div class="viba-portfolio-option <?php echo $data['id']; ?>">
		<div class="viba-portfolio-option-info">
			<?php echo $data['title']; ?>
			<span class="description"><?php echo $data['desc']; ?></span>
			<span class="description"><?php printf( __( 'Use the prefix %s if you want CSS styles to apply only to this style.', 'viba-portfolio' ), '<code>.vp-style-'.$data['slug'].'</code>' ); ?></span>
			<span class="description"><?php printf( __( 'For example %s', 'viba-portfolio' ), '<code>.vp-style-'.$data['slug'].' .viba-portfolio-item { background:#000 }</code>' ); ?></span>
		</div>
		<fieldset id="viba_portfolio_options-<?php echo $data['slug'] . '-' . $data['id'] . ''; ?>" class="viba-portfolio-option-value viba-portfolio-ace-container viba-portfolio-field-init viba-portfolio-container-ace_editor" data-id="<?php echo $data['slug'] . '-' . $data['id'] . ''; ?>" data-type="ace_editor">
			<?php 
			if ( ! isset( $data['mode'] ) ) {
                    $data['mode'] = 'javascript';
                }
                if ( ! isset( $data['theme'] ) ) {
                    $data['theme'] = 'monokai';
                }
                ?>
                <div class="ace-wrapper">
                    <textarea name="<?php echo 'viba_portfolio_options[portfolio-style][styles][' . $data['slug'] . '][' . $data['id'] . ']'; ?>" id="<?php echo $data['slug'] . '-' . $data['id'] . ''; ?>-textarea" class="ace-editor hide" data-editor="<?php echo $data['slug'] . '-' . $data['id'] . ''; ?>-editor" data-mode="<?php echo $data['mode']; ?>" data-theme="<?php echo $data['theme']; ?>"><?php echo $data['default']; ?></textarea>
                    <pre id="<?php echo $data['slug'] . '-' . $data['id'] . ''; ?>-editor"
                         class="ace-editor-area"><?php echo htmlspecialchars( $data['default'] ); ?></pre>
                </div>

		</fieldset>


	</div>
<?php }

function viba_portfolio_admin_option_hover_effects( $data ) { ?>
	<div class="viba-portfolio-option">
		<div class="viba-portfolio-option-info">
			<?php echo $data['title']; ?>
			<span class="description"><?php echo $data['desc']; ?></span>
		</div>
		<div class="viba-portfolio-option-value <?php echo $data['id']; ?>">
		<?php 
			echo '<fieldset class="redux-field-container redux-field redux-field-init redux-container-checkbox" data-id="viba_portfolio_options_portfolio-style_styles_' . $data['slug'] . '_' . $data['id'] . '_overlay" data-type="checkbox">';
			echo '<ul>';

			if ( ! empty( $data['options'] ) && ( is_array( $data['options'] ) || is_array( $data['default']['overlay'] ) ) ) {

                if ( ! isset( $data['default'] ) ) {
                     $data['default']['overlay'] = array();
                }
                if ( ! is_array( $data['default'])) {
                     $data['default']['overlay'] = array();
                }

                foreach ($data['options']['overlay'] as $key => $value ) {

                    if (empty( $data['default']['overlay'][$key])) {
                         $data['default']['overlay'][$key] = "";
                    }

                    echo '<li>';
                    echo '<label for="viba_portfolio_options_portfolio-style_styles_' . $data['slug'] . '_' . $data['id'] . '_image_' . $key . '">';

                    echo '<input type="hidden" class="checkbox-check" data-val="1" name="viba_portfolio_options[portfolio-style][styles][' . $data['slug'] . '][' . $data['id'] . '][overlay][' . $key . ']" value="' . $data['default']['overlay'][$key] . '" ' . '/>';
                    
                    echo '<input type="checkbox" class="checkbox" id="viba_portfolio_options_portfolio-style_styles_' . $data['slug'] . '_' . $data['id'] . '_image_' . $key . '"  value="1" ' . checked( $data['default']['overlay'][$key], '1', false) . '/>';
                    echo $value . '</label>';
                    echo '</li>';
                }
            } elseif ( empty( $data['data']['overlay'] ) ) {

                // Got the "Checked" status as "0" or "1" then insert it as the "value" option
                //$ch_value = 1; // checked($this->value, '1', false) == "" ? "0" : "1";
                echo '<input type="hidden" class="checkbox-check" data-val="1" name="viba_portfolio_options[portfolio-style][styles][' . $data['slug'] . '][' . $data['id'] . ']" value="' . $data['default']['overlay'] . '"/>';
                echo '<input type="checkbox" id="viba_portfolio_options_portfolio-style_styles_' . $data['slug'] . '_' . $data['id'] . '" value="1" class="checkbox" ' . checked( $data['default']['overlay'], '1', false ) . '/>';

            }

            echo '</ul>';
            echo '</fieldset>' ?>

            <p><?php _e( 'Image effects:', 'viba-portfolio' ); ?></p>

            <fieldset class="redux-field-container redux-field redux-field-init redux-container-button_set"  data-id="<?php echo $data['slug'] . '_' . $data['id']; ?>" data-type="button_set" id="viba_portfolio_options-<?php echo $data['slug'] . '_' . $data['id']; ?>">
                    <div class="buttonset ui-buttonset">
                        
                    <?php 
                    foreach ($data['options']['image'] as $key => $value) { 
		                $selected = checked( $data['default']['image'], $key, false );
		                    
		                   echo '<input data-id="viba_portfolio_options_portfolio-style_styles_' . $data['slug'] . '_' . $data['id'] . '_image" type="radio" id="viba_portfolio_options_portfolio-style_styles_' . $data['slug'] . '_' . $data['id'] . '-image-buttonset'.$key.'" name="viba_portfolio_options[portfolio-style][styles][' . $data['slug'] . '][' . $data['id'] . '][image]" class="buttonset-item" value="' . $key . '" ' . $selected . '/>';
               			echo '<label for="viba_portfolio_options_portfolio-style_styles_' . $data['slug'] . '_' . $data['id'] . '-image-buttonset'.$key.'">' . $value . '</label>';
		 			} ?>

                </div>
            </fieldset>
		</div>
	</div>
<?php }