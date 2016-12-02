/**
 * Created by MiKoRiza-OnE on 9/27/2015.
 */

deepmikoto.CodingTimelineItemView = Marionette.ItemView.extend({
    tagName: 'div',
    className: 'col-lg-6 col-md-6 col-sm-12 col-xs-12 coding-post',
    ui: {
        self: '.item'
    },
    events: {
        'click @ui.self': 'showPostDetails'
    },
    getTemplate: function ()
    {
        /** @namespace deepmikoto.templates.codingTimelineItem */
        return _.template( deepmikoto.templates.codingTimelineItem );
    },
    showPostDetails: function ()
    {
        Backbone.history.navigate( 'coding/' + this.model.get( 'id' ) + '--' + this.model.get( 'slug' ), { trigger: true } );
    }
});

deepmikoto.CodingTimelineView = Marionette.CompositeView.extend({
    tagName: 'div',
    className: 'coding-timeline',
    childView: deepmikoto.CodingTimelineItemView,
    childViewContainer: '.coding-posts',
    collection: deepmikoto.CodingTimelineCollection,
    ui: {
        timelineEnd: '.timeline-end'
    },
    initialize: function ()
    {
        deepmikoto.app.utilityFunctions.enableEndlessScroll( this, deepmikoto.apiRoutes.CODING_TIMELINE_URL, deepmikoto.appConstants.CODING_TIMELINE_LIMIT );
    },
    getTemplate: function ()
    {
        /** @namespace deepmikoto.templates.codingTimelineCollection */
        return _.template( deepmikoto.templates.codingTimelineCollection );
    }
});

deepmikoto.CodingCategoriesTimelineItemView = Marionette.ItemView.extend({
    tagName: 'div',
    className: 'col-lg-3 col-md-3 col-sm-12 col-xs-12 coding-category',
    ui: {
        self: '.category'
    },
    events: {
        'click @ui.self': 'showCategoryPosts'
    },
    getTemplate: function ()
    {
        /** @namespace deepmikoto.templates.codingCategoryTimelineItem */
        return _.template( deepmikoto.templates.codingCategoryTimelineItem );
    },
    showCategoryPosts: function ()
    {
        Backbone.history.navigate( 'coding/' + this.model.get( 'slug' ), { trigger: true } );
    }
});

deepmikoto.CodingCategoriesTimelineView = Marionette.CompositeView.extend({
    tagName: 'div',
    className: 'coding-timeline',
    childView: deepmikoto.CodingCategoriesTimelineItemView,
    childViewContainer: '.coding-categories',
    collection: deepmikoto.CodingTimelineCollection,
    getTemplate: function ()
    {
        /** @namespace deepmikoto.templates.codingCategoryTimelineCollection */
        return _.template( deepmikoto.templates.codingCategoryTimelineCollection );
    }
});

deepmikoto.CodingPost = Marionette.LayoutView.extend({
    tagName: 'div',
    className: 'post-details coding-type',
    onShow: function ()
    {
        try {
            /** @namespace FB.XFBML */
            typeof FB == 'object' ? FB.XFBML.parse() : null;
        } catch ( e ) {

        }
        typeof Prism == 'object' ? Prism.highlightAll() : null;
    },
    getTemplate: function()
    {
        /** @namespace deepmikoto.templates.codingPost */
        return _.template( deepmikoto.templates.codingPost );
    }
});