<?php

/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/9/2
 * Time: 16:15
 */
class  HashTable
{
    private $TableSize;
    private $Cells;


    /*
     * 为什么Cells这个数组的存储格式是个struct,为什么不能真删除,因为如果线性探测或者平方探测的情况下
     * 空位表示探测应当结束,比如 h = mod 13例子下,怎么判断一个值不在此hashtable种呢,根据其hash值获取table value,在冲突情况下根据探测方法直到遇到空位表示探测结束,
     * 如果贸然删除会导致错误的探测结束，Quod Erat Demonstrandum Q.E.D.
     */
    /*
     * 散列表的性能分析需要处理两种
     * 1.在散列表中的数据的平均查找长度asl
     * 2.不在散列表中数据的确认不存在的平均查找长度(其实也等于插入的平均查找长度)
     */
    /*
     * 装填因子(存储率) 0.5-0.85,一般大于0.5就double rehashing了,重新计算散列值存储
     */
    public function IntializeTable(int $TableSize)
    {

    }
}