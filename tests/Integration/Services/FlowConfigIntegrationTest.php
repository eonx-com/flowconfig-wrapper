<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\FlowConfig\Integration\Services;

use LoyaltyCorp\FlowConfig\Bridge\Laravel\Providers\FlowConfigServiceProvider;
use LoyaltyCorp\FlowConfig\Services\FlowConfig;
use LoyaltyCorp\FlowConfig\Services\Interfaces\FlowConfigInterface;
use Tests\LoyaltyCorp\FlowConfig\Stubs\Database\Entities\FlowConfigEntityStub;
use Tests\LoyaltyCorp\FlowConfig\TestCases\AppTestCase;

/**
 * @coversNothing
 */
final class FlowConfigIntegrationTest extends AppTestCase
{
    /**
     * Test config values are not flushed automatically.
     * This is because the library is setup to not auto flush.
     *
     * @return void
     */
    public function testConfigIsNotFlushedAutomatically(): void
    {
        $flowConfig = $this->getFlowConfig();
        $flowConfig->set('key_1', 'value_1');

        $entity = new FlowConfigEntityStub('user_id');
        $flowConfig->setByEntity($entity, 'key_2', 'value_2');

        self::assertNull($flowConfig->get('key_1'));
        self::assertNull($flowConfig->getByEntity($entity, 'key_2'));
    }

    /**
     * Test integration with real flow config library.
     *
     * @return void
     */
    public function testIntegrationWithRealFlowConfig(): void
    {
        $flowConfig = $this->getFlowConfig();
        $flowConfig->set('key_1', 'value_1');

        $entity = new FlowConfigEntityStub('user_id');
        $flowConfig->setByEntity($entity, 'key_2', 'value_2');

        // flush the changes.
        $this->getEntityManager()->flush();

        $rootValue = $flowConfig->get('key_1');
        $passThroughValue = $flowConfig->getByEntity($entity, 'key_1');
        $entityValue = $flowConfig->getByEntity($entity, 'key_2');

        self::assertSame('value_1', $rootValue);
        self::assertSame('value_1', $passThroughValue);
        self::assertSame('value_2', $entityValue);
    }

    /**
     * Get flow config instance from container.
     *
     * @return \LoyaltyCorp\FlowConfig\Services\FlowConfig
     */
    protected function getFlowConfig(): FlowConfig
    {
        // create the doctrine schema
        $this->createSchema();

        // register flow config
        $this->app->register(FlowConfigServiceProvider::class);

        return $this->app->make(FlowConfigInterface::class);
    }
}
