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
        this.updateMainHeader( 'home' );
    },
    photographyAction: function ()
    {
        this.updateMainHeader( 'photography' );
    },
    codingAction: function ()
    {
        this.updateMainHeader( 'coding' );
    },
    gamingAction: function ()
    {
        this.updateMainHeader( 'gaming' );
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
    updateMainHeader: function(currentPage)
    {
        deepmikoto.app.radio.broadcast('router', 'change:page', currentPage);
    }
});
