const gulp = require("gulp"),
  sass = require("gulp-sass"),
  cleanCSS = require("gulp-clean-css"),
  autoprefixer = require("gulp-autoprefixer"),
  sourcemaps = require("gulp-sourcemaps"),
  sassGlob = require("gulp-sass-glob");

if (!global.browserSync) {
  global.browserSync = require("browser-sync");
}

gulp.task("sass", () => {
  return gulp
    .src(`${global.theme.base}${global.theme.in}`)
    .pipe(sourcemaps.init())
    .pipe(sassGlob())
    .pipe(sass())
    .on("error", function (error) {
      console.log(error.toString());
      this.emit("end");
    })
    .pipe(cleanCSS())
    .pipe(autoprefixer())
    .pipe(sourcemaps.write("."))
    .pipe(gulp.dest(`${global.theme.base}${global.theme.out}`))
    .pipe(global.browserSync.stream());
});
