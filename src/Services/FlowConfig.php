<?php
declare(strict_types=1);

namespace LoyaltyCorp\FlowConfig\Services;

use CodeFoundation\FlowConfig\Interfaces\Repository\CompositeConfigRepositoryInterface;
use LoyaltyCorp\FlowConfig\Database\Interfaces\FlowConfigurableInterface;
use LoyaltyCorp\FlowConfig\Services\Interfaces\FlowConfigInterface;

final class FlowConfig implements FlowConfigInterface
{
    /**
     * @var \CodeFoundation\FlowConfig\Interfaces\Repository\CompositeConfigRepositoryInterface
     */
    private $config;

    /**
     * FlowConfig constructor.
     *
     * @param \CodeFoundation\FlowConfig\Interfaces\Repository\CompositeConfigRepositoryInterface $config
     */
    public function __construct(CompositeConfigRepositoryInterface $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $key, ?string $default = null): ?string
    {
        $value = $this->config->get($key, $default);

        return $value === null ? null : (string)$value;
    }

    /**
     * {@inheritdoc}
     */
    public function getByEntity(FlowConfigurableInterface $entity, string $key, ?string $default = null): ?string
    {
        return $this->config->getByEntity($entity, $key, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function set(string $key, string $value): void
    {
        $this->config->set($key, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function setByEntity(FlowConfigurableInterface $entity, string $key, string $value): void
    {
        $this->config->setByEntity($entity, $key, $value);
    }
}
