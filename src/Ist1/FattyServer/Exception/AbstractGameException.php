<?php

namespace FattyServer\Exception;

use FattyServer\Handler\HandlerInterface;


abstract class AbstractGameException extends \Exception implements HandlerInterface
{
}