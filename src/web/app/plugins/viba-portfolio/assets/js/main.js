var $j = jQuery.noConflict();
var viba_portfolio = {
	init: function() {
		viba_portfolio_layout();
		viba_portfolio_fit_window_width();
		viba_portfolio_filter();
		viba_portfolio_load_more();
		viba_portfolio_likes();
		viba_portfolio_hoverdirections();
		viba_portfolio_max_height();
		viba_portfolio_on_resize();
		viba_portfolio_single_media();
		viba_portfolio_open_with_ajax();
		viba_portfolio_lightbox();
	},
	afterLoadMore : function() {
		viba_portfolio_hoverdirections();
		viba_portfolio_max_height();
		viba_portfolio_on_resize();
		viba_portfolio_lightbox();
	},
	afterOpenWithAjax : function() {
		viba_portfolio_single_media();
		viba_portfolio_mediaelement();
		viba_portfolio_lightbox();	
	},
	scrollElement: 'html, body'
};

$j( document ).ready( function() {
	//'use strict';
	viba_portfolio.init();
});

/*
var extend_viba_portfolio = {
	afterLoadMore : function() {
		viba_portfolio_hoverdirections();
		my_init_function();
		alert( 'hello' );
	},
	afterOpenWithAjax : function() {
		viba_portfolio_single_media();
		viba_portfolio_mediaelement();
		viba_portfolio_lightbox();
		my_init_function();
		alert( 'hello' );
	}
};
jQuery( document ).ready( function( $ ) {
	$.extend( viba_portfolio, extend_viba_portfolio );
});
*/

/*
   If you want to override function behavior then copy it to your theme js file
   with the same name. For example:
	
	function viba_portfolio_likes(){
		'use strict';
		jQuery( document ).on( 'click', '.viba-portfolio-likes', function( event ) {
			event.preventDefault();
    		alert ( 'hello' );
		});
   }

*/

if ( typeof window['viba_portfolio_likes'] !== 'function' ) {
	function viba_portfolio_likes() {
		'use strict';
		$j( document ).on( 'click', '.viba-portfolio-likes', function( event ) {
			event.preventDefault();
    		viba_portfolio_likes_ajax( $j( this ), 'true' );
		});

		$j( '.viba-portfolio-ajax-likes .viba-portfolio-likes' ).each( function() {
			viba_portfolio_likes_ajax( $j( this ), 'false' );
	    });
	}
}

if ( typeof window['viba_portfolio_likes_ajax'] !== 'function' ) {
	function viba_portfolio_likes_ajax( link, click ) {
		'use strict';

		if( link.hasClass( 'active' ) && click == 'true' ) return;

		if ( 'true' == click ) {
			link.addClass( 'js-vp-loading' );
		}
		
		var id = link.data( 'id' );
		$j.ajax({
			url: viba_portfolio_ajax.ajax_url,
	  			data: {
		            action: 'viba_portfolio_likes',
		            post_id: id,
		            click: click
		        },
				success: function( data ) {
					data = $j.parseJSON( data );
					link.removeClass( 'js-vp-loading' );
					
					if ( data.type == 'success' ) {
						$j( '.viba-portfolio-likes[data-id='+id+']' ).each( function() {
							$j( this ).addClass( 'active' ).find( '.viba-portfolio-likes-count' ).text( data.likes );
						});
					}

					if ( click == 'false' ) {
						link.removeClass( 'active' ).find( '.viba-portfolio-likes-count' ).text( data.likes );
						if ( data.type == 'active' ) {
							link.addClass( 'active' );
						}
					}
				}
		});
	}
}

if ( typeof window['viba_portfolio_fit_window_width'] !== 'function' ) {
	function viba_portfolio_fit_window_width() {
		'use strict';

		$j( window ).on( 'resize', function() {
			
			var $this = $j( '.vp-size-fullwidth' ),
				site = $j( 'html' ),
				padding = $this.outerWidth() - $this.width(),
				width = site.width() - padding,
				left = site.offset().left;

			$this.width( width ).offset({ left: left });

		}).resize();

	}
}

if ( typeof window['viba_portfolio_hoverdirections'] !== 'function' ) {
	function viba_portfolio_hoverdirections() {
		'use strict';

		$j( '.vp-direction-aware .viba-portfolio-item-inner' ).hoverdirections({
			prefix_in: 'vp-in',
	        prefix_out: 'vp-out'
		});
	}
}

