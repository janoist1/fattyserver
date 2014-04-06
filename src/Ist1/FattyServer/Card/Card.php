<?php

namespace FattyServer\Card;


class Card
{
    const TYPE_DUMMY = 0;
    const TYPE_CLUBS = 1;
    const TYPE_DIAMONDS = 2;
    const TYPE_HEARTS = 3;
    const TYPE_SPADES = 4;

    /**
     * @var int
     */
    protected $value;

    /**
     * @var int
     */
    protected $type;

    /**
     * @param $type
     * @param $value
     */
    function __construct($type, $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->type .'_'. $this->value;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    function __toString()
    {
        return $this->getId();
    }
} 