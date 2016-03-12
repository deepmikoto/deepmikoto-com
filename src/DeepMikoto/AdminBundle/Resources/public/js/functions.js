/**
 * Created by MiKoRiza-OnE on 7/29/2015.
 */

/**
 * deploy tools logic
 */
function enableDeployTools()
{
    if( deepmikoto.home.buttons.runDeployTools.length == 0 ) return;
    deepmikoto.home.links.fullDeploy.on( 'click', function ( e ){
        e.preventDefault();
        deepmikoto.home.checkboxes.gitPullMaster.attr( 'checked', 'checked' );
        deepmikoto.home.checkboxes.composerInstall.attr( 'checked', 'checked' );
        deepmikoto.home.checkboxes.cacheClear.attr( 'checked', 'checked' );
        deepmikoto.home.checkboxes.migrations.attr( 'checked', 'checked' );
        deepmikoto.home.checkboxes.assetsInstall.attr( 'checked', 'checked' );
        deepmikoto.home.checkboxes.asseticDump.attr( 'checked', 'checked' );
    });
    deepmikoto.home.buttons.runDeployTools.on( 'click', function ()
    {
        function getUrlOrStatusForCheckbox( checkbox, propertyType )
        {
            var url, status;
            if( checkbox == deepmikoto.home.checkboxes.gitPullMaster ){
                url = deepmikoto.home.ajaxUrls.GIT_PULL_MASTER_URL;
                status = 'Fetching latest code from GIT ... ';
            } else if (checkbox == deepmikoto.home.checkboxes.composerInstall ){
                url = deepmikoto.home.ajaxUrls.COMPOSER_INSTALL_URL;
                status = 'Installing composer dependencies ... ';
            } else if (checkbox == deepmikoto.home.checkboxes.cacheClear ){
                url = deepmikoto.home.ajaxUrls.CACHE_CLEAR_URL;
                status = 'Clearing cache ... ';
            } else if (checkbox == deepmikoto.home.checkboxes.migrations ){
                url = deepmikoto.home.ajaxUrls.MIGRATIONS_URL;
                status = 'Running database migrations ... ';
            } else if (checkbox == deepmikoto.home.checkboxes.assetsInstall ){
                url = deepmikoto.home.ajaxUrls.ASSETS_INSTALL_URL;
                status = 'Installing assets ... ';
            } else if (checkbox == deepmikoto.home.checkboxes.asseticDump ){
                url = deepmikoto.home.ajaxUrls.ASSETIC_DUMP_URL;
                status = 'Compiling assets ... ';
            }

            if( propertyType == 'url' ){
                return url;
            } else {
                return status;
            }
        }
        function runCommand( checkbox )
        {
            deepmikoto.home.miscelanious.deployToolsCurrent.html( getUrlOrStatusForCheckbox( checkbox, 'status' ) );
            windowpop( getUrlOrStatusForCheckbox( checkbox, 'url' ), 543, 433 );
            /*$.ajax({
                url: getUrlOrStatusForCheckbox( checkbox, 'url' ),
                success: function(){
                    deepmikoto.home.miscelanious.deployToolsLog.append( deepmikoto.home.miscelanious.deployToolsCurrent.html() + 'OK<br>' );
                    deepmikoto.home.miscelanious.deployToolsCurrent.html( '' );
                    startCommandChain( checkbox );
                },
                error: function(){
                    deepmikoto.home.miscelanious.deployToolsLog.append( deepmikoto.home.miscelanious.deployToolsCurrent.html() + 'FAILED<br>' );
                    deepmikoto.home.miscelanious.deployToolsCurrent.html( 'Something went wrong! Process stopped!')
                }
            });*/
        }
        function startCommandChain( previousCheckbox )
        {
            previousCheckbox = previousCheckbox || null;
            if( previousCheckbox == null ){
               if( deepmikoto.home.checkboxes.gitPullMaster.is( ':checked' ) ){
                   runCommand( deepmikoto.home.checkboxes.gitPullMaster );
               } else if( deepmikoto.home.checkboxes.composerInstall.is( ':checked' ) ){
                   runCommand( deepmikoto.home.checkboxes.composerInstall );
               } else if( deepmikoto.home.checkboxes.cacheClear.is( ':checked' ) ){
                   runCommand( deepmikoto.home.checkboxes.cacheClear );
               } else if( deepmikoto.home.checkboxes.migrations.is( ':checked' ) ){
                   runCommand( deepmikoto.home.checkboxes.migrations );
               } else if( deepmikoto.home.checkboxes.assetsInstall.is( ':checked' ) ){
                   runCommand( deepmikoto.home.checkboxes.assetsInstall );
               } else if( deepmikoto.home.checkboxes.asseticDump.is( ':checked' ) ){
                   runCommand( deepmikoto.home.checkboxes.asseticDump );
               } else {
                   deepmikoto.home.miscelanious.deployToolsLog.append( 'FINISH' );
               }
            } else if( previousCheckbox == deepmikoto.home.checkboxes.gitPullMaster ){
                if( deepmikoto.home.checkboxes.composerInstall.is( ':checked' ) ){
                    runCommand( deepmikoto.home.checkboxes.composerInstall );
                } else if( deepmikoto.home.checkboxes.cacheClear.is( ':checked' ) ){
                    runCommand( deepmikoto.home.checkboxes.cacheClear );
                } else if( deepmikoto.home.checkboxes.migrations.is( ':checked' ) ){
                    runCommand( deepmikoto.home.checkboxes.migrations );
                } else if( deepmikoto.home.checkboxes.assetsInstall.is( ':checked' ) ){
                    runCommand( deepmikoto.home.checkboxes.assetsInstall );
                } else if( deepmikoto.home.checkboxes.asseticDump.is( ':checked' ) ){
                    runCommand( deepmikoto.home.checkboxes.asseticDump );
                } else {
                    deepmikoto.home.miscelanious.deployToolsLog.append( 'FINISH' );
                }
            } else if( previousCheckbox == deepmikoto.home.checkboxes.composerInstall ){
                if( deepmikoto.home.checkboxes.cacheClear.is( ':checked' ) ){
                    runCommand( deepmikoto.home.checkboxes.cacheClear );
                } else if( deepmikoto.home.checkboxes.migrations.is( ':checked' ) ){
                    runCommand( deepmikoto.home.checkboxes.migrations );
                } else if( deepmikoto.home.checkboxes.assetsInstall.is( ':checked' ) ){
                    runCommand( deepmikoto.home.checkboxes.assetsInstall );
                } else if( deepmikoto.home.checkboxes.asseticDump.is( ':checked' ) ){
                    runCommand( deepmikoto.home.checkboxes.asseticDump );
                } else {
                    deepmikoto.home.miscelanious.deployToolsLog.append( 'FINISH' );
                }
            } else if( previousCheckbox == deepmikoto.home.checkboxes.cacheClear ){
                if( deepmikoto.home.checkboxes.migrations.is( ':checked' ) ){
                    runCommand( deepmikoto.home.checkboxes.migrations );
                } else if( deepmikoto.home.checkboxes.assetsInstall.is( ':checked' ) ){
                    runCommand( deepmikoto.home.checkboxes.assetsInstall );
                } else if( deepmikoto.home.checkboxes.asseticDump.is( ':checked' ) ){
                    runCommand( deepmikoto.home.checkboxes.asseticDump );
                } else {
                    deepmikoto.home.miscelanious.deployToolsLog.append( 'FINISH' );
                }
            } else if( previousCheckbox == deepmikoto.home.checkboxes.migrations ){
                if( deepmikoto.home.checkboxes.assetsInstall.is( ':checked' ) ){
                    runCommand( deepmikoto.home.checkboxes.assetsInstall );
                } else if( deepmikoto.home.checkboxes.asseticDump.is( ':checked' ) ){
                    runCommand( deepmikoto.home.checkboxes.asseticDump );
                } else {
                    deepmikoto.home.miscelanious.deployToolsLog.append( 'FINISH' );
                }
            } else if( previousCheckbox == deepmikoto.home.checkboxes.assetsInstall ){
                if( deepmikoto.home.checkboxes.asseticDump.is( ':checked' ) ){
                    runCommand( deepmikoto.home.checkboxes.asseticDump );
                } else {
                    deepmikoto.home.miscelanious.deployToolsLog.append( 'FINISH' );
                }
            } else {
                deepmikoto.home.miscelanious.deployToolsLog.append( 'FINISH' );
            }
        }
        deepmikoto.home.miscelanious.deployToolsCurrent.html( '' );
        deepmikoto.home.miscelanious.deployToolsLog.html( '' );
        startCommandChain();
    });
}
/**
 * @param autoComplete
 */
