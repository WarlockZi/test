<?php

namespace app\view\layouts;

use app\service\FS;

class Layout
{
    protected FS $layoutFs;
    protected string $layout;
    protected string $content;

    protected function setErrors(): void
    {
        if ($this->route->isNotFound()) {
            $this->route->setError('Такого адреса нет');
        }
        if (!class_exists($this->route->getController())) {
            $this->route->setError('Контроллер не найден');
        }
        $view = $this->viewFs->getAbsPath() . $this->view . '.php';
        if (!is_readable($view)) {
            $this->route->setError('Файл вида не найден -' . $view);
        }
    }
    public function render(): void
    {
        echo $this->layoutFs->getContent($this->layout, $this->content);
    }

}