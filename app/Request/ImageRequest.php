<?php

namespace app\Request;

class ImageRequest
{
    private string $name;
    private string $full_path;
    private string $type;
    private string $tmp_name;
    private int $error;
    private int $size;
    public function __construct(array $file)
    {
        $this->name = $file['name'];
        $this->full_path = $file['full_path'];
        $this->type = $file['type'];
        $this->tmp_name = $file['tmp_name'];
        $this->error = $file['error'];
        $this->size = $file['size'];
    }

}