<?php

namespace FattyServer\Handler\Exception;

use FattyServer\Exception\RuleViolation\AbstractRuleViolationException;
use FattyServer\Handler\AbstractHandler;
use FattyServer\Packet\Output\PacketPropagator;
use FattyServer\Packet\Output\RuleViolation;
use FattyServer\Player\PlayerManager;
use FattyServer\Table\TableManager;


class RuleViolationHandler extends AbstractHandler
{
    /**
     * @var AbstractRuleViolationException
     */
    private $exception;

    /**
     * @param PlayerManager $playerManager
     * @param TableManager $tableManager
     * @param PacketPropagator $propagator
     * @param AbstractRuleViolationException $exception
     */
    function __construct(
        PlayerManager $playerManager,
        TableManager $tableManager,
        PacketPropagator $propagator,
        AbstractRuleViolationException $exception)
    {
        parent::__construct($playerManager, $tableManager, $propagator);

        $this->exception = $exception;
    }

    /**
     * Handles rule violation exception.
     */
    public function handle()
    {
        $this->exception->getPlayer()->getConnection()->sendPacket(
            new RuleViolation($this->exception)
        );
    }
} 