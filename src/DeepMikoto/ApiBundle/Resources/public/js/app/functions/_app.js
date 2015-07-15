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
                this.renderMainHeader();
                this.fetchUserInfo();
            }
        });
    },
    renderMainHeader: function ()
    {
        var mainHeaderView = new deepmikoto.MainHeaderView({
            model: new deepmikoto.MainHeaderModel()
        });
        deepmikoto.app.mainHeader.show(mainHeaderView);
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
                this.updateLoader(100, 'done');
                deepmikoto.app.user = new deepmikoto.User(response);
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