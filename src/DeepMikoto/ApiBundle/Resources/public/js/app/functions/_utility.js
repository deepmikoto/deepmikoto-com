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
            threshold = 150, //required min distance traveled to be considered swipe
            restraint = 100, // maximum distance allowed at the same time in perpendicular direction
            allowedTime = 300, // maximum time allowed to travel that distance
            elapsedTime,
            startTime
        ;

        touchsurface.addEventListener('touchstart', function(e){
            e.preventDefault();
            var touchobj = e.changedTouches[0];
            swipedir = 'none';
            startX = touchobj.pageX;
            startY = touchobj.pageY;
            startTime = new Date().getTime(); // record time when finger first makes contact with surface
            $('section').find('.section-content').html('' +
                '<div><span>startX:' + startX + '</span>&nbsp;<span>startY:' + startY + '</span></div><br>'
            )

        }, false);

        touchsurface.addEventListener('touchmove', function(e){
            e.preventDefault(); // prevent scrolling when inside DIV
            $('section').find('.section-content').append('.');
        }, false);

        touchsurface.addEventListener('touchend', function(e){
            e.preventDefault();

            var touchobj = e.changedTouches[0];
            distX = touchobj.pageX - startX; // get horizontal dist traveled by finger while in contact with surface
            distY = touchobj.pageY - startY; // get vertical dist traveled by finger while in contact with surface
            elapsedTime = new Date().getTime() - startTime; // get time elapsed
            $('section').find('.section-content').html('' +
                '<br><div>' +
                '<span>startX:' + startX + '</span>&nbsp;<span>startY:' + startY + '</span><br>' +
                '<span>touchobj.pageX:' + touchobj.pageX + '</span>&nbsp;<span>touchobj.pageY:' + touchobj.pageY + '</span><br>' +
                '<span>distX:' + distX + '</span>&nbsp;<span>distY:' + distY + '</span><br>' +
                '<span>threshold:' + threshold + '</span>&nbsp;<span>restraint:' + restraint + '</span><br>' +
                '</div><br>'
            );
            if (elapsedTime <= allowedTime){ // first condition for awipe met
                if (Math.abs(distX) >= threshold && Math.abs(distY) <= restraint){ // 2nd condition for horizontal swipe met
                    swipedir = (distX < 0)? 'left' : 'right'; // if dist traveled is negative, it indicates left swipe
                }
                else if (Math.abs(distY) >= threshold && Math.abs(distX) <= restraint){ // 2nd condition for vertical swipe met
                    swipedir = (distY < 0)? 'up' : 'down'; // if dist traveled is negative, it indicates up swipe
                }
            }
            typeof callback == 'function' ? callback( swipedir ) : null;
            alert("you swiped on element w to "+swipedir+" direction");

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