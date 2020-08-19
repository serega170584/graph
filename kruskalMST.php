<?php
require_once 'edgeWeightedGraph.php';
require_once 'unionFind.php';

class KruskalMST
{
    private $mstQueue = [];

    public function __construct(EdgeWeightedGraph $graph)
    {
        $edges = $graph->getEdges();
        $uf = new UnionFind(range(0, $graph->getVertexesCount()));
        while ($edges) {
            $sameWeightedEdges = reset($edges);
            $weight = key($edges);
            $edge = reset($sameWeightedEdges);
            $key = key($sameWeightedEdges);
            unset($sameWeightedEdges[$key]);
            $edges[$weight] = $sameWeightedEdges;
            if (!$edges[$weight]) {
                unset($edges[$weight]);
            }
            $v = $edge[0];
            $w = $edge[1];
            if ($uf->findRoot($v) != $uf->findRoot($w)) {
                $uf->union($v, $w);
                $this->mstQueue[] = [$v, $w];
            }
        }
    }
}

$kMST = new KruskalMST(new EdgeWeightedGraph(8, 'prima.txt'));
var_dump($kMST);