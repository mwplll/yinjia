--
-- 数据库: `zjd`
-- 商品示例数据
--
-- ----------------------------------------------------
TRUNCATE TABLE wm_category;
TRUNCATE TABLE wm_brand;
TRUNCATE TABLE wm_spec;
TRUNCATE TABLE wm_spec_pic;
TRUNCATE TABLE wm_provider;
TRUNCATE TABLE wm_goods;
TRUNCATE TABLE wm_goods_pic;
TRUNCATE TABLE wm_goods_pic_rel;
TRUNCATE TABLE wm_products;
TRUNCATE TABLE wm_series;

##########################
#  插入商品分类数据库
##########################
INSERT INTO wm_category (cat_id, cat_name, cat_father, cat_layer) VALUES
    (1,'墙地面材料',0, '0100000000'),
    (2,'装饰材料',0, '0200000000'),
    (3,'家具五金',0, '0300000000'),
    (4,'灯饰照明',0, '0400000000'),
    (5,'厨房卫浴',0, '0500000000'),
    (6,'地板',1, '0101000000'),
    (7,'瓷砖',1, '0102000000'),
    (8,'分类1.3',1, '0103000000'),
    (9,'实木地板',6, '0101010000'),
    (10,'复合地板',6, '0101020000');

##########################
#  商品品牌数据
##########################
INSERT INTO wm_brand (brand_id, brand_name,eng_name) VALUES
    (1,'品牌A','pinpaiA'),
    (2,'品牌B','pinpaiB'),
    (3,'品牌C','pinpaiC');

##########################
#  商品系列数据
##########################
INSERT INTO wm_series (brand_id, series_name) VALUES
    (1,'A系列'),
    (1,'B系列'),
    (1,'C系列');

##########################
#  商品规格
##########################
INSERT INTO wm_spec (spec_id, spec_name, spec_value, spec_type) VALUES
    (1,'颜色','upload/2015/01/17/20150117114701519.jpg,upload/2015/01/17/20150117114701510.jpg,upload/2015/01/17/20150117114701529.jpg',1),
    (3,'颜色','upload/2015/01/17/20150117114701519.jpg',1),
    (2,'尺寸','7寸,9寸',0);

##########################
#  商品规格图片
##########################
INSERT INTO wm_spec_pic (spec_pic_id, spec_pic, pic_name) VALUES
    (1,'upload/2015/01/17/20150117114701519.jpg','红色'),
    (2,'upload/2015/01/17/20150117114701510.jpg','白色'),
    (3,'upload/2015/01/17/20150117114701529.jpg','蓝色');

##########################
#  供应商
##########################
INSERT INTO wm_provider (provider_id, provider_name) VALUES
    (1,'印家平台自营'),
    (2,'猥琐鸡地板厂'),
    (3,'浙大夜惊魂玻璃厂');

##########################
#  商品
##########################
INSERT INTO wm_goods (goods_id, brand_id,cat_id,provider_id,goods_name,goods_sn,sell_price,market_price,
                      cost_price,img,period,content,weight,unit,is_del,store_num) VALUES
    (1,1,9,1,'白色乳胶漆','123141248789',688,988,500,'http://img12.360buyimg.com/n5/jfs/t625/19/1083242988/184709/2873ceb7/54ae1ca3N0afeff04.jpg',2,'此处为描述信息',200,'桶',0,2),
    (2,1,10,1,'瓷砖','123141248789',631,988,500,'http://img12.360buyimg.com/n5/jfs/t625/19/1083242988/184709/2873ceb7/54ae1ca3N0afeff04.jpg',0,'此处为描述信息',200,'桶',0,132),
    (3,1,10,1,'吊灯','123141248789',68,988,500,'http://img12.360buyimg.com/n5/jfs/t625/19/1083242988/184709/2873ceb7/54ae1ca3N0afeff04.jpg',1,'此处为描述信息',200,'桶',0,32),
    (4,1,9,1,'白色乳胶漆','123141248789',312,988,500,'http://img12.360buyimg.com/n5/jfs/t625/19/1083242988/184709/2873ceb7/54ae1ca3N0afeff04.jpg',3,'此处为描述信息',200,'桶',0,0),
    (5,1,10,1,'白色乳胶漆','123141248789',687,988,500,'http://img12.360buyimg.com/n5/jfs/t625/19/1083242988/184709/2873ceb7/54ae1ca3N0afeff04.jpg',2,'此处为描述信息',200,'桶',1,156),
    (6,1,9,1,'白色乳胶漆','123141248789',688,988,500,'http://img12.360buyimg.com/n5/jfs/t625/19/1083242988/184709/2873ceb7/54ae1ca3N0afeff04.jpg',2,'此处为描述信息',200,'桶',2,34),
    (7,1,9,1,'白色乳胶漆','123141248789',688,988,500,'http://img12.360buyimg.com/n5/jfs/t625/19/1083242988/184709/2873ceb7/54ae1ca3N0afeff04.jpg',2,'此处为描述信息',200,'桶',3,99);

