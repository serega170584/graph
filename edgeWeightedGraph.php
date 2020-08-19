<?php

require_once 'graphInterface.php';

class EdgeWeightedGraph implements GraphInterface
{
    /**
     * @var mixed
     */
    private $fileName;
    /**
     * @var int
     */
    private $vertexesCount;
    private $weighted;

    /**
     * @return int
     */
    public function getVertexesCount(): int
    {
        return $this->vertexesCount;
    }

    /**
     * @var array
     */
    private $graph;
    /**
     * @var int
     */
    private $edgesCount;

    private $edges = [];

    function __construct(int $vertexesCount, $fileName = null, $isFile = true, $edges = [])
    {
        $this->vertexesCount = $vertexesCount;
        if ($isFile) {
            if ($fileName) {
                $this->fileName = $fileName;
            }
            $handle = fopen($this->fileName, 'r');
            $this->edgesCount = (int)fgets($handle);
            for ($i = 0; $i < $this->edgesCount; ++$i) {
                $row = fgets($handle);
                $v = explode(' ', trim($row));
                $this->graph[$v[0]][$v[1]] = $v[2];
            }
        }
    }

    public function getWeight($v, $w)
    {
        return $this->graph[$v][$w];
    }

    public function adj(int $v)
    {
        return array_keys($this->graph[$v] ?? []);
    }

    public function getEdges()
    {
        array_map(function ($rows, $v) {
            array_map(function ($weight, $w) use ($v) {
                $weighted = $this->weighted[$w][$v] ?? false;
                if (!$weighted) {
                    $this->weighted[$v][$w] = true;
                    $this->edges[$weight][] = [$v, $w];
                }
            }, $rows, array_keys($rows));
        }, $this->graph, array_keys($this->graph));
        ksort($this->edges);
        return $this->edges;
    }

    public function addEdge(int $v, int $w, $weight)
    {
        $this->graph[$v][$w] = $weight;
    }
}