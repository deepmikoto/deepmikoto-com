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
    event.notification.close();
    event.waitUntil(
        clients.openWindow('https://deepmikoto.com')
    );
});
