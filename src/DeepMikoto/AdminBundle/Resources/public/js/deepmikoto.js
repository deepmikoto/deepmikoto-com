$( function() {
    enableDeployTools();
    enableGoogleAutoComplete( $( '.post-location' ), $( '.post-latitude' ), $( '.post-longitude' ) );
    enableCKEditor( $( '#deepmikoto_apibundle_codingpost_content' ) );
    enableCKEditor( $( '#deepmikoto_apibundle_gamingpost_content' ) );
    enableCKEditor( $( '#deepmikoto_apibundle_staticpage_content' ) );
}, jQuery );