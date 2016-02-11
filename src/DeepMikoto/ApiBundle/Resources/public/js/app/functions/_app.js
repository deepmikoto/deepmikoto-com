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
        this.updateLoader(80, 'templates');
        this.addExtraAppRegions();
        $.ajax({
            context: this,
            type: 'GET',
            url: deepmikoto.apiRoutes.TEMPLATES_URL,
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
    addExtraAppRegions: function ()
    {
        $( 'body' ).append(
            '<div class="footnote-container" id="footnote"></div>' +
            '<div class="modal-container" id="modal"></div>'
        );

        deepmikoto.app.addRegions({
            footnote      : '#footnote',
            modal         : '#modal'
        });
    },
    renderAppHeader: function ()
    {
        /** @namespace deepmikoto.app.header */
        deepmikoto.app.header.show( new deepmikoto.HeaderView({ model: new deepmikoto.AppHeaderModel }) );
    },
    renderSidebar: function ()
    {
        /** @namespace deepmikoto.app.sidebar */
        deepmikoto.app.sidebar.show( new deepmikoto.SidebarView({ model: new deepmikoto.SidebarModel }) );
    },
    fetchUserInfo: function()
    {
        //this.updateLoader( 80, 'user info' );
        this.updateLoader( 100, 'done' );
        this.startRouter();
        this.showCookieFootNote();
        deepmikoto.app.user = new deepmikoto.User();
        /*$.ajax({ // haven't decided if users will be able to log in
            context: this,
            type: 'GET',
            url: deepmikoto.apiRoutes.USER_INFO_URL,
            dataType: 'json',
            success: function( response )
            {
                deepmikoto.app.user = new deepmikoto.User( response[ 'payload' ] );
                this.updateLoader( 100, 'done' );
                this.startRouter();
                this.showCookieFootNote();
            }
        });*/
    },
    startRouter: function()
    {
        /** @namespace deepmikoto.app.landingPage */
        deepmikoto.app.landingPage.$el.html('');
        deepmikoto.app.router = new deepmikoto.Router();
        deepmikoto.app.router.on( 'route', function (){
            deepmikoto.app.generalFunctions.sendGooglePageView( Backbone.history.fragment );
        });
        Backbone.history.start({ pushState: true, root: root });
    },
    setPageTitle: function( title )
    {
        $( document ).prop( 'title', title );
    },
    showCookieFootNote: function()
    {
        if( Cookies.get( 'cookie-notice' ) !== 'true' ){
            deepmikoto.app.footnote.show(
                new deepmikoto.FootNoteView({
                    model: new deepmikoto.FootNoteModel({
                        type: 'cookie',
                        message: 'This site uses cookies in order to improve your experience. By continuing to browse the site ' +
                        'you are agreeing to our use of cookies. <a href="' + '/help' + '">More Info</a>'
                    })
                })
            );
        }
    }
});