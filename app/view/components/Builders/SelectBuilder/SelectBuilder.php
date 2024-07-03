<?php


namespace app\view\components\Builders\SelectBuilder;


use app\core\FS;
use app\view\components\Builders\Builder;

class SelectBuilder extends Builder
{
    private string $options;
    private FS $fs;
    private string $class = '';
    private string $title = '';
    private string $field = '';
    private string $name = '';
    private string $id = '';
    private string $relation = '';

    private string $initialOption = '';

    public static function build(string $options)
    {
        $select = new static();
        $select->fs = new FS(__DIR__);
        $select->options = $options;

        return $select;
    }

    public function class(string $class)
    {
        $this->class = $class;
        return $this;
    }

    public function name(string $name)
    {
        $this->name = "name={$name}";
        return $this;
    }

    public function id(string $id)
    {
        $this->id = "id={$id}";
        return $this;
    }

    public function relation(string $relation)
    {
        $this->relation = "data-relation='{$relation}'";
        return $this;
    }

    public function field(string $field)
    {
        $this->field = "data-field='{$field}'";
        return $this;
    }

    public function title(string $title)
    {
        $this->title = "title='{$title}'";
        return $this;
    }

    public function initialOption(string $initialOptionLabel = '', int $initialOptionValue = 0)
    {
        $this->initialOption =
            "<option value='{$initialOptionValue}'>{$initialOptionLabel}</option>";
        $this->options = $this->initialOption . $this->options;
        return $this;
    }

    public function get()
    {
        $data = get_object_vars($this);
        return $this->clean($this->fs->getContent('SelectBuilderTemplate', $data));
    }

}