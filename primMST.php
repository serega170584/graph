<?php

require_once('edgeWeightedGraph.php');

class PrimMST
{
    /**
     * @var array
     */
    private $marked;
    private $edgesQueue = [];
    private $mstQueue = [];
    /**
     * @var array
     */
    private $distTo;

    public function __construct(EdgeWeightedGraph $graph)
    {
        $this->marked = array_fill(0, $graph->getVertexesCount(), false);
        $this->distTo = array_fill(0, $graph->getVertexesCount(), INF);
        $this->distTo[0] = 0;
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
            if ($this->marked[$val]) {
                return;
            }
            $weight = $graph->getWeight($v, $val);
            if ($this->distTo[$val] > $weight) {
                $this->distTo[$val] = $weight;
            }
            $this->edgesQueue[$weight] = [$val, $v];
        }, $graph->adj($v));
        ksort($this->edgesQueue);
    }
}

$pMST = new PrimMST(new EdgeWeightedGraph(8, 'prima.txt'));
var_dump($pMST);