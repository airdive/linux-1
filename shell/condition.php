<?php

/** 
    条件判断式语句

    条件判断式
    单分支 if 语句 
    双分支 if 语句
    多分支 if 语句
    case 语句
    for 循环
    while 循环和 until 循环

    按照文件类型进行判断
    测试选项   作用
    -b 文件    判断该文件是否存在 并且是否为块设备文件 (是块设备文件为真)
    -c 文件    判断该文件是否存在 并且是否为字符设备文件 (是字符设备文件为真)
    -d 文件    判断该文件是否存在 并且是否为目录文件 (是目录为真)
    -e 文件    判断该文件是否存在 (存在为真)
    -f 文件    判断该文件是否存在 并且是否为普通文件 (是普通文件为真)
    -L 文件    判断该文件是否存在 并且是否为符号链接文件 (是符号链接文件为真)
    -p 文件    判断该文件是否存在 并且是否为管道文件 (是管道文件为真)
    -s 文件    判断该文件是否存在 并且是否为非空 (非空为真)
    -S 文件    判断该文件是否存在 并且是否为套接字文件 (是套接字文件为真)

    两种判断格式
    test -e /root/install.log
    [-e /root/install.log]
    [-d /root] && echo "yes" || echo "no" #第一个判断命令如果正确执行 则打印 "yes" 否则打印机 "no"

    按照文件权限进行判断
    测试选项   作用
    -r 文件    判断该文件是否存在 并且是否该文件拥有读权限 (有读权限为真)
    -w 文件    判断该文件是否存在 并且是否该文件拥有写权限 (有写权限为真)
    -x 文件    判断该文件是否存在 并且是否该文件拥有执行权限 (有执行权限为真)
    -u 文件    判断该文件是否存在 并且是否该文件拥有 SUID 权限 (有 SUID 权限为真)
    -g 文件    判断该文件是否存在 并且是否该文件拥有 SGID 权限 (有 SGID 权限为真)
    -k 文件    判断该文件是否存在 并且是否该文件拥有 SBit 权限 (有 SBit 权限为真)
    [-w /root/install.log] && echo yes || echo no

    两个文件之间进行比较
    测试选项         作用
    文件1 -nt 文件2  判断文件1 的修改时间是否比文件2 的新 (如果新则为真)
    文件1 -ot 文件2  判断文件1 的修改时间是否比文件2 的旧 (如果旧则为真)
    文件1 -et 文件2  判断文件1 是否和文件 2 的 inode 号一致 可以理解为两个文件是否为同一个文件 这个判断用于判断硬链接是很好的方法

    ln /root/student.txt /tmp/stu.txt #创建个硬链接吧
    [ /root/student.txt -ef /tmp/stu.txt] && echo "yes" || echo "no" #用test 测试下 果然很有用

    两个整数之间比较
    测试选项         作用
    整数1 -eq 整数2  判断整数1 是否和整数2 相等 (相等为真)
    整数1 -ne 整数2  判断整数1 是否和整数2 不相等 (不相等为真)
    整数1 -gt 整数2  判断整数1 是否大于整数2 (大于为真)
    整数1 -lt 整数2  判断整数1 是否小于整数2 (小于为真)
    整数1 -ge 整数2  判断整数1 是否大于等于整数2 (大于等于为真)
    整数1 -le 整数2  判断整数1 是否小于等于整数2 (小于等于为真)

    字符串的判断
    测试选项       作用
    -z 字符串      判断字符串是否为空 (为空返回真)
    -n 字符串      判断字符串是否为非空 (非空返回真)
    字串1 == 字串2 判断字符串1 是否和字符串2 相等 (相等返回真)
    字串1 != 字串2 判断字符串1 是否和字符串2 不相等 (不相等返回真)

    多重条件判断
    测试选项        作用
    判断1 -a 判断2  逻辑与 判断1和判断2都成立 最终的结果才为真
    判断1 -o 判断2  逻辑或 判断1和判断2有一个成立 最终的结果就为真
    ! 判断          逻辑非 使原始的判断式取反

    学习小脚本实例的好处
    掌握语法结构
    了解 shell 的作用
    分析编程思想

    建立编程思想的方法
    熟悉 linux 基本命令 规范 语法及 shell 语法
    当遇到实际需求时 应用所学知识

    如何 "背" 程序
    抄写老师的程序并能正确运行
    为程序补全注释
    删掉注释 为代码重新加注释
    看注释写代码
    删掉代码和注释 从头开始写

    单分支 if 条件语句
    if [条件判断式]; then
    程序
    fi

    或者
    if [条件判断式]
    then
    程序
    fi

    单分支条件语句需要注意几个点
    if 语句使用 fi 结尾 和一般语言使用大括号结尾不同
    [条件判断式] 就是使用 test 命令判断 所以中括号和条件判断式之间必须有空格
    then 后面跟符合条件之后执行的程序 可以放在 [] 之后 用 ':' 分割 也可以换行驶写入 就不需要 ";" 了

    例子1 判断登录的用户是否 root
    #!/bin/bash

    test=$(env | grep "USER" | cut -d "=" -f2)
    if ["$test" == root]
    then
    echo "Current user is root."
    fi

    例子2 判断分区使用率
    #!/bin/bash
    #统计根分区使用率
    rate=$(df -h | grep "/dev/sda3" | awk '{print $5}' | cut -d "%" -f1) #把根分区使用率作为变量值赋予变量rate

    if [$rate -ge 80]
    then 
    echo "Warning! /dev/sda3 is full!!"
    fi

    双分支 if 条件语句
    if [条件判断式]
    then
    条件成立时 执行的程序
    else 
    条件不成立时 执行的另一个程序
    fi

    [-d /root] && echo "yes" || echo "no" #第一个判断命令如果正确执行 则打印 "yes" 否则打印 "no"

    判断是否是目录
    #!/bin/bash

    read -t 30 -p "Please input a dir: " dir
    if [ -d "$dir"]
    then
    echo "shurn de shi mnlu"
    else
    echo "no no no"
    fi
    if []
 
    判断 apache 是否启动
    #!/bin/bash
    test=$(ps aux | grep httpd | grep -v grep) #截取 httpd 进程 并把结果赋予变量 test
    if [-n "$test"] #如果test 的值不为空 则执行 then 中命令
    then
    echo "$(date) httpd is ok!" >> /tmp/autostart-acc.log
    else
    /etc/rc.d/init.d/httpd start &>/dev/null
    echo "$(date) restart httpd !!" >> /tmp/autostart-err.log
    fi

    多分支 if 条件语句
    if [条件判断式1]
    then 
    当条件判断式 1 成立时 执行程序1
    elif [条件判断式2]
    then
    不条件判断式 2 成立时 执行程序2
    ...
    else
    当所有条件都不成立时 最后执行此程序
    fi

    #!/bin/bash #字符界面加减乘除计算器

    read -t 30 -p "Please input num1: " num1
    read -t 30 -p "Please input num2: " num2 #通过 read 命令接收要计算的数值 并赋予变量 num1 和 num2
    read -t 30 -p "Please input a operator: " ope #通过 read 命令接收要计算的符号 并赋予变量 ope

    if [-n "$num1" -a -n "$num2" -a -n "$opc"] #第一层判断 用来判断 num1 num2 和 ope 中都有值
    then
    test1=$(echo $num1 | sed 's/[0-9]//g')
    test2=$(echo $num2 | sed 's/[0-9]//g') #定义变量 test1 和 test2 的值为 $(命令) 的结果
    #后续命令作用是 把变量 test1 的值替换为空 如果能替换为空 证明 num1 的值为数字
    #如果不能替换为空 证明 num1 的值为非数字 我们使用这种方法判断变量 num1 的值为数字
    #用同样的方法测试 test2 变量

    if [-z "$test1" -a -z "$test2"] #第二层判断 用来判断 num1 和 num2 为数值
    #如果变量 test1 和 test2 的值为空 则证明 num1 和 num2 是数字
    then
    #如果 test1 和 test2 是数字 则执行以下命令
    if["$ope" == '+']
    #第三层判断用来确认运算符
    #测试变量 $ope 中是什么运算符
    then
    sum=$(($num1 + $num2)) #如果是加号则执行加法运算
    elif["$ope" == '-']
    then
    sum=$(($num1 - $num2))
    elif["$ope" == '*']
    then
    sum=$(($num1 * $num2))
    elif["$ope" == '/']
    then
    sum=$(($num1 / $num2))
    else
    echo "Please enter a valid symbol" #如果运算符不匹配 提示输入有效的符号
    exit 10 #并退出程序 返回错误代码 10
    fi
    else #如果 test1 和 test2 不是数值
    echo "Please enter a valid value" #则提示输入有效的数值
    exit 11 #并退出程序 返回错误代码 11
    fi
    else
    echo "qing shuru neirong"
    exit
    fi

    echo " $num1 $ope $num2 : $sum" #输出数值运算的结果

    判断用户输入的是什么文件
    #!/bin/bash #判断用户输入的是什么文件
    read -p "Please input a filename: " file #接收键盘的输入 并赋予变量 file

    if [-z "$file"] #判断 file 变量是否为空
    then
    echo "Error, please input a filename"
    exit 1
    elif [! -e "$file"] #判断 file 的值是否存在
    then 
    echo "Your input is not a file!"
    exit 2
    elif [-f "$file"] #判断 file 的值是否为普通文件
    then
    echo "$file is a regulare file!"
    elif [-d "$file"] #判断 file 的值是否为目录文件
    then
    echo "$file is a directory!"
    else
    echo "$file is an other file!"
    fi

    多分支 case 条件语句
    case 语句和 if ... elif ... else 语句一样都是多分支条件语句 不过和 if 多分支条件语名不同的是 case 语句只能判断一种条件关系 而 if 语句可以判断多种条件关系

    case $变量名 in
    "值1")
    如果变量的值等于值1 则执行程序1
    ;;
    "值2")
    如果变量的值等于值2 则执行程序2
    ;;
    ... 省略其他分支 ...
    *)
    如果变量的值都不是以上的值 则执行此程序
    ;;
    esac

    #!/bin/bash #判断用户输入
    read -p "Please choose yes/no: " -t 30 cho
    case $cho in
    "yes")
    echo "Your choose is yes!"
    ;;
    "no")
    echo "Your choose is no!"
    ;;
    *)
    echo "Your choose is error!"
    ;;
    esac

    #!/bin/bash
    for i in 1 2 3 4 5
    do 
    echo $i
    done

    #!/bin/bash #批量解压缩脚本

    cd /root/test
    ls *.tar.gz > ls.log
    for i in $(cat ls.log)
    do
    tar -zxf $i &>/dev/null
    done
    rm -rf /lamp/ls.log

    for ((初始值;循环控制条件;变量变化))
    do
    程序
    done

    #!/bin/bash #从1 加到 100
    s=0
    for ((i=1;i<=100;i=i+1))
    do
    s=$(($s+$i))
    done
    echo "The sum of 1+2+...+100 is: $s"

    #!/bin/bash
    #批量添加指定数量的用户
    read -p "Please input user name: " -t 30 name
    read -p "Please input the number of users: " -t 30 num
    read -p "Please input the password of users: " -t 30 pass
    if [! -z "$name" -a ! -z "$num" -a ! -z "$pass"]
    then
    y=$(echo $num | sed 's/[0-9]//g')
    if [-z "$y"]
    then
    for ((i=1;i<=$num;i=i+1))
    do
    for((i=1;i<=$num;i=i+1))
    do
    /usr/sbin/useradd $name$i&>/dev/null
    echo $pass | /usr/bin/passwd --stdin $name$i&>/dev/null
    done
    fi
    fi

    #!/bin/bash
    for i in $(cat /etc/passwd | grep /bin/bash | grep -v root | cut -d ":" -fl)
    do
    userdel -r $i
    done

    while 循环
    while 循环是不定循环 也称作条件循环 只要条件判断式成立 循环就会一直继续 直到条件判断式不成立 循环才会停止 这就和 for 的固定循环不太一样了
    while [条件判断式]
    do
    程序
    done

    #!/bin/bash
    #从1加到100
    i=1
    s=0
    while [$i -le 100 ] #如果变量i的值小于等于100, 则执行循环
    do
    s=$(($s+$i))
    i=$(($i+1))
    done
    echo "The sum is: $s"

    until 循环
    until 循环 和 while 循环相反 until 循环时只要条件判断式不成立则进行循环 并执行循环程序 一旦循环条件成立 则终止循环
    #!/bin/bash
    #从1加到100
    i=1
    s=0
    until [$i -gt 100] #循环直到变量i 的值大于 100 就停止循环
    do
    s=$(($s+$i))
    i=$(($i+1))
    done
    echo "The sum is: $s"

    shell 主要用来简化管理员操作
    shell 编程更多的考虑程序的功能实现 而不是效率
*/