/** define the app router that will handle relations between app URL and actions */
deepmikoto.Router = Marionette.AppRouter.extend({
    routes: {
        '': 'homeAction',
        'photography': 'photographyAction',
        'photography-post/:id--:slug': 'photographyPostAction',
        'coding': 'codingAction',
        'coding-post/:id--:slug': 'codingPostAction',
        'gaming': 'gamingAction',
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
            }
        });
    }
});
