<?php

namespace FattyServer\Packet\Output;


abstract class AbstractOutputPacket
{
    abstract public function getType();
    abstract public function getData();

    public function __toString()
    {
        $packet = array(
            'type' => $this->getType(),
        );
        $data = $this->getData();

        if (!is_null($data)) {
            $packet['data'] = $data;
        }

        return json_encode($packet);
    }
}