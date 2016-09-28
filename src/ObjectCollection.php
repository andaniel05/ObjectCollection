<?php

namespace Andaniel05\ObjectCollection;

use Andaniel05\ObjectCollection\Exception\ClassNotFoundException;
use Andaniel05\ObjectCollection\Exception\InvalidObjectTypeException;

/**
 * Representa una colección de objetos de un mismo tipo.
 *
 * Internamente se usa un array nativo para almacenar los elementos. En el constructor
 * de la clase se tiene que especificar el tipo de elementos que se almacenarán.
 * Este tipo de elementos puede ser tanto un nombre de clase como de interfaz.
 *
 * En el momento de insertar elementos se va a chequear que el tipo de ese nuevo elemento
 * se corresponda con el que se especificó en el constructor de la clase, por lo que se
 * garantiza que el array solo contendrá elementos del tipo especificado.
 *
 * @author Andy D. Navarro Taño <andaniel05@gmail.com>
 * @version 1.0.0
 */
class ObjectCollection implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * Tipo de elementos.
     *
     * @var string
     */
    protected $class;

    /**
     * Array de almacenamiento.
     *
     * @var array
     */
    protected $array;

    /**
     * Constructor.
     *
     * @param string $class Nombre de clase o de interfaz que representa el tipo de elementos.
     *
     * @throws Andaniel05\ObjectCollection\Exception\ClassNotFoundException   Este error se produce cuando la clase o interfaz especificada no existe.
     */
    public function __construct($class)
    {
        if (false === class_exists($class) && false === interface_exists($class)) {
            throw new ClassNotFoundException($class);
        }

        $this->class = $class;
        $this->array = array();
    }

    /**
     * Devuelve el tipo de almacenamiento.
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Devuelve el array resultante.
     *
     * @return array
     */
    public function getArray()
    {
        return $this->array;
    }

    /**
     * {@inheritdoc}
     *
     * @throws Andaniel05\ObjectCollection\Exception\InvalidObjectTypeException   Este error se produce cuando se intenta almacenar un valor que no es del tipo permitido.
     */
    public function offsetSet($index, $obj)
    {
        if (false === is_object($obj) || false === $obj instanceOf $this->class) {
            throw new InvalidObjectTypeException($this->class, get_class($obj));
        }

        if (false === is_null($index)) {
            $this->array[$index] = $obj;
        } else {
            $this->array[] = $obj;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($index)
    {
        return $this->array[$index];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($index)
    {
        return isset($this->array[$index]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($index)
    {
        unset($this->array[$index]);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->array);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->array);
    }
}