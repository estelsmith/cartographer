<?php

namespace Cascade\Mapper\Value\Resolver;

interface ValueResolverInterface
{
    /**
     * @param mixed $source
     * @param mixed $destination
     * @return mixed
     */
    public function resolve($source, $destination);
}
