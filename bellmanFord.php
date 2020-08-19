<?php
require_once 'edgeWeightedGraph.php';

class BellmanFord
{
    private $vertexes;
    /**
     * @var array
     */
    private $marked;
    /**
     * @var array
     */
    private $edgeTo;
    /**
     * @var array
     */
    private $distTo;
    /**
     * @var array
     */
    private $isInVertexes;

    public function __construct(EdgeWeightedGraph $graph)
    {
        $this->marked = array_fill(0, $graph->getVertexesCount(), false);
        $this->isInVertexes = array_fill(0, $graph->getVertexesCount(), false);
        $this->edgeTo = array_fill(0, $graph->getVertexesCount(), false);
        $this->distTo = array_fill(0, $graph->getVertexesCount(), INF);
        $vertexes = array_keys($this->marked);
        foreach ($vertexes as $v) {
            if (!$this->marked[$v]) {
                $this->distTo[$v] = 0;
                $this->vertexes[] = $v;
                $this->isInVertexes[$v] = true;
                while ($this->vertexes) {
                    var_dump($this->vertexes);
                    $v = reset($this->vertexes);
                    unset($this->vertexes[key($this->vertexes)]);
                    $this->relax($graph, $v);
                    $this->isInVertexes[$v] = false;
                }
            }
        }
    }

    private function relax(EdgeWeightedGraph $graph, $v)
    {
        $this->marked[$v] = true;
        array_map(function ($val) use ($graph, $v) {
            $weight = $this->distTo[$v] + $graph->getWeight($v, $val);
            if ($weight < $this->distTo[$val]) {
                $this->distTo[$val] = $weight;
                $this->edgeTo[$val] = $v;
                $this->vertexes[] = $val;
                $this->isInVertexes[$val] = true;
            }
        }, $graph->adj($v));
    }
}

$graph = new EdgeWeightedGraph(8, 'dijkstra.txt');
$bf = new BellmanFord($graph);
var_dump($bf);