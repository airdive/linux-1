<?php

/**
    阿里云服务器 安装 yii2
    yum info php (要求 php 版本 5.5)
    更新 php
    cd
    ls
    cd ./lnmp
    cd ./lnmp1.2-full
    ./upgrade.sh php
    http://www.php.net/downloads.php #找要更新的版本号
    输入要更新的版本号

    token 过期
    创建一个新的token
    composer config --global github-oauth.github.com token值
    composer config --global github-oauth.github.com dedeef5aafd16f05d2ca1901a8a92b8fa584b93d

    删除 composer
    rm -rf ./composer
    rm -rf /usr/local/bin/composer

    cd
    ls
    mkdir composer
    ls
    cd ./composer
    安装目录 /root/composer/composer.phar
    mv ./composer.phar /usr/local/bin/composer

    composer create-project yiisoft/yii2-app-advanced /home/wwwroot/default/yii2

    如果遇到 your requirements could not be resolved to an installable set of packages
    删除对应的缓存


    ===================================================================
    linux 环境安装 yii2

    安装composer
    cd
    [root@ ~]mkdir composer #创建 composer 目录
    cd ./composer #进入 composer 目录
    curl -sS https://getcomposer.org/installer | php #下载composer
    ll #查看是否为可执行文件
    mv composer.phar /usr/local/bin/composer #设置为全局变量

    运行如下命令来安装 Composer Asset插件：
    composer global require "fxp/composer-asset-plugin:1.0.0-beta3"

    安装高级的应用程序模板
    composer create-project yiisoft/yii2-app-advanced /home/wwwroot/yii2

    如何提示 exception\... 错误
    find / -name php.ini
    vi /usr/local/php/etc/php.ini
    /disable_functions 找到 disable_functions
    #disable_functions
    :wq
    cd /home/wwwroot
    rm -rf yii2
    重新安装
    ls
    cd ./yii2
    ./init
    0 #开发模式

    修改 nginx 配置文件
    find / -name nginx.conf
    vim
    /root
    /home/wwwroot/yii2/frontend/web
    进入 php.ini 取消 disable_functions
    页面访问 http://192.168.1.101
    出现 vendor\bower/jquery/dist 文件不存在

    vim htdoc/vendor/yiisoft/yii2/base/Application.php
    // 注释掉
    //        Yii::setAlias('@bower', $this->_vendorPath . DIRECTORY_SEPARATOR . 'bower');
    // 替换成
            Yii::setAlias('@bower', $this->_vendorPath . DIRECTORY_SEPARATOR . 'bower' . DIRECTORY_SEPARATOR . 'bower-asset');


    lnmp restart
    # 如何出现 ERROR MySQL server PID file could not be found
    service php-fpm restart
    lnmp restart
*/