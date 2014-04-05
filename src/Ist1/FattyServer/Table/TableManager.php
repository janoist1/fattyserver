<?php

namespace FattyServer\Table;


use FattyServer\FattyConnection;

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
    }

    /**
     * Creates and returns a Table.
     *
     * @param $name
     * @return Table
     */
    public static function createTable($name)
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
     * @return Table
     */
    public function createAndAddTable($name)
    {
        $table = self::createTable($name);
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
} 