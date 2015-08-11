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
    FETCH_SIDEBAR_PRIMARY_BLOCK_URL : '_api/sidebar-primary-block',
    FETCH_SIDEBAR_RELATED_BLOCK_URL : '_api/sidebar-related-block',
    FETCH_SIDEBAR_ADD_BLOCK_URL     : '_api/sidebar-add-block',
    FETCH_CODING_TIMELINE_URL       : '_api/coding-timeline',
    FETCH_GAMING_TIMELINE_URL       : '_api/gaming-timeline',
    FETCH_PHOTOGRAPHY_TIMELINE_URL  : '_api/photography-timeline',
    FETCH_PHOTOGRAPHY_POST_URL      : '_api/photography-post'
};

/** define the templates variable */
deepmikoto.templates = {};