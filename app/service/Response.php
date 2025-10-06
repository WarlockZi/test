<?php
declare(strict_types=1);

namespace app\service;

use app\blade\View;
use app\service\Nonce\Nonce;
use JetBrains\PhpStorm\NoReturn;

class Response
{
    protected mixed $content;
    protected int $status;
    protected array $headers;
    protected array $cookies = [];
    public static $statusTexts = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Already Reported',
        226 => 'IM Used',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Payload Too Large',
        414 => 'URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        421 => 'Misdirected Request',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Too Early',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        451 => 'Unavailable For Legal Reasons',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
    ];

    public function __construct($content = '', int $status = 200, array $headers = [])
    {
        $this->content = $content;
        $this->status  = $status;
        $this->headers = array_merge([
            'Content-Type' => 'text/html; charset=UTF-8'
        ], $headers);
    }

    #[NoReturn] public function json(array $data = [], int $status = 200, array $headers = []): \Symfony\Component\HttpFoundation\Response
    {
        $this->content = json_encode($data, JSON_UNESCAPED_UNICODE);
        $this->status  = $status;
        $this->headers = array_merge($this->headers, [
            'Content-Type' => 'application/json; charset=UTF-8'
        ], $headers);

        exit(
            $this->content.'<br>'.
            $this->status.'<br>'.
            json_encode($this->headers).'<br>'
        );
        $this->send();
    }
    #[NoReturn] public function consoleLog(array $data = [], int $status = 200, array $headers = []): \Symfony\Component\HttpFoundation\Response
    {
//        $data = ['console'=>$data];
        $this->content = json_encode($data, JSON_UNESCAPED_UNICODE);
        $this->status  = $status;
        $this->headers = array_merge($this->headers, [
            'Content-Type' => 'application/json; charset=UTF-8'
        ], $headers);

        $this->send();
    }
    #[NoReturn] public function back(array $data = [], int $status = 200, array $headers = []): self
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

    #[NoReturn] public function redirect(string $url, int $status = 302): self
    {
        $this->status              = $status;
        $this->headers['Location'] = $url;
        $this->send();
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

    #[NoReturn] public static function exitWithPopup(string $msg): void
    {
        $self          = new self();
        $self->content = json_encode(['popup'=>$msg], JSON_UNESCAPED_UNICODE);
        $self->status  = 200;
        $self->headers = array_merge($self->headers, [
            'Content-Type' => 'application/json; charset=UTF-8'
        ]);

        $self->send();

    }

    private static function setCSPHeaders()
    {
        $nonce = Nonce::getInstance();
        $nonce = $nonce->getNonce();

        $csp = [
            "default-src 'self'",
            "script-src 'self' https://vi-prod:5173 'nonce-$nonce' ",
            "style-src 'self' localhost:5173 'nonce-$nonce' ",

            "style-src-elem https://fonts.googleapis.com 'unsafe-inline'",
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

    #[NoReturn] public static function view(string $file, array $data = [], int $status = 200): string
    {
        http_response_code($status);

//        $nonce = base64_encode(random_bytes(16));
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

    #[NoReturn] public function send(): void
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

