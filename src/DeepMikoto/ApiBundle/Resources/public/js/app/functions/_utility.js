/**
 * Created by MiKoRiza-OnE on 3/13/2016.
 */

deepmikoto.UtilityFunctions = Marionette.extend({
    constructor: function ()
    {
        //this.enableSwipeUpAndDownSupport();
    },
    detectSwipe: function ( DOMElement, callback )
    {
        var touchsurface = DOMElement,
            swipedir,
            startX,
            startY,
            distX,
            distY,
            threshold = 100, //required min distance traveled to be considered swipe
            restraint = 100, // maximum distance allowed at the same time in perpendicular direction
            allowedTime = 500, // maximum time allowed to travel that distance
            elapsedTime,
            startTime
        ;
        touchsurface.addEventListener('touchstart', function( e ){
            //e.preventDefault();
            /** @namespace e.changedTouches */
            var touchobj = e.changedTouches[0];
            swipedir = 'none';
            startX = touchobj.pageX;
            startY = touchobj.pageY;
            startTime = new Date().getTime(); // record time when finger first makes contact with surface
        }, false);
        touchsurface.addEventListener('touchmove', function(e){
            e.preventDefault(); // prevent scrolling when inside element
        }, false );
        touchsurface.addEventListener('touchend', function( e ){
            //e.preventDefault();
            var touchobj = e.changedTouches[0];
            distX = touchobj.pageX - startX; // get horizontal dist traveled by finger while in contact with surface
            distY = touchobj.pageY - startY; // get vertical dist traveled by finger while in contact with surface
            elapsedTime = new Date().getTime() - startTime; // get time elapsed
            if (elapsedTime <= allowedTime){ // first condition for awipe met
                if (Math.abs(distX) >= threshold && Math.abs(distY) <= restraint){ // 2nd condition for horizontal swipe met
                    swipedir = (distX < 0)? 'left' : 'right'; // if dist traveled is negative, it indicates left swipe
                }
                else if (Math.abs(distY) >= threshold && Math.abs(distX) <= restraint){ // 2nd condition for vertical swipe met
                    swipedir = (distY < 0)? 'up' : 'down'; // if dist traveled is negative, it indicates up swipe
                }
            }
            typeof callback == 'function' ? callback( swipedir ) : null;
        }, false);
    },
    isElementInViewport: function ( el )
    {
        if( el != undefined ){
            if (typeof jQuery === "function" && el instanceof jQuery) {
                el = el[0];
            }

            var rect = el.getBoundingClientRect();

            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= $( window ).height() &&
                rect.right <= $( window ).width()
            );
        }
    },
    windowScrollToTop: function ()
    {
        window.scrollTo( 0, 0 );
    },
    hideHTMLOverflow: function ()
    {
        $( 'html' ).addClass( 'locked' );
    },
    showHTMLOverflow: function ()
    {
        $( 'html' ).removeClass( 'locked' );
    }
});