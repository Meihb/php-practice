<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/7/31
 * Time: 10:21
 */

require_once "../common.php";
error_reporting(E_ALL);

//关闭错误显示
ini_set('display_errors', 0);
//开启错误日志功能
ini_set('log_errors', 'on');
//设置错误日志的路径
ini_set('error_log', 'syslog');
//显示所有错误
error_reporting(-1);

#client.php

class Client
{
    public static function Main($list_todo)
    {
        try {
            //实现文件的自动加载
            function autoload($class)
            {
                include $class . '.php';
            }

            spl_autoload_register('autoload');

            $arr = array(62, 88, 58, 47, 35, 73, 51, 99, 37, 93);

//            $tree = new Bst();   //搜索二叉树
            $tree = new Avl();    //平衡二叉树
//            $tree = new Rbt();   //红黑树

            $tree->init($list_todo);     //树的初始化
//            $tree->Delete(62);
//            $tree->Insert(100);
//            $tree->MidOrder();    //树的中序遍历（这也是调试的一个手段，看看数字是否从小到大排序）
            $image = new BinaryTreeImage($tree);
            $image->show();    //显示图像
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

Client::Main($list_todo);