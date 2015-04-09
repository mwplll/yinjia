#!/bin/sh
#curl -d "author_id=110&"


# 查询
#DESIGN_INFO_API="http://121.40.212.161:8000/data/design/info"
#curl $DESIGN_INFO_API -d "house_id=1000"

DESIGN_EDIT_API="http://121.40.212.161:8000/data/design/edit"
# 插入
curl $DESIGN_EDIT_API -d "op=add&house_id=1&author_id=1&budget_id=1&pic=http://mj100.com/UploadFile/610/201409/zws-1-s-p-023214.jpg&design_price=1000&matl_price=1000&cons_price=2000"