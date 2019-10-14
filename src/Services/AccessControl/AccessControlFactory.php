<?php
declare(strict_types=1);

namespace LoyaltyCorp\FlowConfig\Services\AccessControl;

use CodeFoundation\FlowConfig\AccessControl\NullAccessControl;
use CodeFoundation\FlowConfig\Interfaces\AccessControl\AccessControlInterface;
use LoyaltyCorp\FlowConfig\Services\AccessControl\Interfaces\AccessControlFactoryInterface;

final class AccessControlFactory implements AccessControlFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getEntityConfigAccess(): AccessControlInterface
    {
        return new NullAccessControl();
    }

    /**
     * {@inheritdoc}
     */
    public function getSystemConfigAccessControl(): AccessControlInterface
    {
        return new NullAccessControl();
    }
}
