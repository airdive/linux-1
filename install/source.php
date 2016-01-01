<?php

/**
    源码包与 RPM 的区别

    安装之前的区别 概念上的区别
    安装之后的区别 安装位置不同

    RPM 包安装位置
    是安装在默认位置中
    RPM 包默认安装路径
    /etc/ 配置文件安装目录
    /usr/bin/ 可执行的命令安装目录
    /usr/lib/ 程序所使用的函数库保存位置
    /usr/share/doc/ 基本的软件使用手册保存位置
    /usr/share/man/ 帮助文件保存位置

    源码包安装过程
    rpm --help | grep prefix
    rpm 安装可以指定安装位置 (--prefix=<div>)

    安装位置不同带来的影响
    RPM 包安装的服务可以使用系统服务管理命令 (service) 来管理 例如 RPM 包安装的 apache 的启动方法是
    /etc/rc.d/init.d/httpd start
    service httpd start

    源码包安装位置
    安装在指定位置当中 一般是 /usr/local/软件名/ #源码包没有卸载命令

    而源码包安装的服务则不能被服务管理命令管理 因为没有安装到默认路径中 所以只能用绝对路径进行服务的管理
    /usr/local/apache2/bin/apachectl start
    (只要把安装目录删除掉, 就卸载了对应的软件)

    源码包安装

    安装准备
    安装 C 语言编译器 (rpm -qa | grep gcc 查看是否安装 gcc)
    下载源码包
    http://mirror.bit.edu.cn/apache/httpd/
    npm 包和源码包 选择哪一个呢

    安装注意事项
    源代码保存位置 /usr/local/src/
    软件安装位置 /usr/local/
    如何确定安装过程报错 安装过程停止 并出现 error warning 或 no 的提示

    源码包安装过程
    下载源码包
    解压缩下载的源码包
    进入解压缩目录 

    ./configure 软件配置与检查
    定义需要的功能选项
    检测系统环境是否符合安装要求
    把定义好的功能选项和检测系统环境的信息都写入 makefile 文件 用于后续的编辑
    make 编译 make clean 清除所有编译的文件
    make install 编译安装
    vi INSTALL #打开编译安装文件 查看安装要求

    源码包的卸载
    不需要卸载命令 直接删除安装目录即可 不会遗留任何垃圾文件
*/