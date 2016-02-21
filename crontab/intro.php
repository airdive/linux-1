<?php

/**
    工作中遇到的困难
    每分钟需要执行一个程序检查系统运行状态
    每天凌晨需要对过去一天的业务数据进行统计
    每个星期需要把日志文件备份
    每个月需要把数据库进行备份

    crontab 是什么
    crontab 实践

    crontab 是一个用于设置周期性被执行的任务的工具
    cron 计划任务 是指 cron 服务器
    cron job 执行一项工作
    cron tab 计划任务列表

    crontab 实践

    相关工具
    安装并检查 crontab 服务
    crontab 的基本组成
    crontab 的配置文件格式
    crontab 工具的使用
    crontab 的日志
    crontab 常见错误

    相关工具
    putty 一个免费的易用的 ssh 连接工具
    http://www.putty.org

    检查 cron 服务
    检查 crontab 工具是否安装 crontab -l
    检查 crond 服务是否启动 service crond status
    安装 cron
    yum install vixie-cron
    yum install crontabs

    一个简单的例子
    每分钟都打印当前时间到一个日志文件中 */1 * * * * date >> /tmp/log.txt

    crontab 的基本组成
    系统服务 crond 每分钟都会从配置文件刷新定时任务
    配置文件 文件方式设置定时任务
    配置工具 crontab 用于调整定时任务
    *        *        *        *        * command
    分钟0-59 小时0-23 日期1-31 月份1-12 星期0-7(0或者7 表示星期天)

    crontab 的配置文件格式

    每晚的 21:30 重启 apache 30 21 * * * service httpd restart
    每月 1 10 22 日的 4:45 重启 apache 45 4 1,10,22 * * service httpd restart
    每月 1 到 10 日的 4:45 重启 apache 45 4 1-10 * * service httpd restart
    每隔两分钟重启 apache 服务器 */2 * * * * service httpd restart
    1-59/2 * * * * service httpd restart
    晚上 11 点到早上 7 点之间 每隔一小时重启 apache 0 23-7/1 * * * service httpd restart
    每天 18:00 至 23:00 之间每隔 30 分钟重启 apache 0,30 18-23 * * * service httpd restart   0-59/30 18-23 * * * service httpd restart

    * 表示任何时候都匹配
    可以用 "A,B,C" 表示A 或者 B 或者 C 时执行命令
    可以用 "A-B" 表示 A 到 B 之间时执行命令
    可以用 "*/A" 表示每 A 分钟(小时等) 执行一次命令

*/