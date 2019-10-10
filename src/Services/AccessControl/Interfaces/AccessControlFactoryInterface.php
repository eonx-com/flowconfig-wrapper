<?php
declare(strict_types=1);

namespace LoyaltyCorp\FlowConfig\Services\AccessControl\Interfaces;

use CodeFoundation\FlowConfig\Interfaces\AccessControl\AccessControlInterface;

interface AccessControlFactoryInterface
{
    /**
     * Creates an access control instance for entity level configuration for flow config.
     *
     * @return \CodeFoundation\FlowConfig\Interfaces\AccessControl\AccessControlInterface
     */
    public function getEntityConfigAccess(): AccessControlInterface;

    /**
     * Creates an access control instance for system level configuration for flow config.
     *
     * @return \CodeFoundation\FlowConfig\Interfaces\AccessControl\AccessControlInterface
     */
    public function getSystemConfigAccessControl(): AccessControlInterface;
}
