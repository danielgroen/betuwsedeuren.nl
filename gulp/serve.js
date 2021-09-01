const browserSync = require("browser-sync");

const fs = require("fs"),
  dotenv = require("dotenv"),
  path = require("path"),
  cwd = path.resolve(__dirname + "/.."),
  env = dotenv.parse(fs.readFileSync("../docker/.env")),
  gulp = require("gulp");

gulp.task("watch", () => {
  const options = { interval: 500 };
  gulp.watch(
    `${global.theme.base}${global.theme.in}`,
    options,
    gulp.series("sass")
  );
  gulp.watch(`${global.theme.base}/**/*.php`).on("change", browserSync.reload);
  gulp.watch(`${global.theme.base}/**/*.js`).on("change", browserSync.reload);
});

gulp.task("browser-sync", (cb) => {
  global.browserSync.init({
    proxy: `${env.CNAME}:${env.PORT}`,
    port: 3000,
    ghostMode: false,
  });
  cb();
});

gulp.task(
  "serve",
  gulp.series(
    gulp.parallel("sass"),
    gulp.series("browser-sync"),
    gulp.parallel("watch")
  )
);
