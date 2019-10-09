<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\FlowConfig\Unit\Bridge\Laravel\Providers;

use LoyaltyCorp\FlowConfig\Bridge\Laravel\Providers\FlowConfigServiceProvider;
use LoyaltyCorp\FlowConfig\Services\AccessControl\AccessControlFactory;
use LoyaltyCorp\FlowConfig\Services\AccessControl\Interfaces\AccessControlFactoryInterface;
use LoyaltyCorp\FlowConfig\Services\FlowConfig;
use LoyaltyCorp\FlowConfig\Services\Interfaces\FlowConfigInterface;
use Tests\LoyaltyCorp\FlowConfig\TestCases\Unit\ServiceProviderTestCase;

/**
 * @covers \LoyaltyCorp\FlowConfig\Bridge\Laravel\Providers\FlowConfigServiceProvider
 */
final class FlowConfigServiceProviderTest extends ServiceProviderTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getBindings(): array
    {
        return [
            FlowConfigInterface::class => FlowConfig::class,
            AccessControlFactoryInterface::class => AccessControlFactory::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getServiceProvider(): string
    {
        return FlowConfigServiceProvider::class;
    }
}
