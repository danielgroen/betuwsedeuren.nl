jQuery(document).ready(function( $ ) {

	'use strict';

	function viba_portfolio_permalinks() {

		var selectedValue = $('#permalinks-base-text').val(),
			radioValues = $('.viba_portfolio_permalink'),
			custom = $('.viba_portfolio_permalink_custom');

		$('input.viba_portfolio_permalink').change(function() {
			$('#permalinks-base-text').val( $(this).val() );
		});
		
		if ( selectedValue != "" ) {
			custom.prop( "checked", true );
         }	

         $.each( radioValues, function( i,val ) {
			if ( selectedValue == val.value ) {
				val.checked = true;
			}                   
		});

	}

	viba_portfolio_permalinks();

	var viba_portfolio_metaboxes = [
		{ 
			'format' : $('#post-format-gallery'),
			'section' : $('.viba_portfolio_gallery') 
		},
		{ 
			'format' : $('#post-format-gallery'),
			'section' : $('.viba_portfolio_gallery_type') 
		},
		{ 
			'format' : $('#post-format-video'),
			'section' : $('.viba_portfolio_video') 
		},
		{ 
			'format' : $('#post-format-audio'),
			'section' : $('.viba_portfolio_audio') 
		},
		{ 
			'format' : $('#post-format-link'),
			'section' : $('.viba_portfolio_link') 
		}
	];

	function viba_portfolio_hide_metaboxes() {

		for( var i = 0 ; i < viba_portfolio_metaboxes.length ; i++ ) {
			if( viba_portfolio_metaboxes[i].format.is(':checked') ) {
				viba_portfolio_metaboxes[i].section.css('display', 'block');
			} else {
				viba_portfolio_metaboxes[i].section.css('display', 'none');
			}
		}
		
	}

	viba_portfolio_hide_metaboxes();

	$('#post-formats-select input').change( function() {
		viba_portfolio_hide_metaboxes();

		var viba_portfolio_formats_value = '#' + $(this).attr('id');

		viba_portfolio_metaboxes.filter(function ( metabox ) {
			if ( viba_portfolio_formats_value == metabox.format ) {
				metabox.section.css('display', 'block');
			}
		});
	});

	
	$('.viba-portfolio-color-init').wpColorPicker();

	// Prepare the variables that hold our custom media manager and gallery data
	var viba_portfolio_gallery_frame,
		$viba_portfolio_attachment_ids,
		$viba_portfolio_image_gallery_ids = $( '.viba-portfolio-gallery-images-ids' ),
		$viba_portfolio_gallery_images 	 = $( '.viba-portfolio-gallery-thumbs' );

	$( '.viba-portfolio-type-gallery' ).on( 'click', '.button', function( event ) {

		$viba_portfolio_attachment_ids = $viba_portfolio_image_gallery_ids.val();
		event.preventDefault();

		// If the frame already exists, re-open it.
		if ( viba_portfolio_gallery_frame ) {
			viba_portfolio_gallery_frame.open();
			return;
		}

		// The media frame doesn't exist let, so let's create it with some options.
		viba_portfolio_gallery_frame = wp.media.frames.viba_portfolio_gallery_frame = wp.media({
			// Set the title of the modal.
			title: viba_portfolio_admin.gallery_title,
			button: {
				text: viba_portfolio_admin.add_to_gallery_text,
			},
			library: {
                type: 'image' // let's limit the view to images only
            },
			multiple: true
		});

		// When an image is selected, run a callback.
		viba_portfolio_gallery_frame.on( 'select', function() {

			var selection = viba_portfolio_gallery_frame.state().get( 'selection' ),
				attachment_caption = '';

			selection.map( function( attachment ) {

				attachment = attachment.toJSON();

				if ( attachment && attachment.id != '0' ) {

					$viba_portfolio_attachment_ids = $viba_portfolio_attachment_ids ? $viba_portfolio_attachment_ids + "," + attachment.id : attachment.id;
					attachment_caption = attachment.caption ? '<span class="viba-portfolio-caption">' + attachment.caption + '</span>' : '';
					var attachment_img_src = typeof( attachment.sizes.thumbnail ) !== 'undefined' ? attachment.sizes.thumbnail.url : attachment.sizes.full.url;

					$viba_portfolio_gallery_images.append('\
						<li data-attachment-id="' + attachment.id + '">\
							<img src="' + attachment_img_src + '" />\
							<a class="viba-portfolio-actions edit" href="'+attachment.editLink+'" title="'+ viba_portfolio_admin.edit_image_text +'">'+ viba_portfolio_admin.edit_image_text +'</a>\
							<span class="viba-portfolio-actions delete" title="'+ viba_portfolio_admin.remove_image_text +'"></span>\
							' + attachment_caption+ '\
						</li>');

					}

			});

			$viba_portfolio_image_gallery_ids.val( $viba_portfolio_attachment_ids );

		});

		// Let's open the frame
		viba_portfolio_gallery_frame.open();
	});

	// Image Sorting
	$viba_portfolio_gallery_images.sortable({
		items: 'li',
		helper: 'clone',
		opacity: 0.70,
		update: function(event, ui) {
			var attachment_ids = '';
				$( '.viba-portfolio-gallery-thumbs li' ).each(function() {
				var attachment_id = $(this).attr( 'data-attachment-id' );
				attachment_ids = attachment_ids ? attachment_ids + "," + attachment_id : attachment_id;
			});
				$viba_portfolio_image_gallery_ids.val( attachment_ids );
		}
	});

	// Delete Image
	$( '.viba-portfolio-gallery-thumbs' ).on( 'click', '.delete', function() {
		$(this).closest( 'li' ).remove();

		var attachment_ids = '';
		$( '.viba-portfolio-gallery-thumbs li' ).each(function() {
			var attachment_id = $(this).attr( 'data-attachment-id' );
			attachment_ids = attachment_ids ? attachment_ids + "," + attachment_id : attachment_id;
		});

		$viba_portfolio_image_gallery_ids.val( attachment_ids );
	});

	

	// Open video and audio frame
	$( document ).on( 'click', '.viba-portfolio-upload-button', function( event ) {

		event.preventDefault();
		
		var viba_portfolio_upload_frame,
			$button = $(this),
			$button_parent = $button.parents( '.viba-portfolio-upload-field' ),
			title = $button.data( 'title' ),
			library = $button.data( 'library' );

		// If the frame already exists, re-open it.
		if ( viba_portfolio_upload_frame ) {
			viba_portfolio_upload_frame.open();
			return;
		}

		// Sets up the media library frame
		viba_portfolio_upload_frame = wp.media.frames.viba_portfolio_upload_frame = wp.media({
			title: title,
			library: { type: library }
		});

		
		// Runs when an image is selected.
		viba_portfolio_upload_frame.on( 'select', function(){
			
			var selection = viba_portfolio_upload_frame.state().get('selection');

			selection.map( function( attachment ) {
 				
 				// Grabs the attachment selection and creates a JSON representation of the model.
		    	var media_attachment = attachment.toJSON();

		    	// Sends the attachment URL and ID to our custom input field.
		    	$button_parent.addClass( 'vp-active' );
				$button_parent.find( 'input.viba-portfolio-hosted-upload' ).val( media_attachment.id );
				$button_parent.find( 'input.viba-portfolio-hosted-upload-url' ).val( media_attachment.url );
			
			});
		});

		// Opens the media library frame.
		viba_portfolio_upload_frame.open();


	});

	$( '.viba-portfolio-upload-tabs' ).tabs();

	// Add new video and audio upload
	$( document ).on( 'click', '.viba-portfolio-add-button', function( event ) {
		event.preventDefault();

		var $this = $( this ),
			$upload_field = $this.prev( '.viba-portfolio-upload-field' ),
			$new_upload_field = $upload_field.clone();

		$new_upload_field.find( 'input[type="text"], input[type="hidden"]' ).prop( 'value', '' );
		$upload_field.after( $new_upload_field );

	});

	// Remove video and audio field
	$( document ).on( 'click', '.viba-portfolio-remove-button', function( event ) {
		event.preventDefault();

		var $remove_field = $( this ).parents( '.viba-portfolio-upload-field' );
		$remove_field.remove();

	});

	// Empty video and audio field
	$( document ).on( 'click', '.viba-portfolio-empty-button', function( event ) {
		event.preventDefault();

		var $empty_field = $( this ).parents( '.viba-portfolio-upload-field' ),
			length = $( this ).parents( '.vp-upload-tab' ).find( '.viba-portfolio-upload-field' ).length;

		if ( length > 1 ) {
			$empty_field.remove();
		} else {
			$( this ).parents( '.viba-portfolio-upload-field:first-child' ).removeClass( 'vp-active' );
			$empty_field.find( 'input[type="text"], input[type="hidden"]' ).prop( 'value', '' );
		}

	});

	$( document ).on( 'change', '.viba-portfolio-external-field input[type="text"]', function() {
		var $this = $( this );
		if ( $this.val() != '' ) {
  			$this.parents( '.viba-portfolio-upload-field' ).addClass( 'vp-active' );
		} else{
			$this.parents( '.viba-portfolio-upload-field' ).removeClass( 'vp-active' );
		}
	});

	// Upload Field Sorting
	$( '.viba-portfolio-section-field' ).sortable({
		items: '.viba-portfolio-upload-field',
		helper: 'clone',
		opacity: 0.70
	});


});