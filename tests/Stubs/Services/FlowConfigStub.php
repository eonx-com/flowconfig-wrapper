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
    public function get(string $key, ?string $default = null): ?string
    {
        // TODO: Implement get() method.
    }

    public function getByEntity(FlowConfigurableInterface $entity, string $key, ?string $default = null): ?string
    {
        // TODO: Implement getByEntity() method.
    }

    public function set(string $key, string $value): void
    {
        // TODO: Implement set() method.
    }

    public function setByEntity(FlowConfigurableInterface $entity, string $key, string $value): void
    {
        // TODO: Implement setByEntity() method.
    }
}
