--
-- 数据库: `zjd`
--
-- --------------------------------------------------------

DROP TABLE IF EXISTS wm_category;
DROP TABLE IF EXISTS wm_goods;
DROP TABLE IF EXISTS wm_attribute;
DROP TABLE IF EXISTS wm_attribute_value;
DROP TABLE IF EXISTS wm_goods_attr_rel;
DROP TABLE IF EXISTS wm_provider;
DROP TABLE IF EXISTS wm_goods_pic;
DROP TABLE IF EXISTS wm_goods_pic_rel;
DROP TABLE IF EXISTS wm_brand;
DROP TABLE IF EXISTS wm_spec;
DROP TABLE IF EXISTS wm_spec_pic;
DROP TABLE IF EXISTS wm_products;
DROP TABLE IF EXISTS wm_comment;
DROP TABLE IF EXISTS wm_series;

CREATE TABLE IF NOT EXISTS wm_category (
    cat_id INT(11) NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '商品分类全局id',
    cat_name VARCHAR(50) NOT NULL  COMMENT '分类名称',
    cat_father INT(11) NOT NULL  COMMENT '该分类的父类别标识，如果是顶节点设定为0',
    cat_layer CHAR(10) NOT NULL  COMMENT '限定为5层，初始值为00000000,每两位一组，每层最多99个子类别',
    del TINYINT(11) NOT NULL DEFAULT 0 COMMENT '是否删除，0为正常显示，1为删除，2为前台不显示'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品分类表';

CREATE TABLE IF NOT EXISTS wm_goods (
    goods_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '商品全局id',
    brand_id INT(11) NOT NULL COMMENT '品牌全局id',
    series_id INT(11) NULL COMMENT '系列全局id',
    cat_id INT(11) NOT NULL COMMENT '分类全局id',
    provider_id INT(11) NOT NULL COMMENT '供货商全局id',
    goods_name VARCHAR(50) NOT NULL  COMMENT '商品名称',
    goods_sn VARCHAR(20) NOT NULL  COMMENT '商品的货号',
    sell_price DECIMAL(15,2) NOT NULL  COMMENT '销售价格，0.00',
    market_price DECIMAL(15,2) NOT NULL  COMMENT '市场价格，0.00',
    cost_price DECIMAL(15,2) NOT NULL  COMMENT '成本价格，0.00',
    up_time INT(11)  NULL  COMMENT '上架时间',
    down_time INT(11)  NULL  COMMENT '下架时间',
    create_time INT(11)  NOT NULL  COMMENT '创建时间',
    img VARCHAR(255) NULL COMMENT '商品原图',
    is_del TINYINT(11) NOT NULL DEFAULT 0 COMMENT '是否删除，0为正常，1为删除，2下架，3申请上架',
    period TINYINT(11) NOT NULL DEFAULT 10 COMMENT '所在装修阶段，0为水电，1为泥木，2漆作，3整体安装，10为其他',
    content TEXT NULL COMMENT '商品描述',
    weight DECIMAL(10,2) NOT NULL COMMENT '商品重量，默认为0.00，单位为克',
    unit VARCHAR(10) NOT NULL COMMENT '计量单位',
    visit_num INT(11) NOT NULL DEFAULT 0 COMMENT '浏览数，默认为0',
    favorite_num INT(11) NOT NULL DEFAULT 0 COMMENT '点赞数，默认为0',
    store_num INT(11) NOT NULL DEFAULT 0 COMMENT '库存量，默认为0',
    sale_num INT(11) NOT NULL DEFAULT 0 COMMENT '销量，默认为0',
    comments_num INT(11) NOT NULL DEFAULT 0 COMMENT '评论数，默认为0',
    sort INT(11) NOT NULL DEFAULT 99 COMMENT '排序，默认为99'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品信息表';

CREATE TABLE IF NOT EXISTS wm_attribute (
    attr_id INT(11) NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '商品属性全局id',
    attr_name VARCHAR(50) NOT NULL  COMMENT '商品属性名称',
    cat_id INT(11) NOT NULL  COMMENT '商品分类id，外键'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品属性表';

CREATE TABLE IF NOT EXISTS wm_attribute_value (
    attr_value_id INT(11) NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '商品属性值全局id',
    attr_value VARCHAR(50) NOT NULL  COMMENT '商品属性值',
    attr_id INT(11) NOT NULL  COMMENT '商品属性id，外键'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品属性值表';

CREATE TABLE IF NOT EXISTS wm_goods_attr_rel (
    goods_attr_id INT(11) NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '商品属性关系全局id',
    attr_name VARCHAR(50) NOT NULL  COMMENT '商品属性名称',
    attr_value VARCHAR(50) NOT NULL  COMMENT '商品属性值',
    goods_id INT(11) NOT NULL  COMMENT '商品id，外键',
    attr_value_id INT(11) NOT NULL  COMMENT '商品属性值id，外键'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品属性关系表';

CREATE TABLE IF NOT EXISTS wm_provider (
    provider_id INT(11) NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '供应商全局id',
    provider_name VARCHAR(50) NOT NULL  COMMENT '供应商名称',
    is_del TINYINT(11) NOT NULL DEFAULT 0 COMMENT '是否删除，0为正常显示，1为删除，默认为0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='供应商信息表';

CREATE TABLE IF NOT EXISTS wm_goods_pic (
    pic_id CHAR(32) NOT NULL  PRIMARY KEY COMMENT '商品全局id，为图片路径的md5值',
    pic VARCHAR(255) NOT NULL  COMMENT '图片的URL地址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品图片表';

CREATE TABLE IF NOT EXISTS wm_goods_pic_rel (
    goods_pic_id INT(11) NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '商品图片关系全局id',
    goods_id INT(11) NOT NULL  COMMENT '商品id，外键',
    pic_id CHAR(32) NOT NULL  COMMENT '图片id，为图片URL的md5值，外键'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品图片关系表';

CREATE TABLE IF NOT EXISTS wm_brand (
    brand_id INT(11) NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '品牌全局id',
    brand_name VARCHAR(255) NOT NULL  COMMENT '品牌名称',
    eng_name VARCHAR(255) NOT NULL  COMMENT '品牌英文名称',
    brand_logo VARCHAR(255) NULL  COMMENT '品牌logo存放地址',
    brand_desc TEXT NULL  COMMENT '品牌描述',
    brand_url VARCHAR(255) NULL  COMMENT '品牌官网地址',
    brand_sort INT(11) NOT NULL DEFAULT 0 COMMENT '排序，默认为0',
    is_del TINYINT(11) NOT NULL DEFAULT 0 COMMENT '是否删除，0为正常显示，1为删除，默认为0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='品牌信息表';

CREATE TABLE IF NOT EXISTS wm_series (
    series_id INT(11) NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '商品系列全局id',
    brand_id INT(11) NOT NULL COMMENT '品牌全局id，外键',
    series_name VARCHAR(255) NOT NULL  COMMENT '系列名称',
    is_del TINYINT(11) NOT NULL DEFAULT 0 COMMENT '是否删除，0为正常显示，1为删除，默认为0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品系列信息表';

CREATE TABLE IF NOT EXISTS wm_comment (
    comment_id INT(11) NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '商品评价全局id',
    goods_id INT(11) NOT NULL  COMMENT '商品id，外键',
    user_id INT(11) NOT NULL  COMMENT '用户id，外键',
    comment_time INT(11) NOT NULL  COMMENT '评论时间',
    contents TEXT NOT NULL  COMMENT '评论内容',
    is_del TINYINT(11) NOT NULL DEFAULT 0 COMMENT '是否删除，0为正常显示，1为删除，默认为0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品评论信息表';

CREATE TABLE IF NOT EXISTS wm_spec (
    spec_id INT(11) NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '商品规格全局id',
    spec_name VARCHAR(50) NOT NULL  COMMENT '商品规格名称',
    spec_value TEXT NOT NULL  COMMENT '商品规格值数组',
    spec_type TINYINT(11) NOT NULL DEFAULT 0 COMMENT '规格类型，0为文字，1为图片，默认为0',
    is_del TINYINT(11) NOT NULL DEFAULT 0 COMMENT '是否删除，0为正常显示，1为删除，默认为0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品规格表';

CREATE TABLE IF NOT EXISTS wm_spec_pic (
    spec_pic_id INT(11) NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '商品规格值全局id',
    pic_name VARCHAR(50) NOT NULL  COMMENT '商品规格图片名称',
    spec_pic VARCHAR(255) NOT NULL  COMMENT '商品规格图片',
    create_time INT(11)  NOT NULL  COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品规格图片表';

CREATE TABLE IF NOT EXISTS wm_products (
    products_id INT(11) NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '货品全局id',
    goods_id INT(11) NOT NULL  COMMENT '商品id，外键',
    products_sn VARCHAR(20) NOT NULL  COMMENT '货品编码，采用商品编码加_1的方式',
    sell_price DECIMAL(15,2) NOT NULL  COMMENT '销售价格，0.00',
    market_price DECIMAL(15,2) NOT NULL  COMMENT '市场价格，0.00',
    cost_price DECIMAL(15,2) NOT NULL  COMMENT '成本价格，0.00',
    store_num INT(11) NOT NULL DEFAULT 0 COMMENT '库存量，默认为0',
    weight DECIMAL(10,2) NULL COMMENT '商品重量，默认为0.00，单位为千克',
    spec_array TEXT NOT NULL  COMMENT 'json规格数据'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='货品表，代表某一具体规格组合的商品';







