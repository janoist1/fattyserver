<?php

namespace FattyServer\Packet\Input;

use FattyServer\Handler\LoginHandler;
use FattyServer\Handler\SitDownHandler;


class SitDown implements InputPacketInterface {

    /**
     * @var string
     */
    protected $tableId;

    /**
     * @param array $data
     * @throws \Exception
     */
    function __construct(array $data = null)
    {
        if (!is_array($data)) {
            throw new \Exception('Invalid SitDown packet');
        }

        if (!array_key_exists('table_id', $data)) {
            throw new \Exception('SitDown table_id missing');
        }

        $this->tableId = $data['table_id'];
    }

    /**
     * @return string
     */
    public function getTableId()
    {
        return $this->tableId;
    }

    /**
     * @return LoginHandler
     */
    public function getHandler()
    {
        return new SitDownHandler($this);
    }
} 