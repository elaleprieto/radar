module.exports = (grunt) ->

	# Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		uglify: {
			options: {
				banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
			},
			build: {
				src: ['js/app.js'
					, 'js/vendors/bootstrap-datepicker.js'
					, 'js/vendors/bootstrap-timepicker.js'
					, 'js/controllers/events_controller.js'
					, 'js/controllers/categories_controller.js'
					, 'js/directives.js'
					, 'js/filters.js'
					, 'js/styles.js'
					, 'js/vendors/jquery.cookie.js'
				]
				dest: 'js/radar.min.js'
			}
		}

		coffee: {
			# compile: {
				# files: {
					# # 'js/.js': 'path/to/source.coffee', # 1:1 compile
					# 'js/pedidos/index_an.js': 'coffeescript/pedidos/index_an.coffee' # 1:1 compile
					# #'path/to/another.js': ['path/to/sources/*.coffee', 'path/to/more/*.coffee'] # compile and concat into single file
				# }
			# }
			glob_to_multiple: {
				expand: true,
				cwd: 'coffeescript/',
				src: ['**/*.coffee'],
				dest: 'js/',
				ext: '.js'
			}
		}

		compass: {
			dev: {
				options: {
					config: 'config.rb'
				}
			}
		}

		watch: {
			options: {
				livereload: true,
			},
			css: {
				files: ['sass/**/*.sass'],
				tasks: ['compass'],
			}
			js: {
				files: ['coffeescript/**/*.coffee'],
				tasks: ['coffee'],
			}
			ugly: {
				files: ['js/**/*.js', '!js/radar.min.js'],
				tasks: ['uglify'],
			}
		}
	})

	# Load the plugin that provides the "uglify" task.
	grunt.loadNpmTasks('grunt-contrib-uglify')
	
	grunt.loadNpmTasks('grunt-contrib-coffee')
	grunt.loadNpmTasks('grunt-contrib-compass')
	grunt.loadNpmTasks('grunt-contrib-watch')

	# Default task(s).
	# grunt.registerTask('default', ['uglify'])
	grunt.registerTask('default', ['watch'])