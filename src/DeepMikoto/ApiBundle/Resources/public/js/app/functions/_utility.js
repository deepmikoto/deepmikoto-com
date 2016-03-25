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
        var swipe_det = {};
        swipe_det.sX = 0;
        swipe_det.sY = 0;
        swipe_det.eX = 0;
        swipe_det.eY = 0;
        var min_x = 20;  //min x swipe for horizontal swipe
        var max_x = 40;  //max x difference for vertical swipe
        var min_y = 40;  //min y swipe for vertical swipe
        var max_y = 50;  //max y difference for horizontal swipe
        var direc = "";
        DOMElement.addEventListener('touchstart',function(e){
            e.preventDefault();
            var t = e.touches[0];
            swipe_det.sX = t.screenX;
            swipe_det.sY = t.screenY;
        },false);
        DOMElement.addEventListener('touchmove',function(e){
            e.preventDefault();
            var t = e.touches[0];
            swipe_det.eX = t.screenX;
            swipe_det.eY = t.screenY;
        },false);
        DOMElement.addEventListener('touchend',function(e){
            e.preventDefault();
            //horizontal detection
            if ((((swipe_det.eX - min_x > swipe_det.sX) || (swipe_det.eX + min_x < swipe_det.sX)) && ((swipe_det.eY < swipe_det.sY + max_y) && (swipe_det.sY > swipe_det.eY - max_y)))) {
                if(swipe_det.eX > swipe_det.sX) direc = "right";
                else direc = "left";
            }
            //vertical detection
            if ((((swipe_det.eY - min_y > swipe_det.sY) || (swipe_det.eY + min_y < swipe_det.sY)) && ((swipe_det.eX < swipe_det.sX + max_x) && (swipe_det.sX > swipe_det.eX - max_x)))) {
                if(swipe_det.eY > swipe_det.sY) direc = "down";
                else direc = "up";
            }

            if (direc != "") {
                typeof callback == 'function' ? callback(direc) : null;
                alert("you swiped on element w to "+direc+" direction");
            }
            direc = "";
            swipe_det.sX = 0; swipe_det.sY = 0; swipe_det.eX = 0; swipe_det.eY = 0;
        },false);
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