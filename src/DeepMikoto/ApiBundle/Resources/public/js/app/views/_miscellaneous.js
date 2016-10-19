/**
 * Created by MiKoRiza-OnE on 2/10/2016.
 */

deepmikoto.HelpPageView = Marionette.ItemView.extend({
    className: 'help-page',
    model: new deepmikoto.HelpPageModel(),
    getTemplate: function ()
    {
        return _.template( '<div class="date"><i class="glyphicon glyphicon-calendar"></i> Updated: <%=updated%></div><div class="content"><%=content%></div>');
    }
});

deepmikoto.SearchSuggestionItemView = Marionette.ItemView.extend({
    tagName: 'div',
    className: 'suggestion',
    events: {
        mouseup: 'navigateToItem'
    },
    getTemplate: function ()
    {
        /** @namespace deepmikoto.templates.searchSuggestionItemView */
        return _.template( deepmikoto.templates.searchSuggestionItemView );
    },
    navigateToItem: function ()
    {
        Backbone.history.navigate( this.model.get( 'url' ), { trigger: true } );
    }
});

deepmikoto.SearchSuggestionsView = Marionette.CompositeView.extend({
    tagName: 'div',
    className: 'suggestions-list',
    childView: deepmikoto.SearchSuggestionItemView,
    childViewContainer: '.suggestions',
    collection: deepmikoto.SearchSuggestionCollection,
    getTemplate: function ()
    {
        /** @namespace deepmikoto.templates.searchSuggestions */
        return _.template( deepmikoto.templates.searchSuggestions );
    }
});