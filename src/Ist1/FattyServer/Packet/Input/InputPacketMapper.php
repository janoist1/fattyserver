<?php

namespace FattyServer\Packet\Input;

use FattyServer\FattyServerProtocol;


class InputPacketMapper {

    const TYPE_KEY = 'type';
    const DATA_KEY = 'data';

    /**
     * @param array $array
     * @return InputPacketInterface
     * @throws \Exception
     */
    static public function map(array $array)
    {
        if (!is_array($array) || count($array) < 1) {
            throw new \UnexpectedValueException("Invalid packet format");
        }
        if (!array_key_exists(self::TYPE_KEY, $array)) {
            throw new \Exception('Packet type is missing');
        }

        switch ($array[self::TYPE_KEY]) {
            case FattyServerProtocol::MSG_LOGIN:
                return new Login($array[self::DATA_KEY]);
                break;

            case FattyServerProtocol::MSG_SIT_DOWN:
                return new SitDown($array[self::DATA_KEY]);
                break;

            case FattyServerProtocol::MSG_PLAYER_READY:
                return new PlayerReady();
                break;

            case FattyServerProtocol::MSG_SWAP:
                return new Swap($array[self::DATA_KEY]);
                break;

            case FattyServerProtocol::MSG_PUT_CARD:
                return new PutCard($array[self::DATA_KEY]);
                break;

            case FattyServerProtocol::MSG_CHAT_MESSAGE:
                return new ChatMessage($array[self::DATA_KEY]);
                break;

            default:
                throw new \Exception('Invalid message type');
        }
    }
} 