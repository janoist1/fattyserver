<?php

namespace FattyServer\Exception\RuleViolation;

use FattyServer\Exception\AbstractGameException;
use FattyServer\Handler\Exception\RuleViolationHandler;
use FattyServer\Player\Player;
use FattyServer\Player\PlayerManager;
use FattyServer\Table\TableManager;
use FattyServer\Packet\Output\PacketPropagator;


abstract class AbstractRuleViolationException extends AbstractGameException
{
    /**
     * @var Player
     */
    private $player;

    /**
     * @param Player $player
     * @param string $message
     * @param int $code
     */
    function __construct(Player $player, $message = "", $code = 0)
    {
        parent::__construct($message, $code);

        $this->player = $player;
    }

    /**
     * {@inheritdoc}
     */
    public function getHandler(
        PlayerManager $playerManager,
        TableManager $tableManager,
        PacketPropagator $propagator)
    {
        return new RuleViolationHandler(
            $playerManager,
            $tableManager,
            $propagator,
            $this
        );
    }

    /**
     * @return Player
     */
    public function getPlayer()
    {
        return $this->player;
    }
}