<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\Dependency;

use CurlHandle;
use Kholenkov\ProstorSmsSdk\Exception\HttpClientError;

class CurlWrapper
{
    private ?CurlHandle $handle;

    public function close(): void
    {
        if (null === $this->handle) {
            throw new HttpClientError('Empty cURL handle');
        }

        curl_close($this->handle);

        $this->handle = null;
    }

    public function exec(): string
    {
        if (null === $this->handle) {
            throw new HttpClientError('Empty cURL handle');
        }

        $result = curl_exec($this->handle);
        if (is_bool($result)) {
            throw new HttpClientError('Cannot perform cURL session');
        }

        return $result;
    }

    public function getInfo(?int $option = null): mixed
    {
        if (null === $this->handle) {
            throw new HttpClientError('Empty cURL handle');
        }

        $result = curl_getinfo($this->handle, $option);
        if (false === $result) {
            match ($option) {
                CURLINFO_HTTP_VERSION => throw new HttpClientError('Cannot get HTTP version'),
                CURLINFO_RESPONSE_CODE => throw new HttpClientError('Cannot get HTTP status code'),
                default => throw new HttpClientError('Cannot get specific HTTP information'),
            };
        }

        return $result;
    }

    public function init(string $url): true
    {
        $result = curl_init($url);
        if (false === $result) {
            throw new HttpClientError('Cannot initialize cURL session');
        }

        $this->handle = $result;

        return true;
    }

    public function setOpt(int $option, mixed $value): true
    {
        if (null === $this->handle) {
            throw new HttpClientError('Empty cURL handle');
        }

        $result = curl_setopt($this->handle, $option, $value);
        if (false === $result) {
            throw new HttpClientError('Cannot set option for cURL transfer');
        }

        return true;
    }
}
