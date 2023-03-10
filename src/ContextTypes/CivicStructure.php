<?php

namespace AntonAm\JsonLD\ContextTypes;

/**
 * https://schema.org/CivicStructure
 */
class CivicStructure extends Place
{
    /**
     * Property structure
     *
     * @var array
     */
    protected $structure = [
        'openingHours' => null,
    ];
}
