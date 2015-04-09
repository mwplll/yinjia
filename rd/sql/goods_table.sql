DROP TABLE IF EXISTS wm_goods_type;
DROP TABLE IF EXISTS wm_goods_provider;
DROP TABLE IF EXISTS wm_goods_info;
DROP TABLE IF EXISTS wm_goods_ex_property;
DROP TABLE IF EXISTS wm_goods_ex_info;
DROP TABLE IF EXISTS wm_goods_pic;
DROP TABLE IF EXISTS wm_goods_evaluation;


###########
#   商品分类表
###########
CREATE TABLE wm_goods_type (
    type_id INT NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '全局商品分类ID',
    type_name VARCHAR(50) NOT NULL COMMENT '分类名称',
    type_father INT NOT NULL COMMENT '该分类的父类别标识，如果是顶节点设定为0',
    type_layer CHAR(10) NOT NULL COMMENT '限定为5层，初始值为00000000,每两位一组，每层最多99个子类别'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品分类表';

###########
#   insert wm_goods_type
###########
INSERT INTO wm_goods_type (type_name, type_father, type_layer) VALUES
    ('建材',0, '0000000000'),
    ('灯饰照明',1, '0100000000'),
    ('厨房卫浴',1, '0200000000'),
    ('墙地面材料',1, '0300000000'),
    ('装饰材料',1, '0400000000'),
    ('家具五金',1, '0500000000'),
    ('吊灯',2, '0101000000'),
    ('落地灯',2, '0102000000'),
    ('装饰灯',2, '0103000000'),
    ('淋浴花洒',2, '0201000000'),
    ('浴缸',2, '0202000000'),
    ('墙纸',2, '0301000000'),
    ('华艺',3, '0101010000'),
    ('雷士照明',3, '0101020000'),
    ('飞利浦',3, '0102010000'),
    ('东联',3, '0102020000');


########################################
#   供货厂商表
#######################################
CREATE TABLE wm_goods_provider (
    prov_id INT NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '全局供货商ID',
    prov_name VARCHAR(100) NOT NULL COMMENT '供货商名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='供货厂商表';

###########
#   insert wm_goods_provider
###########
INSERT INTO wm_goods_provider (prov_name) VALUES ('浙江王老五建材有限公司');


#########################################
#   商品信息表
#########################################
CREATE TABLE wm_goods_info (
    goods_id INT NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '全局商品ID',
    goods_name VARCHAR(100) NOT NULL COMMENT '商品名称',
    goods_unit VARCHAR(10) NOT NULL COMMENT '商品单位',
    goods_type INT NOT NULL COMMENT '商品分类ID，外键，对应wm_goods_type.type_id',
    goods_info TEXT NULL COMMENT '商品描述信息',
    goods_provider INT NOT NULL COMMENT '供货商ID，外键，对应wm_goods_provider.prov_id',
    goods_stock INT NOT NULL default 0 COMMENT '库存量',
    buy_price DECIMAL(18,2) NOT NULL default 0 COMMENT '进货价格',
    sell_price DECIMAL(18,2) NOT NULL default 0 COMMENT '出售价格',
    disc_price DECIMAL(18,2) NOT NULL default 0 COMMENT '优惠价格',
    eval_num INT NOT NULL default 0 COMMENT '评价数',
    like_num INT NOT NULL default 0 COMMENT '喜欢数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品信息表';

###########
#   insert wm_goods_info
###########
INSERT INTO wm_goods_info (goods_id,goods_name,goods_unit,goods_type,goods_provider,sell_price,disc_price) VALUES
    (0,'华艺灯饰 现代时尚简约 餐厅吊灯卧室过道阳台太阳花水晶灯具 ','台',13,0,87.00,59.00),
    (1,'华艺灯饰 现代时尚简约 餐厅吊灯卧室过道阳台太阳花水晶灯具 ','台',13,0,837.00,58.00),
    (2,'华艺灯饰 现代时尚简约 餐厅吊灯卧室过道阳台太阳花水晶灯具 ','台',13,0,817.00,52.00),
    (3,'华艺灯饰 现代时尚简约 餐厅吊灯卧室过道阳台太阳花水晶灯具 ','台',13,0,827.00,3.00),
    (4,'华艺灯饰 现代时尚简约 餐厅吊灯卧室过道阳台太阳花水晶灯具 ','台',13,0,87.00,32.00),
    (5,'华艺灯饰 现代时尚简约 餐厅吊灯卧室过道阳台太阳花水晶灯具 ','台',13,0,897.00,32.00),
    (6,'华艺灯饰 现代时尚简约 餐厅吊灯卧室过道阳台太阳花水晶灯具 ','台',13,0,867.00,229.00),
    (7,'华艺灯饰 现代时尚简约 餐厅吊灯卧室过道阳台太阳花水晶灯具 ','台',13,0,857.00,67.00),
    (8,'华艺灯饰 现代时尚简约 餐厅吊灯卧室过道阳台太阳花水晶灯具 ','台',13,0,837.00,439.00),
    (9,'华艺灯饰 现代时尚简约 餐厅吊灯卧室过道阳台太阳花水晶灯具 ','台',13,0,827.00,59.00),
    (10,'华艺灯饰 现代时尚简约 餐厅吊灯卧室过道阳台太阳花水晶灯具 ','台',13,0,857.00,529.00),
    (11,'华艺灯饰 现代时尚简约 餐厅吊灯卧室过道阳台太阳花水晶灯具 ','台',13,0,827.00,5319.00),
    (12,'华艺灯饰 现代时尚简约 餐厅吊灯卧室过道阳台太阳花水晶灯具 ','台',13,0,887.00,549.00),
    (13,'华艺灯饰 现代时尚简约 餐厅吊灯卧室过道阳台太阳花水晶灯具 ','台',13,0,897.00,569.00),
    (14,'华艺灯饰 现代时尚简约 餐厅吊灯卧室过道阳台太阳花水晶灯具 ','台',13,0,817.00,539.00),
    (15,'华艺灯饰 现代时尚简约 餐厅吊灯卧室过道阳台太阳花水晶灯具 ','台',13,0,807.00,519.00),
    (16,'华艺灯饰 现代时尚简约 餐厅吊灯卧室过道阳台太阳花水晶灯具 ','台',13,0,827.00,529.00),
    (17,'雷士照明（NVC） 现代时尚LED餐厅灯具 NUD2299-4 ','台',14,0,2919.00,1299.00);

########################################
#   商品额外属性表 用于存放商品规格
#######################################
CREATE TABLE wm_goods_ex_property (
    expr_id INT NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '全局商品额外属性ID',
    expr_name VARCHAR(200) NOT NULL COMMENT '商品额外属性名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品额外属性表';

###########
#   insert wm_goods_ex_property
###########
INSERT INTO wm_goods_ex_property (expr_name) VALUES ('尺码');

########################################
#   商品额外信息表
#######################################
CREATE TABLE wm_goods_ex_info (
    exin_id INT NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '全局商品额外信息ID',
    goods_id INT NOT NULL COMMENT '所属商品ID，外键',
    expr_id INT NOT NULL COMMENT '商品额外属性ID，外键',
    property_value VARCHAR(200) NOT NULL COMMENT '商品额外属性值'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品额外信息表';

###########
#   insert wm_goods_ex_info
###########
INSERT INTO wm_goods_ex_info (goods_id,expr_id,property_value) VALUES
    (0,1,'银色20cm'),
    (1,1,'银色20cm'),
    (2,1,'银色20cm'),
    (3,1,'银色20cm'),
    (4,1,'银色20cm'),
    (5,1,'银色20cm'),
    (6,1,'银色20cm'),
    (7,1,'银色20cm'),
    (8,1,'银色20cm'),
    (9,1,'银色20cm'),
    (10,1,'银色20cm'),
    (11,1,'银色20cm'),
    (12,1,'银色20cm'),
    (13,1,'银色20cm');

########################################
#   商品图片表
#######################################
CREATE TABLE wm_goods_pic (
    gopic_id INT NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '全局商品图片ID',
    goods_id INT NOT NULL COMMENT '所属商品ID，外键',
    min_pic TEXT NOT NULL COMMENT '商品图片缩略图存储路径',
    max_pic TEXT NOT NULL COMMENT '商品图片大图存储路径',
    is_mainpic BOOLEAN NOT NULL default 0 COMMENT '是否为主图'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品图片表';

###########
#   insert wm_goods_pic
###########
INSERT INTO wm_goods_pic (goods_id,min_pic,max_pic,is_mainpic) VALUES
    (0,
    'http://img12.360buyimg.com/n5/g14/M02/1F/0E/rBEhV1NXMwYIAAAAAAcVh_8DGBAAAMeKgGIXxgABxWf059.jpg',
    'http://img12.360buyimg.com/n1/g14/M02/1F/0E/rBEhV1NXMwYIAAAAAAcVh_8DGBAAAMeKgGIXxgABxWf059.jpg',
    1),
    (0,
    'http://img12.360buyimg.com/n5/g10/M00/09/14/rBEQWFE9f3kIAAAAAASeWMt6mToAAB4fQAQUE0ABJ5w447.jpg',
    'http://img12.360buyimg.com/n1/g10/M00/09/14/rBEQWFE9f3kIAAAAAASeWMt6mToAAB4fQAQUE0ABJ5w447.jpg',
    0),
    (0,
    'http://img12.360buyimg.com/n5/g10/M00/09/14/rBEQWFE9f3kIAAAAAASeWMt6mToAAB4fQAQUE0ABJ5w447.jpg',
    'http://img12.360buyimg.com/n1/g10/M00/09/14/rBEQWFE9f3kIAAAAAASeWMt6mToAAB4fQAQUE0ABJ5w447.jpg',
    0),
    (0,
    'http://img12.360buyimg.com/n5/g10/M00/09/14/rBEQWFE9f3kIAAAAAASeWMt6mToAAB4fQAQUE0ABJ5w447.jpg',
    'http://img12.360buyimg.com/n1/g10/M00/09/14/rBEQWFE9f3kIAAAAAASeWMt6mToAAB4fQAQUE0ABJ5w447.jpg',
    0),
    (0,
    'http://img12.360buyimg.com/n5/g10/M00/09/14/rBEQWFE9f3kIAAAAAASeWMt6mToAAB4fQAQUE0ABJ5w447.jpg',
    'http://img12.360buyimg.com/n1/g10/M00/09/14/rBEQWFE9f3kIAAAAAASeWMt6mToAAB4fQAQUE0ABJ5w447.jpg',
    0),(0,
    'http://img12.360buyimg.com/n5/g14/M02/1F/0E/rBEhV1NXMwYIAAAAAAcVh_8DGBAAAMeKgGIXxgABxWf059.jpg',
    'http://img12.360buyimg.com/n1/g14/M02/1F/0E/rBEhV1NXMwYIAAAAAAcVh_8DGBAAAMeKgGIXxgABxWf059.jpg',
    1),
    (1,
    'http://img12.360buyimg.com/n5/g10/M00/09/14/rBEQWFE9f3kIAAAAAASeWMt6mToAAB4fQAQUE0ABJ5w447.jpg',
    'http://img12.360buyimg.com/n1/g10/M00/09/14/rBEQWFE9f3kIAAAAAASeWMt6mToAAB4fQAQUE0ABJ5w447.jpg',
    0),
    (1,
    'http://img12.360buyimg.com/n5/g10/M00/09/14/rBEQWFE9f3kIAAAAAASeWMt6mToAAB4fQAQUE0ABJ5w447.jpg',
    'http://img12.360buyimg.com/n1/g10/M00/09/14/rBEQWFE9f3kIAAAAAASeWMt6mToAAB4fQAQUE0ABJ5w447.jpg',
    0),
    (1,
    'http://img12.360buyimg.com/n5/g10/M00/09/14/rBEQWFE9f3kIAAAAAASeWMt6mToAAB4fQAQUE0ABJ5w447.jpg',
    'http://img12.360buyimg.com/n1/g10/M00/09/14/rBEQWFE9f3kIAAAAAASeWMt6mToAAB4fQAQUE0ABJ5w447.jpg',
    0),
    (1,
    'http://img12.360buyimg.com/n5/g10/M00/09/14/rBEQWFE9f3kIAAAAAASeWMt6mToAAB4fQAQUE0ABJ5w447.jpg',
    'http://img12.360buyimg.com/n1/g10/M00/09/14/rBEQWFE9f3kIAAAAAASeWMt6mToAAB4fQAQUE0ABJ5w447.jpg',
    0),
    (2,
    'http://img12.360buyimg.com/n5/g14/M02/1F/0E/rBEhV1NXMwYIAAAAAAcVh_8DGBAAAMeKgGIXxgABxWf059.jpg',
    'http://img12.360buyimg.com/n1/g14/M02/1F/0E/rBEhV1NXMwYIAAAAAAcVh_8DGBAAAMeKgGIXxgABxWf059.jpg',
    1),
    (3,
    'http://img12.360buyimg.com/n5/g14/M02/1F/0E/rBEhV1NXMwYIAAAAAAcVh_8DGBAAAMeKgGIXxgABxWf059.jpg',
    'http://img12.360buyimg.com/n1/g14/M02/1F/0E/rBEhV1NXMwYIAAAAAAcVh_8DGBAAAMeKgGIXxgABxWf059.jpg',
    1),
    (4,
    'http://img12.360buyimg.com/n5/g14/M02/1F/0E/rBEhV1NXMwYIAAAAAAcVh_8DGBAAAMeKgGIXxgABxWf059.jpg',
    'http://img12.360buyimg.com/n1/g14/M02/1F/0E/rBEhV1NXMwYIAAAAAAcVh_8DGBAAAMeKgGIXxgABxWf059.jpg',
    1),
    (5,
    'http://img12.360buyimg.com/n5/g14/M02/1F/0E/rBEhV1NXMwYIAAAAAAcVh_8DGBAAAMeKgGIXxgABxWf059.jpg',
    'http://img12.360buyimg.com/n1/g14/M02/1F/0E/rBEhV1NXMwYIAAAAAAcVh_8DGBAAAMeKgGIXxgABxWf059.jpg',
    1),
    (6,
    'http://img12.360buyimg.com/n5/g14/M02/1F/0E/rBEhV1NXMwYIAAAAAAcVh_8DGBAAAMeKgGIXxgABxWf059.jpg',
    'http://img12.360buyimg.com/n1/g14/M02/1F/0E/rBEhV1NXMwYIAAAAAAcVh_8DGBAAAMeKgGIXxgABxWf059.jpg',
    1),
    (7,
    'http://img12.360buyimg.com/n5/g14/M02/1F/0E/rBEhV1NXMwYIAAAAAAcVh_8DGBAAAMeKgGIXxgABxWf059.jpg',
    'http://img12.360buyimg.com/n1/g14/M02/1F/0E/rBEhV1NXMwYIAAAAAAcVh_8DGBAAAMeKgGIXxgABxWf059.jpg',
    1),
    (8,
    'http://img12.360buyimg.com/n5/g14/M02/1F/0E/rBEhV1NXMwYIAAAAAAcVh_8DGBAAAMeKgGIXxgABxWf059.jpg',
    'http://img12.360buyimg.com/n1/g14/M02/1F/0E/rBEhV1NXMwYIAAAAAAcVh_8DGBAAAMeKgGIXxgABxWf059.jpg',
    1),
    (9,
    'http://img12.360buyimg.com/n5/g14/M02/1F/0E/rBEhV1NXMwYIAAAAAAcVh_8DGBAAAMeKgGIXxgABxWf059.jpg',
    'http://img12.360buyimg.com/n1/g14/M02/1F/0E/rBEhV1NXMwYIAAAAAAcVh_8DGBAAAMeKgGIXxgABxWf059.jpg',
    1);

########################################
#   商品评论表
#######################################
CREATE TABLE wm_goods_evaluation (
    eval_id INT NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '全局商品评价ID',
    goods_id INT NOT NULL COMMENT '所属商品ID，外键',
    user_id INT NOT NULL COMMENT '用户ID，外键',
    eval_time datetime NOT NULL COMMENT '评论发表时间',
    eval_cont varchar(200) NOT NULL COMMENT '评论内容'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品评论表';

###########
#   insert wm_goods_evaluation
###########
INSERT INTO wm_goods_evaluation (goods_id,user_id,eval_time,eval_cont) VALUES
    (0,1,'2014-12-19 00:14:19','我是第一个评论哎，三个字，好！好！好！'),
    (0,2,'2014-12-19 00:14:20','这是灯么，这是灯么，我以为是拿来吃泡面的碗'),
    (0,3,'2014-12-19 00:14:21','ls是sb不解释');