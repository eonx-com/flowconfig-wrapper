<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\FlowConfig\Stubs\Services;

use CodeFoundation\FlowConfig\Interfaces\Repository\ConfigRepositoryInterface;

final class DoctrineConfigStub implements ConfigRepositoryInterface
{
    /**
     * @var mixed[]
     */
    private $configs;

    /**
     * DoctrineConfigStub constructor.
     *
     * @param mixed[]|null $configs
     */
    public function __construct(?array $configs = null)
    {
        $this->configs = $configs ?? [];
    }

    /**
     * {@inheritdoc}
     */
    public function canSet(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $key, $default = null)
    {
        return $this->configs[$key] ?? $default;
    }

    /**
     * {@inheritdoc}
     */
    public function set(string $key, $value): void
    {
        $this->configs = \array_merge($this->configs, [$key => $value]);
    }
}
