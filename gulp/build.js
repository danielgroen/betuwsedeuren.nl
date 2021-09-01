const gulp = require("gulp"),
  fs = require("fs");

gulp.task("clean", (cb) => {
  try {
    fs.unlinkSync(`${global.theme.base}/style/style.css`);
  } catch (err) {}
  try {
    fs.unlinkSync(`${global.theme.base}/style/style.css.map`);
  } catch (err) {}

  cb();
});

gulp.task("build", gulp.series(gulp.series("clean"), gulp.parallel("sass")));
