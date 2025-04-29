<?php

namespace app\view\components\Builders\TableBuilder\TableHeader;

use app\service\FS;

class TableHeader
{

    private array $rows = [];
    private FS $fs;

    public static function build(): self
    {
        $tableHeader     = new self;
        $tableHeader->fs = new FS();
        return $tableHeader;
    }

    public function add(string $title, string $html): self
    {
        $this->rows[$title] = $html;
        return $this;
    }

    public function get(): string
    {
        $string = '';
        foreach ($this->rows as $title => $html) {
            $string .= $this->fs->getContent("row", compact('title', 'html'));
        }
        return $string;
    }
}