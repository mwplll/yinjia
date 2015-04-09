var CarouselModel = {
    pic:[],
    text:[]
};
var ShowModel = {
    design :[]
};
var listCarousel = function() {
    name = name || '';
    var pd = {
        style: name,
        start: 0 
    };

    require(['UtilController'], function(AjaxFunc){
        AjaxFunc.getAction({
            url: Global_URL['getDesignList'],
            dataType: Global_DataType,
            callback: function(result){
                result.data = result.data || [];

                // 补充数据模型
                avalon.each(result.data, function(i, item){
      
                    console.log(item);
  
                    
                    //CarouselModel['pic'].push(item['design_schema_info'][0]['main_pic']);  
                    if (item['design_schema_info'].length !== 0) {
                        url = image_base + item['design_schema_info']['main_pic'];
                        CarouselModel['pic'].push(url);
                        //console.log(url);          
                    }            
                    CarouselModel['text'].push(item['house_type_info']);

                });


                defineVM();
            }
        });
    })
};


listCarousel();

var defineVM = function() {
    require(["CarouselPlugin"], function() {
        var DesignCtr = avalon.define("DesignController", function(vm) {


            vm.design = ShowModel['design'],
            vm.list = CarouselModel['pic'],
            vm.pic = CarouselModel['pic'];
            vm.text = CarouselModel['text'],
            vm.carousel_id = 'carousel1'
            vm.currentIndex = 0
            vm.$opt1 = {
                pictures:vm.list,
                timeout:5000,
                pictureWidth:990,
                pictureHeight:649,
                autoSlide:false,
                alwaysShowArrow:false,
                alwaysShowSelection:false
            }

            vm.test = function () {
                //location.href = 'scheme-detail.html?building='+vm.text[currentIndex].building_name;

                location.href = 'search-result.html?building=' + vm.text[vm.currentIndex].building_name;
            }

            vm.show = function(id,index) {
                var mouseevent = {
                    type:"click"
                }
                avalon.vmodels[id].selectPic(index,mouseevent);
                vm.currentIndex = index;
            }
            vm.slide = function() {
                if ( vm.currentIndex == vm.pic.length - 1)
                    vm.currentIndex = 0;
                else
                    vm.currentIndex += 1;
                console.log(vm.currentIndex);
                var mouseevent = {
                    type:"click"
                }
                avalon.vmodels[vm.carousel_id].selectPic(vm.currentIndex,mouseevent);

                setTimeout(function() {
                    vm.slide();
                 }, 5000)
            }
        })

        avalon.scan();
        setTimeout(function() {       
            DesignCtr.slide();
         }, 5000) 
    });
}



