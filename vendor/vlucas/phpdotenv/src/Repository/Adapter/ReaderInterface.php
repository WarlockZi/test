<?php

declare(strict_types=1);

namespace Dotenv\Repository\Adapter;

use PhpOption\Option;

interface ReaderInterface
{
    /**
     * Read an environment variable, if it exists.
     *
     * @param string $name
     *
     * @return Option<string>
     */
    public function read(string $name);
}
