<?php

namespace Utils;

use Utils\Exceptions\FailGetContent;
use Utils\Exceptions\ValidateException;

final class PathUtils implements Utils
{
    public static function isDirectory(string $path) : bool
    {
        return is_dir($path);
    }

    public static function getFiles(string $pathDirectory) : array
    {
        if (!self::isDirectory($pathDirectory))
            throw new ValidateException(self::class, "$pathDirectory is not directory");
        $files = scandir($pathDirectory);
        foreach ($files as $key => $file)
            if ($file === '.' || $file === '..')
                unset($files[$key]);
        return $files;
    }

    public static function join(...$paths) : string
    {
        $result = [];
        foreach ($paths as $path)
        {
            foreach (self::splitPath($path) as $pathPart)
            {
                $strippedPath = self::trimSeparators(self::normalizePath($pathPart));
                if ($strippedPath)
                    $result[] = $strippedPath;
            }
        }

        return self::getLeadingSeparator($paths[0]) . join(DIRECTORY_SEPARATOR, $result);
    }

    /**
     * @throws FailGetContent
     */
    public static function getContent(string $path)
    {
        $result = file_get_contents($path);
        if (is_bool($result))
            throw new FailGetContent();
        return $result;
    }

    public static function isUncPath(string $path) : bool
    {
        return StringUtils::startWith($path, '\\\\');
    }

    public static function splitPath(string $path) : array
    {
        return explode(DIRECTORY_SEPARATOR, self::normalizePath($path));
    }

    public static function normalizePath(string $path) : string
    {
        return self::getLeadingSeparator($path)
            . self::trimSeparators(
                preg_replace('~[\\\/]~', DIRECTORY_SEPARATOR, $path
            ));
    }

    public static function getLeadingSeparator(string $path) : string
    {
        $result = (($path[0] ?? '') === DIRECTORY_SEPARATOR) ? DIRECTORY_SEPARATOR : '';

        if (OsUtils::isWindows())
            $result = self::isUncPath($path) ? '\\\\' : '';

        return $result;
    }

    public static function trimSeparators(string $path) : string
    {
        return trim($path, '\\/');
    }
}
