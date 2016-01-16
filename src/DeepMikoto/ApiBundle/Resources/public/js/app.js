/*!
 * deepmikoto.com app start
 */

/** update initial progress bar and signal loading of js files */
document.getElementById( 'loader-bar' ).style.width = '40%';
document.getElementById( 'loader-subject' ).innerText = 'assets ( JavaScript )';

/** initialize app variable */
var deepmikoto = {};

/** define bootstrapped data */
var root = root || '/';

/** define api routes */
deepmikoto.apiRoutes = {
    TEMPLATES_URL             : '_api/templates',
    USER_INFO_URL             : '_api/user-info',
    SIDEBAR_COMPONENTS_URL    : '_api/sidebar-components',
    CODING_TIMELINE_URL       : '_api/coding-timeline',
    CODING_POST_URL           : '_api/coding-post',
    GAMING_TIMELINE_URL       : '_api/gaming-timeline',
    GAMING_POST_URL           : '_api/gaming-post',
    PHOTOGRAPHY_TIMELINE_URL  : '_api/photography-timeline',
    PHOTOGRAPHY_POST_URL      : '_api/photography-post'
};

/** define app constants */
deepmikoto.appConstants = {
    FACEBOOK_APP_ID     : '789069417870836'
};

/** define the templates variable */
deepmikoto.templates = {};

/** message for users that open the console */
console.info( 'What are you looking for?! Just kidding, you can take a peek! :)');