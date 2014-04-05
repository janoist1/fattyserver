<?php

namespace FattyServer\Table;

use FattyServer\Player\Player;
use FattyServer\Player\PlayerStorage;


class Table extends PlayerStorage
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param $name
     */
    function __construct($name)
    {
        parent::__construct();

        $this->id = uniqid();
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return \SplObjectStorage
     */
    public function getPlayers()
    {
        return $this->players;
    }
} 