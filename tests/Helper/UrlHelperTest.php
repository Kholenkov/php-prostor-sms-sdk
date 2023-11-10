<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Helper;

use Faker\Factory;
use Faker\Generator;
use Kholenkov\ProstorSmsSdk\Helper\UrlHelper;
use PHPUnit\Framework\TestCase;

class UrlHelperTest extends TestCase
{
    private Generator $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create();
    }

    /**
     * @dataProvider getPathDataProvider
     */
    public function testGetPath(string $url, string $expected): void
    {
        self::assertSame($expected, UrlHelper::getPath($url));
    }

    /**
     * @dataProvider getSchemeAndAuthorityDataProvider
     */
    public function testGetSchemeAndAuthority(string $url, string $expected): void
    {
        self::assertSame($expected, UrlHelper::getSchemeAndAuthority($url));
    }

    public function testIsValid(): void
    {
        self::assertTrue(UrlHelper::isValid($this->faker->url()));
        self::assertFalse(UrlHelper::isValid($this->faker->md5()));
    }

    public static function getPathDataProvider(): array
    {
        return [
            ['http://example.localhost/', ''],
            ['http://example.localhost/api/v1', '/api/v1'],
        ];
    }

    public static function getSchemeAndAuthorityDataProvider(): array
    {
        return [
            ['http://example.localhost/', 'http://example.localhost'],
            ['http://user:password@example.localhost/', 'http://user:password@example.localhost'],
            ['http://user:password@example.localhost:9000/', 'http://user:password@example.localhost:9000'],
        ];
    }
}
