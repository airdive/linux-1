<?php

/**
    cp -a yii2 test 
    #修改 nginx.conf 配置文件
    find /usr/local/ -name nginx.conf
    vim /usr/local/nginx/conf/nginx.conf
    修改
    root /home/wwwroot/test/frontend/web;
    yum -y install git
    cd /home/wwwroot/test
    git init
    ssh-keygen
    vim /root/.ssh/id_rsa.pub
    esc ctrl+v y 复制公钥 ---> 保存到 github.com
    git add remote origin git@github.com:pengfen/test.git
    git status
    git add .
    git commit -m "message"
    git push origin master
*/