if ( typeof window['viba_portfolio_max_height'] !== 'function' ) {
	function viba_portfolio_max_height() {
		'use strict';
		
		if ( $j( '.viba-portfolio-max-height' ).length ) {
			// add max-height to elements for css animations
			$j( document ).on( 'mouseenter', '.viba-portfolio-item-inner', function() {
				var $max_height = $j( this ).find( '.viba-portfolio-max-height' );
				
				$max_height.each( function(){
					$j( this ).css( { maxHeight : $j( this ).get(0).scrollHeight + 'px' } );
				})
				
			}).on( 'mouseleave', '.viba-portfolio-item-inner', function() {
				$j( '.viba-portfolio-max-height' ).css( { maxHeight : '0px' } );
			});
		}
	}
}

if ( typeof window['viba_portfolio_on_resize'] !== 'function' ) {
	function viba_portfolio_on_resize() {
		'use strict';

		$j( window ).on( 'resize', function() {

			if ( $j( '.viba-portfolio-js-height' ).length ) {
				$j( '.viba-portfolio-item-inner' ).each( function() {
					var contentHeight = $j( this ).find( '.viba-portfolio-content' ).outerHeight(),
						maxHeight = $j( this ).find( '.viba-portfolio-max-height' ).length ? $j( this ).find( '.viba-portfolio-max-height' ).get(0).scrollHeight : 0,
						height = contentHeight + maxHeight;
					$j( this ).find( '.viba-portfolio-js-height' ).css( 'padding-bottom', height );
				});
			}

			if ( $j( '.viba-portfolio-js-width' ).length ) {
				$j( '.viba-portfolio-item-inner' ).each( function() {
					var contentWidth = $j( this ).find( '.viba-portfolio-content' ).outerWidth();
					$j( this ).find( '.viba-portfolio-js-width' ).css( 'padding-right', contentWidth );
				});
			}

		}).resize();

	}
}

if ( typeof window['viba_portfolio_mediaelement'] !== 'function' ) {
	function viba_portfolio_mediaelement() {
		'use strict';

		if ( typeof jQuery.fn.mediaelementplayer !== 'undefined') {

             var $audio_shortcode = $j('audio.wp-audio-shortcode' ),
                $video_shortcode = $j('video.wp-video-shortcode' );

            // add mime-type aliases to MediaElement plugin support
            mejs.plugins.silverlight[0].types.push('video/x-ms-wmv');
            mejs.plugins.silverlight[0].types.push('audio/x-ms-wma');

            $j(function () {
                var settings = {};

                if ( typeof _wpmejsSettings !== 'undefined' ) {
                    settings = _wpmejsSettings;
                }

                settings.success = function (mejs) {
                    var autoplay, loop;

                    if ( 'flash' === mejs.pluginType ) {
                        autoplay = mejs.attributes.autoplay && 'false' !== mejs.attributes.autoplay;
                        loop = mejs.attributes.loop && 'false' !== mejs.attributes.loop;

                        autoplay && mejs.addEventListener( 'canplay', function () {
                            mejs.play();
                        }, false );

                        loop && mejs.addEventListener( 'ended', function () {
                            mejs.play();
                        }, false );
                    }
                };

                if ( ! $audio_shortcode.hasClass( 'mejs-audio' ) ) {
                    $audio_shortcode.mediaelementplayer( settings );
                }

                if ( ! $video_shortcode.parent( 'mejs-mediaelement' ).length ) {
                    $video_shortcode.mediaelementplayer( settings );
                }

            });

        }

        if ( typeof WPPlaylistView !== 'undefined') {
            $j( '.wp-playlist' ).each( function() {
                return new WPPlaylistView({ el: this });
            });
        }

	}
}

if ( typeof window['viba_portfolio_spinner'] !== 'function' ) {
	function viba_portfolio_spinner( el, spinner ) {
		'use strict';

		var loader = '';

		switch ( spinner ) {
			case 1:
				loader = '<div class="vp-loader vp-loader-1"></div>';
				break;
			case 2:
				loader = '<div class="vp-loader vp-loader-2"></div>';
				break;
			case 3:
				loader = '<div class="vp-loader vp-loader-3"></div>';
				break;
			case 4:
				loader = '<div class="vp-loader vp-loader-4"></div>';
				break;
			case 5:
				loader = '<div class="vp-loader vp-loader-5"></div>';
				break;
			case 6:
				loader = '<div class="vp-loader vp-loader-6"></div>';
				break;
			case 7:
				loader = '<div class="vp-loader vp-loader-7"></div>';
				break;
			case 8:
				loader = '<div class="vp-loader vp-loader-8"></div>';
				break;
			case 9:
				loader = '<div class="vp-loader vp-loader-9"><div></div><div></div><div></div></div>';
				break;
			case 10:
				loader = '<div class="vp-loader vp-loader-10"></div>';
				break;
			case 11:
				loader = '<div class="vp-loader vp-loader-11"></div>';
				break;
			case 12:
				loader = '<div class="vp-loader vp-loader-12"></div>';
				break;
		}

		el.append( '<div class="viba-portfolio-loader">' + loader + '</div>' );

	}
}

