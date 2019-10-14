<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\FlowConfig\Unit\Services\AccessControl;

use CodeFoundation\FlowConfig\AccessControl\NullAccessControl;
use LoyaltyCorp\FlowConfig\Services\AccessControl\AccessControlFactory;
use Tests\LoyaltyCorp\FlowConfig\TestCases\BaseTestCase;

/**
 * @covers \LoyaltyCorp\FlowConfig\Services\AccessControl\AccessControlFactory
 */
final class AccessControlFactoryTest extends BaseTestCase
{
    /**
     * Test that by default, the access control factory returns NullAccessControl instances for both
     * system and entity level configurations.
     *
     * @return void
     */
    public function testDefaultFactoryGetters(): void
    {
        $factory = $this->createFactoryInstance();

        $entityAccessControl = $factory->getEntityConfigAccess();
        $systemAccessControl = $factory->getSystemConfigAccessControl();

        self::assertInstanceOf(NullAccessControl::class, $entityAccessControl);
        self::assertInstanceOf(NullAccessControl::class, $systemAccessControl);
    }

    /**
     * Creates an instance of the factory for testing.
     *
     * @return \LoyaltyCorp\FlowConfig\Services\AccessControl\AccessControlFactory
     */
    private function createFactoryInstance(): AccessControlFactory
    {
        return new AccessControlFactory();
    }
}
