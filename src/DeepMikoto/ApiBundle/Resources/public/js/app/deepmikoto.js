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

/**
 * Our Marionette app
 */
deepmikoto.app = new Marionette.Application();

/**
 * The main regions of our app
 */
deepmikoto.app.addRegions({
    mainHeader: '#main-header',
    mainContent: '#main-content'
});

/** we initialize app radio channels */
deepmikoto.app.addInitializer(function()
{
    deepmikoto.app.globalChannel = Backbone.Wreqr.radio.channel('global');
    deepmikoto.app.headerChannel = Backbone.Wreqr.radio.channel('header');
});

/** we initialize app functions */
deepmikoto.app.addInitializer(function()
{
    deepmikoto.app.generalFunctions = new deepmikoto.GeneralFunctions();
    deepmikoto.app.appFunctions = new deepmikoto.AppFunctions();
});

/**
 * We bootstrap the app :
 *
 * Instantiate the user
 */
deepmikoto.app.addInitializer(function()
{
    deepmikoto.app.user = new deepmikoto.User(user);
});

/**
 * Instantiate the collections from the bootstrapped data
 */
deepmikoto.app.addInitializer(function()
{
    deepmikoto.app.data = {};
});

/**
 * Now we launch the app
 */
deepmikoto.app.start();