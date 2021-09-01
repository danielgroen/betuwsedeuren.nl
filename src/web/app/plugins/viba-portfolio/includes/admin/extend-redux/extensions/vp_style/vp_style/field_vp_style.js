jQuery(document).ready(function($) {

	"use strict";

	redux.field_objects = redux.field_objects || {};
    redux.field_objects.ace_editor = redux.field_objects.ace_editor || {};

	redux.field_objects.ace_editor.viba_portfolio_init = function( selector ) {
        if ( !selector ) {
            selector = $( document ).find( '.viba-portfolio-container-ace_editor' );
        }

        $( selector ).each(
            function() {
                var el = $( this );
                var parent = el;
                if ( !el.hasClass( 'viba-portfolio-ace-container' ) ) {
                    parent = el.parents( '.viba-portfolio-ace-container:first' );
                }
                if ( parent.hasClass( 'viba-portfolio-field-init' ) ) {
                    parent.removeClass( 'viba-portfolio-field-init' );
                } else {
                    return;
                }
                el.find( '.ace-editor' ).each(
                    function( index, element ) {
                        var area = element;
                        var editor = $( element ).attr( 'data-editor' );

                        var aceeditor = ace.edit( editor );
                        aceeditor.setTheme( "ace/theme/" + jQuery( element ).attr( 'data-theme' ) );
                        aceeditor.getSession().setMode( "ace/mode/" + $( element ).attr( 'data-mode' ) );
                        var parent = '';
                        if ( el.hasClass( 'viba-portfolio-ace-container' ) ) {
                            parent = el.attr( 'data-id' );
                        } else {
                            parent = el.parents( '.viba-portfolio-ace-container:first' ).attr( 'data-id' );
                        }

                        //aceeditor.setOptions( redux.ace_editor[parent] );
                        aceeditor.on(
                            'change', function( e ) {
                                $( '#' + area.id ).val( aceeditor.getSession().getValue() );
                                redux_change( $( element ) );
                                aceeditor.resize();
                            }
                        );
                    }
                );
            }
        );
    };

	function viba_portflio_admin_generete_styles() {

		$( "#viba-portfolio-styles" ).accordion({
			collapsible: false,
			active: $( ".viba-portfolio-accordion-content" ).length - 1,
			heightStyle: "content",
			autoHeight: false,
			animation: 100,
			activate: function() {
				redux.field_objects.slider.init();
				redux.field_objects.button_set.init();
				redux.field_objects.color.init();
				redux.field_objects.checkbox.init();
			}
		});

		$('.viba-portfolio-option-tabs').tabs({
			hide: 100, show: 100,
			activate: function() { 
				redux.field_objects.slider.init();
				redux.field_objects.button_set.init();
				redux.field_objects.color.init();
				redux.field_objects.checkbox.init();
			}
		});

		var viba_portfolio_style = [];
		
		$( '.viba-portfolio-style-tabs a.viba-portfolio-style-link' ).each( function( key, value ) {
			viba_portfolio_style[key] = $( this ).data( 'id' );
		});

		var viba_type_tab = $('.viba-portfolio-type-tabs');
		
		viba_type_tab.each( function( key, value ){
			var $this = $( value ),
				viba_portfolio_types = [],
				viba_type_tab_active = $this.data( 'active' );

			$this.find( '.viba-portfolio-type-link' ).each( function( key, value ) {
				viba_portfolio_types[key] = $( this ).data( 'key' );
			});

			$(this).tabs({ 
				hide: 100, 
				show: 100,
				active: viba_portfolio_types.indexOf(viba_type_tab_active),
				activate: function() { 
					var current_type = viba_portfolio_types[$this.tabs( 'option', 'active' )];
					$this.children( '.portfolio-type' ).val( current_type );
				}
			});

		});

		var viba_style_tab = $('.viba-portfolio-style-tabs');
		
		viba_style_tab.each( function( key, value ){
			var $this = $( value ),
				viba_portfolio_styles = [],
				viba_style_tab_active = $this.data( 'active' );

			$this.find( '.viba-portfolio-style-link' ).each( function( key, value ) {
				viba_portfolio_styles[key] = $( this ).data( 'key' );
			});

			$(this).tabs({ 
				hide: 100, 
				show: 100,
				active: viba_portfolio_styles.indexOf(viba_style_tab_active),
				activate: function() { 
					var current_style = viba_portfolio_styles[$this.tabs( 'option', 'active' )];
					$this.parent('.viba-portfolio-type-tabs').children( '.portfolio-style' ).val( current_style );
				}
			});

		});
	}

	viba_portflio_admin_generete_styles();
	redux.field_objects.checkbox.init();
	redux.field_objects.color.init();
	redux.field_objects.ace_editor.viba_portfolio_init();

	$(".viba-portfolio-query-field select, .vp-typography-field select").select2({ allowClear: true });

	$( document ).on( 'click', '.viba-portfolio-add-style a', function( event ) {
		event.preventDefault();

		var $this = $( this),
			style_container = $( '#viba-portfolio-styles' ),
			style_name = $( '.viba-portfolio-input-new-style' ).val(),
			nonce = $this.data( 'nonce' ),
			number_of_accordions = $( '#viba-portfolio-styles .ui-accordion-header' ).length;

		if ( style_name == '' ) { $( '.viba-portfolio-input-new-style' ).focus(); return; }

		$this.addClass( 'active' );

		$.ajax({
			url: ajaxurl,
	  		data: {
		        action: 'viba_portfolio_create_new_style',
		        nonce : nonce,
		        style: style_name
		    },
			success: function( data ) {
				
				$( data ).appendTo( style_container );

				$( '#viba-portfolio-styles' ).accordion('destroy');
				viba_portflio_admin_generete_styles();

				$( '#viba-portfolio-styles' ).accordion( "option", "active", number_of_accordions );
				
				redux.field_objects.slider.init();
				redux.field_objects.button_set.init();
				redux.field_objects.color.init();
				redux.field_objects.ace_editor.viba_portfolio_init();
				redux.field_objects.checkbox.init();
				redux.field_objects.select.init();
				
				$(".viba-portfolio-query-field select, .vp-typography-field select").select2({ allowClear: true });

				$this.removeClass( 'active' );

			    $( 'html, body' ).animate({
		            scrollTop: $( '#viba-portfolio-styles' ).offset().top + ( ( number_of_accordions - 1 ) * 72 )
		        }, 1400 );

		        $( '.viba-portfolio-input-new-style' ).val( '' );


				  
			}
		});

	});

    $( document ).on( 'click', '.viba-portfolio-duplicate-style a', function( event ) {
        event.preventDefault();

        var $this = $( this),
            style_container = $( '#viba-portfolio-styles' ),
            style_id = $( '.viba-portfolio-duplicate-style-select' ).val(),
            style_name = $( '.viba-portfolio-input-duplicate-style' ).val(),
            nonce = $this.data( 'nonce' ),
            number_of_accordions = $( '#viba-portfolio-styles .ui-accordion-header' ).length;

        if ( style_name == '' ) { $( '.viba-portfolio-input-duplicate-style' ).focus(); return; }

        $this.addClass( 'active' );

        $.ajax({
            url: ajaxurl,
            data: {
                action: 'viba_portfolio_duplicate_style',
                nonce : nonce,
                slug : style_id,
                style: style_name
            },
            success: function( data ) {
                
                $( data ).appendTo( style_container );

                $( '#viba-portfolio-styles' ).accordion('destroy');
                viba_portflio_admin_generete_styles();

                $( '#viba-portfolio-styles' ).accordion( "option", "active", number_of_accordions );
                
                redux.field_objects.slider.init();
                redux.field_objects.button_set.init();
                redux.field_objects.color.init();
                redux.field_objects.ace_editor.viba_portfolio_init();
                redux.field_objects.checkbox.init();
                redux.field_objects.select.init();
                
                $(".viba-portfolio-query-field select, .vp-typography-field select").select2({ allowClear: true });

                $this.removeClass( 'active' );

                $( 'html, body' ).animate({
                    scrollTop: $( '#viba-portfolio-styles' ).offset().top + ( ( number_of_accordions - 1 ) * 72 )
                }, 1400 );

                $( '.viba-portfolio-input-duplicate-style' ).val( '' );
            }
        });

    });

	$( document ).on( 'click', '.viba-portfolio-delete-style', function( event ) {
		event.preventDefault();
		event.stopPropagation();

		var accordion_header = $( this ).parent( '.ui-accordion-header' ),
			accordion_content = accordion_header.next( '.ui-accordion-content' );

		if ( true == confirm( 'Are you sure?' ) ) {
			accordion_header.remove();
			accordion_content.remove();
		}

	});

});