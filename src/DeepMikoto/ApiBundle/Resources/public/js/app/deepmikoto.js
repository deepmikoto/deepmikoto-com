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
    header      : '#header',
    body        : '#body',
    sidebar     : '#sidebar',
    landingPage : '#landing'
});

/** we initialize app functions */
deepmikoto.app.addInitializer(function()
{
    deepmikoto.app.generalFunctions = new deepmikoto.GeneralFunctions;
    deepmikoto.app.appFunctions     = new deepmikoto.AppFunctions;
    deepmikoto.app.radio            = new deepmikoto.RadioFunctions;
    deepmikoto.app.utilityFunctions = new deepmikoto.UtilityFunctions;
});

/**
 * Our app data variable
 */
deepmikoto.app.addInitializer(function()
{
    deepmikoto.app.data = {};
});

/**
 * Now we launch the app
 */
$( window ).on( 'load', function()
{
    deepmikoto.app.start();
});
