"use strict";

const gulp = require("gulp"),
  path = require("path"),
  cwd = path.resolve(__dirname + "/.."),
  theme_folder = `${cwd}/src/web/app/themes/jacket`;

process.setMaxListeners(0);

global.theme = {
  in: "/style/**/*.scss",
  out: "/style",
  base: theme_folder,
};

require("./sass.js");
require("./serve.js");
require("./build.js");

gulp.task("default", gulp.series("serve"));
