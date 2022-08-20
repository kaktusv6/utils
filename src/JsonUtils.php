<?php

namespace Utils;

final class JsonUtils implements Utils
{
    public static function decode(string $json): array
    {
        return json_decode($json, true);
    }

    public static function encode($value): string
    {
        return json_encode($value);
    }

    public static function decodeFile(string $path): array
    {
        return self::decode(PathUtils::getContent($path));
    }
}
