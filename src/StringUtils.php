<?php

namespace Utils;

final class StringUtils implements Utils
{
    /**
     * Method for check prefix to string value
     *
     * @param string $value
     * @param string $prefix
     * @return bool
     */
    public static function startWith(string $value, string $prefix): bool
    {
        $result = false;
        if ($value !== '' && $prefix !== '')
            $result = mb_substr($value, 0, mb_strlen($prefix)) === $prefix;
        return $result;
    }
}