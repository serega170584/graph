<?php
require_once('diGraph.php');
require_once('depthFirstOrder.php');

class Kosaraju
{
    private $count;
    private $components = [];

    public function __construct(DiGraph $graph)
    {
        $this->marked = array_fill(0, $graph->getVertexesCount(), false);
        $order = (new DepthFirstOrder($graph->reverse()))->getReversePost();
        foreach ($order as $v) {
            if (!$this->marked[$v]) {
                $this->dfs($graph, $v);
                ++$this->count;
            }
        }
    }

    /**
     * @return array
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    private function dfs(DiGraph $graph, int $v)
    {
        $this->marked[$v] = true;
        $this->components[$this->count][] = $v;
        array_map(function ($v) use ($graph) {
            if (!$this->marked[$v]) {
                $this->dfs($graph, $v);
            }
        }, $graph->adj($v));
    }
}

$graph = new DiGraph(13, 'kosaraju.txt');
$k = new Kosaraju($graph);
var_dump($k->getComponents());