/**
 * Created by zyc on 2015/2/7.
 */
// 户型信息
var houseCtr = avalon.define({
    $id: 'HouseController',
    row: {
        name: '',
        thumbUrl : '',
        province: '',
        city: '',
        grossArea: '',
        usableArea: '',
        area: ''
    },
    grossArea: '',
    usableArea: '',
    houseId: null,
    cityId: null
});
var house_id = null;
require(['UtilController'], function(AjaxFunc){
    house_id = AjaxFunc.getQueryStringByName('house_id');
    if(!house_id){
        alert("请先选择户型图!");
        return;
    }
    houseCtr.houseId = house_id;
    AjaxFunc.getAction({
        url: Global_URL['getHouseInfoById'],
        data: {id: house_id},
        callback: function(result){
            houseCtr.row['name'] = result.data['name'];
            houseCtr.row['thumbUrl'] = image_base + result.data['pic'] + THUMB_SIZE['schema'];
            houseCtr.row['prov'] = result.data['prov'];
            houseCtr.row['city'] = result.data['city'];
            houseCtr.row['area'] = result.data['area'];
            houseCtr['cityId'] = result.data['cityId'];
            houseCtr['grossArea'] = result.data['grossArea'];
            houseCtr['usableArea'] = result.data['usableArea'];
        }
    });
});