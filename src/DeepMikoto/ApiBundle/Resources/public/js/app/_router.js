/** define the app router that will handle relations between app URL and actions */
deepmikoto.Router = Marionette.AppRouter.extend({
    routes:
    {
        '': 'homeAction',
        'photography': 'photographyAction',
        'photography/:id--:slug': 'photographyPostAction',
        'coding': 'codingAction',
        'coding/:id--:slug': 'codingPostAction',
        'gaming': 'gamingAction',
        'gaming/:id--:slug': 'gamingPostAction',
        'help': 'helpAction',
        'login': 'loginAction',
        'logout': 'logoutAction',
        ':placeholder': 'undefinedAction',
        ':placeholder/:placeholder': 'undefinedAction',
        ':placeholder/:placeholder/:placeholder': 'undefinedAction',
        ':placeholder/:placeholder/:placeholder/:placeholder': 'undefinedAction',
        ':placeholder/:placeholder/:placeholder/:placeholder/:placeholder': 'undefinedAction',
        ':placeholder/:placeholder/:placeholder/:placeholder/:placeholder/:placeholder': 'undefinedAction',
        ':placeholder/:placeholder/:placeholder/:placeholder/:placeholder/:placeholder/:placeholder': 'undefinedAction',
        ':placeholder/:placeholder/:placeholder/:placeholder/:placeholder/:placeholder/:placeholder/:placeholder': 'undefinedAction'
    },
    undefinedAction: function()
    {
        Backbone.history.navigate( '', { trigger: true } );
    },
    scrollPageToTop: function ()
    {
        $( window ).scrollTop( 0, 0 );
    },
    homeAction: function()
    {
        this.updateAwareness( 'home' );
        this.updatePageTitle( 'deepmikoto' );
        this.showLandingPage();
    },
    helpAction: function ()
    {
        this.updateAwareness( 'help' );
        this.updatePageTitle( 'Help' );
        this.showHelpPage();
    },
    photographyAction: function ()
    {
        this.updateAwareness( 'photography' );
        this.updatePageTitle( 'Photography' );
        this.showPhotographyTimeline();
    },
    photographyPostAction: function ( id, slug )
    {
        this.updateAwareness( 'photography' );
        this.showPhotographyPost( id, slug );
    },
    codingAction: function ()
    {
        this.updateAwareness( 'coding' );
        this.updatePageTitle( 'Coding' );
        this.showCodingTimeline();
    },
    codingPostAction: function ( id, slug )
    {
        this.updateAwareness( 'coding' );
        this.showCodingPost( id, slug );
    },
    gamingAction: function ()
    {
        this.updateAwareness( 'gaming' );
        this.updatePageTitle( 'Gaming' );
        this.showGamingTimeline();
    },
    gamingPostAction: function ( id, slug )
    {
        this.updateAwareness( 'gaming' );
        this.showGamingPost( id, slug );
    },
    loginAction: function()
    {
        if ( deepmikoto.app.user.isLoggedIn() ){
            Backbone.history.navigate( '', { trigger: true } );
        } else {
            this.showLogin();
        }
    },
    logoutAction: function()
    {
        $.ajax({
            context: this,
            type: 'GET',
            url: 'logout',
            dataType: 'json',
            success: function() {
                deepmikoto.app.user.clear();
                Backbone.history.navigate( '', { trigger: true } );
            }
        });
    },
    showLandingPage: function ()
    {
        deepmikoto.app.appBody.reset();
        deepmikoto.app.landingPage.show( new deepmikoto.LandingPage() );
    },
    showHelpPage: function ()
    {
        $.ajax({
            context: this,
            type: 'GET',
            url: deepmikoto.apiRoutes.HELP_PAGE_URL,
            dataType: 'json',
            success: function( response )
            {
                var helpPage = new deepmikoto.HelpPageView({
                    model: new deepmikoto.HelpPageModel( response )
                });
                deepmikoto.app.appBody.show( helpPage );
                this.scrollPageToTop();
            },
            error: function ()
            {
                this.homeAction();
            }
        });
    },
    showLogin: function()
    {

    },
    updateAwareness: function( currentPage )
    {
        deepmikoto.app.radio.broadcast( 'router', 'change:page', currentPage );
    },
    updatePageTitle: function( title )
    {
        deepmikoto.app.appFunctions.setPageTitle( title );
    },
    showCodingTimeline: function ()
    {
        $.ajax({
            context: this,
            type: 'GET',
            url: deepmikoto.apiRoutes.CODING_TIMELINE_URL,
            dataType: 'json',
            success: function( response )
            {
                var codingTimeline = new deepmikoto.CodingTimelineView({
                    collection: new deepmikoto.CodingTimelineCollection( response[ 'payload' ] )
                });
                deepmikoto.app.appBody.show( codingTimeline );
                this.scrollPageToTop();
            },
            error: function ()
            {
                this.homeAction();
            }
        });
    },
    showGamingTimeline: function ()
    {
        $.ajax({
            context: this,
            type: 'GET',
            url: deepmikoto.apiRoutes.GAMING_TIMELINE_URL,
            dataType: 'json',
            success: function( response )
            {
                var gamingTimeline = new deepmikoto.GamingTimelineView({
                    collection: new deepmikoto.GamingTimelineCollection( response[ 'payload' ] )
                });
                deepmikoto.app.appBody.show( gamingTimeline );
                this.scrollPageToTop();
            },
            error: function ()
            {
                this.homeAction();
            }
        });
    },
    showPhotographyTimeline: function()
    {
        $.ajax({
            context: this,
            type: 'GET',
            url: deepmikoto.apiRoutes.PHOTOGRAPHY_TIMELINE_URL,
            dataType: 'json',
            success: function( response )
            {
                var photographyTimeline = new deepmikoto.PhotographyTimelineView({
                    collection: new deepmikoto.PhotographyTimelineCollection( response[ 'payload' ] )
                });
                deepmikoto.app.appBody.show( photographyTimeline );
                this.scrollPageToTop();
            },
            error: function ()
            {
                this.homeAction();
            }
        });
    },
    showPhotographyPost: function( id, slug )
    {
        $.ajax({
            context: this,
            type: 'GET',
            url: deepmikoto.apiRoutes.PHOTOGRAPHY_POST_URL,
            data: {
                id: id,
                slug: slug
            },
            dataType: 'json',
            success: function( response )
            {
                this.updatePageTitle( response[ 'payload' ][ 'title' ] );
                var photographyPost = new deepmikoto.PhotographyPost({
                    model: new deepmikoto.PhotographyPostModel( response[ 'payload'] )
                });
                deepmikoto.app.appBody.show( photographyPost );
                this.scrollPageToTop();
            },
            error: function ()
            {
                this.homeAction();
            }
        });
    },
    showCodingPost: function( id, slug )
    {
        $.ajax({
            context: this,
            type: 'GET',
            url: deepmikoto.apiRoutes.CODING_POST_URL,
            data: {
                id: id,
                slug: slug
            },
            dataType: 'json',
            success: function( response )
            {
                this.updatePageTitle( response[ 'payload' ][ 'title' ] );
                var codingPost = new deepmikoto.CodingPost({
                    model: new deepmikoto.CodingPostModel( response[ 'payload'] )
                });
                deepmikoto.app.appBody.show( codingPost );
                this.scrollPageToTop();
            },
            error: function ()
            {
                this.homeAction();
            }
        });
    },
    showGamingPost: function( id, slug )
    {
        $.ajax({
            context: this,
            type: 'GET',
            url: deepmikoto.apiRoutes.GAMING_POST_URL,
            data: {
                id: id,
                slug: slug
            },
            dataType: 'json',
            success: function( response )
            {
                this.updatePageTitle( response[ 'payload' ][ 'title' ] );
                var gamingPost = new deepmikoto.GamingPost({
                    model: new deepmikoto.GamingPostModel( response[ 'payload'] )
                });
                deepmikoto.app.appBody.show( gamingPost );
                this.scrollPageToTop();
            },
            error: function ()
            {
                this.homeAction();
            }
        });
    }
});
