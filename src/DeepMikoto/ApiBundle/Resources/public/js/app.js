/*!
 * deepmikoto.com app start
 */

/** update initial progress bar and signal loading of js files */
document.getElementById( 'loader-bar' ).style.width = '60%';
document.getElementById( 'loader-subject' ).innerText = 'assets ( JavaScript )';

/** initialize app variable */
var deepmikoto = {};

/** define bootstrapped data */
var root = root || '/';
var psk = ( typeof psk != 'undefined' ? psk : '' );

/** define api routes */
deepmikoto.apiRoutes = {
    TEMPLATES_URL               : '_api/templates',
    HELP_PAGE_URL               : '_api/help',
    USER_INFO_URL               : '_api/user-info',
    SIDEBAR_COMPONENTS_URL      : '_api/sidebar-components',
    CODING_TIMELINE_URL         : '_api/coding-timeline',
    CODING_POST_URL             : '_api/coding-post',
    CODING_CATEGORIES_URL       : '_api/coding-categories',
    CODING_CATEGORY_TIMELINE_URL: '_api/coding-category-timeline',
    GAMING_TIMELINE_URL         : '_api/gaming-timeline',
    GAMING_POST_URL             : '_api/gaming-post',
    PHOTOGRAPHY_TIMELINE_URL    : '_api/photography-timeline',
    PHOTOGRAPHY_POST_URL        : '_api/photography-post',
    SEARCH_SUGGESTIONS_URL      : '_api/search-suggestions'
};

/** define app constants */
deepmikoto.appConstants = {
    FACEBOOK_APP_ID         : '789069417870836',
    PUSH_SERVER_PUBLIC_KEY  : psk,
    CODING_TIMELINE_LIMIT       : 20,
    GAMING_TIMELINE_LIMIT       : 10,
    PHOTOGRAPHY_TIMELINE_LIMIT  : 10
};

/** define the templates variable */
deepmikoto.templates = {};

deepmikoto.preLoadAssets = function ( assetsArray )
{
    var assets = [];
    for( var i = 0; i < assetsArray.length; i++ ){
        assets[ i ] = new Image();
        assets[ i ].src = assetsArray[ i ];
    }
};
deepmikoto.preLoadAssets([
    '/bundles/deepmikotoapi/images/night.jpg',
    '/bundles/deepmikotoapi/images/code.jpg',
    '/bundles/deepmikotoapi/images/wow.jpg',
    '/bundles/deepmikotoapi/images/cluj.jpg'
]);

deepmikoto.loadScript = function( src ){
    var fileref,
        type = src.substring(src.lastIndexOf('.')).replace('.','');
    if ( type=="js" ){

    } else if ( type=="css" ){
        fileref=document.createElement("link");
        fileref.setAttribute("rel", "stylesheet");
        fileref.setAttribute("type", "text/css");
        fileref.setAttribute("href", src);
    }
    if (typeof fileref!="undefined")
        document.getElementsByTagName("head")[0].appendChild( fileref );
};

/** message for users that open the console */
console.info( 'What are you looking for?! Just kidding, you can take a peek! :)');