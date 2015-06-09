/**
 * Created by MiKoRiza-OnE on 6/9/2015.
 */

/** initialize app variable */
var deepmikoto = { };

/** define the model that will hold our user */
deepmikoto.User = Backbone.Model.extend({
    isLoggedIn: function() {
        return (this.has('username'));
    },
    hasRole: function(role) {
        return (this.has('roles') && this.get('roles').indexOf(role) != -1);
    }
});

/** define the app router that will handle relations between app URL and actions */
deepmikoto.Router = Marionette.AppRouter.extend({
    routes: {
        '': 'homeAction',
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
    undefinedAction: function(){
        Backbone.history.navigate('', { trigger: true });
    },
    homeAction: function(){
        console.log('home');
    },
    loginAction: function(){
        if (deepmikoto.app.user.isLoggedIn()) {
            Backbone.history.navigate('', { trigger: true })
        } else {
            this.showLogin();
        }
    },
    logoutAction: function(){
        console.log('logout');
        $.ajax({
            context: this,
            type: 'GET',
            url: 'logout',
            dataType: 'json',
            success: function() {
                deepmikoto.app.user.clear();
                Backbone.history.navigate('', { trigger: true });
                console.log('logout');
            }
        });
    },
    showLogin: function(){

    }
});

/**
 * Our Marionette app
 */
deepmikoto.app = new Marionette.Application();

/**
 * The main regions of our app
 */
deepmikoto.app.addRegions({

});

/**
 * We bootstrap the app :
 *
 * 1) Instantiate the user
 */
deepmikoto.app.addInitializer(function() {
    deepmikoto.app.user = new deepmikoto.User(user);
});

/**
 * 2) Instantiate the collections from the bootstrapped data
 */
deepmikoto.app.addInitializer(function() {
    deepmikoto.app.data = {};
});

/**
 * 3) Launch the router and process the first route
 */
deepmikoto.app.addInitializer(function() {
    deepmikoto.app.router = new deepmikoto.Router();
    Backbone.history.start({ pushState: true, root: root });
});

/** we start the route filter */
deepmikoto.app.addInitializer(function() {
    NoHashTagsPlease(deepmikoto.app.router);
});

/**
 * Now we launch the app
 */
deepmikoto.app.start();