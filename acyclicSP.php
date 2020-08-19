<?php
require_once 'edgeWeightedGraph.php';
require_once 'topological.php';

class AcyclicSP
{
    private $edgeTo;
    /**
     * @var array
     */
    private $distTo;

    public function __construct(EdgeWeightedGraph $graph)
    {
        $order = (new Topological($graph))->getOrder();
        $this->distTo = array_fill(0, $graph->getVertexesCount(), INF);
        $vertex = reset($order);
        $this->distTo[$vertex] = 0;
        array_map(function ($v) use ($graph) {
            array_map(function ($val) use ($v, $graph) {
                $weight = $this->distTo[$v] + $graph->getWeight($v, $val);
                if ($weight < $this->distTo[$val]) {
                    $this->distTo[$val] = $weight;
                    $this->edgeTo[$val] = $v;
                }
            }, $graph->adj($v));
        }, $order);
    }
}

$asp = new AcyclicSP(new EdgeWeightedGraph(8, 'acyclic_sp.txt'));
var_dump($asp);
die('asd');