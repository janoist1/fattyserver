<?php

namespace FattyServer\Packet\Input;

use FattyServer\FattyServerProtocol;
use FattyServer\Handler\Connection\ConnectionHandlerInterface;


class InputPacketMapper {

    const TYPE_KEY = 'type';
    const DATA_KEY = 'data';

    /**
     * @param array $array
     * @return ConnectionHandlerInterface
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
            case FattyServerProtocol::PACKET_LOGIN:
                return new Login($array[self::DATA_KEY]);
                break;

            case FattyServerProtocol::PACKET_NEW_TABLE:
                return new NewTable($array[self::DATA_KEY]);
                break;

            case FattyServerProtocol::PACKET_SIT_DOWN:
                return new SitDown($array[self::DATA_KEY]);
                break;

            case FattyServerProtocol::PACKET_PLAYER_READY:
                return new PlayerReady();
                break;

            case FattyServerProtocol::PACKET_PLAYER_NOT_READY:
                return new PlayerNotReady();
                break;

            case FattyServerProtocol::PACKET_PLAYER_LEFT_TABLE:
                return new PlayerLeftTable();
                break;

            case FattyServerProtocol::PACKET_SWAP:
                return new Swap($array[self::DATA_KEY]);
                break;

            case FattyServerProtocol::PACKET_TURN:
                return new Turn($array[self::DATA_KEY]);
                break;

            case FattyServerProtocol::PACKET_CHAT_MESSAGE:
                return new ChatMessage($array[self::DATA_KEY]);
                break;

            default:
                throw new \Exception('Invalid message type ('. $array[self::TYPE_KEY] .')');
        }
    }
} 