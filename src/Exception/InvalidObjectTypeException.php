<?php

namespace Andaniel05\ObjectCollection\Exception;

class InvalidObjectTypeException extends ObjectCollectionException
{
    public function __construct($expected, $actual)
    {
        parent::__construct(sprintf('Los tipos de objeto no coinciden. El tipo esperado es %s y el tipo actual fué %s', $expected, $actual));
    }
}