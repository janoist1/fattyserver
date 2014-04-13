<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;
use FattyServer\Table\Table;


abstract class AbstractListOutputPacket extends AbstractOutputPacket
{
    /**
     * @var \Iterator
     */
    protected $items;

    /**
     * @param \Iterator $items
     */
    function __construct(\Iterator $items)
    {
        $this->items = $items;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = array();

        foreach ($this->items as $obj) {
            $item = $this->isDataStorage() ? $this->items[$obj] : $obj;
            $data[] = $this->getItemData($item);
        }

        return $data;
    }

    /**
     * @param $item
     * @return array
     */
    abstract public function getItemData($item);

    /**
     * @return bool
     */
    abstract public function isDataStorage();
}