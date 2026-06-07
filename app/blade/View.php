<?php

namespace app\blade;


use app\service\Router\IRequest;
use Exception;

class View implements IView
{
    public function __construct(
        private readonly Blade    $blade,
        private readonly IRequest $request,
    )
    {
        $this->blade
            ->share('request', $request);
        $this->blade->directive('deb', function () {
            return DEV ? "<?php  (xdebug_break()); ?>" : "";
        });
    }

    /**
     * @throws Exception
     */
    public function render(string $template, array $data = [], int|null $status = 200)
    {
        try {
            return $this->blade->run($template, $data);
        } catch (\Throwable $exception) {
            return $this->handleError($exception);
        }
    }

    protected function handleError($e)
    {
        // Логирование
        $this->logError($e);

        // В зависимости от режима
        if ($this->blade->getMode() === $this->blade::MODE_DEBUG) {
            return $this->debugError($e);
        } else {
            return $this->productionError($e);
        }
    }

    protected function logError($e): void
    {
        $logMessage = date('Y-m-d H:i:s') . " - Blade Error: " .
            $e->getMessage() . " in " .
            $e->getFile() . ":" . $e->getLine() . PHP_EOL;
        error_log( $logMessage, FILE_APPEND);
    }

    protected function debugError($e): string
    {
        return "<div style='padding: 20px; background: #fee; border: 1px solid red;'>
                <h3>Blade Template Error</h3>
                <p><strong>Message:</strong> {$e->getMessage()}</p>
                <p><strong>File:</strong> {$e->getFile()}:{$e->getLine()}</p>
                </div>";
    }

    protected function productionError($e)
    {
        // Попытка показать страницу ошибки
        try {
            return $this->run("errors.template", ['error' => 'Template error occurred']);
        } catch (Exception $e2) {
            return "A template error occurred. Please try again later.";
        }
    }
}