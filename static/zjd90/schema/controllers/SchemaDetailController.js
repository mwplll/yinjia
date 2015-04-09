var schemaCtr;
var commentCtr;
var carouselCtr;
var schema_id = null;
var house_id = null;
var carousel_id = 'carousel1';
var rooms = [];

var pics = [];
require(['UtilController','CarouselPlugin','PagerPlugin'], function(AjaxFunc){
    schema_id = AjaxFunc.getQueryStringByName('schema_id');
    house_id = AjaxFunc.getQueryStringByName('house_id');
    schemaCtr = avalon.define({
        $id: 'SchemaDetailController',

        row: {
            designer: {}
        },
        houseInfo: {},
        currentIndex: 0,

        discount: 0.8,
        edit: false,

        // 加入我的新家计划
        addToMyDesign: function(){
            require(['UtilController'], function(AjaxFunc){
                AjaxFunc.getAction({
                    url: Global_URL['addToMyDesign'],
                    data: {id: schema_id},
                    callback: function(result){
                        require("ArtDialogPlugin", function () {
                            var d = dialog({
                                content: '恭喜! 您已成功找到设计方案',
                                quickClose: false
                            });
                            d.showModal();
                            setTimeout(function(){
                                d.close();
                                location.href = base + '/user/my_schema.html'
                            },1000)
                        });
                    }
                });
            })
        },

        buyHandler: function(){
            alert('TODO');
        },

        editHandler: function(){
            schemaCtr.edit = !schemaCtr.edit;
            if(schemaCtr.edit){
                schemaCtr.discount = 1;
            }else{
                schemaCtr.discount = 0.8;
            }
        }

    });

    commentCtr = avalon.define({
        $id: 'CommentListController',
        list: [],
        pager: {
            currentPage: 1,
            perPages: 7,
            totalPages: 0,
            totalItems: 0,
            showJumper: false,
            onJump:function(e, data) {
                listComment(data.currentPage);
            }
        },
        total: 0,
        $skipArray: ['pager'],

        content: '',
        commentHandler: function () {
            var headerCtr = avalon.vmodels['HeaderController'];
            if(!headerCtr.hasLogin){
                headerCtr.toLogin();
            }else{
                if(!commentCtr.content){
                    Tip.alert("请输入评论内容!");
                    return ;
                }
                require('UtilController', function(AjaxFunc){
                    AjaxFunc.getAction({
                        url:Global_URL['saveComment'],
                        data: {
                            designSchemaId: schema_id,
                            content: commentCtr.content
                        },
                        callback: function(reuslt){
                            listComment(1);
                        }
                    })
                });
            }
        }
    });

    avalon.scan();

    listComment(1);

    initRooms();
    initBase();
    initHouse();
});

function initRooms(callback){
    require(['UtilController'], function(AjaxFunc){
        AjaxFunc.getAction({
            url: Global_URL['getDesignEffect'],
            data: {id: schema_id},
            callback: function(result){
                var rooms = result.data['picList'] || [];
                if(!rooms.length){
                    return;
                }
                var pics = [];
                avalon.each(rooms, function (i, item) {
                    item.thumbUrl = image_base + item.pic + THUMB_SIZE['detail'];
                    pics.push(item.thumbUrl);
                });

                carouselCtr = avalon.define({
                    $id: 'CarouselController',
                    rooms: rooms,
                    $opt1: {
                        pictures: avalon.mix([], true, pics),
                        timeout:5000,
                        pictureWidth:870,
                        pictureHeight:580,
//                        adaptiveWidth: true,
//                        adaptiveHeight: true,

                        autoSlide:true,
                        alwaysShowArrow:false,
                        alwaysShowSelection: false,
                        arrowLeftNormalSrc: '../images/arrows-left-icon.png',
                        arrowRightNormalSrc: '../images/arrows-right-icon.png',
                        arrowLeftHoverSrc: '../images/arrows-left-hover-icon.png',
                        arrowRightHoverSrc: '../images/arrows-right-hover-icon.png'
                    },
                    currentIndex: 0,
                    showHandler: function(index) {
                        var mouseevent = {
                            type:"click"
                        };
                        avalon.vmodels[carousel_id].selectPic(index,mouseevent);
                        carouselCtr.currentIndex = index;
                    },
                    slide: function() {
                        if ( carouselCtr.currentIndex >= carouselCtr.rooms.length - 1)
                            carouselCtr.currentIndex = 0;
                        else
                            carouselCtr.currentIndex += 1;
                        var mouseevent = {
                            type:"click"
                        };
                        avalon.vmodels[carousel_id].selectPic(carouselCtr.currentIndex,mouseevent);
                    }
                });

                avalon.scan();
            }
        });

        AjaxFunc.getAction({
            url: Global_URL['saveView'],
            data:{id: schema_id},
            callback: function(result){

            }
        });
    });
}

function initBase(){
    require(['UtilController'], function(AjaxFunc){
        AjaxFunc.getAction({
            url: Global_URL['getDesignBase'],
            data:{id: schema_id},
            callback:function(result){
                schemaCtr.row = result.data;
            }
        })
    });
}

function initHouse() {
    require(['UtilController'], function(AjaxFunc){
        AjaxFunc.getAction({
            url:Global_URL['getHouseInfoById'],
            data:{id: house_id},
            callback: function(result){
                schemaCtr.houseInfo = result.data;
            }
        })
    });
}

function listComment(curIndex){
    var pd = {
        page: curIndex,
        num: commentCtr.pager.perPages,
        designSchemaId: schema_id
    };

    require(['UtilController'], function(AjaxFunc){
        AjaxFunc.getAction({
            url: Global_URL['getCommentList'],
            data: pd,
            callback: function(result){
                var list = result.data.commentList || [];

                // 补充数据模型
                avalon.each(list, function(i, item){
                    if(item.avatar){
                        item['thumbUrl'] = image_base + item.avatar;
                    }else{
                        item['thumbUrl'] = base + 'images/designer-02.png'
                    }

                    item['content'] = item.content || '无';
                });
                commentCtr.list = list;
                commentCtr.total = result.data.pagination.count;

                commentCtr.pager.currentPage = curIndex;
                commentCtr.pager.totalItems = result.data.pagination.count || list.length;
                commentCtr.pager.totalPages = Math.ceil(commentCtr.pager.totalItems / commentCtr.pager.perPages);
                avalon.vmodels['CommentListPager'].totalItems = commentCtr.pager.totalItems;
                avalon.vmodels['CommentListPager'].totalPages = commentCtr.pager.totalPages;
                avalon.vmodels['CommentListPager'].currentPage = commentCtr.pager.currentPage;
            }
        });
    })
}