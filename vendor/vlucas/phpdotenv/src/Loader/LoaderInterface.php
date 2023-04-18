<?php

declare(strict_types=1);

namespace Dotenv\Loader;

use Dotenv\Parser\Entry;
use Dotenv\Repository\RepositoryInterface;

interface LoaderInterface
{
    /**
     * Load the given entries into the repository.
     *
     * @param RepositoryInterface $repository
     * @param Entry[]                 $entries
     *
     * @return array<string,string|null>
     */
    public function load(RepositoryInterface $repository, array $entries);
}
