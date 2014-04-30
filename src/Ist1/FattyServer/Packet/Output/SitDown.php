<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;
use FattyServer\Player\Player;
use FattyServer\Table\Table;


class SitDown extends AbstractPlayerOutputPacket
{
    /**
     * @var Table
     */
    protected $table;

    /**
     * @param Player $player
     * @param Table $table
     */
    function __construct(Player $player, Table $table)
    {
        parent::__construct($player);
        $this->table = $table;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = array(
            'table_id' => $this->table->getId()
        );

        return array_merge(parent::getData(), $data);
    }

    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::MSG_SIT_DOWN;
    }
}