<?php

/**
    配置 IP 地址
  * ls /etc/sysconfig/network-scripts/ifcfg-eth0
  * vim /etc/sysconfig/network-scripts/ifcfg-eth0
  * 修改 ONBOOT = 'yes' (按i将no 改为 yes vim 中强制退出 q! Tab 键补全)
  * 按 esc 键
  * 输入 :wq (esc 键进入编辑模式 : 进入命令模式)
  * 重启 service network restart
  * ifconfig (查看ip 地址)
  * inet addr:192. 
  *
    setup 手动设置 (常用于nat 连接)
  * setup ---> 网络配置 ---> 设备配置 ---> 名称 设备 使用 DHCP (去掉 *) 静态 IP 子网掩码 (255.255.255.0) 默认网关 IP 主 DNS 服务器 第二 DNS 服务器 ---> 确认 
  *    防火墙设置
  *    网络配置
  *        DNS 配置
  *        设备配置
  *    系统服务
  *    验证配置

     关闭防火墙
  * setup ---> 防火墙设置 ---> 运行工具 (按Tab 键) ---> 按空格取消 * ---> 确定(按 Tab 键) ---> 是(按 Tab 键) ---> 退出 (按 Tab 键)

     修改密码
  * vim /etc/ssh/sshd_config
  *

  *  df 查看当前文件

     selinux 开启 linux 安全组件(增强安全组件)
  * vim /etc/selinux/config
  * SELINUX = disabled
  * 按 esc 键 
  * :wq
*/