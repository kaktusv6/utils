<?php

namespace Utils;

final class JsonUtils implements Utils
{
    /**
     * Method decode json to array
     *
     * @throws \JsonException
     */
    public static function decode(string $json): array
    {
        return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Method encode array to json
     *
     * @param $value
     * @return string
     */
    public static function encode($value): string
    {
        return json_encode($value);
    }

    /**
     * Method get decode json from file by path
     *
     * @throws Exceptions\FailGetContent
     */
    public static function decodeFile(string $path): array
    {
        return self::decode(PathUtils::getContent($path));
    }
}
