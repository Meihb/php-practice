<?php

namespace Algorithm\TreeSearch;

namespace Algorithm\TreeSearch;
include_once "./Tree.php";
/*
 * 广度优先 就是层级遍历
 * 实现方法是把节点氛围 三类 分别为:待解除、已接触、已完结
 */


//测试
$A = new TreeNode("8");
$B = new TreeNode("3");
$C = new TreeNode("10");
$D = new TreeNode("1");
$E = new TreeNode("6");
$F = new TreeNode("14");
$G = new TreeNode("4");
$H = new TreeNode("7");
$M = new TreeNode("13");

$tree = new Tree($A);
$A->addChildren($B);
$A->addChildren($C);
$B->addChildren($D);
$B->addChildren($E);
$C->addChildren($F);
$E->addChildren($G);
$E->addChildren($H);
$F->addChildren($M);

$result = ($tree->DFS($tree->root));

//var_dump($result);
foreach ($result as $key => $value) {

    print_r($value);
    echo "<br>";
}
