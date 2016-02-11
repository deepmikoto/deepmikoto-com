/**
 * Created by MiKoRiza-OnE on 6/9/2015.
 */

/**
 * Our Marionette app
 */
deepmikoto.app = new Marionette.Application();

/**
 * The main regions of our app
 */
deepmikoto.app.addRegions({
    header        : '#header',
    body          : '#body',
    sidebar       : '#sidebar',
    landingPage   : '#landing'
});

/** we initialize app functions */
deepmikoto.app.addInitializer(function()
{
    deepmikoto.app.generalFunctions = new deepmikoto.GeneralFunctions;
    deepmikoto.app.appFunctions     = new deepmikoto.AppFunctions;
    deepmikoto.app.radio            = new deepmikoto.RadioFunctions;
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
$( function() {
    deepmikoto.app.start();
});
