/**
 * Created with IntelliJ IDEA.
 * User: zyc
 * Date: 14-4-2
 * Time: 上午10:41
 * To change this template use File | Settings | File Templates.
 */

Ext.ImgAdjustUtil = {
    imgAdjust: function (src, pw, ph, callback) {
        if (!src) {
            return;
        }
        pw = pw || 200;
        ph = ph || 200;

        var img = new Image();
        img.onload = function () {
            var oh = img.height , ow = img.width;
            var r;
            while (oh > ph || ow > pw) {
                r = Math.min(ph / oh, pw / ow);
                oh = r * oh;
                ow = r * ow;
            }
            if (callback) {
                callback(oh, ow);
            }
        };
        img.onerror = function () {
            if (callback) {
                callback(0, 0);
            }
        };
        img.src = src;
    }
};