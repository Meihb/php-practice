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
    public function Floyd()
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
     * ACTIVITY ON VERTEX 每一个顶点带有意义的网络
     * 拓扑排序
     */
    public function TopSort()
    {

    }

    /**
     * 关键路径 Activity On Edge网络 每一个边带有意义,顶点表示边结束
     * 绝对不允许厌恶的活动路径,即一下 机动时间为0的路径
     * 入度即表示前置条件,和aov其实一样的
     */
    /*
    1.工期
    Earlist[0] = 0;
    Earlist[j] = max {Earlist[i]+C<i,j>| <i,j>∈E};C<i,j>表示从i指向j的权重
    2.机动时间 可空闲的时间
    latest[last] = Earlist[last]
    Latest[i] = min{Latest[j]-C<i,j>|<i,j>∈E}
    D<i,j> = Latest[j]-Earlist[i]-C<i,j>;//对于每一个边来说,用边尾节点的最晚时间 - 边首节点的最早时间 -边权重 即为 此条边的机动时间
     */
    public function AOE()
    {

    }
}