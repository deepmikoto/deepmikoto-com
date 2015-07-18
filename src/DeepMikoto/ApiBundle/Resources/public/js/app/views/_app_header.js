
/** view and actions for main header view */
deepmikoto.AppHeaderView = Marionette.ItemView.extend({
    className: 'app-header',
    model: new deepmikoto.AppHeaderModel,
    ui: {
        active : '.active',
        home   : '#home'
    },
    initialize: function(){
        this.listenTo(deepmikoto.app.routerChannel.vent, 'change:page', this.updateCurrentPage);
    },
    getTemplate: function ()
    {
        /** @namespace deepmikoto.templates.appHeader */
        return _.template(deepmikoto.templates.appHeader);
    },
    updateCurrentPage: function (page)
    {
        this.model.set({ currentPage: page });
        this.ui.active.removeClass('active');
        this.ui[page].addClass('active');
    }
});