<?php

namespace AntonAm\JsonLD\Contracts;

interface ContextTypeInterface
{
    /**
     * @return array
     */
    public function getProperties(): array;
}
