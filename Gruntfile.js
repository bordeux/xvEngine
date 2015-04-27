module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        concat: {
            app: {
                options: {
                    separator: ';\n',
                    banner: (function (path) {
                        var file = grunt.file.read(path);
                        return file.substr(0, file.length - 7);
                    })("websrc/config/concat.options.banner.js"),
                    footer: "})(application);",
                    process: eval(grunt.file.read("websrc/config/concat.options.process.js"))
                },
                src: ['websrc/app/**/*.js'],
                dest: 'web/js/application.js'
            },
            vendor: {
                src: ['websrc/vendor/**/*.js'],
                dest: 'web/js/vendor.js'
            }
        },
        uglify: {
            app: {
                files: {
                    'web/js/application.min.js': ['web/js/vendor.js', 'web/js/application.js']
                }
            }
        },
        watch: {
            scripts: {
                files: ['websrc/app/**/*.js'],
                tasks: ['concat:app'],
                options: {
                    interrupt: true,
                    livereload: true
                }
            },
            js: {
                files: ['websrc/vendor/**/*.js'],
                tasks: ['concat:vendor'],
                options: {
                    interrupt: true,
                    livereload: true
                }
            },
            css: {
                files: ['websrc/**/*.scss'],
                tasks: ['sass', 'autoprefixer'],
                options: {
                    interrupt: true,
                    livereload: true
                }
            },
            image: {
                files: ['websrc/img/**/*'],
                tasks: ['imagemin']
            }
        },
        sass: {
            dist: {
                options: {
                    unixNewlines: true,
                    style: 'compressed',
                    sourcemap: 'none'
                },
                files: {
                    'cache/grunt/style_nonprefixed.css': ['websrc/style.scss']
                }
            }
        },
        imagemin: {
            dynamic: {
                files: [{
                    expand: true,
                    cwd: 'websrc/',
                    src: ['img/**/*.{png,jpg,gif}'],
                    dest: 'web/'
                }
                ]
            }
        },
        autoprefixer: {
            options: {
                browsers: ['last 10 versions'],
                map: false
                /*map: {
                 prev: 'public/css/',
                 inline: false
                 }*/
            },
            css: {
                src: 'cache/grunt/style_nonprefixed.css',
                dest: 'web/css/style.css'
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-imagemin');
    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.loadNpmTasks('grunt-contrib-uglify');


    grunt.registerTask('default', ['concat', 'sass', 'autoprefixer', 'watch']);
    grunt.registerTask('build', ['concat', 'sass', 'autoprefixer', 'imagemin', 'uglify']);
    grunt.registerTask('images', ['imagemin']);
};