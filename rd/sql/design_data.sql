--
-- 数据库: `zjd`
--
-- --------------------------------------------------------
TRUNCATE TABLE `wm_design_pic`;
TRUNCATE TABLE `wm_design_schema`;
TRUNCATE TABLE `wm_design_cad`;
TRUNCATE TABLE `wm_design_room`;
TRUNCATE TABLE `wm_design_material`;
TRUNCATE TABLE `wm_design_comment`;
TRUNCATE TABLE `wm_design_style`;
TRUNCATE TABLE `wm_building`;
TRUNCATE TABLE `wm_company`;
TRUNCATE TABLE `wm_house_type`;
TRUNCATE TABLE `wm_city`;
TRUNCATE TABLE `wm_manual`;

#########################
# insert wm_house_type
#########################
INSERT INTO `wm_house_type` (`house_number`,`house_type_name`,`building_id`,`pic`, `design_num`, `usable_area`, `gross_area`) VALUES
    (
        'ZJHZ0001'
        ,'三室两厅一厨一卫'
        ,1
        ,'house/type/HZ_LH_CJBA_90A.jpg'
        ,0,'63.62','89.00'
    ),
    (
        'ZJHZ0002'
        ,'四室两厅一厨一卫'
        ,1
        ,'house/type/HZ_LH_CJBA_90A.jpg'
        ,0,'120','138'
    ),
    (
        'ZJHZ0001'
        ,'五室两厅一厨两卫'
        ,1
        ,'house/type/HZ_LH_CJBA_90A.jpg'
        ,0,'168','195.00'
    );

######################
# insert wm_building
######################
INSERT INTO `wm_building` (`building_id`, `city_id`, `area_id`, `building_del`,`building_recommend`, `company_id`, `building_name`, `total_design_num`) VALUES
(1, 330100, 330108, 0,1, '1', '春江彼岸', 0),
(6, 330100, 330108, 0,0, '3', '春和钱塘', 0),
(7, 330100, 330104, 0,1, '4', '柏林印象', 0),
(8, 330100, 330105, 0,0, '5', '德信晓宸', 0),
(9, 330100, 330108, 0,0, '6', '官河锦庭', 0),
(10, 330100, 330104, 0,0, '7', '凯旋门', 0),
(11, 330100, 330110, 0,0, '8', '西溪华府', 0),
(12, 330100, 330110, 0,1, '9', '西溪融庄', 0),
(13, 330100, 330106, 0,0, '10', '之江九里', 0),
(14, 330800, 330803, 0,0, '11', '金河湾', 0),
(15, 330700, 330781, 0,0, '12', '金圆上都', 0),
(16, 330100, 330122, 0,0, '13', '桐庐浙富嘉盛住宅', 0);

######################
# insert wm_city
######################
INSERT INTO wm_city (city_id,prov_name,city_name,manual_coe) VALUES
    (330100,'浙江', '杭州',1.20),
    (330500,'浙江', '湖州',1.00),
    (330400,'浙江', '嘉兴',1.00),
    (330700,'浙江', '金华',1.00),
    (331100,'浙江', '丽水',1.00),
    (330200,'浙江', '宁波',1.00),
    (330800,'浙江', '衢州',1.00),
    (330600,'浙江', '绍兴',1.00),
    (331000,'浙江', '台州',1.00),
    (330300,'浙江', '温州',1.00),
    (330900,'浙江', '舟山',1.00);

######################
# insert wm_manual
######################
INSERT INTO wm_manual (design_style_id,manual_name,manual_price) VALUES
    (1,'水电基础装饰部分',30.55),
    (1,'泥水基础装饰部分',50.20),
    (1,'木作基础装饰部分',25.30),
    (1,'油漆基础装饰部分',23.20),
    (1,'其他杂项（搬运、清理、打扫）',10.00),
    (2,'水电基础装饰部分',70.55),
    (2,'泥水基础装饰部分',60.20),
    (2,'木作基础装饰部分',35.30),
    (2,'油漆基础装饰部分',34.20),
    (2,'其他杂项（搬运、清理、打扫）',23.00);

######################
# insert wm_company
######################
INSERT INTO `wm_company` (`company_id`, `company_name`) VALUES
(1, '龙湖'),
(2, '金河湾'),
(3, '浅谈房产'),
(4, '德信房产'),
(5, '德信'),
(6, '中天'),
(7, '滨江'),
(8, '中海'),
(9, '绿城'),
(10, '华润'),
(11, '万华'),
(12, '金圆'),
(13, '浙富');

