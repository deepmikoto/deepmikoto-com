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
        var command_queue = [];
        function getUrlOrStatusForCheckbox( checkbox, propertyType )
        {
            var command, status;
            if( checkbox == deepmikoto.home.checkboxes.gitPullMaster ){
                command = deepmikoto.home.commands.GIT_PULL_MASTER;
                status = 'code update with git';
            } else if (checkbox == deepmikoto.home.checkboxes.composerInstall ){
                command = deepmikoto.home.commands.COMPOSER_INSTALL;
                status = 'dependencies install ';
            } else if (checkbox == deepmikoto.home.checkboxes.cacheClear ){
                command = deepmikoto.home.commands.CACHE_CLEAR;
                status = 'cache clear';
            } else if (checkbox == deepmikoto.home.checkboxes.migrations ){
                command = deepmikoto.home.commands.MIGRATIONS;
                status = 'database migrations';
            } else if (checkbox == deepmikoto.home.checkboxes.assetsInstall ){
                command = deepmikoto.home.commands.ASSETS_INSTALL;
                status = 'assets install';
            } else if (checkbox == deepmikoto.home.checkboxes.asseticDump ){
                command = deepmikoto.home.commands.ASSETIC_DUMP;
                status = 'assets compiling';
            }

            if( propertyType == 'command' ){
                return command;
            } else {
                return 'Queueing <strong>' + status + '</strong> ...';
            }
        }
        function addCommandToQueue( checkbox )
        {
            deepmikoto.home.miscelanious.deployToolsCurrent.html( getUrlOrStatusForCheckbox( checkbox, 'status' ) );
            updateCurrentLog( 'OK!' );
            command_queue.push( getUrlOrStatusForCheckbox( checkbox, 'command' ) );
            startCommandChain( checkbox );
        }
        function startCommandChain( previousCheckbox )
        {
            previousCheckbox = previousCheckbox || null;
            if( previousCheckbox == null ){
               if( deepmikoto.home.checkboxes.gitPullMaster.is( ':checked' ) ){
                   addCommandToQueue( deepmikoto.home.checkboxes.gitPullMaster );
               } else if( deepmikoto.home.checkboxes.composerInstall.is( ':checked' ) ){
                   addCommandToQueue( deepmikoto.home.checkboxes.composerInstall );
               } else if( deepmikoto.home.checkboxes.cacheClear.is( ':checked' ) ){
                   addCommandToQueue( deepmikoto.home.checkboxes.cacheClear );
               } else if( deepmikoto.home.checkboxes.migrations.is( ':checked' ) ){
                   addCommandToQueue( deepmikoto.home.checkboxes.migrations );
               } else if( deepmikoto.home.checkboxes.assetsInstall.is( ':checked' ) ){
                   addCommandToQueue( deepmikoto.home.checkboxes.assetsInstall );
               } else if( deepmikoto.home.checkboxes.asseticDump.is( ':checked' ) ){
                   addCommandToQueue( deepmikoto.home.checkboxes.asseticDump );
               } else {
                   runCommandQueue();
               }
            } else if( previousCheckbox == deepmikoto.home.checkboxes.gitPullMaster ){
                if( deepmikoto.home.checkboxes.composerInstall.is( ':checked' ) ){
                    addCommandToQueue( deepmikoto.home.checkboxes.composerInstall );
                } else if( deepmikoto.home.checkboxes.cacheClear.is( ':checked' ) ){
                    addCommandToQueue( deepmikoto.home.checkboxes.cacheClear );
                } else if( deepmikoto.home.checkboxes.migrations.is( ':checked' ) ){
                    addCommandToQueue( deepmikoto.home.checkboxes.migrations );
                } else if( deepmikoto.home.checkboxes.assetsInstall.is( ':checked' ) ){
                    addCommandToQueue( deepmikoto.home.checkboxes.assetsInstall );
                } else if( deepmikoto.home.checkboxes.asseticDump.is( ':checked' ) ){
                    addCommandToQueue( deepmikoto.home.checkboxes.asseticDump );
                } else {
                    runCommandQueue();
                }
            } else if( previousCheckbox == deepmikoto.home.checkboxes.composerInstall ){
                if( deepmikoto.home.checkboxes.cacheClear.is( ':checked' ) ){
                    addCommandToQueue( deepmikoto.home.checkboxes.cacheClear );
                } else if( deepmikoto.home.checkboxes.migrations.is( ':checked' ) ){
                    addCommandToQueue( deepmikoto.home.checkboxes.migrations );
                } else if( deepmikoto.home.checkboxes.assetsInstall.is( ':checked' ) ){
                    addCommandToQueue( deepmikoto.home.checkboxes.assetsInstall );
                } else if( deepmikoto.home.checkboxes.asseticDump.is( ':checked' ) ){
                    addCommandToQueue( deepmikoto.home.checkboxes.asseticDump );
                } else {
                    runCommandQueue();
                }
            } else if( previousCheckbox == deepmikoto.home.checkboxes.cacheClear ){
                if( deepmikoto.home.checkboxes.migrations.is( ':checked' ) ){
                    addCommandToQueue( deepmikoto.home.checkboxes.migrations );
                } else if( deepmikoto.home.checkboxes.assetsInstall.is( ':checked' ) ){
                    addCommandToQueue( deepmikoto.home.checkboxes.assetsInstall );
                } else if( deepmikoto.home.checkboxes.asseticDump.is( ':checked' ) ){
                    addCommandToQueue( deepmikoto.home.checkboxes.asseticDump );
                } else {
                    runCommandQueue();
                }
            } else if( previousCheckbox == deepmikoto.home.checkboxes.migrations ){
                if( deepmikoto.home.checkboxes.assetsInstall.is( ':checked' ) ){
                    addCommandToQueue( deepmikoto.home.checkboxes.assetsInstall );
                } else if( deepmikoto.home.checkboxes.asseticDump.is( ':checked' ) ){
                    addCommandToQueue( deepmikoto.home.checkboxes.asseticDump );
                } else {
                    runCommandQueue();
                }
            } else if( previousCheckbox == deepmikoto.home.checkboxes.assetsInstall ){
                if( deepmikoto.home.checkboxes.asseticDump.is( ':checked' ) ){
                    addCommandToQueue( deepmikoto.home.checkboxes.asseticDump );
                } else {
                    runCommandQueue();
                }
            } else {
                runCommandQueue();
            }
        }
        function updateCurrentLog( status_text ){
            deepmikoto.home.miscelanious.deployToolsLog.append(
                deepmikoto.home.miscelanious.deployToolsCurrent.html() + status_text + '<br>'
            );
            deepmikoto.home.miscelanious.deployToolsCurrent.html( '' );
        }
        function runCommandQueue()
        {
            deepmikoto.home.miscelanious.deployToolsCurrent.html( 'Executing ...' );
            var popup = openPopup( command_queue );
            if( popup != null ){
                popup.onbeforeunload = function (){
                    popup = undefined;
                    updateCurrentLog( 'Done!' );
                    deepmikoto.home.miscelanious.deployToolsLog.append( 'FINISH' );
                };
            } else {
                updateCurrentLog( 'Nothing to execute!' );
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
function enableCKEditor( textarea )
{
    if( textarea.length > 0 ){
        /** @namespace CKEDITOR */
        CKEDITOR.replace( textarea.attr( 'id' ) );
    }
}

function openPopup( command_queue )
{
    if( command_queue.length > 0 ){
        var leftPosition, topPosition, width = 750, height = 550;
        //Allow for borders.
        leftPosition = (window.screen.width / 2) - ((width / 2 ) + 10);
        //Allow for title and status bars.
        topPosition = (window.screen.height / 2) - ((height / 2) + 50);
        //Open the window.
        return window.open(
            deepmikoto.home.ajaxUrls.COMMAND_EXEC + '/' + JSON.stringify( command_queue ), "Window2", "status=no,height="
            + height + ",width=" + width + ",resizable=yes,left=" + leftPosition + ",top=" + topPosition + ",screenX="
            + leftPosition + ",screenY=" + topPosition + ",toolbar=no,menubar=no,location=no,directories=no,address=no"
        );
    } else {
        return null;
    }
}