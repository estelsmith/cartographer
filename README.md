PHP Object Mapper
=================
The php-object-mapper library provides the ability to transform data from one type into another type.

[![Build Status](https://scrutinizer-ci.com/g/cascademedia/php-object-mapper/badges/build.png?b=master)](https://scrutinizer-ci.com/g/cascademedia/php-object-mapper/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/cascademedia/php-object-mapper/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/cascademedia/php-object-mapper/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/cascademedia/php-object-mapper/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/cascademedia/php-object-mapper/?branch=master)

Installation
============
To install php-object-mapper, simply require the library by executing the following composer command.

```
$ composer require cascademedia/php-object-mapper @stable
```

Alternatively, you can clone/download this repository and install the package manually.

Basic Usage
===========
Array-to-Array
--------------
TODO.

```php
class MyContext implements ContextInterface
{
    public function getMap()
    {
        return (new Map())
            ->from(Map::REF_ARRAY)
            ->to(Map::REF_ARRAY)
            ->add('first_name', 'fname')
            ->add('last_name', 'lname')
        ;
    }
}

$originalDestination = [
    'first_name' => 'TBD',
    'last_name' => 'TBD'
];

$source = [
    'fname' => 'Test First',
    'lname' => 'Test Last'
];

$mapper = new Mapper();
$context = new MyContext();

$updatedDestination = $mapper->map($originalDestination, $source, $context);
var_dump($updatedDestination);
/*
array(2) {
  'first_name' =>
  string(10) "Test First"
  'last_name' =>
  string(9) "Test Last"
}
*/
```

Array-to-Object
---------------
TODO.

```php
class User
{
    public $firstName;

    public $lastName;
}

class MyContext implements ContextInterface
{
    public function getMap()
    {
        return (new Map())
            ->from(Map::REF_ARRAY)
            ->to(Map::REF_CLASS_PROPERTIES)
            ->add('firstName', 'fname')
            ->add('lastName', 'lname')
        ;
    }
}

$destination = new User();

$source = [
    'fname' => 'Test First',
    'lname' => 'Test Last'
];

$mapper = new Mapper();
$context = new MyContext();

$mapper->map($destination, $source, $context);
var_dump($destination);
/*
class User#2 (2) {
  public $firstName =>
  string(10) "Test First"
  public $lastName =>
  string(9) "Test Last"
}
*/
```

Object-to-Object
----------------
TODO.

Object-to-Array
---------------
TODO.

Contexts
========
TODO.

References
==========
References are classes used by the mapper to to retrieve or store field data in an object or array. The mapper currently
supports array, object mutator, and object property references.

Array References
----------------
The ```ArrayReference``` class tells the mapper that you wish to access data contained within the top level of an
array.

The ```getValue()``` method allows users to retrieve data from any given array.
```php
$reference = new ArrayReference('first_name');

$data = [
    'first_name' => 'Test First',
    'last_name' => 'Test Last'
];

var_dump($reference->getValue($data));
// string(10) "Test First"
```

The ```setValue()``` method allows users to put data into any given array. Note that this method returns a copy of the
modified array and does not modify the original array passed into it.
```php
var_dump($reference->setValue($data, 'Another Test First'));
/*
array(2) {
  'first_name' =>
  string(18) "Another Test First"
  'last_name' =>
  string(9) "Test Last"
}
*/
```

Mutator References
------------------
The ```MutatorReference``` class tells the mapper that you wish to access data returned from a class' method call. By
default, this reference will attempt to use getters and setters of the named field. For example, referencing a
field named ```test``` will call ```getTest()``` and ```setTest()``` respectively, but can be configured to call other
methods if necessary.

Note that only public methods can be accessed. Accessing private and protected methods will result in a
```ReflectionException``` being thrown.

The ```getValue()``` method will call the configured getter method for the given object and return its result.
```php
class User
{
    private $firstName;

    private $lastName;

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }
}

$reference = new MutatorReference('first_name');

$user = (new User())
    ->setFirstName('Test First')
    ->setLastName('Test Last')
;

var_dump($reference->getValue($user));
// string(10) "Test First"
```

The ```setValue()``` method will call the configured setter method for the given object.
```php
var_dump($reference->setValue($user, 'Another Test First'));
/*
class User#3 (2) {
  private $firstName =>
  string(18) "Another Test First"
  private $lastName =>
  string(9) "Test Last"
}
*/
```

If the default getters and setters are not satisfactory, you can change the methods that are called via the reference's
constructor.
```php
$reference = new MutatorReference('first_name', 'retrieveFirstName', 'addFirstName');
```

Property References
-------------------
The ```PropertyReference``` class tells the mapper that you wish to access data contained within a class' public
property. Note that only public properties can be accessed. Accessing private and protected properties will result in
a ```ReflectionException``` being thrown.

The ```getValue()``` method will return the data contained in the referenced object property.
```php
class User
{
    public $firstName;

    public $lastName;
}

$reference = new PropertyReference('firstName');

$user = new User();
$user->firstName = 'Test First';
$user->lastName = 'Test Last';

var_dump($reference->getValue($user));
// string(10) "Test First"
*/
```

The ```setValue()``` method will put data into the referenced object property.
```php
var_dump($reference->setValue($user, 'Another Test First'));
/*
class User#3 (2) {
  public $firstName =>
  string(18) "Another Test First"
  public $lastName =>
  string(9) "Test Last"
}
```

Mappings
========
Mapping
-------
TODO.

Embedded Mapping
----------------
TODO.

Resolver Mapping
----------------
TODO.

Value Resolvers
===============
TODO.

Want to contribute?
===================
TODO.

License
=======
This library is MIT licensed, meaning it is free for anyone to use and modify.

```
The MIT License (MIT)

Copyright (c) 2015 Cascade Media, LLC.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```
