<?php
declare(strict_types=1);

namespace LoyaltyCorp\FlowConfig\Database\Exceptions;

use EoneoPay\Utils\Exceptions\RuntimeException;

final class EntityManagerDriverException extends RuntimeException
{
    /**
     * Get Error code.
     *
     * @return int
     */
    public function getErrorCode(): int
    {
        return self::DEFAULT_ERROR_CODE_RUNTIME + 85;
    }

    /**
     * Get Error sub-code.
     *
     * @return int
     */
    public function getErrorSubCode(): int
    {
        return 1;
    }
}
