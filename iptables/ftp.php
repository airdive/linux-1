<?php

/**
    ftp 主动模式下 iptables 的规则配置
    ftp 被动模式下 iptables 的规则配置

    iptables 对于 FTP 主动模式 (同一网段可以采用主动模式 在实际中大部分服务器与开发不在同一网段 常采用被动模式)
    ftp 连接的默认模式为被动模式
    vsftpd 服务支持主动模式需要注意配置选项 (vi /etc/vsftpd/vsftpd.conf)
    port_enable=yes
    connect_from_port_20=YES
    iptables 需要开启 (/etc/init.d/vsftpd restart) 21 端口的访问权限
    #iptables -I INPUT -p tcp -dport 21 -j ACCEPT

    安装 vsftpd
    yum install vsftpd
    客户端安装 ftp 客户端
    yum install ftp
    服务端执行 iptables 命令 规则如下
    iptables -F
    iptables -I INPUT -p tcp --dport 21 -j ACCEPT
    iptables -I INPUT -p tcp --dport 22 -j ACCEPT
    iptables -I INPUT -p icmp -j ACCEPT
    iptables -I INPUT -m state --state ESTABLISHED,RELATED -j ACCEPT
    iptables -A INPUT -j REJECT
    iptables -nL
    对比将 passive off 后 及设置成被动模式后 ftp 正常访问
    iptables -I INPUT -p tcp --dport 20:21 -j ACCEPT

    iptables 对于 ftp 被动模式
    为 vsftpd 指定数据端口 并且通过 iptables 开放相应需要传输的端口段
    iptables -I INPUT -p tcp --dport 21 -j ACCEPT
    vim /etc/vsftpd/vsftpd.conf
    pasv_min_port=50000
    pasv_max_port=60000
    iptables -I INPUT -p tcp --dport 50000:60000 -j ACCEPT

    方式二 使用连接追踪模块
    iptables -I INPUT -m state --state ESTABLISHED,RELATED -j ACCEPT
    iptables -I INPUT -p tcp --dport 21 -j ACCEPT
    modprobe nf_conntrack_ftp #临时
    vim /etc/sysconfig/iptables-config #开机自动加载
    IPTABLES_MODULES="nf_conntrack_ftp"

    场景三
    要求一 员工在公司内部 (10.10.155.0/24, 10.10.188.0/24) 能访问服务器上的任何服务
    要求二 当员工出差例如在上海 通过 VPN 连接到公司 外网 (员工) === 拨号到 ==> VPN服务器 ====> 内网FTP, SAMBA, NFS, SSH
    要求三 公司有一个门户网站需要允许公网访问

    常见端口
    常见允许外网访问的服务
    网站 www http 80/tcp
             https 443/tcp
    邮件 mail smtp 25/tcp
              smtps 265/tcp
              pop3 110/tcp
              pop3s 995/tcp
              imap 143/tcp

    一些常用不允许外网访问的服务
    文件服务器 NFS 123/udp
               SAMBA 137,138,139/tcp 445/tcp
               FTP 20/tcp,21/tcp
    远程管理 SSH 22/tcp
    数据库   MYSQL 3306/tcp
             ORACLE 1521/tcp

    配置规则基本思路
    ACCEPT 规则 
        允许本地访问
        允许已监听状态数据包通过
        允许规则中允许的数据包通过 (注意开放 ssh 远程管理端口)

    DENY 规则 拒绝未被允许的数据包 (iptables 规则保存成配置文件)

    iptables -I INPUT -i lo -j ACCEPT #允许本地访问
    iptables -I INPUT -m state --state ESTABLISHED,RELATED -j ACCEPT #允许已监听的数据包通过
    iptables -L #查看
    iptables -A INPUT -s 10.10.155.0/24 -j ACCEPT #允许155 网段的访问
    iptables -A INPUT -p tcp --dport 80 -j ACCEPT #允许 80 端口
    iptables -A INPUT -p tcp --dport 1723 -j ACCEPT #允许 1723 (vpn) 端口
    iptables -I INPUT -p icmp -j ACCEPT #允许 icmp 协议
    iptables -A INPUt -j REJECT #拒绝其它端口

    telnet 测试
    telnet IP 端口号

    将规则保存到配置文件中
    /etc/init.d/iptables save
    vim /etc/init.d/iptables
    chkconfig iptables on #开机启动
    chkconfig --list | grep iptables

    #将规则写进.sh 文件中
    vim /opt/iptable_ssh.sh
    /bin/sh /opt/iptable_ssh.sh
    vim /etc/rc.local
    /bin/sh /opt/iptable_ssh.sh

*/