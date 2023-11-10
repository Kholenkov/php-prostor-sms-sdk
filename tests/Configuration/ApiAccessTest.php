<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Configuration;

use Faker\Factory;
use Faker\Generator;
use InvalidArgumentException;
use Kholenkov\ProstorSmsSdk\Configuration\ApiAccess;
use PHPUnit\Framework\TestCase;

class ApiAccessTest extends TestCase
{
    private Generator $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create();
    }

    public function testConstruct(): void
    {
        $object = new ApiAccess(
            $baseUrl = $this->faker->url(),
            $login = $this->faker->md5(),
            $password = $this->faker->md5(),
        );

        self::assertSame($baseUrl, $object->baseUrl);
        self::assertSame($login, $object->login);
        self::assertSame($password, $object->password);


        $array = $object->jsonSerialize();

        self::assertIsArray($array);
        self::assertSame($baseUrl, $array['baseUrl']);
        self::assertSame($login, $array['login']);
        self::assertSame($password, $array['password']);
    }

    public function testConstructWithEmptyBaseUrl(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Empty API base URL');

        new ApiAccess(
            '',
            $this->faker->md5(),
            $this->faker->md5(),
        );
    }

    public function testConstructWithEmptyLogin(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Empty API login');

        new ApiAccess(
            $this->faker->url(),
            '',
            $this->faker->md5(),
        );
    }

    public function testConstructWithEmptyPassword(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Empty API password');

        new ApiAccess(
            $this->faker->url(),
            $this->faker->md5(),
            '',
        );
    }

    public function testConstructWithInvalidBaseUrl(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid API base URL');

        new ApiAccess(
            $this->faker->md5(),
            $this->faker->md5(),
            $this->faker->md5(),
        );
    }
}
