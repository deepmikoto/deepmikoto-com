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
    runDeployTools  : $( '#run-deploy' ),
    generateSitemaps: $( '#generate-sitemaps' )
};
deepmikoto.home.ajaxUrls = {
    COMMAND_EXEC: /*'/app_dev.php' +*/ '/adminarea/command/execute'
};
deepmikoto.home.commands = {
    GIT_PULL_MASTER   : 'git-pull-master',
    COMPOSER_INSTALL  : 'composer-install',
    CACHE_CLEAR       : 'cache-clear',
    MIGRATIONS        : 'migrations-migrate',
    ASSETS_INSTALL    : 'assets-install',
    ASSETIC_DUMP      : 'assetic-dump',
    GENERATE_SITEMAP : 'generate-sitemap'
};
deepmikoto.home.miscelanious = {
    deployToolsLog      : $( '#command-log' ),
    deployToolsCurrent  : $( '#current-command' )
};