/**
 * Created by MiKoRiza-OnE on 7/9/2015.
 */

deepmikoto.AppFunctions = Marionette.extend({
    constructor: function ()
    {
        this.fetchTemplates();
    },
    renderMainHeader: function ()
    {
        var mainHeaderView = new deepmikoto.MainHeaderView({
            model: new deepmikoto.MainHeaderModel()
        });
        deepmikoto.app.mainHeader.show(mainHeaderView);
    },
    fetchTemplates: function ()
    {
        $.ajax({
            context: this,
            type: 'GET',
            url: deepmikoto.apiRoutes.FETCH_TEMPLATES_URL,
            dataType: 'json',
            success: function(response)
            {
                deepmikoto.templates = response;
                this.renderMainHeader();
                this.startRouter();
            }
        })
    },
    startRouter: function()
    {
        deepmikoto.app.router = new deepmikoto.Router();
        Backbone.history.start({ pushState: true, root: root });
    }
});