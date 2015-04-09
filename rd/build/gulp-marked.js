var path = require('path');
var fs = require('fs');
var marked = require('marked');
var renderer = new marked.Renderer();
var through = require('through2');
var gutil = require('gulp-util');
var PluginError = gutil.PluginError;


//console.log(renderer.table.toString()) // = function(){


renderer.table = function(header, body){
    //function (header, body) {
    //    return '<table>\n'
    //    + '<thead>\n'
    //    + header
    //    + '</thead>\n'
    //    + '<tbody>\n'
    //    + body
    //    + '</tbody>\n'
    //    + '</table>\n';
    //}
    return '<div class="row"><div class="col-lg-9"><table class="table table-bordered table-striped">\n'
        + '<thead>\n'
        + header
        + '</thead>\n'
        + '<tbody>\n'
        + body
        + '</tbody>\n'
        + '</table>\n</div></div>';
};


/**
 * 默认的 marked 解析出来的 dom 不带 class, 通过该函数进行处理
 * @param str
 * @returns {*}
 */
var addClass = function(str){
    //console.log(str);
    //var str = str.replace(/<table/g, function(str, p1, p2, offset, s){
    //    return '<table class="table table-bordered table-striped"';
    //});
    return str;
};

const PLUGIN_NAME = 'gulp-marked';

var gulpMarked = function(opt){
    //if (!src) {
    //    throw new PluginError(PLUGIN_NAME, 'Missing marked src text!');
    //}
    //var srcBuf = new Buffer(prefixText); // allocate ahead of time
    function replaceExtension(path) {
        //path = path.replace(/\.coffee\.md$/, '.litcoffee');
        return gutil.replaceExtension(path, '.html');
    }

    return through.obj(function(file, enc, cb){
        if(file.isNull()) return cb(null, file);
        if(file.isStream()) return cb(new PluginError('gulp-marked', 'Streaming not supported'));


        var str = file.contents.toString('utf-8');
        var dest = replaceExtension(file.path);

        // wrapper output with header and footer if needed
        var headerStr = '', footerStr = '';
        if(opt && opt.concat){
            opt.concat.header && (headerStr = fs.readFileSync(opt.concat.header, 'utf-8'));
            opt.concat.footer && (footerStr = fs.readFileSync(opt.concat.footer, 'utf-8'));
        }

        var bodyStr = marked(str, {renderer: renderer});


        var data =  headerStr + addClass(bodyStr) + footerStr;

        //gutil.log("marked file parsed");

        // overwrite file for other gulp plugin to pipe
        file.contents = new Buffer(data);
        file.path = dest;
        cb(null, file);
    });
};


module.exports = gulpMarked;
