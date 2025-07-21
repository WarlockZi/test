<?php

namespace app\core;

use app\service\Router\Router;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

class Application
{
    protected string $basePath;
    protected bool $isHttp;

    public function __construct($basePath = null)
    {
        $this->basePath = $basePath ?: dirname(__DIR__, 3);
        $this->isHttp = php_sapi_name() !== 'cli';
    }

    public function isHttp(): bool
    {
        return $this->isHttp;
    }

    public function run(): void
    {
        if ($this->isHttp) {
            $this->runHttp();
        } else {
            $this->runConsole();
        }
    }

    protected function runHttp(): void
    {
        require $this->basePath.'/routes/web.php';

        $router = new Router();
        $router->dispatch($_SERVER['REQUEST_URI']);
    }

    protected function runConsole(): void
    {
        $input = new ArgvInput();
        $output = new ConsoleOutput();

        require $this->basePath.'/routes/console.php';

        $consoleKernel = new \App\Console\Kernel($this);
        $consoleKernel->handle($input, $output);
    }
}