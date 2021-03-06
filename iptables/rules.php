<?php

/**
    iptables 防火墙 nat 表规则配置
    snat 源地址转换 出口 POSTROUTING
    dnat 目标地址转换 进口 PREROUTING
    netstat -luntp | grep 80

    转发需要打开 
    vim /etc/sysctl.conf
    net.ipv4.ip_forward = 1
    sysctl -p #执行
    sysctl -a | grep ip_forward
    iptables -t nat -A POSTROUTING -s 10.10.188.0/24 -j SNAT --to 10.10.199.0/24
    iptables -t nat -L #查看 nat 表中的内容

    netstat -rn
    cat /etc/sysconfig/network 
    GATEWAY=120... #添加路由
    或是 route 添加
    route add 0.0.0.0 gw 10.10.177.232
*/