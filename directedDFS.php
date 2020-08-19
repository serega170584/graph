<?php

require_once('diGraph.php');

class DirectedDFS
{
    /**
     * @var array $marked
     */
    private $marked = [];

    private $count;

    private $edges = [];

    private $startVertex;

    public function __construct(DiGraph $graph, int $v)
    {
        $this->marked = array_fill(0, $graph->getVertexesCount(), false);
        $this->startVertex = $v;
        $this->dfs($graph, $v);
    }

    private function dfs(DiGraph $graph, int $v)
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

$graph = new DiGraph(7);
$dfs = new DirectedDFS($graph, 0);
var_dump($dfs);
var_dump($dfs->getPath(6));