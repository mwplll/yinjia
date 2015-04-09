/**
 * Created by zyc on 2014/12/27.
 */
// 发布设计方案 填写基本信息
var publishCtr = avalon.define({
    $id: 'PublishController',
    curStep: 1,
    row: {
        id: null,
        name: '',           // 方案名称
        price: '',          // 设计价格
        deposit: '',        // 定金
        content: '',// 描述
        designSn: '' // 定金
    },
    numBlurHandler: function(type){
        if(type == 'price'){
            var price = Number((Number(publishCtr.row.price) || 0).toFixed(2));
            price = Math.max(0, price);
            publishCtr.row.price = price;
        }else if(type == 'deposit'){
            var deposit = Number((Number(publishCtr.row.deposit) || 0).toFixed(2));
            deposit = Math.max(0, deposit);
            publishCtr.row.deposit = deposit;
        }
    },
    saveHandler: function(callback){
        var pd = {
            houseTypeId: houseCtr.houseId,
            name: publishCtr.row.name,
            id: publishCtr.row.id,
//            price: publishCtr.row.price,
//            deposit: publishCtr.row.deposit,
            content: publishCtr.row.content
        };

        var re = validateHandler(pd);
        var msg = null;
        if(!re.success){
            msg = re.message;
        }
        if(msg){
            Tip.alert(msg);
            return;
        }
        require(['UtilController'], function(AjaxFunc){
            AjaxFunc.saveAction({
                url: Global_URL['publishDesignBase'],
                data: pd,
                crossDomain: Global_CrossDomain,
                method: 'POST',
                callback: function(result){
                    if(!design_id){
                        design_id = result.data;
                    }
                   location.href = 'publish-effect.html?house_id='+  houseCtr.houseId + '&design_id=' + design_id;
                }
            });
        });
    }
});
var design_id = null;
require(['UtilController'], function(AjaxFunc){
    design_id = AjaxFunc.getQueryStringByName('design_id');
    if(!design_id){
        return;
    }
    publishCtr.row.id = design_id;
    AjaxFunc.getAction({
        url: Global_URL['getDesignBase'],
        data: {id: design_id},
        callback: function(result){
            publishCtr.row['name'] = result.data['name'];
            publishCtr.row['price'] = result.data['price'];
            publishCtr.row['deposit'] = result.data['deposit'];
            publishCtr.row['designSn'] = result.data['designSn'];
            publishCtr.row['content'] = result.data['content'];
        }
    });
});
function validateHandler(pd){
    var fg = true, msg = '';
    if(!pd.name){
        fg = false;
        msg = '请填写设计方案名称';
        return {
            success: fg,
            message: msg
        }
    }
    return{
        success: true
    }
}