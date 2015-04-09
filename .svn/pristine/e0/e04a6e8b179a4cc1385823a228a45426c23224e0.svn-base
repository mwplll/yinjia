/**
 * file:
 * ver:
 * auth: zyc
 * update: 2014/12/2
 * description:
 */
var _dialogs_ =  {'avatar': null};
var userInfoCtr = avalon.define("UserInfoController", function(vm){
    vm.username = '';
    vm.sex = '保密';
    vm.email = '';
    vm.headImageId = '';
    vm.headImageUrl = base + 'images/designer-02.png';

    vm.birthday = '';
    vm.year = '';
    vm.month = '';
    vm.day = '';
    vm.inited = false;
    vm.defaultYears = [];

    vm.content = '';
    vm.plan = '';


    vm.saveHandler = function(){
        var pd = {
            avatar: userInfoCtr.headImageId || null,
            userSex:'',

            userShow: userInfoCtr.content,
            birthday: ''
        };

        if(userInfoCtr.sex == '男'){
            pd['userSex'] = 0;
        }else if(userInfoCtr.sex == '女'){
            pd['userSex'] = 1;
        }else if(userInfoCtr.sex == '保密'){
            pd['userSex'] = 2;
        }

        if(userInfoCtr.year && userInfoCtr.month && userInfoCtr.day){
            pd['birthday'] = userInfoCtr.year + '-' + userInfoCtr.month +  '-' + userInfoCtr.day;
        }

        require(['UtilController'], function(AjaxFunc) {
            AjaxFunc.saveAction({
                url: Global_URL['saveUserInfo'],
                data: pd,
                crossDomain: Global_CrossDomain,
                callback: function (result) {
                    location.reload();
                }
            });
        });

    };
    vm.getDefaultYears = function(){
        var year = new Date().getFullYear();
        var tmp = [];
        for(var i = 0; i < 100; i++){
            tmp.push(year--);
        }
        userInfoCtr.defaultYears = tmp;
    };
    vm.uploadHandler = function(){
        require([
            'ArtDialogPlugin2',
            "text!../../account/views/avatar.html"
        ], function(_, html){
            var d = dialog({
                fixed: true,
                width: 940,
                height: 540,
                content: html
            });
            d.showModal();
            _dialogs_['avatar'] = d;
        });
    };
    vm.init = function(){
        userInfoCtr.getDefaultYears();
        require(['UtilController'], function(AjaxFunc){
            AjaxFunc.getAction({
                url: Global_URL['userInfo'],
                callback: function(result){
                    if(result.errorCode != 22000){
                        return;
                    }
                    if(result.data){
                        userInfoCtr.username = result.data.userName || '';
                        if(result.data.avatar){
                            userInfoCtr.headImageId = result.data.avatar;
                            userInfoCtr.headImageUrl = image_base + userInfoCtr.headImageId;
                        }

                        if(Number(result.data.userSex) == 0){
                            userInfoCtr.sex = '男';
                        }else if(Number(result.data.userSex) == 1){
                            userInfoCtr.sex = '女';
                        }else if(Number(result.data.userSex) == 2){
                            userInfoCtr.sex = '保密';
                        }

                        if(result.data.birthday){
                            var p = result.data.birthday.split('-');
                            userInfoCtr.year = p[0];
                            userInfoCtr.month = Number(p[1]);
                            userInfoCtr.day = Number(p[2]);
                        }
                        userInfoCtr.content = result.data.userShow;
                    }
                }
            })
        });
    };
});

userInfoCtr.init();

/***********************
 * Avatar.swf 回调 JS
 ***********************/
function callJS(re){
    // alert("上传完成，在页面调用JS执行下一步操作");
    if(re.errorCode != 22000){
        require(['ArtDialogPlugin'], function(){
            var d = dialog({
                content: "上传失败",
                quickClose: false
            });
            d.showModal();
            setTimeout(function(){
                d.close();
            },1500);
        });
        return;
    }
    userInfoCtr.headImageUrl = image_base + re.data.link;
    userInfoCtr.headImageId = re.data.link;
    _dialogs_['avatar'].close();
}

function closeHandler(){
    _dialogs_['avatar'].close();
}

function setUploadURL()
{
    //上传头像的url，给as3使用的
    var upload_url = Global_URL['uploadAvatarUrl'];
    return upload_url;
}

/**Parses string formatted as YYYY-MM-DD to a Date object.
 * If the supplied string does not match the format, an
 * invalid Date (value NaN) is returned.
 * @param {string} dateStringInRange format YYYY-MM-DD, with year in
 * range of 0000-9999, inclusive.
 * @return {Date} Date object representing the string.
 */
function parseISO8601(dateStringInRange) {
    var isoExp = /^\s*(\d{4})-(\d\d)-(\d\d)\s*$/,
        date = new Date(NaN), month,
        parts = isoExp.exec(dateStringInRange);

    if(parts) {
        month = +parts[2];
        date.setFullYear(parts[1], month - 1, parts[3]);
        if(month != date.getMonth() + 1) {
            date.setTime(NaN);
        }
    }
    return date;
}