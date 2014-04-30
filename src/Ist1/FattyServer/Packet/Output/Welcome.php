<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;


class Welcome extends AbstractOutputPacket
{
    /**
     * User ID
     *
     * @var string
     */
    protected $id;

    /**
     * Server version
     *
     * @var string
     */
    protected $version;

    /**
     * @param $id
     * @param $version
     */
    function __construct($id, $version)
    {
        $this->id = $id;
        $this->version = $version;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = array(
            'id' => $this->id,
            'version' => $this->version
        );

        return $data;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::PACKET_WELCOME;
    }
} 