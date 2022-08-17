<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Utils\ArrayUtils;
use Utils\StringUtils;

class StringUtilsTest extends TestCase
{
    public function dataProviderValuesForCheckPrefix(): array
    {
        return [
            'First tests' => ['prefix', 'prefixprefix'],
            'Second tests' => ['testPrefix', 'testPrefixValue'],
        ];
    }

    /** @dataProvider dataProviderValuesForCheckPrefix */
    public function testSuccessCheckPrefix(string $prefix, string $value): void
    {
        $this->assertTrue(true, StringUtils::startWith($value, $prefix));
    }

    public function testFailCheckPrefix(): void
    {
        $this->assertEquals(false, StringUtils::startWith('test', 'prefix'));
    }
}