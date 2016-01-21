<?php

/**
    shell 编程

    shell 变量的缺点
    弱类型
    默认字符串型

    declare 声明变量类型
    [root@localhost ~]# declare [+/-] [选项] 变量名
    - 给变量设定类型属性
    + 取消变量的类型属性
    -a 将变量声明为数组型
    -i 将变量声明为整数型 (integer)
    -x 将变量声明为环境变量
    -r 将变量声明为只读变量
    -p 显示指定变量的被声明的类型

    声明数组变量
    #定义数组
    [root@localhost ~]# movie[0]=zp
    [root@localhost ~]# movie[1]=tp
    [root@localhost ~]# declare -a movie[2]=live
    查看数组
    [root@localhost ~]# echo ${movie}
    [root@localhost ~]# echo ${movie[2]}
    [root@localhost ~]# echo ${movie[*]}

    declare -x test=123 #和export 作用相似 但其实是 declare 命令的作用

    声明变量只读属性
    [root@localhost ~]# declare -r test #给 test 赋予只读属性 但是请注意只读属性会让变量不能修改不能删除 甚至不能取消只读属性

    查询变量的属性
    declare -p #查询所有变量的属性
    declare -p 变量名 #查询指定变量的属性

    数值运算的方法
    [root@localhost ~]# aa=11
    [root@localhost ~]# bb=22 #给变量aa 和 bb 赋值
    [root@localhost ~]# declare -i cc=$aa + $bb

    expr 或 let 数值运算工具
    [root@localhost ~]# aa=11
    [root@localhost ~]# bb=22 #给变量aa 和变量 bb 赋值
    [root@localhost ~]# dd=$(expr $aa + $bb) #dd 的值是aa 和 bb 的和 注意 "+" 号左右两侧必须有空格

    "$((运算式))" 或 "$[运算式]"
    [root@localhost ~]# aa=11
    [root@localhost ~]# bb=22
    [root@localhost ~]# ff=$(($aa + $bb))
    [root@localhost ~]# gg=$[$aa + $bb]

    运算符
    优先级  运算符    说明
      13    - +       单目负 单目正
      12    ! ~       逻辑非 按位取反或补码
      11    * / %     乘 除 取模
      10    + -       加 减
      9     << >>     按位左移 按位右移
      8     <= >= < > 小于或等于 大于或等于 小于 大于
      7     == !=     等于 不等于
      6     &         按位与
      5     ^         按位异或
      4     |         按位或
      3     &&        逻辑与
      2     ||        逻辑或
      1     = += -= *=
            /= %= &=  赋值 运算且赋值
            ^= |= <<=
            >>=

    [root@localhost ~]# aa=$(( (11+3) * 3/2 )) #虽然乘和除的优先级高于加 但是通过小括号可以调整运算优先级
    [root@localhost ~]# bb=$(( 14 % 3 )) #14 不能被 3 整除 余数是 2
    [root@localhost ~]# cc=$(( 1 && 0 )) #逻辑与运算只有想与的两面边都是 1 与的结果才是 1 否则与的结果是 0

    变量测试
    格式复杂 用法简单

    变量转换方式   变是y 没有设置   变量 y 为空值   变量 y 设置值
    x=${y-新值}    x=新值           x为空           x=$y
    x=${y:-新值}   x=新值           x=新值          x=$y
    x=${y+新值}    x为空            x=新值          x=新值
    x=${y:+新值}   x为空            x为空           x=新值
    x=${y=新值}    x=新值 y=新值    x为空 y值不变   x=$y y值不变
    x=${y:=新值}   x=新值 y=新值    x=新值 y=新值   x=$y y值不变
    x=${y?新值}    新值输出到标准   x为空           x=$y
                   错误输出(就是屏幕)
    x=${y:?新值}   新值输出到标准   新值输出到标准  x=$y
                   错误输出         错误输出

    测试 x=${y-新值}
    [root@localhost ~]# unset y #删除变量 y
    [root@localhost ~]# x=${y-2} #进行测试
    [root@localhost ~]# echo $x #因为变是 y 不存在 所以 x = new 
*/