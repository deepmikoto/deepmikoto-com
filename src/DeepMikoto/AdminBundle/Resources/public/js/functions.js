/**
 * Created by MiKoRiza-OnE on 7/29/2015.
 */

/**
 * Created by MiKoRiza-OnE on 7/23/2015.
 */

/**
 * @param buttonId
 * @param url
 */
function commandButtonsBehavior( buttonId, url )
{
    $( buttonId ).on('click', function () {
        $( this ).blur().button( 'loading' );
        $.ajax({
            context: this,
            url: url,
            success: function(){
                $( this ).button( 'reset' ).addClass( 'disabled btn-success' );
            },
            error: function(){
                $( this ).button( 'reset' ).addClass( 'btn-danger');
            }
        });
    });
}
/**
 * @param autoComplete
 */
function geoLocate( autoComplete ){
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition( function( position ) {
            /** @class google.maps.LatLng */
            var geolocation = new google.maps.LatLng( position.coords.latitude, position.coords.longitude );
            /** @class google.maps.Circle */
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            /** @class autoComplete.setBounds */
            /** @class circle.getBounds */
            autoComplete.setBounds( circle.getBounds() );
        });
    }
}
/**
 * @param locationInput
 * @param latitudeInput
 * @param longitudeInput
 */
function enableGoogleAutoComplete( locationInput, latitudeInput, longitudeInput ){
    if( locationInput.length == 0 ) return;
    /** @class google.maps.places.Autocomplete */
    var autoComplete = new google.maps.places.Autocomplete(
        /** @type {HTMLInputElement} */( document.getElementById( locationInput.attr('id') ) ),
        { types: ['geocode'] }
    );
    geoLocate( autoComplete );
    /** @class google.maps.event.addListener */
    google.maps.event.addListener(autoComplete, 'place_changed', function() {
        /** @class autoComplete.getPlace */
        var lat = autoComplete.getPlace()['geometry']['location'];
        /** @class lat.lat */
        lat = lat.lat();
        var lon = autoComplete.getPlace()['geometry']['location'];
        /** @class lon.lng */
        lon = lon.lng();
        latitudeInput.val( lat );
        longitudeInput.val( lon );
    });
}