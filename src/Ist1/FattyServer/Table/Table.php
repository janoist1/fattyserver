<?php

namespace FattyServer\Table;


class Table {

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var \SplObjectStorage
     */
    protected $players;

    /**
     * @param $name
     */
    function __construct($name)
    {
        $this->id = uniqid();
        $this->name = $name;
        $this->players = new \SplObjectStorage();
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