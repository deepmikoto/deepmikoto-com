
/** view and actions for main header view */
deepmikoto.HeaderView = Marionette.LayoutView.extend({
    className: 'app-header home',
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
        'click @ui.searchToggle': 'toggleSearchField',
        'keyup @ui.searchField': 'getSuggestions',
        'click @ui.searchField': 'getSuggestions'
    },
    initialize: function()
    {
        this.bodyDOM = $( 'body' );
        this.listenTo( deepmikoto.app.routerChannel.vent, 'change:page', this.updateCurrentPage );
        this.listenTo( deepmikoto.app.windowChannel.vent, 'window:scroll', this.indicateScrolling );
        this.listenTo( deepmikoto.app.windowChannel.vent, 'window:mouseup', this.hideSuggestions );
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
    indicateScrolling: function ()
    {
        var _this = this;
        this.bodyDOM.addClass( 'scrolling' );
        this.scrollingTimeount != undefined ? clearTimeout( this.scrollingTimeount ) : null;
        this.scrollingTimeount = setTimeout( function (){
            _this.bodyDOM.removeClass( 'scrolling' );
        }, 400 );
    },
    showSearchToggle: function ()
    {
        setTimeout( $.proxy( function (){
            this.ui.searchContainer.removeClass( 'loading' );
        }, this ), 50 );
    },
    toggleSearchField: function ()
    {
        if( !this.ui.searchContainer.hasClass( 'active' ) ){
            this.ui.searchContainer.addClass( 'active' );
            this.ui.searchField.focus();
        } else {
            this.hideSearchField();
            this.ui.searchField.val('');
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
            this.ui[ page ] ? this.ui[ page ].blur().addClass( 'active' ) : null;
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
    },
    getSuggestions: function ()
    {
        var term = this.ui.searchField.val(),
            _this = this;
        this.searchTimeount != undefined ? clearTimeout( this.searchTimeount ) : null;
        this.searchAjax != undefined ? this.searchAjax.abort() : null;
        this.hideSuggestions();
        if ( term.length >= 2 ) {
            this.searchTimeount = setTimeout( function (){
                _this.searchAjax = $.ajax({
                    method: 'GET',
                    url: deepmikoto.apiRoutes.SEARCH_SUGGESTIONS_URL,
                    data: {
                        term: term
                    },
                    dataType: 'json',
                    success: function ( response )
                    {
                        _this.resultsArea.show(
                            new deepmikoto.SearchSuggestionsView({
                                collection: new deepmikoto.SearchSuggestionCollection( response['payload'] )
                            })
                        )
                    },
                    error: function ()
                    {
                        _this.hideSuggestions();
                    }
                });
            }, 200 );
        } else {
            _this.hideSuggestions();
        }
    },
    hideSuggestions: function ()
    {
        this.resultsArea.reset();
    }
});