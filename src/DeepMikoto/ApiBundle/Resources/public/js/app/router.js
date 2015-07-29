/** define the app router that will handle relations between app URL and actions */
deepmikoto.Router = Marionette.AppRouter.extend({
    routes: {
        '': 'homeAction',
        'photography': 'photographyAction',
        'coding': 'codingAction',
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
        Backbone.history.navigate('', { trigger: true });
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
    },
    codingAction: function ()
    {
        this.updateAwareness( 'coding' );
        this.updatePageTitle( 'Coding' );
    },
    gamingAction: function ()
    {
        this.updateAwareness( 'gaming' );
        this.updatePageTitle( 'Gaming' );
    },
    loginAction: function()
    {
        if (deepmikoto.app.user.isLoggedIn()) {
            Backbone.history.navigate('', { trigger: true })
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
                Backbone.history.navigate('', { trigger: true });
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
    }
});
