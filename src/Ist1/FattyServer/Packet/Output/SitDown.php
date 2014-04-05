<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;
use FattyServer\Player\Player;
use FattyServer\Table\Table;


class SitDown extends AbstractOutputPacket
{
    /**
     * @var Player
     */
    protected $player;

    /**
     * @var Table
     */
    protected $table;

    /**
     * @param Player $player
     */
    function __construct(Player $player, Table $table)
    {
        $this->player = $player;
        $this->table = $table;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            'user_id' => $this->player->getId(),
            'table_id' => $this->table->getId()
        );
    }

    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::MSG_SIT_DOWN;
    }
}