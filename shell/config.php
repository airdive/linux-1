<?php

/**
    环境变量配置文件

    环境变量配置文件简介
    环境变量配置文件的功能
    其他配置文件

    变量类型
    用户自定义变量 (本地变量)
    环境变量
    预定义变量
    位置参数变量

    环境变量作用 定义每个用户的操作环境
    已学的环境变量 path psl

    source 命令
    [root@localhost ~]# source 配置文件或[root@localhost ~]# .配置文件
    修改配置文件后 必须注销重新登录才能生效 使用source 命令可以不用重新登录

    环境变量配置文件简介
    PATH HISTSIZE PS1 HOSTNAME 等环境变量写入对应的环境变量配置文件夹
    环境变量配置文件中主要是定义对系统操作环境生效的系统默认环境变量 如 PATH 等
    /etc/parfile
    /etc/profile.d/*.sh
    ~/.bash_profile
    ~/.bashrc
    /etc/bashrc
*/