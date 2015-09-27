$( function() {
    enableDeployTools();
    enableGoogleAutoComplete( $( '.post-location' ), $( '.post-latitude' ), $( '.post-longitude' ) );
    enableCKEditor( $( '#deepmikoto_apibundle_codingpost_content' ) );
}, jQuery );