<?php

namespace Cascade\Mapper;

use Cascade\Mapper\Context\ContextInterface;

interface MapperInterface
{
    /**
     * @param mixed $destination
     * @param mixed $source
     * @param ContextInterface $context
     * @return mixed
     */
    public function map($destination, $source, ContextInterface $context);
}
