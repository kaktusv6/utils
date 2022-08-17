<?php declare(strict_types=1);

namespace Utils;

use Utils\Exceptions\ValidateException;

final class ArrayUtils implements Utils
{
    /**
     * Method for get a single random value from an array
     *
     * @param array $array
     * @return mixed
     */
    public static function getRandomValue(array $array)
    {
        // TODO if $array is empty? exception or return null
        return $array[array_rand($array)];
    }

    /**
     * Method for get an array random values from an array
     *
     * @param array $array
     * @param int|null $count
     * @return array
     * @throws ValidateException|\Exception
     */
    public static function getRandomValues(array $array, ?int $count = null): array
    {
        if ($count !== null && $count <= 0)
            throw new ValidateException(self::class, '"count" mus be >= 0');

        if ($count === null)
            $count = random_int(1, count($array));

        $result = [];
        do
        {
            $result[] = self::getRandomValue($array);
        }
        while (count($result) !== $count);
        return $result;
    }

    /**
     * Method for get first element from array
     *
     * @param array $array
     * @return mixed
     */
    public static function first(array $array)
    {
        return $array[array_key_first($array)] ?? null;
    }

    /**
     * Method for get last element from array
     *
     * @param array $array
     * @return mixed
     */
    public static function last(array $array)
    {
        return $array[array_key_last($array)] ?? null;
    }
}
