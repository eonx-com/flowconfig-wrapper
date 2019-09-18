<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\FlowConfig\Stubs\Services;

use LoyaltyCorp\FlowConfig\Database\Interfaces\FlowConfigurableInterface;
use LoyaltyCorp\FlowConfig\Services\Interfaces\FlowConfigInterface;

/**
 * This class explicitly exposes a functional equivalent of the FlowConfig service without
 *  a backing database.
 *
 * This class can be freely used for testing purposes in dependant projects.
 *
 * @coversNothing
 */
class FlowConfigStub implements FlowConfigInterface
{
    /**
     * @var string[]
     */
    private $defaults;

    /**
     * @var string[][][]
     */
    private $entityConfig;

    /**
     * @var string[]
     */
    private $systemConfig;

    public function __construct(?array $defaults = null)
    {
        $this->defaults = $defaults ?? [];
    }

    public function get(string $key, ?string $default = null): ?string
    {
        return $this->systemConfig[$key] ?? $this->defaults[$key] ?? $default ?? null;
    }

    public function getByEntity(FlowConfigurableInterface $entity, string $key, ?string $default = null): ?string
    {
        return $this->entityConfig[$entity->getEntityType()][$entity->getEntityId()][$key]
            ?? $this->systemConfig[$key]
            ?? $this->defaults[$key]
            ?? $default
            ?? null;
    }

    public function set(string $key, string $value): void
    {
        $this->systemConfig[$key] = $value;
    }

    public function setByEntity(FlowConfigurableInterface $entity, string $key, string $value): void
    {
        $this->entityConfig[$entity->getEntityType()][$entity->getEntityId()][$key] = $value;
    }
}
