<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\FlowConfig\Stubs\Services\AccessControl;

use CodeFoundation\FlowConfig\Interfaces\AccessControl\AccessControlInterface;
use LoyaltyCorp\FlowConfig\Services\AccessControl\Interfaces\AccessControlFactoryInterface;

final class AccessControlFactoryStub implements AccessControlFactoryInterface
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
}
