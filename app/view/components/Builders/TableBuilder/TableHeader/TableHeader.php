<?php

namespace app\view\components\Builders\TableBuilder\TableHeader;


class TableHeader
{

    private array $rows = [];

    public static function build(): self
    {
        return new self;
    }

    public function add(string $title, string $html): self
    {
        $this->rows[$title] = $html;
        return $this;
    }

    public function get(): array
    {
        return $this->rows;
    }
}