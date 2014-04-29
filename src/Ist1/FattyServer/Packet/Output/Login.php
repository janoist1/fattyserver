<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;


class Login extends AbstractOutputPacket
{
    /**
     * @var bool
     */
    protected $success;

    /**
     * @var int
     */
    protected $code;

    /**
     * @var string
     */
    protected $message;

    /**
     * Login Packet.
     *
     * @param bool $success
     * @param int $code
     * @param string $message
     */
    function __construct($success = true, $code = null, $message = null)
    {
        $this->success = $success;
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = array(
            'success' => $this->success
        );

        if ($this->code !== null) {
            $data['code'] = $this->code;
        }
        if ($this->message !== null) {
            $data['message'] = $this->message;
        }

        return $data;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::MSG_LOGIN;
    }
} 