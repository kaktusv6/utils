<?php declare(strict_types=1);

namespace Utils;

final class OsUtils implements Utils
{
    public static function isWindows() : bool
    {
        return StringUtils::startWith(strtolower(PHP_OS), 'win');
    }
}
