/**
 * Created by MiKoRiza-OnE on 1/28/2017.
 */
module.exports = function(grunt) {
    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        assetsPath: 'src/DeepMikoto/ApiBundle/Resources',
        adminAssetsPath: 'src/AdminBundle/Resources',
        uglify: {
            front_scripts: {
                files: {
                    'web/js/deepmikoto.js': [
                        '<%=assetsPath%>/public/js/app.js',
                        '<%=assetsPath%>/public/js/vendor/jquery-2.2.2.min.js',
                        '<%=assetsPath%>/public/js/vendor//prism.js',
                        '<%=assetsPath%>/public/js/vendor/json2.js',
                        '<%=assetsPath%>/public/js/vendor/underscore.js',
                        '<%=assetsPath%>/public/js/vendor/backbone.js',
                        '<%=assetsPath%>/public/js/vendor/backbone.marionette.js',
                        '<%=assetsPath%>/public/js/vendor/js.cookie.js',
                        '<%=assetsPath%>/public/js/vendor/lightbox.js',
                        '<%=assetsPath%>/public/js/app/models/*.js',
                        '<%=assetsPath%>/public/js/app/collections/*.js',
                        '<%=assetsPath%>/public/js/app/views/*.js',
                        '<%=assetsPath%>/public/js/app/functions/*.js',
                        '<%=assetsPath%>/public/js/app/_router.js',
                        '<%=assetsPath%>/public/js/app/deepmikoto.js'
                    ]
                }
            }
        },
        sass: {
            dist: {
                files: {
                    'web/css/deepmikoto.css': [
                        '<%=assetsPath%>/public/css/*.css',
                        '<%=assetsPath%>/public/scss/deepmikotoapi.scss',
                        '<%=assetsPath%>/public/scss/media_queries/*.scss'
                    ]
                },
                options: {
                    outputStyle: 'compressed'
                }
            }
        },
        copy: {
            images: {
                cwd: '<%=assetsPath%>/public/images',
                expand: true,
                src: '**',
                dest: 'web/bundles/images/'
            },
            adminFonts: {
                cwd: '<%=adminAssetsPath%>/public/fonts',
                expand: true,
                src: '**',
                dest: 'web/css/fonts/'
            },
            fonts: {
                cwd: '<%=assetsPath%>/public/fonts',
                expand: true,
                src: '**',
                dest: 'web/fonts/'
            }
        },
        watch: {

        }
    });

    // Load the plugins.
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-copy');

    // Default task(s).
    grunt.registerTask('w', ['copy', 'cssmin', 'sass', 'uglify', 'watch']);
    grunt.registerTask('compile', ['sass', 'uglify']);
};
