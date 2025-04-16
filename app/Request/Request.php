<?php

namespace app\Request;

class Request
{
        private string $uri;
        private string $method;
        private array $cookie;
        private array $body;
        private string $protocol;
        private string $path;
        private array $params=[];


    public static function capture(): self
    {
        $self = new self();

        $self->uri = $_SERVER['REQUEST_URI']??'';
        $self->method = $_SERVER['REQUEST_METHOD']??'GET';
        $self->protocol = $_SERVER['SERVER_PROTOCOL']??'';
        $self->body = $_POST??'';
        $self->cookie = $_COOKIE??[];
        $self->parseUrl();

        return $self;
    }

    private function parseUrl(): void
    {
        $this->path = parse_url($this->uri)['path'];
        $query = parse_url($this->uri)['query']??'';
        parse_str($query,$this->params);
    }

}