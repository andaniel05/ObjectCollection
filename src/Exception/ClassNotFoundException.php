<?php

namespace Andaniel05\ObjectCollection\Exception;

class ClassNotFoundException extends ObjectCollectionException
{
    public function __construct($class)
    {
        parent::__construct(sprintf('La clase o la interfaz %s no se encuentra.', $class));
    }
}