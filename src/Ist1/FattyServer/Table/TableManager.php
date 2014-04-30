<?php

namespace FattyServer\Table;


use FattyServer\FattyConnection;
use FattyServer\Player\Player;

class TableManager
{
    const DEFAULT_TABLE_NAME = 'default';

    /**
     * @var \SplObjectStorage
     */
    protected $tables;

    /**
     * Construct.
     */
    public function __construct()
    {
        $this->tables = new \SplObjectStorage();

        $this->createAndAddTable(self::DEFAULT_TABLE_NAME, false);
    }

    /**
     * Adds a Table to the manager.
     *
     * @param Table $table
     */
    public function addTable(Table $table)
    {
        $this->tables->attach($table);
    }

    /**
     * Adds a Table to the manager.
     *
     * @param Table $table
     */
    public function removeTable(Table $table)
    {
        $this->tables->offsetUnset($table);
    }

    /**
     * @return \SplObjectStorage
     */
    public function getTables()
    {
        return $this->tables;
    }

    /**
     * Creates a Table, adds it to the manager,
     * and returns the new Table.
     *
     * @param $name
     * @param bool $isTemporary
     * @return Table
     */
    public function createAndAddTable($name, $isTemporary = true)
    {
        $table = new Table($name, $isTemporary);

        $this->addTable($table);

        return $table;
    }

    /**
     * Returns a Table by Id
     *
     * @param string $id
     * @return Table
     */
    public function getTableById($id)
    {
        /** @var Table $table */
        foreach ($this->tables as $table) {
            if ($table->getId() == $id) {
                return $table;
            }
        }

        return null;
    }

    /**
     * Returns a Table by its name
     *
     * @param string $name
     * @return Table
     */
    public function getTableByName($name)
    {
        /** @var Table $table */
        foreach ($this->tables as $table) {
            if ($table->getName() == $name) {
                return $table;
            }
        }

        return null;
    }

    /**
     * Returns a Table by a FattyConnection
     *
     * @param Player $player
     * @return Table
     */
    public function getTableByPlayer(Player $player)
    {
        /** @var Table $table */
        foreach ($this->tables as $table) {
            // todo: check if Player has finished
            if ($table->getPlayers()->getAll()->contains($player->getConnection())) {
                return $table;
            }
        }

        return null;
    }
} 