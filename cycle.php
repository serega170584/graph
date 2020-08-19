<?php

require_once('graph.php');

class Cycle
{
    /**
     * @var bool
     */
    private $isCycle;

    public function __construct(Graph $graph, int $v)
    {
        $this->marked = array_fill(0, $graph->getVertexesCount(), false);
        $this->dfs($graph, $v, $v);
    }

    private function dfs(Graph $graph, int $v, int $u)
    {
        $this->marked[$v] = true;
        $adjRows = $graph->adj($v);
        array_map(function ($w) use ($graph, $v, $u) {
            if ($this->isCycle) {
                return;
            }
            if ($this->marked[$w]) {
                if ($w != $u) {
                    $this->isCycle = true;
                }
            } else {
                $this->dfs($graph, $w, $v);
            }
        }, $adjRows);
    }
}

$graph = new Graph(3, 'cycle.txt');
$c = new Cycle($graph, 0);
var_dump($c);