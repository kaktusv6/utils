<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Utils\ArrayUtils;
use Utils\Exceptions\ValidateException;

class ArrayUtilsTest extends TestCase
{
    public function dataProviderValues(): array
    {
        return [
            'Get random int' => [[1, 2, 3, 4, 5, 6]],
            'Get random string' => [['foo', 'bar', 'value', 'word', 'test', 'random']],
            'Get random array' => [[['foo'], ['bar'], ['value'], ['word'], ['test'], ['random']]],
            'Get random mixed' => [[1, 'bar', ['value'], ['key' => 'word'], ['other_key' => 123], 123.123]],
        ];
    }

    /** @dataProvider dataProviderValues */
    public function testGetRandomValue(array $values): void
    {
        $value = ArrayUtils::getRandomValue($values);
        $this->assertNotFalse(array_search($value, $values, true));
    }

    /** @dataProvider dataProviderValues */
    public function testGetRandomValuesWithRandomCount(array $values): void
    {
        $randomValues = ArrayUtils::getRandomValues($values);
        foreach ($randomValues as $value)
            $this->assertNotFalse(array_search($value, $values, true));
    }

    /** @dataProvider dataProviderValues */
    public function testValidationGetRandomValues(array $values): void
    {
        $this->expectException(ValidateException::class);
        ArrayUtils::getRandomValues($values, rand(null, 0));
    }

    /** @dataProvider dataProviderValues */
    public function testGetFirstValue(array $values): void
    {
        $firstValue = ArrayUtils::first($values);
        $this->assertEquals(array_shift($values), $firstValue);
    }

    /** @dataProvider dataProviderValues */
    public function testGetLastValue(array $values): void
    {
        $lastValue = ArrayUtils::last($values);
        $this->assertEquals(array_pop($values), $lastValue);
    }
}
