var gulp = require('gulp');
var gulpMarked = require('./build/gulp-marked');


var conf = {
    file: {
        doc: {
            input: 'doc/**/*.md',
            output: 'html/doc'
        }
    }
};


gulp.task('dev', function(){
    gulp.watch(conf.file.doc.input, function(e){

        gulp.src(e.path)
            .pipe(gulpMarked({
                concat: {
                    header: 'doc/output_wrapper/header.html',
                    footer: 'doc/output_wrapper/footer.html'
                }
            }))
            .pipe(gulp.dest(conf.file.doc.output));
        console.log("[doc_gen]:" + e.path);

        //return gulp_doc.parse(e.path).then(function() {
        //});
    });
});


gulp.task('doc', function(){
    gulp.src(conf.file.doc.input)
        .pipe(gulpMarked({
            concat: {
                header: 'doc/output_wrapper/header.html',
                footer: 'doc/output_wrapper/footer.html'
            }
        }))
        .pipe(gulp.dest(conf.file.doc.output));
});
