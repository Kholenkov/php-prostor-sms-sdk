<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Exception;

use Faker\Factory;
use Faker\Generator;
use Kholenkov\ProstorSmsSdk\Exception\HttpClientError;
use PHPUnit\Framework\TestCase;

class HttpClientErrorTest extends TestCase
{
    private Generator $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create();
    }

    public function testExceptionWithCustomMessage(): void
    {
        $exceptionMessage = $this->faker->realText();

        $this->expectException(HttpClientError::class);
        $this->expectExceptionMessage($exceptionMessage);

        throw new HttpClientError($exceptionMessage);
    }

    public function testExceptionWithDefaultMessage(): void
    {
        $this->expectException(HttpClientError::class);
        $this->expectExceptionMessage('HTTP client error');

        throw new HttpClientError();
    }
}
