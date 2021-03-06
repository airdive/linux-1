<?php

/**
    远程登录

    SSH 协议原理
    SecureCRT 远程管理工具
    Xshell 工具和 WinSCP 文件传输工具

    对称加密算法
    采用单钥密码系统的加密方法 同一个密钥可能以同时用作信息的加密和解密 这种加密方法称为对称加密 也称为单密钥加密

    非对称加密算法
    非对称加密算法 (asymmetric cryptographic algorithm) 又名 "公开密钥加密算法" 非对称加密算法需要两面个密钥 公开密钥 (publickey) 和私有密钥 (privatekey)

    SSH 命令
    ssh 用户名@ip #远程管理指定 linux 服务器

    scp [-r] 用户名@ip:文件路径 本地路径 #下载文件

    scp [-r] 本地文件 用户名@ip:上传路径 #上传文件

    df 统计分区的使用状况
*/