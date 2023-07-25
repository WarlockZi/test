<?php

declare(strict_types=1);

namespace Dotenv\Repository\Adapter;

use PhpOption\None;
use PhpOption\Option;

final class MultiReader implements ReaderInterface
{
    /**
     * The set of readers to use.
     *
     * @var ReaderInterface[]
     */
    private $readers;

    /**
     * Create a new multi-reader instance.
     *
     * @param ReaderInterface[] $readers
     *
     * @return void
     */
    public function __construct(array $readers)
    {
        $this->readers = $readers;
    }

    /**
     * Read an environment variable, if it exists.
     *
     * @param non-empty-string $name
     *
     * @return Option<string>
     */
    public function read(string $name)
    {
        foreach ($this->readers as $reader) {
            $result = $reader->read($name);
            if ($result->isDefined()) {
                return $result;
            }
        }

        return None::create();
    }
}
