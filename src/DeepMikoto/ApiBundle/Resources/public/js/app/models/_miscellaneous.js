/**
 * Created by MiKoRiza-OnE on 2/10/2016.
 */

deepmikoto.HelpPageModel = Backbone.Model.extend({
    defaults: {
        content: null,
        updated: null
    }
});

deepmikoto.SearchSuggestionModel = Backbone.Model.extend({
    defaults: {
        title: null,
        category: null,
        url: null
    }
});