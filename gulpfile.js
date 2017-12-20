/**
 * WordPress Plugin Boilerplate Gulp file.
 *
 * Instructions:
 * In command line, cd into the project directory and run these commands:
 *
 * npm init
 * sudo npm install --save-dev gulp gulp-util gulp-load-plugins browser-sync fs path event-stream gulp-plumber
 * sudo npm install --save-dev gulp-sourcemaps gulp-autoprefixer gulp-filter gulp-merge-media-queries gulp-cssnano gulp-sass gulp-concat gulp-uglify-es gulp-notify gulp-imagemin gulp-rename gulp-wp-pot gulp-sort gulp-parker gulp-svgmin gulp-size gulp-readme-to-markdown
 * gulp
 *
 * Implements:
 * 	1. Live reloads browser with BrowserSync.
 * 	2. CSS: Sass to CSS conversion, error catching, Autoprefixing, Sourcemaps, CSS minification, and Merge Media Queries.
 *  3. JS: Concatenates & uglifies JS files.
 *  4. Images: Minifies PNG, JPEG, GIF and SVG images.
 *  5. Watches files for changes in CSS, JS, or PHP.
 *  7. Corrects the line endings.
 *  8. InjectCSS instead of browser page reload.
 *  9. Generates .pot file for i18n and l10n.
 *  10. Generates a Github-compatible README.me file from the README.txt file.
 *
 * @since 		1.0.0
 * @author 		Chris Wilcoxson (@slushman)
 */

/**
 * Project Configuration for gulp tasks.
 */
var project = {
	'url': 'mysafemenu.dev',
	'i18n': {
		'domain': 'restaurants',
		'destFile': 'languages/restaurants.pot',
		'package': 'Restaurants',
		'bugReport': 'https://github.com/slushman/restaurants/issues',
		'translator': 'Chris Wilcoxson <chris@slushman.com>',
		'lastTranslator': 'Chris Wilcoxson <chris@slushman.com>'
	}
};

var watch = {
	php: './*.php',
	admin: {
		scripts: {
			filename: 'restaurants-',
			folders: './admin/js/src/',
			path: './admin/js/',
			source: './admin/js/src/**/*.js',
		},
		styles: './admin/css/src/*.scss',
		svgs: {
			path: './admin/SVGs/',
			source: './admin/SVGs/**/*.svg',
		},
	},
	frontend: {
		scripts: {
			filename: 'restaurants-',
			folders: './frontend/js/src/',
			path: './frontend/js/',
			source: './frontend/js/src/**/*.js',
		},
		styles: './frontend/css/src/*.scss',
		svgs: {
			path: './frontend/SVGs/',
			source: './frontend/SVGs/**/*.svg',
		},
	},
	blocks: {
		scripts: {
			filename: '',
			folders: './blocks/js/src/',
			path: './blocks/js/',
			source: './blocks/js/src/**/*.js',
		},
		styles: './blocks/css/src/**/*.scss'
	}
}

/**
 * Browsers you care about for autoprefixing.
 */
const AUTOPREFIXER_BROWSERS = [
	'last 2 version',
	'> 1%',
	'ie >= 11',
	'ff >= 30',
	'chrome >= 34',
	'safari >= 7',
	'opera >= 23',
	'ios >= 7',
	'android >= 4',
	'bb >= 10'
];

/**
 * Load gulp plugins and assing them semantic names.
 */
var gulp 			= require( 'gulp' ); // Gulp of-course
var gulpLoadPlugins = require( 'gulp-load-plugins' );
var plugins 		= gulpLoadPlugins();
var browserSync 	= require( 'browser-sync' ).create(); // Reloads browser and injects CSS.
var reload 			= browserSync.reload; // For manual browser reload.
var fs 				= require( 'fs' );
var path 			= require( 'path' );
var es 				= require( 'event-stream' );
var uglify 			= require( 'gulp-uglify-es' ).default;

var onError = function(err) { console.log(err); }

/**
 * Returns all the folders in a directory.
 *
 * @see 	https://gist.github.com/jamescrowley/9058433
 */
function getFolders( dir ){
	return fs.readdirSync( dir )
		.filter(function( file ){
			return fs.statSync( path.join( dir, file ) ).isDirectory();
	});
}

/**
 * Processes admin SASS files and creates the admin.css file.
 */
