<?php

require_once('edgeWeightedGraph.php');

class LazyPrimMST
{
    /**
     * @var array
     */
    private $marked;
    private $edgesQueue = [];
    private $mstQueue = [];

    public function __construct(EdgeWeightedGraph $graph)
    {
        $this->marked = array_fill(0, $graph->getVertexesCount(), false);
        $this->visit($graph, 0);
        while ($this->edgesQueue) {
            $edge = reset($this->edgesQueue);
            unset($this->edgesQueue[key($this->edgesQueue)]);
            $v = $edge[0];
            $w = $edge[1];
            if ($this->marked[$v] && $this->marked[$w]) {
                continue;
            }
            $this->mstQueue[] = $edge;
            if (!$this->marked[$v]) {
                $this->visit($graph, $v);
            }
            if (!$this->marked[$w]) {
                $this->visit($graph, $w);
            }
        }
    }

    private function visit(\EdgeWeightedGraph $graph, int $v)
    {
        $this->marked[$v] = true;
        array_map(function ($val) use ($v, $graph) {
            if (!$this->marked[$val]) {
                $this->edgesQueue[$graph->getWeight($v, $val)] = [$v, $val];
            }
        }, $graph->adj($v));
        ksort($this->edgesQueue);
    }
}

$lPMST = new LazyPrimMST(new EdgeWeightedGraph(8, 'prima.txt'));
var_dump($lPMST);