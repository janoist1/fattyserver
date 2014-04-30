<?php

namespace FattyServer\Packet\Input;

use FattyServer\FattyConnection;
use FattyServer\Handler\Packet\PacketHandlerInterface;
use FattyServer\Handler\Packet\LoginHandler;
use FattyServer\Handler\Packet\NewTableHandler;
use FattyServer\Packet\Output\PacketPropagator;
use FattyServer\Player\PlayerManager;
use FattyServer\Table\TableManager;


class NewTable implements PacketHandlerInterface {

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