gulp.task( 'adminStyles', function () {
	gulp.src( watch.admin.styles )
		.pipe( plugins.plumber({ errorHandler: onError }) )
		.pipe( plugins.sourcemaps.init() )
		.pipe( plugins.sass( {
			errLogToConsole: true,
			includePaths: ['./sass'],
			outputStyle: 'compact',
			precision: 10
		} ) )
		.pipe( plugins.autoprefixer( AUTOPREFIXER_BROWSERS ) )
		.pipe( plugins.sourcemaps.write ( './', { includeContent: false } ) )
		.pipe( plugins.sourcemaps.init( { loadMaps: true } ) )
		.pipe( plugins.filter( '**/*.css' ) ) // Filtering stream to only css files
		.pipe( plugins.mergeMediaQueries( { log: true } ) ) // Merge Media Queries
		.pipe( plugins.cssnano() )
		.pipe( gulp.dest( './admin/css' ) )

		.pipe( plugins.filter( '**/*.css' ) ) // Filtering stream to only css files
		.pipe( browserSync.stream() ) // Reloads style.css if that is enqueued.
		.pipe( plugins.parker({
			file: false,
			title: 'Parker Results',
			metrics: [
				'TotalStylesheetSize',
				'MediaQueries',
				'SelectorsPerRule',
				'IdentifiersPerSelector',
				'SpecificityPerSelector',
				'TopSelectorSpecificity',
				'TopSelectorSpecificitySelector',
				'TotalUniqueColours',
				'UniqueColours'
			]
		}) )
		.pipe( plugins.notify( { message: 'TASK: "adminStyles" Completed! 💯', onLast: true } ) )
});

/**
 * Processes frontend SASS files and creates the frontend.css file.
 */
gulp.task( 'frontendStyles', function () {
	gulp.src( watch.frontend.styles )
		.pipe( plugins.plumber({ errorHandler: onError }) )
		.pipe( plugins.sourcemaps.init() )
		.pipe( plugins.sass( {
			errLogToConsole: true,
			//includePaths: ['./sass'],
			outputStyle: 'compact',
			precision: 10
		} ) )
		.pipe( plugins.autoprefixer( AUTOPREFIXER_BROWSERS ) )
		.pipe( plugins.sourcemaps.write ( './', { includeContent: false } ) )
		.pipe( plugins.sourcemaps.init( { loadMaps: true } ) )
		.pipe( plugins.filter( '**/*.css' ) ) // Filtering stream to only css files
		.pipe( plugins.mergeMediaQueries( { log: true } ) ) // Merge Media Queries
		.pipe( plugins.cssnano() )
		.pipe( gulp.dest( './frontend/css/' ) )

		.pipe( plugins.filter( '**/*.css' ) ) // Filtering stream to only css files
		.pipe( browserSync.stream() ) // Reloads style.css if that is enqueued.
		.pipe( plugins.parker({
			file: false,
			title: 'Parker Results',
			metrics: [
				'TotalStylesheetSize',
				'MediaQueries',
				'SelectorsPerRule',
				'IdentifiersPerSelector',
				'SpecificityPerSelector',
				'TopSelectorSpecificity',
				'TopSelectorSpecificitySelector',
				'TotalUniqueColours',
				'UniqueColours'
			]
		}) )
		.pipe( plugins.notify( { message: 'TASK: "frontendStyles" Completed! 💯', onLast: true } ) )
});

/**
 * Processes blocks SASS files and creates the CSS files for each block.
 */
gulp.task( 'blockStyles', function () {
	gulp.src( watch.blocks.styles )
		.pipe( plugins.plumber({ errorHandler: onError }) )
		.pipe( plugins.sourcemaps.init() )
		.pipe( plugins.sass( {
			errLogToConsole: true,
			//includePaths: ['./sass'],
			outputStyle: 'compact',
			precision: 10
		} ) )
		.pipe( plugins.autoprefixer( AUTOPREFIXER_BROWSERS ) )
		.pipe( plugins.sourcemaps.write ( './', { includeContent: false } ) )
		.pipe( plugins.sourcemaps.init( { loadMaps: true } ) )
		.pipe( plugins.filter( '**/*.css' ) ) // Filtering stream to only css files
		.pipe( plugins.mergeMediaQueries( { log: true } ) ) // Merge Media Queries
		.pipe( plugins.cssnano() )
		.pipe( gulp.dest( './blocks/css/' ) )

		.pipe( plugins.filter( '**/*.css' ) ) // Filtering stream to only css files
		.pipe( browserSync.stream() ) // Reloads style.css if that is enqueued.
		.pipe( plugins.parker({
			file: false,
			title: 'Parker Results',
			metrics: [
				'TotalStylesheetSize',
				'MediaQueries',
				'SelectorsPerRule',
				'IdentifiersPerSelector',
				'SpecificityPerSelector',
				'TopSelectorSpecificity',
				'TopSelectorSpecificitySelector',
				'TotalUniqueColours',
				'UniqueColours'
			]
		}) )
		.pipe( plugins.notify( { message: 'TASK: "blockStyles" Completed! 💯', onLast: true } ) )
});



