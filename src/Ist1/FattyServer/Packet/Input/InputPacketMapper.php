<?php

namespace FattyServer\Packet\Input;

use FattyServer\FattyServerProtocol;


class InputPacketMapper {

    /**
     * @param array $array
     * @return InputPacketInterface
     * @throws \Exception
     */
    static public function map(array $array)
    {
        switch ($array['type']) {
            case FattyServerProtocol::MSG_LOGIN:
                return new Login($array['data']);
                break;

            case FattyServerProtocol::MSG_PUT_CARD:

                break;

            case FattyServerProtocol::MSG_CHAT_MESSAGE:
                return new ChatMessage($array['data']);
                break;

            default:
                throw new \Exception('Invalid message type');
        }
    }
} 