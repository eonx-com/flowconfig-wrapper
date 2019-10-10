<?php
declare(strict_types=1);

namespace LoyaltyCorp\FlowConfig\Services\AccessControl\Interfaces;

use CodeFoundation\FlowConfig\Interfaces\AccessControl\AccessControlInterface as BaseAccessControlInterface;

interface AccessControlInterface extends BaseAccessControlInterface
{
    /**
     * The value is hidden and not returned in bulk gets, but can be retrieved if specifically requested.
     *
     * @const int
     */
    public const HIDDEN = 1;

    /**
     * The value can only be accessed internally.
     *
     * @const int
     */
    public const INTERNAL = 0;

    /**
     * The value is read-only and cannot be updated.
     *
     * @const int
     */
    public const READONLY = 2;
}
