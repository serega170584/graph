<?php


class UnionFind
{
    private $components = [];
    private $parent = [];

    public function __construct($vertexes)
    {
        array_map(function ($val) {
            $this->components[$val] = [$val];
            $this->parent[$val] = $val;
        }, $vertexes);
    }

    public function union($p, $q)
    {
        $rootP = $this->findRoot($p);
        $rootQ = $this->findRoot($q);
        if (count($this->components[$rootP]) == count($this->components[$rootQ])) {
            $root = $rootP;
            $this->components[$root] = array_merge($this->components[$root], $this->components[$rootQ]);
            $this->parent[$q] = $p;
        } elseif (count($this->components[$rootP]) > count($this->components[$rootQ])) {
            $root = $rootP;
            $this->components[$root] = array_merge($this->components[$root], $this->components[$rootQ]);
            $this->parent[$q] = $p;
        } elseif (count($this->components[$rootP]) < count($this->components[$rootQ])) {
            $root = $rootQ;
            $this->components[$root] = array_merge($this->components[$root], $this->components[$rootP]);
            $this->parent[$p] = $q;
        }
    }

    public function isConnected($p, $q)
    {
        return $this->findRoot($p) == $this->findRoot($q);
    }

    public function findRoot($p)
    {
        while ($p != $this->parent[$p]) {
            $p = $this->parent[$p];
        }
        return $p;
    }
}