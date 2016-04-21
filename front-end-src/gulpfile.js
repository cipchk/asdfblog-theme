// npm install --save-dev gulp gulp-concat gulp-uglify path gulp-changed gulp-util gulp-sync gulp-ng-html2js gulp-minify-html gulp-inject gulp-livereload gulp-clean gulp-sass gulp-minify-css
var gulp = require('gulp'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    path = require('path'),
    changed = require('gulp-changed'),
    gutil = require('gulp-util'),
    gulpsync = require('gulp-sync')(gulp),
    livereload = require('gulp-livereload'), // Livereload plugin needed: https://chrome.google.com/webstore/detail/livereload/jnihajbhpnppcggbcgedagnkighmdlei
    inject = require("gulp-inject"),
    clean = require("gulp-clean"),
    sass = require("gulp-sass"),
    minifyCSS = require('gulp-minify-css'),
    PluginError = gutil.PluginError;


// LiveReload 端口
var lvr_port = 35735;

// 是否为 产品模式
var isProduction = false;

var paths = {
    js: {
        dist: '../src/js/',
        m: [
            './bower_components/zeptojs/src/zepto.js',
            './bower_components/zeptojs/src/event.js',
            './bower_components/zeptojs/src/selector.js',
            './prism/prism.js',
            './js/*.js'
        ],
        bus: ['./js/*/*.js']
    },
    css: {
        m: [
            './sass/*.scss',
            './prism/prism.css'
        ],
        dist: '../src/',
        name: 'style.css'
    }
};

//---------------
// 任务
//---------------
gulp.task('js:m', function() {
    return gulp.src(paths.js.m)
        .pipe(isProduction ? uglify() : gutil.noop())
        .pipe(concat('m.js'))
        .pipe(gulp.dest(paths.js.dist))
        .on("error", handleError);
});

gulp.task('js:bus', function() {
    return gulp.src(paths.js.bus)
        .pipe(isProduction ? uglify() : gutil.noop())
        .pipe(gulp.dest(paths.js.dist))
        .on("error", handleError);
});

gulp.task('css:m', function() {
    return gulp.src(paths.css.m)
        .pipe(concat(paths.css.name))
        .pipe(sass())
        .on("error", handleError)
        .pipe(isProduction ? minifyCSS({
            keepSpecialComments: 0
        }) : gutil.noop())
        .pipe(gulp.dest(paths.css.dist));
});

gulp.task('start', ['js:m', 'js:bus', 'css:m']);

//---------------
// WATCH
//---------------
gulp.task('watch', function() {
    livereload.listen();

    gulp.watch(paths.js.m, ['js:m']);
    gulp.watch(paths.js.bus, ['js:bus']);
    gulp.watch(paths.css.m, ['css:m']);

    gulp.watch([

        './js/**',
        './less/*.less'

    ]).on('change', function(event) {

        livereload.changed(event.path);

    });

});

// 产品模式
gulp.task('build', ['prod', 'start']);
gulp.task('prod', function() {
    isProduction = true;
});

// default (no minify)
gulp.task('default', gulpsync.sync(['start', 'watch']), function() {

    gutil.log(gutil.colors.cyan('* All Done *'));

});


gulp.task('done', function() {
    console.log('All Done!! You can start editing your code, LiveReload will update your browser after any change..');
});

// Error handler
function handleError(err) {
    console.log(err.toString());
    this.emit('end');
}
