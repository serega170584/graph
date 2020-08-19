<?php
require_once 'graphInterface.php';

class DiGraph implements GraphInterface
{
    private $graph = [];
    private $edgesCount = 0;
    private $vertexesCount = 0;
    private $fileName = 'di_graph.txt';

    function __construct(int $vertexesCount, $fileName = null, $isFile = true, $edges = [])
    {
        if ($fileName) {
            $this->fileName = $fileName;
        }
        $this->vertexesCount = $vertexesCount;
        $this->graph = array_combine(range(0, $vertexesCount - 1), array_fill(0, $vertexesCount, []));
        if ($isFile) {
            $handle = fopen($this->fileName, 'r');
            $this->edgesCount = (int)fgets($handle);
            for ($i = 0; $i < $this->edgesCount; ++$i) {
                $row = fgets($handle);
                $v = array_map(function ($val) {
                    return (int)$val;
                }, explode(' ', trim($row)));
                $this->graph[$v[0]][] = $v[1];
            }
        } else {
            $this->edgesCount = count($edges);
            $this->graph = $edges;
        }
    }

    public function reverse()
    {
        $reverse = [];
        foreach ($this->graph as $vertexesKey => $vertexes) {
            foreach ($vertexes as $key => $val) {
                $reverse[$val][] = $vertexesKey;
            }
        }
        return new DiGraph($this->vertexesCount, null, false, $reverse);
    }

    public function adj(int $v)
    {
        return $this->graph[$v];
    }

    public function degree(int $v)
    {
        return count($this->adj($v));
    }

    public function maxDegree()
    {
        $counts = array_combine(array_map(function ($val) {
            return $val;
        }, array_keys($this->graph)), array_map(function ($rows) {
            return count($rows);
        }, $this->graph));
        arsort($counts);
        return array_shift($counts);
    }

    public function avgDegree()
    {
        return 2 * $this->edgesCount / $this->vertexesCount;
    }

    public function __toString()
    {
        $output = sprintf("%d вершин, %d ребер\r\n", $this->vertexesCount, $this->edgesCount);
        $output .= implode("\r\n", array_map(function ($adj, $vertex) {
            return implode("\r\n", array_map(function ($adjVertex) use ($vertex) {
                return sprintf('%d %d', $adjVertex, $vertex);
            }, $adj));
        }, $this->graph, array_keys($this->graph)));
        return $output;
    }

    /**
     * @return int
     */
    public function getEdgesCount(): int
    {
        return $this->edgesCount;
    }

    /**
     * @return int
     */
    public function getVertexesCount(): int
    {
        return $this->vertexesCount;
    }
}

//$diGraph = new DiGraph(7);
