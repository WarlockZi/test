<?php

namespace app\view\layouts;

class Layout
{
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
}