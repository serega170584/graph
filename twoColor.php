<?php

require_once('graph.php');

class TwoColors
{
    /**
     * @var bool
     */
    private $isTwoColor = true;

    private $colors = [];

    public function __construct(Graph $graph, int $v)
    {
        $this->marked = array_fill(0, $graph->getVertexesCount(), false);
        $this->colors[$v] = false;
        $this->dfs($graph, $v);
    }

    private function dfs(Graph $graph, int $v)
    {
        $this->marked[$v] = true;
        $adjRows = $graph->adj($v);
        array_map(function ($w) use ($graph, $v) {
            if (!$this->isTwoColor) {
                return;
            }
            if ($this->marked[$w]) {
                if ($this->colors[$w] == $this->colors[$v]) {
                    $this->isTwoColor = false;
                }
            } else {
                $this->colors[$w] = !$this->colors[$v];
                $this->dfs($graph, $w);
            }
        }, $adjRows);
    }
}

$graph = new Graph(6, 'two_colors.txt');
$tc = new TwoColors($graph, 0);
var_dump($tc);