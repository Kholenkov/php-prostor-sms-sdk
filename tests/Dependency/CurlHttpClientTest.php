<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Dependency;

use Faker\Factory;
use Faker\Generator;
use Kholenkov\ProstorSmsSdk\Configuration\ApiAccess;
use Kholenkov\ProstorSmsSdk\Configuration\Configuration;
use Kholenkov\ProstorSmsSdk\Configuration\Logger;
use Kholenkov\ProstorSmsSdk\Dependency\CurlHttpClient;
use Kholenkov\ProstorSmsSdk\Dependency\CurlWrapper;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class CurlHttpClientTest extends TestCase
{
    private Configuration $configuration;
    private Generator $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create();

        $this->configuration = new Configuration(
            new ApiAccess(
                $this->faker->url(),
                $this->faker->md5(),
                $this->faker->md5(),
            ),
            new Logger(),
        );
    }

    public function testSuccess(): void
    {
        $responseHttpStatusCode = 200;
        $responseBody = json_encode([$this->faker->md5()]);

        $curlWrapper = $this->createMock(CurlWrapper::class);
        $curlWrapper->expects(self::once())->method('init')
            ->willReturn(true);
        $curlWrapper->expects(self::exactly(5))->method('setOpt')
            ->willReturn(true);
        $curlWrapper->expects(self::once())->method('exec')
            ->willReturn($responseBody);
        $curlWrapper->expects(self::exactly(2))->method('getInfo')
            ->willReturn(
                $responseHttpStatusCode,
                CURL_HTTP_VERSION_2_0,
            );
        $curlWrapper->expects(self::once())->method('close');

        $curlHttpClient = new CurlHttpClient($curlWrapper);

        $response = $curlHttpClient->post($this->configuration->apiAccess, '/test');

        self::assertInstanceOf(ResponseInterface::class, $response);
    }
}
