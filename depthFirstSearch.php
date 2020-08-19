<?php

require_once('graph.php');

class DepthFirstSearch
{
    /**
     * @var array $marked
     */
    private $marked = [];

    private $count;

    private $edges = [];

    private $startVertex;

    public function __construct(Graph $graph, int $v)
    {
        $this->marked = array_fill(0, $graph->getVertexesCount(), false);
        $this->startVertex = $v;
        $this->dfs($graph, $v);
    }

    private function dfs(Graph $graph, int $v)
    {
        $this->marked[$v] = true;
        ++$this->count;
        $vertex = $v;
        array_map(function ($v) use ($graph, $vertex) {
            if (!$this->marked[$v]) {
                $this->edges[$v] = $vertex;
                $this->dfs($graph, $v);
            }
        }, $graph->adj($v));
    }

    public function getPath(int $v)
    {
        if ($this->marked[$v]) {
            $path = [];
            $vertex = $path[$v] = $this->edges[$v];
            while ($vertex !== $this->startVertex) {
                $vertex = $path[$vertex] = $this->edges[$vertex];
            }
            return array_reverse($path);
        } else {
            return null;
        }
    }
}

$graph = new Graph(7);
$dfs = new DepthFirstSearch($graph, 0);
var_dump($dfs->getPath(5));