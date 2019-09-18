<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\FlowConfig\Unit\Database\Exceptions;

use LoyaltyCorp\FlowConfig\Database\Exceptions\EntityManagerDriverException;
use Tests\LoyaltyCorp\FlowConfig\TestCases\BaseTestCase;

/**
 * @covers \LoyaltyCorp\FlowConfig\Database\Exceptions\EntityManagerDriverException
 */
final class InvalidEntityExceptionTest extends BaseTestCase
{
    /**
     * Test exception returns the correct codes.
     *
     * @return void
     */
    public function testExceptionCodes(): void
    {
        $exception = new EntityManagerDriverException();

        self::assertSame(1185, $exception->getErrorCode());
        self::assertSame(1, $exception->getErrorSubCode());
    }
}
