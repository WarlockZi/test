<?php

declare(strict_types=1);

namespace Dotenv\Repository\Adapter;

use PhpOption\Option;

interface AdapterInterface extends ReaderInterface, WriterInterface
{
    /**
     * Create a new instance of the adapter, if it is available.
     *
     * @return Option<\Dotenv\Repository\Adapter\AdapterInterface>
     */
    public static function create();
}
