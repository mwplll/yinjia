# 图片/文件上传API

##1、图片上传
[POST] http://121.40.212.161:8000/data/image/upload

参数      |说明     | 参数可选值  | 可选值说明
---------|---------|---------------------------
type     | 图片类型 | avator      | 用户头像
         |         | house_type  | 户型图
         |         | design_room | 设计方案设计图
         |         | cid_pic | 实名认证的身份证
         |         | goods | 商品图片
         |         | brand_logo | 商品品牌logo
         |         | spec | 商品的规格图片
         |         | design_cad | 设计方案施工图
         |         | article | 文章

file     | 图片文件， input type=file name=file，即 name 为 file 的表单元素 || 

返回

    errorCode: 22000
    data:
        link: xxx
		
##2、文件上传
[POST] http://121.40.212.161:8000/data/file/upload

参数      |说明     | 参数可选值  | 可选值说明
---------|---------|---------------------------
type     | 文件类型 | design_file     | 设计方案施工图工程文件
		|			| design_pdf     |设计方案施工图PDF文件
		 
file     | 文件， input type=file name=file，即 name 为 file 的表单元素 || 		




