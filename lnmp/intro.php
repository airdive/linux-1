<?php

/**
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