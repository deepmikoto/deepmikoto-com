

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
    commandButtonsBehavior( deepmikoto.buttons.cacheClear,    deepmikoto.ajaxUrls.CACHE_CLEAR_URL );
    commandButtonsBehavior( deepmikoto.buttons.assetsInstall, deepmikoto.ajaxUrls.ASSETS_INSTALL_URL );
    commandButtonsBehavior( deepmikoto.buttons.asseticDump,   deepmikoto.ajaxUrls.ASSETIC_DUMP_URL );
    enableGoogleAutoComplete( $('.post-location'), $('.post-latitude'), $('.post-longitude') );
}, jQuery );


