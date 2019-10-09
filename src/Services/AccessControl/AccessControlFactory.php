<?php
declare(strict_types=1);

namespace LoyaltyCorp\FlowConfig\Services\AccessControl;

use CodeFoundation\FlowConfig\AccessControl\NullAccessControl;
use CodeFoundation\FlowConfig\Interfaces\AccessControl\AccessControlInterface;
use LoyaltyCorp\FlowConfig\Services\AccessControl\Interfaces\AccessControlFactoryInterface;

class AccessControlFactory implements AccessControlFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getEntityConfigAccessControl(): AccessControlInterface
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
