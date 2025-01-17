<?php

namespace AntonAm\JsonLD;

use AntonAm\JsonLD\ContextTypes\BreadcrumbList;
use AntonAm\JsonLD\ContextTypes\GeoCoordinates;
use AntonAm\JsonLD\ContextTypes\LocalBusiness;
use AntonAm\JsonLD\ContextTypes\PostalAddress;
use InvalidArgumentException;
use AntonAm\JsonLD\Contracts\ContextTypeInterface;

class Context
{
    /**
     * Context type
     *
     * @var ContextTypeInterface
     */
    protected $context = null;

    /**
     * Create a new Context instance
     *
     * @param string $context
     * @param array  $data
     */
    public function __construct($context, array $data = [])
    {
        $class = $this->getContextTypeClass($context);

        $this->context = new $class($data);
    }

    /**
     * Present given data as a JSON-LD object.
     *
     * @param string $context
     * @param array  $data
     *
     * @return static
     */
    public static function create($context, array $data = []): self
    {
        return new self($context, $data);
    }

    /**
     * Return the array of context properties.
     *
     * @return array
     */
    public function getProperties(): array
    {
        return array_filter($this->context->getProperties());
    }

    /**
     * Generate the JSON-LD script tag.
     *
     * @return string
     */
    public function generate(): string
    {
        $properties = $this->getProperties();

        return $properties
            ? "<script type=\"application/ld+json\">" . json_encode($properties, JSON_HEX_APOS | JSON_UNESCAPED_UNICODE) . "</script>"
            : '';
    }

    /**
     * Return script tag.
     *
     * @param string $name
     *
     * @return string|null
     * @throws InvalidArgumentException
     */
    protected function getContextTypeClass($name): ?string
    {
        // Check for custom context type
        if (class_exists($name)) {
            return $name;
        }

        // Create local context type class
        $class = ucwords(str_replace(['-', '_'], ' ', $name));
        $class = '\\AntonAm\\JsonLD\\ContextTypes\\' . str_replace(' ', '', $class);

        // Check for local context type
        if (class_exists($class)) {
            return $class;
        }

        // Backwards compatible, remove in a future version
        switch ($name) {
            case 'address':
                return PostalAddress::class;
            case 'business':
                return LocalBusiness::class;
            case 'breadcrumbs':
                return BreadcrumbList::class;
            case 'geo':
                return GeoCoordinates::class;
        }

        throw new InvalidArgumentException(sprintf('Undefined context type: "%s"', $name));
    }

    /**
     * Return script tag.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->generate();
    }
}
