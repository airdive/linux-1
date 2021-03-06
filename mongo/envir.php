<?php

/**
    mongo 64位linux
    mongo 版本 2.6.5
    ssh工具 putty.exe
    文本编辑器 vim sublime

    https://github.com/mongodb/mongo.git
    download zip
    ssh 上传 mongo-r2.6.5.zip

    cd
    ls
    unzip mongo-r2.6.5.zip
    cd ./mongo-r2.6.5
    scons all
    scons 自动构建工具
    yum -y install scons

    1.下载安装包
	wget http://fastdl.mongodb.org/linux/mongodb-linux-i686-1.8.2.tgz
	下载完成后解压缩压缩包
	tar zxf mongodb-linux-i686-1.8.2.tgz
	 
	2. 安装准备
	将mongodb移动到/usr/local/server/mongdb文件夹
	mv mongodb-linux-i686-1.8.2 /usr/local/mongodb
	 
	创建数据库文件夹与日志文件
	mkdir /usr/local/mongodb/data
	touch /usr/local/mongodb/logs

	cd /usr/local/mongodb/bin
	. /mongod -h
*/