/**
 * Created by MiKoRiza-OnE on 9/3/2015.
 */
var deepmikoto = {};
deepmikoto.home = {};
deepmikoto.coding = {};
deepmikoto.gaming = {};
deepmikoto.photography = {};
deepmikoto.home.checkboxes = {
    gitPullMaster   : $( '#git-pull-master' ),
    cacheClear      : $( '#cache-clear' ),
    composerInstall : $( '#composer-install' ),
    migrations      : $( '#migrations' ),
    assetsInstall   : $( '#assets-install' ),
    asseticDump     : $( '#assetic-dump' )
};
deepmikoto.home.links = {
    fullDeploy      : $( '#full-deploy' )
};
deepmikoto.home.buttons = {
    runDeployTools  : $( '#run-deploy' )
};
deepmikoto.home.ajaxUrls = {
    GIT_PULL_MASTER_URL : '/adminarea/command/git-pull-master',
    COMPOSER_INSTALL_URL: '/adminarea/command/composer-install',
    CACHE_CLEAR_URL     : '/adminarea/command/cache-clear',
    MIGRATIONS_URL      : '/adminarea/command/migrations-migrate',
    ASSETS_INSTALL_URL  : '/adminarea/command/assets-install',
    ASSETIC_DUMP_URL    : '/adminarea/command/assetic-dump'
};
deepmikoto.home.miscelanious = {
    deployToolsLog      : $( '#command-log' ),
    deployToolsCurrent  : $( '#current-command' )
};