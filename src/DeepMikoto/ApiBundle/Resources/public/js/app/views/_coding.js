/**
 * Created by MiKoRiza-OnE on 9/27/2015.
 */

deepmikoto.CodingTimelineItemView = Marionette.ItemView.extend({
    tagName: 'div',
    className: 'col-lg-12 col-md-12 col-sm-12 col-xs-12 coding-post',
    events: {
        click: 'showPostDetails'
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
    getTemplate: function ()
    {
        /** @namespace deepmikoto.templates.codingTimelineCollection */
        return _.template( deepmikoto.templates.codingTimelineCollection );
    }
});

deepmikoto.CodingPost = Marionette.LayoutView.extend({
    tagName: 'div',
    className: 'post-details coding-type',
    onShow: function ()
    {
        /** @namespace FB.XFBML */
        typeof FB == 'object' ? FB.XFBML.parse() : null;
    },
    getTemplate: function()
    {
        /** @namespace deepmikoto.templates.codingPost */
        return _.template( deepmikoto.templates.codingPost );
    }
});