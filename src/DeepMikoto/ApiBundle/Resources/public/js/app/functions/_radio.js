/**
 * Created by MiKoRiza-OnE on 7/15/2015.
 */

deepmikoto.RadioFunctions = Marionette.extend({
    constructor: function()
    {
        this.initializeRadioChannels();
        this.broadcastBehaviours();
    },
    initializeRadioChannels: function()
    {
        deepmikoto.app.globalChannel   = Backbone.Wreqr.radio.channel('global');
        deepmikoto.app.windowChannel   = Backbone.Wreqr.radio.channel('window');
        deepmikoto.app.routerChannel   = Backbone.Wreqr.radio.channel('router');
        deepmikoto.app.securityChannel = Backbone.Wreqr.radio.channel('security');
    },
    broadcast: function(channel, message, data)
    {
        data = data || null;
        Backbone.Wreqr.radio.vent.trigger(channel, message, data);
    },
    broadcastBehaviours: function ()
    {
        var $window = $( window );
        $window.on( 'scroll', $.proxy( function(){
            this.broadcast( 'window', 'window:scroll' );
        }, this ));
        $window.on( 'resize', $.proxy(function (){
            this.broadcast( 'window', 'window:resize' );
        }, this ));
        $window.on( 'click', $.proxy(function () {
            this.broadcast( 'window', 'window:click' );
        }, this ));
        $window.on( 'mouseup', $.proxy(function () {
            this.broadcast( 'window', 'window:mouseup' );
        }, this ));
        this.watchForMouseWheelMovement();
    },
    watchForMouseWheelMovement: function()
    {
        function detectMouseWheelDirection( e )
        {
            var delta = 0;
            if ( !e ) e = window.event;
            if ( e.wheelDelta ) {
                delta = e.wheelDelta / 60;
            } else if ( e.detail ) {
                delta = -e.detail / 2;
            }
            delta = delta > 0 ? 'up' : 'down';

            return delta;
        }
        document.onmousewheel = $.proxy( function( e ){
            var scroll_direction = detectMouseWheelDirection( e );
            this.broadcast( 'window', 'window:mousewheel', scroll_direction );
        }, this );
        if( window.addEventListener ){
            document.addEventListener( 'DOMMouseScroll', $.proxy( function( e ){
                var scroll_direction = detectMouseWheelDirection( e );
                this.broadcast( 'window', 'window:mousewheel', scroll_direction );
            }, this ), false );
        }
    }
});