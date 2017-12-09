'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass');
var cleanCss = require('gulp-clean-css');
var rename = require("gulp-rename");

gulp.task('sass', function () {
    gulp.src('./public_html/scss/frontend.scss')
        .pipe(sass({style: 'compressed'}))
        .pipe(cleanCss())
        .pipe(gulp.dest('./public_html/css/'));
});