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