/**
 * Creates a minified javascript file for each folder in the admin/src directory.
 */
gulp.task( 'adminScripts', function() {
	var folders = getFolders( watch.admin.scripts.folders );

	var tasks = folders.map( function( folder ) {

		return gulp.src( path.join( watch.admin.scripts.folders, folder, '/*.js' ) )
			.pipe( plugins.plumber({ errorHandler: onError }) )
			.pipe( plugins.sourcemaps.init() )
			.pipe( plugins.concat( watch.admin.scripts.filename + folder + '.js' ) )
			.pipe( gulp.dest( watch.admin.scripts.path ) )
			.pipe( uglify() )
			.pipe( plugins.rename( watch.admin.scripts.filename + folder + '.min.js' ) )
			.pipe( plugins.sourcemaps.write( 'maps' ) )
			.pipe( gulp.dest( watch.admin.scripts.path ) );
	});

	return es.concat.apply( null, tasks )
		.pipe( plugins.notify( { message: 'TASK: "adminScripts" Completed! 💯', onLast: true } ) );
});

/**
 * Creates a minified javascript file for each folder in the admin/src directory.
 */
gulp.task( 'frontendScripts', function() {
	var folders = getFolders( watch.frontend.scripts.folders );

	var tasks = folders.map( function( folder ) {

		return gulp.src( path.join( watch.frontend.scripts.folders, folder, '/*.js' ) )
			.pipe( plugins.plumber({ errorHandler: onError }) )
			.pipe( plugins.sourcemaps.init() )
			.pipe( plugins.concat( watch.frontend.scripts.filename + folder + '.js' ) )
			.pipe( gulp.dest( watch.frontend.scripts.path ) )
			.pipe( uglify() )
			.pipe( plugins.rename( watch.frontend.scripts.filename + folder + '.min.js' ) )
			.pipe( plugins.sourcemaps.write( 'maps' ) )
			.pipe( gulp.dest( watch.frontend.scripts.path ) );
	});

	return es.concat.apply( null, tasks )
		.pipe( plugins.notify( { message: 'TASK: "frontendScripts" Completed! 💯', onLast: true } ) );
});

/**
 * Creates a minified javascript file for each folder in the admin/src directory.
 */
gulp.task( 'blockScripts', function() {
	var folders = getFolders( watch.blocks.scripts.folders );

	var tasks = folders.map( function( folder ) {

		return gulp.src( path.join( watch.blocks.scripts.folders, folder, '/*.js' ) )
			.pipe( plugins.plumber({ errorHandler: onError }) )
			.pipe( plugins.sourcemaps.init() )
			.pipe( plugins.concat( watch.blocks.scripts.filename + folder + '.js' ) )
			.pipe( gulp.dest( watch.blocks.scripts.path ) )
			.pipe( uglify() )
			.pipe( plugins.rename( watch.blocks.scripts.filename + folder + '.min.js' ) )
			.pipe( plugins.sourcemaps.write( 'maps' ) )
			.pipe( gulp.dest( watch.blocks.scripts.path ) );
	});

	return es.concat.apply( null, tasks )
		.pipe( plugins.notify( { message: 'TASK: "blockScripts" Completed! 💯', onLast: true } ) );
});




/**
 * Live Reloads, CSS injections, Localhost tunneling.
 *
 * @link http://www.browsersync.io/docs/options/
 */
gulp.task( 'browser-sync', function() {
	browserSync.init({
		proxy: project.url,
		host: project.url,
		open: 'external',
		injectChanges: true,
		browser: "google chrome"
	});
});

/**
 * Minifies PNG, JPEG, GIF and SVG images in the admin folder.
 */
