/* eslint-disable import/no-extraneous-dependencies */
const gulp = require('gulp');
const svgSprite = require('gulp-svg-sprite');
const through = require('through2');
const stylelint = require('stylelint');
const path = require('path');
const fs = require('fs');

// Create icons
const svgspriteConfig = {
  mode: {
    symbol: {
      prefix: '#icon-',
      sprite: 'icon-sprite',
      example: false,
    },
  },
};

// Sprite-Task (unverändert): erzeugt symbol-Sprite
gulp.task('icons:sprite', () => (
  gulp.src('src/icons/**/*.svg')
    .pipe(svgSprite(svgspriteConfig))
    .pipe(gulp.dest('static/icons'))
));

// Einzel-SVGs werden nur von fest im SCSS-Code verdrahteten mask-image-
// Referenzen gebraucht (z.B. Button-Pfeile) - anders als der Sprite (der
// jedes Icon enthalten muss, weil im Editor frei aus allen ~1500 gewählt
// werden kann). Diese Namen stehen fix im Code, nicht in der Datenbank -
// ein reiner Source-Scan ist hier sicher (kein Laufzeit-/DB-Zustand wie bei
// der früheren, verworfenen Sprite-Kürzung).
function getMaskReferencedIconNames() {
  const scssDir = path.join(__dirname, 'src/scss');
  const names = new Set();
  const walk = (dir) => {
    fs.readdirSync(dir, { withFileTypes: true }).forEach((entry) => {
      const full = path.join(dir, entry.name);
      if (entry.isDirectory()) {
        walk(full);
      } else if (entry.name.endsWith('.scss')) {
        const content = fs.readFileSync(full, 'utf8');
        const matches = content.matchAll(/static\/icons\/svg\/([a-zA-Z0-9_-]+)\.svg/g);
        Array.from(matches, (m) => m[1]).forEach((name) => names.add(name));
      }
    });
  };
  walk(scssDir);
  return names;
}

// Copy-Task: kopiert nur die tatsächlich per CSS-Maske referenzierten
// Einzel-SVGs nach static/icons/svg/, statt aller ~1500.
gulp.task('icons:copy', () => {
  const usedNames = getMaskReferencedIconNames();
  fs.rmSync(path.join(__dirname, 'static/icons/svg'), { recursive: true, force: true });
  return gulp.src('src/icons/**/*.svg')
    .pipe(through.obj((file, enc, cb) => {
      const name = path.basename(file.path, '.svg');
      cb(null, usedNames.has(name) ? file : null);
    }))
    .pipe(gulp.dest('static/icons/svg'));
});

// List-Task: schreibt eine JSON-Liste aller Icon-Namen (fürs Icon-Picker
// im Block-Editor) - läuft bei jedem Icon-Build mit, damit die Liste nie
// von Hand gepflegt werden muss.
gulp.task('icons:list', (done) => {
  const dir = path.join(__dirname, 'src/icons');
  const names = fs.readdirSync(dir)
    .filter((file) => file.endsWith('.svg'))
    .map((file) => file.replace(/\.svg$/, ''))
    .sort();

  fs.mkdirSync(path.join(__dirname, 'static/icons'), { recursive: true });
  fs.writeFileSync(
    path.join(__dirname, 'static/icons/icon-list.json'),
    JSON.stringify(names),
  );
  done();
});

// Kombi-Task: Sprite + Kopien + Liste
gulp.task('icons', gulp.parallel('icons:sprite', 'icons:copy', 'icons:list'));

// Simple SCSS task placeholder (Webpack handles SCSS build in this project)
gulp.task('scss', (done) => done());

// Lint helper using stylelint Node API
function lint(shouldFail = false) {
  const files = path.join(__dirname, 'src/scss/**/*.scss');
  return stylelint
    .lint({
      files,
      formatter: 'string',
    })
    .then((result) => {
      if (result.output) {
        // eslint-disable-next-line no-console
        console.log(result.output);
      }
      const errored = result.errored;
      if (shouldFail && errored) {
        throw new Error('SCSS lint failed.');
      }
    });
}

// Lint Task
gulp.task('scss:lint', () => lint());
gulp.task('scss:lint:fail', () => lint(true));

// Watch Task
gulp.task(
  'scss:watch',
  gulp.series('scss', 'scss:lint', 'icons', () => {
    gulp.watch(
      [
        'src/scss/**/*.scss',
        'src/icons/*.*',
      ],
      { interval: 500 },
      gulp.series('scss', 'scss:lint', 'icons'),
    );
  }),
);
