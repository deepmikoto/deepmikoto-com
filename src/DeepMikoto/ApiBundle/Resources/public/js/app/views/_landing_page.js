/**
 * Created by MiKoRiza-OnE on 2/11/2016.
 */

deepmikoto.LandingPage = Marionette.ItemView.extend({
    className: 'landing-page',
    initialize: function()
    {
        this.listenTo( deepmikoto.app.routerChannel.vent, 'change:page', this.destroy );
    },
    getTemplate: function ()
    {
        return _.template( deepmikoto.templates.landingPage );
    }
});