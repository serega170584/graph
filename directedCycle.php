<?php

require_once('diGraph.php');

class DirectedCycle
{
    /**
     * @var array $marked
     */
    private $marked = [];
    private $inCycle = [];
    private $cycles = [];
    private $edgeTo = [];

    public function __construct(DiGraph $graph)
    {
        $this->marked = array_fill(0, $graph->getVertexesCount(), false);
        $this->inCycle = array_fill(0, $graph->getVertexesCount(), false);
        $this->edgeTo = array_fill(0, $graph->getVertexesCount(), false);
        $vertexes = array_keys($this->marked);
        foreach ($vertexes as $v) {
            if (!$this->marked[$v]) {
                $this->dfs($graph, $v);
            }
        }
    }

    private function dfs(DiGraph $graph, int $v)
    {
        $this->marked[$v] = true;
        $vertex = $v;
        $this->inCycle[$v] = true;
        array_map(function ($v) use ($graph, $vertex) {
            if ($this->marked[$v]) {
                if ($this->inCycle[$v]) {
                    $cycles = [];
                    $cycles[] = $v;
                    while ($vertex != $v) {
                        $cycles[] = $vertex;
                        $vertex = $this->edgeTo[$vertex];
                    }
                    $this->cycles[] = $cycles;
                }
            } else {
                $this->edgeTo[$v] = $vertex;
                $this->dfs($graph, $v);
            }
        }, $graph->adj($v));
        $this->inCycle[$v] = false;
    }

    /**
     * @return array
     */
    public function getCycles(): array
    {
        return $this->cycles;
    }
}

$graph = new DiGraph(13, 'directed_cycle.txt');
$dc = new DirectedCycle($graph);
var_dump($dc->getCycles());