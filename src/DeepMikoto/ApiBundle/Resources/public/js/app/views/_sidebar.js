/**
 * Created by MiKoRiza-OnE on 7/18/2015.
 */

deepmikoto.SidebarView = Marionette.LayoutView.extend({
    className: 'sidebar',
    model: new deepmikoto.SidebarModel(),
    ui: {
        primary : '#primary',
        related : '#related',
        adds    : '#adds'
    },
    getTemplate: function()
    {
        /** @namespace deepmikoto.templates.sidebar */
        return _.template(deepmikoto.templates.sidebar);
    },
    initialize: function()
    {
        this.listenTo(deepmikoto.app.routerChannel.vent, 'change:page', this.adaptContentToPage);
    },
    adaptContentToPage: function(page)
    {
        this.renderPrimaryBlock(page);
        this.renderRelatedElements(page);
        this.renderAdd(page);
    },
    renderPrimaryBlock: function(page)
    {
        $.ajax({
            context: this,
            type: 'GET',
            url: deepmikoto.apiRoutes.FETCH_SIDEBAR_PRIMARY_BLOCK_URL,
            data: {
                page: page
            },
            dataType: 'html',
            success: function(response)
            {
                this.ui.primary.html(response);
            }
        });
    },
    renderRelatedElements: function(name)
    {

    },
    renderAdd: function(name)
    {

    },
    renderHomeSubject: function()
    {

    }
});