<?php

namespace FattyServer\Exception\RuleViolation;

use FattyServer\Player\Player;


class PlayerNotValidException extends AbstractRuleViolationException
{
    /**
     * @param Player $player
     */
    function __construct(Player $player)
    {
        parent::__construct($player, 'Player not valid', 0); // todo: set a code
    }
} 