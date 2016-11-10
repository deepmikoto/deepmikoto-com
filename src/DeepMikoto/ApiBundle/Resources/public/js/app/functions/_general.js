/**
 * Created by MiKoRiza-OnE on 7/9/2015.
 */

deepmikoto.GeneralFunctions = Marionette.extend({
    constructor: function ()
    {
        this.enableAjaxPrefilter();
        this.noHashTagsPlease();
        this.enableGoogleAnalytics();
        this.enableFacebookApp();
        this.initServiceWorker();
    },
    enableGoogleAnalytics: function()
    {
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)};i[r].l=new Date();a=s.createElement(o);
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        /** @namespace ga */
        ga('create', 'UA-56243816-2', 'auto');
    },
    sendGooglePageView: function ( uri )
    {
        typeof ga == 'function' ? ga('send', 'pageview', uri ) : null;
    },
    /**
     * Here we provide support for symfony's app_dev in ajax calls
     */
    enableAjaxPrefilter: function()
    {
        $.ajaxPrefilter(function(options)
        {
            options.url = root + options.url;
        });
    },
    /**
     *  We define a route filter that handles all application links and passes it
     *  through our router, this is done to eliminate the use of "#/" in our links and URL's
     */
    noHashTagsPlease: function()
    {
        /**
         * Use absolute URLs to navigate to anything not in your Router.
         * Note: this version works with IE. Backbone.history.navigate will automatically route the IE user to the appropriate hash URL
         * Use delegation to avoid initial DOM selection and allow all matching elements to bubble
         */
        $(document).delegate("a", "click", function( e )
        {
            /** Get the anchor href and protocol */
            var href = $(this).attr("href");
            var protocol = this.protocol + "//";
            if (href != undefined)
            {
                href = href.replace(root, '/');
                /**
                 * Ensure the protocol is not part of URL, meaning its relative.
                 * Stop the event bubbling to ensure the link will not cause a page refresh.
                 */
                if (href.slice(protocol.length) !== protocol && protocol !== 'javascript://' && href.substring(0, 1) !== '#' &&
                    href.substring(0, 7) !== 'http://' && href.substring(0, 8) !== 'https://')
                {
                    e.preventDefault();

                    deepmikoto.app.router.navigate(href, { trigger: true });
                }
            }
        });
    },
    /**
     * Include facebook js app
     */
    enableFacebookApp: function()
    {
        window.fbAsyncInit = function()
        {
            /** @namespace FB */
            FB.init({
                appId      : deepmikoto.appConstants.FACEBOOK_APP_ID,
                xfbml      : true,
                version    : 'v2.4'
            });
        };
        (function( d, s, id ){
            var js, fjs = d.getElementsByTagName(s)[0];
            if ( d.getElementById( id ) ) {return;}
            js = d.createElement( s ); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore( js, fjs );
        }( document, 'script', 'facebook-jssdk' ) );
    },
    /**
     * we activate service worker for desktop push notifications
     */
    initServiceWorker: function()
    {
        if ( 'serviceWorker' in navigator ) {
            try {
                /** @namespace navigator.serviceWorker */
                navigator.serviceWorker.register( '/_sw.js' ).then( function( registration ) {
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);
                });
            } catch( err ) {
                // registration failed :(
                console.log('ServiceWorker registration failed: ', err);
            }
        }
    }
});