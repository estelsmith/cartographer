<?php

namespace Cascade\Mapper\Context;

use Cascade\Mapper\Map\MapInterface;

interface ContextInterface
{
    /**
     * @return MapInterface
     */
    public function getMap();
}
