<?php


namespace app\view\components\Builders\SelectBuilder;


use app\core\FS;
use app\view\components\Traits\CleanString;

class SelectBuilder
{
    use CleanString;

    private FS $fs;
    private string $class = '';
    private string $title = '';
    private string $relation = '';
    private string $field = '';
    private string $options;
    private string $initialOption = '';

    public static function build(string $options):static
    {
        $select          = new static();
        $select->fs      = new FS(__DIR__);
        $select->options = $options;
        return $select;
    }


    public function class(string $class):static
    {
        $this->class = "class='$class'";
        return $this;
    }

    public function title(string $title):static
    {
        $this->title = "title='$title'";
        return $this;
    }
    public function relation(string $relation, string $relationModel):static
    {
        $this->relation = "data-relation='{$relation}' data-relationmodel='{$relationModel}'";
//        $this->relation = "data-relation='$relation'";
        return $this;
    }

    public function field(string $field):static
    {
        $this->field = "data-field='$field'";
        return $this;
    }

    public function initialOption(string $initialOptionLabel = '', int $initialOptionValue = 0):static
    {
        $this->initialOption =
            "<option value='$initialOptionValue'>$initialOptionLabel</option>";
        $this->options       = $this->initialOption . $this->options;
        return $this;
    }

    public function get():string
    {
        $data = get_object_vars($this);
        return $this->clean($this->fs->getContent('templates/SelectBuilderTemplate', $data));
    }
//    public function getOptions(): string
//    {
//        return $this->options;
//    }



}