<?php

declare(strict_types=1);

namespace Dotenv\Parser;

use Dotenv\Exception\InvalidFileException;

interface ParserInterface
{
    /**
     * Parse content into an entry array.
     *
     * @param string $content
     *
     * @throws InvalidFileException
     *
     * @return Entry[]
     */
    public function parse(string $content);
}