######################
# insert design schema
######################
INSERT INTO wm_design_schema
    (design_schema_id,design_style_id,design_name,design_sn,house_type_id, view_num,like_num,comment_num,design_price, design_deposit,estimate_price,user_id,main_pic,design_schema_del,design_schema_recommend)
     VALUES
    (1,1,'印家金牌设计师设计，高端大气上档次',1,1,12,6,0,2999,1499,876,2,'design/room/HZ_LH_CJBA_90A_KT.jpg',0,1),
    (2,1,'JUST FOR TEST，名称',1,2,20,15,0,3999,1999,1200,2,'design/room/HZ_LH_CJBA_138A_ZW.jpg',0,1),
    (4,2,'我是方案名称最多20个字2',2,2,28,15,0,3999,1999,1180,2,'design/room/HZ_LH_CJBA_138B_KT.jpg',0,1),
    (5,2,'我是方案名称最多20个字3',3,2,22,15,0,3999,1999,1500,2,'design/room/HZ_LH_CJBA_138C_KT.jpg',0,1),
    (3,2,'我是方案名称最多20个字4',1,3,35,18,0,7999,3999,1800,2,'design/room/HZ_LH_CJBA_190A_CT.jpg',0,1);

#######################
# insert wm_design_comment
#######################
INSERT INTO wm_design_comment (design_comment_id,design_schema_id, user_id,content) VALUES
    (1, 1, 1, '这是我喜欢的feel,设计师一定是个有丰富生活经验的人，细节考虑很到位'),
    (2, 1, 2, '哈哈，装修出来真是这个样子，那真是极好的');

#######################
# insert wm_design_style
#######################
INSERT INTO wm_design_style (design_style_id,design_style_name) VALUES
    (1,'A档'),
    (2,'B档');

#######################
# insert wm_design_pic
#######################
INSERT INTO wm_design_pic (design_schema_id, design_pic,room_name) VALUES
    (1, 'design/room/HZ_LH_CJBA_90A_CT.jpg', '客厅'),
    (1, 'design/room/HZ_LH_CJBA_90A_KT.jpg', '客厅'),
    (1, 'design/room/HZ_LH_CJBA_90A_WS.jpg', '客厅'),
    (2, 'design/room/HZ_LH_CJBA_138A_ZW.jpg', '客厅'),
    (2, 'design/room/HZ_LH_CJBA_138A_CT.jpg', '客厅'),
    (2, 'design/room/HZ_LH_CJBA_138A_KT.jpg', '客厅'),
    (3, 'design/room/HZ_LH_CJBA_190A_CT.jpg', '客厅'),
    (3, 'design/room/HZ_LH_CJBA_190A_KT.jpg', '客厅'),
    (4, 'design/room/HZ_LH_CJBA_138B_KT.jpg', '客厅'),
    (4, 'design/room/HZ_LH_CJBA_138B_ZW.jpg', '客厅'),
    (5, 'design/room/HZ_LH_CJBA_138C_KT.jpg', '客厅'),
    (5, 'design/room/HZ_LH_CJBA_138C_ZW.jpg', '客厅');

######################
# insert wm_design_room
######################
INSERT INTO wm_design_room (design_room_id,design_schema_id,design_room_name,design_room_area,design_room_type) VALUES
    (1,1,'客厅',10.00,1),
    (2,1,'餐厅',12.00,2),
    (3,1,'主卧',13.00,3),
    (4,1,'卫生间',6.00,8);

######################
# insert wm_design_material
######################
INSERT INTO wm_design_material (design_material_id,design_schema_id,design_room_id,design_material_number,design_material_name,
                                goods_id,products_id,products_num) VALUES
    (1,1,1,'1-1','抛光砖',1,1,2),
    (2,1,1,'1-2','大理石',2,3,1),
    (3,1,2,'1-3','仿古砖',3,5,10),
    (4,2,1,'1-1','抛光砖',1,1,2),
    (5,2,1,'1-2','大理石',2,3,1),
    (6,2,2,'1-3','仿古砖',3,5,10),
    (7,3,1,'1-1','抛光砖',1,1,2),
    (8,3,1,'1-2','大理石',2,3,1),
    (9,3,2,'1-3','仿古砖',3,5,10),
    (10,4,1,'1-1','抛光砖',1,1,2),
    (11,4,1,'1-2','大理石',2,3,1),
    (12,4,2,'1-3','仿古砖',3,5,10),
    (13,5,1,'1-1','抛光砖',1,1,2),
    (14,5,1,'1-2','大理石',2,3,1),
    (15,5,2,'1-3','仿古砖',3,5,10);

