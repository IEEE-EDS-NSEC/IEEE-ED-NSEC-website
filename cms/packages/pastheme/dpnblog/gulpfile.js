var gulp = require('gulp');

var less = require('gulp-less');

var min = require('gulp-cssmin');

var rename = require('gulp-rename');

gulp.task('css' , function(){
  gulp.src('build/less/dpnblog.less')
  .pipe(less())
  .pipe(min())
  .pipe(rename('dpnblog.min.css'))
  .pipe(gulp.dest('assets/css'))
})
