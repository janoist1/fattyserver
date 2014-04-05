<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;


class Gathering extends AbstractOutputPacket
{
    /**
     * Table ID
     *
     * @var string
     */
    protected $id;

    /**
     * @param $id
     */
    function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = array(
            'table_id' => $this->id
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