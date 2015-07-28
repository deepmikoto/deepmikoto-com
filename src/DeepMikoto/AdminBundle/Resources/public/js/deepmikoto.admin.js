/**
 * Created by MiKoRiza-OnE on 7/23/2015.
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

$(function() {
    var deepmikoto = {};

    deepmikoto.buttons = {
        cacheClear   : '#cache-clear',
        assetsInstall: '#assets-install',
        asseticDump  : '#assetic-dump'
    };

    deepmikoto.ajaxUrls = {
        CACHE_CLEAR_URL     : '/adminarea/command/cache-clear',
        ASSETS_INSTALL_URL  : '/adminarea/command/assets-install',
        ASSETIC_DUMP_URL    : '/adminarea/command/assetic-dump'
    };

    commandButtonsBehavior( deepmikoto.buttons.cacheClear, deepmikoto.ajaxUrls.CACHE_CLEAR_URL );
    commandButtonsBehavior( deepmikoto.buttons.assetsInstall, deepmikoto.ajaxUrls.ASSETS_INSTALL_URL );
    commandButtonsBehavior( deepmikoto.buttons.asseticDump, deepmikoto.ajaxUrls.ASSETIC_DUMP_URL );

}, jQuery );


