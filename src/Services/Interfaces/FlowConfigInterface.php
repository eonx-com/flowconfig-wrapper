<?php
declare(strict_types=1);

namespace LoyaltyCorp\FlowConfig\Services\Interfaces;

use LoyaltyCorp\FlowConfig\Database\Interfaces\FlowConfigurableInterface;

interface FlowConfigInterface
{
    /**
     * The value can only be accessed internally.
     *
     * @const int
     */
    public const FLAG_ACCESS_INTERNAL = 0;

    /**
     * The value is hidden and not returned in bulk gets, but can be retrieved if specifically requested.
     *
     * @const int
     */
    public const FLAG_ACCESS_HIDDEN = 1;

    /**
     * The value is read-only and cannot be updated.
     *
     * @const int
     */
    public const FLAG_ACCESS_READONLY = 2;

    /**
     * Get the config value defined by $key.
     *
     * @param string $key
     * @param string|null $default
     *
     * @return mixed|null
     */
    public function get(string $key, ?string $default = null);

    /**
     * Get the config value defined by $key bound to an entity.
     *
     * @param \LoyaltyCorp\FlowConfig\Database\Interfaces\FlowConfigurableInterface $entity
     * @param string $key
     * @param string|null $default
     *
     * @return mixed|null
     */
    public function getByEntity(FlowConfigurableInterface $entity, string $key, ?string $default = null);

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
     * @param \LoyaltyCorp\FlowConfig\Database\Interfaces\FlowConfigurableInterface $entity
     * @param string $key
     * @param string $value
     *
     * @return void
     */
    public function setByEntity(FlowConfigurableInterface $entity, string $key, string $value): void;
}
