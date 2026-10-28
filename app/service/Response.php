<?php
declare(strict_types=1);

namespace app\service;

use app\blade\View;
use app\enum\HttpStatusCode;
use app\service\Logger\ILogger;
use app\service\Nonce\Nonce;
use JetBrains\PhpStorm\NoReturn;

class Response
{
    protected mixed $content;
    protected int $status;
    protected array $headers;
    protected string $error;
    protected ?ILogger $logger = null;
    protected array $cookies = [];

    public static $statusTexts = HttpStatusCode::class;

    public function __construct($content = '', int $status = 200, array $headers = [])
    {
        $this->content = $content;
        $this->status  = $status;
        $this->headers = array_merge([
            'Content-Type' => 'text/html; charset=UTF-8'
        ], $headers);
    }

    #[NoReturn]
    public function json(array $data = [], int $status = 200, array $headers = []): \Symfony\Component\HttpFoundation\Response
    {
        $data['csrf'] = $_SESSION['csrf_token'] ?? null;

        $this->content = json_encode($data, JSON_UNESCAPED_UNICODE);
        $this->status  = $status;
        $this->headers = array_merge($this->headers, [
            'Content-Type' => 'application/json; charset=UTF-8'
        ], $headers);

        $this->send();
    }

    #[NoReturn]
    public function popup(string $message = '', int $status = 200, array $headers = []): \Symfony\Component\HttpFoundation\Response
    {
        if ($this->logger && $this->logger instanceof ILogger) {
            $this->logger->write($message);
        }
        $this->content = json_encode(['popup' => $message, 'csrf' => $_SESSION['csrf_token'] ?? null], JSON_UNESCAPED_UNICODE);

        $this->status  = $status;
        $this->headers = array_merge($this->headers, [
            'Content-Type' => 'application/json; charset=UTF-8'
        ], $headers);

        $this->send();
    }

    #[NoReturn]
    public function consoleLog(string $data = '', int $status = 200, array $headers = []): \Symfony\Component\HttpFoundation\Response
    {
        $this->json(['console' => $data], $status, $headers);
    }

    #[NoReturn]
    public function consoleTable(array $data = [], int $status = 200, array $headers = []): \Symfony\Component\HttpFoundation\Response
    {
        $this->json(['table' => $data], $status, $headers);
    }

    #[NoReturn]
    public function back(array $data = [], int $status = 200, array $headers = []): self
    {
        $HTTP_REFERER  = $_SERVER['HTTP_REFERER'] ?? '';
        $this->status  = $status;
        $this->headers = array_merge([
            'Location' => $HTTP_REFERER
        ], $headers);
        $this->send();
    }

    public function file(string $path, string $name = null, array $headers = []): self
    {
        if (!file_exists($path)) {
            throw new \RuntimeException("File not found: {$path}");
        }

        $this->content = file_get_contents($path);
        $this->headers = array_merge($this->headers, [
            'Content-Type' => mime_content_type($path),
            'Content-Length' => filesize($path),
            'Content-Disposition' => 'attachment; filename="' . ($name ?? basename($path)) . '"'
        ], $headers);

        return $this;
    }

    #[NoReturn]
    public function redirect(string $url, int $status = 302): self
    {
        $this->status              = $status;
        $this->headers['Location'] = $url;
        $this->send();
    }

    #[NoReturn]
    public function withError(string $error): self
    {
        $this->error       = $error;
        $_SESSION['error'] = $error;
        return $this;
    }

    public function withLog(ILogger $logger): self
    {
        $this->logger = $logger;
        return $this;
    }

    public function cookie(string $name, string $value, int $minutes = 0, string $path = '/', string $domain = null, bool $secure = false, bool $httpOnly = true): self
    {
        $this->cookies[] = compact('name', 'value', 'minutes', 'path', 'domain', 'secure', 'httpOnly');
        return $this;
    }

    public function header(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function status(int $code): self
    {
        $this->status = $code;
        return $this;
    }

    private static function setCSPHeaders()
    {
        $nonce = Nonce::getInstance();
        $nonce = $nonce->getNonce();

        $csp = [
            "default-src 'self' https://autofill.yandex.ru",
            "script-src 'self' https://vi-prod:5173 'nonce-$nonce'",
            "style-src 'self' https://vi-prod:5173 'nonce-$nonce'",

            "style-src-elem https://fonts.googleapis.com https://vitexopt.ru 'unsafe-inline'",
            "font-src fonts.gstatic.com",
            "connect-src 'self' wss://localhost:5173 https://vitexopt.ru",
            "script-src-attr 'unsafe-inline'",

            "img-src 'self' data:",
            "frame-ancestors 'none'",
            "form-action 'self'",
            "base-uri 'self'",
            "object-src 'none'"
        ];

        header("Content-Security-Policy: " . implode('; ', $csp));

        return $nonce;
    }

    #[NoReturn]
    public static function view(string $file, array $data = [], int $status = 200): string
    {
        http_response_code($status);

        $nonce = self::setCSPHeaders();
//        header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' localhost:5173; style-src 'self' 'nonce-'$nonce; img-src 'self' data:");
        header("X-Content-Type-Options: nosniff");
        header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
        header("X-XSS-Protection: 1; mode=block");
        header("Referrer-Policy: strict-origin-when-cross-origin");

        header("Cross-Origin-Embedder-Policy: require-corp");
        header("Cross-Origin-Opener-Policy: same-origin");
        header("Cross-Origin-Resource-Policy: same-origin");
        $view = APP->get(View::class);
        exit($view->render($file, $data));
    }

    #[NoReturn]
    public function send(): void
    {
        http_response_code($this->status);

        foreach ($this->headers as $name => $value) {
            header("{$name}: {$value}");
        }

        foreach ($this->cookies as $cookie) {
            setcookie(
                $cookie['name'],
                $cookie['value'],
                $cookie['minutes'] ? time() + ($cookie['minutes'] * 60) : 0,
                $cookie['path'],
                $cookie['domain'],
                $cookie['secure'],
                $cookie['httpOnly']
            );
        }

        echo $this->content;
        exit;
    }
}

