<?php

namespace FattyServer\Table;


use FattyServer\FattyConnection;

class TableManager
{
    /**
     * @var array
     */
    protected $tables;

    /**
     * Construct.
     */
    public function __construct()
    {
        $this->tables = array();
    }

    /**
     * Creates and returns a Table.
     *
     * @param $name
     * @return Table
     */
    public function createTable($name)
    {
        return new Table($name);
    }

    /**
     * Adds a Table to the manager.
     *
     * @param Table $table
     */
    public function addTable(Table $table)
    {
        if (array_key_exists($table->getId(), $this->tables)) {
            return;
        }

        $this->tables[$table->getId()] = $table;
    }

    /**
     * Removes a Table from the manager.
     *
     * @param Table $table
     */
    public function removeTable(Table $table)
    {
        if (!array_key_exists($table->getId(), $this->tables)) {
            return;
        }

        unset($this->tables[$table->getId()]);
    }

    /**
     * Creates a Table, adds it to the manager,
     * and returns the new Table.
     *
     * @param $name
     * @return Table
     */
    public function createAndAddTable($name)
    {
        $table = $this->createTable($name);
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
        if (!array_key_exists($id, $this->tables)) {
            return null;
        }

        return $this->tables[$id];
    }

    /**
     * Returns a Table by a FattyConnection
     *
     * @param FattyConnection $conn
     * @return Table
     */
    public function getTableByConnection(FattyConnection $conn)
    {
        /** @var Table $table */
        foreach ($this->tables as $table) {
            if ($table->getPlayers()->contains($conn)) {
                return $table;
            }
        }

        return null;
    }

    /**
     * @return array
     */
    public function getTables()
    {
        return $this->tables;
    }

    /**
     * @return \SplObjectStorage
     */
    public function getPlayers()
    {
        return $this->players;
    }
} 