<?php

require_once('graph.php');

class                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         ConnectedComponents
{
    /**
     * @var array $marked
     */
    private $marked = [];

    private $count = 0;

    private $componentIndexRows = [];

    public function __construct(Graph $graph)
    {
        $this->marked = array_fill(0, $graph->getVertexesCount(), false);
        array_map(function ($v) use ($graph) {
            if (!$this->marked[$v]) {
                $this->dfs($graph, $v);
                ++$this->count;
            }
        }, array_keys($this->marked));
    }

    private function dfs(Graph $graph, int $v)
    {
        $this->marked[$v] = true;
        $this->componentIndexRows[$v] = $this->count;
        array_map(function ($v) use ($graph) {
            if (!$this->marked[$v]) {
                $this->dfs($graph, $v);
            }
        }, $graph->adj($v));
    }
}

$graph = new Graph(11, 'connected_components.txt');
$cc = new ConnectedComponents($graph);
var_dump($cc);
