<?php

namespace FattyServer\Exception;


abstract class AbstractGameException extends \Exception
{
    abstract public function getHandler();
}