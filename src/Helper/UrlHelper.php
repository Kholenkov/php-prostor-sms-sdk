<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\Helper;

class UrlHelper
{
    public static function getPath(string $url): string
    {
        $path = trim((string) parse_url($url, PHP_URL_PATH), '/');
        return $path ? '/' . $path : '';
    }

    public static function getSchemeAndAuthority(string $url): string
    {
        $schemeAndAuthority = '';

        $components = parse_url($url);

        if (is_array($components)) {
            if (isset($components['scheme'])) {
                $schemeAndAuthority .= $components['scheme'] . '://';
            }

            if (isset($components['user'])) {
                $schemeAndAuthority .= $components['user'];
                if (isset($components['pass'])) {
                    $schemeAndAuthority .= ':' . $components['pass'];
                }
                $schemeAndAuthority .= '@';
            }

            if (isset($components['host'])) {
                $schemeAndAuthority .= $components['host'];
                if (isset($components['port'])) {
                    $schemeAndAuthority .= ':' . $components['port'];
                }
            }
        }

        return $schemeAndAuthority;
    }

    public static function isValid(string $url): bool
    {
        return !(false === filter_var($url, FILTER_VALIDATE_URL));
    }
}
