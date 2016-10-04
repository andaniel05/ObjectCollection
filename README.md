ObjectCollection
================

Representa una colección de objetos de un mismo tipo.

## Funcionamiento interno

Internamente se usa un array nativo para almacenar los elementos. En el constructor de la clase se tiene que especificar el tipo de elementos que se almacenarán. Este tipo de elementos puede ser tanto un nombre de clase como de interfaz. En el momento de insertar elementos se va a chequear que el tipo de ese nuevo elemento se corresponda con el que se especificó en el constructor de la clase, por lo que se garantiza que el array solo contendrá elementos del tipo especificado.

## Requerimientos

PHP 5.3+

## Ejemplos de uso


Ejemplo1. Operaciones básicas con la clase.

```php
<?php

use Andaniel05\ObjectCollection\ObjectCollection;

class Person
{
    public $name;
    public $age;

    public function __construct($name, $age)
    {
        $this->name = $name;
        $this->age = $age;
    }
}

$andy    = new Person('andy', 27);
$andria  = new Person('andria', 35);
$sonia   = new Person('sonia', 52);
$antonio = new Person('antonio', 54);

$collection = new ObjectCollection('Person');

// Inserción con índices.
$collection['andy']   = $andy;
$collection['andria'] = $andria;

// Inserción sin índices (añade al final del array).
$collection[] = $sonia;
$collection[] = $antonio;

// Recorridos en forma de array. Hay garantía de que $person será siempre una
// instancia de la clase Person.
foreach ($collection as $index => $person) {
    echo "Index: {$key}, Name: {$person->getName()}, Age: {$person->getAge()}\n";
}

// Contar elementos.
echo count($collection); // Devuelve 4.

// Obtener elementos.
$andy1 = $collection['andy'];

// Comprobar existencia de elementos.
echo isset($collection['andy']); // Devuelve TRUE.

// Eliminar elementos.
unset($collection['andria']);

// Obtener el array de la colección.
$array = $collection->getArray();


```

Ejemplo2. Creación de un tipo de colección personalizada.

```php
<?php

use Andaniel05\ObjectCollection\ObjectCollection;

/**
 * Tipo de colección personalizada que solo admite instancias de la clase 'Person'.
 */
class PersonCollection extends ObjectCollection
{
    public function __construct()
    {
        parent::__construct('Person');
    }
}

// Sobre las instancias de la clase PersonCollection se aplican las mismas
// operaciones del ejemplo anterior.
$collection = new PersonCollection;

```