<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\FlowConfig\Integration\Services\AccessControl;

use CodeFoundation\FlowConfig\AccessControl\NullAccessControl;
use CodeFoundation\FlowConfig\Exceptions\ValueSetException;
use CodeFoundation\FlowConfig\Interfaces\AccessControl\AccessControlInterface;
use LoyaltyCorp\FlowConfig\Bridge\Laravel\Providers\FlowConfigServiceProvider;
use LoyaltyCorp\FlowConfig\Services\AccessControl\Interfaces\AccessControlFactoryInterface;
use LoyaltyCorp\FlowConfig\Services\FlowConfig;
use LoyaltyCorp\FlowConfig\Services\Interfaces\FlowConfigInterface;
use Tests\LoyaltyCorp\FlowConfig\Stubs\Services\AccessControl\AccessControlStub;
use Tests\LoyaltyCorp\FlowConfig\TestCases\AppTestCase;

class AccessControlFactoryIntegrationTest extends AppTestCase
{
    /**
     * Tests custom factory implementation, ensuring that the 'canGetKey' and 'canSetKey' methods return the boolean
     * values specified through the stubs in the factory.
     *
     * @return void
     */
    public function testFactoryImplementation(): void
    {
        $factory = $this->getFactoryInstance();
        $entityAccessControl = $factory->getEntityConfigAccess();
        $systemAccessControl = $factory->getSystemConfigAccessControl();

        self::assertTrue($entityAccessControl->canGetKey('test-key'));
        self::assertTrue($entityAccessControl->canSetKey('test-key'));

        self::assertTrue($systemAccessControl->canGetKey('test-key'));
        self::assertFalse($systemAccessControl->canSetKey('test-key'));
    }

    /**
     * Tests that the flow config class from the application container uses the custom factory implementation also
     * from the container.
     *
     * @return void
     */
    public function testFlowConfigUsesCustomFactoryImplementation(): void
    {
        $factory = $this->getFactoryInstance();
        $flowConfig = $this->getFlowConfig();
        $entityAccessControl = $factory->getEntityConfigAccess();
        $systemAccessControl = $factory->getSystemConfigAccessControl();

        // The return instance should not be of type NullAccessControl
        self::assertNotInstanceOf(NullAccessControl::class, $factory);

        // Ensure that the we can get/set on the entity level
        self::assertTrue($entityAccessControl->canGetKey('test-key'));
        self::assertTrue($entityAccessControl->canSetKey('test-key'));

        // Ensure that we can only get, but not set, on the system level
        self::assertTrue($systemAccessControl->canGetKey('test-key'));
        self::assertFalse($systemAccessControl->canSetKey('test-key'));

        // With the custom factory, we should not be able to set a key on the system config
        $this->setExpectedException(ValueSetException::class, 'The value for key \'test-key\' could not be set.');
        $flowConfig->set('test-key', 'true');
    }

    /**
     * Gets an instance of the acccess control factory, whereby the entity config can be both retrieved, and set, and
     * where the system config can be retrieved, but not set.
     *
     * @return \LoyaltyCorp\FlowConfig\Services\AccessControl\AccessControlFactory
     */
    private function getFactoryInstance(): AccessControlFactoryInterface
    {
        $this->createSchema();

        $this->app->instance(AccessControlFactoryInterface::class, new class implements AccessControlFactoryInterface
        {
            /**
             * {@inheritdoc}
             */
            public function getEntityConfigAccess(): AccessControlInterface
            {
                return new AccessControlStub(true, true);
            }

            /**
             * {@inheritdoc}
             */
            public function getSystemConfigAccessControl(): AccessControlInterface
            {
                return new AccessControlStub(true, false);
            }
        });

        return $this->app->make(AccessControlFactoryInterface::class);
    }

    /**
     * Gets an instance of the flow config class from the container.
     *
     * @return \LoyaltyCorp\FlowConfig\Services\FlowConfig
     */
    private function getFlowConfig(): FlowConfig
    {
        $this->createSchema();

        $this->app->register(FlowConfigServiceProvider::class);

        return $this->app->make(FlowConfigInterface::class);
    }
}
