<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2019/8/28
 * Time: 15:41
 */

class Graph
{

    //邻接矩阵 或者 邻接表
    public function __construct()
    {

    }

    public function BFS()
    {

    }

    public function DFS()
    {

    }


    /*
     *
     void unweighted(Vertex s,Graphp G){
        //初始化
        INITIATE_NUM = -999;//取一个明显不可能得到的数 -1,-∞,+∞皆可
        Q = Queue();
        dist= [];
        path=[];
        foreach G.vertexs as v:
            dist[v] =INITIATE_NUM;
        dist[s] = 0;//单源点设置为0,若INITIATE_NUM也为0，则在下面程序中,S源点将会发生回路
        Q.enqueu(s);
        while(Q.count()>0){
            v = Q.dequeu();
            for(w in v.neighbours )//能到达的邻接点,即E<v,w>存在
                if(dist[w]==INITIATE_NUM)//第一次访问
                    dist[w] = dist[v]+1;path[w] = v;
                    Q.enqueue(w);
        }

     }
     */
    public function unweighted()
    {

    }


    /*
     *
     * dijkstra不解决有负边的情况
     * Collected是一个表示皆收录的节点
     * 每次非递减的从未收录的节点收一个节点进入(和无权图的差别在于一个取最小值,一个用队列按序处理)
     void Dijkstra(Vertex s){
        //初始化
        Collected=[];//收录顶点
        dist=path=[];
        foreach G.vertexs as vertex:
            dist[vertex] = 999;//这里的initiate_num为啥要设计为最大值呢,因为dijkstra的核心是比较大小,所以需要设置一个明显达不到的最大值
        dist[s] = 0;//源节点

        while(true){
            v = minium dist[] not in Collected[];//第一次肯定是源点了,再次还涉及到排序算法
            if(!v) break;
            Collected[v] = true;//收录节点
            for(w in v.neighbours)//可联通的邻接点
                if(collected[w]==false)//未收录
                    if(E(v,w)+dist[w]<dist[w]){
                        dist[W] = dist[V] + E<V,W> ;//作为一个未收录的节点,其可能被多次修改(如果其和Collected多个节点都是邻接可联通情况下,这样可以保证最终路径最短)
                        path[W] = v;
            }
        }
    }

     */
    /**
     *
     * void Dijkstra( Vertex s )
     * { while (1) {
     * V = 未收录顶点中dist最小者;
     * if ( 这样的V不存在 )
     * break;
     * collected[V] = true;
     * for ( V 的每个邻接点 W )
     * if ( collected[W] == false )
     * if ( dist[V]+E<V,W> < dist[W] ) {
     * dist[W] = dist[V] + E<V,W> ;
     * path[W] = V;
     * }
     * }
     * }
     * Dijkstra
     */

    public function Dijkstra()
    {

    }

    /*
    通过矩阵处理
    1.D k [i][j]=路径{i->{i<=k}->j}的最小长度
    2.D -1就是邻接矩阵,对角元都为0,有边相连的value为权值,没有相连的必须是无穷大
    D 0、D 1、D 2...D  V-1[I][J]即给出了i到j的最短距离
    3. 从D k-1递推到D k时:
        当k∉最短路径{i->{i<=k}->j} D k = D k-1;
        当k∈最短路径{i->{i<=k}->j} D k[i][j] = D k-1[i][k] + D k-1[k][j]
    void Floyd(){
        for(i=0;i<N;i++){
            for（j=0;j<N;j++）{
                    D[i][j] = G[i][j];//此处应当设置好无穷大值
                    path[i][j] = -1;
                }
        }
        for(k=0;k<n;k++){
            for(i=0;i<N;i++){
                for（j=0;j<N;j++）{
                    if(D[i][k]+D[k][j] < D[i][j]) D[i][j] = D[i][k]+D[k][j];path[i][j] = k;//递归打印path[i][k]+path[k][j]
                }
            }
        }

    }

     */
    public function Floyd($AdjacenyMatrix)
    {
        $n = count($AdjacenyMatrix);
        $path = [];
        printf("初始邻接矩阵\r\n<br>");
        $this->printMatrix($AdjacenyMatrix);
        $d = $AdjacenyMatrix;
        for ($i = 1; $i <= $n; $i++) {
            for ($j = 1; $j <= $n; $j++) {
                $path[$i - 1][$j - 1] = $j;
            }
        }
        printf("初始化path矩阵<br>");
        $this->printMatrix($path);
        for ($k = 1; $k <= $n; $k++) {//需要思考为什么k必须是最外层循环
            for ($i = 1; $i <= $n; $i++) {
                for ($j = 1; $j <= $n; $j++) {
                    echo " k:$k, i:$i,j:$j; d [$i][$j]  compare with  d [$i][$k]  plus  d [$k][$j]  \r\n<br>";
                    $this->printMatrix($AdjacenyMatrix);
                    if ($d[$i - 1][$j - 1] > $d[$i - 1][$k - 1] + $d[$k - 1][$j - 1]) {
                        echo "relaxation!:\r\n<br>";
                        $d[$i - 1][$j - 1] = $d[$i - 1][$k - 1] + $d[$k - 1][$j - 1];
                        $path[$i - 1][$j - 1] = $k;
                    } else {
                        echo "no relaxation:\r\n<br>";
                    }
                    $this->printMatrix($path);
                }
            }
        }

        echo "结果:<br>";
        $this->printMatrix($path);
        $this->printMatrix($d);

    }

