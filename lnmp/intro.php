<?php

/**
ali 上搭建环境
pwd
mkdir lnmp
ls
cd ./lnmp
wget -c http://soft.vpser.net/lnmp/lnmp1.2-full.tar.gz && tar zxf lnmp1.2-full.tar.gz && cd lnmp1.2-full && ./install.sh lnmp
yum info mysql #查看 mysql 的版本
yum info nginx #查看 nginx 的版本
yum info php   #查看 php 的版本

nginx
nginx 安装目录 /usr/local/nginx/
nginx 日志目录 /home/wwwlogs/ (ls /home/wwwlogs/ access.log nginx_error.log)
nginx 配置文件 /usr/local/nginx/conf/nginx.conf

访问 http://120.24.36.66
项目目录 ls /home/wwwroot/default

============================================
ls
mkdir lnmp

下载并安装 lnmp环境
wget -c http://soft.vpser.net/lnmp/lnmp1.2-full.tar.gz && tar zxf lnmp1.2-full.tar.gz && cd lnmp1.2-full && ./install.sh lnmp

LNMP 1.2状态管理: lnmp {start|stop|reload|restart|kill|status}
LNMP 1.2各个程序状态管理: lnmp {nginx|mysql|mariadb|php-fpm|pureftpd} {start|stop|reload|restart|kill|status}
LNMP 1.1状态管理： /root/lnmp {start|stop|reload|restart|kill|status}
Nginx状态管理：/etc/init.d/nginx {start|stop|reload|restart}
MySQL状态管理：/etc/init.d/mysql {start|stop|restart|reload|force-reload|status}
Memcached状态管理：/etc/init.d/memcached {start|stop|restart}
PHP-FPM状态管理：/etc/init.d/php-fpm {start|stop|quit|restart|reload|logrotate}
PureFTPd状态管理： /etc/init.d/pureftpd {start|stop|restart|kill|status}
ProFTPd状态管理： /etc/init.d/proftpd {start|stop|restart|reload}

如重启LNMP，输入命令：/root/lnmp restart 即可，单独重启mysql：/etc/init.d/mysql restart
*/