if ( typeof window['viba_portfolio_lightbox'] !== 'function' ) {
	function viba_portfolio_lightbox() {
		'use strict';

		$j( '.vp-zoom-button, .viba-portfolio-single-thumbnail a' ).magnificPopup({ 
			type: 'image',
			mainClass: 'mfp-zoom-in',
			tClose: '',
			tLoading: '',
			removalDelay: 300,
			closeOnContentClick: true,
			midClick: true,
			closeBtnInside: true,
			image: {
				cursor: null,
				verticalFit: true
			},
			callbacks: {    
				imageLoadComplete: function() {
					var self = this;
					setTimeout(function() {
						self.wrap.addClass( 'mfp-image-loaded' );
					}, 16 );
				},
				close: function() {
					this.wrap.removeClass( 'mfp-image-loaded' );
				},
			}

		});

		
		$j( '.viba-portfolio-gallery' ).each(function() {
			$j( this ).magnificPopup({ 
				delegate: 'a.viba-portfolio-media-link',
				type: 'image',
				mainClass: 'mfp-zoom-in',
				tClose: '',
				tLoading: '',
				gallery: {
					enabled: true,
					tPrev: '',
					tNext: '',
					tCounter: '%curr% / %total%',
					preload: [1,1]
				},
				removalDelay: 300,
				closeOnContentClick: true,
				midClick: true,
				closeBtnInside: true,
				image: {
					cursor: null,
					verticalFit: true
				},
				callbacks: {    
					imageLoadComplete: function() {
						var self = this;
						setTimeout(function() {
							self.wrap.addClass( 'mfp-image-loaded' );
						}, 16 );
					},
					open: function() {
						$j.magnificPopup.instance.next = function() {
							var self = this;
							self.wrap.removeClass( 'mfp-image-loaded' );
							setTimeout( function() { $j.magnificPopup.proto.next.call( self ); }, 120 );
						}
						$j.magnificPopup.instance.prev = function() {
							var self = this;
							self.wrap.removeClass( 'mfp-image-loaded' );
							setTimeout( function() { $j.magnificPopup.proto.prev.call( self ); }, 120 );
						}
					},
					close: function() {
						this.wrap.removeClass( 'mfp-image-loaded' );
					},
				}

			});
		});

	}
}

