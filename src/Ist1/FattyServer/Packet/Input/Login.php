<?php

namespace FattyServer\Packet\Input;

use FattyServer\Handler\LoginHandler;


class Login implements InputPacketInterface {

    /**
     * @var string
     */
    protected $name;

    /**
     * @param array $data
     * @throws \Exception
     */
    function __construct(array $data = null)
    {
        if (!is_array($data)) {
            throw new \Exception('Invalid Login packet');
        }

        if (!array_key_exists('name', $data)) {
            throw new \Exception('Login name missing');
        }

        $this->name = $data['name'];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return LoginHandler
     */
    public function getHandler()
    {
        return new LoginHandler($this);
    }
} 