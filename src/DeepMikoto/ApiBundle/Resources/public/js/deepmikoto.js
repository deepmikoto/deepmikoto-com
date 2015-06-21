/**
 * Created by MiKoRiza-OnE on 6/9/2015.
 */

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
        this.showOrUpdateMainHeader('home');
    },
    loginAction: function(){
        if (deepmikoto.app.user.isLoggedIn()) {
            Backbone.history.navigate('', { trigger: true })
        } else {
            this.showLogin();
        }
    },
    logoutAction: function(){
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
    showLogin: function(){

    },
    showOrUpdateMainHeader: function(currentPage){
        if(!deepmikoto.app.mainHeader.hasView()){
            var mainHeaderView = new deepmikoto.MainHeaderView({
                model: new deepmikoto.MainHeaderModel({
                    currentPage: currentPage
                })
            });
            deepmikoto.app.mainHeader.show(mainHeaderView);
        }
        Backbone.Wreqr.radio.vent.trigger('header', 'change:page', currentPage);
    }
});

/**
 * Our Marionette app
 */
deepmikoto.app = new Marionette.Application();

/** we initialize app functions */
deepmikoto.app.addInitializer(function() {
    deepmikoto.app.generalFunctions = new deepmikoto.GeneralFunctions();
    deepmikoto.app.generalFunctions.initializeCoreFunctions();
    deepmikoto.app.headerChannel = Backbone.Wreqr.radio.channel('header');
});

/**
 * The main regions of our app
 */
deepmikoto.app.addRegions({
    mainHeader: '#main-header',
    mainContent: '#main-content'
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

/**
 * Now we launch the app
 */
deepmikoto.app.start();