/**
 * Created by MiKoRiza-OnE on 8/4/2015.
 */

deepmikoto.PhotographyTimelineItemView = Marionette.ItemView.extend({
    tagName: 'div',
    className: 'photography-post',
    getTemplate: function ()
    {
        /** @namespace deepmikoto.templates.photographyTimelineItem */
        return _.template( deepmikoto.templates.photographyTimelineItem );
    }
});

deepmikoto.PhotographyTimelineView = Marionette.CompositeView.extend({
    tagName: 'div',
    className: 'photography-timeline',
    childView: deepmikoto.PhotographyTimelineItemView,
    childViewContainer: '.photography-posts',
    collection: deepmikoto.PhotographyTimelineCollection,
    getTemplate: function ()
    {
        /** @namespace deepmikoto.templates.photographyTimelineCollection */
        return _.template( deepmikoto.templates.photographyTimelineCollection );
    }
});