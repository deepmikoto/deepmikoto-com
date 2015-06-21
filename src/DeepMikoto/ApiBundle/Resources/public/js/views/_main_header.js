/** model for main header */
deepmikoto.MainHeaderModel = Backbone.Model.extend({
    defaults: {
        currentPage: 'home'
    }
});

/** view and actions for main header view */
deepmikoto.MainHeaderView = Marionette.ItemView.extend({
    template: '#main_header_tpl',
    className: 'main-header',
    model: new deepmikoto.MainHeaderModel,
    ui: {
        active: '.active',
        home: '#home'
    },
    initialize: function(){
        this.listenTo(deepmikoto.app.headerChannel.vent, 'change:page', this.updateCurrentPage);
    },
    updateCurrentPage: function (page)
    {
        var _this = this;
        this.ui.active.fadeOut(function(){
            _this.ui[page].fadeIn();
        });
    }
});