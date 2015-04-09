/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-4-2
 * Time: 上午10:27
 * To change this template use File | Settings | File Templates.
 */

// 工具函数
Ext.ToolUtil = {

    getWindowHeight: function getWindowHeight() {
        var de = document.documentElement;
        return (de && de.clientHeight) || document.body.clientHeight;
    },

    getWindowWidth: function getWindowHeight() {
        var de = document.documentElement;
        return (de && de.clientWidth) || document.body.clientWidth;
    },

    getHashParam: function(){
        var hash = (!window.location.hash)?null:window.location.hash;
        if(!hash){
            return null;
        }
        return hash.split("#")[1]
    },

    createGoodsTreeModel: function(nodes){
        function getTree(list) {
            var gc = function(parentid) {
                var cn = [];
                for (var i = 0; i < list.length; i++) {
                    var n = list[i];
                    if(n.father_id == parentid){
                        n.id = Number(n.id);
                        n.categoryId = n.id;
                        n.text = n.name;
                        n.enable = Number(n.del);
                        n.parentId = n.father_id;
                        n.children = gc(n.id);
                        if(!n.children.length){
                            n.leaf = true;
                        }
                        cn.push(n);
                    }
                }
                return cn;
            };
            return gc(0);
        }
        return getTree(nodes);
    },

    createArticleTreeModel: function(nodes){
        function getTree(list) {
            var gc = function(parentid) {
                var cn = [];
                for (var i = 0; i < list.length; i++) {
                    var n = list[i];
                    if(n.fatherId == parentid){
                        n.id = Number(n.id);
                        n.categoryId = n.id;
                        n.text = n.name;
                        n.enable = Number(n.state);
                        n.parentId = n.fatherId;
                        n.children = gc(n.id);
                        if(!n.children.length){
                            n.leaf = true;
                        }
                        cn.push(n);
                    }
                }
                return cn;
            };
            return gc(0);
        }
        return getTree(nodes);
    },

    createDesignTreeModel: function(nodes){
        function getTree(list) {
            var gc = function(parentid) {
                var cn = [];
                for (var i = 0; i < list.length; i++) {
                    var n = list[i];
                    if(n.fatherId == parentid){
//                        n.id = n.id;
                        n.categoryId = n.id;
                        n.text = n.name;
                        n.enable = Number(n.state);
                        n.parentId = n.fatherId;
                        n.children = gc(n.id);
                        if(!n.children.length){
                            n.leaf = true;
                        }
                        cn.push(n);
                    }
                }
                return cn;
            };
            return gc(0);
        }
        return getTree(nodes);
    },

    /**
     * 规格数组的组合
     * @param array   [[], [], []]
     */
    combineArray: function(array){
        var result = [];
        var len = array.length;
        if(!len){
            return [];
        }
        var me = this, i = 1;
        if(len < 2){
            var xx = [];
            for(var x = 0; x < array[0].length; x++){
                xx.push([array[0][x]]);
            }
            return xx;
        }

        result = array[0];
        while(i < len){
            result = me._combineTwo(result, array[i++]);
        }
        return result;
    },

    _combineTwo: function(a, b){
        var result = [];
        for(var i = 0;i < a.length; i++){
            var k = [].concat(a[i]);
            for(var j = 0; j < b.length; j++){
                result.push(k.concat(b[j]));
            }
        }
        return result;
    }
};