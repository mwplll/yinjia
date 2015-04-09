var exec = require('child_process').exec;
var path = require('path');
var gulp = require('gulp');
var Q = require('q');


comm = {};

comm.gen_doc = function (f) {
    var deferred = Q.defer();

    var basename = path.basename(f);
    var dotIndex = basename.indexOf('.');
    var filename = dotIndex != -1 ? basename.slice(0, dotIndex) : basename;

    exec("marked -i " + f + " > html/doc/" + filename + ".html", function (err) {
        if(err) deferred.reject(err);
        deferred.resolve()
    });

    return deferred.promise;
};


module.exports = {
    parse: comm.gen_doc
};
