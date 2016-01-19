<?php

namespace Cascade\Mapper\Value\Resolver;

class CallableValueResolver implements ValueResolverInterface
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function resolve($source, $destination)
    {
        return call_user_func(
            $this->callback,
            $source,
            $destination
        );
    }
}
