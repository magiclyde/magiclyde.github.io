<?php

/**
 * 一致性 hash
 *
 * @see https://www.cnblogs.com/jajian/p/10896624.html
 * @example
    
        $ch =   new ConsistentHash();

        $ch->addNode('a');
        $ch->addNode('b');
        $ch->addNode('c');
        $ch->addNode('d');

        $key1 = '41.63.160.0'; 
        $key2 = '66.178.44.136'; 
        $key3 = '4.69.240.28'; 
        echo 'key ' . $key1 . ' in: ' . $ch->lookup($key1) . ' node' . PHP_EOL;
        echo 'key ' . $key2 . ' in: ' . $ch->lookup($key2) . ' node' . PHP_EOL;
        echo 'key ' . $key3 . ' in: ' . $ch->lookup($key3) . ' node' . PHP_EOL;
    
 */
class ConsistentHash
{
    protected $nodes = []; // 物理节点
    protected $position = []; // 虚拟节点
	protected $mul = 64; // 每个物理节点对应64个虚拟节点


    public function lookup($key)
    {
        $point = $this->hash($key);

        $node = current($this->position);

        foreach ($this->position as $key => $val) {
            if ($point <= $key) {
                $node = $val;
                break;
            }
        }

        reset($this->position);

        return $node;
    }

    public function addNode($node)
    {
        if (isset($this->nodes[$node])) {
            return ;
        }

        // 添加物理节点和虚拟节点
        for ($i=0; $i < $this->mul; $i++) { 
            $pos = $this->hash($node . '-' . $i);
            $this->position[$pos] = $node;
            $this->nodes[$node][] = $pos;
        }

        $this->sortPos();
    }

    public function delNode($node)
    {
        if (!isset($this->nodes[$node])) {
            return ;
        }

        // 循环删除虚拟节点
        foreach ($this->nodes[$nodes] as $pos) {
            unset($this->position[$pos]);
        }


        // 删除物理节点
        unset($this->nodes[$node]);
    }

    protected function hash($str)
    {
        return sprintf("%u", crc32($str));
    }

    protected function sortPos()
    {
        ksort($this->position, SORT_REGULAR);
    }

}


