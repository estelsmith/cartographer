<?php

namespace Cascade\Mapper\Context;

use Cascade\Mapper\MapInterface;

interface ContextInterface
{
    /**
     * @return MapInterface
     */
    public function getMap();
}
