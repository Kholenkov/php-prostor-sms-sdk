<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Configuration;

use Faker\Factory;
use Faker\Generator;
use Kholenkov\ProstorSmsSdk\Configuration\ApiAccess;
use Kholenkov\ProstorSmsSdk\Configuration\Configuration;
use Kholenkov\ProstorSmsSdk\Configuration\Logger;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    private Generator $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create();
    }

    public function testConstruct(): void
    {
        $object = new Configuration(
            $apiAccess = new ApiAccess(
                $this->faker->url(),
                $this->faker->md5(),
                $this->faker->md5(),
            ),
            $logger = new Logger(),
        );

        self::assertSame($apiAccess, $object->apiAccess);
        self::assertSame($logger, $object->logger);


        $array = $object->jsonSerialize();

        self::assertIsArray($array);
        self::assertSame($apiAccess, $array['apiAccess']);
        self::assertSame($logger, $array['logger']);
    }
}
