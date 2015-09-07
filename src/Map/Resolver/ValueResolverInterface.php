<?php

namespace Cascade\Mapper\Map\Resolver;

interface ValueResolverInterface
{
    /**
     * @param mixed $source
     * @return mixed
     */
    public function resolve($source);
}
