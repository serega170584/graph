<?php
require_once 'edgeWeightedGraph.php';

class Dijkstra
{
    /**
     * @var array
     */
    private $edgeTo;
    /**
     * @var array
     */
    private $distTo;
    private $vertexes;

    public function __construct(EdgeWeightedGraph $graph)
    {
        $this->marked = array_fill(0, $graph->getVertexesCount(), false);
        $this->edgeTo = array_fill(0, $graph->getVertexesCount(), false);
        $this->distTo = array_fill(0, $graph->getVertexesCount(), INF);
        $vertexes = array_keys($this->marked);
        foreach ($vertexes as $v) {
            if (!$this->marked[$v]) {
                $this->distTo[$v] = 0;
                $this->relax($graph, $v);
                while ($this->vertexes) {
                    $v = reset($this->vertexes);
                    unset($this->vertexes[key($this->vertexes)]);
                    $this->relax($graph, $v);
                }
            }
        }
    }

    private function relax(EdgeWeightedGraph $graph, int $v)
    {
        $this->marked[$v] = true;
        array_map(function ($val) use ($graph, $v) {
            $weight = $this->distTo[$v] + $graph->getWeight($v, $val);
            if ($weight < $this->distTo[$val]) {
                $this->distTo[$val] = $weight;
                $this->edgeTo[$val] = $v;
                $this->vertexes[$weight] = $val;
            }
        }, $graph->adj($v));
        ksort($this->vertexes);
    }
}

$graph = new EdgeWeightedGraph(8, 'dijkstra.txt');
$d = new Dijkstra($graph);
var_dump($d);
