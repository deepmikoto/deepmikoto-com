/**
 * Created by MiKoRiza-OnE on 6/9/2015.
 */

/**
 * here we provide support for symfony app_dev in ajax calls
 */
$.ajaxPrefilter(function(options) {
    if(root === undefined) var root = '';
    options.url = root + options.url;
});


/**
 *  we define a route filter that handles all application links and passes it
 *  through out router, this is done to eliminate the use of "#/" in our links and URL's
 */
deepmikoto.NoHashTagsPlease = function(router){
    /**
     * Use absolute URLs to navigate to anything not in your Router.
     * Note: this version works with IE. Backbone.history.navigate will automatically route the IE user to the appropriate hash URL
     * Use delegation to avoid initial DOM selection and allow all matching elements to bubble
     */
    $(document).delegate("a", "click", function(evt) {
        /** Get the anchor href and protocol */
        var href = $(this).attr("href").replace('/app_dev.php', '');
        if (href != undefined){
            var protocol = this.protocol + "//";
            /**
             * Ensure the protocol is not part of URL, meaning its relative.
             * Stop the event bubbling to ensure the link will not cause a page refresh.
             */
            if (href.slice(protocol.length) !== protocol && protocol !== 'javascript://' && href.substring(0, 1) !== '#' &&
                href.substring(0, 7) !== 'http://' && href.substring(0, 8) !== 'https://')
            {
                evt.preventDefault();

                router.navigate(href, { trigger: true });
            }
        }
    });
};