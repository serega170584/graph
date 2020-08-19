<?php
require_once('graph.php');

class BreadthFirstSearch
{
    /**
     * @var array $marked
     */
    private $marked = [];

    private $count;

    private $queue = [];

    private $edges = [];

    private $startVertex;

    public function __construct(Graph $graph, int $v)
    {
        $this->marked = array_fill(0, $graph->getVertexesCount(), false);
        $this->queue[] = $v;
        $this->startVertex = $v;
        $this->bfs($graph, $v);
    }

    private function bfs(Graph $graph, int $v)
    {
        while ($this->queue) {
            $vertex = array_shift($this->queue);
            $this->marked[$v] = true;
            ++$this->count;
            $adj = $graph->adj($vertex);
            foreach ($adj as $val) {
                if (!$this->marked[$val]) {
                    $this->edges[$val] = $vertex;
                    $this->queue[] = $val;
                    $this->marked[$val] = true;
                }
            }
        }
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
$bfs = new BreadthFirstSearch($graph, 0);
var_dump($bfs->getPath(3));