<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;


class GameError extends AbstractOutputPacket
{
    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $message;

    /**
     * @param string $code
     * @param string $message
     */
    function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = array(
            'code' => $this->code,
            'message' => $this->message,
        );

        return array_merge(parent::getData(), $data);
    }

    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::PACKET_GAME_ERROR;
    }
} 