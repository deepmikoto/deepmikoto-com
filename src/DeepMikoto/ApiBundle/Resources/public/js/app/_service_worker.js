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
        clients.matchAll({
            type: "window"
        }).then( function(clientList){
            let targetUrl = event.notification.data.targetURL;
            for (var i = 0; i < clientList.length; i++) {
                var client = clientList[i];
                if (client.url == targetUrl && 'focus' in client)
                    return client.focus();
            }
            if (clients.openWindow) {
                return clients.openWindow(targetUrl);
            }
        })
    );
});
