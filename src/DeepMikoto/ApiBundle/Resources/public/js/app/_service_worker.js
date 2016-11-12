/**
 * Created by MiKoRiza-OnE on 11/10/2016.
 */
'use strict';
self.addEventListener('push', function(event)
{
    var data = JSON.parse( event.data.text() );
    event.waitUntil(
        self.registration.showNotification(data.title, data)
    );
});

self.addEventListener('notificationclick', function(event)
{
    console.log( event );
    console.log( event.notification );
    console.log( event.notification.data );
    event.notification.close();
    //var data = JSON.parse( event.data.text() );
    event.waitUntil(
        clients.openWindow('https://deepmikoto.com')
    );
});
