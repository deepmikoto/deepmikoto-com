/*!
 * deepmikoto.com app start
 */

/** initialize app variable */
var deepmikoto = {};

/** define bootstrapped data */
var root = root || '/';

/** define api routes */
deepmikoto.apiRoutes = {
    FETCH_TEMPLATES_URL             : '_api/templates',
    FETCH_USER_INFO_URL             : '_api/user-info',
    FETCH_SIDEBAR_COMPONENTS_URL    : '_api/sidebar-components',
    FETCH_CODING_TIMELINE_URL       : '_api/coding-timeline',
    FETCH_CODING_POST_URL           : '_api/coding-post',
    FETCH_GAMING_TIMELINE_URL       : '_api/gaming-timeline',
    FETCH_GAMING_POST_URL           : '_api/gaming-post',
    FETCH_PHOTOGRAPHY_TIMELINE_URL  : '_api/photography-timeline',
    FETCH_PHOTOGRAPHY_POST_URL      : '_api/photography-post'
};

/** define app constants */
deepmikoto.appConstants = {
    FACEBOOK_APP_ID     : '789069417870836'
};

/** define the templates variable */
deepmikoto.templates = {};