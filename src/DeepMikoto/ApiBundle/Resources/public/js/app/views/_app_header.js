
/** view and actions for main header view */
deepmikoto.AppHeaderView = Marionette.LayoutView.extend({
    className: 'app-header',
    model: new deepmikoto.AppHeaderModel,
    regions: {
        resultsArea: '#results-area'
    },
    ui: {
        home        : '#home',
        photography : '#photography',
        coding      : '#coding',
        gaming      : '#gaming',
        collapsed   : '#collapsed',
        toggleMenu  : '#toggle-collapsed',
        searchContainer : '#search-container',
        searchField     : '#search-field',
        searchToggle    : '#search-toggle'
    },
    events: {
        'click @ui.toggleMenu': 'toggleCollapsedMenu',
        'click @ui.searchContainer': 'preventClick',
        'click @ui.searchToggle': 'toggleSearchField'
    },
    initialize: function()
    {
        this.listenTo( deepmikoto.app.routerChannel.vent, 'change:page', this.updateCurrentPage );
    },
    getTemplate: function ()
    {
        /** @namespace deepmikoto.templates.appHeader */
        return _.template( deepmikoto.templates.appHeader );
    },
    onShow: function ()
    {
        this.showSearchToggle();
    },
    showSearchToggle: function ()
    {
        var _this = this;
        setTimeout(function (){
            _this.ui.searchContainer.removeClass( 'loading' );
        }, 1 );
    },
    toggleSearchField: function ()
    {
        if( !this.ui.searchContainer.hasClass( 'active' ) ){
            this.ui.searchContainer.addClass( 'active' );
        } else {
            this.hideSearchField();
        }
    },
    hideSearchField: function ()
    {
        this.ui.searchContainer.removeClass( 'active' );
        this.ui.searchField.val( '' );
        this.resultsArea.reset();
    },
    preventClick: function ( e )
    {
        e.preventDefault();
    },
    updateCurrentPage: function( page )
    {
        if( this.model.get( 'page' ) != page ){
            this.model.set({ currentPage: page });
            this.ui.collapsed.removeAttr( 'style' );
            this.$el.find( '.active' ).removeClass( 'active' );
            this.$el.attr( 'class', 'app-header ' + page );
            this.ui[ page ].blur().addClass( 'active' );
        }
        this.hideSearchField();
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