/**
 * Created by MiKoRiza-OnE on 9/27/2015.
 */

deepmikoto.GamingTimelineItemView = Marionette.ItemView.extend({
    tagName: 'div',
    className: 'col-lg-12 col-md-12 col-sm-12 col-xs-12 gaming-post',
    events: {
        click: 'showPostDetails'
    },
    getTemplate: function ()
    {
        /** @namespace deepmikoto.templates.gamingTimelineItem */
        return _.template( deepmikoto.templates.gamingTimelineItem );
    },
    showPostDetails: function ()
    {
        Backbone.history.navigate( 'gaming/' + this.model.get( 'id' ) + '--' + this.model.get( 'slug' ), { trigger: true } );
    }
});

deepmikoto.GamingTimelineView = Marionette.CompositeView.extend({
    tagName: 'div',
    className: 'gaming-timeline',
    childView: deepmikoto.GamingTimelineItemView,
    childViewContainer: '.gaming-posts',
    collection: deepmikoto.GamingTimelineCollection,
    ui: {
        timelineEnd: '.timeline-end'
    },
    initialize: function ()
    {
        deepmikoto.app.utilityFunctions.enableEndlessScroll( this, deepmikoto.apiRoutes.GAMING_TIMELINE_URL, deepmikoto.appConstants.GAMING_TIMELINE_LIMIT );
    },
    getTemplate: function ()
    {
        /** @namespace deepmikoto.templates.gamingTimelineCollection */
        return _.template( deepmikoto.templates.gamingTimelineCollection );
    }
});

deepmikoto.GamingPost = Marionette.LayoutView.extend({
    tagName: 'div',
    className: 'post-details gaming-type',
    onShow: function ()
    {
        /** @namespace FB.XFBML */
        typeof FB == 'object' ? FB.XFBML.parse() : null;
    },
    getTemplate: function()
    {
        /** @namespace deepmikoto.templates.gamingPost */
        return _.template( deepmikoto.templates.gamingPost );
    }
});