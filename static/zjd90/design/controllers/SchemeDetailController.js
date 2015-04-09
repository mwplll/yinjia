/**
 * file:
 * ver:
 * auth: zyc
 * update: 2014/12/4
 * description:
 */


var rooms = [];
var designCtr;
// 设计方案详情
var commentCtr;
var design_id;
require([
    'UtilController',
    'CarouselPlugin',
    'PagerPlugin'
], function(AjaxFunc){
    design_id = AjaxFunc.getQueryStringByName('design_id');
    var pd = {
        design_id: design_id
    };
    AjaxFunc.getAction({
        url: Global_URL['getDesignDetails'],
        data: pd,
        callback: function(result){
            result.data = result.data || [];
            result.data.housetype.pic = image_base + result.data.housetype.pic + THUMB_SIZE['schema'];
            // 补充数据模型
            var mainpic = result.data.designschema['main_pic'];

            var pics = [];
            avalon.each(result.data.designrooms, function(i, item){
                if ( item['design_pic'] == mainpic)
                    rooms.splice( 0, 0, { name: item['room_name'], thumbUrl: image_base + item['design_pic'] + THUMB_SIZE['schema']});
                else {
                    rooms.push({
                        name: item['room_name'],
                        size: item['room_area'],
                        thumbUrl: image_base + item['design_pic']
                    });
                }
            });

            avalon.each(rooms, function(i, item) {
                pics.push(item.thumbUrl);
            });

            var house_area = Number(result.data.housetype.gross_area);

            result.data['unit_price'] = 0;
            if(house_area){
                result.data['unit_price'] = (Number(result.data.designschema.total_price) / house_area).toFixed(2);
            }

            initCarousel(rooms, pics, result.data);
            avalon.scan();
        }
    });
    commentCtr = avalon.define({
        $id: 'CommentListController',
        list: [1,2,3,4],
        pager: {
            currentPage: 1,
            perPages: 3,
            totalPages: 0,
            totalItems: 10,
            showJumper: false,
            onJump:function(e, data) {
                listComment(data.currentPage);
            }
        },
        $skipArray: ['pager']
    });
    avalon.scan();
    listComment(1);
});

function initCarousel(arr, pics, text){
    designCtr = avalon.define("SchemeDetailController", function(vm) {
        vm.list = avalon.mix([], true, arr);
        vm.carousel_id = 'carousel1';
        vm.design_id = design_id;
        vm.city_id = text.housetype.city_id;
        vm.currentIndex = 0;
        vm.text = text;
        vm.$opt1 = {
            pictures: avalon.mix([], true, pics),
            timeout:5000,
            pictureWidth:1170,
            pictureHeight:649,
            autoSlide:false,
            alwaysShowArrow:true,
            alwaysShowSelection: false
        };

        // 加入我的新家计划
        vm.addToMyDesign = function(){
            require(['UtilController'], function(AjaxFunc){
                AjaxFunc.getAction({
                    url: Global_URL['addToMyDesign'],
                    dataType: Global_DataType,
                    data: {design_id: design_id},
                    callback: function(result){
                        require("ArtDialogPlugin", function () {
                            var d = dialog({
                                content: '恭喜! 您已成功找到设计方案',
                                quickClose: false
                            });
                            d.showModal();
                            setTimeout(function(){
                                d.close();
                                location.href = base + '/user/my_scheme.html'
                            },1000)
                        });
                    }
                });
            })
        };

        vm.showHandler = function(index) {
            var mouseevent = {
                type:"click"
            };
            avalon.vmodels[designCtr.carousel_id].selectPic(index,mouseevent);
            designCtr.currentIndex = index;
        };
        vm.slide = function() {
            if ( designCtr.currentIndex >= designCtr.list.length - 1)
                designCtr.currentIndex = 0;
            else
                designCtr.currentIndex += 1;
            var mouseevent = {
                type:"click"
            };
            avalon.vmodels[designCtr.carousel_id].selectPic(designCtr.currentIndex,mouseevent);
        }
    });
}


function listComment(curIndex){
    var pd = {
        start: (curIndex - 1) * commentCtr.pager.perPages,
        limit: commentCtr.pager.perPages
    };

    require(['UtilController'], function(AjaxFunc){
        AjaxFunc.getAction({
            url: Global_URL['getCommentList'],
            data: pd,
            callback: function(result){
                var list = result.data.list || [];
                // 补充数据模型
                avalon.each(list, function(i, item){
                    item['navIndex'] = 0;
                    item['marginLeft'] = 0;
                    item['images'] = [{t:1},{t:1},{t:1},{t:1}];
                });
                commentCtr.list = list;

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