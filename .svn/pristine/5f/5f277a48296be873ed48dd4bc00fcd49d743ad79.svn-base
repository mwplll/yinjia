/* Demo Note:  This demo uses a FileProgress class that handles the UI for displaying the file name and percent complete.
The FileProgress class is not part of SWFUpload.
*/
define("Upload_Handler", function(){
    return {};
});
/* **********************
 Event Handlers
 These are my custom event handlers to make my
 web application behave the way I went when SWFUpload
 completes different tasks.  These aren't part of the SWFUpload
 package.  They are part of my application.  Without these none
 of the actions SWFUpload makes will show up in my application.
 ********************** */
function fileQueued(file) {
    try {
        var progress = new FileProgress(file, this.customSettings.progressTarget);
        progress.setStatus("等待上传...");
        progress.toggleCancel(true, this);
    } catch (ex) {
        this.debug(ex);
    }

}

function fileQueueError(file, errorCode, message) {
    try {

        if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
//            alert("You have attempted to queue too many files.\n" + (message === 0 ? "You have reached the upload limit." : "You may select " + (message > 1 ? "up to " + message + " files." : "one file.")));
            alert("为了保证您的上传速度，一次最多上传" + message  + "个文件.");
            return;
        }

        var progress = new FileProgress(file, this.customSettings.progressTarget);
        progress.setError();
        progress.toggleCancel(false);

        switch (errorCode) {
            case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
                progress.setStatus("文件大小超出范围.");
                this.debug("Error Code: File too big, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
                break;
            case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
                progress.setStatus("文件大小为空.");
                this.debug("Error Code: Zero byte file, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
                break;
            case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
                progress.setStatus("无效的文件格式.");
                this.debug("Error Code: Invalid File Type, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
                break;
            default:
                if (file !== null) {
                    progress.setStatus("Unhandled Error");
                }
                this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
                break;
        }
    } catch (ex) {
        this.debug(ex);
    }
}

function fileDialogComplete(numFilesSelected, numFilesQueued) {
    try {
        if (numFilesSelected > 0) {
            document.getElementById(this.customSettings.cancelButtonId).disabled = false;

            /* I want auto start the upload and I can do that here */
            this.startUpload();
        }

    } catch (ex)  {
        this.debug(ex);
    }
}

function uploadStart(file) {
    try {
        /* I don't want to do any file validation or anything,  I'll just update the UI and
         return true to indicate that the upload should start.
         It's important to update the UI here because in Linux no uploadProgress events are called. The best
         we can do is say we are uploading.
         */
        var progress = new FileProgress(file, this.customSettings.progressTarget);
        progress.setStatus("正在上传...");
        progress.toggleCancel(true, this);
    }
    catch (ex) {}
    return true;
}

function uploadProgress(file, bytesLoaded, bytesTotal) {
    try {
        var percent = Math.ceil((bytesLoaded / file.size) * 100);

        var progress = new FileProgress(file,  this.customSettings.progressTarget);
        progress.setProgress(percent);
        if (percent === 100) {
            progress.setStatus("");//正在创建缩略图...
            progress.toggleCancel(false, this);
        } else {
            progress.setStatus("正在上传...");
            progress.toggleCancel(true, this);
        }
    } catch (ex) {
        this.debug(ex);
    }
}

function uploadSuccess(file, serverData) {
    try {
        var progress = new FileProgress(file, this.customSettings.progressTarget);
        progress.setComplete();
        progress.setStatus("已完成.");
        progress.toggleCancel(false);
    } catch (ex) {
        this.debug(ex);
    }
}

function uploadError(file, errorCode, message) {
    try {

        var progress = new FileProgress(file, this.customSettings.progressTarget);
        progress.setError();
        progress.toggleCancel(false);

        switch (errorCode) {
            case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
                progress.setStatus("Upload Error: " + message);
                this.debug("Error Code: HTTP Error, File name: " + file.name + ", Message: " + message);
                break;
            case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
                progress.setStatus("Upload Failed.");
                this.debug("Error Code: Upload Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
                break;
            case SWFUpload.UPLOAD_ERROR.IO_ERROR:
                progress.setStatus("Server (IO) Error");
                this.debug("Error Code: IO Error, File name: " + file.name + ", Message: " + message);
                break;
            case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
                progress.setStatus("Security Error");
                this.debug("Error Code: Security Error, File name: " + file.name + ", Message: " + message);
                break;
            case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
                progress.setStatus("Upload limit exceeded.");
                this.debug("Error Code: Upload Limit Exceeded, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
                break;
            case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
                progress.setStatus("Failed Validation.  Upload skipped.");
                this.debug("Error Code: File Validation Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
                break;
            case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
                // If there aren't any files left (they were all cancelled) disable the cancel button
                if (this.getStats().files_queued === 0) {
                    document.getElementById(this.customSettings.cancelButtonId).disabled = true;
                }
                progress.setStatus("取消上传.");
                progress.setCancelled();
                break;
            case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
                progress.setStatus("中止上传.");
                break;
            default:
                progress.setStatus("Unhandled Error: " + errorCode);
                this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
                break;
        }
    } catch (ex) {
        this.debug(ex);
    }
}

function uploadComplete(file) {
    try {
        /*  I want the next upload to continue automatically so I'll call startUpload here */
        if (this.getStats().files_queued > 0) {
            this.startUpload();
        } else {
            var progress = new FileProgress(file,  this.customSettings.progressTarget);
            progress.setComplete();
            progress.setStatus("<font color='red'>所有文件上传完毕!</b></font>");
            progress.toggleCancel(false);
        }
    } catch (ex) {
        this.debug(ex);
    }
}

/* ******************************************
 *	FileProgress Object
 *	Control object for displaying file info
 * ****************************************** */

function FileProgress(file, targetID) {
    this.fileProgressID = file.id;
    this.fileProgressWrapper = document.getElementById(this.fileProgressID);
    this.fileProgressElement = document.getElementById(this.fileProgressID);
    this.cancelElement = document.getElementById("del_pic_" + this.fileProgressID);

    this.reset();
    this.height = this.fileProgressWrapper.offsetHeight;
    this.setTimer(null);
}

FileProgress.prototype.setTimer = function (timer) {
    this.fileProgressElement["FP_TIMER"] = timer;
};
FileProgress.prototype.getTimer = function (timer) {
    return this.fileProgressElement["FP_TIMER"] || null;
};

FileProgress.prototype.reset = function () {
//    this.fileProgressElement.className = "progressContainer";
//
//    this.fileProgressElement.childNodes[2].innerHTML = "&nbsp;";
//    this.fileProgressElement.childNodes[2].className = "progressBarStatus";
//
//    this.fileProgressElement.childNodes[3].className = "progressBarInProgress";
    this.fileProgressElement.childNodes[1].style.width = "0%";

    this.appear();
};
FileProgress.prototype.setProgress = function (percentage) {
//    this.fileProgressElement.className = "progressContainer green";
//    this.fileProgressElement.childNodes[3].className = "progressBarInProgress";
    this.fileProgressElement.childNodes[1].style.width = percentage + "%";

    this.appear();
};
FileProgress.prototype.setComplete = function () {
//    this.fileProgressElement.className = "progressContainer blue";
//    this.fileProgressElement.childNodes[3].className = "progressBarComplete";
    this.fileProgressElement.childNodes[1].style.width = "";
    var oSelf = this;
    this.setTimer(setTimeout(function () {
        oSelf.disappear();
    }, 1000));

};
FileProgress.prototype.setError = function () {
//    this.fileProgressElement.className = "progressContainer red";
//    this.fileProgressElement.childNodes[3].className = "progressBarError";
    this.fileProgressElement.childNodes[1].style.width = "";

    var oSelf = this;
    this.setTimer(setTimeout(function () {
        oSelf.disappear();
    }, 1500));
};
FileProgress.prototype.setCancelled = function () {
//    this.fileProgressElement.className = "progressContainer";
//    this.fileProgressElement.childNodes[3].className = "progressBarError";
    this.fileProgressElement.childNodes[1].style.width = "";

    var oSelf = this;
    this.setTimer(setTimeout(function () {
        oSelf.disappear();
    }, 1500));
};
FileProgress.prototype.setStatus = function (status) {
//    this.fileProgressElement.childNodes[2].innerHTML = status;
};

FileProgress.prototype.toggleCancel = function (show, swfuploadInstance) {
    this.cancelElement.style.display = show ? "block" : "none";
//    if (swfuploadInstance) {
//        var fileID = this.fileProgressID;
//        this.cancelElement.onclick = function () {
//            swfuploadInstance.cancelUpload(fileID);
//            console.log("cancel upload......");
//            return false;
//        };
//    }
};

FileProgress.prototype.appear = function () {
    if (this.getTimer() !== null) {
        clearTimeout(this.getTimer());
        this.setTimer(null);
    }

    if (this.fileProgressWrapper.filters) {
        try {
            this.fileProgressWrapper.filters.item("DXImageTransform.Microsoft.Alpha").opacity = 100;
        } catch (e) {
            // If it is not set initially, the browser will throw an error.  This will set it if it is not set yet.
            this.fileProgressWrapper.style.filter = "progid:DXImageTransform.Microsoft.Alpha(opacity=100)";
        }
    } else {
        this.fileProgressWrapper.style.opacity = 1;
    }

    this.fileProgressWrapper.style.height = "";

//    this.height = this.fileProgressWrapper.offsetHeight;
    this.opacity = 100;
    this.fileProgressWrapper.style.display = "";

};

// Fades out and clips away the FileProgress box.
FileProgress.prototype.disappear = function () {

    var reduceOpacityBy = 15;
    var reduceHeightBy = 4;
    var rate = 30;	// 15 fps

    if (this.opacity > 0) {
        this.opacity -= reduceOpacityBy;
        if (this.opacity < 0) {
            this.opacity = 0;
        }
        if (this.fileProgressWrapper.filters) {
            try {
                this.fileProgressWrapper.filters.item("DXImageTransform.Microsoft.Alpha").opacity = this.opacity;
            } catch (e) {
                // If it is not set initially, the browser will throw an error.  This will set it if it is not set yet.
                this.fileProgressWrapper.style.filter = "progid:DXImageTransform.Microsoft.Alpha(opacity=" + this.opacity + ")";
            }
        } else {
            this.fileProgressWrapper.style.opacity = this.opacity / 100;
        }
    }

    if (this.height > 0) {
        this.height -= reduceHeightBy;
        if (this.height < 0) {
            this.height = 0;
        }

        this.fileProgressWrapper.style.height = this.height + "px";
    }

    if (this.height > 0 || this.opacity > 0) {
        var oSelf = this;
        this.setTimer(setTimeout(function () {
            oSelf.disappear();
        }, rate));
    } else {
        this.fileProgressWrapper.style.display = "none";
        this.setTimer(null);
    }
};
function fadeIn(element, opacity) {
    var reduceOpacityBy = 5;
    var rate = 30;	// 15 fps

    if (opacity < 100) {
        opacity += reduceOpacityBy;
        if (opacity > 100) {
            opacity = 100;
        }

        if (element.filters) {
            try {
                element.filters.item("DXImageTransform.Microsoft.Alpha").opacity = opacity;
            } catch (e) {
                // If it is not set initially, the browser will throw an error.  This will set it if it is not set yet.
                element.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=' + opacity + ')';
            }
        } else {
            element.style.opacity = opacity / 100;
        }
    }

    if (opacity < 100) {
        setTimeout(function () {
            fadeIn(element, opacity);
        }, rate);
    }
}