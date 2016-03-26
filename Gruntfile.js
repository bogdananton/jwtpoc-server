module.exports = function (grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        clean : {
            dist : ['public/*/*', 'public/*/.bower.json', '!public/*/dist']
        }
    });

    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.registerTask('default', ['clean', 'clean']);
};