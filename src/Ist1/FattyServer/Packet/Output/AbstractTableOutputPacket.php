<?php

namespace FattyServer\Packet\Output;

use FattyServer\Table\Table;


abstract class AbstractTableOutputPacket extends AbstractOutputPacket
{
    /**
     * @var Table
     */
    protected $table;

    /**
     * @param Table $table
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
        return array(
            'table_id' => $this->table->getId()
        );
    }
}