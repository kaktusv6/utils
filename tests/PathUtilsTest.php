<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Utils\Exceptions\ValidateException;
use Utils\OsUtils;
use Utils\PathUtils;

class PathUtilsTest extends TestCase
{
    public function dataProviderDirectories(): array
    {
        return [
            'Test on fixture directory' => [__DIR__ . '/fixtures/directory'],
        ];
    }

    /** @dataProvider dataProviderDirectories */
    public function testCheckDirectory(string $pathToDirectory): void
    {
        $this->assertTrue(PathUtils::isDirectory($pathToDirectory));
    }

    /** @dataProvider dataProviderDirectories */
    public function testGetFilesFromDirectory(string $pathToDirectory): void
    {
        $this->assertNotEmpty(PathUtils::getFiles($pathToDirectory));
    }

    public function dataProviderFiles(): array
    {
        return [
            'Test on fixture file' => [__DIR__ . '/fixtures/directory/file.txt'],
        ];
    }

    /** @dataProvider dataProviderFiles */
    public function testFailCheckDirectory(string $pathToFile): void
    {
        $this->assertFalse(PathUtils::isDirectory($pathToFile));
    }

    /** @dataProvider dataProviderFiles */
    public function testFailGetFilesFromDirectory(string $pathToFile): void
    {
        $this->expectException(ValidateException::class);
        PathUtils::getFiles($pathToFile);
    }

    public function dataProviderPaths(): array
    {
        return [
            'Paths without leading separator' => [
                [
                    'directory',
                    '/users/files',
                    'file.txt',
                ],
                'directory/users/files/file.txt',
                'directory\users\files\file.txt',
            ],
            'Paths with leading separator' => [
                [
                    '/directory',
                    '/users/files',
                    'file.txt',
                ],
                '/directory/users/files/file.txt',
                'directory\users\files\file.txt',
            ],
        ];
    }

    /** @dataProvider dataProviderPaths */
    public function testJoinPaths(array $paths, string $expectedUnix, string $expectedWindows): void
    {
        $actual = PathUtils::join(...$paths);
        $this->assertIsString($actual);
        $this->assertEquals(
            OsUtils::isWindows() ? $expectedWindows : $expectedUnix,
            $actual
        );
    }
}
