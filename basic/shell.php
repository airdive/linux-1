<?php

/**
     Shell 基础

     shell 概述
     脚本执行方式
     bash 的基本功能

     shell 是什么
     shell 是一个命令行解释器 它们用户提供了一个向 linux 内核发送请求以便运行程序的界面系统级程序 用户可以用 shell 来启动 挂起 停止甚至是编写一些程序
     shell 还是一个功能相当强大的编程语言 易编写 易调试 灵活性较强 shell 是解释执行的脚本语言 在 shell 中可以直接调用 linux 系统命令

     shell 的分类
     bourne shell 从 1979 起 unix 就开始使用 bourne shell bourne shell 的主文件名为sh

     c shell 主要在 BSD 版的 Unix 系统中使用 其语法和 c 语言相类似而得名

     shell 的两种主要语法类型有 bourne 和 c 这两种语法彼此不兼容 
     bourne 家庭主要包括 sh ksh bash psh zsh
     c 家族主要包括 csh tcsh

     bash bash 与 sh 兼容 现在使用 linux 就是使用 bash 作为用户的基本 shell

     echo 输出命令
     echo [选项] [输出内容]
     -e 支持反斜线控制的字符转换

     \a 输出警告音
     \b 退格键 也就是向左删除键
     \n 换行符
     \r 回车键
     \t 制表符 也就是 Tab 键
     \v 垂直制表符
     \Onnn 按照八进制 ASCII 码表输出字符 其中 0 为数字零 nnn 是三位八进制数
     \xhh  按照十六进制 ASCII 码表输出字符 其中 hh 是两位十六朝进制数

     [root@localhost ~]# echo -e "\e[1;31m \e[0m";
     #\e[1;开启颜色输出 \e[0m 关闭 输出颜色 30m=黑色 31m=红色 32m=绿色 33m=黄色 34m=蓝色 35m=洋红 36m=青色 37m=白色

     第一个脚本
     [root@localhost sh]# vi hello.sh
     #!/bin/bash
     #The first program

     脚本执行
     赋予执行权限 直接运行
     chmod 755 hello.sh #如果不给权限会提示 permission denied
     ./hello.sh
     能过 bash 调用执行脚本
     bash hello.sh

     bash 的基本功能
     什么是别名
     命令别名 == 人的小名
     别名永久生效与删除别名
     vi ~/.bashrc #写入环境变量配置文件
     unalias 别名 #删除别名

     常用快捷键
     ctrl + c 强制终止当前命令
     ctrl + l 清屏
     ctrl + a 光标移到命令行首
     ctrl + e 光标移到命令行尾
     ctrl + u 从光标所在位置删除到行首
     ctrl + z 把命令放入后台
     ctrl + r 在历史命令中搜索
*/