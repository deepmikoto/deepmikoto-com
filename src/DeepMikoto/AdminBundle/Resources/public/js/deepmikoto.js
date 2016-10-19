$( function() {
    if ( typeof CKEDITOR != 'undefined' ) {
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.config.extraAllowedContent = 'pre(language-*)';
    }
    enableDeployTools();
    enableGoogleAutoComplete( $( '.post-location' ) );
    enableCKEditor( $( '#deepmikoto_apibundle_codingpost_content' ) );
    enableCKEditor( $( '#deepmikoto_apibundle_gamingpost_content' ) );
    enableCKEditor( $( '#deepmikoto_apibundle_staticpage_content' ) );
}, jQuery );