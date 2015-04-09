DROP TABLE IF EXISTS wm_article_category;
DROP TABLE IF EXISTS wm_article;

CREATE TABLE IF NOT EXISTS wm_article_category (
    cat_id INT(11) NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '文章分类全局id',
    cat_name VARCHAR(50) NOT NULL  COMMENT '分类名称',
    cat_father INT(11) NOT NULL  COMMENT '该分类的父类别标识，如果是顶节点设定为0',
    cat_layer CHAR(10) NOT NULL  COMMENT '限定为5层，初始值为00000000,每两位一组，每层最多99个子类别',
    cat_del TINYINT(11) NOT NULL DEFAULT 0 COMMENT '是否删除，0为正常显示，1为删除，2为前台不显示'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章分类表';

CREATE TABLE IF NOT EXISTS wm_article (
    article_id INT(11) NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '文章全局id',
    title VARCHAR(255) NOT NULL  COMMENT '文章标题',
    cat_id INT(11) NOT NULL  COMMENT '文章所属分类',
    content TEXT NULL  COMMENT '文章正文',
    summary TEXT NOT NULL  COMMENT '文章简介',
    author VARCHAR(255) NULL  COMMENT '作者',
    create_time INT(11) NOT NULL COMMENT '创建时间',
    modify_time INT(11) NOT NULL COMMENT '最后修改时间',
    pic TEXT NULL COMMENT '文章主图',
    sort INT(11) NOT NULL DEFAULT 99 COMMENT '排序，默认为99',
    top TINYINT(6) NOT NULL DEFAULT 0 COMMENT '是否置顶，0为否，1为是',
    article_del TINYINT(11) NOT NULL DEFAULT 0 COMMENT '是否删除，0为正常显示，1为删除，2为前台不显示'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章表';