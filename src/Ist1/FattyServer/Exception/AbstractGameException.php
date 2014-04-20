<?php

namespace FattyServer\Exception;

use FattyServer\Handler\HandleableInterface;


abstract class AbstractGameException extends \Exception implements HandleableInterface
{
}