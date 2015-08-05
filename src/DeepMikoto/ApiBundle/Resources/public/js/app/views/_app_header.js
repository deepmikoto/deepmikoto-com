
/** view and actions for main header view */
deepmikoto.AppHeaderView = Marionette.ItemView.extend({
    className: 'app-header',
    model: new deepmikoto.AppHeaderModel,
    ui: {
        home        : '#home',
        photography : '#photography',
        coding      : '#coding',
        gaming      : '#gaming',
        collapsed   : '#collapsed',
        toggleMenu  : '#toggle-collapsed'
    },
    events: {
        'click @ui.toggleMenu': 'toggleCollapsedMenu'
    },
    initialize: function(){
        this.listenTo( deepmikoto.app.routerChannel.vent, 'change:page', this.updateCurrentPage );
    },
    getTemplate: function ()
    {
        /** @namespace deepmikoto.templates.appHeader */
        return _.template( deepmikoto.templates.appHeader );
    },
    updateCurrentPage: function (page)
    {
        this.model.set({ currentPage: page });
        this.ui.collapsed.removeAttr( 'style' );
        $( this.el ).find( '.active').removeClass( 'active' );
        $( window ).scrollTop( 0, 0 );
        this.ui[ page ].blur().addClass( 'active' );
    },
    toggleCollapsedMenu: function()
    {
        this.ui.toggleMenu.blur();
        if ( this.ui.collapsed.is(':visible') ){
            this.ui.collapsed.removeAttr( 'style' );
        } else {
            this.ui.collapsed.css( 'display', 'block' );
        }
    }
});