if ( typeof window['viba_portfolio_layout'] !== 'function' ) {
	function viba_portfolio_layout() {
		'use strict';

		$j( '.viba-portfolio' ).each( function( index, value ) {

			var $this = $j( this ),
				$vp_wrapper = $this.parents( '.viba-portfolio-wrapper' ),
				spinner = parseInt( $this.data( 'spinner' ) ),
				transition_duration = $this.data( 'transition-duration' );

			$vp_wrapper.addClass( 'js-vp-loading' );
			viba_portfolio_spinner( $vp_wrapper, spinner );

			if ( $vp_wrapper.hasClass( 'vp-size-fullwidth' ) ) {
				$j( 'html' ).addClass( 'vp-html-overflow' );
			}
			
			$this.apalodiImagesLoaded( function() {

				// Grid Layout
				if ( $this.hasClass( 'vp-isotope' ) ) {

					setTimeout( function() {
						$vp_wrapper.addClass( 'js-vp-loaded js-vp-ready' );
						setTimeout( function() {
							$vp_wrapper.removeClass( 'js-vp-loading js-vp-loaded' );
						}, transition_duration );
					}, 800 );

					var hidden_style = $this.data( 'isotope-hidden-style' ),
						visible_style = $this.data( 'isotope-visible-style' ),
						columnn_width = '.viba-portfolio-item';

					if ( $this.hasClass( 'vp-layout-multi-size-grid' ) ) {
						columnn_width = '.viba-portfolio-item-default';
					}

					$this.apalodi_isotope({
						itemSelector : '.viba-portfolio-item',
						layoutMode: 'packery',
						packery: {
							columnWidth: columnn_width
						},
						filter: '*',
						transitionDuration: transition_duration + 'ms',
						hiddenStyle: {
							opacity: 0,
							transform: hidden_style,
						},
						visibleStyle: {
							opacity: 1,
							transform: visible_style,
						}
					});
					
				}

				// Carousel Layout
				if ( $this.hasClass( 'vp-layout-carousel' ) ) {

					$j( 'html' ).addClass( 'vp-html-overflow' );
					$vp_wrapper.removeClass( 'js-vp-loading' ).addClass( 'js-vp-loaded js-vp-ready' );

					setTimeout( function() {
						$vp_wrapper.removeClass( 'js-vp-loaded' );
					}, transition_duration );

	
					var col_mp = $this.data( 'col-mp' ),
						col_ml = $this.data( 'col-ml' ),
						col_tp = $this.data( 'col-tp' ),
						col_tl = $this.data( 'col-tl' ),
						col_ds = $this.data( 'col-ds' ),
						col_dl = $this.data( 'col-dl' );

					$this.apalodi_owlCarousel( {
						theme: 'viba-portfolio-owl',
						itemsCustom : [
							[0, col_mp],
							[480, col_ml],
							[768, col_tp],
							[960, col_tl],
							[1124, col_ds],
							[1400, col_dl]
					    ],
					 	navigation: true,
					 	navigationText : false,
					 	pagination: true,
					 	slideSpeed: transition_duration,
					 	rewindSpeed: transition_duration / 2,
					 	addClassActive: true,
					 	autoHeight: false,
					 	beforeUpdate : function() {
					 		$this.find('.owl-item').css({ 'transition-duration': '0ms' });

					 	},
					 	afterUpdate : function() {
					 		$this.find('.owl-item').css({ 'transition-duration': transition_duration+'ms' });
					 	},
					 	afterAction : function() {
					 		var $item = $this.find( '.owl-item.active' ),
					 			array = [];
					 		$item.each( function() {
					 			array.push( $j( this ).outerHeight( true ) );
					 		});
					 		var max = Math.max.apply( Math, array );
					 		$this.find( '.owl-wrapper-outer' ).css({ 'height': max });
					 	}
					});
				}		

			}); // apalodiImagesLoaded()

		});	

	}
}

if ( typeof window['viba_portfolio_filter'] !== 'function' ) {
	function viba_portfolio_filter() {
		'use strict';

		$j( '.viba-portfolio-filter a' ).on( 'click', function( event ) {
			event.preventDefault();

			var $this = $j( this ),
				filter = $this.attr( 'data-isotope-filter' );

			$this.parents( '.viba-portfolio-filter' ).find( 'a' ).removeClass( 'selected' );
			$this.addClass( 'selected' );
			$this.parents( '.viba-portfolio-filter' ).next( $j( 'viba-portfolio' ) ).apalodi_isotope( { filter: filter } );

			if ( $this.parents( '.viba-portfolio-filter' ).find( '.vp-filter-dropdown-button' ).length ) {
				var $filter_button = $this.parents( '.viba-portfolio-filter' ).find( '.vp-filter-button' ),
					selected_text = $this.text();
				$filter_button.text( selected_text );
			}

		});

		$j( '.vp-filter-button' ).on ( 'click', function( event ) {
			var $this = $j( this );
			$this.toggleClass( 'selected' );
			if ( $this.parents( '.viba-portfolio-filter' ).hasClass( 'vp-filter-slide-in' ) ) {
				$this.next( '.viba-portfolio-filter-list' ).slideToggle(400);
			}
			else {
				$this.next( '.viba-portfolio-filter-list' ).toggleClass( 'selected' );
			}
			
		});

		$j( '.viba-portfolio-widget-filter a' ).on( 'click', function( event ) {
			event.preventDefault();

			var $this = $j( this ),
				filter = $this.attr( 'data-isotope-filter' );

			$this.parents( '.viba-portfolio-widget-filter' ).find( 'a' ).removeClass( 'selected' );
			$this.addClass( 'selected' );
			$this.parents( 'body' ).find( '.viba-portfolio.vp-isotope' ).apalodi_isotope( { filter: filter } );

		});

	}
}

