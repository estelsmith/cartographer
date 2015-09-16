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

Object-to-Object
----------------
TODO.

Object-to-Array
---------------
TODO.

References
==========
Array References
----------------
TODO.

Mutator References
------------------
TODO.

Property References
-------------------
TODO.

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
