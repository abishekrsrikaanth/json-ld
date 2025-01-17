<?php

namespace AntonAm\JsonLD\ContextTypes;

/**
 * https://schema.org/Corporation
 */
class Corporation extends Organization
{
    /**
     * Property structure
     *
     * @var array
     */
    protected $structure = [
        'tickerSymbol' => null,
    ];
}