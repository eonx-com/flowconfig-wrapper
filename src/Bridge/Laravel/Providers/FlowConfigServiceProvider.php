<?php
declare(strict_types=1);

namespace LoyaltyCorp\FlowConfig\Bridge\Laravel\Providers;

use CodeFoundation\FlowConfig\Repository\CascadeConfig;
use CodeFoundation\FlowConfig\Repository\DoctrineConfig;
use CodeFoundation\FlowConfig\Repository\DoctrineEntityConfig;
use CodeFoundation\FlowConfig\Repository\ReadonlyConfig;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\ORM\Extensions\MappingDriverChain;
use LoyaltyCorp\FlowConfig\Database\Exceptions\EntityManagerDriverException;
use LoyaltyCorp\FlowConfig\Services\AccessControl\AccessControlFactory;
use LoyaltyCorp\FlowConfig\Services\AccessControl\Interfaces\AccessControlFactoryInterface;
use LoyaltyCorp\FlowConfig\Services\FlowConfig;
use LoyaltyCorp\FlowConfig\Services\Interfaces\FlowConfigInterface;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects) Service provider have lots of classes.
 */
final class FlowConfigServiceProvider extends ServiceProvider
{
    /**
     * Boot Entity Configuration services for FlowConfig.
     *
     * @return void
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \LoyaltyCorp\FlowConfig\Database\Exceptions\EntityManagerDriverException
     */
    public function boot(): void
    {
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $this->app->make('registry')->getManager();
        $driver = $entityManager->getConfiguration()->getMetadataDriverImpl();

        // This is just a sanity check, entity manager uses driver chain metadata implementation.
        // @codeCoverageIgnoreStart
        if (($driver instanceof MappingDriverChain) !== true) {
            throw new EntityManagerDriverException(
                'exceptions.container.em_invalid_driver',
                [
                    'expected' => MappingDriverChain::class,
                    'received' => $driver !== null ? \get_class($driver) : null,
                ]
            );
        }
        // @codeCoverageIgnoreEnd

        /**
         * @var \LaravelDoctrine\ORM\Extensions\MappingDriverChain $driver
         *
         * @see https://youtrack.jetbrains.com/issue/WI-37859 - typehint required until PhpStorm recognises === check
         */
        $driver->addDriver(new XmlDriver(
            \base_path('vendor/code-foundation/flow-config/src/Entity/DoctrineMaps'),
            '.orm.xml'
        ), 'CodeFoundation\\FlowConfig\\Entity');
    }

    /**
     * @noinspection PhpMissingParentCallCommonInspection Parent implementation is empty
     *
     * {@inheritdoc}
     */
    public function register(): void
    {
        if ($this->app->has(AccessControlFactoryInterface::class) === false) {
            // Override this factory in your app to provide access control rules to flow config.
            $this->app->singleton(AccessControlFactoryInterface::class, AccessControlFactory::class);
        }

        $this->app->singleton(FlowConfigInterface::class, static function (Container $app): FlowConfig {
            $entityManager = $app->make('registry')->getManager();
            $autoFlush = false;

            /**
             * @var \LoyaltyCorp\FlowConfig\Services\AccessControl\Interfaces\AccessControlFactoryInterface $acFactory
             */
            $acFactory = $app->make(AccessControlFactoryInterface::class);

            $configData = [];
            $entityConfig = new DoctrineEntityConfig(
                $entityManager,
                $autoFlush,
                $acFactory->getEntityConfigAccess()
            );
            $systemConfig = new DoctrineConfig(
                $entityManager,
                $autoFlush,
                $acFactory->getSystemConfigAccessControl()
            );
            $readOnlyConfig = new ReadonlyConfig($configData);
            $cascade = new CascadeConfig($readOnlyConfig, $systemConfig, $entityConfig);

            return new FlowConfig(
                $cascade
            );
        });
    }
}
