/**
 * Created by MiKoRiza-OnE on 8/11/2015.
 */

deepmikoto.FootNoteView = Marionette.ItemView.extend({
    tagName: 'div',
    className: 'footnote',
    model: new deepmikoto.FootNoteModel,
    ui: {
        dismiss: '#dismiss'
    },
    events: {
        'click @ui.dismiss': 'dismissFootNote'
    },
    getTemplate: function()
    {
        /** @namespace deepmikoto.templates.footNote */
        return _.template( deepmikoto.templates.footNote );
    },
    dismissFootNote: function()
    {
        Cookies.set( this.model.get( 'type' ) + '-notice', true, { expires: 365 } );
        this.$el.animate({
            opacity: 0
        }, 200, $.proxy(function (){
            this.destroy();
        }, this ) );
    }
});