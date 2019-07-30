<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/7/30
 * Time: 10:54
 */


//默认排序从小到大
$list_todo = [49, 38, 65, 97, 76, 13, 27, 49, 55, 04];

/**
 * @param array $list
 * @param $n
 * @param $i
 */
function print_list(array $list, $n, $i)
{
    echo "第{$i}趟排序:";
    for ($j = 0; $j < $n; $j++) {
        echo $list[$j] . ' ';
    }
    echo '<br>';
}