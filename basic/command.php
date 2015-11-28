<?php

/**
    [root@localhost ~]#
    root 当前登录用户
    localhost 主机名
    ~ 当前所在目录 (家目录)
    # 超级用户的提示符
    $ 普通用户的提示符

    命令 [选项] [参数]
    注意 个别命令使用不遵循此格式
         当有多个选项时 可以写在一起
         简化选项与完整选项
         -a 等于 -all

    ls [选项][文件或目录]
    选项
         -a 显示所有文件 包括隐藏文件
         -l 显示详细信息
         -d 查看目录属性
         -h 人性化显示文件大小
         -i 显示 inode

    -rw-r--r--
    - 文件类型 (- 文件 d 目录 l 软链接)
    rw- u所有者 
    r-- g所属组
    r-- o其他人

    r 读 4 w 写 2 x 执行 1 
    文件类型有七种 文件 目录 软链接 块设备文件 字符设备文件 套接字文件和管道文件

    目录相关命令
    建立目录
    mkdir -p [目录名]
    -p 递归创建
    命令英文原意 make directories
    mkdir -p apeng/peng (mkdir apeng cd ./apeng mkdir peng)

    切换所在目录 cd
    cd [目录]
    命令英文原意 change directory
    简化操作
    cd ~  进入当前用户的家目录
    cd 
    cd -  进入上次目录
    cd .. 进入上一级目录
    cd .  进入当前目录

    ctrl + l 进行清屏

    相对路径 参照当前所在目录 进行查找
    [root@imooc ~]# cd ../usr/local/src/

    绝对路径 从根目录开始指定 一级一级递归查找 在任何目录下 都能进入指定位置
    [root@imooc ~]# cd /etc/

    查询所在目录位置 pwd
    命令英文原意 print working directory

    删除空目录 rmdir
    rmdir [目录名]
    命令英文原意 remove empty directories

    删除文件或目录 rm
    rm -rf [文件或目录]
    命令英文原意 remove
    选项
         -r 删除目录
         -f 强制

    复制命令 cp
    cp [选项] [原文件或目录] [目标目录]
    命令英文原意 copy
    选项
         -r 复制目录
         -p 连带文件属性复制
         -d 若源文件是链接文件 则复制链接属性
         -a 相当于 -pdr

    mv [原文件或目录] [目标目录]
    命令英文原意 move

    常用目录的作用
    /根目录
    /bin 命令保存目录 (普通用户就可以读取的命令)
    /boot 启动目录 启动相关文件
    /dev 设备文件保存目录
    /etc 配置文件保存目录
    /home 普通用户的家目录
    /lib 系统库保存目录
    /mnt 系统挂载目录
    /media 挂载目录

    /root 超级用户的家目录
    /tmp 临时目录
    /sbin 命令保存目录 (超级用户才能使用的目录)
    /proc 直接写入内存的
    /sys
    /usr 系统软件资源目录
         /usr/bin/系统命令 (普通用户)
         /usr/sbin/系统命令 (超级用户)
    /var 系统相关文档内容
*/