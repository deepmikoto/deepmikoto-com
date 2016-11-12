/**
 * Created by MiKoRiza-OnE on 11/12/2016.
 */
'use strict';

var __deepmikotoSW__ = {
    serverPublicKey: deepmikoto.appConstants.PUSH_SERVER_PUBLIC_KEY,
    isSubscribed: false,
    swRegistration: null,
    init: function ()
    {
        this.removeScriptTag();
        this.registerSW();
    },
    /**
     * @prop serviceWorker
     * @prop catch
     */
    registerSW: function ()
    {
        if ('serviceWorker' in navigator && 'PushManager' in window) {
            navigator.serviceWorker.register('/dmsw.js')
                .then( function( swReg ) {
                    __deepmikotoSW__.swRegistration = swReg;
                    __deepmikotoSW__.initialiseUI();
                })
                .catch(function(error) {})
            ;
        }
    },
    /**
     * @prop pushManager
     * @prop getSubscription
     */
    initialiseUI: function ()
    {
        __deepmikotoSW__.swRegistration.pushManager.getSubscription()
            .then( function( subscription ) {
                __deepmikotoSW__.isSubscribed = !(subscription === null);
                if ( !__deepmikotoSW__.isSubscribed ) {
                    __deepmikotoSW__.subscribeUser();
                }
            })
        ;
    },
    /**
     * @prop subscribe
     */
    subscribeUser: function ()
    {
        var appServerKey = this.urlB64ToUnit8Array( this.serverPublicKey );
        __deepmikotoSW__.swRegistration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: appServerKey
        })
            .then(function( subscription ) {
                __deepmikotoSW__.updateSubscriptionOnServer( subscription );
                __deepmikotoSW__.isSubscribed = true;
            })
            .catch(function(err) {
                console.log('Failed to subscribe the user: ', err);
            });
    },
    updateSubscriptionOnServer: function ( subscription )
    {
        $.ajax({
            method: 'POST',
            url: deepmikoto.apiRoutes.SAVE_PUSH_SUBSCRIPTION,
            data: JSON.parse( JSON.stringify( subscription ) ),
            dataType: 'json'
        });
    },
    removeScriptTag: function ()
    {
        var element = document.getElementById('swi');
        element.parentNode.removeChild(element);
    },
    /**
     * @prop repeat
     */
    urlB64ToUnit8Array: function( base64String )
    {
        const padding = '=' . repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding)
            .replace(/\-/g, '+')
            .replace(/_/g, '/');

        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);

        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    },
    getSubscription: function ()
    {
        if ( this.swRegistration ) {
            this.swRegistration.pushManager.getSubscription()
                .then(function (subscription) {

                });
        } else {
            console.log( 'Service Worker is not registered' );
        }
    },
    /**
     * @prop unsubscribe
     */
    removeSubscription: function ()
    {
        if ( this.swRegistration ) {
            this.swRegistration.pushManager.getSubscription()
                .then(function (subscription) {
                    if (subscription) {
                        // TODO: Tell application server to delete subscription
                        return subscription.unsubscribe();
                    }
                })
            ;
        }
    }
};

__deepmikotoSW__.init();