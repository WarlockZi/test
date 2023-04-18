<?php

declare(strict_types=1);

namespace Dotenv\Repository\Adapter;

use function function_exists;
use function getenv;
use function is_string;
use PhpOption\None;
use PhpOption\Option;
use PhpOption\Some;
use function putenv;

final class PutenvAdapter implements AdapterInterface
{
    /**
     * Create a new putenv adapter instance.
     *
     * @return void
     */
    private function __construct()
    {
        //
    }

    /**
     * Create a new instance of the adapter, if it is available.
     *
     * @return Option
     */
    public static function create()
    {
        if (self::isSupported()) {
            /** @var Option */
            return Some::create(new self());
        }

        return None::create();
    }

    /**
     * Determines if the adapter is supported.
     *
     * @return bool
     */
    private static function isSupported()
    {
        return function_exists('getenv') && function_exists('putenv');
    }

    /**
     * Read an environment variable, if it exists.
     *
     * @param string $name
     *
     * @return Option
     */
    public function read(string $name)
    {
        /** @var Option */
        return Option::fromValue(getenv($name), false)->filter(static function ($value) {
            return is_string($value);
        });
    }

    /**
     * Write to an environment variable, if possible.
     *
     * @param string $name
     * @param string $value
     *
     * @return bool
     */
    public function write(string $name, string $value)
    {
        putenv("$name=$value");

        return true;
    }

    /**
     * Delete an environment variable, if possible.
     *
     * @param string $name
     *
     * @return bool
     */
    public function delete(string $name)
    {
        putenv($name);

        return true;
    }
}
