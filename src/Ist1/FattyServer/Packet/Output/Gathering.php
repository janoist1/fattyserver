<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;
use FattyServer\Table\Table;


class Gathering extends AbstractOutputPacket
{
    /**
     * @var Table
     */
    protected $table;

    /**
     * @param $id
     */
    function __construct(Table $table)
    {
        $this->table = $table;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = array(
            'table_id' => $this->table->getId()
        );

        return $data;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::MSG_GATHERING;
    }
} 