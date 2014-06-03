<?php

namespace FattyServer\Exception\RuleViolation;

use FattyServer\Player\Player;


class WrongTableException extends AbstractRuleViolationException
{
    /**
     * @param Player $player
     */
    function __construct(Player $player)
    {
        parent::__construct($player, 'Wrong table', 0); // todo: set a code
    }
} 