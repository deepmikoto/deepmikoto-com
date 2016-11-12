/**
 * Created by MiKoRiza-OnE on 11/10/2016.
 */
'use strict';

/**
 * my annoyance with warnings
 *
 * @property {Object} registration
 * @typedef {Object} registration
 * @property {Function} showNotification
 */
self.addEventListener( 'push', function( event )
{
    var data = JSON.parse( event.data.text() );
    event.waitUntil(
        self.registration.showNotification( data.title, data )
    );
});

/**
 * my annoyance with warnings
 *
 * @typedef {Object} event
 * @property {Object} notification
 * @property {Function} waitUntil
 * @property {Function} matchAll
 * @property {String} targetURL
 * @typedef {Object} clients
 * @property {Function} openWindow
 */
self.addEventListener('notificationclick', function(event)
{
    event.notification.close();
    event.waitUntil(
        clients.matchAll({
            type: "window"
        }).then( function( clientList ){
            var targetUrl = event.notification.data.targetURL;
            for ( var i = 0; i < clientList.length; i++ ) {
                var client = clientList[i];
                if ( client.url == targetUrl && 'focus' in client )
                    return client.focus();
            }
            if ( clients.openWindow ) {
                return clients.openWindow( targetUrl );
            }
        })
    );
});
