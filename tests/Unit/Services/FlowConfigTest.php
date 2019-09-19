<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\FlowConfig\Unit\Services;

use LoyaltyCorp\FlowConfig\Services\FlowConfig;
use PHPUnit\Framework\TestCase;
use Tests\LoyaltyCorp\FlowConfig\Stubs\Database\Entities\FlowConfigEntityStub;
use Tests\LoyaltyCorp\FlowConfig\Stubs\External\FlowConfig\CompositeConfigRepositoryStub;

/**
 * @covers \LoyaltyCorp\FlowConfig\Services\FlowConfig
 */
final class FlowConfigTest extends TestCase
{
    /**
     * Test basic class initialization works.
     *
     * @return void
     */
    public function testClassCanBeInitialized(): void
    {
        new FlowConfig(
            new CompositeConfigRepositoryStub([])
        );

        $this->addToAssertionCount(1);
    }

    /**
     * Test configuration can be set and then get on base doctrine config.
     *
     * @return void
     */
    public function testConfigurationCanBeSetAndGet(): void
    {
        $flowConfig = $this->getService();
        $flowConfig->set('config_key', 'config_value');

        $savedValue = $flowConfig->get('config_key');
        $defaultValue = $flowConfig->get('non_existing_key', 'i have a default');

        self::assertSame('config_value', $savedValue);
        self::assertSame('i have a default', $defaultValue);
    }

    /**
     * Test configuration can be set on entity.
     *
     * @return void
     */
    public function testConfigurationCanBeSetOnEntity(): void
    {
        $flowConfig = $this->getService();
        $entity = new FlowConfigEntityStub('id_100');

        $flowConfig->setByEntity($entity, 'config_100', 'value_100');
        $savedValue = $flowConfig->getByEntity($entity, 'config_100');
        $defaultValue = $flowConfig->getByEntity($entity, 'non_existing_key', 'i have a default');

        self::assertSame('value_100', $savedValue);
        self::assertSame('i have a default', $defaultValue);
    }

    /**
     * Create service instance.
     *
     * @param mixed[]|null $configs
     *
     * @return \LoyaltyCorp\FlowConfig\Services\FlowConfig
     */
    private function getService(?array $configs = null): FlowConfig
    {
        return new FlowConfig(
            new CompositeConfigRepositoryStub($configs)
        );
    }
}
