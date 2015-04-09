sync:
	git reset --hard HEAD
	git pull

restart:
	sudo service php-fpm restart
	sudo /usr/local/bin/nginx -s reload

deploy: sync restart


push:
	git add -A
	git commit -m "auto commit"
	git push origin


sql_sync:
	@# http://stackoverflow.com/questions/10719662/import-a-local-sql-file-to-mysql-on-a-remote-server-using-ssh-tunnel
	mysql -h 121.40.102.93 -u zjd -proot zjd < sql/order_table.sql
	@#sh import_data/insert_design.sh
	@#sh import_data/insert_design.sh
	@#sh import_data/insert_design.sh


add_house:
	curl "http://121.40.212.161:8000/data/house/edit?act=add" -F "pic=@data/house.jpg" \
	-F name=滨江金色黎明89.00㎡大二期E2-3号楼1单元01室偶数层户型3室1厅1卫1厨 \
	-F build_id=1 -F city_id=1 -F usable_area=98.31 -F gross_area=108 -F room_name[]=客厅 -F room_area[]=13.0 \
	-F room_name[]=厨房 -F room_area[]=12.5 -F room_name[]=卧室 -F room_area[]=19.4


reset:	sql_sync add_house

img_upload:
	curl "http://121.40.212.161:8000/data/image/upload?type=test" -F "pic=@data/house.jpg" \

ftp_upyun:
	ftp v2.ftp.upyun.com
