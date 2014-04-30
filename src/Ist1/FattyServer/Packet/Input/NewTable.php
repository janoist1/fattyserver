<?php

namespace FattyServer\Packet\Input;

use FattyServer\FattyConnection;
use FattyServer\Handler\Connection\ConnectionHandlerInterface;
use FattyServer\Handler\Connection\Packet\LoginHandler;
use FattyServer\Handler\Connection\Packet\NewTableHandler;
use FattyServer\Packet\Output\PacketPropagator;
use FattyServer\Player\PlayerManager;
use FattyServer\Table\TableManager;


class NewTable implements ConnectionHandlerInterface {

    /**
     * @var string
     */
    protected $name;

    /**
     * @param array $data
     * @throws \Exception
     */
    function __construct(array $data = null)
    {
        if (!is_array($data)) {
            throw new \Exception('Invalid NewTable packet');
        }

        if (!array_key_exists('name', $data)) {
            throw new \Exception('NewTable name missing');
        }

        $this->name = $data['name'];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getHandler(
        PlayerManager $playerManager,
        TableManager $tableManager,
        PacketPropagator $propagator,
        FattyConnection $connection)
    {
        return new NewTableHandler(
            $playerManager,
            $tableManager,
            $propagator,
            $connection,
            $this
        );
    }
} 