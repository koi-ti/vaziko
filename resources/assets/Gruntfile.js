module.exports = function(grunt) {

	var matchdep = require('matchdep');

	// Filter devDependencies (with config string indicating file to be required)
	matchdep.filterDev('grunt-contrib-*', './package.json').forEach(grunt.loadNpmTasks);

	// Project configuration.
	grunt.initConfig({

		pkg: grunt.file.readJSON('package.json'),

		// uglify
		uglify: {
			options: {
				banner: '/*! <%= pkg.name %> - v<%= pkg.version %> - <%= grunt.template.today("yyyy-mm-dd") %> */\n',
				compress: {
					drop_console: true
				},
				beautify: false,
				mangle: true
			},
			app: {
				files: {
					'../../public/js/vendor.min.js': [
					 	'./bower_components/underscore/underscore.js',
					 	'./bower_components/backbone/backbone.js',
					 	'./bower_components/moment/moment.js',
					 	'./bower_components/moment/locale/es.js',
					 	'./bower_components/alertify.js/dist/js/alertify.js',
					 	'./bower_components/adminLTE/bootstrap/js/bootstrap.min.js',
					 	'./bower_components/bootstrap-validator/dist/validator.min.js',
					 	'./bower_components/adminLTE/dist/js/app.min.js',
					 	'./bower_components/adminLTE/plugins/fastclick/fastclick.min.js',
		    			'./bower_components/adminLTE/plugins/slimScroll/jquery.slimscroll.min.js',
		    			'./bower_components/adminLTE/plugins/iCheck/icheck.min.js',
		    			'./bower_components/adminLTE/plugins/select2/select2.full.min.js',
		    			'./bower_components/adminLTE/plugins/select2/i18n/es.js',
		    			'./bower_components/adminLTE/plugins/input-mask/jquery.inputmask.js',
		    			'./bower_components/adminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js',
		    			'./bower_components/adminLTE/plugins/input-mask/jquery.inputmask.extensions.js',
		    			'./bower_components/datatables.net/js/jquery.dataTables.min.js',
		    			'./bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js',
		    			'./bower_components/datatables.net-buttons/js/dataTables.buttons.js',
		    			'./bower_components/datatables.net-buttons-bs/js/buttons.bootstrap.min.js',
					 	'./scripts/helpers/routes.min.js'
					],
					'../../public/js/app.min.js': [
						'./scripts/helpers/misc.js',
						'./scripts/models/**.js',
						'./scripts/views/**/**.js',
						'./scripts/collections/**/**.js',
						'./scripts/routes.js',
						'./scripts/init.js'
					]
				}
			}
		},

		less: {
			production: {
				files: {
					"./css/app.css": "./css/app.less"
				}
			}
		},

		//Minify css files
		cssmin: {
			target: {
			  files: {
			    '../../public/css/icons.min.css': [
	    			'./bower_components/font-awesome/css/font-awesome.min.css',
		    	],
			    '../../public/css/vendor.min.css': [
	    			'./bower_components/AdminLTE/dist/css/skins/skin-green.min.css',	    			
	    			'./bower_components/AdminLTE/plugins/iCheck/minimal/green.css',    			
	    			'./bower_components/AdminLTE/plugins/select2/select2.min.css',    			
	    			'./bower_components/AdminLTE/dist/css/AdminLTE.min.css',
	    			'./bower_components/datatables.net-bs/css/dataTables.bootstrap.css',	
	    			'./bower_components/datatables.net-buttons-bs/css/buttons.bootstrap.min.css',				
	    			'./bower_components/alertify.js/alertify/css/alertify.css',
			    	'./css/app.css'
		    	]
			  }
			}
		},

		// copiying files
		copy: {
			main: {
				files: [
  					//move jQuery file to public/js/ directory
  					{expand: true, cwd: './bower_components/AdminLTE/plugins/jQuery/', src: ['jQuery-2.1.4.min.js'], dest: '../../public/js/', filter: 'isFile', 
            			rename: function(dest, src) { return dest + 'jquery.min.js'; } },
            		
            		// move awesome fonts to public/css/ directory
					{expand: true, cwd: './bower_components/font-awesome/fonts/', src: ['**'], dest: '../../public/fonts/'},

            		// move fonts to public/fonts/ directory
					{expand: true, cwd: './bower_components/AdminLTE/bootstrap/fonts/', src: ['**'], dest: '../../public/fonts/'},

					// move css min bootstrap public/css/ directory
					{expand: true, cwd: './bower_components/adminLTE/bootstrap/css/', src: ['bootstrap.min.css'], dest: '../../public/css/', filter: 'isFile'},
				]
			},
			img: {
				files: [
					//move iCheck images to public/css
  					{expand: true, cwd: './bower_components/AdminLTE/plugins/iCheck/minimal/', src: ['green**.png'], dest: '../../public/css'},
				]
			},
		},

		// watch tasks
		watch: {
			jsApp: {
				files: [
					'./scripts/**/**/**.js',
					'./scripts/init.js',
					'./scripts/routes.js',
					'./Gruntfile.js'
				],
				tasks: ['uglify:app']			
			}
		}
	});

	// Default task(s).
	grunt.registerTask('default', ['uglify', 'less', 'cssmin', 'copy', 'watch']);

};