<?php

if (!function_exists('getValue')) {
    function getValue(?iterable $data, string $key, $default = null): mixed
    {
        if (!str_contains($key, '.')) {
            return $data[$key] ?? $default;
        }
        $keyCascade = explode('.', $key);

        return reduce($data, $keyCascade) ?? $default;
    }

    function reduce(?iterable $data, array $keyCascade): mixed
    {
        return array_reduce(
            $keyCascade,
            fn($carry, $keyItem): mixed => getByKey($carry, $keyItem),
            $data
        );
    }
}

if (!function_exists('getByKey')) {
    function getByKey(?iterable $data, int|string $key, $default = null): mixed
    {
        return $data[$key] ?? $default;
    }
}

if (!function_exists('bitMask')) {
    /**
     * @param string $data Hexadecimal string
     * @param int $bit
     * @return int
     */
    function bitMask(string $data, int $bit): int
    {
        $mask = 2 ** $bit;

        return (hexdec($data) & $mask) >> $bit;
    }
}

if (!function_exists('toPascalCase')) {
    function toPascalCase(string $string): string
    {
        return str_replace(
            ' ', '',
            ucwords(str_replace(['_', '-'], ' ', $string))
        );
    }
}

if (!function_exists('hexFormat')) {
    function hexFormat(int $data, int $length = 2): string
    {
        return str_pad(dechex($data), $length, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('dump')) {
    function dump($data): void
    {
        var_dump($data);
    }
}

if (!function_exists('dd')) {
    function dd($data): void
    {
        var_dump($data);

        die('dd');
    }
}
