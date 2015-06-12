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
    initialize: function(){
        this.listenTo(this.model, 'change', this.render);
    }
});