gulp.task( 'adminImages', function() {
	gulp.src( './admin/images/*.{png,jpg,gif}' )
		.pipe( plugins.plumber({ errorHandler: onError }) )
		.pipe( plugins.imagemin({
			progressive: true,
			optimizationLevel: 3, // 0-7 low-high
			interlaced: true,
			svgoPlugins: [{removeViewBox: false}]
		}))
		.pipe( gulp.dest( './admin/images/' ) )
		.pipe( plugins.notify( { message: 'TASK: "adminImages" Completed! 💯', onLast: true } ) );
});

/**
 * Minifies PNG, JPEG, GIF and SVG images in the frontend folder.
 */
gulp.task( 'frontendImages', function() {
	gulp.src( './frontend/images/*.{png,jpg,gif}' )
		.pipe( plugins.plumber({ errorHandler: onError }) )
		.pipe( plugins.imagemin({
			progressive: true,
			optimizationLevel: 3, // 0-7 low-high
			interlaced: true,
			svgoPlugins: [{removeViewBox: false}]
		}))
		.pipe( gulp.dest( './frontend/images/' ) )
		.pipe( plugins.notify( { message: 'TASK: "frontendImages" Completed! 💯', onLast: true } ) );
});

/**
 * Creates minified SVGs files for the admin.
 */
gulp.task( 'adminSVGs', function() {
	var folders = getFolders( watch.admin.svgs.path );

	var tasks = folders.map( function( folder ) {

		return gulp.src( path.join( watch.admin.svgs.path, folder, '/*.svg' ) )
			.pipe( plugins.plumber({ errorHandler: onError }) )
			.pipe( plugins.svgmin() )
			.pipe( gulp.dest( './admin/SVGs/' + folder + '/' ) )
			.pipe( plugins.notify( { message: 'TASK: "adminSVGs" Completed! 💯', onLast: true } ) );
	});
});

/**
 * Creates minified SVGs files for the frontend.
 */
gulp.task( 'frontendSVGs', function() {
	var folders = getFolders( watch.frontend.svgs.path );

	var tasks = folders.map( function( folder ) {

		return gulp.src( path.join( watch.frontend.svgs.path, folder, '/*.svg' ) )
			.pipe( plugins.plumber({ errorHandler: onError }) )
			.pipe( plugins.svgmin() )
			.pipe( gulp.dest( './frontend/SVGs/' + folder + '/' ) )
			.pipe( plugins.notify( { message: 'TASK: "frontendSVGs" Completed! 💯', onLast: true } ) );
	});
});

/**
 * WP POT Translation File Generator.
 */
gulp.task( 'translate', function () {
	return gulp.src( watch.php )
		.pipe( plugins.plumber({ errorHandler: onError }) )
		.pipe( plugins.sort() )
		.pipe( plugins.wpPot( project.i18n ) )
		.pipe( gulp.dest( project.i18n.destFile ) )
		.pipe( plugins.notify( { message: 'TASK: "translate" Completed! 💯', onLast: true } ) );
});

gulp.task( 'readme', function() {
	return gulp.src( ['README.txt'] )
		.pipe( plugins.readmeToMarkdown({
			details: false,
			extract: {
				'changelog': 'CHANGELOG',
				'Frequently Asked Questions': 'FAQ'
			}
		}))
		.pipe( gulp.dest( '.' ) )
		.pipe( plugins.notify( { message: 'TASK: "readme" Completed! 💯', onLast: true } ) );
});

/**
 * Watches for file changes and runs specific tasks.
 */
gulp.task( 'default', ['adminStyles', 'frontendStyles', 'adminScripts', 'frontendScripts', 'blockScripts', 'adminImages', 'frontendImages', /*'adminSVGs', 'frontendSVGs',*/ 'translate', /*'browser-sync',*/ 'readme'], function () {
	gulp.watch( watch.php, reload ); // Reload on PHP file changes.
	gulp.watch( watch.admin.styles, ['adminStyles', reload] ); // Reload on SCSS file changes.
	gulp.watch( watch.frontend.styles, ['frontendStyles', reload] ); // Reload on SCSS file changes.
	gulp.watch( watch.blocks.styles, ['blockStyles', reload] ); // Reload on SCSS file changes.
	gulp.watch( watch.admin.scripts.source, [ 'adminScripts', reload ] ); // Reload on admin JS file changes.
	gulp.watch( watch.frontend.scripts.source, [ 'frontendScripts', reload ] ); // Reload on frontend JS file changes
	gulp.watch( watch.blocks.scripts.source, [ 'blockScripts', reload ] ); // Reload on blocks JS file changes
	gulp.watch( 'README.txt', ['readme'] );
});
