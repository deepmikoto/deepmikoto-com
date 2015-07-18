/**
 * Created by MiKoRiza-OnE on 7/9/2015.
 */

deepmikoto.AppFunctions = Marionette.extend({
    constructor: function ()
    {
        this.fetchTemplates();
    },
    updateLoader: function (progress, subject)
    {
        $('#loader-bar').css('width', progress + '%');
        $('#loader-subject').html(subject);
    },
    fetchTemplates: function ()
    {
        this.updateLoader(40, 'templates');
        $.ajax({
            context: this,
            type: 'GET',
            url: deepmikoto.apiRoutes.FETCH_TEMPLATES_URL,
            dataType: 'json',
            success: function(response)
            {
                deepmikoto.templates = response;
                this.renderAppHeader();
                this.renderSidebar();
                this.fetchUserInfo();
            }
        });
    },
    renderAppHeader: function ()
    {
        /** @namespace deepmikoto.app.header */
        deepmikoto.app.header.show( new deepmikoto.AppHeaderView({ model: new deepmikoto.AppHeaderModel }) );
    },
    renderSidebar: function ()
    {
        /** @namespace deepmikoto.app.sidebar */
        deepmikoto.app.sidebar.show( new deepmikoto.SidebarView({ model: new deepmikoto.SidebarModel }) );
    },
    fetchUserInfo: function()
    {
        this.updateLoader(80, 'user info');
        $.ajax({
            context: this,
            type: 'GET',
            url: deepmikoto.apiRoutes.FETCH_USER_INFO_URL,
            dataType: 'json',
            success: function(response)
            {
                deepmikoto.app.user = new deepmikoto.User(response);
                this.updateLoader(100, 'done');
                this.startRouter();
            }
        });
    },
    startRouter: function()
    {
        deepmikoto.app.router = new deepmikoto.Router();
        Backbone.history.start({ pushState: true, root: root });
    }
});