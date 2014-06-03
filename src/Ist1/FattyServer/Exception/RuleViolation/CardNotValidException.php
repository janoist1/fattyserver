<?php

namespace FattyServer\Exception\RuleViolation;

use FattyServer\Player\Player;


class CardNotValidException extends AbstractRuleViolationException
{
    /**
     * @param Player $player
     */
    function __construct(Player $player)
    {
        parent::__construct($player, 'Card not valid', 0); // todo: set a code
    }
} 