##########################
#  货品
##########################
INSERT INTO wm_products (products_id,goods_id, products_sn,sell_price,market_price,cost_price,store_num,weight,spec_array) VALUES
    (1,1,'123141248789-1',68,28,500,2,200,'[{"id":"1","type":"1","value":"upload/2015/01/17/20150117114701519.jpg","picName":"红色","name":"颜色"},{"id":"2","type":"0","value":"7寸","picName":"","name":"尺寸"}]'),
    (2,1,'123141248789-2',58,28,500,2,200,'[{"id":"1","type":"1","value":"upload/2015/01/17/20150117114701510.jpg","picName":"白色","name":"颜色"},{"id":"2","type":"0","value":"7寸","picName":"","name":"尺寸"}]'),
    (3,1,'123141248789-3',98,28,500,2,200,'[{"id":"1","type":"1","value":"upload/2015/01/17/20150117114701529.jpg","picName":"蓝色","name":"颜色"},{"id":"2","type":"0","value":"7寸","picName":"","name":"尺寸"}]'),
    (4,1,'123141248789-4',948,248,500,2,200,'[{"id":"1","type":"1","value":"upload/2015/01/17/20150117114701519.jpg","picName":"红色","name":"颜色"},{"id":"2","type":"0","value":"9寸","picName":"","name":"尺寸"}]'),
    (5,1,'123141248789-5',928,228,500,2,200,'[{"id":"1","type":"1","value":"upload/2015/01/17/20150117114701510.jpg","picName":"白色","name":"颜色"},{"id":"2","type":"0","value":"9寸","picName":"","name":"尺寸"}]'),
    (6,1,'123141248789-6',968,218,500,2,200,'[{"id":"1","type":"1","value":"upload/2015/01/17/20150117114701529.jpg","picName":"蓝色","name":"颜色"},{"id":"2","type":"0","value":"9寸","picName":"","name":"尺寸"}]');

##########################
#  商品图片
##########################
INSERT INTO wm_goods_pic (pic_id, pic) VALUES
    (MD5('http://img12.360buyimg.com/n5/jfs/t625/19/1083242988/184709/2873ceb7/54ae1ca3N0afeff04.jpg'),'http://img12.360buyimg.com/n5/jfs/t625/19/1083242988/184709/2873ceb7/54ae1ca3N0afeff04.jpg'),
    (MD5('http://img12.360buyimg.com/n1/jfs/t295/276/644098604/234175/c192a138/541cf0d4Nbe413304.jpg'),'http://img12.360buyimg.com/n1/jfs/t295/276/644098604/234175/c192a138/541cf0d4Nbe413304.jpg'),
    (MD5('http://img12.360buyimg.com/n1/g5/M01/01/0B/rBEDik_GAJgIAAAAAAGX85XFQyUAAARCQH1CtIAAZgL768.jpg'),'http://img12.360buyimg.com/n1/g5/M01/01/0B/rBEDik_GAJgIAAAAAAGX85XFQyUAAARCQH1CtIAAZgL768.jpg'),
    (MD5('http://img12.360buyimg.com/n1/g12/M00/0F/0E/rBEQYFNnrn8IAAAAAAhSH9MsbagAAFjbQHmudMACFI3688.jpg'),'http://img12.360buyimg.com/n1/g12/M00/0F/0E/rBEQYFNnrn8IAAAAAAhSH9MsbagAAFjbQHmudMACFI3688.jpg'),
    (MD5('http://img12.360buyimg.com/n1/g5/M01/01/0B/rBEDik_GAJsIAAAAAAGAhjdTagoAAARCQITguAAAYCe507.jpg'),'http://img12.360buyimg.com/n1/g5/M01/01/0B/rBEDik_GAJsIAAAAAAGAhjdTagoAAARCQITguAAAYCe507.jpg');

##########################
#  商品-商品图片关系
##########################
INSERT INTO wm_goods_pic_rel (goods_pic_id, goods_id,pic_id) VALUES
    (1,1,MD5('http://img12.360buyimg.com/n5/jfs/t625/19/1083242988/184709/2873ceb7/54ae1ca3N0afeff04.jpg')),
    (2,1,MD5('http://img12.360buyimg.com/n1/jfs/t295/276/644098604/234175/c192a138/541cf0d4Nbe413304.jpg')),
    (3,1,MD5('http://img12.360buyimg.com/n1/g5/M01/01/0B/rBEDik_GAJgIAAAAAAGX85XFQyUAAARCQH1CtIAAZgL768.jpg')),
    (4,1,MD5('http://img12.360buyimg.com/n1/g12/M00/0F/0E/rBEQYFNnrn8IAAAAAAhSH9MsbagAAFjbQHmudMACFI3688.jpg')),
    (5,1,MD5('http://img12.360buyimg.com/n1/g5/M01/01/0B/rBEDik_GAJsIAAAAAAGAhjdTagoAAARCQITguAAAYCe507.jpg'));