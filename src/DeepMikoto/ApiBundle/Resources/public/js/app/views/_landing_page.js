/**
 * Created by MiKoRiza-OnE on 2/11/2016.
 */

deepmikoto.LandingPage = Marionette.ItemView.extend({
    className: 'landing-page',
    model: new deepmikoto.LandingPageModel,
    ui: {
        sections: 'section',
        welcomeSection: 'section.welcome',
        scrollIndicatorWheel: '.scroll-indicator',
        welcomeSectionVideo: '#bgvid'
    },
    initialize: function()
    {
        this.listenTo( deepmikoto.app.routerChannel.vent, 'change:page', this.destroy );
        this.listenTo( deepmikoto.app.windowChannel.vent, 'window:resize', this.adaptSectionsSize );
        this.listenTo( deepmikoto.app.windowChannel.vent, 'window:mousewheel', this.showAppropriateSection );
    },
    getTemplate: function ()
    {
        return _.template( deepmikoto.templates.landingPage );
    },
    onShow: function ()
    {
        this.scrollToTopAndDisableScroll();
        this.adaptSectionsSize();
        this.enableSwipeDetection();
        //this.loadVideoAndOpenWindow();
    },
    onDestroy: function ()
    {
        deepmikoto.app.utilityFunctions.showHTMLOverflow();
    },
    scrollToTopAndDisableScroll: function ()
    {
        deepmikoto.app.utilityFunctions.windowScrollToTop();
        deepmikoto.app.utilityFunctions.hideHTMLOverflow();
    },
    enableSwipeDetection: function ()
    {
        deepmikoto.app.utilityFunctions.detectSwipe( this.el, $.proxy( function ( swipedir ){
            if ( swipedir == 'up' ) {
                this.showNextSection();
            } else if ( swipedir == 'down' ) {
                this.showPreviousSection();
            }
        }, this ) );
    },
    getActiveSection: function ()
    {
        return this.$el.find('section[data-active]');
    },
    adaptSectionsSize: function ()
    {
        if( !this.model.get( 'scrollInProgress' ) === true ) {
            this.scrollTimeout != undefined ? clearTimeout( this.scrollTimeout ) : null;
            this.ui.sections.css({ height: $( window ).height() } );
            var active_section = this.getActiveSection();
            //noinspection JSCheckFunctionSignatures
            window.scrollTo( 0, active_section.offset().top );
            this.scrollTimeout = setTimeout(function (){
                //noinspection JSCheckFunctionSignatures
                window.scrollTo( 0, active_section.offset().top );
            }, 100 );
        } else {
            this.model.set( 'resizeAfterScrollEnd', true );
        }
    },
    showAppropriateSection: function ( direction )
    {
        if( this.model.get( 'scrollInProgress' ) === false ){
            this.model.set({ scrollInProgress: true });
            var offset = null, s = this.getActiveSection();
            if( direction == 'down' && s.next().length > 0 ){
                this.ui.sections.removeAttr( 'data-active' );
                offset = s.next().attr('data-active', 'yes').offset().top;
            } else if ( direction == 'up' && s.prev().length > 0 ){
                this.ui.sections.removeAttr( 'data-active' );
                offset = s.prev().attr('data-active', 'yes').offset().top;
            }
            if( offset != null ){
                $('html, body').animate({
                    scrollTop: offset
                }, 600, $.proxy( function (){
                    this.model.set({ scrollInProgress: false });
                    if ( this.model.get( 'resizeAfterScrollEnd' ) === true ) {
                        this.model.set({ resizeAfterScrollEnd: false });
                        this.adaptSectionsSize();
                    }
                }, this ) );
            } else {
                this.model.set({ scrollInProgress: false });
            }
        }
    },
    showNextSection: function ()
    {
        this.showAppropriateSection( 'down' );
    },
    showPreviousSection: function()
    {
        this.showAppropriateSection( 'up' );
    },
    loadVideoAndOpenWindow: function ()
    {
        var _this = this,
            video = this.ui.welcomeSectionVideo[0];
        video.addEventListener('loadeddata', function (){
            _this.ui.welcomeSection.addClass('open-vid');
        });
        video.play();
    }
});