/**
 * Created by MiKoRiza-OnE on 8/4/2015.
 */

deepmikoto.PhotographyTimelineItemView = Marionette.ItemView.extend({
    tagName: 'div',
    className: 'col-lg-6 col-md-6 col-sm-6 col-xs-12 photography-post',
    ui: {
        photos: '#photos',
        photo: '#photo',
        overlay: '#overlay'
    },
    events: {
        'click @ui.overlay': 'showPostDetails'
    },
    getTemplate: function ()
    {
        /** @namespace deepmikoto.templates.photographyTimelineItem */
        return _.template( deepmikoto.templates.photographyTimelineItem );
    },
    onShow: function()
    {
        this.applyRandomAnimation();
    },
    applyRandomAnimation: function ()
    {
        var min = 1, max = 2;
        var effectToUse = Math.floor( Math.random() * ( max - min + 1 ) + min );
        if( effectToUse == 1 ){
            this.enablePictureSlideUp();
        } else if( effectToUse == 2 ){
            this.enablePictureFading();
        }
    },
    showPostDetails: function ( e )
    {
        e.target.nodeName != 'A' ?
        Backbone.history.navigate( 'photography/' + this.model.get( 'id' ) + '--' + this.model.get( 'slug' ), { trigger: true } )
        : null;
    },
    enablePictureFading: function()
    {
        var photos_count = this.model.get( 'photos' ).length, _this = this;
        function displayNextPhoto( index, useDelay ){
            var previous_index, next_index, delay = Math.floor( Math.random() * ( 20000 - 3000 + 1 ) + 3000 );
            useDelay = useDelay || false;
            setTimeout( function (){
                if( !_this.isDestroyed ){
                    if( index == 0 ){
                        previous_index = photos_count - 1;
                    } else {
                        previous_index = index - 1;
                    }
                    $( _this.ui.photo[ previous_index ] ).animate({
                        opacity: 0
                    }, 1500 );
                    $( _this.ui.photo[ index ] ).animate({
                        opacity: 1
                    }, 1500 );
                    setTimeout( function(){
                        if( index == photos_count - 1 ){
                            next_index = 0;
                        } else {
                            next_index = index + 1;
                        }
                        displayNextPhoto( next_index );
                    }, !useDelay ? delay : 0 );
                }
            }, useDelay ? delay : 0 );
        }
        $( this.ui.photo[ 0 ] ).css( 'opacity', '1' );
        displayNextPhoto( 0, true );
    },
    enablePictureSlideUp: function()
    {
        var photos_count = this.model.get( 'photos' ).length, _this = this;
        function displayNextPhoto( index, useDelay ){
            var previous_index, next_index, delay = Math.floor( Math.random() * ( 20000 - 3000 + 1 ) + 3000 );
            useDelay = useDelay || false;
            setTimeout( function (){
                if( !_this.isDestroyed ){
                    if( index == 0 ){
                        previous_index = photos_count - 1;
                    } else {
                        previous_index = index - 1;
                    }
                    if( !useDelay ){
                        $( _this.ui.photo[ index ] ).slideDown( 'slow' );
                        $( _this.ui.photo[ previous_index ] ).slideUp( 'slow' );
                    }
                    setTimeout( function(){
                        if( index == photos_count - 1 ){
                            next_index = 0;
                        } else {
                            next_index = index + 1;
                        }
                        displayNextPhoto( next_index );
                    }, !useDelay ? delay : 0 );
                }
            }, useDelay ? delay : 0 );
        }
        this.ui.photo.css({ opacity: '1', display: 'none', position: 'relative' });
        $( this.ui.photo[ 0 ] ).css({ display: 'block' });
        displayNextPhoto( 0, true );
    }
});

deepmikoto.PhotographyTimelineView = Marionette.CompositeView.extend({
    tagName: 'div',
    className: 'photography-timeline',
    childView: deepmikoto.PhotographyTimelineItemView,
    childViewContainer: '#photography-posts',
    collection: deepmikoto.PhotographyTimelineCollection,
    ui: {
        timelineEnd: '.timeline-end'
    },
    initialize: function ()
    {
        deepmikoto.app.utilityFunctions.enableEndlessScroll( this, deepmikoto.apiRoutes.PHOTOGRAPHY_TIMELINE_URL, deepmikoto.appConstants.PHOTOGRAPHY_TIMELINE_LIMIT );
    },
    getTemplate: function ()
    {
        /** @namespace deepmikoto.templates.photographyTimelineCollection */
        return _.template( deepmikoto.templates.photographyTimelineCollection );
    }
});

deepmikoto.PhotographyPost = Marionette.LayoutView.extend({
    tagName: 'div',
    className: 'post-details photography-type',
    onShow: function ()
    {
        /** @namespace FB.XFBML */
        typeof FB == 'object' ? FB.XFBML.parse() : null;
        this.enableGallery();
    },
    getTemplate: function()
    {
        /** @namespace deepmikoto.templates.photographyPost */
        return _.template( deepmikoto.templates.photographyPost );
    },
    enableGallery: function ()
    {
        $('.photos .photo .image a').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var $this = $(this),
                index = 0,
                pswpElement = document.querySelectorAll('.pswp')[0],
                items = []
            ;

            $('.photos .photo .image a').each(function (idx, link) {
                var thumb = $(link).find('img')[0];
                items.push({
                    src: $(link).attr('href'),
                    h: thumb.width > thumb.height ? 1080 : 1920,
                    w: thumb.width > thumb.height ? 1920 : 1080,
                });

                if (link.href == $this.attr('href')) {
                    index = idx;
                }
            });

            var options = {
                mainClass: 'pswp--minimal--dark',
                barsSize: {top:0,bottom:0},
                captionEl: false,
                fullscreenEl: false,
                shareEl: false,
                bgOpacity: 0.85,
                tapToClose: true,
                tapToToggleControls: false,
                index: index
            };

            // Initializes and opens PhotoSwipe
            var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
            gallery.init();
        });
    }
});