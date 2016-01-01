<?php

/**
    sudo 权限
    root 把本来只能超级用户执行的命令赋予普通用户执行
    sudo 的操作对象是系统命令

    sudo 使用
    [root@localhost ~]# visudo #实际修改的是 /etc/sudoers 文件
    root ALL=(ALL) ALL #用户名 被管理主机的地址= (可使用的身份) 授权命令 (绝对路径)
    #%wheel ALL=(ALL) ALL #%组名 被管理主机的地址= (可使用的身份) 授权命令 (绝对路径)

    授权普通用户可以重启服务器
    [root@localhost ~]# visudo
    user1 ALL=(ALL)  /sbin/shutdown -r now #在文件最后给普通用户添加授权命令
    普通用户使用 sudo /sbin/shutdown -r now

    普通用户执行 sudo 赋予的命令
    [root@localhost ~]# su - user1
    [user1@localhost ~]$ sudo -l #查看可用的 sudo 命令
    [user1@localhost ~]$ sudo /sbin/shutdown -r now #普通用户执行 sudo 赋予的命令

    授权普通用户可以添加其他用户
    [root@localhost ~]# visudo
    user1 ALL=/usr/sbin/useradd
    user1 ALL=/usr/bin/passwd #授予用户设定密码的权限
    user1 ALL=/usr/bin/passwd[A-Za-z]*, !/usr/bin/passwd "", !/usr/bin/passwd root #不能设定 root 用户的密码
*/