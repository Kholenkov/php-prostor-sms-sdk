<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Exception;

use Faker\Factory;
use Faker\Generator;
use Kholenkov\ProstorSmsSdk\Exception\ApiError;
use PHPUnit\Framework\TestCase;

class ApiErrorTest extends TestCase
{
    private Generator $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create();
    }

    public function testExceptionWithCustomMessage(): void
    {
        $exceptionMessage = $this->faker->realText();

        $this->expectException(ApiError::class);
        $this->expectExceptionMessage($exceptionMessage);

        throw new ApiError($exceptionMessage);
    }

    public function testExceptionWithDefaultMessage(): void
    {
        $this->expectException(ApiError::class);
        $this->expectExceptionMessage('API error');

        throw new ApiError();
    }
}
