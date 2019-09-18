<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\FlowConfig\Stubs\External\FlowConfig;

use CodeFoundation\FlowConfig\Interfaces\CompositeConfigRepositoryInterface;
use CodeFoundation\FlowConfig\Interfaces\EntityIdentifier;

class CompositeConfigRepositoryStub implements CompositeConfigRepositoryInterface
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

    /**
     * CompositeConfigRepositoryStub constructor.
     *
     * @param string[]|null $defaults
     */
    public function __construct(?array $defaults = null)
    {
        $this->defaults = $defaults ?? [];
    }

    /**
     * {@inheritdoc
     */
    public function canSet(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc
     */
    public function canSetByEntity(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc
     */
    public function set(string $key, $value)
    {
        $this->systemConfig[$key] = $value;
    }

    /**
     * {@inheritdoc
     */
    public function getByEntity(EntityIdentifier $entity, string $key, $default = null)
    {
        return $this->entityConfig[$entity->getEntityType()][$entity->getEntityId()][$key]
            ?? $this->systemConfig[$key]
            ?? $this->defaults[$key]
            ?? $default
            ?? null;
    }

    /**
     * {@inheritdoc
     */
    public function setByEntity(EntityIdentifier $entity, string $key, $value)
    {
        $this->entityConfig[$entity->getEntityType()][$entity->getEntityId()][$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $key, $default = null)
    {
        return $this->systemConfig[$key] ?? $this->defaults[$key] ?? $default ?? null;
    }

}
