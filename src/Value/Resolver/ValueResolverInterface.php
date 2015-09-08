<?php

namespace Cascade\Mapper\Value\Resolver;

interface ValueResolverInterface
{
    /**
     * @param mixed $source
     * @return mixed
     */
    public function resolve($source);
}
