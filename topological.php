<?php
require_once 'graphInterface.php';
//require_once('diGraph.php');
require_once('depthFirstOrder.php');

class Topological
{
    /**
     * @var DepthFirstOrder
     */
    private $depthFirstOrder;
    /**
     * @var array
     */
    private $order;

    public function __construct(GraphInterface $graph)
    {
        $this->depthFirstOrder = new DepthFirstOrder($graph);
        $this->order = $this->depthFirstOrder->getReversePost();
    }

    /**
     * @return array
     */
    public function getOrder(): array
    {
        return $this->order;
    }
}

//$graph = new DiGraph(13, 'depth_first_order.txt');
//$t = new Topological($graph);
//var_dump($t->getOrder());