if ( typeof window['viba_portfolio_load_more'] !== 'function' ) {
	function viba_portfolio_load_more() {
		'use strict';

		var viba_portfolio_load_more 		= '.vp-pagination-load-more',
			viba_portfolio_loading_class 	= 'js-vp-loading';

		$j( '.vp-load-more-count .vp-load-more' ).each( function() {
			var $this = $j( this ),
				offset = parseInt( $this.attr( 'data-offset' ) ),
				count_posts = parseInt( $this.attr( 'data-count-posts' ) ),
				count = count_posts - offset;

				$this.find( 'span.vp-load-more-text' ).append( '<span class="vp-load-more-count" />' )
				$this.find( '.vp-load-more-count' ).html( '(' + count + ')' );
		});

		$j( viba_portfolio_load_more ).on( 'click', 'a', function( event ) {
			event.preventDefault();

			var $this = $j( this ),
				post_per_page = parseInt( $this.data( 'post-per-page' ) ),
				offset = parseInt( $this.data( 'offset' ) ),
				count_posts = parseInt( $this.data( 'count-posts' ) ),
				tax = $this.data( 'tax' ) ? $this.data( 'tax' ) : false,
				term_id = $this.data( 'term-id' ) ? $this.data( 'term-id' ) : false,
				archive_page = $this.data( 'archive-page' ) ? true : false,
				search_query = $this.data( 'search-query' ) ? $this.data( 'search-query' ) : false,
				current_style = $this.parents( '.viba-portfolio-wrapper' ).data( 'style' );

			$this.addClass( viba_portfolio_loading_class );

			$j.ajax({
				type: 'GET',
				url: viba_portfolio_ajax.ajax_url,
	  			data: {
		            action: 'viba_portfolio_load_more',
		            post_per_page: post_per_page,
		            offset: offset,
		            tax : tax,
		            term_id : term_id,
		            archive_page : archive_page,
		            search_query : search_query,
		            current_style: current_style
		        },

				success: function( data ) {

					data = $j.parseJSON( data );

					if ( data.type == 'success' ) {

						var $new_items = $j( data.html ).filter( '.viba-portfolio-item' ),
							$container = $this.parents( viba_portfolio_load_more ).prev( '.viba-portfolio' );

						// Update offset
						$this.data( 'offset', offset + post_per_page );

						$new_items.apalodiImagesLoaded( function() {
							
							$this.removeClass( viba_portfolio_loading_class );
							$container.append( $new_items ).apalodi_isotope( 'appended', $new_items );

							// Are there more items to load?
							if ( offset + post_per_page >= count_posts ) {
								$this.parents( viba_portfolio_load_more ).slideUp();
							} else if ( $this.find( '.vp-load-more-count' ).length ) {
								// Update load more count
								$this.find( '.vp-load-more-count' ).html( '(' + ( count_posts - ( offset + post_per_page ) ) + ')' );
							}

							viba_portfolio.afterLoadMore();
						});

					} else if ( data.type == 'empty' ) {
						$this.parents( viba_portfolio_load_more ).slideUp();
					}
					
				},

				error: function() {
					$this.addClass( 'js-vp-ajax-error' );
					setTimeout( function() { $this.removeClass( viba_portfolio_loading_class ); }, 3000 );
				}

			});


		});

	}
}

