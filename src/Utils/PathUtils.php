<?php

namespace Utils;

use Utils\Exceptions\FailGetContent;
use Utils\Exceptions\ValidateException;

final class PathUtils implements BaseUtils
{
    /**
     * Method get files from directory without '.', '..'
     *
     * @param string $pathDirectory
     * @return array
     */
    public static function getFiles(string $pathDirectory) : array
    {
        if (!is_dir($pathDirectory))
            throw new ValidateException(self::class, "$pathDirectory is not directory");
        $files = scandir($pathDirectory);
        foreach ($files as $key => $file)
            if ($file === '.' || $file === '..')
                unset($files[$key]);
        return $files;
    }

    /**
     * Method join paths with separator current OS
     *
     * @param ...$paths
     * @return string
     */
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
     * Method get content from file by path
     *
     * @throws FailGetContent
     */
    public static function getContent(string $path)
    {
        $result = file_get_contents($path);
        if (is_bool($result))
            throw new FailGetContent();
        return $result;
    }

    /**
     * Method checks that the path belongs to a Unix system
     *
     * @param string $path
     * @return bool
     */
    public static function isUncPath(string $path) : bool
    {
        return StringUtils::startWith($path, '\\\\');
    }

    /**
     * Method explode path by separator
     *
     * @param string $path
     * @return array
     */
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

    /**
     * Method get lead separator by OS
     *
     * @param string $path
     * @return string
     */
    public static function getLeadingSeparator(string $path) : string
    {
        $result = (($path[0] ?? '') === DIRECTORY_SEPARATOR) ? DIRECTORY_SEPARATOR : '';

        if (OsUtils::isWindows())
            $result = self::isUncPath($path) ? '\\\\' : '';

        return $result;
    }

    /**
     * Method trim path
     *
     * @param string $path
     * @return string
     */
    public static function trimSeparators(string $path) : string
    {
        return trim($path, '\\/');
    }
}
