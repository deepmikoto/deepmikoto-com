/**
 * Created by MiKoRiza-OnE on 9/27/2015.
 */

deepmikoto.CodingPostModel = Backbone.Model.extend({
    defaults: {
        id    : null,
        slug  : null,
        title : null,
        date  : null
    }
});

deepmikoto.CodingCollectionModel = Backbone.Model.extend({
    defaults: {
        slug  : null,
        name  : null,
        image : null
    }
});

deepmikoto.CodingTimelineModel = Backbone.Model.extend({
    defaults: {
        category: null
    }
});