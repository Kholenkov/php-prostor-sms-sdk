<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\Dependency;

use CurlHandle;
use GuzzleHttp\Psr7\Response;
use Kholenkov\ProstorSmsSdk\Configuration\ApiAccess;
use Kholenkov\ProstorSmsSdk\Interfaces\HttpClient;
use Psr\Http\Message\ResponseInterface;

class CurlHttpClient implements HttpClient
{
    public function __construct(private CurlWrapper $curlWrapper)
    {
    }

    public function post(ApiAccess $apiAccess, string $path, array $data = []): ResponseInterface
    {
        $url = rtrim($apiAccess->baseUrl, '/') . $path;
        $data = array_merge(
            $data,
            [
                'login' => $apiAccess->login,
                'password' => $apiAccess->password,
            ],
        );


        $this->curlWrapper->init($url);


        $this->curlWrapper->setOpt(CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $this->curlWrapper->setOpt(CURLOPT_POST, 1);
        $this->curlWrapper->setOpt(CURLOPT_POSTFIELDS, json_encode($data));
        $this->curlWrapper->setOpt(CURLOPT_RETURNTRANSFER, 1);

        $responseHeaders = [];
        $this->curlWrapper->setOpt(
            CURLOPT_HEADERFUNCTION,
            function (CurlHandle $curlHandle, string $header) use (&$responseHeaders): int {
                // @codeCoverageIgnoreStart
                $headerLength = strlen($header);

                $header = explode(':', $header, 2);
                if (count($header) < 2) {
                    return $headerLength;
                }

                $headerName = strtolower(trim($header[0]));
                if (!isset($responseHeaders[$headerName])) {
                    $responseHeaders[$headerName] = [];
                }
                $responseHeaders[$headerName][] = trim($header[1]);

                return $headerLength;
                // @codeCoverageIgnoreEnd
            }
        );


        $responseBody = $this->curlWrapper->exec();

        /** @var int $responseHttpStatusCode */
        $responseHttpStatusCode = $this->curlWrapper->getInfo(CURLINFO_RESPONSE_CODE);

        /** @var int $responseHttpVersion */
        $responseHttpVersion = $this->curlWrapper->getInfo(CURLINFO_HTTP_VERSION);


        $this->curlWrapper->close();


        return new Response(
            $responseHttpStatusCode,
            $responseHeaders,
            $responseBody,
            match ($responseHttpVersion) {
                CURL_HTTP_VERSION_1_0 => '1.0',
                CURL_HTTP_VERSION_1_1 => '1.1',
                CURL_HTTP_VERSION_2_0 => '2.0',
                default => '',
            }
        );
    }
}