function geoLocate( autoComplete )
{
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition( function( position ) {
            /** @class google.maps.LatLng */
            var geolocation = new google.maps.LatLng( position.coords.latitude, position.coords.longitude );
            /** @class google.maps.Circle */
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            /** @class autoComplete.setBounds */
            /** @class circle.getBounds */
            autoComplete.setBounds( circle.getBounds() );
        });
    }
}
/**
 * @param locationInput
 */
function enableGoogleAutoComplete( locationInput )
{
    if( locationInput.length == 0 ) return;
    /** @class google.maps.places.Autocomplete */
    var autoComplete = new google.maps.places.Autocomplete(
        /** @type {HTMLInputElement} */( document.getElementById( locationInput.attr('id') ) ),
        { types: ['geocode'] }
    );
    geoLocate( autoComplete );
}
/**
 * @param textarea
 */
function enableCKEditor( textarea ){
    if( textarea.length > 0 ){
        /** @namespace CKEDITOR */
        CKEDITOR.replace( textarea.attr( 'id' ) );
    }
}

function windowpop(url, width, height) {
    var leftPosition, topPosition;
    //Allow for borders.
    leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
    //Allow for title and status bars.
    topPosition = (window.screen.height / 2) - ((height / 2) + 50);
    //Open the window.
    window.open(url, "Window2", "status=no,height=" + height + ",width=" + width + ",resizable=yes,left=" + leftPosition + ",top=" + topPosition + ",screenX=" + leftPosition + ",screenY=" + topPosition + ",toolbar=no,menubar=no,scrollbars=no,location=no,directories=no,address=no");
}