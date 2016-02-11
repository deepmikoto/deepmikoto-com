/**
 * Created by MiKoRiza-OnE on 7/18/2015.
 */

deepmikoto.SidebarView = Marionette.LayoutView.extend({
    className: 'sidebar home',
    model: new deepmikoto.SidebarModel(),
    ui: {
        primary : '#primary',
        related : '#related',
        adds    : '#adds'
    },
    getTemplate: function()
    {
        /** @namespace deepmikoto.templates */
        return _.template( deepmikoto.templates.sidebar );
    },
    initialize: function()
    {
        this.listenTo( deepmikoto.app.routerChannel.vent, 'change:page', this.adaptContentToPage );
    },
    adaptContentToPage: function( page )
    {
        if( this.model.get( 'context' ) != page ){
            this.model.set({ context: page });
            this.$el.attr( 'class', 'sidebar ' + page );
            this.renderSidebarComponents( page );
        }
    },
    renderSidebarComponents: function ( page )
    {
        if( page != 'home' ){
            $.ajax({
                context: this,
                type: 'GET',
                url: deepmikoto.apiRoutes.SIDEBAR_COMPONENTS_URL,
                data: {
                    page: page
                },
                dataType: 'json',
                success: function( response )
                {
                    this.ui.primary.html( response[ 'payload' ][ 'primaryBlock' ] );
                    this.ui.related.html( response[ 'payload' ][ 'relatedBlock' ] );
                    this.ui.adds.html( response[ 'payload' ][ 'adBlock' ] );
                }
            });
        }
    }
});