if ( typeof window['viba_portfolio_single_media'] !== 'function' ) {
	function viba_portfolio_single_media() {
		'use strict';

		$j( '.viba-portfolio-single-thumbnail' ).each( function( index, value ) {

			var $this = $j( this ),
				$vp_wrapper = $this.parents( '.viba-portfolio-single-media' ),
				spinner = parseInt( $vp_wrapper.data( 'spinner' ) );

			$this.each( function() {
				var $this = $j( this );
				$this.addClass( 'js-vp-loading' );
				viba_portfolio_spinner( $this, spinner );

				$this.apalodiImagesLoaded( function() {
					$this.velocity({ 
						height: $this.get(0).scrollHeight + 'px' 
					}, { 
						duration: 800, 
						complete: function(elements) { $j( elements ).attr( 'style', 'height:auto' ); }
					});
					setTimeout( function() {
						$this.addClass( 'js-vp-loaded' );
						setTimeout( function() {
							$this.removeClass( 'js-vp-loading js-vp-loaded' ).addClass( 'js-vp-ready' );
						}, 400 );
					}, 1000 );
				});

			});

		});

		$j( '.viba-portfolio-gallery' ).each( function( index, value ) {

			var $this = $j( this ),
				$vp_wrapper = $this.parents( '.viba-portfolio-single-media' ),
				spinner = parseInt( $vp_wrapper.data( 'spinner' ) );
			
			if ( $this.hasClass( 'viba-portfolio-gallery-stacked' ) ) {

				var $gallery_item = $this.find( '.viba-portfolio-gallery-item' );

				$gallery_item.each( function() {
					var $this = $j( this );
					$this.addClass( 'js-vp-loading' );
					viba_portfolio_spinner( $this, spinner );

					$this.apalodiImagesLoaded( function() {	
						$this.velocity({ 
							height: $this.get(0).scrollHeight + 'px' 
						}, { 
							duration: 800, 
							complete: function(elements) { $j( elements ).attr( 'style', 'height:auto' ); }
						});
						setTimeout( function() {
							$this.addClass( 'js-vp-loaded' );
							setTimeout( function() {
								$this.removeClass( 'js-vp-loading js-vp-loaded' ).addClass( 'js-vp-ready' );
							}, 400 );
						}, 1000 );
					});

				});

			} else {

				$vp_wrapper.addClass( 'js-vp-loading' );
				viba_portfolio_spinner( $vp_wrapper, spinner );
				
			}

			$this.apalodiImagesLoaded( function() {

				if ( $this.hasClass( 'viba-portfolio-gallery-grid' ) ) {

					setTimeout( function() {
						$vp_wrapper.addClass( 'js-vp-loaded js-vp-ready' );
						setTimeout( function() {
							$vp_wrapper.removeClass( 'js-vp-loading js-vp-loaded' );
						}, 200 );
					}, 1200 );

					$this.apalodi_isotope({
						itemSelector : '.viba-portfolio-gallery-item',
						masonry: {
					  		columnWidth: '.viba-portfolio-gallery-item'
						},
					});

				}

				if ( $this.hasClass( 'viba-portfolio-gallery-slider' ) ) {

					$vp_wrapper.addClass( 'js-vp-ready' );
					setTimeout( function() {
						$vp_wrapper.addClass( 'js-vp-loaded' ).removeClass( 'js-vp-loading js-vp-loaded' );
					}, 1200 );

					$this.apalodi_owlCarousel( {
						theme: 'viba-portfolio-owl',
						singleItem: true,
					 	navigation: true,
					 	navigationText : false,
					 	slideSpeed: 600,
					 	rewindSpeed: 400,
					 	addClassActive: true,
					 	autoHeight: true
					});

				}

				if ( $this.hasClass( 'viba-portfolio-gallery-carousel' ) ) {

					$vp_wrapper.addClass( 'js-vp-ready' );
					setTimeout( function() {
						$vp_wrapper.addClass( 'js-vp-loaded' ).removeClass( 'js-vp-loading js-vp-loaded' );
					}, 1200 );

					$this.apalodi_owlCarousel( {
						theme: 'viba-portfolio-owl',
						itemsCustom : [
					    	[0, 1],
					    	[480, 2],
					    	[768, 3],
					    ],
					 	navigation: true,
					 	navigationText : false,
					 	slideSpeed: 600,
					 	rewindSpeed: 400,
					 	addClassActive: true,
					 	autoHeight: false,
					 	afterAction : function() {
					 		var $item = $this.find( '.owl-item.active' ),
					 			array = [];
					 		$item.each( function() {
					 			array.push( $j( this ).outerHeight( true ) );
					 		});
					 		var max = Math.max.apply( Math, array );
					 		$this.find( '.owl-wrapper-outer' ).css({ 'height': max });
					 	}
					});

				}

			});

		});

	}
}

