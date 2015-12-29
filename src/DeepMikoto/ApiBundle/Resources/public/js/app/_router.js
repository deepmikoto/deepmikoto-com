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
            url: deepmikoto.apiRoutes.FETCH_CODING_TIMELINE_URL,
            dataType: 'json',
            success: function( response )
            {
                var codingTimeline = new deepmikoto.CodingTimelineView({
                    collection: new deepmikoto.CodingTimelineCollection( response[ 'payload' ] )
                });
                deepmikoto.app.body.show( codingTimeline );
                this.scrollPageToTop();
            }
        });
    },
    showGamingTimeline: function ()
    {
        $.ajax({
            context: this,
            type: 'GET',
            url: deepmikoto.apiRoutes.FETCH_GAMING_TIMELINE_URL,
            dataType: 'json',
            success: function( response )
            {
                var gamingTimeline = new deepmikoto.GamingTimelineView({
                    collection: new deepmikoto.GamingTimelineCollection( response[ 'payload' ] )
                });
                deepmikoto.app.body.show( gamingTimeline );
                this.scrollPageToTop();
            }
        });
    },
    showPhotographyTimeline: function()
    {
        $.ajax({
            context: this,
            type: 'GET',
            url: deepmikoto.apiRoutes.FETCH_PHOTOGRAPHY_TIMELINE_URL,
            dataType: 'json',
            success: function( response )
            {
                var photographyTimeline = new deepmikoto.PhotographyTimelineView({
                    collection: new deepmikoto.PhotographyTimelineCollection( response[ 'payload' ] )
                });
                deepmikoto.app.body.show( photographyTimeline );
                this.scrollPageToTop();
            }
        });
    },
    showPhotographyPost: function( id, slug )
    {
        $.ajax({
            context: this,
            type: 'GET',
            url: deepmikoto.apiRoutes.FETCH_PHOTOGRAPHY_POST_URL,
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
                deepmikoto.app.body.show( photographyPost );
                this.scrollPageToTop();
            }
        });
    },
    showCodingPost: function( id, slug )
    {
        $.ajax({
            context: this,
            type: 'GET',
            url: deepmikoto.apiRoutes.FETCH_CODING_POST_URL,
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
                deepmikoto.app.body.show( codingPost );
                this.scrollPageToTop();
            }
        });
    },
    showGamingPost: function( id, slug )
    {
        $.ajax({
            context: this,
            type: 'GET',
            url: deepmikoto.apiRoutes.FETCH_GAMING_POST_URL,
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
                deepmikoto.app.body.show( gamingPost );
                this.scrollPageToTop();
            }
        });
    }
});
