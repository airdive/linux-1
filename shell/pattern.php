<?php

/**
    正则表达式在程序语言中很常见

    有利于其他语言中正则表达式的学习

    正则表达式
    正则表达式是用于描述字符排列和匹配模式的一种语法规则 它主要用于字符串的模式分割 匹配 查找及替换操作

    通配符
    *   匹配任意内容
    ?   匹配任意一个内容
    []  匹配中括号中的一个字符

    基础正则表达式
    元字符  作用
    *       前一个字符匹配 0 次或任意多次
    .       匹配除了换行符外任意一个字符
    ^       匹配行首 例如 ^hello 会匹配以 hello 开头的行
    $       匹配行尾 例如 hello& 会匹配以 hello 结尾的行
    []      匹配中括号中指定的任意一个字符 只匹配一个字符 例如 [aoeiu] 匹配任意一个元音字母
    [^]     匹配除中括号的字符以外的任意一个字符 例如 [^0-9] 匹配任意一位非数字字符
    \       转义符 用于取消特殊符号的含义取消
    \{n\}   表示其前面的字符恰好出现 n 次
    \{n,\}  表示其前面的字符出现不小于 n 次
    \{n,m\} 表示其前面的字符至少出现n 次 最多出现 m 次 [a-z]\{6,8\} 匹配 6到 8 位的小写字母 

    正则表达式与通配符
    正则表达式用来在文件中匹配符合条件的字符串 正则是包含匹配 grep awk sed 等命令可以支持正则表达式
    通配符用来匹配符合条件的文件名 通配符是完全匹配 ls find cp 这些命令不支持正则表达式 所以只能使用 shell 自己的通配符来进行匹配了

    "*" 前一个字符匹配 0 次 或任意多次
    "a*" #匹配所有内容 包括空白行
    "aa*" #匹配至少包含有一个 a 的行
    "aaa*" 匹配最少包含两个连续a 的字符串
    "aaaaa*" #则会匹配最少包含四个个连续 a 的字符串

    "." 匹配除了换行符外任意一个字符
    "s..d" #"s..d" 会匹配在 s 和 d 这两个字母之间一定有两个字符的单词
    "s.*d" #匹配在 s 和 d 字母之间有任意字符
    ".*" #匹配所有内容

    "^" 匹配行首 "$"匹配行尾
    "^M" #匹配以大写 "M" 开头的行
    "n$" #匹配以小写 "n" 结尾的行驶
    "^$" #会匹配空白行

    "[]" 匹配中括号中指定的任意一个字符 只匹配一个字符
    "s[ao]id" #匹配s和 i 字母中 要不是a 要不是o
    "[0-9]" #匹配任意一个数字
    "^[a-z]" #匹配用小写字母开头的行

    "[^]" 匹配除中括号的字符以外的任意一个字符
    "^[^a-zA-Z]" #匹配不用小写字母开头的行
    "^[^a-zA-Z]" #匹配不用字母开头的行

    "\" 转义符
    "\.$" #匹配使用 "." 结尾的行

    [0-9]\{4\}-[0-9]\{2\}-[0-9]\{2\} #匹配日期格式 YYYY-MM-DD
    [0-9]\{1,3\}\.[0-9]\{1,3\}\.[0-9]\{1,3\}\.[0-9]\{1,3\} #匹配 IP 地址

    grep "/bin/bash" /etc/passwd | grep -v "root"

    [root@localhost ~]# cut [选项] 文件名
    -f 列号 提取第几列
    -d 分隔符 按照指定分隔符分割列 (默认以tab 作为分隔符)
    [root@localhost ~]# vi student.txt
    id name  gender mark
    1  apeng f      85
    2  cao   f      60
    3  peng  f      70
    cut student.exe
    grep "/bin/bash" /etc/passwd
    grep "/bin/bash" /etc/passwd | grep -v "root"
    grep "/bin/bash" /etc/passwd | grep -v "root" | cut -f 1 -d ":"

    cut -f 2 student.txt
    cut -f 2,4 student.txt

    cut 命令的局限
    df -h #人性化显示
    df -h | cut -f 5
    df -h | cut -f 1,3 -d " "

    printf 命令
    printf '输出类型输出格式'　输出内容

    输出类型
    %ns 输出字符串 n 是数字指代输出几个字符
    %ni 输出整数 n 是数字指代输出几个数字
    %m.nf 输出浮点数 m 和 n 是数字 指代输出的整数位数和小数位数 如 %8.2f 代表共输出 8 位数 其中 2 位是小数 6 位是整数

    输出格式
    \a 输出警告声音
    \b 输出退格键 也就是 backspace 键
    \f 清除屏幕
    \n 换行
    \r 回车 也就是 enter 键
    \t 水平输出退格键 也就是 tab 键
    \v 垂直输出退格键 也就是 tab 键

    [root@localhost ~]# printf %s 1 2 3 4 5 6
    [root@localhost ~]# printf %s %s %s 1 2 3 4 5 6
    [root@localhost ~]# printf '%s %s %s' 1 2 3 4 5 6
    [root@localhost ~]# printf '%s %s %s\n' 1 2 3 4 5 6

    printf '%s' $(cat student.txt) #不调整输出格式
    printf '%s\t %s\t %s\t %s\n' $(cat student.txt) #调整格式输出

    在 awk 命令的输出中支持 print 和 printf 命令
    print print 会在每个输出之后自动加入一个换行符 (linux 默认没有 print 命令)
    printf printf 是标准格式输出命令　并不会自动加入换行符 如果需要换行 需要手工加入换行符

    awk '条件1{动作1} 条件2{动作2} ...' 文件名
    条件 (pattern)
    一般使用关系表达式作为条件
    x > 10 判断变量 x 是否大于 10
    x >= 10 大于等于
    x <= 10 小于等于
    动作 (Action)
    格式化输出
    流程控制语句

    awk '{printf $2 "\t" $4 "\n"}' student.txt
    awk '{print $2 "\t" $4}' student.txt
    awk '{printf $2 "\t" $4}' student.txt
    df -h | awk '{print $1 "\t" $3}'
    df -h | grep "/dev/sda5" | awk '{print $5}'
    df -h | grep "/dev/sda5" | awk '{print $5}' | cut -d "%" -f 1
    awk 'BEGIN{printf "This is a transcript \n"}{printf $2 "\t" $4 "\n"}' student.txt
    awk '{print $2 "\t" $4}'
    awk 'END{print "test"}{printf $2 "\t" $4 "\n"}'
    cat /etc/passwd | grep "/bin/bash" | awk 'BEGIN {FS=":"}{printf $1 "\t" $3 "\n"}'
    cat student.txt | grep -v Name | awk '$4>=70{print $2}'

    sed 命令
    sed 是一种几乎包括在所有 unix 平台 (包括 linux) 的轻量级流编辑器 sed 主要是用来将数据进行选取 替换 删除 新增的命令
    sed [选项] '[动作]' 文件名
    -n 一般sed 命令会把所有数据都输出到屏幕 如果加入此选择则只会把经过 sed 命令处理的行输出到屏幕
    -e 允许对输入数据应用多条 sed 命令编辑
    -i 用 sed 的修改结果直接修改读取数据的文件 而不是由屏幕输出
    动作
    -a 追加 在当前行后添加一行或多行
    -c 行替换 用c 后面的字符串替换原数据行
    -i 插入 在当前行前插入一行或多行 d 删除 删除指定的行
    -p 打印 输出指定的行
    -s 字串替换 用一个字符串替换另外一个字符串 格式为 "行范围 s/旧字串 /新字串 /g" (和 vim 中的替换格式类似)

    sed '2,4d' student.txt #删除第二行到第四行的数据 但不修改文件本身
    sed '2a piaoliang jiushi renxing' student.txt #在第二行后追加 hello
    sed '2i meinv' student.txt #在第二行前插入两行数据

    排序命令 sort
    sort [选项] 文件名
    -f 忽略大小写
    -n 以数值型进行排序 默认使用字符串型排序
    -r 反向排序
    -t 指定分隔符 默认是分隔符是制表符
    -k n[,m] 按照指定的字段范围排序 从第n 字段开始 m 字段结束 (默认到行尾)
    sort /etc/passwd #排序用户信息文件
    sort -r /etc/passwd #反向排序
    sort -t ":" -k 3,3 /etc/passwd #指定分隔符是 ":" 用第三字段开头 第三字段结尾排序 就是只用第三字段排序
    sort -n -t ":" -k 3,3 /etc/passwd

    统计命令 wc
    wc [选项] 文件名
    -l 只统计行数
    -w 只统计单词数
    -m 只统计字符数
*/