<?php

namespace FattyServer\Packet\Output;

use FattyServer\Exception\RuleViolation\AbstractRuleViolationException;
use FattyServer\FattyServerProtocol;


class RuleViolation extends AbstractOutputPacket
{
    /**
     * Exception object
     *
     * @var string
     */
    protected $exception;

    /**
     * @param AbstractRuleViolationException $exception
     */
    function __construct(AbstractRuleViolationException $exception)
    {
        $this->exception = $exception;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = array(
            'code' => $this->exception->getCode(),
            'message' => $this->exception->getMessage()
        );

        return $data;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::PACKET_RULE_VIOLATION;
    }
} 