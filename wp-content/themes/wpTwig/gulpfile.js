'use strict';

var gulp 			= require('gulp'),
	sass 			= require('gulp-sass'),
	autoprefixer 	= require('gulp-autoprefixer'),
	concat 			= require('gulp-concat'),
	uglify 			= require('gulp-uglify'),
	jshint 			= require('gulp-jshint'),
	cssnano 		= require('gulp-cssnano'),
	rename 			= require('gulp-rename'),
	babel 			= require('gulp-babel'),
	wait            = require('gulp-wait'),
	browserSync 	= require('browser-sync').create();

var siteUrl = 'wpextra.me';

var paths = {
	vendor	: './assets/vendor',
	bundles	: './assets/bundles',
	min		: './assets/min',
	js 		: './assets/js',
	scss	: './assets/scss',
	temp	: './assets/temp'
}

gulp.task('vendor_css', function () {
	return gulp.src([
			paths.vendor + '/bootstrap/dist/css/bootstrap.css',
			paths.vendor + '/font-awesome/css/font-awesome.css',
			paths.vendor + '/fancybox/source/jquery.fancybox.css',
			paths.vendor + '/slick-carousel/slick/slick.css'
		])
		.pipe(concat('vendor.css'))
		.pipe(gulp.dest(paths.bundles))
		.pipe(rename('vendor.min.css'))
		.pipe(cssnano({zindex: false}))
		.pipe(gulp.dest(paths.min));
});

gulp.task('sass', function () {
	return gulp.src([
			paths.scss + '/*.scss'
		])
		.pipe(wait(1000))
		.pipe(sass({
			outputStyle: 'expanded',
			indentType: 'space',
			indentWidth: 4
		}))
		.pipe(autoprefixer({
			browsers: ['last 10 versions']
		}))
		.pipe(concat('style.css'))
		.pipe(gulp.dest(paths.bundles))
		.pipe(rename('style.min.css'))
		.pipe(cssnano({zindex: false}))
		.pipe(gulp.dest(paths.min));
});

gulp.task('vendor_js', function () {
	return gulp.src([
			paths.vendor + '/bootstrap/dist/js/bootstrap.js',
			paths.vendor + '/fancybox/source/jquery.fancybox.js',
			paths.vendor + '/slick-carousel/slick/slick.js'
		])
		.pipe(concat('vendor.js'))
		.pipe(gulp.dest(paths.bundles))
		.pipe(rename('vendor.min.js'))
		.pipe(uglify())
		.pipe(gulp.dest(paths.min));
});

gulp.task('jshint', function () {
	return gulp.src(paths.js + '/*.js')
		.pipe(jshint({
			esversion: 6
		}))
		.pipe(jshint.reporter('default'))
});

gulp.task('babeljs', ['jshint'], function () {
	return gulp.src( paths.js + '/*.js' )
		.pipe(babel())
		.pipe(gulp.dest( paths.temp + '/babeljs' ));
});

gulp.task('js', ['babeljs'], function () {
	return gulp.src([
			paths.temp + '/babeljs/*.js'
		])
		.pipe(concat('script.js'))
		.pipe(gulp.dest(paths.bundles))
		.pipe(rename('script.min.js'))
		.pipe(uglify())
		.pipe(gulp.dest(paths.min));
});

gulp.task('default', ['vendor_js', 'vendor_css', 'jshint', 'babeljs', 'js', 'sass'], function() {

	browserSync.init({
		proxy: siteUrl
	});

	// Run registerd tasks
	gulp.watch([paths.js + '/*.js'], {cwd: './'}, ['js']);

	gulp.watch([
		paths.scss + '/*.scss',
		paths.scss + '/*/*.scss',
		paths.scss + '/*/*/*.scss'
	], {cwd: './'}, ['sass']);

	gulp.watch([
		'./*.php',
		'./*/*.php',
		'./*/*/*.php',
		'./*/*/*/*.php',
		'./*.twig',
		'./*/*.twig',
		'./*/*/*.twig',
		'./*/*/*/*.twig',
		paths.bundles + '/*.js',
		paths.bundles + '/*.css'
	])
	.on('change', browserSync.reload);

});