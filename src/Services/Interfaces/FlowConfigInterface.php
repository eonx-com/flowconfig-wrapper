<?php
declare(strict_types=1);

namespace LoyaltyCorp\FlowConfig\Services\Interfaces;

use LoyaltyCorp\FlowConfig\Entities\FlowConfigurableInterface;

interface FlowConfigInterface
{
    /**
     * Get the config value defined by $key.
     *
     * @param string $key
     * @param string|null $default
     *
     * @return string|null
     */
    public function get(string $key, ?string $default = null): ?string;

    /**
     * Get the config value defined by $key bound to an entity.
     *
     * @param \LoyaltyCorp\FlowConfig\Entities\FlowConfigurableInterface $entity
     * @param string $key
     * @param string|null $default
     *
     * @return string|null
     */
    public function getByEntity(FlowConfigurableInterface $entity, string $key, ?string $default = null): ?string;

    /**
     * Sets a config value in this repository.
     *
     * @param string $key
     * @param string $value
     *
     * @return void
     */
    public function set(string $key, string $value): void;

    /**
     * Sets a config value bound to an entity.
     *
     * @param \LoyaltyCorp\FlowConfig\Entities\FlowConfigurableInterface $entity
     * @param string $key
     * @param string $value
     *
     * @return void
     */
    public function setByEntity(FlowConfigurableInterface $entity, string $key, string $value): void;
}
