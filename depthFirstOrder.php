<?php
require_once('diGraph.php');

class DepthFirstOrder
{
    /**
     * @var array
     */
    private $pre = [];
    /**
     * @var array
     */
    private $post = [];
    /**
     * @var array
     */
    private $reversePost = [];
    /**
     * @var array
     */
    private $marked = [];

    /**
     * @return array
     */
    public function getReversePost(): array
    {
        return $this->reversePost;
    }


    public function __construct(GraphInterface $graph)
    {
        $this->marked = array_fill(0, $graph->getVertexesCount(), false);
        $vertexes = array_keys($this->marked);
        foreach ($vertexes as $v) {
            if (!$this->marked[$v]) {
                $this->dfs($graph, $v);
            }
        }
    }

    private function dfs(GraphInterface $graph, int $v)
    {
        $this->pre[] = $v;
        $this->marked[$v] = true;
        array_map(function ($v) use ($graph) {
            if (!$this->marked[$v]) {
                $this->dfs($graph, $v);
            }
        }, $graph->adj($v));
        $this->post[] = $v;
        $this->reversePost = array_merge([$v], $this->reversePost);
    }

    /**
     * @return array
     */
    public function getPost(): array
    {
        return $this->post;
    }

    /**
     * @return array
     */
    public function getPre(): array
    {
        return $this->pre;
    }
}

//$graph = new DiGraph(13, 'depth_first_order.txt');
//$dfs = new DepthFirstOrder($graph);