if ( typeof window['viba_portfolio_open_with_ajax'] !== 'function' ) {
	function viba_portfolio_open_with_ajax() {
		'use strict';

		var viba_portfolio_actions 			= '<div class="vp-ajax-actions-wrapper"><div class="vp-ajax-actions"><a class="vp-ajax-prev"><span>'+viba_portfolio_ajax.previous+'</span></a><a class="vp-ajax-next"><span>'+viba_portfolio_ajax.next+'</span></a><a class="vp-ajax-close"><span>'+viba_portfolio_ajax.close+'</span></a></div></div>',
			viba_portfolio_ajax_content		= '<div class="vp-ajax-wrapper"><div class="vp-ajax-content"> ' + viba_portfolio_actions + '<div class="vp-ajax-inner"></div></div></div>',
			modal_counter = 0;

		$j( '.vp-ajax' ).each( function() {
			var $this = $j( this ),
				$vp_wrapper = $this.parents( '.viba-portfolio-wrapper' ),
				spinner = parseInt( $this.data( 'spinner' ) ),
				style = 'vp-style-' + $vp_wrapper.data( 'style' ),
				animation = $this.data( 'ajax-animation' ),
				width = $this.data( 'ajax-width' );
				
			if ( $this.hasClass( 'vp-ajax-modal' ) && modal_counter < 1 ) {
				modal_counter++;
				$j( 'body' ).append( $j( viba_portfolio_ajax_content ) );
				var $ajax_wrapper_modal = $j( document ).find( '.vp-ajax-wrapper' );
				viba_portfolio_spinner( $ajax_wrapper_modal, spinner );
				$ajax_wrapper_modal.addClass( 'js-vp-ajax-modal ' + style + ' ' + animation );
				$ajax_wrapper_modal.find( '.vp-ajax-content' ).css( 'maxWidth', width + 'px' );
			}

			if ( $this.hasClass( 'vp-ajax-above' ) ) {
				$j( $vp_wrapper ).prepend( $j( viba_portfolio_ajax_content ) );
				var $ajax_wrapper_above = $vp_wrapper.find( '.vp-ajax-wrapper' );
				viba_portfolio_spinner( $ajax_wrapper_above, spinner );
				$ajax_wrapper_above.addClass( 'js-vp-ajax-slide js-vp-ajax-above' );
				$ajax_wrapper_above.find( '.vp-ajax-content' ).css( 'maxWidth', width + 'px' );
			}

			if ( $this.hasClass( 'vp-ajax-below' ) ) {
				$j( $vp_wrapper ).append( $j( viba_portfolio_ajax_content ) );
				var $ajax_wrapper_below = $vp_wrapper.find( '.vp-ajax-wrapper' );
				viba_portfolio_spinner( $ajax_wrapper_below, spinner );
				$ajax_wrapper_below.addClass( 'js-vp-ajax-slide js-vp-ajax-below' );
				$ajax_wrapper_below.find( '.vp-ajax-content' ).css( 'maxWidth', width + 'px' );
			}

		});

		$j( document ).on( 'click', '.vp-ajax .viba-portfolio-link:not(.vp-ext-link)', function( event ) {
			event.preventDefault();

			var $this = $j( this ),
				link = $this.data( 'path' ),
				id = $this.data( 'id' ),
				first_id = $this.parents( '.viba-portfolio' ).find( '.viba-portfolio-item:not(.vp-format-link):first' ).find( '.viba-portfolio-link' ).data( 'id' ),
    			last_id = $this.parents( '.viba-portfolio' ).find( '.viba-portfolio-item:not(.vp-format-link):last' ).find( '.viba-portfolio-link' ).data( 'id' ),
    			prev_id = $this.parents( '.viba-portfolio-item' ).prevAll( '.viba-portfolio-item:not(.vp-format-link):first' ).find( '.viba-portfolio-link' ).data( 'id' ),
				next_id = $this.parents( '.viba-portfolio-item' ).nextAll( '.viba-portfolio-item:not(.vp-format-link):first' ).find( '.viba-portfolio-link' ).data( 'id' ),
				$ajax_wrapper = $this.parents( '.viba-portfolio' ).hasClass( 'vp-ajax-modal' ) ? $j( document ).find( '.vp-ajax-wrapper' ) : $this.parents( '.viba-portfolio-wrapper' ).find( '.vp-ajax-wrapper' ),
				$ajax_inner = $ajax_wrapper.find( '.vp-ajax-inner' ),
				$ajax_slide = $this.parents( '.viba-portfolio-wrapper' ).find(  '.js-vp-ajax-slide' ),
				$ajax_slide_content = $ajax_slide.find( '.vp-ajax-content' ),
				offset = $this.parents( '.viba-portfolio' ).data( 'ajax-offset' );

			if ( $this.parents( '.viba-portfolio' ).hasClass( 'vp-layout-carousel' ) )	{
				prev_id = $this.parents( '.owl-item' ).prevAll( '.owl-item' ).find( '.viba-portfolio-item:not(.vp-format-link)' ).last().find( '.viba-portfolio-link' ).data( 'id' );
				next_id = $this.parents( '.owl-item' ).nextAll( '.owl-item' ).find( '.viba-portfolio-item:not(.vp-format-link)' ).first().find( '.viba-portfolio-link' ).data( 'id' );
			}

			if ( next_id == null ) { next_id = first_id; }
		    if ( prev_id == null ) { prev_id = last_id; }

			$ajax_wrapper.find( '.vp-ajax-next' ).data( 'id', next_id );
    		$ajax_wrapper.find( '.vp-ajax-prev' ).data( 'id', prev_id );

    		if ( $ajax_slide.length ) {
				$j( viba_portfolio.scrollElement ).velocity( 'scroll', { offset: $ajax_slide.offset().top - offset, duration: 1000 });
			}

			$ajax_slide_content.velocity( 'slideUp', { duration: 1200, easing: 'ease' });
			$ajax_wrapper.addClass( 'js-vp-loading' );

			if ( $this.parents( '.viba-portfolio' ).hasClass( 'vp-ajax-modal' ) ) {
				$j( 'html' ).addClass( 'vp-modal-open' );
			}
		
			$j.ajax({
				url: viba_portfolio_ajax.ajax_url,
	  			data: {
					action: 'viba_portfolio_open_with_ajax',
					post_id: id
				},
				success: function( data ) {

					data = $j.parseJSON( data );

					if ( data.type == 'success' ) {

						$ajax_inner.scrollTop( 0 );
						$ajax_inner.empty();

						// wait for animations to finish
						setTimeout( function() {
							$ajax_wrapper.addClass( 'js-vp-ajax-ready js-vp-loaded' );
							setTimeout( function() {
								$ajax_wrapper.removeClass( 'js-vp-loading js-vp-loaded' );
							}, 200 );
						}, 600 );

						var $single_item = $j( data.html ).filter( '#viba-portfolio-item-' + id );

						$single_item.appendTo( $ajax_inner );

						viba_portfolio.afterOpenWithAjax();

						if ( $ajax_slide.length ) {

							$ajax_slide_content.velocity( 'slideDown', { duration: 400, easing: 'ease' });
							$j( viba_portfolio.scrollElement ).velocity( 'scroll', { offset: $ajax_slide.offset().top - offset, duration: 1000 });

						}

						// Fire Google Analytics pageview
						if ( 'object' === typeof _gaq ) {
							_gaq.push( [ '_trackPageview', link ] );
						}
						if ( 'function' === typeof ga ) {
							ga( 'send', 'pageview', link );
						}
						
						// Fire Stetic pageview
						if ( 'object' === typeof _fss ) {
							_fss.pageUri = link;
						}

					}	
				}
			});
		});	

		// Prev and next button
		$j( document ).on( 'click', '.vp-ajax-prev, .vp-ajax-next', function( event ) {
			event.preventDefault();

			var $this = $j( this ),
				actions_id = $j( this ).data( 'id' ),
				$vp_wrapper = $this.parents( '.vp-ajax-wrapper' ).hasClass( 'js-vp-ajax-modal' ) ? $j( document ).find( '.viba-portfolio:first' ) : $this.parents( '.viba-portfolio-wrapper' ).find( '.viba-portfolio' );

			$vp_wrapper.find( '.vp-item-' + actions_id ).find( '.viba-portfolio-link:first' ).trigger( 'click' );

		});	

		// Close
		$j( document ).on( 'click', '.vp-ajax-close', function( event ) {
			event.preventDefault();

			var $this = $j( this ),
				$vp_wrapper = $j( this ).parents( '.viba-portfolio-wrapper' ),
				$ajax_modal = $j( document ).find( '.js-vp-ajax-modal' ),
				$ajax_slide = $vp_wrapper.find( '.js-vp-ajax-slide' ),
				$ajax_slide_content = $ajax_slide.find( '.vp-ajax-content' ),
				$ajax_inner = $vp_wrapper.find( '.vp-ajax-wrapper' ).find( '.vp-ajax-inner' ),
				$ajax_modal_inner = $ajax_modal.find( '.vp-ajax-inner' );

			$ajax_modal.removeClass( 'js-vp-ajax-ready' );
			$ajax_slide_content.velocity( 'slideUp', { duration: 1000, easing: 'ease' });


			$ajax_modal_inner.empty();

			setTimeout( function() {
				$ajax_slide.removeClass( 'js-vp-ajax-ready' );
			 	$ajax_inner.empty();
			}, 1000 );

			$j( '.viba-portfolio-single-media audio, .viba-portfolio-single-media video' ).each( function() { this.player.pause() });
			$j( '.viba-portfolio-single-media iframe' ).remove();

			$j( 'html' ).removeClass( 'vp-modal-open' );

		});	

		// Close modal window if clicked outside
		$j( '.vp-ajax-wrapper.js-vp-ajax-modal' ).click( function( event ) { 
			if( ! $j( event.target ).closest( '.vp-ajax-content' ).length ) {
				$j( '.vp-ajax-close' ).trigger( 'click' );
			}        
		});

		// Close or load prev and next when arrow keys are pressed
		$j( document ).keydown( function( e ) { 

			if ( $j( '.mfp-wrap' ).length ) {
				e.stopPropagation(); return false;
			}

			if ( e.which === 37 ) { 
				$j( '.vp-ajax-prev' ).trigger( 'click' );
			}
			if ( e.which === 39 ) { 
				$j( '.vp-ajax-next' ).trigger( 'click' );
			} 
			if ( e.which === 27 ) { 
				$j( '.vp-ajax-close' ).trigger( 'click' );
			}
		});

	}
}