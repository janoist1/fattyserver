<?php

namespace FattyServer\Exception\RuleViolation;

use FattyServer\Player\Player;


class WrongTurnException extends AbstractRuleViolationException
{
    /**
     * @param Player $player
     */
    function __construct(Player $player)
    {
        parent::__construct($player, 'Wrong turn', 0); // todo: set a code
    }
} 