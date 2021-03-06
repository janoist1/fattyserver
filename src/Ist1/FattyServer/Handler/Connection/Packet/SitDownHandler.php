<?php

namespace FattyServer\Handler\Connection\Packet;

use FattyServer\FattyConnection;
use FattyServer\Handler\AbstractHandler;
use FattyServer\Handler\Connection\AbstractConnectionHandler;
use FattyServer\Packet\Input;
use FattyServer\Packet\Output;
use FattyServer\Packet\Output\Gathering;
use FattyServer\Packet\Output\PacketPropagator;
use FattyServer\Player\Player;
use FattyServer\Player\PlayerManager;
use FattyServer\Table\Table;
use FattyServer\Table\TableManager;


class SitDownHandler extends AbstractConnectionHandler
{
    /**
     * @var Input\SitDown
     */
    protected $packet;

    /**
     * @param PlayerManager $playerManager
     * @param TableManager $tableManager
     * @param PacketPropagator $propagator
     * @param FattyConnection $connection
     * @param Input\SitDown $packet
     */
    function __construct(
        PlayerManager $playerManager,
        TableManager $tableManager,
        PacketPropagator $propagator,
        FattyConnection $connection,
        Input\SitDown $packet)
    {
        parent::__construct(
            $playerManager,
            $tableManager,
            $propagator,
            $connection
        );

        $this->packet = $packet;
    }

    /**
     * Handles a sit down at a table request.
     */
    public function handle()
    {
        $player = $this->playerManager->getPlayers()->getOne($this->connection);
        $table = $this->tableManager->getTableByPlayer($player);

        if ($table !== null) {
            // todo: handle Player already sat to another Table
            return;
        }

        $table = $this->tableManager->getTableById($this->packet->getTableId());

        if ($table === null) {
            // todo: handle Table not exists
            return;
        }
        if ($table->isFull()) {
            // todo: handle max Player limit reached, no more can sit
            return;
        }
        if ($table->hasPlayer($player)) {
            // todo: handle Player already sat to this Table
            return;
        }
        if ($table->isReady()) {
            // todo: handle Table is ready, no more Player can sit
            return;
        }

        $this->sitDown($player, $table);
    }
} 