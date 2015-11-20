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
        this.updateLoader( 80, 'user info' );
        this.updateLoader( 100, 'done' );
        this.startRouter();
        this.showCookieFootNote();
        deepmikoto.app.user = new deepmikoto.User();
        /*$.ajax({ // haven't decided if users will be able to log in
            context: this,
            type: 'GET',
            url: deepmikoto.apiRoutes.FETCH_USER_INFO_URL,
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
                        'you are agreeing to our use of cookies.'
                    })
                })
            );
        }
    }
});