/**
 * Created by MiKoRiza-OnE on 7/15/2015.
 */

deepmikoto.RadioFunctions = Marionette.extend({
    constructor: function()
    {
        this.initializeRadioChannels();
    },
    initializeRadioChannels: function()
    {
        deepmikoto.app.globalChannel   = Backbone.Wreqr.radio.channel('global');
        deepmikoto.app.headerChannel   = Backbone.Wreqr.radio.channel('header');
        deepmikoto.app.securityChannel = Backbone.Wreqr.radio.channel('security');
    },
    broadcast: function(channel, message, data)
    {
        data = data || null;
        Backbone.Wreqr.radio.vent.trigger(channel, message, data);
    }

});