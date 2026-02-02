const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));

const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const uglify = require('gulp-uglify');
const imagemin = require('gulp-imagemin');
const browserSync = require('browser-sync').create();

// Rutas de origen y destino
const paths = {
  styles: {
    src: 'src/sass/**/*.scss',
    dest: 'dist/css'
  },
  scripts: {
    src: 'src/js/**/*.js',
    dest: 'dist/js'
  },
  images: {
    src: 'src/img/**/*',
    dest: 'dist/img'
  }
};

// Compilar Sass y autoprefijar
function styles() {
	return gulp
	  .src(paths.styles.src)
	  .pipe(sass().on('error', sass.logError))
	  .pipe(autoprefixer())
	  .pipe(cleanCSS())
	  .pipe(gulp.dest(paths.styles.dest))
  }

// Minificar JavaScript
function scripts() {
  return gulp
    .src(paths.scripts.src)
    .pipe(uglify())
    .pipe(gulp.dest(paths.scripts.dest))
}

// Optimizar imágenes
function images() {
  return gulp
    .src(paths.images.src)
    .pipe(imagemin())
    .pipe(gulp.dest(paths.images.dest));
}

function watch() {

	// Observa cambios en los archivos Sass y ejecuta la tarea 'styles'
	gulp.watch(paths.styles.src, styles);
  
	// Observa cambios en los archivos JavaScript y ejecuta la tarea 'scripts'
	gulp.watch(paths.scripts.src, scripts);
  
	// Observa cambios en los archivos de imágenes y ejecuta la tarea 'images'
	gulp.watch(paths.images.src, images);
  }
  
  exports.watch = watch;
  
  // Tarea predeterminada que inicia la observación
  exports.default = gulp.series(styles, scripts, images, watch);