    public function printMatrix($matrix)
    {
        $m = count($matrix);
        $n = count($matrix[0]);
        $new = [];
        $temp = [" "];
        for ($i = 1; $i <= $n; $i++) {
            $temp[] = "v{$i}";;
        }
        $new[0] = $temp;


        for ($i = 1; $i <= $m; $i++) {
            $list = array_merge(["v{$i}"], $matrix[$i - 1]);
            $new[] = $list;
        }

        echo '<table border=1 style="width:10px;">';
        for ($i = 0; $i < count($new); $i++) {
            echo '<tr>';
            for ($j = 0; $j < count($new[$i]); $j++) {
                echo '<td style="padding: 1px; " align="center">' . $new [$i][$j] . '</td>';
            }
            echo '<tr>';
        }
        echo '</table>';
        return;

    }

    /*
     * same as Floyd
     */
    public function FloydWarshall()
    {

    }

    //最小生成树一
    public function Prim()
    {

    }


    //最小生成树二
    public function Kruskal()
    {

    }


    /*

    void TopSort(){
        cnt =0;
        for(i=0;i<V;i++){
            if(Indegeree[v]==0) Enqueue(v,Q)
        }
        while(!IsEmpty(Q)){
            V =Dequeue(Q);cnt++;
            for(W IN V.neighboiurs){//邻接点
                if(--Indegree[w]==0) Enqueue(w,Q)
                }
        }
        if(cnt<N) die('图里有毒,回路!')
    }
     */
    /**
     *如果数据表示为邻接表,那就需要遍历一次初始化入度(或者也不需要)
     * ACTIVITY ON VERTEX 每一个顶点带有意义的网络
     * 拓扑排序
     *
     * 拓扑序:如果从顶点v到顶点w有一条有一条有向路径,则v一定排在w之前。满足此条件的顶点序列成为拓扑序。获得拓扑序的过程即是拓扑排序
     * AOV如果有合理的拓扑序,则必定是有向无环图(Directed Acyclic Graph,DAG),有环的话表示互为前置,无法实现。
     *
     *
     * pesudocode:
     * for (i=0;i<|V|;i++){
     *  V=未输出的入度为0的顶点
     *  if(不存在V){report cycle;break}//说明存在环
     *  输出V
     *  for(v的邻接点w){
     *      indegree[w]--;
     *  }
     * }
     * 思考:如果外循环i还未结束,但是为输出的入度为0的顶点已经找不到了,那说明:必定存在环(照理每次输出一个顶点,如果找不到了,那说明之前输出的有重复的顶点)
     * 上面方法时间复杂度为O(|V|^2) ,外循环为|V|,每次还需要遍历顶点找到入度为0的顶点,顾得出
     *
     * 改良循环内查找方式
     * for(v In V){
     *      if Indegree(v)==0 ;Enqueue(v,Q)
     * }
     * while(!empty(Q)){
     *      v = Dequeue(Q)//输出v
     *      cnt++;
     *     for(w in adj(v)){
     *       ;
     *        if( --indegree(w)==0) Enqueue(w,Q)
     *   }
     * if(cnt<|V|) report "cycle"
     * }
     * O(|V|+|E|)
     * 此算法还可以来测试一个有向图是否为DAG
     */
    public function TopSort()
    {

    }

    /**
     * 关键路径 Activity On Edge网络 每一个边带有意义,顶点表示边结束
     * 绝对不允许厌恶的活动路径,即一下 机动时间为0的路径
     * 入度即表示前置条件,和aov其实一样的
     *
     * 首先进行拓扑排序,不能topsort的Graph无法求得关键路径 critical path
     *
     * 计算Earlist[v]的时候可以再topsort dequeue 时候 顺便执行 每次对比保留较大值
     * 排序结束之后需要设置 汇点 的latest[v]=earlist[v],按照top序逆序遍历,每一个边尾节点未v的 设置 最晚执行时间,对比保留较小值
     *
     * 之后可以从源点出发,计算以其为边首节点的边,若边的机动时间为0,则是关键路径,确定好了两个顶点之后继续用尾节点为新的首节点(关键路径的sum等于Earlist[汇点]即最短工期)
     */
    /*
    1.工期
    Earlist[0] = 0;
    Earlist[j] = max {Earlist[i]+C<i,j>| <i,j>∈E};C<i,j>表示从i指向j的权重
    2.机动时间 可空闲的时间
    latest[last] = Earlist[last]
    Latest[i] = min{Latest[j]-C<i,j>|<i,j>∈E}
    D<i,j> = Latest[j]-Earlist[i]-C<i,j>;//对于每一个边来说,用边尾节点的最晚完成时间 - 边首节点的最早时间 -边权重 即为 此条边的机动时间 flexible time???
    3.critical path 关键路径:绝对不允许延误所组成的路径 即机动时间为0

     */
    public function AOE()
    {

    }
}

$obj = new Graph();
$adjacenyMatrix = [
    [0, 2, 4, 99, 99],
    [99, 0, 99, 1, 99],
    [2, 3, 0, 5, 99],
    [1, 5, 99, 0, 99],
    [6, 99, 3, 99, 0]
];

$adjacenyMatrix = [
    [0, 2, 4, 7],
    [99, 0, 1, 99],
    [2, 3, 0, 13],
    [1, 2, 3, 0]
];
//$obj->printMatrix($adjacenyMatrix);
//exit();
$obj->Floyd($adjacenyMatrix);