/** model for main header */
deepmikoto.MainHeaderModel = Backbone.Model.extend({
    defaults: {
        currentPage: 'home'
    }
});

/** view and actions for main header view */
deepmikoto.MainHeaderView = Marionette.ItemView.extend({
    className: 'main-header',
    model: new deepmikoto.MainHeaderModel,
    ui: {
        active: '.active',
        home: '#home'
    },
    initialize: function(){
        this.listenTo(deepmikoto.app.headerChannel.vent, 'change:page', this.updateCurrentPage);
    },
    getTemplate: function ()
    {
        return _.template(deepmikoto.templates.mainHeader);
    },
    updateCurrentPage: function (page)
    {
        this.model.set({ currentPage: page });
        this.ui.active.removeClass('active');
        this.ui[page].addClass('active');
    }
});