<?php
require_once 'edgeWeightedGraph.php';
require_once 'topological.php';

class CriticalPathMethod
{
    private $edgeTo = [];
    /**
     * @var array
     */
    private $distTo;

    public function __construct(EdgeWeightedGraph $graph)
    {
        $vertexesCount = $graph->getVertexesCount();
        $s = $vertexesCount - 2;
        $f = $vertexesCount - 1;
        $fdescr = fopen('critical_path_method.txt', 'r');
        $vertex = 0;
        while (($buffer = fgets($fdescr)) !== false) {
            $graph->addEdge($s, $vertex, 0);
            $graph->addEdge($vertex + ($vertexesCount - 2) / 2, $f, 0);
            $data = array_map(function ($val) {
                return (int)$val;
            }, explode(' ', $buffer));
            $weight = array_shift($data);
            $graph->addEdge($vertex, $vertex + ($vertexesCount - 2) / 2, $weight);
            while ($data) {
                $toVertex = array_shift($data);
                $graph->addEdge($vertex + ($vertexesCount - 2) / 2, $toVertex, 0);
            }
            ++$vertex;
        }
        $order = (new Topological($graph))->getOrder();
        $this->distTo = array_fill(0, $vertexesCount, -INF);
        $vertex = reset($order);
        $this->distTo[$vertex] = 0;
        array_map(function ($v) use ($graph) {
            array_map(function ($val) use ($v, $graph) {
                $weight = $this->distTo[$v] + $graph->getWeight($v, $val);
                if ($weight > $this->distTo[$val]) {
                    $this->distTo[$val] = $weight;
                    $this->edgeTo[$val] = $v;
                }
            }, $graph->adj($v));
        }, $order);
    }
}

$cpm = new CriticalPathMethod(new EdgeWeightedGraph(22, null, false));
var_dump($cpm);