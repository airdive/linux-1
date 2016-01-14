<?php

/**
    用户和用户组

    用户 使用操作系统的人
    用户组 具有相同系统权限的一组用户

    /etc/group 存储当前系统中所有用户组信息
    group  :      x       :  123   : abc,def
    组名称 : 组密码占位符 : 组编号 : 组中用户名列表

    /etc/gshadow 存储当前系统中用户组的密码信息
    group  :   *    :          : abc,def
    组名称 : 组密码 : 组管理者 : 组中用户名列表

    /etc/passwd 存储当前系统中所有用户的信息
    user   :      x     :    123   :     456    :      xxx     : /home/user : /bin/bash
    用户名 : 密码占位符 : 用户编号 : 用户组编号 : 用户注释信息 : 用户主目录 : shell 类型

    /etc/shadow 存储当前系统中所有用户的密码信息
    user   :  ... :::::
    用户名 : 密码 :::::

    groupadd sexy
    groupmod -n market sexy
    groupmod -g 668 market
    groupadd -g 888 boss
    useradd -d /home/xxx imooc

    主要组与附属组
    用户可以同时属于多个组
    一个主要组 多个附属组
*/