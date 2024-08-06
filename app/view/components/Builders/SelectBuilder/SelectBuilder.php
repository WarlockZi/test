<?php


namespace app\view\components\Builders\SelectBuilder;


use app\core\FS;
use app\view\components\Traits\CleanString;

class SelectBuilder
{
    use CleanString;

    private string $options;
    private FS $fs;
    private string $class = '';
    private string $title = '';
    private string $field = '';
    private string $name = '';
    private string $id = '';
    private string $relation = '';

    private string $initialOption = '';

    public static function build(string $options):SelectBuilder
    {
        $select          = new static();
        $select->fs      = new FS(__DIR__);
        $select->options = $options;

        return $select;
    }


    public function class(string $class):SelectBuilder
    {
        $this->class = $class;
        return $this;
    }

    public function name(string $name):SelectBuilder
    {
        $this->name = "name=$name";
        return $this;
    }

    public function id(string $id):SelectBuilder
    {
        $this->id = "id=$id";
        return $this;
    }

    public function relation(string $relation):SelectBuilder
    {
        $this->relation = "data-relation='$relation'";
        return $this;
    }

    public function field(string $field):SelectBuilder
    {
        $this->field = "data-field='$field'";
        return $this;
    }

    public function title(string $title):SelectBuilder
    {
        $this->title = "title='$title'";
        return $this;
    }

    public function initialOption(string $initialOptionLabel = '', int $initialOptionValue = 0):SelectBuilder
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

    public function getOptions(): string
    {
        return $this->options;
    }

}