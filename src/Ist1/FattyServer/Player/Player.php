<?php

namespace FattyServer\Player;

use FattyServer\FattyConnection;


class Player
{
    /**
     * @var FattyConnection
     */
    protected $connection;

    /**
     * @var string
     */
    protected $name;


    function __construct(FattyConnection $conn, $name)
    {
        $this->connection = $conn;
        $this->name = $name;
    }

    /**
     * @return FattyConnection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->connection->getId();
    }
}